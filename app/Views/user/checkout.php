<?= $this->extend('template/web/template'); ?>
<?= $this->section('content'); ?>

<!-- Logo Start -->
<div class="container mt-3">
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="modal-content">
                <form action="<?= base_url('user/transaksi') ;?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderModalToggleLabel2">Konfirmasi pesanan anda</h5>
                    </div>
                    <div class="modal-body">
                        <label for="formGroupExampleInput" class="form-label">Nama Logo</label>
                        <div class="alert alert-primary" role="alert">
                            <?= $nama; ?>
                            <input type="hidden" name="nama" value="<?= $nama; ?>" />
                        </div>
                        <label for="formGroupExampleInput" class="form-label">Email</label>
                        <div class="alert alert-primary" role="alert">
                            <?= $email; ?>
                            <input type="hidden" name="email" value="<?= $email; ?>" />
                        </div>
                        <label for="formGroupExampleInput" class="form-label">Nama Produk</label>
                        <div class="alert alert-primary" role="alert">
                            <input type="hidden" name="produk" value="<?= $produk['id']; ?>" />
                            <?= $produk['nama']; ?>
                        </div>
                        <label for="formGroupExampleInput" class="form-label">Pembayaran</label>
                        <div class="alert alert-primary" role="alert">
                            <?= $channel['nama']; ?>
                            <input type="hidden" name="channel" value="<?= $channel['kode']; ?>" />
                        </div>
                        <label for="formGroupExampleInput" class="form-label">Total bayar</label>
                        <div class="alert alert-primary" role="alert">
                            <?= number_to_currency($produk['harga'], 'IDR'); ?>
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
                        <button type="submit" class="btn btn-primary">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>