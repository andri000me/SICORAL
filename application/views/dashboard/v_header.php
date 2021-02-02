<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SI CORAL</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Data Table Plugin -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css">
  <!-- Print Style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/myscript.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- leaflet plugins -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/leaflet/leaflet.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/leaflet-search/src/leaflet-search.css">
  <!-- Swall plugins -->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style type="text/css">
  /* .swal2-popup{
  width:850px!important;
  } */
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
      <a href="<?php echo base_url(); ?>" class="logo">
        <span class="logo-mini"><b>SC</b></span>
        <span class="logo-lg"><b>SI</b>CORAL</span>
      </a>
      <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo base_url();?>assets/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                <span class="hidden-xs">HAK AKSES :
                  <b><?php echo $this->session->userdata('level') ?></b></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="user-header">
                    <img src="<?php echo base_url(); ?>assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                    <p>
                      <?php echo $this->session->userdata('username') ?>
                      <small>Hak akses :
                        <?php echo $this->session->userdata('level') ?></small>
                      </p>
                    </li>
                    <li class="user-footer">
                      <div class="pull-left">
                        <a href="<?php echo base_url().'dashboard/profil' ?>" class="btn btn-default btn-flat">Profil</a>
                      </div>
                      <div class="pull-right">
                        <a href="<?php echo base_url().'dashboard/keluar' ?>" class="btn btn-default btn-flat">Keluar</a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
        </header>
        <aside class="main-sidebar">
          <section class="sidebar">
            <div class="user-panel">
              <div class="pull-left image">
                <img src="<?php echo base_url(); ?>assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
              </div>
              <div class="pull-left info">
                <?php
                $id_user = $this->session->userdata('id');
                $user = $this->db->query("select * from pengguna where pengguna_id='$id_user'")->row();
                ?>
                <p><?php echo $user->pengguna_nama; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i>Online</a>
              </div>
            </div>
            <ul class="sidebar-menu" data-widget="tree">
              <li class="header">MAIN NAVIGATION</li>
              <li <?=$this->uri->segment(2) == 'index' || $this->uri->segment(2) == '' ? 'class="active"' : ''?>>
                <a href="<?php echo base_url().'dashboard' ?>">
                  <i class="fa fa-dashboard"></i>
                  <span>DASHBOARD</span>
                </a>
              </li>
              <li <?=$this->uri->segment(2) == 'sig' ? 'class="active"' : ''?>>
                <a href="<?php echo base_url().'dashboard/sig' ?>">
                  <i class="fa fa-map"></i>
                  <span>SI-GEOGRAFIS</span>
                </a>
              </li>
              <li <?=$this->uri->segment(2) == 'alt_konservasi' ? 'class="active"' : ''?>>
                <a href="<?php echo base_url().'dashboard/alt_konservasi' ?>">
                  <i class="fa fa-search"></i>
                  <span>ALTERNATIF KONSERVASI</span>
                </a>
              </li>
              <li class="treeview <?=$this->uri->segment(2) == 'donatur' || $this->uri->segment(2) == 'donasi' || $this->uri->segment(2) == 'tracking' ? 'active' : ''?>">
                <a href="#">
                  <i class="fa fa-money"></i>
                  <span>DONASI</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <?php
                  //cek jika yang login adalah admin
                  if($this->session->userdata('level')=="admin"){ ?>
                    <li <?=$this->uri->segment(2) == 'donatur' ? 'class="active"' : ''?>><a href="<?php echo base_url().'admin/donatur' ?>"><i class="fa fa-users"></i> DONATUR</a></li>
                  <?php } ?>
                  <li <?=$this->uri->segment(2) == 'donasi' ? 'class="active"' : ''?>><a href="<?php echo base_url().'dashboard/donasi' ?>"><i class="fa fa-money"></i> BERDONASI</a></li>
                  <li <?=$this->uri->segment(2) == 'tracking' ? 'class="active"' : ''?>><a href="<?php echo base_url().'dashboard/tracking' ?>"><i class="fa fa-truck"></i> TRACKING</a></li>
                </ul>
              </li>
              <li <?=$this->uri->segment(2) == 'perizinan' ? 'class="active"' : ''?>>
                <a href="<?php echo base_url().'dashboard/perizinan' ?>">
                  <i class="fa fa-legal"></i>
                  <span>PERIZINAN</span>
                </a>
              </li>
              <li <?=$this->uri->segment(2) == 'relawan' ? 'class="active"' : ''?>>
                <a href="<?php echo base_url().'dashboard/relawan' ?>">
                  <i class="fa fa-users"></i>
                  <span>RELAWAN</span>
                </a>
              </li>
              <?php
              //cek jika yang login adalah admin
              if($this->session->userdata('level')=="admin"){ ?>
                <li <?=$this->uri->segment(2) == 'vendor' ? 'class="active"' : ''?>>
                  <a href="<?php echo base_url().'admin/vendor' ?>">
                    <i class="fa fa-cubes"></i>
                    <span>VENDOR</span>
                  </a>
                </li>
              <?php } ?>
              <li <?=$this->uri->segment(2) == 'rab' ? 'class="active"' : ''?>>
                <a href="<?php echo base_url().'admin/rab' ?>">
                  <i class="fa fa-balance-scale"></i>
                  <span>RAB</span>
                </a>
              </li>
              <?php
              //cek jika yang login adalah admin
              if($this->session->userdata('level')=="admin"){ ?>
                <li <?=$this->uri->segment(2) == 'kriteria' ? 'class="active"' : ''?>>
                  <a href="<?php echo base_url().'admin/kriteria' ?>">
                    <i class="fa fa-book"></i>
                    <span>KRITERIA</span>
                  </a>
                </li>
              <?php } ?>
              <li <?=$this->uri->segment(2) == 'laporan' ? 'class="active"' : ''?>>
                <a href="<?php echo base_url().'dashboard/laporan' ?>">
                  <i class="fa fa-bar-chart"></i>
                  <span>LAPORAN</span>
                </a>
              </li>
              <li class="treeview <?=$this->uri->segment(2) == 'artikel' || $this->uri->segment(2) == 'kategori' ? 'active' : ''?>">
                <a href="#">
                  <i class="fa fa-pencil"></i>
                  <span>ARTIKEL</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li <?=$this->uri->segment(2) == 'artikel' ? 'class="active"' : ''?>><a href="<?php echo base_url().'dashboard/artikel' ?>"><i class="fa fa-pencil"></i> BUAT ARTIKEL</a></li>
                  <?php
                  //cek jika yang login adalah admin
                  if($this->session->userdata('level')=="admin"){ ?>
                    <li <?=$this->uri->segment(2) == 'kategori' ? 'class="active"' : ''?>><a href="<?php echo base_url().'admin/kategori' ?>"><i class="fa fa-th"></i> KATEGORI</a></li>
                  <?php } ?>
                </ul>
              </li>
              <li class="treeview <?=$this->uri->segment(2) == 'pages' || $this->uri->segment(2) == 'pengguna' || $this->uri->segment(2) == 'pengaturan' || $this->uri->segment(2) == 'profil' || $this->uri->segment(2) == 'ganti_password' ? 'active' : ''?>">
                <a href="#">
                  <i class="fa fa-cogs"></i>
                  <span>PENGATURAN</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <?php
                  //cek jika yang login adalah admin
                  if ($this->session->userdata('level')=="admin") { ?>
                    <li <?=$this->uri->segment(2) == 'pages' ? 'class="active"' : ''?>>
                      <a href="<?php echo base_url().'admin/pages' ?>">
                        <i class="fa fa-files-o"></i>
                        <span>PAGES</span>
                      </a>
                    </li>
                    <li <?=$this->uri->segment(2) == 'pengguna' ? 'class="active"' : ''?>>
                      <a href="<?php echo base_url().'admin/pengguna' ?>">
                        <i class="fa fa-users"></i>
                        <span>PENGGUNA & HAK AKSES</span>
                      </a>
                    </li>
                    <li <?=$this->uri->segment(2) == 'pengaturan' ? 'class="active"' : ''?>>
                      <a href="<?php echo base_url().'admin/pengaturan' ?>">
                        <i class="fa fa-edit"></i>
                        <span>PENGATURAN WEBSITE</span>
                      </a>
                    </li>
                  <?php } ?>
                  <li <?=$this->uri->segment(2) == 'profil' ? 'class="active"' : ''?>>
                    <a href="<?php echo base_url().'dashboard/profil' ?>">
                      <i class="fa fa-user"></i>
                      <span>PROFIL</span>
                    </a>
                  </li>
                  <li <?=$this->uri->segment(2) == 'ganti_password' ? 'class="active"' : ''?>>
                    <a href="<?php echo base_url().'dashboard/ganti_password' ?>">
                      <i class="fa fa-lock"></i>
                      <span>GANTI PASSWORD</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li <?=$this->uri->segment(2) == 'keluar' ? 'class="active"' : ''?>>
                <a href="<?php echo base_url().'dashboard/keluar' ?>">
                  <i class="fa fa-share"></i>
                  <span>KELUAR</span>
                </a>
              </li>
            </ul>
          </section>
        </aside>
        <!-- jQuery 3 -->
        <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/leaflet/leaflet.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/leaflet-search/src/leaflet-search.js"></script>
