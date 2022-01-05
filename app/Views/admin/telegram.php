<?= $this->extend('template/admin/template'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <center>
                <div class="card w-100">
                    <div class="card-body">
                        <?php if (!$telegram) : ?>
                            <h5 class="card-title">Ooops !</h5>
                            <p class="card-text">Telegram belum ada.</p>
                            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#teleModal">
                                Tambah telegram
                            </button>
                        <?php elseif ($telegram['status'] == 'belum') : ?>
                            <h5 class="card-title">Konfirmasi Telegram</h5>
                            <p class="card-text">Telegram terhubung dengan ID <?= $telegram['teleid']; ?>.</p>
                            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#telekomfirModal">
                                Konfirmasi Sekarang
                            </button>
                            <button type="button" class="btn btn-warning mb-3 d-inline" data-bs-toggle="modal" data-bs-target="#teleModal">
                                Ubah telegram
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </center>
        </div>
    </div>
</div>
<?php if (!$telegram) : ?>
    <div class="modal fade" id="teleModal" tabindex="-1" aria-labelledby="teleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <center>
                        <h5 class="modal-title" id="teleModalLabel">Tambah Telegram</h5>
                    </center>
                    <button type="button" class="iconify" data-icon="clarity:window-close-line" data-bs-inline="false" data-width="24px" data-height="24px" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="g-3 needs-validation" action="<?= base_url('admin/telegram_req'); ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <p>Untuk mendapatkan Telegram ID silahkan chat <a href="https://t.me/Uniqie_bot" target="_blank" rel="noopener noreferrer">@uniqie_bot</a></p>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control <?= ($validation->hasError('teleid')) ? 'is-invalid' : '' ?>" placeholder="xxxxxxxx" aria-label="teleid" name="teleid" id="teleid" aria-describedby="basic-addon1" value="<?= old('teleid') ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('teleid'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php elseif ($telegram['status'] == 'belum') : ?>
    <div class="modal fade" id="teleModal" tabindex="-1" aria-labelledby="teleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <center>
                        <h5 class="modal-title" id="teleModalLabel">Tambah Telegram</h5>
                    </center>
                    <button type="button" class="iconify" data-icon="clarity:window-close-line" data-bs-inline="false" data-width="24px" data-height="24px" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="g-3 needs-validation" action="<?= base_url('admin/telegram_req'); ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <p>Untuk mendapatkan Telegram ID silahkan chat <a href="https://t.me/Uniqie_bot" target="_blank" rel="noopener noreferrer">@uniqie_bot</a></p>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control <?= ($validation->hasError('teleid')) ? 'is-invalid' : '' ?>" placeholder="xxxxxxxx" aria-label="teleid" name="teleid" id="teleid" aria-describedby="basic-addon1" value="<?= old('teleid') ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('teleid'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="telekomfirModal" tabindex="-1" aria-labelledby="telekomfirModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <center>
                        <h5 class="modal-title" id="telekomfirModalLabel">Konfirmasi Telegram</h5>
                    </center>
                    <button type="button" class="iconify" data-icon="clarity:window-close-line" data-bs-inline="false" data-width="24px" data-height="24px" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="g-3 needs-validation" action="<?= base_url('admin/telegram_verif' . '/' . $telegram['id']); ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <p>Silahkan masukkan kode yang dikirim ke ID <?= $telegram['teleid']; ?></p>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control <?= ($validation->hasError('kode')) ? 'is-invalid' : '' ?>" placeholder="xxxxxxxx" aria-label="kode" name="kode" id="kode" aria-describedby="basic-addon1" value="<?= old('kode') ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('kode'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
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
        Swal.fire({
            title: pesan,
            html: '[x]' + error,
            icon: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Coba lagi ?'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#teleModal').modal('show');
            }
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