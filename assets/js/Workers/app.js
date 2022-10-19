const APP = {
  SW: null,
  workerpath: null,
  init() {
    APP.registerSW();
    // document.querySelector("h2").addEventListener("click", APP.addImage);
  },
  registerSW() {
    //called after DOMContentLoaded
    if ("serviceWorker" in navigator) {
      // 1. Register a service worker hosted at the root of the
      // site using the default scope.
      navigator.serviceWorker.register(`${APP.workerpath}/sw.js`).then(
        (registration) => {
          //console.log(registration);
          APP.SW =
            registration.installing ||
            registration.waiting ||
            registration.active;
          console.log("service worker registered");
          APP.Request_Notification();
        },
        (error) => {
          console.log("Service worker registration failed:", error);
        }
      );
      // 2. See if the page is currently has a service worker.
      //   if (navigator.serviceWorker.controller) {
      //     console.log("we have a service worker installed");
      //   }

      // 3. Register a handler to detect when a new or
      // updated service worker is installed & activate.
      //   navigator.serviceWorker.oncontrollerchange = (ev) => {
      //     console.log("New service worker activated");
      //   };

      // 4. remove/unregister service workers
      // navigator.serviceWorker.getRegistrations().then((regs) => {
      //   for (let reg of regs) {
      //     reg.unregister().then((isUnreg) => console.log(isUnreg));
      //   }
      // });
      // 5. Listen for messages from the service worker
    } else {
      console.log("Service workers are not supported.");
    }
  },
  async Request_Notification() {
    let status = Notification.permission;
    if (status === 'default') {
      return await Notification.requestPermission();
    } else if (status === 'denied') {
      return alert("Enable Notification for better experience");
    } else {
      return true;
    }
  },
  addImage(ev) {
    let img = document.createElement("img");
    img.src = "/images/Instagram post - 5.png";
    img.alt = "dynamically added image";
    let p = document.createElement("p");
    p.append(img);
    document.querySelector("main").append(p);
  },
};

//var url = new URL(url_string);
APP.workerpath = document.getElementById("set-worker").src.split("PATH=")[1];
document.addEventListener("DOMContentLoaded", APP.init);