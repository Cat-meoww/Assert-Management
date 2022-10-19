<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<script type="module" src="<?= base_url('assets/js/bootstrap5/offcanvas.js') ?>"></script>
<div class="d-flex align-items-center justify-content-between welcome-content mb-3">
    <div class="navbar-breadcrumb">
        <h4 class="card-title">Inventory</h4>
    </div>
    <div class="d-flex align-items-center">
        <div class="list-grid-toggle mr-4" role="button" data-placement="top" data-toggle="tooltip" title="Filter">
            <!-- <span class="icon icon-grid i-grid" data-toggle="tooltip" data-placement="top" title="Create"><i class="ri-add-line font-size-20"></i></span> -->
            <span class="icon icon-grid i-grid" aria-label="Inventory Filter" role="button" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="ri-filter-3-line font-size-20"></i></span>


        </div>
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
                        <label for="dt-maintainer">Maintainer</label>
                        <select name="dt-maintainer" id="dt-maintainer" class=" form-control">
                            <option value="0">All</option>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <button id="dt-filter-submit" class="btn btn-primary">search</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="dashboard1-dropdown mr-4 d-flex align-items-center">
            <div class="dashboard1-info rounded">
                <a href="#filter" class="collapsed" data-toggle="collapse" aria-expanded="false">
                    <i class="ri-filter-3-line font-size-20"></i>
                </a>
                <ul id="filter" class="iq-dropdown dropright collapse list-inline m-0 p-0 mt-2">
                    <li class="mb-2">
                        Filter
                    </li>
                    <li class="mb-2">

                    </li>

                </ul>
            </div>
        </div> -->
        <div class="dashboard1-dropdown d-flex align-items-center">


            <div class="dashboard1-info rounded" data-toggle="tooltip" data-placement="top" role="button" title="Add a item">
                <a href="#create" data-toggle="modal" data-target="#create-type" role="button" aria-expanded="false">
                    <i class="ri-add-line "></i>
                </a>
            </div>



        </div>

        <div class="modal fade bd-example-modal-xl" id="create-type" tabindex="-1" role="dialog" aria-hidden="true">
            <form method="POST" action="" autocomplete="off" id="allmasterform" class="needs-validation">
                <div class="modal-dialog modal-dialog-scrollable modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add a item </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body pb-0">

                            <!-- <div class=" mb-0 d-flex align-items-end justify-content-end">
                                <div class="dashboard1-info  rounded btn-primary bg-primary" role="button" id="add_filed" data-toggle="tooltip" data-placement="top" title="Add another field" role="button">
                                    <a role="button" data-dismiss="button">
                                        <i class="ri-add-line "></i>
                                    </a>
                                </div>
                            </div> -->
                            <div class="card m-0 pb-0" id="form-dyn-fill">
                                <!-- <div class="row modal-header ">
                                    <div class="col-4 mb-3">
                                        <label for="product_type">Product</label>
                                        <select name="product_type[]" class="form-control" required id="product_type">
                                            <option value="1">option</option>
                                        </select>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="actual_price">Actual Price</label>
                                        <input type="number" min="1" name="actual_price[]" min="0" oninput="validity.valid||(value='');" class="form-control" required id="actual_price" value="" autocomplete="off">

                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" min="1" name="quantity[]" min="0" oninput="validity.valid||(value='');" class="form-control" required id="quantity" value="" autocomplete="off">

                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="Maintainer">Maintainer</label>
                                        <select name="Maintainer_id[]" class="form-control" required id="Maintainer">
                                            <option value="1">option</option>
                                        </select>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="buyed_on">Buyed On</label>
                                        <input type="date" class="form-control" name="buyed_on[]" id="buyed_on" required autocomplete=" off">
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="expired_on">Expired On</label>
                                        <input type="date" class="form-control" id="expired_on" id="expired_on" required autocomplete=" off">
                                    </div>

                                    <div class="col-4 mb-3 row  justify-content-around align-items-center">

                                        <div class="form-check m-0 col">
                                            <label class="form-check-label" for="is_sale">For sale</label>
                                            <input class="ml-2" name="is_sale[]" type="checkbox" id="is_sale" value="1">
                                        </div>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <div class="dashboard1-info  rounded btn-primary bg-danger" role="button" id="delete_filed" data-toggle="tooltip" data-placement="top" title="Delete field" role="button">
                                            <a role="button" data-dismiss="button">
                                                <i class="ri-add-line "></i>
                                            </a>
                                        </div>
                                    </div>

                                </div> -->
                            </div>



                            <script>
                                $(document).ready(function() {
                                    let field_count = 0;
                                    $("#add_filed").click(function() {
                                        create_field();

                                    });

                                    function get_product_option() {
                                        let productfield_data = `<?= json_encode($product_list) ?>`;
                                        productfield_data = JSON.parse(productfield_data);
                                        //console.table(productfield_data);
                                        let product_options = '';
                                        $.each(productfield_data, function(index, value) {
                                            product_options += `<option value="${value.id}" data-price='${value.default_price}' >${value.name}</option>`;
                                        });
                                        return product_options;
                                    }
                                    $(document.body).on('change', '.product_name', function() {
                                        let pro_id = $(this).val();
                                        let piviot = $(this).data('piviot');
                                        let price = $(this).find(':selected').data('price');
                                        //make input default price
                                        $(`#actual_price${piviot}`).val(price);
                                        //alert(pro_id + "  " + price)
                                    });

                                    window.get_maintainer_option = function() {
                                        let maintainer_data = `<?= json_encode($maintainer_list) ?>`;
                                        maintainer_data = JSON.parse(maintainer_data);
                                        let maintainer_data_options = '';
                                        $.each(maintainer_data, function(index, value) {
                                            maintainer_data_options += `<option value="${value.id}">${value.username}</option>`;
                                        });
                                        return maintainer_data_options;
                                    }

                                    function create_field() {
                                        profield = get_product_option();
                                        maintainer_fields = get_maintainer_option();
                                        field_data = `<div class="row modal-header justify-content-start " id="field_piviot${field_count}">
                                                        <div class="col-4 mb-3">
                                                            <label for="product_id${field_count}">Product</label>
                                                            <select name="product_id[]" class="form-control product_name" required id="product_id${field_count}" data-piviot="${field_count}">
                                                                <option value="0" selected disabled>Select</option>
                                                                ${profield}
                                                            </select>
                                                        </div>
                                                        <div class="col-4 mb-3">
                                                            <label for="actual_price${field_count}">Actual Price</label>
                                                            <input type="number" min="1" name="actual_price[]" min="0" oninput="validity.valid||(value='');" class="form-control" required id="actual_price${field_count}" value="" autocomplete="off">

                                                        </div>
                                                        <div class="col-4 mb-3">
                                                            <label for="quantity${field_count}">Quantity</label>
                                                            <input type="number" min="1" name="quantity[]" min="0" oninput="validity.valid||(value='');" class="form-control" required id="quantity${field_count}" value="" autocomplete="off">

                                                        </div>
                                                        <div class="col-4 mb-3">
                                                            <label for="maintainer${field_count}">Maintainer</label>
                                                            <select name="maintainer_id[]" class="form-control" required id="maintainer${field_count}">
                                                                ${maintainer_fields}
                                                            </select>
                                                        </div>
                                                        <div class="col-4 mb-3">
                                                            <label for="buyed_on${field_count}">Buyed On</label>
                                                            <input type="date" class="form-control" name="buyed_on[]" id="buyed_on${field_count}" required autocomplete=" off">
                                                        </div>
                                                        <div class="col-4 mb-3">
                                                            <label for="expired_on${field_count}">Expired On</label>
                                                            <input type="date" class="form-control" name="expired_on[]" id="expired_on${field_count}" required autocomplete=" off">
                                                        </div>
                                                        <div class="col-4 mb-3">
                                                            <label for="product_sake${field_count}">Type</label>
                                                            <select name="product_sake[]" class="form-control" required id="product_sake${field_count}">
                                                                <option value="assert">Assert</option>
                                                                <option value="sale">For sale</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-4 align-self-center">
                                                            <div class="dashboard1-info  rounded btn-primary bg-danger delete_field" role="button" data-piviot="${field_count}" data-toggle="tooltip" data-placement="top" title="Delete field" role="button">
                                                                <a role="button" data-dismiss="button">
                                                                    <i class="ri-close-line "></i>
                                                                </a>
                                                            </div>             
                                                        </div>
                                        </div>`;
                                        $("#form-dyn-fill").append(field_data);
                                        field_count++;
                                        $('[data-toggle="tooltip"]').tooltip();
                                    }
                                    create_field();
                                    $(document.body).on('click', '.delete_field', function() {
                                        piviot = $(this).data('piviot');
                                        $("#field_piviot" + piviot).remove();
                                        $('[data-toggle="tooltip"]').tooltip('hide');
                                        //alert(piviot);
                                    });


                                    $("#btn-submit").click(function() {
                                        //console.log($("#allmasterform").serialize());
                                        add_data($("#allmasterform").serialize());
                                    });
                                    async function add_data(parameter) {
                                        const url = "<?= base_url('all-master-save/' . $uri->getSegment(2)) ?>";
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
                                        $('#create-type').modal('toggle');
                                        let res = await response.text();
                                        if (res == 'success') {
                                            toastr.success("success");
                                            $("#form-dyn-fill").html("");
                                            create_field();
                                            call_datatable();
                                        } else {
                                            toastr.error("Invalid data");
                                        }

                                    }





                                    $("#allmasterform").on('submit', function(event) {
                                        event.preventDefault();
                                        add_data($(this).serialize());
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
                                        maintainer = $("#dt-maintainer").val();
                                        inv_status = $("#dt-status").val();
                                        var dbtable = $('#ss-datatable').DataTable({
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
                                                url: '<?= base_url("api/show-admin-inventory-datatable") ?>',
                                                type: "POST",
                                                data: {
                                                    status: inv_status,
                                                    fromdate: fromdate,
                                                    todate: todate,
                                                    type: type,
                                                    category: category,
                                                    sub_category: sub_category,
                                                    maintainer: maintainer,
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
                        </div>
                        <div class="modal-footer justify-content-between">
                            <div class=" mb-0 d-flex align-items-end justify-content-end">
                                <div class="dashboard1-info  rounded btn-primary bg-primary" role="button" id="add_filed" data-toggle="tooltip" data-placement="top" title="Add another field" role="button">
                                    <a role="button" class="text-white" data-dismiss="button">
                                        <i class="ri-add-line "></i>
                                    </a>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>

                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
<div class="card">

    <div class="card-body">
        <div class="row justify-content-between">

        </div>
        <div class="table-responsive pb-3">
            <table id="ss-datatable" class="table table-striped table-bordered mt-4 ss-datatable " role="grid" aria-describedby="user-list-page-info">
                <thead>
                    <tr>
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
        $("#dt-maintainer").append(get_maintainer_option());
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
    });
</script>
<?= $this->endSection() ?>