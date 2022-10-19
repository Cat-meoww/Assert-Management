<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between welcome-content mb-3">
    <div class="navbar-breadcrumb">
        <h4 class="card-title">User Creation</h4>
    </div>
    <div class="d-flex align-items-center">

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
                        <h5 class="modal-title">Create User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="allmasterform" action=" <?= base_url('all-master-save/' . $uri->getSegment(2)) ?>" autocomplete="off" class="needs-validation">
                            <div class="form-row">
                                <div class="col-4 mb-3">
                                    <label for="Productty">Username</label>
                                    <input type="text" name="Username" class="form-control" id="Username" value="" autocomplete="off" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-4 mb-3">
                                    <label for="Firstname">First Name</label>
                                    <input type="text" name="Firstname" class="form-control" id="Firstname" value="" autocomplete="off" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-4 mb-3">
                                    <label for="Lastname">Last Name</label>
                                    <input type="text" name="Lastname" class="form-control" id="Lastname" value="" autocomplete="off" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="Mailid">Mail Id</label>
                                    <input type="email" name="Mailid" class="form-control" id="Mailid" value="" autocomplete="off" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="Userrole">User Role</label>
                                    <select name="Userrole" class="form-control" id="Userrole">
                                        <option value="maintainer">Maintainer</option>
                                        <option value="employee">Employee</option>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="Passwordcreate">Password</label>
                                    <input type="password" name="Password" class="form-control" id="Passwordcreate" autocomplete="off" required>
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
                                        method: 'POST',
                                        mode: 'cors',
                                        cache: 'no-cache',
                                        credentials: 'same-origin',
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
                                        $("#allmasterform").trigger('reset');
                                        call_datatable();
                                        //$("#allmasterform")[0].reset();

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
                                            url: '<?= base_url("api/admin/show-users") ?>',
                                            type: "POST",
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

                </div>
            </div>
        </div>

    </div>
</div>
<div class="card">

    <div class="card-body">

        <div class="table-responsive pb-3">
            <table id="ss-datatable" class="table table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
                <thead>
                    <tr>
                        <th scope="col">User Name</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Mail_id</th>
                    </tr>

                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>