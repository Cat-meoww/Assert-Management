<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<style>
    .dropdown-toggle:after {
        display: none;
    }

    .dt-select-jq {
        background: #8f93f6 !important;
        color: #000 !important;
    }

    .table-bordered td,
    .table-bordered th {
        border: 0px solid #f1f1f1 !important;
    }
</style>

<script type="module" src="<?= base_url('assets/js/bootstrap5/offcanvas.js') ?>"></script>
<div class="d-flex align-items-center justify-content-between welcome-content mb-3">
    <div class="navbar-breadcrumb">
        <h4 class="card-title">Maintainace Asserts</h4>
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
                        <label for="dt-status">Product Status</label>
                        <select name="dt-status" id="dt-status" class="form-control">
                            <option value="0">All</option>
                            <?php foreach ($invent_status as $row) : ?>
                                <option value='<?= $row->id ?>'><?= $row->status_name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="dt-datetype">Date Type</label>
                        <select name="dt-datetype" id="dt-datetype" class="form-control">
                            <option value="1">Bought on</option>
                            <option value="2">Entry on</option>
                            <option value="3">Sold on</option>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="dt-from">From</label>
                        <input type="date" id='dt-from' name='dt-from' class="form-control" autocomplete=" off">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="dt-to">To</label>
                        <input type="date" id='dt-to' name='dt-to' class="form-control" autocomplete=" off">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="dt-type">Type</label>
                        <select name="dt-type" id="dt-type" class=" form-control">
                            <option value="0">All</option>
                            <?php foreach ($pro_type as $row) :
                                $protype_array[$row->id] = $row->type;
                            ?>

                                <option value='<?= $row->id ?>'><?= $row->type ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="dt-category">Category</label>
                        <select name="dt-category" id="dt-category" class=" form-control">
                            <option value="0">All</option>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="dt-sub-category">Sub Category</label>
                        <select name="dt-sub-category" id="dt-sub-category" class=" form-control">
                            <option value="0">All</option>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="dt-staff">Assigned To</label>
                        <select name="dt-staff" id="dt-staff" class="form-control">
                            <option value="0">All</option>
                            <option value="-1">Un Assigned</option>
                            <?php foreach ($workers_data as $row) : ?>
                                <option value='<?= $row->id ?>'><?= $row->username ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <button id="dt-filter-submit" class="btn btn-primary">search</button>
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
<div class="card">

    <div class="card-body">
        <div class="row justify-content-between">

        </div>
        <div class="table-responsive pb-3">
            <table id="ss-datatable" class="table  table-striped table-bordered mt-4 ss-datatable " role="grid" aria-describedby="user-list-page-info">
                <thead>
                    <tr>
                        <th scope="col">Action</th>
                        <th scope="col">Product</th>
                        <th scope="col">Type</th>
                        <th scope="col">Category</th>
                        <th scope="col">Sub Category</th>
                        <th scope="col">Actual Price</th>
                        <th scope="col">Status</th>
                        <th scope="col">Maintainer</th>
                        <th scope="col">Assigned to</th>
                        <th scope="col">Maintenance Cost</th>
                        <th scope="col">Date</th>
                    </tr>

                </thead>
                <tbody>


                </tbody>
            </table>

        </div>

    </div>
</div>


<script>
    $(document).ready(function() {
        window.get_maintainer_option = function() {
            let maintainer_data = `<?= json_encode($maintainer_list) ?>`;
            maintainer_data = JSON.parse(maintainer_data);
            let maintainer_data_options = '';
            $.each(maintainer_data, function(index, value) {
                maintainer_data_options += `<option value="${value.id}">${value.username}</option>`;
            });
            return maintainer_data_options;
        }
        window.get_workers_option = function(id = 0) {
            let workers_data = `<?= json_encode($workers_data) ?>`;
            workers_data = JSON.parse(workers_data);
            let workers_data_options = '';
            id = parseInt(id);
            if (isNaN(id)) {
                id = 0;
            }
            workers_data_options += `<option value="0">Un-assign</option>`;
            $.each(workers_data, function(index, value) {
                if (value.id != id) {
                    workers_data_options += `<option value="${value.id}">${value.username}</option>`;
                } else {
                    workers_data_options += `<option value="${value.id}" selected>${value.username}</option>`;
                }
            });
            return workers_data_options;
        }
        $("#dt-type").change(function() {
            let chlist = `<?php echo json_encode($pro_category) ?>`;
            chlist = JSON.parse(chlist);
            //console.table(chlist)
            let protype = $(this).val();
            console.log(protype);
            $('#dt-category').html("");
            $('#dt-category').append(`<option value="0">All</option>`);
            $.each(chlist, function(index, value) {
                if (value.type == protype) {
                    $('#dt-category').append(`<option value="${value.id}">${value.category}</option>`);
                }
            });
            option_sub_category();
        });

        function clear_dynamic_dt_datetype() {
            $("#dt-datetype option[value='4']").remove();
            $("#dt-datetype option[value='5']").remove();
            $("#dt-datetype option[value='6']").remove();
        }
        $("#dt-status").change(function() {
            dt_status = $(this).val();
            if (dt_status == 2) {
                clear_dynamic_dt_datetype();
                $("#dt-datetype").append('<option value="4">Damaged On</option>');
            } else if (dt_status == 3) {
                clear_dynamic_dt_datetype();

                $("#dt-datetype").append('<option value="5">Repaired On</option>');
            } else if (dt_status == 4) {
                clear_dynamic_dt_datetype();
                $("#dt-datetype").append('<option value="6">Upgraded On</option>');

            } else {
                clear_dynamic_dt_datetype();
            }
        });

        function option_sub_category() {
            let chlist = `<?php echo json_encode($pro_sub_category) ?>`;
            chlist = JSON.parse(chlist);

            let procat = $("#dt-category").val();
            let pro_type = $("#dt-type").val();
            console.log(procat);
            $('#dt-sub-category').html("");
            $('#dt-sub-category').append(`<option value="0">All</option>`);
            $.each(chlist, function(index, value) {
                if (value.category_id == procat && value.type_id == pro_type) {
                    $('#dt-sub-category').append(`<option value="${value.id}">${value.sub_category_name}</option>`);
                }
            });
        }

        $("#dt-category").change(function() {
            option_sub_category();
        });
        $("#dt-filter-submit").click(function() {
            call_datatable();
        });
        window.call_datatable = function() {
            if ($("#ss-datatable").length) {
                $('#ss-datatable').dataTable().fnDestroy()
            }
            fromdate = $("#dt-from").val();
            todate = $("#dt-to").val();
            datetype = $("#dt-datetype").val();
            type = $("#dt-type").val();
            category = $("#dt-category").val();
            sub_category = $("#dt-sub-category").val();
            inv_status = $("#dt-status").val();
            staff = $("#dt-staff").val();
            var dbtable = $('#ss-datatable').DataTable({
                createdRow: function(row, data, dataIndex) {
                    //console.table(data);
                    $(row).data('id', data.code);
                    $(row).data('maintainer-id', data['maintainer']);
                    $(row).data('maintainer-name', data['maintainer-name']);
                    $(row).data('assigned-to-id', data['assigned-to-id']);
                    $(row).data('assigned-to-name', data['assigned-to']);
                    $(row).data('js-selected', false);
                    $(row).addClass('dt-rows');
                },
                language: {
                    search: "",
                    searchPlaceholder: "search",
                },
                search: {
                    return: true,
                },
                ordering: false,
                dom: "Bfrtip",
                "processing": true,
                "serverSide": true,
                "autoWidth": false,

                "order": [],
                "ajax": {
                    url: '<?= base_url("api/show-maintainer-inventory-datatable") ?>',
                    type: "POST",
                    data: {
                        status: inv_status,
                        fromdate: fromdate,
                        todate: todate,
                        type: type,
                        category: category,
                        sub_category: sub_category,
                        datetype: datetype,
                        assign: staff,
                    }
                },
                "columnDefs": [{
                    "targets": [0],
                    "orderable": false,
                }, ],
            });
        }
        call_datatable();
        document.onclick = hideMenu;

        function hideMenu() {

            //document.querySelector(".contextMenu").style.visibility = "hidden";
        }

        // shareMenu = contextMenu.querySelector(".share-menu");
        let SELECTED = false;
        $('#ss-datatable tbody').on('contextmenu', 'tr', function(e) {
            SELECTED = true;
            e.preventDefault();
            selected_callback(this);

        });
        selected_callback = function(instance) {
            let pro_code_id = $(instance).data('id');
            console.log(pro_code_id);
            $(instance).addClass("dt-select-jq");
            $(instance).data('js-selected', true);
            SELECTED = true;
        }
        de_selected_callback = function(instance) {
            $(instance).removeClass("dt-select-jq");
            $(instance).data('js-selected', false);
        }
        de_selected_callback_all = function() {
            $("#ss-datatable tbody").children('tr').removeClass("dt-select-jq");
            $("#ss-datatable tbody").children('tr').data('js-selected', false);
        }
        $('#ss-datatable tbody').on('click', 'tr', function(e) {
            // console.log(e.ctrlKey);
            e.preventDefault();
            if (SELECTED && e.ctrlKey) {
                console.log($(this).data('js-selected'));
                if ($(this).data('js-selected') == true) {
                    de_selected_callback(this);
                } else {
                    selected_callback(this);
                }
            } else {
                de_selected_callback_all();
                selected_callback(this);
            }
        });
    });
    //assigning staff
    $(document.body).on('click', '.assignbtn', function() {
        let productid = $(this).data('instance-id');

        let assignedto = $(this).data('assigned-to');
        let workers_option = get_workers_option(assignedto);
        $('#staffid').html(workers_option);
        $("#instanceid").val(productid);
        $('#assproname').val($(this).data('product-name'));

    });
    $(document.body).on('submit', '#assignstaff', function(event) {
        event.preventDefault();
        $("#assigner").modal('hide');
        formdata = $(this).serialize();
        //alert(formdata);
        set_assign(formdata);
    });
    async function set_assign(parameter) {
        const url = "<?= base_url('all-master-save/maintainer-assign-update') ?>";
        const options = {
            method: 'POST', // *GET, POST, PUT, DELETE, etc.
            mode: 'cors', // no-cors, *cors, same-origin
            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
            credentials: 'same-origin', // include, *same-origin, omit
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: parameter,
        }
        const response = await fetch(url, options);
        let res = await response.text();
        if (res == 'success') {
            toastr.success("success");
            call_datatable();
        } else {
            toastr.error("Failed to update");
        }
    }
    // move to 
    $(document.body).on('click', '.moveto', function() {
        let productid = $(this).data('instance-id');

        let assignedto = $(this).data('assigned-to');
        let moveto = parseInt($(this).data('moveto'));
        $('#asspronamemoveto').val($(this).data('product-name'));
        $('#movetoreason').val('');
        if (moveto === 1) {
            $('#movetoreason').removeAttr('disabled');
            $('#movestatus').removeAttr('disabled');
            $('#movetoinstanceid').val(productid);
            $('#allowmoveto').val(productid);
        } else {
            $('#movetoinstanceid').val(0);
            $('#allowmoveto').val('');
            $('#movetoreason').attr('disabled', '');
            $('#movestatus').attr('disabled', '');
            toastr.warning("Unable to move item only usable are able to move");
        }
    });
    $(document.body).on('submit', '#movetoform', function(event) {
        event.preventDefault();
        $("#moveto").modal('hide');
        formdata = $(this).serialize();
        //alert(formdata);
        moveto_status(formdata);
    });
    async function moveto_status(parameter) {
        const url = "<?= base_url('api/update-product-status') ?>";
        const options = {
            method: 'POST', // *GET, POST, PUT, DELETE, etc.
            mode: 'cors', // no-cors, *cors, same-origin
            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
            credentials: 'same-origin', // include, *same-origin, omit
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: parameter,
        }
        const response = await fetch(url, options);
        let res = await response.text();
        if (res == 'success') {
            toastr.success("success");
            call_datatable();
        } else {
            toastr.error("Failed to update");
        }
    }
    // move to 
    $(document.body).on('click', '.repaire_done', function() {
        let productid = $(this).data('instance-id');
        $("#ru_instanceid").val(productid);


        $('#ru_proname').val($(this).data('product-name'));


    });
    $(document.body).on('submit', '#repairandupgradeform', function(event) {
        event.preventDefault();
        $("#repairandupgrademodel").modal('hide');
        formdata = $(this).serialize();
        complete_repair_upgrade(formdata);
    });
    async function complete_repair_upgrade(parameter) {
        const url = "<?= base_url('api/update-repair-upgrade') ?>";
        const options = {
            method: 'POST', // *GET, POST, PUT, DELETE, etc.
            mode: 'cors', // no-cors, *cors, same-origin
            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
            credentials: 'same-origin', // include, *same-origin, omit
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: parameter,
        }
        const response = await fetch(url, options);
        let res = await response.text();
        if (res == 'success') {
            toastr.success("success");
            call_datatable();
        } else {
            toastr.error("Failed to update");
        }
    }
</script>
<!-- Modal -->
<div class="modal fade" id="assigner" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assign Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="assignstaff" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="assproname">Product name</label>
                            <input type="text" name="assproname" readonly id="assproname" class="form-control">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="staffid">Staff Members</label>
                            <select name="assignitemto" id="staffid" required class="form-control">

                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <!-- <button id="dt-filter-submit" class="btn btn-primary">search</button> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                <input type="hidden" id="instanceid" name=" instanceid">
            </form>
        </div>
    </div>
</div>
<!-- Modal move to -->
<div class="modal fade" id="moveto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Move to </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="movetoform" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="assproname">Product name</label>
                            <input type="text" name="assproname" readonly id="asspronamemoveto" class="form-control">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="movestatus">Status</label>
                            <select name="movestatus" id="movestatus" required class="form-control">
                                <option value="4">Upgrade</option>
                                <option value="3">Repaired</option>
                                <option value="2">Damaged</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="Reason">Reason</label>
                            <textarea name="Reason" class="form-control" id="movetoreason" required rows="5" maxlength="200"></textarea>
                        </div>
                        <div class="col-12">
                            <!-- <button id="dt-filter-submit" class="btn btn-primary">search</button> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                <input type="hidden" id="movetoinstanceid" name="instanceid" required>
                <input type="hidden" id="allowmoveto" name="allowmoveto" required>
            </form>
        </div>
    </div>
</div>
<!-- Modal repair and upgrade model -->
<div class="modal fade" id="repairandupgrademodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Repair/Upgrade Done</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="repairandupgradeform" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="ru_proname">Product name</label>
                            <input type="text" name="ru_proname" readonly id="ru_proname" class="form-control">
                        </div>

                        <div class="col-12">
                            <label for="ru_cost">Recovery Cost</label>
                            <input type="number" name="ru_cost" min="0" oninput="validity.valid||(value='');" id="ru_cost" class="form-control">
                        </div>
                        <div class="col-12">
                            <!-- <button id="dt-filter-submit" class="btn btn-primary">search</button> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                <input type="hidden" id="ru_instanceid" name="instanceid" required>
            </form>
        </div>
    </div>
</div>
<!-- TIMELINE model -->
<style>
    .timeline {
        border-left: 3px solid #727cf5;
        border-bottom-right-radius: 4px;
        border-top-right-radius: 4px;
        background: rgba(114, 124, 245, 0.09);
        margin: 0 auto;
        letter-spacing: 0.2px;
        position: relative;
        line-height: 1.4em;
        font-size: 1.03em;
        padding: 50px;
        list-style: none;
        text-align: left;
        max-width: 50%;
    }

    @media (max-width: 767px) {
        .timeline {
            max-width: 98%;
            padding: 25px;
        }
    }

    .timeline h1 {
        font-weight: 300;
        font-size: 1.4em;
    }

    .timeline h2,
    .timeline h3 {
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 10px;
    }

    .timeline .event {
        border-bottom: 1px dashed #e8ebf1;
        padding-bottom: 25px;
        margin-bottom: 25px;
        position: relative;
    }

    @media (max-width: 767px) {
        .timeline .event {
            padding-top: 30px;
        }
    }

    .timeline .event:last-of-type {
        padding-bottom: 0;
        margin-bottom: 0;
        border: none;
    }

    .timeline .event:before,
    .timeline .event:after {
        position: absolute;
        display: block;
        top: 0;
    }

    .timeline .event:before {
        left: -207px;
        content: attr(data-date);
        text-align: right;
        font-weight: 100;
        font-size: 0.9em;
        min-width: 120px;
    }

    @media (max-width: 767px) {
        .timeline .event:before {
            left: 0px;
            text-align: left;
        }
    }

    .timeline .event:after {
        -webkit-box-shadow: 0 0 0 3px #727cf5;
        box-shadow: 0 0 0 3px #727cf5;
        left: -55.8px;
        background: #fff;
        border-radius: 50%;
        height: 9px;
        width: 9px;
        content: "";
        top: 5px;
    }

    @media (max-width: 767px) {
        .timeline .event:after {
            left: -31.8px;
        }
    }

    .rtl .timeline {
        border-left: 0;
        text-align: right;
        border-bottom-right-radius: 0;
        border-top-right-radius: 0;
        border-bottom-left-radius: 4px;
        border-top-left-radius: 4px;
        border-right: 3px solid #727cf5;
    }

    .rtl .timeline .event::before {
        left: 0;
        right: -170px;
    }

    .rtl .timeline .event::after {
        left: 0;
        right: -55.8px;
    }
</style>
<script>
    $(document.body).on('click', '.timeline-btn', function() {

        let proid = parseInt($(this).closest('.dt-rows').data('id'));
        call_timeline(proid);

    });
    call_timeline = async function(assert_id) {
        $('#timelinedata').html(' ');
        const url = "<?= base_url('api/get-assert-timeline') ?>";
        const options = {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },

            body: `id=${assert_id}`,

        }
        const response = await fetch(url, options);
        let res = await response.text();
        $('#timelinedata').html(res);
    }
</script>
<div class="modal fade" id="PROTIMELINE" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Timeline</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container">

                    <ul class="timeline" id="timelinedata">
                        <li class="event" data-date="12:30 - 1:00pm">
                            <h3>Registration</h3>
                            <p>Get here on time, it's first come first serve. Be late, get turned away.</p>
                        </li>
                        <li class="event" data-date="2:30 - 4:00pm">
                            <h3>Opening Ceremony</h3>
                            <p>Get ready for an exciting event, this will kick off in amazing fashion with MOP &amp; Busta Rhymes as an opening show.</p>
                        </li>
                        <li class="event" data-date="5:00 - 8:00pm">
                            <h3>Main Event</h3>
                            <p>This is where it all goes down. You will compete head to head with your friends and rivals. Get ready!</p>
                        </li>
                        <li class="event" data-date="8:30 - 9:30pm">
                            <h3>Closing Ceremony</h3>
                            <p>See how is the victor and who are the losers. The big stage is where the winners bask in their own glory.</p>
                        </li>
                    </ul>

                </div>
            </div>



        </div>
    </div>
</div>

<?= $this->endSection() ?>