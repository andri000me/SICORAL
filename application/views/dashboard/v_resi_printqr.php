<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Resi Penyerahan DonasiQR</title>
  </head>
  <body>
    <img width="10%" class="img-responsive" src="<?php echo base_url().'gambar/qr-code/resi-'.$donasi->nomor_resi.'.png'; ?>"> <br>
    <span><?php echo $donasi->nomor_resi; ?>  </span>
  </body>
</html>
