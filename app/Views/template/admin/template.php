<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Admin UNIQUE">
    <meta name="author" content="Abunaum">

    <!-- Title Page-->
    <title><?= $judul; ?></title>

    <!-- Fontfaces CSS-->
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/css/font-face.css" rel="stylesheet" media="all">
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/font-awesome-5.15/css/all.css" rel="stylesheet" media="all">
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" media="all">
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/css/theme.css" rel="stylesheet" media="all">
    <link rel="shortcut icon" href="<?= base_url('images/favicon.ico') ?>">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" id="theme-styles">
</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="<?= base_url('admin'); ?>">
                            <img src="<?= base_url('images/header-logo.png'); ?>" alt="Abunaum" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <?= $this->include('template/admin/navbar') ?>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <?= $this->include('template/admin/sidebar') ?>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <?= $this->include('template/admin/headerdekstop') ?>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <?= $this->renderSection('content'); ?>
            <!-- END MAIN CONTENT-->
            <div class="row">
                <div class="col-md-12">
                    <div class="copyright">
                        <p>Copyright © <?= date('Y') ?> <?= $_SERVER['HTTP_HOST'] ?>. All rights reserved. Template by <a href="https://facebook.com/ahmad.yani.ardath">Abunaum</a>.</p>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- Vendor JS       -->
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/slick/slick.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/wow/wow.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/animsition/animsition.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/circle-progress/circle-progress.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/js/main.js"></script>
    <!-- Extra JS Gua-->
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <script src="<?= base_url('js/currency.js') ?>"></script>
    <script>
        var conn = new WebSocket('ws://localhost:5051');
        conn.onopen = function(e) {
            console.log("Connection established!");
        };

        conn.onmessage = function(e) {
            console.log(e.data);
        };
    </script>
    <?php
    if (session()->getFlashdata('websocket')) :
        $data = session()->getFlashdata('websocket');
    ?>
        <script>
            var conn = new WebSocket('ws://localhost:5051');
            conn.onopen = function(e) {
                conn.send('<?= $data; ?>');
            };

            conn.onmessage = function(e) {
                console.log(e.data);
            };
        </script>
    <?php endif; ?>

</body>

</html>
<!-- end document-->