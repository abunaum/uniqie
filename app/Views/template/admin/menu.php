<li>
    <a href="<?= base_url('admin'); ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i></i>Dashboard</a>
</li>
<li class="has-sub">
    <a class="js-arrow" href="#">
        <i class="fab fa-fw fa-accusoft"></i></i>Gateway</a>
    <ul class="list-unstyled navbar-mobile-sub__list js-sub-list">
        <li>
            <a href="<?= base_url('admin/payment'); ?>">Payment Gateway</a>
        </li>
        <li>
            <a href="<?= base_url('admin/channel'); ?>">Channel Pembayaran</a>
        </li>
    </ul>
</li>
<li class="has-sub">
    <a class="js-arrow" href="#">
        <i class="fas fa-fw fa-sitemap"></i>Item</a>
    <ul class="list-unstyled navbar-mobile-sub__list js-sub-list">
        <li>
            <a href="<?= base_url('admin/kategori'); ?>">Kategori</a>
        </li>
        <li>
            <a href="<?= base_url('admin/produk'); ?>">Produk</a>
        </li>
    </ul>
</li>
<li class="has-sub">
    <a class="js-arrow" href="#">
        <i class="fas fa-fw fa-users"></i>Transaksi</a>
    <ul class="list-unstyled navbar-mobile-sub__list js-sub-list">
        <li>
            <a href="<?= base_url('admin/transaksi'); ?>">Daftar transaksi</a>
        </li>
    </ul>
</li>
<br>
<form action="<?= base_url('admin/uninstall') ?>" method="post" id="form-uninstall">
    <?= csrf_field(); ?>
    <button type="button" class="btn btn-danger" onclick="uninstall()">
        Uninstall
    </button>
</form>
<?php
$date = date('d F Y h:i:s a');
echo $date;
?>
<script type="text/javascript">
    function uninstall() {
        Swal.fire({
            title: 'Yakin mau Uninstall ?',
            showCancelButton: true,
            confirmButtonText: 'Uninstall',
            cancelButtonText: 'Batal',
            showLoaderOnConfirm: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("form-uninstall").submit();
            }
        })
    }
</script>