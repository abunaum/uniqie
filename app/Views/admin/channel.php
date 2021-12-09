<?= $this->extend('template/admin/template'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <?php if ($payment == null) : ?>
                <script>
                    let timerInterval
                    Swal.fire({
                        title: "Error!",
                        html: "Payment Gateway belum di setting <br> Anda akan di arahkan ke halaman setting Payment Gateway",
                        icon: 'error',
                        timer: 5000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            timerInterval = setInterval(() => 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                            window.location.href = "<?= base_url('admin/payment'); ?>";
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            window.location.href = "<?= base_url('admin/payment'); ?>";
                        }
                    })
                </script>
            <?php elseif ($channel == null) : ?>
                <center>
                    <h1>Channel payment masih kosong</h1>
                    <br>
                    <button class="btn btn-success" onclick="sinkron()">Sinkron sekarang</button>
                </center>
            <?php else : ?>
                <center>
                    <h2>Channel Pembayaran</h2>
                </center>
                <hr>
                <div class="table-responsive m-b-40">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nomor = 1;
                            ?>
                            <?php foreach ($channel as $i) : ?>
                                <tr>
                                    <?php
                                    $kode = $i['kode'];
                                    $nama = $i['nama'];
                                    $status = $i['status'];
                                    $id = $i['id'];
                                    ?>
                                    <td><?= $nomor++ ?></td>
                                    <td><?= $kode ?></td>
                                    <td><?= $nama ?></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" <?= ($status == 'aktif' ? 'checked' : ''); ?> role="switch" id="status<?= $id; ?>">
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <center>
                    <hr>
                    <button class="btn btn-success" onclick="sinkron()">Sinkron lagi</button>
                </center>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    function sinkron() {
        Swal.fire({
            title: 'Channel',
            html: "<p id='dataload'>Sedang sinkronasi channel ....</p>",
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
            },
            willClose: () => {}
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {}
        })
        const other_params = {
            method: "POST",
            mode: "cors"
        };
        url = '<?= base_url('api/syncchannel'); ?>';
        fetch(url, other_params)
            .then(function(response) {
                return response.json();
            })
            .then(function(jsonResponse) {
                if (jsonResponse['success'] != true) {
                    Swal.fire({
                        title: 'Sinkron channel',
                        html: jsonResponse['pesan'],
                        icon: 'error',
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
                } else {
                    Swal.fire({
                        title: 'Sinkron channel',
                        html: jsonResponse['pesan'],
                        icon: 'success',
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            timerInterval = setInterval(() => 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                            window.location.href = "<?= base_url('admin/channel'); ?>";
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {}
                    })
                }
            });
    }
</script>
<?php if (session()->getFlashdata('error')) : ?>
    <?php
    $error = session()->getFlashdata('error');
    $pesan = $error['pesan'];
    $value = $error['value'];
    $keterangan = implode("<br>[x] ", $value);
    ?>
    <script type="text/javascript">
        var pesan = '<?= $pesan ?>';
        var error = '<?= $keterangan ?>';
        let timerInterval
        Swal.fire({
            title: pesan,
            html: '[x]' + error,
            icon: 'error',
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