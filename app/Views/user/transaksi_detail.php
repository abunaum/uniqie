<?= $this->extend('template/web/template'); ?>
<?= $this->section('content'); ?>

<!-- Logo Start -->
<div class="container mt-3">
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalToggleLabel3">Pembayaran</h5>
                </div>
                <div class="modal-body">
                    <table class="table table-sm">
                        <tbody>
                            <img src="<?= 'https://tripay.co.id/images/payment-channel/' . $gambar; ?>" class="rounded mx-auto d-block">
                            <tr>
                                <td>Nama Logo</td>
                                <td><?= $transaksi['nama'] ?></td>
                            </tr>
                            <tr>
                                <td>Nama Produk</td>
                                <td><?= $transaksi['nama_produk'] ?></td>
                            </tr>
                            <tr>
                                <td>Metode Pembayaran</td>
                                <td><?= $transaksi['nama_channel'] ?></td>
                            </tr>
                            <hr>
                            <?php if ($type_channel == 'bank') : ?>
                                <tr>
                                    <td>Nomor VA</td>
                                    <td><?= $payment['pay_code']; ?></td>
                                </tr>
                            <?php elseif ($type_channel == 'toko') : ?>
                                <tr>
                                    <td>Kode Pembayaran</td>
                                    <td><?= $payment['pay_code']; ?></td>
                                </tr>
                            <?php elseif ($type_channel == 'ovo') : ?>
                                <tr>
                                    <td>Nomor OVO</td>
                                    <td><?= $transaksi['info']; ?></td>
                                </tr>
                            <?php else : ?>
                            <?php endif; ?>
                            <tr>
                                <td>Total Biaya</td>
                                <td><?= number_to_currency($payment['amount'], 'IDR') ?></td>
                            </tr>
                            <tr>
                                <td>Batas Pembayaran</td>
                                <td><?= $batas_waktu; ?> WIB</td>
                            </tr>
                        </tbody>
                    </table>
                    <?php if ($payment['status'] == 'UNPAID') : ?>
                        <div class="alert alert-warning" role="alert">
                            Pastikan anda melakukan pembayaran sebelum melewati batas pembayaran dan dengan nominal yang tepat.
                        </div>
                    <?php endif; ?>
                    <?php if ($payment['payment_method'] == 'OVO' && $payment['status'] == 'UNPAID') : ?>
                        <center>
                            <a href="<?= $payment['pay_url']; ?>" target="_blank" rel="noopener noreferrer">
                                <button class="btn btn-success" onclick="proccessOVO()">Bayar sekarang</button>
                            </a>
                        </center>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <a href="<?= base_url('user/transaksi'); ?>">
                        <button type="button" class="btn btn-secondary" style="background-color: #1062fe">Kembali ke list transaksi</button>
                    </a>
                    <button type="button" class="btn btn-success" data-bs-target="#bayarModal" data-bs-toggle="modal" data-bs-dismiss="modal">Cara Pembayaran</button>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="bayarModal" aria-hidden="true" aria-labelledby="bayarModalLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="bayarModalLabel">Petunjuk Pembayaran</h6>
            </div>
            <div class="modal-body">
                <div class="alert alert-primary" role="alert">
                    <?php foreach ($payment['instructions'] as $intruk) : ?>
                        <h6 class="alert-heading"><?= $intruk['title']; ?></h6>
                        <?php $i = 0; ?>
                        <?php foreach ($intruk['steps'] as $step) : ?>
                            <?php $i++; ?>
                            <p class="small"><?= $i; ?>. <?= $step; ?> </p>
                            <hr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>