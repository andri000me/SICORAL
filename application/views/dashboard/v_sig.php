<div class="content-wrapper">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('msg'); ?>"></div>
  <?php if ($this->session->flashdata('msg')) : ?>
    <?php $this->session->flashdata('msg');  ?>
  <?php endif; ?>
  <section class="content-header">
    <h1>
      Sistem Informasi Geografis
      <small>Maps Geografis</small>
    </h1>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-lg-12">
        <div class="" id="map">
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-lg-12">
        <?php if($this->session->userdata('level')=="admin"){ ?>
        <a href="<?php echo base_url().'admin/sig_tambah'; ?>" class="btn btn-sm btn-primary"> Buat lokasi baru</a>
        <?php } ?>
        <br/>
        <br/>
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Daftar Lokasi</h3>
          </div>
          <div class="box-body">
            <table id="example1" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th width="1%">NO</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th width="10%">Gambar</th>
                  <th>Status</th>
                  <th width="15%">OPSI</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach($map as $m){
                  ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $m->nama_lokasi; ?></td>
                    <td><?php echo $m->alamat_lokasi; ?></td>
                    <td><img width="100%" class="img-responsive" src="<?php echo base_url().'/gambar/map/'.$m->gambar_lokasi; ?>"></td>
                    <td>
                      <?php
                      if($m->status_lokasi == 1){
                        echo "Aktif";
                      }else{
                        echo "Non Aktif";
                      }
                      ?>
                    </td>
                    <td>
                      <a id="set_dtl" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-detail"
                      data-gambar_lokasi="<?=$m->gambar_lokasi?>"
                      data-nama_lokasi="<?=$m->nama_lokasi?>"
                      data-deskripsi_lokasi="<?=$m->deskripsi_lokasi?>"
                      data-alamat_lokasi="<?=$m->alamat_lokasi?>"
                      data-lintang_lokasi="<?=$m->lintang_lokasi?>"
                      data-bujur_lokasi="<?=$m->bujur_lokasi?>"
                      data-status_lokasi="
                      <?php
                      if($m->status_lokasi == 1){
                        echo "Aktif";
                      }else{
                        echo "Non Aktif";
                      }
                      ?>"
                      data-qr_code="<?=$m->qr_code?>">
                        <i class="fa fa-eye"></i> </a>
                        <?php
                        // cek apakah penggun yang login adalah admin
                        if($this->session->userdata('level') == "admin"){
                          // jika penulis, maka cek apakah penulis artikel ini adalah si pengguna atau bukan
                          if($this->session->userdata('id') == $m->map_author){
                            ?>
                            <a href="<?php echo base_url().'admin/sig_edit/'.$m->map_id; ?>" class="btn btn-warning btn-sm"> <i class="fa fa-pencil"></i> </a>
                            <a href="<?php echo base_url().'admin/sig_hapus/'.$m->map_id; ?>" class="btn btn-danger btn-sm remove"> <i class="fa fa-trash"></i> </a>
                            <?php
                          }
                        }else{
                          // jika yang login adalah admin
                          ?>
                          <a href="<?php echo base_url().'admin/sig_edit/'.$m->map_id; ?>" class="btn btn-warning btn-sm"> <i class="fa fa-pencil"></i> </a>
                          <a href="<?php echo base_url().'admin/sig_hapus/'.$m->map_id; ?>" class="btn btn-danger btn-sm remove"> <i class="fa fa-trash"></i> </a>
                          <?php
                        }
                        ?>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Modal -->
<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h2 class="modal-title text-center" id="exampleModalCenterTitle"><i class="fa fa-map"><b> Informasi Lokasi</b></i></h2>
      </div>
      <div class="modal-body table-responsive">
        <img id="gambar_lokasi" width="50%" class="img-responsive" style="margin: 0 auto;"><br>
        <img id="qr_code" width="50%" class="img-responsive" style="margin: 0 auto;">
        <table class="table table-bordered no-margin">
          <tbody>
            <tr>
              <th>Nama Lokasi</th>
              <td><p class="text-uppercase-font-weight-bold" id="nama_lokasi"></p> </td>
            </tr>
            <tr>
              <th>Deskripsi</th>
              <td><p class="text-justify" id="deskripsi_lokasi"></p> </td>
            </tr>
            <tr>
              <th>Alamat Lokasi</th>
              <td><span id="alamat_lokasi"></span> </td>
            </tr>
            <tr>
              <th>Garis Lintang</th>
              <td><span id="lintang_lokasi"></span> </td>
            </tr>
            <tr>
              <th>Garis Bujur</th>
              <td><span id="bujur_lokasi"></span> </td>
            </tr>
            <tr>
              <th>Status</th>
              <td><span id="status_lokasi"></span> </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  $(document).on('click', '#set_dtl', function(){
    // var map_id = $(this).data('id');
    var gambar_lokasi = $(this).data('gambar_lokasi');
    var nama_lokasi= $(this).data('nama_lokasi');
    var deskripsi_lokasi = $(this).data('deskripsi_lokasi');
    var alamat_lokasi = $(this).data('alamat_lokasi');
    var lintang_lokasi = $(this).data('lintang_lokasi');
    var bujur_lokasi = $(this).data('bujur_lokasi');
    var status_lokasi = $(this).data('status_lokasi');
    var qr_code = $(this).data('qr_code');
    // $('#map_id').text(map_id);
    $('#gambar_lokasi').prop('src', '<?=base_url('gambar/map/')?>'+gambar_lokasi);
    $('#nama_lokasi').text(nama_lokasi);
    $('#deskripsi_lokasi').text(deskripsi_lokasi);
    $('#alamat_lokasi').text(alamat_lokasi);
    $('#lintang_lokasi').text(lintang_lokasi);
    $('#bujur_lokasi').text(bujur_lokasi);
    $('#status_lokasi').text(status_lokasi);
    $('#qr_code').prop('src', '<?=base_url('gambar/qrcode/')?>'+qr_code);
  })
})

</script>

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
