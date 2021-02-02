<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Sistem Informasi Geografis
      <small>Tambah Maps</small>
    </h1>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-5">
        <a href="<?php echo base_url().'dashboard/sig'; ?>" class="btn btn-sm btn-primary">Kembali</a>
          <br/>
          <br/>
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Sistem Informasi Geografis</h3>
            </div>
            <div class="box-body">
              <?php foreach($map as $m){ ?>
              <form method="post" action="<?php echo base_url('dashboard/sig_update') ?>" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label>Nama Lokasi</label>
                  <input type="hidden" name="id" value="<?php echo $m->map_id; ?>">
                  <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lokasi .." value="<?php echo $m->nama_lokasi; ?>" required>
                  <?php echo form_error('nama'); ?>
                </div>
                <div class="form-group">
                  <label>Deskripsi</label>
                  <input type="text" name="deskripsi" class="form-control" placeholder="Masukkan deskripsi lokasi .." value="<?php echo $m->deskripsi_lokasi; ?>" required>
                  <?php echo form_error('deskripsi'); ?>
                </div>
                <div class="form-group">
                  <label>Alamat</label>
                  <input type="text" name="alamat" class="form-control" placeholder="Masukkan alamat lokasi .." value="<?php echo $m->alamat_lokasi; ?>" required>
                  <?php echo form_error('alamat'); ?>
                </div>
                <div class="form-group">
                  <label>Lintang Lokasi</label><br>
                  <small>Klik pada map untuk koordinat</small>
                  <input type="text" name="lintang" id="lat" class="form-control" placeholder="koordinat lintang(-6.1192554)" value="<?php echo $m->lintang_lokasi; ?>" required>
                  <?php echo form_error('lintang'); ?>
                </div>
                <div class="form-group">
                  <label>Bujur Lokasi</label><br>
                  <small>Klik pada map untuk koordinat</small>
                  <input type="text" name="bujur" id="lng" class="form-control" placeholder="koordinat bujur (106.8478001)" value="<?php echo $m->bujur_lokasi; ?>" required>
                  <?php echo form_error('bujur'); ?>
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="status">
                  <option value="">- Pilih Status -</option>
                    <option <?php if($m->status_lokasi == "1"){ echo "selected='selected'"; } ?> value="1">Aktif</option>
                    <option <?php if($m->status_lokasi == "0"){ echo "selected='selected'"; } ?> value="0">Non-Aktif</option>
                  </select>
                  <?php echo form_error('status'); ?>
                </div>
                <div class="form-group">
                  <label>Gambar Lokasi</label>
                  <input type="file" name="berkas">
                  <br/>
                  <?php
                  if(isset($gambar_error)){
                    echo $gambar_error;
                  }
                  ?>
                  <?php echo form_error('berkas'); ?>
                </div>
              </div>
              <div class="box-footer">
                <input type="submit" class="btn btn-success" value="Simpan">
              </div>
            </form>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="col-lg-7">
          <br>
          <br>
          <div class="" id="map" style="height: 680px; ">
          </div>
      </div>
    </div>
  </section>
</div>

<script type="text/javascript">
var map = new L.Map('map', {zoom: 9, center: new L.latLng(-6.1192501,106.8478001)});

map.addLayer(new L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}));

var popup = L.popup();
function onMapClick(e) {
  popup
  .setLatLng(e.latlng)
  .setContent("Anda memilih bujur dan lintang " + e.latlng.toString())
  .openOn(map);
}

map.on('click', onMapClick);

// Data sesuai table map
var data = [
  <?php foreach ($map as $key => $value) { ?>
    {"lokasi":[<?= $value->lintang_lokasi ?>,<?= $value->bujur_lokasi ?>],"nama_lokasi":"<?= $value->nama_lokasi ?>"},
    <?php } ?>
  ];
  // elemet search
  var markersLayer = new L.LayerGroup();
  map.addLayer(markersLayer);
  var controlSearch = new L.Control.Search({
    position:'topright',
    layer: markersLayer,
    initial: false,
    zoom: 12,
    marker: false
  });

  map.addControl( new L.Control.Search({
    layer: markersLayer,
    initial: false,
    collapsed: true,
    zoom: 15
  }) );

  // populasi maps dari sampe data
  for (i in data) {
    var nama_lokasi = data[i].nama_lokasi;
    var lokasi = data[i].lokasi;
    var marker = new L.Marker(new L.latLng(lokasi), {title: nama_lokasi} );
    marker.bindPopup('Nama Lokasi: '+ nama_lokasi);
    markersLayer.addLayer(marker);
  }
</script>
