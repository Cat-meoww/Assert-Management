<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<style>
    .dropdown-toggle:after {
        display: none;
    }
</style>
<script type="module" src="<?= base_url('assets/js/bootstrap5/offcanvas.js') ?>"></script>
<div class="d-flex align-items-center justify-content-between welcome-content mb-3">
    <div class="navbar-breadcrumb">
        <h4 class="card-title"><b>Staff</b> Asserts</h4>
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
                            <option value="2">Assigned on</option>
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
            var dbtable = $('#ss-datatable').DataTable({
                createdRow: function(row, data, dataIndex) {
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
                    url: '<?= base_url("api/show-staff-inventory-datatable") ?>',
                    type: "POST",
                    data: {
                        status: inv_status,
                        fromdate: fromdate,
                        todate: todate,
                        type: type,
                        category: category,
                        sub_category: sub_category,
                        datetype: datetype,
                    }
                },
                "columnDefs": [{
                    "targets": [0],
                    "orderable": false,
                }, ],
            });
        }
        call_datatable();
    });
</script>
<!-- ticketriser Modal -->
<script>
    $(document.body).on('click', '.ticket-riser', function() {
        let selector = $(this).closest('.dt-rows');
        let proid = parseInt(selector.data('id'));
        let pro_code = `INV-${proid}`;
        let maintainer_id = parseInt(selector.data('maintainer-id'));
        let maintainer_name = selector.data('maintainer-name');
        $('#tick-inv-instance-id').val(proid);
        $('#tick-inv-instance-code').val(pro_code);
        $('#tick-maintainer-id').val(maintainer_id);
        $('#tick-maintainer-name').val(maintainer_name);
    });
    $(document.body).on('submit', '#ticketriserform', function(event) {
        event.preventDefault();
        $("#ticketriser").modal('hide');
        formdata = $(this).serialize();
        raise_ticket(formdata);
    });
    
    let raise_ticket = async function(param) {

        const url = "<?= base_url('api/post-ticket-raiser') ?>";
        const options = {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },

            body: param,

        }
        const response = await fetch(url, options);
        let res = await response.text();
        if (res == 'success') {
            toastr.success("Ticket has been raised.");
        } else {
            toastr.error("Failed to raise the ticket!");
        }

    }
</script>
<div class="modal fade" id="ticketriser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ticket Raiser</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="ticketriserform" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="tick-inv-instance-code">Assert ID</label>
                            <input type="text" name="assert-code" readonly id="tick-inv-instance-code" class="form-control">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="tick-maintainer-name">Maintainer</label>
                            <input type="text" name="maintainer-name" readonly id="tick-maintainer-name" class="form-control">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="tick-title">Title</label>
                            <select name="title" class="form-control" id="">
                                <?php foreach ($ticket_titles as $trows) : ?>
                                    <option value='<?= $trows->id ?>'><?= $trows->title ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="tick-des">Description (max-200)</label>
                            <textarea name="description" maxlength="200" id="tick-des" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                <input type="hidden" id="tick-inv-instance-id" name="instance-id">
                <input type="hidden" id="tick-maintainer-id" name="maintainer-id">
            </form>
        </div>
    </div>
</div>

<?= $this->include('layout/components/product_timeline') ?>
<?= $this->endSection() ?>