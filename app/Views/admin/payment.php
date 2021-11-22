<?= $this->extend('template/admin/template'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <form action="<?= base_url('admin/edit_payment') ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group has-success">
                        <label for="apikey" class="control-label mb-1">Api Key</label>
                        <input id="apikey" name="apikey" type="text" class="form-control <?= ($validation->hasError('apikey') ? 'is-invalid' : ''); ?>" value="<?= $payment['apikey']; ?>">
                    </div>
                    <div class="form-group has-success">
                        <label for="privatekey" class="control-label mb-1">Private Key</label>
                        <input id="privatekey" name="privatekey" type="text" class="form-control <?= ($validation->hasError('privatekey') ? 'is-invalid' : ''); ?>" value="<?= $payment['apiprivatekey']; ?>">
                    </div>
                    <div class="form-group has-success">
                        <label for="kode" class="control-label mb-1">Kode Merchant</label>
                        <input id="kode" name="kode" type="text" class="form-control <?= ($validation->hasError('kode') ? 'is-invalid' : ''); ?>" value="<?= $payment['kodemerchant']; ?>">
                    </div>
                    <div class="form-group has-success">
                        <label for="jenis" class="control-label mb-1">Jenis</label>
                        <select class="form-control" id="jenis" name="jenis">
                            <?php if ($payment['jenis'] == 'api-sandbox') : ?>
                                <option value="api-sandbox">Sandbox</option>
                                <option value="api">Real Merchat</option>
                            <?php else : ?>
                                <option value="api">Real Merchat</option>
                                <option value="api-sandbox">Sandbox</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <center>
                    <div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </center>
            </form>
        </div>
    </div>
</div>
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