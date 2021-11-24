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
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <img class="card-img-top" src="images/uniqie.png" alt="..." />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder small">Skyblock Island</h5>
                                <!-- Product price-->
                                Rp10.000
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer row justify-content-center p-4 pt-0 border-top-0 bg-transparent">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="<?= (session()->get('logged_in') != true ? '#loginModal' : '#exampleModal'); ?>">Order
                            </button>
                        </div>
                    </div>
                </div>
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
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <img class="card-img-top" src="images/uniqie.png" alt="..." />
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Nama Logo *</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" placeholder="contoh: uniqie">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Email *</label>
                    <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="email@email.com">
                </div>
                <label for="formGroupExampleInput2" class="form-label">Pembayaran</label>
                <select class="form-select" aria-label="Default select example">
                    <option selected>Bank BCA (VA)</option>
                    <option value="1">Bank BRI (VA)</option>
                    <option value="2">Bank BNI (VA)</option>
                    <option value="3">Bank Mandiri (VA)</option>
                    <option value="4">Alfamart</option>
                    <option value="5">Alfamidi</option>
                    <option value="6">Indomaret</option>
                    <option value="7">OVO (Cash/Point)</option>
                    <option value="8">QRIS</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #1062fe">Close</button>
                <button type="button" class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">Checkout</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Checkout End-->

<!-- Modal Confirm Start-->
<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel2">Konfirmasi pesanan anda</h5>
            </div>
            <div class="modal-body">
                <label for="formGroupExampleInput" class="form-label">Nama Logo *</label>
                <div class="alert alert-primary" role="alert">
                    Uniqie
                </div>
                <label for="formGroupExampleInput" class="form-label">Email *</label>
                <div class="alert alert-primary" role="alert">
                    uniqiegraph@gmail.com
                </div>
                <label for="formGroupExampleInput" class="form-label">Pembayaran</label>
                <div class="alert alert-primary" role="alert">
                    Alfamart
                </div>
                <p class="small bold-red">Catatan:</p>
                <p class="small">Dengan mengklik konfirmasi, Anda mengonfirmasi bahwa informasi yang dimasukkan sudah benar.
                    Tidak ada pengembalian uang yang akan diberikan jika Anda salah memasukkan teks atau email sendiri.</p><br>
                <div class="alert alert-success" role="alert">
                    <p class="small">* Dikirim kepada Anda dalam waktu kurang dari 24 jam.</p>
                    <hr>
                    <p class="small">* Teks kustom Anda ditambahkan.</p>
                    <hr>
                    <p class="small">* Gambar PNG ukuran penuh dengan latar belakang transparan.</p>
                    <hr>
                    <p class="small">* Penghapusan Watermark.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #1062fe">Close</button>
                <button type="button" class="btn btn-primary" data-bs-target="#exampleModalToggle3" data-bs-toggle="modal" data-bs-dismiss="modal">Konfirmasi</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Confirm End-->

<!-- Modal Payment Start -->
<div class="modal fade" id="exampleModalToggle3" aria-hidden="true" aria-labelledby="exampleModalToggleLabel3" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel3">Pembayaran</h5>
            </div>
            <div class="modal-body">
                <table class="table table-sm">
                    <tbody>
                        <img src="images/payment/bca.png" class="rounded mx-auto d-block">
                        <tr>
                            <td>Batas Pembayaran</td>
                            <td>14 November 2021</td>
                            <td>12:00 WIB</td>
                        </tr>
                        <tr>
                            <td>Nomor VA</td>
                            <td>4325562672373</td>
                            <td><button class="btn btn-primary">Copy</button></td>
                        </tr>
                        <tr>
                            <td>Total Biaya</td>
                            <td>Rp. 10.000</td>
                            <td><button class="btn btn-primary">Copy</button></td>
                        </tr>
                    </tbody>
                </table>
                <div class="alert alert-warning" role="alert">
                    Pastikan anda melakukan pembayaran sebelum melewati batas pembayaran dan dengan nominal yang tepat.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #1062fe">Close</button>
                <button type="button" class="btn btn-success" data-bs-target="#exampleModalToggle4" data-bs-toggle="modal" data-bs-dismiss="modal">Cara Pembayaran</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Payment End-->

<!-- Modal Tutorial Start -->
<div class="modal fade" id="exampleModalToggle4" aria-hidden="true" aria-labelledby="exampleModalToggleLabel4" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalToggleLabel4">Petunjuk Pembayaran</h6>
            </div>
            <div class="modal-body">
                <div class="alert alert-primary" role="alert">
                    <h6 class="alert-heading">Via BCA Mobile</h6>
                    <p class="small">1. Login pada aplikasi <strong>BCA Mobile</strong> </p>
                    <hr>
                    <p class="small">2. Pilih <strong>m-BCA</strong> masukan kode akses m-BCA</p>
                    <hr>
                    <p class="small">3. Pilih <strong>m-Transfer</strong></p>
                    <hr>
                    <p class="small">4. Pilih <strong>BCA Virtual Account</strong></p>
                    <hr>
                    <p class="small">5. Masukan Nomor VA <strong>(42131844219)</strong> lalu klik <strong>OK</strong></p>
                    <hr>
                    <p class="small">6. Konfirmasi no virtual account dan rekening pendebetan</p>
                    <hr>
                    <p class="small">7. Periksa kembali rincian pembayaran anda, lalu klik <strong>YA</strong></p>
                    <hr>
                    <p class="small">8. Masukan pin m-BCA</p>
                    <hr>
                    <p class="small">9. Pembayaran Selesai.</p>
                    <hr>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-target="#exampleModalToggle3" data-bs-toggle="modal" data-bs-dismiss="modal">Kembali</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Tutorial End-->
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
<?= $this->endSection(); ?>