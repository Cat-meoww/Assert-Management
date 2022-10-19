<!doctype html>
<html lang="en">

<?php
// $session = session();

$username = $session->username;
$firstname = $session->firstname;
$firstletter = $firstname[0];
$lastname = $session->lastname;
$email = $session->email;
$token = $session->token;
$user_role = $session->user_role;
$uri = service('uri', 'cookie');
set_cookie("APP_CHAT_TOKEN", $session->token, time() + 3600);
?>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?></title>
    <link rel="manifest" href="<?= base_url() ?>/manifest.webmanifest">
    <meta name="theme-color" content="#6c71e3" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/favicon.png" />

    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/backend.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/%40fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/remixicon/fonts/remixicon.css">

    <!-- Viewer Plugin -->
    <!--PDF-->
    <!-- <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/doc-viewer/include/pdf/pdf.viewer.css"> -->
    <!--Docs-->
    <!--PPTX-->
    <!-- <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/doc-viewer/include/PPTXjs/css/pptxjs.css"> -->
    <!-- <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/doc-viewer/include/PPTXjs/css/nv.d3.min.css"> -->
    <!--All Spreadsheet -->
    <!-- <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/doc-viewer/include/SheetJS/handsontable.full.min.css"> -->
    <!--Image viewer-->
    <!-- <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/doc-viewer/include/verySimpleImageViewer/css/jquery.verySimpleImageViewer.css"> -->
    <!--officeToHtml-->
    <!-- <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/doc-viewer/include/officeToHtml/officeToHtml.css"> -->
    <script src="<?= base_url() ?>/assets/js/backend-bundle.min.js"></script>
</head>

<body class=" color-light ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">

        <div class="iq-sidebar  sidebar-default ">
            <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
                <a href="index.html" class="header-logo">
                    <img src="<?= base_url() ?>/assets/images/logo.png" class="img-fluid rounded-normal light-logo" alt="logo">
                    <img src="<?= base_url() ?>/assets/images/logo-white.png" class="img-fluid rounded-normal darkmode-logo" alt="logo">
                </a>
                <div class="iq-menu-bt-sidebar">
                    <i class="las la-bars wrapper-menu"></i>
                </div>
            </div>
            <?php include_once 'sidebar/rolebar.php'; ?>

        </div>
        <div class="iq-top-navbar">
            <div class="iq-navbar-custom">
                <nav class="navbar navbar-expand-lg navbar-light p-0">
                    <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                        <i class="ri-menu-line wrapper-menu"></i>
                        <a href="index.html" class="header-logo">
                            <img src="<?= base_url() ?>/assets/images/logo.png" class="img-fluid rounded-normal light-logo" alt="logo">
                            <img src="<?= base_url() ?>/assets/images/logo-white.png" class="img-fluid rounded-normal darkmode-logo" alt="logo">
                        </a>
                    </div>
                    <div class="iq-search-bar device-search">

                        <form>
                            <div class="input-prepend input-append">
                                <div class="btn-group">
                                    <label class="dropdown-toggle searchbox" data-toggle="dropdown">
                                        <input class="dropdown-toggle search-query text search-input" type="text" placeholder="Type here to search..."><span class="search-replace"></span>
                                        <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                                        <span class="caret">
                                            <!--icon-->
                                        </span>
                                    </label>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">
                                                <div class="item"><i class="far fa-file-pdf bg-info"></i>PDFs</div>
                                            </a></li>
                                        <li><a href="#">
                                                <div class="item"><i class="far fa-file-alt bg-primary"></i>Documents
                                                </div>
                                            </a></li>
                                        <li><a href="#">
                                                <div class="item"><i class="far fa-file-excel bg-success"></i>Spreadsheet</div>
                                            </a></li>
                                        <li><a href="#">
                                                <div class="item"><i class="far fa-file-powerpoint bg-danger"></i>Presentation</div>
                                            </a></li>
                                        <li><a href="#">
                                                <div class="item"><i class="far fa-file-image bg-warning"></i>Photos &
                                                    Images</div>
                                            </a></li>
                                        <li><a href="#">
                                                <div class="item"><i class="far fa-file-video bg-info"></i>Videos</div>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="change-mode">
                            <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                                <div class="custom-switch-inner">
                                    <p class="mb-0"> </p>
                                    <input type="checkbox" class="custom-control-input" id="dark-mode" data-active="true">
                                    <label class="custom-control-label" for="dark-mode" data-mode="toggle">
                                        <span class="switch-icon-left"><i class="a-left"></i></span>
                                        <span class="switch-icon-right"><i class="a-right"></i></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-label="Toggle navigation">
                            <i class="ri-menu-3-line"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto navbar-list align-items-center">
                                <li class="nav-item nav-icon search-content">
                                    <a href="#" class="search-toggle rounded" id="dropdownSearch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ri-search-line"></i>
                                    </a>
                                    <div class="iq-search-bar iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownSearch">
                                        <form action="#" class="searchbox p-2">
                                            <div class="form-group mb-0 position-relative">
                                                <input type="text" class="text search-input font-size-12" placeholder="type here to search...">
                                                <a href="#" class="search-link"><i class="las la-search"></i></a>
                                            </div>
                                        </form>
                                    </div>
                                </li>
                                <li class="nav-item nav-icon dropdown">
                                    <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ri-question-line"></i>
                                    </a>
                                    <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton01">
                                        <div class="card shadow-none m-0">
                                            <div class="card-body p-0 ">
                                                <div class="p-3">
                                                    <a href="#" class="iq-sub-card pt-0"><i class="ri-questionnaire-line"></i>Help</a>
                                                    <a href="#" class="iq-sub-card"><i class="ri-recycle-line"></i>Training</a>
                                                    <a href="#" class="iq-sub-card"><i class="ri-refresh-line"></i>Updates</a>
                                                    <a href="#" class="iq-sub-card"><i class="ri-service-line"></i>Terms
                                                        and Policy</a>
                                                    <a href="#" class="iq-sub-card"><i class="ri-feedback-line"></i>Send
                                                        Feedback</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item nav-icon dropdown">
                                    <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ri-settings-3-line"></i>
                                    </a>
                                    <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton02">
                                        <div class="card shadow-none m-0">
                                            <div class="card-body p-0 ">
                                                <div class="p-3">
                                                    <a href="#" class="iq-sub-card pt-0"><i class="ri-settings-3-line"></i> Settings</a>
                                                    <a href="#" class="iq-sub-card"><i class="ri-hard-drive-line"></i>
                                                        Get Drive for desktop</a>
                                                    <a href="#" id="idledetector" class="iq-sub-card"><i class="ri-hard-drive-line"></i>
                                                        Idle Detector</a>
                                                    <a href="#" class="iq-sub-card"><i class="ri-keyboard-line"></i>
                                                        Keyboard Shortcuts</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item nav-icon dropdown caption-content">
                                    <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <div class="caption bg-primary line-height text-capitalize"><?= $firstletter ?></div>
                                    </a>
                                    <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton03">
                                        <div class="card mb-0">
                                            <div class="card-header d-flex justify-content-between align-items-center mb-0">
                                                <div class="header-title">
                                                    <h4 class="card-title mb-0">Profile</h4>
                                                </div>
                                                <div class="close-data text-right badge badge-primary cursor-pointer ">
                                                    <i class="ri-close-fill"></i>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="profile-header">
                                                    <div class="cover-container text-center">
                                                        <div class="rounded-circle profile-icon bg-primary mx-auto d-block text-capitalize">
                                                            <?= $firstletter ?>
                                                            <a href="#">

                                                            </a>
                                                        </div>
                                                        <div class="profile-detail mt-3">
                                                            <h5><a href="https://templates.iqonic.design/cloudbox/html/app/user-profile-edit.html"><?= $username ?></a></h5>
                                                            <p><?= $email ?></p>
                                                        </div>
                                                        <a href="<?= base_url('auth/logout') ?>" id="appsignout" class="btn btn-primary">Sign Out</a>
                                                    </div>
                                                    <div class="profile-details mt-4 pt-4 border-top">
                                                        <div class="media align-items-center mb-3">
                                                            <div class="rounded-circle iq-card-icon-small bg-primary">
                                                                A
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <div class="media justify-content-between">
                                                                    <h6 class="mb-0">Anna Mull</h6>
                                                                    <p class="mb-0 font-size-12"><i>Signed Out</i></p>
                                                                </div>
                                                                <p class="mb-0 font-size-12">annamull@gmail.com</p>
                                                            </div>
                                                        </div>
                                                        <div class="media align-items-center mb-3">
                                                            <div class="rounded-circle iq-card-icon-small bg-success">
                                                                K
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <div class="media justify-content-between">
                                                                    <h6 class="mb-0">King Poilin</h6>
                                                                    <p class="mb-0 font-size-12"><i>Signed Out</i></p>
                                                                </div>
                                                                <p class="mb-0 font-size-12">kingpoilin@gmail.com</p>
                                                            </div>
                                                        </div>
                                                        <div class="media align-items-center">
                                                            <div class="rounded-circle iq-card-icon-small bg-danger">
                                                                D
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <div class="media justify-content-between">
                                                                    <h6 class="mb-0">Devid Worner</h6>
                                                                    <p class="mb-0 font-size-12"><i>Signed Out</i></p>
                                                                </div>
                                                                <p class="mb-0 font-size-12">devidworner@gmail.com</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="content-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <?= $this->renderSection('content') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Dynamic alerts -->
    <script>
        $(document).ready(function() {
            <?php
            $alert_data = $session->getFlashdata('alert');
            if (is_array($alert_data)) {
                foreach ($alert_data as  $value) {
                    if (is_array($value)) {
                    } else {
                        echo "toastr.success('$value');";
                    }
                }
            } else {
                echo "toastr.success('$alert_data');";
            }
            ?>
        });
    </script>
    <!-- Wrapper End-->
    <footer class="iq-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="privacy-policy.html">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href="terms-of-service.html">Terms of Use</a></li>
                    </ul>
                </div>
                <div class="col-lg-6 text-right">
                    Copyright 2020 <a href="#">CloudBOX</a> All Rights Reserved.
                </div>
            </div>
        </div>
    </footer>
    <!-- Backend Bundle JavaScript -->
    <!-- <script src="<?= base_url() ?>/assets/js/backend-bundle.min.js"></script> -->
    <script src="<?= base_url() ?>/assets/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/dataTables.bootstrap4.min.js"></script>

    <!-- Chart Custom JavaScript -->
    <script src="<?= base_url() ?>/assets/js/customizer.js"></script>

    <!-- Chart Custom JavaScript -->
    <script src="<?= base_url() ?>/assets/js/chart-custom.js"></script>
    <!-- toaster JavaScript -->
    <script src="<?= base_url() ?>/assets/js/toast/toastr.js"></script>
    <!-- <link rel="stylesheet" href="<?= base_url() ?>/assets/js/toast/build/toastr.css"> -->

    <!--PDF-->
    <!-- <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/pdf/pdf.js"></script> -->
    <!--Docs-->
    <!-- <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/docx/jszip-utils.js"></script> -->
    <!-- <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/docx/mammoth.browser.min.js"></script> -->
    <!--PPTX-->
    <!-- <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/PPTXjs/js/filereader.js"></script> -->
    <!-- <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/PPTXjs/js/d3.min.js"></script> -->
    <!-- <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/PPTXjs/js/nv.d3.min.js"></script> -->
    <!-- <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/PPTXjs/js/pptxjs.js"></script> -->
    <!-- <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/PPTXjs/js/divs2slides.js"></script> -->
    <!--All Spreadsheet -->
    <!-- <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/SheetJS/handsontable.full.min.js"></script> -->
    <!-- <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/SheetJS/xlsx.full.min.js"></script> -->
    <!--Image viewer-->
    <!-- <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/verySimpleImageViewer/js/jquery.verySimpleImageViewer.js"></script> -->
    <!--officeToHtml-->
    <!-- <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/officeToHtml/officeToHtml.js"></script> -->
    <!-- <script src="<?= base_url() ?>/assets/js/doc-viewer.js"></script> -->
    <!-- app JavaScript -->
    <script src="<?= base_url() ?>/assets/js/app.js"></script>
    <?php $uri = new \CodeIgniter\HTTP\URI(base_url()); ?>
    <script defer id="set-worker" src="<?= base_url() ?>/assets/js/Workers/app.js?PATH=<?= $uri->getPath() ?>"></script>
    <script defer id="shared-worker" src="<?= base_url() ?>/assets/js/Workers/shared-interface.js?PATH=<?= $uri->getPath() ?>"></script>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Title</h4>
                    <div>
                        <a class="btn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                </div>
                <div class="modal-body">
                    <div id="resolte-contaniner" style="height: 500px;" class="overflow-auto">
                        File not found
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<!-- Mirrored from templates.iqonic.design/cloudbox/html/backend/pages-blank-page.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 15 May 2022 05:55:51 GMT -->

</html>