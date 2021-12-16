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
                                <td>Batas Pembayaran</td>
                                <?php

                                use CodeIgniter\I18n\Time; ?>
                                <td><?= Time::createFromTimestamp($payment['expired_time'], 'Asia/Jakarta', 'id_ID'); ?> WIB</td>
                            </tr>
                            <tr>
                                <td>Nomor VA</td>
                                <td>4325562672373</td>
                            </tr>
                            <tr>
                                <td>Total Biaya</td>
                                <td><?= number_to_currency($payment['amount'], 'IDR') ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="alert alert-warning" role="alert">
                        Pastikan anda melakukan pembayaran sebelum melewati batas pembayaran dan dengan nominal yang tepat.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #1062fe">Close</button>
                    <button type="button" class="btn btn-success" data-bs-target="#orderModalToggle4" data-bs-toggle="modal" data-bs-dismiss="modal">Cara Pembayaran</button>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>