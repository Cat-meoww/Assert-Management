<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<style>
    .chat-body {
        height: 59vh;
        overflow-y: auto;
    }

    .same-body-height {
        height: 70vh;
        overflow-y: auto;
    }

    .chat-height {
        height: 80vh;
    }

    .myrow {
        height: 75vh;
        overflow: hidden;
    }

    .scroll-y {
        overflow-y: scroll;
    }


    .max-height {
        height: -webkit-fill-available;
    }

    .ctext-wrap {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 10px;
    }


    .ctext-wrap-content {
        padding: 12px 20px;
        background-color: var(--blue);
        border-radius: 8px 8px 8px 0;
        position: relative;
        color: #fff;
    }

    .dark .ctext-wrap-content {
        color: #fff;
    }


    .right .ctext-wrap .ctext-wrap-content {
        -webkit-box-ordinal-group: 3;
        -ms-flex-order: 2;
        order: 2;
        background-color: var(--iq-secondary);
        text-align: right;
        color: var(--bs-dark);
        border-radius: 8px 8px 0 8px;
    }

    .ctext-wrap-content:before {
        content: "";
        position: absolute;
        border: 5px solid transparent;
        border-left-color: var(--blue);
        border-top-color: var(--blue);
        left: 0;
        right: auto;
        bottom: -10px;
    }

    .right .ctext-wrap .ctext-wrap-content:before {
        border: 5px solid transparent;
        border-top-color: var(--iq-secondary);
        border-right-color: var(--iq-secondary);
        left: auto;
        right: 0;
    }

    .chat-time {
        font-size: 12px;
        margin-top: 4px;
        text-align: right;
        color: rgba(255, 255, 255, .5);
    }

    .dark .ctext-wrap-content p,
    .ctext-wrap-content span {
        color: #fff;
    }

    .right .ctext-wrap {
        float: right;
        text-align: right;
        justify-content: flex-end;
    }



    .chat-list>li {
        margin-bottom: 24px;
        position: relative;

    }
</style>
<div class="card chat-height">

    <div class="card-body">
        <div class="row justify-content-between px-2 myrow">
            <div class="col-4 px-1 scroll-y max-height">
                <ul class="list-group">

                    <!-- <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cras justo odio
                        <span class="badge badge-primary badge-pill">14</span>
                    </li> -->
                    <?php foreach ($user_list as $row) : ?>

                        <li role="button" data-receiver_username='<?= $row->username ?>' data-userid='<?= $row->id ?>' class="list-group-item d-flex justify-content-between align-items-center select_user">
                            <strong class="text-capitalize"><?= $row->username ?></strong>
                            <span class="badge badge-primary badge-pill" id="user_notification_<?= $row->id ?>"></span>
                        </li>

                    <?php endforeach ?>
                </ul>
            </div>
            <div class="col-8">
                <div class="card shadow-none mb-0">
                    <h5 class="card-header  border-bottom text-capitalize font-weight-bolder" id="receiver_username"> Featured</h5>
                    <img class="p-5 mx-5 img-fluid same-body-height " id="chat-banner" src="<?= base_url('assets/images/layouts/chat/chat_view.svg') ?>" alt="...">
                    <div class="card-body chat-body">

                        <ul class="list-unstyled mb-0 chat-list d-flex flex-column " id="msg_display">
                            <!-- <li>
                                <div class="ctext-wrap">
                                    <div class="ctext-wrap-content">
                                        <p class="mb-0">
                                            Good morning Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit eligendi maiores dignissimos ut repellendus accusamus voluptatibus deserunt, cupiditate voluptate delectus velit illo esse aliquam placeat omnis at repellat minima amet Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reiciendis aliquam beatae excepturi! Vel quia corrupti maiores explicabo repellat aspernatur voluptatibus velit, libero asperiores, natus cupiditate deleniti non voluptas, quidem recusandae.
                                        </p>
                                        <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <span class="align-middle">10:00</span></p>
                                    </div>
                                </div>
                            </li>
                            <li class="right">
                                <div class="ctext-wrap">
                                    <div class="ctext-wrap-content">
                                        <p class="mb-0">
                                            oppo samsung
                                        </p>
                                        <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <span class="align-middle">10:00</span></p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="ctext-wrap">
                                    <div class="ctext-wrap-content">
                                        <p class="mb-0">
                                            Good morning
                                        </p>
                                        <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <span class="align-middle">10:00</span></p>
                                    </div>
                                </div>
                            </li>
                            <li class="right">
                                <div class="ctext-wrap">
                                    <div class="ctext-wrap-content">
                                        <p class="mb-0">
                                            Good morning Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit eligendi maiores dignissimos ut repellendus accusamus voluptatibus deserunt, cupiditate voluptate delectus velit illo esse aliquam placeat omnis at repellat minima amet Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reiciendis aliquam beatae excepturi! Vel quia corrupti maiores explicabo repellat aspernatur voluptatibus velit, libero asperiores, natus cupiditate deleniti non voluptas, quidem recusandae.
                                        </p>
                                        <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <span class="align-middle">10:00</span></p>
                                    </div>
                                </div>
                            </li> -->
                        </ul>
                    </div>



                </div>
                <form action="#" id="chat-form" method="post">
                    <div class="input-group ">

                        <input type="text" autocomplete="off" id="chatmsg" class="form-control" placeholder="Type .." aria-label="Type .." aria-describedby="Type ..">
                        <div class="input-group-append" id="button-addon3">
                            <button class="btn btn-primary" type="submit"><i class="las la-paper-plane"></i></button>
                        </div>
                        <!-- <div class="input-group-append">
                            <span class="input-group-text" role='submit' type='submit' id="basic-addon2"> <i class="las la-paper-plane"></i></button></span>
                        </div> -->
                    </div>
                </form>
            </div>
        </div>


    </div>
</div>
<script async>
    window.Get_msg = async (id = 0) => {
        data = {
            id: id
        }
        const url = "<?= base_url('api/get_chat_data') ?>";
        const options = {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(data).toString(),
        }
        const response = await fetch(url, options);
        const res = await response.json();
        res.map((log) => {
            classr = ''
            if (id != log.sender) {
                classr = `class='right'`;
            }
            html = `<li ${classr} >
                        <div class="ctext-wrap">
                            <div class="ctext-wrap-content">
                                <p class="mb-0 text-break">${log.msg}</p>
                                <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <span class="align-middle">${log.created_on}</span></p>
                            </div>
                        </div>
                    </li>`;
            $("#msg_display").prepend(html);
            $(".chat-body").scrollTop($(".chat-body")[0].scrollHeight);
        });

        //console.log(res);

    }
</script>
<!-- <script async>
    const token = "<?= "$session->token" ?>";
    let receiver_id = '';
    $(document).ready(func
    tion(params) {

        var conn = new WebSocket('ws://localhost:8055?token=<?= "$session->token" ?>');
        conn.onopen = function(e) {
            console.log("Connection established!");
        };
        conn.onclose = function(e) {
            console.log("Connection closed");
        };
        conn.onerror = function(e) {
            alert("Failed to connect with chat server")
        }
        conn.onmessage = function(e) {
            console.log(e.data);
            let response = e.data;
            var res = JSON.parse(e.data);
            if (res.type == 'msg') {
                notify_bell();
                if (res.sender_id == receiver_id) {
                    html = `<li>
                                <div class="ctext-wrap">
                                    <div class="ctext-wrap-content">
                                        <p class="mb-0">` + res.orginal_msg + `
                                        </p>
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
            // var res = JSON.parse(e.data);
            // var rowstart = 'd-flex flex-row justify-content-start mb-4';
            // var bg_class = 'text-dark alert-success';
            // var html = `<div class="` + rowstart + `">

            //                     <div class="p-3 ms-3 br-15 ` + bg_class + `" >
            //                         <p class="small mb-0">` + res.msg + `</p> </div> </div>`;
            // $("#msg_area").append(html);
        };

        function sendmsg() {
            if (validate_chatform()) {
                var msg = $("#chatmsg").val();

                var data = {
                    msg: msg,
                    receiver_id: receiver_id,
                    type: 'msg'
                }
                conn.send(JSON.stringify(data));
                $("#chatmsg").val("");
                make_my_msg_bar(data);
            }
        }

        function make_my_msg_bar(data) {
            html = `<li class="right">
                                <div class="ctext-wrap">
                                    <div class="ctext-wrap-content">
                                        <p class="mb-0">` + data.msg + `
                                        </p>
                                        <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <span class="align-middle">10:00</span></p>
                                    </div>
                                </div>
                            </li>`;
            $("#msg_display").append(html);
            $(".chat-body").scrollTop($(".chat-body")[0].scrollHeight);

        }

        function notify_bell() {
            var audio = new Audio('<?= base_url('assets/sounds/notify/bell.mp3') ?>');
            audio.play();
        }
        $('#chat_form').on('submit', function(event) {
            event.preventDefault();
            sendmsg();
        });
        $('#chatmsg').keypress(function(e) {
            var key = e.which;
            if (key == 13) {

            }
        });



        $(document).on('submit', "#chat-form", function(event) {
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
    $(document).on('click', '.select_user', function() {

        if (receiver_id != $(this).data('userid')) {
            receiver_id = $(this).data('userid');
            receiver_name = $(this).data('receiver_username');
            $("#receiver_username").html(receiver_name);
            $('.select_user.active').removeClass('active');
            $(this).addClass('active');
            $("#chatmsg").val("");
            $("#chat-banner").addClass("d-none");
            //empty in the msg box
            $("#msg_display").html('');
        }


        //alert(receiver_id);
    });
</script> -->
<?= $this->endSection() ?>