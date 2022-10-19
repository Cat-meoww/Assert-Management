<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between welcome-content mb-3">
    <div class="navbar-breadcrumb">
        <h4 class="card-title">Product Type</h4>
    </div>
    <div class="d-flex align-items-center">
        <div class="list-grid-toggle mr-4">
            <!-- <span class="icon icon-grid i-grid" data-toggle="tooltip" data-placement="top" title="Create"><i class="ri-add-line font-size-20"></i></span> -->


        </div>
        <div class="dashboard1-dropdown d-flex align-items-center">
            <div class="dashboard1-info rounded" data-toggle="tooltip" data-placement="top" title="Create">
                <a href="#create" data-toggle="modal" data-target="#create-type" role="button" aria-expanded="false">
                    <i class="ri-add-line "></i>
                </a>

            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="create-type" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Product Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="allmasterform" action=" <?= base_url('all-master-save/' . $uri->getSegment(2)) ?>" autocomplete="off" class="needs-validation">
                            <div class="form-row">
                                <div class="col-12 mb-3">
                                    <label for="Productty">Product type</label>
                                    <input type="text" name="product_type" class="form-control" id="Productty" value="" autocomplete="off" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <button class="btn btn-primary" type="submit">Submit form</button>
                                </div>
                            </div>
                        </form>
                        <script>
                            $(document).ready(function() {
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
                                    } else {
                                        toastr.error("Invalid data");
                                    }

                                }
                                $("#allmasterform").on('submit', function(event) {
                                    event.preventDefault();
                                    add_data($(this).serialize());
                                });

                                // Example starter JavaScript for disabling form submissions if there are invalid fields
                                // (function() {
                                //     'use strict';
                                //     window.addEventListener('load', function() {
                                //         // Fetch all the forms we want to apply custom Bootstrap validation styles to
                                //         var forms = document.getElementsByClassName('needs-validation');
                                //         // Loop over them and prevent submission
                                //         var validation = Array.prototype.filter.call(forms, function(form) {
                                //             form.addEventListener('submit', function(event) {
                                //                 event.preventDefault();
                                //                 if (form.checkValidity() === false) {
                                //                     event.stopPropagation();
                                //                 }
                                //                 add_data($(form).serialize());
                                //                 form.classList.add('was-validated');
                                //             }, false);
                                //         });
                                //     }, false);
                                // })();
                            });
                        </script>
                    </div>

                </div>
            </div>
        </div>
        <!-- <div class="dashboard1-dropdown d-flex align-items-center">
            <div class="dashboard1-info rounded">
                <a href="#calander" class="collapsed" data-toggle="collapse" aria-expanded="false">
                    <i class="ri-arrow-down-s-line"></i>
                </a>
                <ul id="calander" class="iq-dropdown collapse list-inline m-0 p-0 mt-2">
                    <li class="mb-2">
                        <a href="#" data-toggle="tooltip" data-placement="right" title="Calander"><i class="las la-calendar iq-arrow-left"></i></a>
                    </li>
                    <li class="mb-2">
                        <a href="#" data-toggle="tooltip" data-placement="right" title="Keep"><i class="las la-lightbulb iq-arrow-left"></i></a>
                    </li>
                    <li>
                        <a href="#" data-toggle="tooltip" data-placement="right" title="Tasks"><i class="las la-tasks iq-arrow-left"></i></a>
                    </li>
                </ul>
            </div>
        </div> -->
    </div>
</div>
<div class="card">
    <!-- <div class="card-header d-flex justify-content-between">
        <div class="header-title">

        </div>
    </div> -->
    <div class="card-body">
        <div class="row justify-content-between">
            <!-- <div class="col-sm-6 col-md-6">
                <div id="user_list_datatable_info" class="dataTables_filter">
                    <form class="mr-3 position-relative">
                        <div class="form-group mb-0">
                            <input type="search" class="form-control" id="exampleInputSearch" placeholder="Search" aria-controls="user-list-table">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="user-list-files d-flex">
                    <a class="bg-primary" href="javascript:void();">
                        Print
                    </a>
                    <a class="bg-primary" href="javascript:void();">
                        Excel
                    </a>
                    <a class="bg-primary" href="javascript:void();">
                        Pdf
                    </a>
                </div>
            </div> -->
        </div>
        <div class="table-responsive pb-3">
            <table id="user-list-table" class="table table-striped table-bordered mt-4 data-tables" role="grid" aria-describedby="user-list-page-info">
                <thead>
                    <tr>
                        <th scope="col">Type</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>

                </thead>
                <tbody>
                    <!-- <tr>
                        <td class="text-center"><img class="rounded img-fluid avatar-40" src="../assets/images/user/05.jpg" alt="profile"></td>
                        <td>Lynn Guini</td>
                        <td>+27 2563 456 589</td>
                        <td>
                            <div class="flex align-items-center list-user-action">
                                <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add" href="#"><i class="ri-user-add-line"></i></a>
                                <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#"><i class="ri-pencil-line"></i></a>
                                <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i class="ri-delete-bin-line"></i></a>
                            </div>
                        </td>

                    </tr> -->
                    <?php foreach ($pro_type as $row) : ?>
                        <tr>
                            <td><?= $row->type ?></td>
                            <td><?= $row->status ?></td>
                            <td>
                                <div class="flex align-items-center list-user-action">
                                    <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#"><i class="ri-pencil-line"></i></a>
                                    <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i class="ri-delete-bin-line"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <!-- <div class="row justify-content-between mt-3">
            <div id="user-list-page-info" class="col-md-6">
                <span>Showing 1 to 5 of 5 entries</span>
            </div>
            <div class="col-md-6">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div> -->
    </div>
</div>

<?= $this->endSection() ?>