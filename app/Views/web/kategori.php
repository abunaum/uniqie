<?= $this->extend('template/web/template'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="cell cell-1"><?= $kategori['nama']; ?></div>
    <div class="grid-banner">
        <section class="grid_section layout_padding">
            <div class="container-fluid  ">
                <div class="row">
                    <div class="col-md-4 pl-md-0">
                        <div class="img-box">
                            <img src="<?= base_url('images/change.gif'); ?>" alt="">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="grid_container mb-3">
                            <p>
                                <?= $kategori['deskripsi']; ?>
                            </p>
                        </div>
                        <form action="<?= base_url('order/' . $kategori['id']); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="mb-3">
                                <label for="nama" class="form-label">* Nama Server</label>
                                <input type="text" name="nama" class="form-control <?= ($validation->hasError('nama') ? 'is-invalid' : ''); ?>" value="<?= old('nama'); ?>" id="nama" placeholder="Server Unique">
                            </div>
                            <div class="mb-3">
                                <label for="text" class="form-label">Text</label>
                                <input type="text" value="<?= old('text'); ?>" name="text" class="form-control" id="text" placeholder="Server Unique">
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" id="deskripsi" rows="3" placeholder="(Optional)"><?= old('deskripsi'); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">* Alamat Email</label>
                                <input type="email" name="email" class="form-control <?= ($validation->hasError('email') ? 'is-invalid' : ''); ?>" value="<?= old('email'); ?>" id="email" placeholder="name@example.com">
                            </div>
                            <center>
                                <button type="submit" class="btn btn-success">
                                    <span class="iconify" data-icon="fa-solid:cart-plus"></span>
                                    Order
                                </button>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </section>
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
            icon: 'error',
            title: pesan,
            html: '[x]' + error,
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
<?= $this->endSection(); ?>