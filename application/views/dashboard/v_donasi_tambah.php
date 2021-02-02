<div class="content-wrapper">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('msg'); ?>"></div>
<?php if ($this->session->flashdata('msg')) : ?>
  <?php $this->session->flashdata('msg');  ?>
<?php endif; ?>
  <section class="content-header">
    <h1>
      Donasi
      <small>Berdonasi</small>
    </h1>
  </section>
  <section class="content">
    <br/>
    <div class="row">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Daftar Riwayat Donasi</h3>
          </div>
          <div class="box-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th width="1%">NO</th>
                  <th>Nama</th>
                  <th>Nama Event</th>
                  <th>Tanggal</th>
                  <th width="15%">Nomor Resi</th>
                  <th>Status</th>
                  <th width="10%">OPSI</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = $this->uri->segment('3') + 1;
                foreach($donasi as $d){
                  ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $d->pengguna_nama; ?></td>
                    <td><?php echo $d->artikel_judul; ?></td>
                    <td><?php echo date('d F Y H:i:s', strtotime($d->tanggal_donasi)); ?></td>
                    <td><?php echo $d->nomor_resi; ?></td>
                    <td>
                      <?php
                      if($d->status_donasi == 1){
                        echo "Terkirim";
                      }elseif ($d->status_donasi == 2) {
                        echo "Divalidasi";
                      }elseif ($d->status_donasi == 3) {
                        echo "Valid";
                      }else {
                        echo "Disalurkan";
                      }
                      ?>
                    </td>
                    <td>
                      <?php if ($d->status_donasi == 3 || $this->session->userdata('level') == "admin" ): ?>
                      <a id="set_dtl" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-detail"
                      data-donasi_id="<?=$d->donasi_id?>"
                      data-nomor_resi="<?=$d->nomor_resi?>"
                      data-pengguna_nama="<?=$d->pengguna_nama?>"
                      data-tanggal_donasi="<?=date('d F Y H:i:s', strtotime($d->tanggal_donasi))?>"
                      data-artikel_judul="<?=$d->artikel_judul?>"
                      data-jumlah_donasi="<?=$d->jumlah_donasi?>"
                      data-status_donasi="<?php
                      if($d->status_donasi == 1){
                        echo "Terkirim";
                      }elseif ($d->status_donasi == 2) {
                        echo "Divalidasi";
                      }elseif ($d->status_donasi == 3) {
                        echo "Valid";
                      }else {
                        echo "Disalurkan";
                      }
                      ?>"
                      data-barcode="<?=$d->barcode?>">
                      <i class="fa fa-file-pdf-o"></i> </a>
                      <?php endif; ?>
                      <?php
                      // cek dan jika yang login adalah admin
                      if($this->session->userdata('level') == "admin"){ ?>
                        <a href="<?php echo base_url().'admin/donasi_edit/'.$d->donasi_id; ?>" class="btn btn-warning btn-sm"> <i class="fa fa-pencil"></i> </a>
                        <a href="<?php echo base_url().'admin/donasi_hapus/'.$d->donasi_id; ?>" class="btn btn-danger btn-sm remove"> <i class="fa fa-trash"></i> </a>
                      <?php } ?>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <!-- membuat tombol halaman pagination -->
            <?php echo $this->pagination->create_links(); ?>
          </div>
        </div>
      </div>
    </div>
    <form method="post" action="<?php echo base_url('dashboard/donasi_aksi') ?>" enctype="multipart/form-data">
      <div class="row">
        <div class="col-lg-6">
          <div class="box box-primary">
            <div class="box-body">
              <div class="form-group">
                <h3>Tambah Donasi</h3>
                <label>Nama Event</label>
                <select class="form-control" name="nama_event" required>
                  <option value="">- Pilih Event</option>
                  <?php foreach($artikel as $a){ ?>
                    <option <?php if(set_value('artikel') == $a->artikel_id){echo "selected='selected'";} ?> value="<?php echo $a->artikel_id ?>"><?php echo $a->artikel_judul; ?></option>
                  <?php } ?>
                </select>
                <br/>
                <?php echo form_error('nama_event'); ?>
              </div>
              <label>Jumlah Donasi</label>
              <div class="input-group">
                <span class="input-group-addon"><b>IDR</b></span>
                <input type="number" name="jumlah_donasi" class="form-control" placeholder="Masukkan nominal donasi" value="<?php echo set_value('jumlah_donasi'); ?>" required>
                <br/>
                <?php echo form_error('jumlah_donasi'); ?>
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
  </section>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-body">
      <div id="printThis">
      <img width="20%" class="img-responsive" style="float:left" src="<?php echo base_url().'/gambar/website/'.$pengaturan->logo; ?>">
        <h2>SI-CORAL</h2>
        <h4>Sistem Informasi Konservasi Terumbu Karang</h4>
        <h4>Tanda Terima Donasi</h4>
        <hr/>
      <table class="table table-responsive">
        <tbody>
          <tr>
            <td class="col-sm-3"><b>Nama Donatur</b></td>
            <td class="col-sm-1">:</td>
            <td class="col-sm-4"><span id="pengguna_nama"></span> </td>
            <td rowspan="3"><img id="barcode" width="100%" class="img-responsive"></td>
          </tr>
          <tr>
            <td class="col-sm-3"><b>Nomor Resi</b></td>
            <td class="col-sm-1">:</td>
            <td class="col-sm-4"><span id="nomor_resi"></span> </td>
          </tr>
          <tr>
            <td class="col-sm-3"><b>Tanggal Donasi</b></td>
            <td class="col-sm-1">:</td>
            <td class="col-sm-4"><span id="tanggal_donasi"></span> </td>
          </tr>
        </tbody>
      </table>
      <br>
      <table class="table table-responsive table-bordered no-margin">
        <tbody>
          <tr>
            <th>Nama Event</th>
            <th>Jumlah Donasi</th>
            <th>Status</th>
            </tr>
            <tr>
              <td><span id="artikel_judul"></span> </td>
              <td><span id="jumlah_donasi"></span> </td>
              <td><span id="status_donasi"></span> </td>
            </tr>
        </tbody>
      </table> <br>
      <p>Note : <br>Tanda terima ini dianggap sah apabila telah divalidasi dan diterbitkan oleh pihak SICORAL dan terdapat barcode yang terdaftar. </p>
    </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" id="btnPrint"><i class="fa fa-print"> Print</i></button>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
$(document).on('click', '#set_dtl', function(){
  var donasi_id = $(this).data('donasi_id');
  var nomor_resi = $(this).data('nomor_resi');
  var pengguna_nama= $(this).data('pengguna_nama');
  var tanggal_donasi= $(this).data('tanggal_donasi');
  var artikel_judul = $(this).data('artikel_judul');
  var jumlah_donasi = $(this).data('jumlah_donasi');
  var status_donasi = $(this).data('status_donasi');
  var barcode = $(this).data('barcode');
  $('#donasi_id').text(donasi_id);
  $('#nomor_resi').text(nomor_resi);
  $('#pengguna_nama').text(pengguna_nama);
  $('#tanggal_donasi').text(tanggal_donasi);
  $('#artikel_judul').text(artikel_judul);
  $('#jumlah_donasi').text(jumlah_donasi);
  $('#status_donasi').text(status_donasi);
  $('#barcode').prop('src', '<?=base_url('gambar/barcode/')?>'+barcode);
})
})

</script>

<script>
document.getElementById("btnPrint").onclick = function () {
    printElement(document.getElementById("printThis"));
}

function printElement(elem) {
    var domClone = elem.cloneNode(true);

    var $printSection = document.getElementById("printSection");

    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }

    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}
</script>
