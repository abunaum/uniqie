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
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        use Google\Service\AIPlatformNotebooks\Execution;

                        $nomor = 1 ?>
                        <?php foreach ($item as $i) : ?>
                            <tr>
                                <?php
                                $nama = $i['nama'];
                                $id = $i['id'];
                                ?>
                                <td><?= $nomor++ ?></td>
                                <td><?= $nama ?></td>
                                <td><?= 'Rp.' . number_format($i['harga']) ?></td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editModal<?= $id; ?>">
                                        Edit
                                    </button>
                                    <form action="<?= base_url('admin/item/' . $id) ?>" method="post" class="d-inline" id="form-hapus-id<?= $id; ?>">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="button" class="btn btn-danger" onclick="hapusitem('<?= $nama; ?>','<?= $id; ?>')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <center>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">
                    Tambah Item
                </button>
            </center>
        </div>
    </div>
</div>
<script type="text/javascript">
    function hapusitem(nama, id) {
        Swal.fire({
            title: 'Yakin mau hapus ' + nama + id + ' ?',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            showLoaderOnConfirm: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("form-hapus-id" + id).submit();
            }
        })
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
        Swal.fire({
            title: pesan,
            html: '[x]' + error,
            icon: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Coba lagi ?'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#tambahModal').modal('show');
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

<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/tambah_item') ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group has-success">
                        <label for="nama" class="control-label mb-1">Nama Item</label>
                        <input id="nama" name="nama" type="text" class="form-control <?= ($validation->hasError('nama') ? 'is-invalid' : ''); ?>" value="<?= old('nama'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi" class="control-label mb-1">Deskripsi Item</label>
                        <textarea name="deskripsi" id="deskripsi" rows="9" placeholder="Masukkan deskripsi item" class="form-control <?= ($validation->hasError('deskripsi') ? 'is-invalid' : ''); ?>"><?= old('deskripsi'); ?></textarea>
                    </div>
                    <div class=" form-group">
                        <label for="harga">Harga</label>
                        <div class="row form-group">
                            <div class="col col-md-12">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        Rp.
                                    </div>
                                    <input type="text" id="harga" name="harga" onkeyup="convertToRupiah(this);" placeholder="10,000" class="form-control <?= ($validation->hasError('harga') ? 'is-invalid' : ''); ?>" value="<?= old('harga'); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($item as $i) : ?>
    <?php
    $nama = $i['nama'];
    $deskripsi = $i['deskripsi'];
    $harga = $i['harga'];
    $id = $i['id'];
    ?>
    <div class="modal fade" id="editModal<?= $id; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit <?= $nama; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('admin/edit_item/' . $id) ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group has-success">
                            <label for="nama" class="control-label mb-1">Nama Item</label>
                            <input id="nama" name="nama" type="text" class="form-control <?= ($validation->hasError('nama') ? 'is-invalid' : ''); ?>" value="<?= (old('nama') ? old('nama') : $nama); ?>">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi" class="control-label mb-1">Deskripsi Item</label>
                            <textarea name="deskripsi" id="deskripsi" rows="9" placeholder="Masukkan deskripsi item" class="form-control <?= ($validation->hasError('deskripsi') ? 'is-invalid' : ''); ?>"><?= (old('deskripsi') ? old('deskripsi') : $deskripsi); ?></textarea>
                        </div>
                        <div class=" form-group">
                            <label for="harga">Harga</label>
                            <div class="row form-group">
                                <div class="col col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            Rp.
                                        </div>
                                        <input type="text" id="harga" name="harga" onkeyup="convertToRupiah(this);" placeholder="10,000" class="form-control <?= ($validation->hasError('harga') ? 'is-invalid' : ''); ?>" value="<?= (old('harga') ? old('harga') : number_format($harga)); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- /.container-fluid -->
<?= $this->endSection(); ?>