<?= $this->extend('template/web/template'); ?>
<?= $this->section('content'); ?>

<!-- Logo Start -->
<div class="container mt-3">
  <section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="orderModalToggleLabel3">List Transaksi</h5>
        </div>
        <div class="modal-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Produk</th>
                <th scope="col">Kode Transaksi</th>
                <th scope="col">Harga</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 0; ?>
              <?php foreach ($transaksi as $t) : ?>
                <?php $i++; ?>
                <tr>
                  <th scope="row"><?= $i; ?></th>
                  <td><?= $t['nama_produk']; ?></td>
                  <td><?= $t['merchant_ref']; ?></td>
                  <td><?= number_to_currency($t['harga'], 'IDR') ?></td>
                  <td><?= $t['status']; ?></td>
                  <td>
                    <a href="<?= base_url('user/transaksi/detail') . '/' . $t['merchant_ref']; ?>">
                      <button class="btn btn-success">Detail</button>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<?= $this->endSection(); ?>