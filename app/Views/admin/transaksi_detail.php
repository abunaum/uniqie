<?= $this->extend('template/admin/template'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <center>
                <div class="table-responsive m-b-40">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Info</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div class="col-md-4" style="padding-left: 0px;  padding-right: 0px;">
                                <img src="<?= base_url('images/produk') . '/' . $transaksi['gambar']; ?>" alt="gambar produk" class="img-responsive img-thumbnail">
                            </div>
                            <tr>
                                <td>Nama User</td>
                                <td><?= $transaksi['user_name']; ?></td>
                            </tr>
                            <tr>
                                <td>Reference</td>
                                <td><?= $transaksi['reference']; ?></td>
                            </tr>
                            <tr>
                                <td>Merchant Ref</td>
                                <td><?= $transaksi['merchant_ref']; ?></td>
                            </tr>
                            <tr>
                                <td>Channel Pembayaran</td>
                                <td><?= $transaksi['channel']; ?></td>
                            </tr>
                            <tr>
                                <td>Produk</td>
                                <td><?= $transaksi['nama_produk']; ?></td>
                            </tr>
                            <tr>
                                <td>Nama Logo</td>
                                <td><?= $transaksi['nama']; ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><?= $transaksi['email']; ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td><?= $transaksi['status']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <hr>
                </div>
            </center>
        </div>
    </div>
</div>

<!-- /.container-fluid -->
<?= $this->endSection(); ?>