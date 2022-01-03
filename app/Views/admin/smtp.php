<?= $this->extend('template/admin/template'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="table-responsive m-b-40">
                <?php if ($smtp == null) : ?>
                    <center>
                        <h1>Data SMTP masih kosong.</h1>
                    </center>
                <?php else : ?>
                    <table class="table table-borderless table-data3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Host</th>
                                <th>Port</th>
                                <th>User</th>
                                <th>Password</th>
                                <th style="text-align: center; vertical-align: middle;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody><?php
                                $nomor = 1 ?>
                            <?php foreach ($smtp as $i) : ?>
                                <tr>
                                    <?php
                                    $host = $i['host'];
                                    $port = $i['port'];
                                    $user = $i['user'];
                                    $password = $i['password'];
                                    $id = $i['id'];
                                    ?>
                                    <td style="text-align: center; vertical-align: middle;"><?= $nomor++ ?></td>
                                    <td><?= $host ?></td>
                                    <td><?= $port ?></td>
                                    <td><?= $user ?></td>
                                    <?php
                                    $pass = strlen($password);
                                    if ($pass == 0) {
                                        $pass = 8;
                                    }
                                    $pas = '';
                                    for ($i = 0; $i < $pass; $i++) {
                                        $pas = $pas . '*';
                                    }
                                    ?>
                                    <td><?= $pas; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $id; ?>">Edit</button>
                                        <form action="<?= base_url('admin/smtp/' . $id) ?>" method="post" class="d-inline" id="form-hapus-id<?= $id; ?>">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="button" class="btn btn-danger" onclick="hapussmtp('<?= $user; ?>','<?= $id; ?>')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                <br>
                <hr>
                <center>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah SMTP</button>
                </center>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah SMTP</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/tambah_smtp') ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group has-success mb-3">
                        <label for="host" class="control-label mb-1">Host</label>
                        <input id="host" name="host" type="text" class="form-control <?= ($validation->hasError('host') ? 'is-invalid' : ''); ?>" value="<?= old('host'); ?>">
                    </div>
                    <div class="form-group has-success mb-3">
                        <label for="port" class="control-label mb-1">Port</label>
                        <input id="port" name="port" type="number" class="form-control <?= ($validation->hasError('port') ? 'is-invalid' : ''); ?>" value="<?= old('port'); ?>">
                    </div>
                    <div class="form-group has-success mb-3">
                        <label for="user" class="control-label mb-1">User</label>
                        <input id="user" name="user" type="text" class="form-control <?= ($validation->hasError('user') ? 'is-invalid' : ''); ?>" value="<?= old('user'); ?>">
                    </div>
                    <div class="form-group has-success mb-3">
                        <label for="password" class="control-label mb-1">Password</label>
                        <input id="password" name="password" type="password" class="form-control <?= ($validation->hasError('password') ? 'is-invalid' : ''); ?>" value="<?= old('password'); ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($smtp as $i) : ?>
    <?php
    $host = $i['host'];
    $port = $i['port'];
    $user = $i['user'];
    $password = $i['password'];
    $id = $i['id'];
    ?>
    <div class="modal fade" id="editModal<?= $id; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit SMTP</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('admin/edit_smtp') . '/' . $id ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group has-success mb-3">
                            <label for="host" class="control-label mb-1">Host</label>
                            <input id="host" name="host" type="text" class="form-control <?= ($validation->hasError('host') ? 'is-invalid' : ''); ?>" value="<?= $host; ?>">
                        </div>
                        <div class="form-group has-success mb-3">
                            <label for="port" class="control-label mb-1">Port</label>
                            <input id="port" name="port" type="number" class="form-control <?= ($validation->hasError('port') ? 'is-invalid' : ''); ?>" value="<?= $port; ?>">
                        </div>
                        <div class="form-group has-success mb-3">
                            <label for="user" class="control-label mb-1">User</label>
                            <input id="user" name="user" type="text" class="form-control <?= ($validation->hasError('user') ? 'is-invalid' : ''); ?>" value="<?= $user; ?>">
                        </div>
                        <div class="form-group has-success mb-3">
                            <label for="password" class="control-label mb-1">Password</label>
                            <input id="password" name="password" type="password" class="form-control <?= ($validation->hasError('password') ? 'is-invalid' : ''); ?>" value="<?= $password; ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script type="text/javascript">
    function hapussmtp(user, id) {
        Swal.fire({
            title: 'Yakin mau hapus ' + user + ' ?',
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
    $type = $error['type'];
    if ($type == 'edit') {
        $edit_id = $error['id'];
    } else {
        $edit_id = 0;
    }
    $value = $error['value'];
    $keterangan = implode("<br>[x] ", $value);
    ?>
    <script type="text/javascript">
        var pesan = '<?= $pesan ?>';
        var tipe = '<?= $type ?>';
        var id = '<?= $edit_id ?>';
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
                if (tipe == 'tambah') {
                    $('#tambahModal').modal('show');
                } else {
                    $('#editModal' + id).modal('show');
                }
            }
        })
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('smtperr')) : ?>
    <script type="text/javascript">
        <?php
        $error = session()->getFlashdata('smtperr');
        $pesan = $error['pesan'];
        $type = $error['type'];
        if ($type == 'edit') {
            $edit_id = $error['id'];
        } else {
            $edit_id = 0;
        }
        $value = $error['value'];
        ?>
        var pesan = '<?= $pesan; ?>';
        var tipe = '<?= $type; ?>';
        var id = '<?= $edit_id; ?>';
        var error = '<?= $value; ?>';
        Swal.fire({
            title: pesan,
            html: error,
            icon: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Coba lagi ?'
        }).then((result) => {
            if (result.isConfirmed) {
                if (tipe == 'tambah') {
                    $('#tambahModal').modal('show');
                } else {
                    $('#editModal' + id).modal('show');
                }
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