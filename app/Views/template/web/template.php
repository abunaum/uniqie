<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>#1 Logo Art Design | 50+ Templates</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="Bootstrap Ecommerce" name="keywords">
  <meta content="Bootstrap Ecommerce" name="description">

  <!-- Favicon -->
  <link href="images/favicon.png" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">

  <!-- CSS Libraries -->
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

  <!-- CSS FILES -->
  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <link href="<?= base_url('css/bootstrap-icons.css') ?>" rel="stylesheet">

  <link rel="stylesheet" href="<?= base_url('css/icofont.min.css') ?>">

  <!-- Template Stylesheet -->
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

  <!-- Header Start -->

  <div class="container-xxl position-relative p-0">

    <header class="header_section">
      <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-lg px-4 px-lg-5 py-3 py-lg-0" style="background-color: #fff">
        <a href="<?= base_url() ?>" class="navbar-brand p-0">
          <img src="<?= base_url('images/header-logo.png') ?>" alt="Logo">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
          <span class="icofont-navigation-menu"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
          <div class="navbar-nav ms-auto py-0">
            <a href="<?= base_url('logo'); ?>" class="text-dark nav-item nav-link">Explore Logo</a>
            <a href="#" class="text-dark nav-item nav-link">Join Discord</a>
          </div>
          <?php if (session('logged_in') == true) : ?>
            <form class="d-flex py-3 py-lg-0">
              <div class="order-0 py-2 px-4 ms-3">
                <div data-bs-toggle="modal" data-bs-target="#akunModal">
                  <img src="<?= user()->profile; ?>" class="rounded-circle img-thumbnail" style="width: 3em;"> <?= user()->name; ?>
                </div>
              </div>
            </form>
          <?php else : ?>
            <form action="<?= base_url('authgoogle') ?>" method="post">
              <button type="submit" class="btn btn-primary rounded-pill order-0 py-2 px-4 ms-3">
                Login / Register
              </button>
            </form>
          <?php endif ?>
        </div>
      </nav>
    </header>

  </div>
  <!-- Header End -->

  <?php if (session('logged_in') == true) : ?>
    <!-- Full Screen Search Start -->
    <div class="modal fade" id="akunModal" tabindex="-1">
      <div class="modal-dialog modal-fullscreen">
        <div class="modal-content" style="background: rgba(29, 40, 51, 0.8);">
          <div class="modal-header border-0">
            <button type="button" class="text-white btn-primary btn bg-blue btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-circle"></i></button>
          </div>
          <div class="modal-body d-flex align-items-center justify-content-center row">
            <div class="card text-white mb-3" style="max-width: 50rem;">
              <div class="card-header">
                <center>
                  <img src="<?= user()->profile; ?>" class="rounded-circle img-thumbnail" style="width: 10em;">
                  <h4 class="card-title"><?= user()->name; ?></h4>
                  <h5 class="card-title"><?= user()->email; ?></h5>
                </center>
              </div>
              <div class="card-body">
                <center>
                  <hr>
                  <a href="<?= base_url('user/transaksi'); ?>">
                    <button class="btn btn-primary btn-lg rounded-pill">Transaksi</button>
                  </a>
                  <a href="<?= base_url('logout'); ?>">
                    <button class="btn btn-danger btn-lg rounded-pill d-inline">Logout</button>
                  </a>
                  <hr>
                </center>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Full Screen Search End -->
  <?php endif; ?>

  <!-- Slider Hero Start -->


  <?= $this->renderSection('content'); ?>
  <!-- Faq Start -->

  <!-- Footer Start-->
  <footer class="text-center shadow-lg">
    <!-- Copyright -->
    <div class="text-white text-center p-3 shadow-lg" style="background-color: #1062fe"> © <?= date('Y') ?> Copyright
      <a class="text-white small" href="<?= base_url() ?>"><?= $_SERVER['SERVER_NAME'] ?></a>
    </div>
    <!-- Copyright -->

  </footer>
  <!-- Footer End-->

  <!-- JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="<?= base_url('js/custom.js') ?>"></script>

</body>

</html>