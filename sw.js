const version = 31;
let Image_Cache = `Image_Cache-v${version}`;
let Font_Cache = `Font_Cache-v${version}`;
let Css_Cache = `Css_Cache-v${version}`;
let Dynamic_Cache = `Dynamic_Cache`;
const sitepath = `github/ir`;
// console.log(self);
self.oninstall = (ev) => {
  //service worker is installed.
  self.skipWaiting();
  console.log(`Version ${version} installed`);
};
self.onactivate = (ev) => {
  // when the service worker has been activated to replace an old one.
  //Extendable Event
  console.log("activated");
  console.log(self);
  // delete old versions of caches.
  ev.waitUntil(
    caches.keys().then((keys) => {
      return Promise.all(
        keys
        .filter((key) => {
          if (key != Image_Cache && key != Font_Cache && key != Css_Cache) {
            return true;
          }
        })
        .map((key) => caches.delete(key))
      ).then((empties) => {
        //empties is an Array of boolean values.
        //one for each cache deleted
      });
    })
  );
};

self.onfetch = (ev) => {
  //service worker intercepted a fetch call
  //console.log(ev.request);
  mycache = caches.match(ev.request).then((cacheRes) => {
    if (cacheRes) {
      // console.log(`getting from cache ${ev.request.url}`);
      return cacheRes;
    } else {
      // console.log(`from internet : ${ev.request.url}`);
      return SW_FETCH(ev);
    }
  });
  ev.respondWith(mycache);
};

self.onmessage = (ev) => {
  //message from webpage
};

// custom functions
SW_FETCH = async (ev) => {
  const fetchResponse = await fetch(ev.request);

  type = fetchResponse.headers.get("content-type");
  if (fetchResponse.status > 399) {
    return fetchResponse;
  }
  // cache start
  if (
    (type && type.match(/^text\/css/i)) ||
    ev.request.url.match(/fonts.googleapis.com/i)
  ) {
    //css
    return await Make_SW_Cache(Css_Cache, ev, fetchResponse);
  } else if (type && type.match(/^image\//i)) {
    //images
    return await Make_SW_Cache(Image_Cache, ev, fetchResponse);
  } else if (type && type.match(/^font\//i)) {
    //font
    return await Make_SW_Cache(Font_Cache, ev, fetchResponse);
  } else {
    //console.log("Content Type :", type);
    return fetchResponse;
  }
};
Make_SW_Cache = async (cachename, ev, response) => {
  cache = await caches.open(cachename);
  //console.log("caching : ", ev.request.url);
  try {
    cache.put(ev.request, response.clone());
  } catch (err) {
    return console.log(`error : ${err}`);
  }
  return response;
};

//Notification manager
self.onpush = (e) => {
  let payload = e.data.json();

  options = {
    requireInteraction: true,
    actions: [{
      action: "view",
      title: "Open"
    }, {
      action: "close",
      title: "Dismiss",
      
    }],
    data: {
      url: payload.url,
    },
    body: payload.body,
    icon: `assets/images/favicon.png`,
    image: `assets/images/page-img/07.jpg`,
    vibrate: [100],
    dir: 'ltr'
  };
  e.waitUntil(self.registration.showNotification(payload.title, options));
}
self.onnotificationclick = (e) => {
  let payload = e.notification.data;
  if (e.action === 'view') {
    clients.openWindow(payload.url);
  }
}