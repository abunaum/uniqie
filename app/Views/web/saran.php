<?= $this->extend('template/web/template'); ?>
<?= $this->section('content'); ?>
<!-- Start -->
<div class="container">

    <section class="other_section layout_padding">
        <div class="container-fluid  ">
            <div class="row">
                <div class="col-md-12">
                    <div class="detail-box">
                        <center>
                            <div class="heading_container mb-3">
                                <h2>
                                    Kritik dan Saran
                                </h2>
                            </div>
                            <form action="" method="post">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Alamat Email</label>
                                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" placeholder="Nama Anda">
                                </div>
                                <div class="mb-3">
                                    <label for="kritik" class="form-label">Kritik</label>
                                    <textarea class="form-control" id="kritik" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="saran" class="form-label">Saran</label>
                                    <textarea class="form-control" id="saran" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn-success">Kirim</button>
                            </form>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<!-- Timeline End-->

<div class="container">

    <!-- Section: Links -->
    <section class="mt-5">

        <!-- Grid row-->
        <div class="row text-center d-flex justify-content-center pt-5">

            <!-- Grid column -->
            <div class="col-md-3">
                <h6 class="text-capitalize font-weight-normal">
                    <a href="mailto:uniqiegraph@gmail.com" class="text-dark small">Kontak</a>
                </h6>
            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-3">
                <h6 class="text-capitalize font-weight-normal">
                    <a href="<?= base_url('layanan') ?>" class="text-dark small">Ketentuan Layanan</a>
                </h6>
            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-3">
                <h6 class="text-capitalize font-weight-normal">
                    <a href="<?= base_url('privasi') ?>" class="text-dark small">Kebijakan Privasi</a>
                </h6>
            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-3">
                <h6 class="text-capitalize font-weight-normal">
                    <a href="<?= base_url('saran') ?>" class="text-dark small">Kritik Dan Saran</a>
                </h6>
            </div>
            <!-- Grid column -->

        </div>
        <!-- Grid row-->
    </section>

    <!-- Section: Links -->
    <hr class="my-5" />

    <!-- Section: Text -->
    <section class="mb-5">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <p class="small">
                    Uniqie adalah sebuah platform desain grafis yang berfokus pada pembuatan logo, Kami menyediakan logo untuk game, toko online, atau proyek apapun. Kami berdedikasi untuk mempermudah memesan sebuah karya seni dengan cepat.
                </p>
            </div>
        </div>
    </section>
    <!-- Section: Text -->
</div>
<!-- End of .container -->
<!-- <?= $this->endSection(); ?> -->