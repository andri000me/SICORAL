<div class="content-wrapper">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('msg'); ?>"></div>
  <?php if ($this->session->flashdata('msg')) : ?>
    <?php $this->session->flashdata('msg');  ?>
  <?php endif; ?>
  <section class="content-header">
    <h1>
      Donasi
      <small>Tracking</small>
    </h1>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Lacak Donasi</h3>
          </div>
          <div class="box-body">
            <form method="post" action="<?php echo base_url('dashboard/tracking_aksi') ?>">
            <div class="input-group input-group-md col-lg-4">
                <input type="number" class="form-control" placeholder="Masukkan nomor resi donasi" name="resi" maxlength="13" required>
                    <span class="input-group-btn">
                      <input type="submit" value="Cari" class="btn btn-success">
                    </span>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
