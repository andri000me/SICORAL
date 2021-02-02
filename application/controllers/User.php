<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
  function __construct()
  {
    parent::__construct();
    date_default_timezone_set('Asia/Jakarta');
    $this->load->model('m_data');
    $this->load->library('fungsi');
    $this->load->library('zend');
    $this->load->library('ciqrcode');
    // cek session yang login,
    // jika session status tidak sama dengan session telah_login, berarti pengguna belum login
    // maka halaman akan di alihkan kembali ke halaman login.
    if($this->session->userdata('status')!="telah_login" && $this->session->userdata('level')!="penulis" ){
      redirect(base_url().'login?alert=belum_login');
    }
  }


}
?>
