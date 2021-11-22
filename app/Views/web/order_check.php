<?= $this->extend('template/web/template'); ?>
<?= $this->section('content'); ?>
<!-- Start -->
<div class="container">
    <div class="cell cell-1 mb-3">Check Order</div>
    <section class="about_section layout_padding">
        <div class="container-fluid  ">
            <div class="row">
                <table class="table table-success table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Desc</th>
                            <th scope="col">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Kode</td>
                            <td><?= $order['kode']; ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Order</td>
                            <td><?= $order['nama_item']; ?></td>
                        </tr>
                        <tr>
                            <td>Nama Server</td>
                            <td><?= $order['nama_server']; ?></td>
                        </tr>
                        <tr>
                            <td>Text</td>
                            <td>
                                <?php
                                if ($order['text'] == '') {
                                    echo '-';
                                } else {
                                    echo $order['text'];
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Deskripsi</td>
                            <td>
                                <?php
                                if ($order['deskripsi'] == '') {
                                    echo '-';
                                } else {
                                    echo $order['deskripsi'];
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><?= $order['email']; ?></td>
                        </tr>
                        <tr>
                            <td>Harga</td>
                            <td>Rp.<?= number_format($order['harga']); ?></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td><?= $order['status']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php if ($order['status'] == 'UNPAID') : ?>
                <form action="" method="post" class="mb-3">
                    <?= csrf_field(); ?>
                    <div class="form-group mb-3">
                        <div class="cell cell-1 mb-3">Pilih Metode Pembayaran</div>
                        <select class="form-control" id="channel">
                            <?php foreach ($pembayaran as $channel) : ?>
                                <?php
                                $nama = $channel['code'];
                                $flat = $channel['flat'];
                                $percent = $channel['percent'];
                                $harga = $order['harga'];
                                $harganopercent = $harga + $flat;
                                $hargapercent = $harga * $percent / 100;
                                ?>
                                <option>
                                    <?php
                                    if ($percent != 0.00) {
                                        echo $nama . ' (Fee Rp. ' . $flat . ' ). Total : Rp. ' . number_format($harganopercent) . ' + ' . $percent . '%';
                                    } else {
                                        echo $nama . ' (Fee Rp. ' . $flat . ' ). Total : Rp. ' . number_format($harganopercent);
                                    }
                                    ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <center>
                        <button type="submit" class="btn btn-success">
                            <span class="iconify" data-icon="fa-solid:cart-plus"></span>
                            Bayar
                        </button>
                    </center>
                </form>
            <?php endif; ?>
        </div>
    </section>
</div>
<!-- About End -->
<?= $this->endSection(); ?>