<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {
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
    if($this->session->userdata('status')!="telah_login"){
      redirect(base_url().'login?alert=belum_login');
    }
  }

  public function index()
  {
    // hitung jumlah artikel
    $data['jumlah_artikel'] = $this->m_data->get_data('artikel')->num_rows();
    // hitung jumlah kategori
    $data['jumlah_kategori'] = $this->m_data->get_data('kategori')->num_rows();
    // hitung jumlah pengguna
    $data['jumlah_pengguna'] = $this->m_data->get_data('pengguna')->num_rows();
    // hitung jumlah halaman
    $data['jumlah_halaman'] = $this->m_data->get_data('halaman')->num_rows();
    $this->load->view('dashboard/v_header');
    $this->load->view('dashboard/v_index',$data);
    $this->load->view('dashboard/v_footer');
  }

  public function keluar()
  {
    $this->session->sess_destroy();
    redirect('login?alert=logout');
  }

  public function ganti_password()
  {
    $this->load->view('dashboard/v_header');
    $this->load->view('dashboard/v_ganti_password');
    $this->load->view('dashboard/v_footer');
  }

  public function ganti_password_aksi()
  {
    // form validasi
    $this->form_validation->set_rules('password_lama','Password Lama','required');
    $this->form_validation->set_rules('password_baru','Password Baru','required|min_length[8]');
    $this->form_validation->set_rules('konfirmasi_password','Konfirmasi Password Baru','required|matches[password_baru]');
    // cek validasi
    if($this->form_validation->run() != false){
      // menangkap data dari form
      $password_lama = $this->input->post('password_lama');
      $password_baru = $this->input->post('password_baru');
      $konfirmasi_password = $this->input->post('konfirmasi_password');
      // cek kesesuaian password lama dengan id pengguna yang sedang login dan password lama
      $where = array(
        'pengguna_id' => $this->session->userdata('id'),
        'pengguna_password' => md5($password_lama)
      );

      $cek = $this->m_data->cek_login('pengguna', $where)->num_rows();
      // cek kesesuaikan password lama
      if($cek > 0){
        // update data password pengguna
        $where = array(
          'pengguna_id' => $this->session->userdata('id')
        );
        $data = array(
          'pengguna_password' => md5($password_baru)
        );
        $this->m_data->update_data($where, $data, 'pengguna');
        // alihkan halaman kembali ke halaman ganti password
        redirect('dashboard/ganti_password?alert=sukses');
      }else{
        // alihkan halaman kembali ke halaman ganti password
        redirect('dashboard/ganti_password?alert=gagal');
      }
    }else{
      $this->load->view('dashboard/v_header');
      $this->load->view('dashboard/v_ganti_password');
      $this->load->view('dashboard/v_footer');
    }
  }

  // Akhir fungsu ganti password
  // fungsi ARTIKEL
  public function artikel()
  {
    $data['artikel'] = $this->db->query("SELECT * FROM artikel,kategori,pengguna WHERE artikel_kategori=kategori_id and artikel_author=pengguna_id order by artikel_id desc")->result();
    $this->load->view('dashboard/v_header');
    $this->load->view('dashboard/v_artikel',$data);
    $this->load->view('dashboard/v_footer');
  }
  // Fungsi Profil
  public function profil()
  {
    // id pengguna yang sedang login
    $id_pengguna = $this->session->userdata('id');
    $where = array(
      'pengguna_id' => $id_pengguna
    );
    $data['profil'] = $this->m_data->edit_data($where,'pengguna')->result();
    $this->load->view('dashboard/v_header');
    $this->load->view('dashboard/v_profil',$data);
    $this->load->view('dashboard/v_footer');
  }
  // Fungsi Edit Profil
  public function profil_update()
  {
    // Wajib isi nama dan email
    $this->form_validation->set_rules('nama','Nama','required');
    $this->form_validation->set_rules('email','Email','required');
    if($this->form_validation->run() != false){
      $id = $this->session->userdata('id');
      $nama = $this->input->post('nama');
      $email = $this->input->post('email');
      $where = array(
        'pengguna_id' => $id
      );
      $data = array(
        'pengguna_nama' => $nama,
        'pengguna_email' => $email
      );
      $this->m_data->update_data($where,$data,'pengguna');
      redirect(base_url().'dashboard/profil/?alert=sukses');
    }else{
      // id pengguna yang sedang login
      $id_pengguna = $this->session->userdata('id');
      $where = array(
        'pengguna_id' => $id_pengguna
      );
      $data['profil'] = $this->m_data->edit_data($where,'pengguna')->result();
      $this->load->view('dashboard/v_header');
      $this->load->view('dashboard/v_profil',$data);
      $this->load->view('dashboard/v_footer');
    }
  }
  // Akhir fungsi profil

    // awal fungsi SIG
    public function sig()
    {
      $data['map'] = $this->m_data->get_data('map')->result();
      $data['msg'] = $this->session->flashdata('msg');
      $this->load->view('dashboard/v_header');
      $this->load->view('dashboard/v_sig',$data);
      $this->load->view('dashboard/v_footer');
    }
    // CRUD DONASI
    public function donasi()
    {
      // Pagination code awal
      // $this->load->database();
      $jumlah_data = $this->m_data->get_data('donasi')->num_rows();
      $this->load->library('pagination');
      $config['base_url'] = base_url().'dashboard/donasi/';
      $config['total_rows'] = $jumlah_data;
      $config['per_page'] = 5;
      $config['first_link'] = 'First';
      $config['last_link'] = 'Last';
      $config['next_link'] = 'Next';
      $config['prev_link'] = 'Prev';
      $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination justify-content-end">';
      $config['full_tag_close'] = '</ul></nav></div>';
      $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
      $config['num_tag_close'] = '</span></li>';
      $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
      $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
      $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
      $config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
      $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
      $config['prev_tagl_close'] = '</span>Next</li>';
      $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
      $config['first_tagl_close'] = '</span></li>';
      $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
      $config['last_tagl_close'] = '</span></li>';
      $from = $this->uri->segment(3);
      if($from==""){
        $from = 0;
      }
      $this->pagination->initialize($config);
      // pagination code akhir
      $id_pengguna = $this->session->userdata('id');
      $where = array(
        'pengguna_id' => $id_pengguna
      );
      $data['donasi'] = $this->m_data->edit_data($where,'donasi')->result();
      $data['donasi'] = $this->db->query("SELECT * FROM donasi JOIN pengguna ON donasi.pengguna_id=pengguna.pengguna_id JOIN artikel ON donasi.artikel_id=artikel.artikel_id WHERE donasi.pengguna_id='$id_pengguna' ORDER BY donasi.donasi_id DESC LIMIT $config[per_page] OFFSET $from")->result();
      $data['artikel'] = $this->db->query("SELECT * FROM artikel,kategori WHERE artikel.artikel_kategori=kategori.kategori_id AND kategori.kategori_nama='Event' AND artikel.artikel_status='publish' order by artikel_id desc")->result();
      $data['pengaturan'] = $this->m_data->get_data('pengaturan')->row();
      $data['msg'] = $this->session->flashdata('msg');
      $this->load->view('dashboard/v_header');
      $this->load->view('dashboard/v_donasi_tambah',$data);
      $this->load->view('dashboard/v_footer');
    }
    // CRUD Donasi tambah aksi
    public function donasi_aksi()
    {
      // Wajib isi form
      $this->form_validation->set_rules('nama_event','Nama Event','required');
      $this->form_validation->set_rules('jumlah_donasi','Jumlah Donasi','required');

      // Membuat gambar wajib di isi
      if (empty($_FILES['struk']['name'])){
        $this->form_validation->set_rules('struk', 'Bukti Transfer', 'required');
      }
      if($this->form_validation->run() != false){

        $config['upload_path'] = './gambar/donasi/';
        $config['allowed_types'] = 'gif|jpg|png';

        $this->load->library('upload',$config);

        if ($this->upload->do_upload('struk')) {

          // mengambil data tentang gambar
          $gambar = $this->upload->data();

          $struk = $gambar['file_name'];
          $tanggal = date('Y-m-d H:i:s');
          $nomor = rand(1000,9999);
          $tglresi = date('dmY');
          $author = $this->session->userdata('id');
          $namaevent = $this->input->post('nama_event');
          $jumlahdonasi = $this->input->post('jumlah_donasi');
          $resi = $namaevent.$nomor.$tglresi;
          // load Zend Barcode
          $this->load->library('zend');
          $this->zend->load('Zend/Barcode');
          $image_resource = Zend_Barcode::factory('code128', 'image', array('text'=>$resi), array())->draw();
          $image_name     = $resi.'.jpg';
          $image_dir      = './gambar/barcode/'; // penyimpanan file barcode
          imagejpeg($image_resource, $image_dir.$image_name);
          $data = array(
            'nomor_resi' => $resi,
            'pengguna_id' => $author,
            'artikel_id' => $namaevent,
            'jumlah_donasi' => $jumlahdonasi,
            'tanggal_donasi' => $tanggal,
            'status_donasi' => 1,
            'struk' => $struk,
            'barcode' => $image_name,
          );
          $this->m_data->insert_data($data,'donasi');
          $this->session->set_flashdata('msg', ' Ditambahkan');
          redirect(base_url().'dashboard/donasi?alert=sukses');
        } else {
          $this->form_validation->set_message('struk', $data['gambar_error'] = $this->upload->display_errors());
          $jumlah_data = $this->m_data->get_data('donasi')->num_rows();
          $this->load->library('pagination');
          $config['base_url'] = base_url().'dashboard/donasi/';
          $config['total_rows'] = $jumlah_data;
          $config['per_page'] = 5;
          $config['first_link'] = 'First';
          $config['last_link'] = 'Last';
          $config['next_link'] = 'Next';
          $config['prev_link'] = 'Prev';
          $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination justify-content-end">';
          $config['full_tag_close'] = '</ul></nav></div>';
          $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
          $config['num_tag_close'] = '</span></li>';
          $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
          $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
          $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
          $config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
          $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
          $config['prev_tagl_close'] = '</span>Next</li>';
          $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
          $config['first_tagl_close'] = '</span></li>';
          $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
          $config['last_tagl_close'] = '</span></li>';
          $from = $this->uri->segment(3);
          if($from==""){
            $from = 0;
          }
          $this->pagination->initialize($config);
          $id_pengguna = $this->session->userdata('id');
          $data['donasi'] = $this->db->query("SELECT * FROM donasi JOIN pengguna ON donasi.pengguna_id=pengguna.pengguna_id JOIN artikel ON donasi.artikel_id=artikel.artikel_id WHERE donasi.pengguna_id='$id_pengguna' ORDER BY donasi.donasi_id DESC LIMIT $config[per_page] OFFSET $from")->result();
          $data['artikel'] = $this->db->query("SELECT * FROM artikel,kategori WHERE artikel.artikel_kategori=kategori.kategori_id AND kategori.kategori_nama='Event' AND artikel.artikel_status='publish' order by artikel_id desc")->result();
          $this->load->view('dashboard/v_header');
          $this->load->view('dashboard/v_donasi_tambah',$data);
          $this->load->view('dashboard/v_footer');
        }
      }else{
        $id_pengguna = $this->session->userdata('id');
        $jumlah_data = $this->m_data->get_data('donasi')->num_rows();
        $this->load->library('pagination');
        $config['base_url'] = base_url().'dashboard/donasi/';
        $config['total_rows'] = $jumlah_data;
        $config['per_page'] = 5;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination justify-content-end">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close'] = '</span>Next</li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close'] = '</span></li>';
        $from = $this->uri->segment(3);
        if($from==""){
          $from = 0;
        }
        $this->pagination->initialize($config);
        $data['donasi'] = $this->db->query("SELECT * FROM donasi JOIN pengguna ON donasi.pengguna_id=pengguna.pengguna_id JOIN artikel ON donasi.artikel_id=artikel.artikel_id WHERE donasi.pengguna_id='$id_pengguna' ORDER BY donasi.donasi_id DESC LIMIT $config[per_page] OFFSET $from")->result();
        $data['artikel'] = $this->db->query("SELECT * FROM artikel,kategori WHERE artikel.artikel_kategori=kategori.kategori_id AND kategori.kategori_nama='Event' AND artikel.artikel_status='publish' order by artikel_id desc")->result();
        $this->load->view('dashboard/v_header');
        $this->load->view('dashboard/v_donasi_tambah',$data);
        $this->load->view('dashboard/v_footer');
      }
    }


    // public function resi_donasi($id)
    // {
    //   $where = array(
    //     'donasi_id' => $id
    //   );
    //   $data['donasi'] = $this->m_data->get_data('donasi')->result();
    //   $data['donasi'] = $this->m_data->edit_data($where,'donasi')->result();
    //   $this->load->view('dashboard/v_header');
    //   $this->load->view('dashboard/v_resi_donasi',$data);
    //   $this->load->view('dashboard/v_footer');
    // }
    function print_resi($id)
    {
      $where = array(
        'donasi_id' => $id
      );
      $data['donasi'] = $this->m_data->get_data('donasi')->result();
      $data['donasi'] = $this->m_data->edit_data($where,'donasi')->result();
      $data['pengaturan'] = $this->m_data->get_data('pengaturan')->row();
      $html = $this->load->view('dashboard/v_resi_print', $data, true);
      $this->fungsi->PdfGenerator($html, 'Resi-'.$data['donasi']->nomor_resi , 'A4', 'landscape');
    }

    function orPrintQr($id)
    {
      $where = array(
        'donasi_id' => $id
      );
      $data['donasi'] = $this->m_data->get_data('donasi')->result();
      $data['donasi'] = $this->m_data->edit_data($where,'donasi')->row();
      $html = $this->load->view('dashboard/v_resi_printqr', $data, true);
      $this->fungsi->PdfGenerator($html, 'resi-'.$data['donasi']->nomor_resi , 'A4', 'landscape');
    }

    function tracking()
    {
      $this->load->view('dashboard/v_header');
      $this->load->view('dashboard/v_tracking');
      $this->load->view('dashboard/v_footer');
    }

    function tracking_aksi()
    {
      $resi= $this->input->post('resi');
      $data['track'] = $this->m_data->get_data('tracking')->result(); // menampilkan data pada tabel track
      $data['track'] = $this->db->query("SELECT * FROM tracking JOIN donasi ON tracking.donasi_id=donasi.donasi_id
                                                                JOIN pengguna ON tracking.pengguna_id=pengguna.pengguna_id
                                                                JOIN artikel ON tracking.artikel_id=artikel.artikel_id
                                                                WHERE (donasi.donasi_id LIKE '%.$resi.%') ORDER BY tracking.tracking_id DESC")->num_rows();
      $this->load->view('dashboard/v_header');
      $this->load->view('dashboard/v_cari', $data);
      $this->load->view('dashboard/v_footer');
    }




  }
