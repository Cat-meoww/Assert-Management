<!doctype html>
<html lang="en">

<!-- Mirrored from templates.iqonic.design/cloudbox/html/backend/auth-sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 15 May 2022 05:55:49 GMT -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>AssertBOX | Sign In</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="https://templates.iqonic.design/cloudbox/html/assets/images/favicon.ico" />

    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/backend.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/%40fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/remixicon/fonts/remixicon.css">

    <!-- Viewer Plugin -->
    <!--PDF-->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/doc-viewer/include/pdf/pdf.viewer.css">
    <!--Docs-->
    <!--PPTX-->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/doc-viewer/include/PPTXjs/css/pptxjs.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/doc-viewer/include/PPTXjs/css/nv.d3.min.css">
    <!--All Spreadsheet -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/doc-viewer/include/SheetJS/handsontable.full.min.css">
    <!--Image viewer-->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/doc-viewer/include/verySimpleImageViewer/css/jquery.verySimpleImageViewer.css">
    <!--officeToHtml-->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/doc-viewer/include/officeToHtml/officeToHtml.css">
</head>

<body class=" ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->

    <div class="wrapper">
        <section class="login-content">
            <div class="container h-100">
                <div class="row justify-content-center align-items-center height-self-center">
                    <div class="col-md-5 col-sm-12 col-12 align-self-center">
                        <div class="sign-user_card">
                            <img src="<?= base_url() ?>/assets/images/logo.png" class="img-fluid rounded-normal light-logo logo" alt="logo">
                            <img src="<?= base_url() ?>/assets/images/logo-white.png" class="img-fluid rounded-normal darkmode-logo logo" alt="logo">
                            <h3 class="mb-3">Sign In</h3>
                            <p>Login to stay connected.</p>
                            <?php if (isset($validation)) : ?>

                                <?= $validation->listErrors('alert-info-list') ?>


                            <?php endif; ?>

                            <form action="<?= base_url('auth/login/check') ?>" method="post">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="floating-label form-group">
                                            <input class="floating-input form-control" name="email" type="email" placeholder=" ">
                                            <label>Email</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="floating-label form-group">
                                            <input class="floating-input form-control" name="password" type="password" placeholder=" ">
                                            <label>Password</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="custom-control custom-checkbox mb-3 text-left">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">Remember Me</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="auth-recoverpw.html" class="text-primary float-right">Forgot Password?</a>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Sign In</button>
                                <p class="mt-3">
                                    Create an Account <a href="<?= base_url('auth/register') ?>" class="text-primary">Sign Up</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Backend Bundle JavaScript -->
    <script src="<?= base_url() ?>/assets/js/backend-bundle.min.js"></script>

    <!-- Chart Custom JavaScript -->
    <script src="<?= base_url() ?>/assets/js/customizer.js"></script>

    <!-- Chart Custom JavaScript -->
    <script src="<?= base_url() ?>/assets/js/chart-custom.js"></script>

    <!--PDF-->
    <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/pdf/pdf.js"></script>
    <!--Docs-->
    <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/docx/jszip-utils.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/docx/mammoth.browser.min.js"></script>
    <!--PPTX-->
    <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/PPTXjs/js/filereader.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/PPTXjs/js/d3.min.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/PPTXjs/js/nv.d3.min.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/PPTXjs/js/pptxjs.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/PPTXjs/js/divs2slides.js"></script>
    <!--All Spreadsheet -->
    <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/SheetJS/handsontable.full.min.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/SheetJS/xlsx.full.min.js"></script>
    <!--Image viewer-->
    <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/verySimpleImageViewer/js/jquery.verySimpleImageViewer.js"></script>
    <!--officeToHtml-->
    <script src="<?= base_url() ?>/assets/vendor/doc-viewer/include/officeToHtml/officeToHtml.js"></script>
    <script src="<?= base_url() ?>/assets/js/doc-viewer.js"></script>
    <!-- app JavaScript -->
    <script src="<?= base_url() ?>/assets/js/app.js"></script>
</body>

<!-- Mirrored from templates.iqonic.design/cloudbox/html/backend/auth-sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 15 May 2022 05:55:49 GMT -->

</html>