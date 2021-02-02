<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Donasi
      <small>Donatur</small>
    </h1>
  </section>
  <section class="content">
    <a href="<?php echo base_url().'admin/donatur'; ?>" class="btn btn-sm btn-primary">Kembali</a>
    <br/>
    <br/>
      <form method="post" action="<?php echo base_url('admin/donatur_update') ?>" enctype="multipart/form-data">
        <div class="row">
          <div class="col-lg-6">
            <div class="box box-primary">
              <div class="box-body">
                <div class="form-group">
                  <label>Nama Event</label>
                  <?php foreach ($donatur as $d) {?>
                  <input type="hidden" name="id" value="<?php echo $d->donasi_id; ?>">
                  <select class="form-control" name="nama_event">
                    <option value="">- Pilih Event</option>
                    <?php foreach($artikel as $a){ ?>
                      <option <?php if($d->artikel_id == $a->artikel_id){echo "selected='selected'";} ?> value="<?php echo $a->artikel_id ?>"><?php echo $a->artikel_judul; ?></option>
                    <?php } ?>
                  </select>
                  <br/>
                  <?php echo form_error('artikel'); ?>
                </div>
                <label>Jumlah Donasi</label>
                <div class="input-group">
                  <span class="input-group-addon"><b>IDR</b></span>
                  <input type="number" name="jumlah_donasi" class="form-control" placeholder="Masukkan nominal donasi" value="<?php echo number_format($d->jumlah_donasi, 0, '', '.'); ?>" required>
                  <br/>
                  <?php echo form_error('jumlah_donasi'); ?>
                </div>
                <br/>
                <br/>
                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="status_donasi">
                    <option value="">- Pilih Status -</option>
                    <option <?php if($d->status_donasi == "1"){ echo "selected='selected'"; } ?> value="1">Terkirim</option>
                    <option <?php if($d->status_donasi == "2"){ echo "selected='selected'"; } ?> value="2">Divalidasi</option>
                    <option <?php if($d->status_donasi == "3"){ echo "selected='selected'"; } ?> value="3">Valid</option>
                    <option <?php if($d->status_donasi == "4"){ echo "selected='selected'"; } ?> value="4">Disalurkan</option>
                    <option <?php if($d->status_donasi == "0"){ echo "selected='selected'"; } ?> value="0">Invalid</option>
                  </select>
                  <?php echo form_error('status_donasi'); ?>
                </div>
                <br/>
                <div class="form-group">
                  <label>Bukti Donasi</label>
                  <input type="file" name="struk">
                  <br/>
                  <?php
                  if(isset($gambar_error)){
                    echo $gambar_error;
                  }
                  ?>
                  <?php echo form_error('struk'); ?>
                </div>
                <div class="box-footer">
                  <input type="submit" class="btn btn-success" value="Simpan">
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
      <?php } ?>
  </section>
</div>
