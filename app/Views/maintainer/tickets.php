<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/boot-5.1.3/scss/placeholders.css') ?>">
<script type="module" src="<?= base_url('assets/js/bootstrap5/offcanvas.js') ?>"></script>
<div class="d-flex align-items-center justify-content-between welcome-content mb-3">
    <div class="navbar-breadcrumb">
        <h4 class="card-title">Tickets</h4>
    </div>
    <div class="d-flex align-items-center">

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasRightLabel">Filter</h5>
                <button type="button" class="close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"> <i class="las la-times"></i></button>
            </div>
            <div class="offcanvas-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="lazy-status">Status</label>
                        <select name="lazy-status" id="lazy-status" class="form-control">
                            <option value="0">Unsolved</option>
                            <option value="1">Resolved</option>

                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="lazy-datetype">Date Type</label>
                        <select name="lazy-datetype" id="lazy-datetype" class="form-control">
                            <option value="0">Date-Type</option>
                            <option value="1">Raised on</option>
                            <option value="2">Resolved on</option>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="lazy-from">From</label>
                        <input type="date" id="lazy-from" name="lazy-from" class="form-control" autocomplete=" off">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="lazy-to">To</label>
                        <input type="date" id="lazy-to" name="lazy-to" class="form-control" autocomplete=" off">
                    </div>

                    <div class="col-12 my-3">
                        <a class="btn btn-primary d-block" id='lazy-search-btn' role="button" rel="noopener noreferrer">Search</a>
                    </div>

                </div>
            </div>
        </div>


        <div class="dashboard1-dropdown d-flex align-items-center">
            <div class="dashboard1-info rounded" data-toggle="tooltip" data-placement="top" role="button" title="Filter">
                <a href="#offcanvasRight" aria-label="Inventory Filter" role="button" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                    <i class="ri-filter-3-line font-size-20"></i>
                </a>
            </div>
        </div>



    </div>
</div>
<div class="ticket-container">
    <div id="ticket-data"></div>
    <div id="ticket-placeholder"></div>
</div>


<script>
    $(document).ready(function() {
        async function complete_ticket(assert_id, id = 0, comments = '') {
            let data = {
                assert_id: assert_id,
                ticket_id: id,
                comments: comments,
            };
            const url = "<?= base_url('api/complete-ticket') ?>";
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
            const res = await response.text();
            return res;

        }

        function hide_card(selector) {
            // selector.animate({opacity:'0'},600,function () {
            //     selector.animate({height:'0px'},400,function () {
            //        selector.remove(); 
            //     });
            // });
            selector.animate({
                opacity: 0,
                height: '0px',
                left: 7000,
            }, 600, function() {
                selector.remove();
            });

        }
        $(document.body).on('click', '.tick-completed', async function(event) {
            event.preventDefault();
            comment = prompt("Comment :");
            id = $(this).data('id');
            assert_id = $(this).data('assert_id');
            if (comment = comment.trim()) {
                result = await complete_ticket(assert_id, id, comment);
                if (result == 'success') {
                    toastr.success("Ticket moved to completed");
                    let card = $(this).closest('.card');
                    hide_card(card);
                } else {
                    toastr.error("Failed to raise the ticket!");
                }
            }

        });

    });
    $(document).ready(function() {
        let limit = 5;
        let start = 0;
        let action = 'inactive';

        function lazy_load(limit) {
            let placeholder = '';
            for (let index = 0; index < limit; index++) {
                placeholder += `<div class="card" aria-hidden="true">
                                    <div class="card-body">
                                        <h5 class="card-title placeholder-glow">
                                            <span class="placeholder col-6"></span>
                                        </h5>
                                        <p class="card-text placeholder-glow">
                                            <span class="placeholder col-7"></span>
                                            <span class="placeholder col-4"></span>
                                            <span class="placeholder col-4"></span>
                                            <span class="placeholder col-6"></span>
                                            <span class="placeholder col-8"></span>
                                        </p>
                                        <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-6"></a>
                                    </div>
                                </div>`;
            }
            $(`#ticket-placeholder`).html(placeholder);
        }
        lazy_load(limit);
        $('#lazy-search-btn').click(function() {
            start = 0;
            action = 'inactive';
            $('#ticket-data').html('');
            lazy_load(limit);
            load_data(limit, start);

        });
        async function load_data(limit, start) {
            data = {
                limit: limit,
                start: start,
                status: $('#lazy-status').val(),
                datetype: $('#lazy-datetype').val(),
                fromdate: $('#lazy-from').val(),
                todate: $('#lazy-to').val(),
            };
            const url = "<?= base_url('api/get-maintainer-tickets') ?>";
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
            let res = await response.text();
            if (res == '') {
                $(`#ticket-placeholder`).html(`<h3 class="text-center mb-4">No More Tickets 🤘</h3>`);
                action = 'active';
            } else {
                $('#ticket-data').append(res);
                $(`#ticket-placeholder`).html('');
                action = 'inactive';
            }
        }
        if (action == 'inactive') {
            action = 'active';
            load_data(limit, start);
        }
        $(window).scrollTop(0);
        $(window).scroll(function() {
            nowscroll = $(window).scrollTop();
            if ($(window).scrollTop() + $(window).height() > $("#ticket-data").height() && action == 'inactive') {
                lazy_load(limit);
                action = 'active';
                start = start + limit;
                load_data(limit, start);
                $(window).scrollTop(nowscroll);
            }
        });
    });
</script>

<?= $this->include('layout/components/product_timeline') ?>
<?= $this->endSection() ?>