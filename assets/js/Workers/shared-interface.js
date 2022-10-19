const cookieStorage = {
    getItem: (item) => {
        const cookies = document.cookie
            .split(';')
            .map(cookie => cookie.split('='))
            .reduce((acc, [key, value]) => ({
                ...acc,
                [key.trim()]: value
            }), {});
        return cookies[item];
    },
    setItem: (item, value) => {
        document.cookie = `${item}=${value};`
    }
}
const SHAREDAPP = {
    //sharedWorker
    SocketWorker: null,
    workerpath: null,
    chattoken: null,
    init() {
        // starter of app
        SHAREDAPP.StartWorker();
        // const idleBtn = document.getElementById('idledetector');
        // //idleBtn.addEventListener('click', (event) => SHAREDAPP.offlineDetector());
        // SHAREDAPP.offlineDetector();

        //document.getElementsByClassName('select_user')[0].click()
    },
    StartWorker: () => {
        option = {
            name: cookieStorage.getItem('APP_CHAT_TOKEN'),
        };
        if ("SharedWorker" in window) {
            console.log("started shared worker");
            SHAREDAPP.SocketWorker = new SharedWorker(`${SHAREDAPP.workerpath}/SharedWorker.js`, option);
            SHAREDAPP.SocketWorker.port.start();
            SHAREDAPP.SocketWorker.port.onmessage = SHAREDAPP.onmessage;
        }
    },
    onmessage: ({
        data
    }) => {
        console.log(data);
        let res = data;
        if (res.type == 'msg') {
            SHAREDAPP.notify();
            if (res.sender_id == receiver_id) {
                html = `<li>
                            <div class="ctext-wrap">
                                <div class="ctext-wrap-content">
                                    <p class="mb-0 text-break">${res.orginal_msg}</p>
                                    <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <span class="align-middle">10:00</span></p>
                                </div>
                            </div>
                        </li>`;
                $("#msg_display").append(html);
                $(".chat-body").scrollTop($(".chat-body")[0].scrollHeight);

            } else {
                toastr.notification(res.msg, res.sender_name);
            }
        }

    },
    postMessage: (data) => {
        let cover = {
            action: "send",
            value: data,
        };
        SHAREDAPP.SocketWorker.port.postMessage(cover);
    },
    notify: async () => {
        try {
            var audio = new Audio(`${SHAREDAPP.workerpath}/assets/sounds/notify/bell.mp3`);
            promise = await audio.play();
        } catch (e) {
            console.log("failed to play audio : ", e);
            return false;
        }
    },
    terminate: () => {
        let cover = {
            action: "kill",
        };
        SHAREDAPP.SocketWorker.port.postMessage(cover);
    },
    userstatus: true,
    offlineDetector: async () => {

        const state = await IdleDetector.requestPermission();
        console.log(state);

        const idleDetector = new IdleDetector();

        idleDetector.onchange = () => {
            const {
                userState,
                screenState
            } = idleDetector;
            console.log(idleDetector)
            if (userState == 'idle' || screenState == 'locked') {
                SHAREDAPP.userstatus = false
            }else{
                SHAREDAPP.userstatus = true
            }
        };

        await idleDetector.start({
            threshold: 60000,
        });

    }
};
SHAREDAPP.workerpath = document.getElementById("shared-worker").src.split("PATH=")[1];
document.addEventListener("DOMContentLoaded", SHAREDAPP.init);
document.querySelector("#appsignout").onclick = SHAREDAPP.terminate;

const token = "";
let receiver_id = '';
$(document).ready(function (params) {

    function sendmsg() {
        if (validate_chatform()) {
            var msg = $("#chatmsg").val();

            var data = {
                msg: msg,
                receiver_id: receiver_id,
                type: 'msg'
            }
            // conn.send(JSON.stringify(data));
            SHAREDAPP.postMessage(data);
            $("#chatmsg").val("");
            make_my_msg_bar(data);
        }
    }

    function make_my_msg_bar(data) {
        html = `<li class="right">
                                <div class="ctext-wrap">
                                    <div class="ctext-wrap-content">
                                        <p class="mb-0 text-break">` + data.msg + `
                                        </p>
                                        <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <span class="align-middle">10:00</span></p>
                                    </div>
                                </div>
                            </li>`;
        $("#msg_display").append(html);
        $(".chat-body").scrollTop($(".chat-body")[0].scrollHeight);

    }

    function notify_bell() {
        try {
            var audio = new Audio('/assets/sounds/notify/bell.mp3');
            audio.play();
        } catch (e) {
            console.log(e);
        }
    }
    $('#chat_form').on('submit', function (event) {
        event.preventDefault();
        sendmsg();
    });
    $('#chatmsg').keypress(function (e) {
        var key = e.which;
        if (key == 13) {

        }
    });



    $(document).on('submit', "#chat-form", function (event) {
        event.preventDefault();
        if (validate_chatform()) {
            sendmsg();
        }

    });

    function validate_chatform() {
        if ($("#chatmsg").val().trim().length < 1) {
            alert("empty msg");
            return false;
        }
        if (receiver_id.length < 1) {
            alert("empty selection");
            return false;
        }
        return true;
    }
});
$(document).on('click', '.select_user', function () {
    if (receiver_id != $(this).data('userid')) {
        receiver_id = $(this).data('userid');
        receiver_name = $(this).data('receiver_username');
        $("#receiver_username").html(receiver_name);
        $('.select_user.active').removeClass('active');
        $(this).addClass('active');
        $("#chatmsg").val("");
        Get_msg(receiver_id);
        $("#chat-banner").addClass("d-none");
        //empty in the msg box
        $("#msg_display").html('');


    }

    //alert(receiver_id);
});