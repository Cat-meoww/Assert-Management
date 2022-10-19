<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between welcome-content mb-3">
    <div class="navbar-breadcrumb">
        <h4 class="card-title">Ticket Titles</h4>
    </div>
    <div class="d-flex align-items-center">

        <div class="dashboard1-dropdown d-flex align-items-center">
            <div class="dashboard1-info rounded" data-toggle="tooltip" data-placement="top" title="Create">
                <a href="#create" data-toggle="modal" data-target="#create-titles" role="button" aria-expanded="false">
                    <i class="ri-add-line "></i>
                </a>

            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="create-titles" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Ticket Titles (issues/else)</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="allmasterform" action=" <?= base_url('all-master-save/' . $uri->getSegment(2)) ?>" autocomplete="off" class="needs-validation">
                            <div class="form-row">
                                <div class="col-12 mb-3">
                                    <label for="Productty">Product Titles</label>
                                    <input type="text" name="ticket-title" class="form-control" id="in-ticket-title" maxlength="200" value="" autocomplete="off" required>
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
                                    $('#create-titles').modal('toggle');
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
        <div class="row justify-content-between">

        </div>
        <div class="table-responsive pb-3">
            <table id="user-list-table" class="table table-striped table-bordered mt-4 data-tables" role="grid" aria-describedby="user-list-page-info">
                <thead>
                    <tr>
                        <th scope="col">s.no</th>
                        <th scope="col">Title</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>

                </thead>
                <tbody>

                    <?php foreach ($ticket_titles as $row) : ?>
                        <tr>
                            <td><?= $row->id ?></td>
                            <td><?= $row->title ?></td>
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

    </div>
</div>
<?= $this->endSection(); ?>