<?= $this->extend('template/admin/template'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Reference</th>
                            <th>Merchant ref</th>
                            <th>Produk</th>
                            <th>Status</th>
                            <th style="text-align: center; vertical-align: middle;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nomor = 1 + $startno;
                        ?>
                        <?php foreach ($transaksi as $i) : ?>
                            <tr>
                                <?php
                                $id = $i['id'];
                                $ref = $i['merchant_ref'];
                                ?>
                                <td style="text-align: center; vertical-align: middle;"><?= $nomor++ ?></td>
                                <td><?= $i['reference']; ?></td>
                                <td><?= $ref; ?></td>
                                <td><?= ceknamaproduk($i['produk']); ?></td>
                                <td>
                                    <?php
                                    if ($i['status'] == 'UNPAID') {
                                        echo 'Menunggu pembayaran';
                                    } elseif ($i['status'] == 'PAID' && $i['selesai'] == 'no') {
                                        echo 'Menunggu dikirim';
                                    } elseif ($i['status'] == 'PAID' && $i['selesai'] == 'yes') {
                                        echo 'Transaksi selesai';
                                    } else {
                                        echo $i['status'];
                                    }
                                    ?>
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <a href="<?= base_url("admin/transaksi/$ref"); ?>">
                                        <button class="btn btn-success">Detail</button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <br>
                <div class="d-flex justify-content-center">
                    <?= $pager->links('transaksi', 'halaman'); ?>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('sukses')) : ?>
    <?php
    $flash = session()->getFlashdata('sukses');
    $pesan = $flash['pesan'];
    $value = $flash['value'];
    ?>
    <script type="text/javascript">
        var pesan = '<?= $pesan ?>';
        var value = '<?= $value ?>';
        let timerInterval
        Swal.fire({
            icon: 'success',
            title: pesan,
            html: value,
            timer: 3000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                timerInterval = setInterval(() => 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {}
        })
    </script>
<?php endif; ?>


<!-- /.container-fluid -->
<?= $this->endSection(); ?>