<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Resi Donasi</title>
  </head>
  <body>
    <header>
      <img width="25%" class="img-responsive" style="float:left" src="<?php echo base_url().'/gambar/website/'.$pengaturan->logo; ?>">
        <h2>SI-CORAL</h2>
        <h4>Sistem Informasi Konservasi Terumbu Karang</h4>
        <h4>Tanda Terima Donasi</h4>
        <hr/>
    </header>
    <?php foreach($donasi as $d){ ?>
    <table class="table table-responsive">
      <tbody>
        <tr>
          <td class="col-sm-3"><b>Nama Donatur</b></td>
          <td class="col-sm-1">:</td>
          <td class="col-sm-4"><?php echo $d->pengguna_nama; ?></td>
          <td rowspan="3"><img width="25%" class="img-responsive" src="<?php echo base_url().'/gambar/barcode/'.$d->barcode; ?>"></td>
        </tr>
        <tr>
          <td class="col-sm-3"><b>Nomor Resi</b></td>
          <td class="col-sm-1">:</td>
          <td class="col-sm-4"><?php echo $d->nomor_resi; ?></td>
        </tr>
        <tr>
          <td class="col-sm-3"><b>Tanggal Donasi</b></td>
          <td class="col-sm-1">:</td>
          <td class="col-sm-4"><?php echo date('d F Y H:i:s', strtotime($d->tanggal_donasi)); ?></td>
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
            <td><?php echo $d->artikel_judul; ?> </td>
            <td><?php echo "Rp ".number_format($d->jumlah_donasi, 2, ',', '.'); ?> </td>
            <td><?php
            if($d->status_donasi == 1){
              echo "Terkirim";
            }elseif ($d->status_donasi == 2) {
              echo "Divalidasi";
            }elseif ($d->status_donasi == 3) {
              echo "Valid";
            }else {
              echo "Disalurkan";
            }
            ?> </td>
          </tr>
      </tbody>
      <?php } ?>
    </table>
     <br>
    <p>Note : <br>Tanda terima ini dianggap sah apabila telah divalidasi dan diterbitkan oleh pihak SICORAL dan terdapat barcode yang terdaftar. </p>
  </body>
</html>
