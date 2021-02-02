<div class="content-wrapper">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('msg'); ?>"></div>
<?php if ($this->session->flashdata('msg')) : ?>
  <?php $this->session->flashdata('msg');  ?>
<?php endif; ?>
  <section class="content-header">
    <h1>
      DONASI
      <small>Donatur</small>
    </h1>
  </section>
  <section class="content">
    <br/>
    <div class="row">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Daftar Donasi Masuk</h3>
          </div>
          <div class="box-body">
            <table id="example1" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th width="1%">NO</th>
                  <th>Nama Donatur</th>
                  <th>Nama Event</th>
                  <th>Tanggal</th>
                  <th width="15%">Jumlah (IDR)</th>
                  <th>Status</th>
                  <th width="10%">OPSI</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach($donatur as $d){ ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $d->pengguna_nama; ?></td>
                    <td><?php echo $d->artikel_judul; ?></td>
                    <td><?php echo date('d F Y H:i:s', strtotime($d->tanggal_donasi)); ?></td>
                    <td><?php echo "Rp ".number_format($d->jumlah_donasi, 2, ',', '.'); ?></td>
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
                      <a id="set_dtl" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-detail"
                      data-donasi_id="<?=$d->donasi_id ?>"
                      data-struk="<?=$d->struk?>"
                      data-barcode="<?=$d->barcode?>"
                      >
                        <i class="fa fa-eye"></i> </a>
                      <?php
                      // cek dan jika yang login adalah admin
                      if($this->session->userdata('level') == "admin"){ ?>
                        <a href="<?php echo base_url().'admin/donatur_edit/'.$d->donasi_id; ?>" class="btn btn-warning btn-sm"> <i class="fa fa-pencil"></i> </a>
                        <a href="<?php echo base_url().'admin/donatur_hapus/'.$d->donasi_id; ?>" class="btn btn-danger btn-sm remove"> <i class="fa fa-trash"></i> </a>
                      <?php } ?>
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
      <h2 class="modal-title text-center" id="exampleModalCenterTitle"><i class="fa fa-map"><b> Bukti Pembayaran dan Resi</b></i></h2>
    </div>
    <div class="box-primary">
    <div class="modal-body">
          <div class="form-group text-center">
            <h2>Bukti Donasi</h2>
            <span id="donasi_id" hidden></span>
            <img id="struk" width="50%" class="img-responsive" style="margin: 0 auto;">
          </div>
          <div class="form-group text-center">
            <h2>Nomor Resi</h2>
              <img id="barcode" width="30%" class="img-responsive" style="margin: 0 auto;">
          </div>
        </tbody>
      </table>
    </div>
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
    var donasi_id = $(this).data('donasi_id');
    var struk = $(this).data('struk');
    var barcode= $(this).data('barcode');
    $('#donasi_id').text(donasi_id);
    $('#struk').prop('src', '<?=base_url('gambar/donasi/')?>'+struk);
    $('#barcode').prop('src', '<?=base_url('gambar/barcode/')?>'+barcode);
  })
})

</script>
