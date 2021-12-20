<?= $this->extend('template/web/template'); ?>
<?= $this->section('content'); ?>
<!-- Terms Start -->
<div class="container">

    <section class="shop-area shop-bg">
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="shop-content text-center">
                    <p class="text-center" style="padding-bottom: 15px" ;><small class="text-muted" ;>Kategori unggulan logo kami</small></p>
                    <?php if (kategori()) : ?>
                        <?php $kategori = kategori() ?>
                        <?php foreach ($kategori as $k) : ?>
                            <a class="btn btn-primary" href="<?= base_url('kategori/' . $k['id']); ?>" role="button"><?= $k['nama']; ?></a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

</div>
<!-- Timeline End-->

<!-- Logo Start -->
<div class="container">
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-10 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php if (produk()) : ?>
                    <?php $produk = produk() ?>
                    <?php foreach ($produk as $p) : ?>
                        <div class="col mb-5">
                            <div class="card h-100">
                                <!-- Product image-->
                                <img class="card-img-top" src="<?= base_url('images/produk/' . $p['gambar']); ?>" />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder small"><?= $p['nama']; ?></h5>
                                        <!-- Product price-->
                                        <?= number_to_currency($p['harga'], 'idr'); ?>
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer row justify-content-center p-4 pt-0 border-top-0 bg-transparent">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="<?= (session()->get('logged_in') != true ? '#loginModal' : '#orderModal' . $p['id']); ?>">Order
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

</div>
<!-- Logo End-->

<!-- Modal Login -->
<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Login ?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3>Harap login sebelum order</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="<?= base_url('authgoogle') ?>" method="post" class="d-inline">
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Checkout Start-->
<?php if (ceklogin() == true) : ?>
    <?php if (produk()) : ?>
        <?php $produk = produk() ?>
        <?php foreach ($produk as $p) : ?>
            <?php $id = $p['id']; ?>
            <div class="modal fade" id="orderModal<?= $p['id']; ?>" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <img class="img-thumbnail img-responsive" style="max-width:50%;" src="<?= base_url('images/produk/' . $p['gambar']); ?>" />
                            </center>
                        </div>
                        <div class="modal-body">
                            <form id="form-checkout-id<?= $id; ?>" action="<?= base_url('checkout'); ?>" method="post">
                                <?= csrf_field() ?>
                                <input type="hidden" class="form-control" id="id" name="id" value="<?= $p['id']; ?>">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Logo *</label>
                                    <input type="text" class="form-control <?= ($validation->hasError('nama') ? 'is-invalid' : ''); ?>" value="<?= old('nama'); ?>" id="nama" placeholder="contoh: uniqie" name="nama">
                                </div>
                                <div class="mb-3">
                                    <?php
                                    $oldemail = old('email');
                                    ?>
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control <?= ($validation->hasError('email') ? 'is-invalid' : ''); ?>" id="email" name="email" placeholder="email@email.com" value="<?= ($oldemail ? $oldemail : user()->email); ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="formGroupExampleInput2" class="form-label">Pembayaran</label>
                                    <select class="form-select <?= ($validation->hasError('channel') ? 'is-invalid' : ''); ?>" id="channel" name="channel" aria-label="Default select example" onchange="run(this,'<?= $id; ?>')">
                                        <option value="">Pilih Channel pembayaran</option>
                                        <?php if (channel()) : ?>
                                            <?php $channel = channelactive() ?>
                                            <?php foreach ($channel as $c) : ?>
                                                <option value="<?= $c['kode']; ?>"><?= $c['nama']; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="mb-3" id="ovoinput<?= $id; ?>" style="display:none;">
                                    <label for="ovo" class="form-label">Nomor OVO</label>
                                    <input type="number" class="form-control d-inline <?= ($validation->hasError('ovo') ? 'is-invalid' : ''); ?>" value="<?= old('ovo'); ?>" id="ovo" placeholder="081xxxxxxxxx" name="ovo" aria-describedby="nope">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #1062fe">Close</button>
                            <button type="button" class="btn btn-primary" onclick="checkout('<?= $id; ?>')">Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>
<!-- Modal Checkout End-->
<div class="container">
    <div class="page-navigation">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul>
                        <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                        <li class="current-page"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function run(c, id) {
        var channel = (c.value || c.options[c.selectedIndex].value);
        console.log(channel);
        if (channel == 'OVO') {
            document.getElementById('ovoinput' + id).style.display = 'block';
        } else {
            document.getElementById('ovoinput' + id).style.display = 'none';
        }
    }

    function checkout(id) {
        document.getElementById("form-checkout-id" + id).submit();
    }
</script>

<?php if (session()->getFlashdata('error')) : ?>
    <?php
    $error = session()->getFlashdata('error');
    $pesan = $error['pesan'];
    $value = $error['value'];
    $id = $error['id'];
    $keterangan = implode("<br>[x] ", $value);
    ?>
    <script type="text/javascript">
        var pesan = '<?= $pesan ?>';
        var id = '<?= $id ?>';
        var error = '<?= $keterangan ?>';
        Swal.fire({
            title: pesan,
            html: '[x]' + error,
            icon: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Coba lagi ?'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#orderModal' + id).modal('show');
            }
        })
    </script>
<?php endif; ?>

<?= $this->endSection(); ?>