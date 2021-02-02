<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {
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
    if($this->session->userdata('level')!="admin"){
      redirect(base_url().'welcome/notfound');
  }
}
  // CRUD KATEGORI
  public function kategori()
  {
    $data['kategori'] = $this->m_data->get_data('kategori')->result();
    $data['msg'] = $this->session->flashdata('msg');
    $this->load->view('dashboard/v_header');
    $this->load->view('view_admin/v_kategori',$data);
    $this->load->view('dashboard/v_footer');
  }
  // fungsi tambah kategori
  public function kategori_tambah()
  {
    $this->load->view('dashboard/v_header');
    $this->load->view('view_admin/v_kategori_tambah');
    $this->load->view('dashboard/v_footer');
  }
  // fungsi kategori aksi
  public function kategori_aksi()
  {
    $this->form_validation->set_rules('kategori','Kategori','required');
    if($this->form_validation->run() != false){
      $kategori = $this->input->post('kategori');
      $data = array(
        'kategori_nama' => $kategori,
        'kategori_slug' => strtolower(url_title($kategori))
      );
      $this->m_data->insert_data($data,'kategori');
      $this->session->set_flashdata('msg', ' Ditambahkan');
      redirect(base_url().'admin/kategori');
    }else{
      $this->load->view('dashboard/v_header');
      $this->load->view('view_admin/v_kategori_tambah');
      $this->load->view('dashboard/v_footer');
    }
  }
  // fungsi edit kategori
  public function kategori_edit($id)
  {
    $where = array(
      'kategori_id' => $id
    );
    $data['kategori'] = $this->m_data->edit_data($where,'kategori')->result();
    $this->load->view('dashboard/v_header');
    $this->load->view('view_admin/v_kategori_edit',$data);
    $this->load->view('dashboard/v_footer');
  }
  // fungsi update kategori
  public function kategori_update()
  {
    $this->form_validation->set_rules('kategori','Kategori','required');
    if($this->form_validation->run() != false){
      $id = $this->input->post('id');
      $kategori = $this->input->post('kategori');
      $where = array(
        'kategori_id' => $id
      );
      $data = array(
        'kategori_nama' => $kategori,
        'kategori_slug' => strtolower(url_title($kategori))
      );
      $this->m_data->update_data($where, $data,'kategori');
      $this->session->set_flashdata('msg', ' Diubah');
      redirect(base_url().'admin/kategori');
    }else{
      $id = $this->input->post('id');
      $where = array(
        'kategori_id' => $id
      );
      $data['kategori'] = $this->m_data->edit_data($where,'kategori')->result();
      $this->load->view('dashboard/v_header');
      $this->load->view('view_admin/v_kategori_edit',$data);
      $this->load->view('dashboard/v_footer');
    }
  }
  // fungsi hapus kategori
  public function kategori_hapus($id)
  {
    $where = array(
      'kategori_id' => $id
    );
    $this->m_data->delete_data($where,'kategori');
    $this->session->set_flashdata('msg', ' Dihapus');
    redirect(base_url().'admin/kategori');
  }

  // Akhir dari fungsi kategori

  // Fungsi tambah artikel
  public function artikel_tambah()
  {
    $data['kategori'] = $this->m_data->get_data('kategori')->result();
    $this->load->view('dashboard/v_header');
    $this->load->view('view_admin/v_artikel_tambah',$data);
    $this->load->view('dashboard/v_footer');
  }
  // Fungsi artikel aksi
  public function artikel_aksi()
  {
    // Wajib isi judul,konten dan kategori
    $this->form_validation->set_rules('judul','Judul','required|is_unique[artikel.artikel_judul]');
    $this->form_validation->set_rules('konten','Konten','required');
    $this->form_validation->set_rules('kategori','Kategori','required');
    // Membuat gambar wajib di isi
    if (empty($_FILES['sampul']['name'])){
      $this->form_validation->set_rules('sampul', 'Gambar Sampul', 'required');
    }
    if($this->form_validation->run() != false){
      $config['upload_path'] = './gambar/artikel/';
      $config['allowed_types'] = 'gif|jpg|png';
      $this->load->library('upload', $config);
      if ($this->upload->do_upload('sampul')) {
        // mengambil data tentang gambar
        $gambar = $this->upload->data();
        $tanggal = date('Y-m-d H:i:s');
        $judul = $this->input->post('judul');
        $slug = strtolower(url_title($judul));
        $konten = $this->input->post('konten');
        $sampul = $gambar['file_name'];
        $author = $this->session->userdata('id');
        $kategori = $this->input->post('kategori');
        $status = $this->input->post('status');
        $data = array(
          'artikel_tanggal' => $tanggal,
          'artikel_judul' => $judul,
          'artikel_slug' => $slug,
          'artikel_konten' => $konten,
          'artikel_sampul' => $sampul,
          'artikel_author' => $author,
          'artikel_kategori' => $kategori,
          'artikel_status' => $status,
        );
        $this->m_data->insert_data($data,'artikel');
        redirect(base_url().'admin/artikel');
      } else {
        $this->form_validation->set_message('sampul', $data['gambar_error'] = $this->upload->display_errors());
        $data['kategori'] = $this->m_data->get_data('kategori')->result();
        $this->load->view('dashboard/v_header');
        $this->load->view('view_admin/v_artikel_tambah',$data);
        $this->load->view('dashboard/v_footer');
      }
    }else{
      $data['kategori'] = $this->m_data->get_data('kategori')->result();
      $this->load->view('dashboard/v_header');
      $this->load->view('view_admin/v_artikel_tambah',$data);
      $this->load->view('dashboard/v_footer');
    }
  }
  // Fungsi Artikel Edit
  public function artikel_edit($id)
  {
    $where = array(
      'artikel_id' => $id
    );
    $data['artikel'] = $this->m_data->edit_data($where,'artikel')->result();
    $data['kategori'] = $this->m_data->get_data('kategori')->result();
    $this->load->view('dashboard/v_header');
    $this->load->view('view_admin/v_artikel_edit',$data);
    $this->load->view('dashboard/v_footer');
  }
  // Fungsi Artikel Update
  public function artikel_update()
  {
    // Wajib isi judul,konten dan kategori
    $this->form_validation->set_rules('judul','Judul','required');
    $this->form_validation->set_rules('konten','Konten','required');
    $this->form_validation->set_rules('kategori','Kategori','required');
    if($this->form_validation->run() != false){
      $id = $this->input->post('id');
      $judul = $this->input->post('judul');
      $slug = strtolower(url_title($judul));
      $konten = $this->input->post('konten');
      $kategori = $this->input->post('kategori');
      $status = $this->input->post('status');
      $where = array(
        'artikel_id' => $id
      );
      $data = array(
        'artikel_judul' => $judul,
        'artikel_slug' => $slug,
        'artikel_konten' => $konten,
        'artikel_kategori' => $kategori,
        'artikel_status' => $status,
      );
      $this->m_data->update_data($where,$data,'artikel');
      if (!empty($_FILES['sampul']['name'])){
        $config['upload_path'] = './gambar/artikel/';
        $config['allowed_types'] = 'gif|jpg|png';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('sampul')) {
          // mengambil data tentang gambar
          $gambar = $this->upload->data();
          $data = array(
            'artikel_sampul' => $gambar['file_name'],
          );
          $this->m_data->update_data($where,$data,'artikel');
          redirect(base_url().'dashboard/artikel');
        } else {
          $this->form_validation->set_message('sampul', $data['gambar_error'] = $this->upload->display_errors());
          $where = array(
            'artikel_id' => $id
          );
          $data['artikel'] = $this->m_data->edit_data($where,'artikel')->result();
          $data['kategori'] = $this->m_data->get_data('kategori')->result();
          $this->load->view('dashboard/v_header');
          $this->load->view('view_admin/v_artikel_edit',$data);
          $this->load->view('dashboard/v_footer');
        }
      }else{
        redirect(base_url().'dashboard/artikel');
      }
    }else{
      $id = $this->input->post('id');
      $where = array(
        'artikel_id' => $id
      );
      $data['artikel'] = $this->m_data->edit_data($where,'artikel')->result();
      $data['kategori'] = $this->m_data->get_data('kategori')->result();
      $this->load->view('dashboard/v_header');
      $this->load->view('view_admin/v_artikel_edit',$data);
      $this->load->view('dashboard/v_footer');
    }
  }
  // Fungsi hapus artikel
  public function artikel_hapus($id)
  {
    $where = array(
      'artikel_id' => $id
    );
    $this->db->where('artikel_id',$id);
    $query = $this->m_data->get_data('artikel');
    $row = $query->row();

    unlink("./gambar/artikel/$row->artikel_sampul");
    $this->m_data->delete_data($where,'artikel');
    redirect(base_url().'dashboard/artikel');
  }


  // Akhir dari fungsi artikel

  // Fungsi halaman
    public function pages()
    {
      $data['halaman'] = $this->m_data->get_data('halaman')->result();
      $this->load->view('dashboard/v_header');
      $this->load->view('view_admin/v_pages',$data);
      $this->load->view('dashboard/v_footer');
    }
    // Fungsi tambah halaman
    public function pages_tambah()
    {
      $this->load->view('dashboard/v_header');
      $this->load->view('view_admin/v_pages_tambah');
      $this->load->view('dashboard/v_footer');
    }
    // Fungsi halaman aksi
    public function pages_aksi()
    {
      // Wajib isi judul,konten
      $this->form_validation->set_rules('judul','Judul','required|is_unique[halaman.halaman_judul]');
      $this->form_validation->set_rules('konten','Konten','required');
      if($this->form_validation->run() != false){
        $judul = $this->input->post('judul');
        $slug = strtolower(url_title($judul));
        $konten = $this->input->post('konten');
        $data = array(
          'halaman_judul' => $judul,
          'halaman_slug' => $slug,
          'halaman_konten' => $konten
        );
        $this->m_data->insert_data($data,'halaman');
        // alihkan kembali ke method pages
        redirect(base_url().'admin/pages');
      }else{
        $this->load->view('dashboard/v_header');
        $this->load->view('view_admin/v_pages_tambah');
        $this->load->view('dashboard/v_footer');
      }
    }
    // Fungsi edit halaman
    public function pages_edit($id)
    {
      $where = array(
        'halaman_id' => $id
      );
      $data['halaman'] = $this->m_data->edit_data($where,'halaman')->result();
      $this->load->view('dashboard/v_header');
      $this->load->view('view_admin/v_pages_edit',$data);
      $this->load->view('dashboard/v_footer');
    }
    // Fungsi update halaman
    public function pages_update()
    {
      // Wajib isi judul,konten
      $this->form_validation->set_rules('judul','Judul','required');
      $this->form_validation->set_rules('konten','Konten','required');
      if($this->form_validation->run() != false){
        $id = $this->input->post('id');
        $judul = $this->input->post('judul');
        $slug = strtolower(url_title($judul));
        $konten = $this->input->post('konten');
        $where = array(
          'halaman_id' => $id
        );
        $data = array(
          'halaman_judul' => $judul,
          'halaman_slug' => $slug,
          'halaman_konten' => $konten
        );
        $this->m_data->update_data($where,$data,'halaman');
        redirect(base_url().'admin/pages');
      }else{
        $id = $this->input->post('id');
        $where = array(
          'halaman_id' => $id
        );
        $data['halaman'] = $this->m_data->edit_data($where,'halaman')->result();
        $this->load->view('dashboard/v_header');
        $this->load->view('view_admin/v_pages_edit',$data);
        $this->load->view('dashboard/v_footer');
      }
    }
    // Fungsi hapus halaman
    public function pages_hapus($id)
    {
      $where = array(
        'halaman_id' => $id
      );
      $this->m_data->delete_data($where,'halaman');
      redirect(base_url().'admin/pages');
    }

    // Akhir fungsi halaman

    // Fungsi pengaturan
    public function pengaturan()
    {
      $data['pengaturan'] = $this->m_data->get_data('pengaturan')->result();
      $this->load->view('dashboard/v_header');
      $this->load->view('view_admin/v_pengaturan',$data);
      $this->load->view('dashboard/v_footer');
    }
    // Fungsi update pengaturan
    public function pengaturan_update()
    {
      // Wajib isi nama dan deskripsi website
      $this->form_validation->set_rules('nama','Nama Website','required');
      $this->form_validation->set_rules('deskripsi','Deskripsi Website','required');

      if($this->form_validation->run() != false){
        $nama = $this->input->post('nama');
        $deskripsi = $this->input->post('deskripsi');
        $link_facebook = $this->input->post('link_facebook');
        $link_twitter = $this->input->post('link_twitter');
        $link_instagram = $this->input->post('link_instagram');
        $link_github = $this->input->post('link_github');
        $where = array(
        );
        $data = array(
          'nama' => $nama,
          'deskripsi' => $deskripsi,
          'link_facebook' => $link_facebook,
          'link_twitter' => $link_twitter,
          'link_instagram' => $link_instagram,
          'link_github' => $link_github
        );
        // update pengaturan
        $this->m_data->update_data($where,$data,'pengaturan');
        // Periksa apakah ada gambar logo yang diupload
        if (!empty($_FILES['logo']['name'])){
          $config['upload_path'] = './gambar/website/';
          $config['allowed_types'] = 'jpg|png';
          $this->load->library('upload', $config);
          if ($this->upload->do_upload('logo')) {
            // mengambil data tentang gambar logo yang diupload
            $gambar = $this->upload->data();
            $logo = $gambar['file_name'];
            $this->db->query("UPDATE pengaturan SET logo='$logo'");
          }
        }
        redirect(base_url().'admin/pengaturan/?alert=sukses');
      }else{
        $data['pengaturan'] = $this->m_data->get_data('pengaturan')->result();
        $this->load->view('dashboard/v_header');
        $this->load->view('view_admin/v_pengaturan',$data);
        $this->load->view('dashboard/v_footer');
      }
    }
    // akhir fungsi pengaturan
    // fungsi hak akses dan pengguna
    // CRUD PENGGUNA
    public function pengguna()
    {
      $data['pengguna'] = $this->m_data->get_data('pengguna')->result();
      $this->load->view('dashboard/v_header');
      $this->load->view('view_admin/v_pengguna',$data);
      $this->load->view('dashboard/v_footer');
    }
    // CRUD Pengguna tambah
    public function pengguna_tambah()
    {
      $this->load->view('dashboard/v_header');
      $this->load->view('view_admin/v_pengguna_tambah');
      $this->load->view('dashboard/v_footer');
    }
    // CRUD Pengguna tambah aksi
    public function pengguna_aksi()
    {
      // Wajib isi
      $this->form_validation->set_rules('nama','Nama Pengguna','required');
      $this->form_validation->set_rules('email','Email Pengguna','required');
      $this->form_validation->set_rules('username','Username Pengguna','required');
      $this->form_validation->set_rules('password','Password Pengguna','required|min_length[8]');
      $this->form_validation->set_rules('level','Level Pengguna','required');
      $this->form_validation->set_rules('status','Status Pengguna','required');

      if($this->form_validation->run() != false){
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));
        $level = $this->input->post('level');
        $status = $this->input->post('status');

        $data = array(
          'pengguna_nama' => $nama,
          'pengguna_email' => $email,
          'pengguna_username' => $username,
          'pengguna_password' => $password,
          'pengguna_level' => $level,
          'pengguna_status' => $status
        );
        $this->m_data->insert_data($data,'pengguna');
        redirect(base_url().'admin/pengguna');
      }else{
        $this->load->view('dashboard/v_header');
        $this->load->view('view_admin/v_pengguna_tambah');
        $this->load->view('dashboard/v_footer');
      }
    }
    //CRUD pengguna edit
    public function pengguna_edit($id)
    {
      $where = array(
        'pengguna_id' => $id
      );
      $data['pengguna'] = $this->m_data->edit_data($where,'pengguna')->result();
      $this->load->view('dashboard/v_header');
      $this->load->view('view_admin/v_pengguna_edit',$data);
      $this->load->view('dashboard/v_footer');
    }
    // CRUD pengguna update
    public function pengguna_update()
    {
      // Wajib isi
      $this->form_validation->set_rules('nama','Nama Pengguna','required');
      $this->form_validation->set_rules('email','Email Pengguna','required');
      $this->form_validation->set_rules('username','Username Pengguna','required');
      $this->form_validation->set_rules('level','Level Pengguna','required');
      $this->form_validation->set_rules('status','Status Pengguna','required');

      if($this->form_validation->run() != false){
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));
        $level = $this->input->post('level');
        $status = $this->input->post('status');
        //cek jika form password tidak diisi, maka jangan update kolum password, dan sebaliknya
        if($this->input->post('password') == ""){
          $data = array(
            'pengguna_nama' => $nama,
            'pengguna_email' => $email,
            'pengguna_username' => $username,
            'pengguna_level' => $level,
            'pengguna_status' => $status
          );
        }else{
          $data = array(
            'pengguna_nama' => $nama,
            'pengguna_email' => $email,
            'pengguna_username' => $username,
            'pengguna_password' => $password,
            'pengguna_level' => $level,
            'pengguna_status' => $status
          );
        }
        $where = array(
          'pengguna_id' => $id
        );
        $this->m_data->update_data($where,$data,'pengguna');
        redirect(base_url().'admin/pengguna');
      }else{
        $id = $this->input->post('id');
        $where = array(
          'pengguna_id' => $id
        );
        $data['pengguna'] = $this->m_data->edit_data($where,'pengguna')->result();
        $this->load->view('dashboard/v_header');
        $this->load->view('view_admin/v_pengguna_edit',$data);
        $this->load->view('dashboard/v_footer');
      }
    }
    //CRUD pengguna hapus
    public function pengguna_hapus($id)
    {
      $where = array(
        'pengguna_id' => $id
      );
      $data['pengguna_hapus'] = $this->m_data->edit_data($where,'pengguna')->row();
      $data['pengguna_lain'] = $this->db->query("SELECT * FROM pengguna WHERE pengguna_id != $id")->result();
        $this->load->view('dashboard/v_header');
        $this->load->view('view_admin/v_pengguna_hapus',$data);
        $this->load->view('dashboard/v_footer');
      }
      // CRUD pengguna hapus aksi
      public function pengguna_hapus_aksi()
      {
        $pengguna_hapus = $this->input->post('pengguna_hapus');
        $pengguna_tujuan = $this->input->post('pengguna_tujuan');
        // hapus pengguna
        $where = array(
          'pengguna_id' => $pengguna_hapus
        );
        $this->m_data->delete_data($where,'pengguna');
        // pindahkan semua artikel pengguna yang dihapus ke pengguna yang dipilih
        $w = array(
          'artikel_author' => $pengguna_hapus
        );
        $d = array(
          'artikel_author' => $pengguna_tujuan
        );
        $this->m_data->update_data($w,$d,'artikel');
        redirect(base_url().'admin/pengguna');
      }
      // end crud pengguna

      // CRUD SIG tambah
      public function sig_tambah()
      {
        $data['map'] = $this->m_data->get_data('map')->result();
        $data['msg'] = $this->session->flashdata('msg');
        $this->load->view('dashboard/v_header');
        $this->load->view('view_admin/v_sig_tambah',$data);
        $this->load->view('dashboard/v_footer');
      }
      // CRUD SIG tambah aksi
      public function sig_aksi()
      {
        // Wajib isi form
        $this->form_validation->set_rules('nama','Nama Lokasi','required');
        $this->form_validation->set_rules('deskripsi','Deskripsi','required');
        $this->form_validation->set_rules('alamat','Alamat','required');
        $this->form_validation->set_rules('lintang','Lintang Lokasi','required');
        $this->form_validation->set_rules('bujur','Bujur Lokasi','required');
        $this->form_validation->set_rules('status','Status','required');
        // Membuat gambar wajib di isi
        if (empty($_FILES['berkas']['name'])){
          $this->form_validation->set_rules('berkas', 'gambar lokasi', 'required');
        }
        if($this->form_validation->run() != false){

          $config['upload_path'] = './gambar/map/';
          $config['allowed_types'] = 'gif|jpg|png';

          $this->load->library('upload',$config);

          if ($this->upload->do_upload('berkas')) {
            // mengambil data tentang gambar
            $gambar = $this->upload->data();

            $berkas = $gambar['file_name'];
            $tanggal = date('Y-m-d H:i:s');
            $author = $this->session->userdata('id');
            $nama = $this->input->post('nama');
            $deskripsi = $this->input->post('deskripsi');
            $alamat = $this->input->post('alamat');
            $lintang = $this->input->post('lintang');
            $bujur = $this->input->post('bujur');
            $status = $this->input->post('status');
            // load QR Code
            $this->load->library('ciqrcode'); //pemanggilan library QR CODE
            $config['cacheable']    = true; //boolean, the default is true
            $config['cachedir']     = 'application/cache/'; //string, the default is application/cache/
            $config['errorlog']     = 'application/logs/'; //string, the default is application/logs/
            $config['imagedir']     = './gambar/qrcode/'; //direktori penyimpanan qr code
            $config['quality']      = true; //boolean, the default is true
            $config['size']         = '1024'; //interger, the default is 1024
            $config['black']        = array(224,255,255); // array, default is array(255,255,255)
            $config['white']        = array(70,130,180); // array, default is array(0,0,0)
            $this->ciqrcode->initialize($config);

            $image_name=$nama.'.png'; //buat name dari qr code sesuai dengan nim

            $params['data'] = $nama; //data yang akan di jadikan QR CODE
            $params['level'] = 'H'; //H=High
            $params['size'] = 10;
            $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
            $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

            $data = array(
              'nama_lokasi' => $nama,
              'map_author' => $author,
              'map_tanggal' => $tanggal,
              'deskripsi_lokasi' => $deskripsi,
              'alamat_lokasi' => $alamat,
              'lintang_lokasi' => $lintang,
              'bujur_lokasi' => $bujur,
              'status_lokasi' => $status,
              'gambar_lokasi' => $berkas,
              'qr_code' => $image_name,
            );
            $this->m_data->insert_data($data,'map');
            $this->session->set_flashdata('msg', ' Ditambahkan');
            redirect(base_url().'admin/sig_tambah');
          } else {
            $this->form_validation->set_message('berkas', $data['gambar_error'] = $this->upload->display_errors());
            $data['map'] = $this->m_data->get_data('map')->result();
            $this->load->view('dashboard/v_header');
            $this->load->view('view_admin/v_sig_tambah',$data);
            $this->load->view('dashboard/v_footer');
          }
        }else{
          $data['map'] = $this->m_data->get_data('map')->result();
          $this->load->view('dashboard/v_header');
          $this->load->view('view_admin/v_sig_tambah',$data);
          $this->load->view('dashboard/v_footer');
        }
      }
      //CRUD SIG edit
      public function sig_edit($id)
      {
        $where = array(
          'map_id' => $id
        );
        $data['map'] = $this->m_data->edit_data($where,'map')->result();
        $this->load->view('dashboard/v_header');
        $this->load->view('view_admin/v_sig_edit',$data);
        $this->load->view('dashboard/v_footer');
      }
      // CRUD SIG update
      public function sig_update()
      {
        // Wajib isi judul,konten dan kategori
        $this->form_validation->set_rules('nama','Nama Lokasi','required');
        $this->form_validation->set_rules('deskripsi','Deskripsi','required');
        $this->form_validation->set_rules('alamat','Alamat','required');
        $this->form_validation->set_rules('lintang','Lintang Lokasi','required');
        $this->form_validation->set_rules('bujur','Bujur Lokasi','required');
        $this->form_validation->set_rules('status','Status','required');
        if($this->form_validation->run() != false){
          $id = $this->input->post('id');
          $nama = $this->input->post('nama');
          $tanggal = date('Y-m-d H:i:s');
          $deskripsi = $this->input->post('deskripsi');
          $alamat = $this->input->post('alamat');
          $lintang = $this->input->post('lintang');
          $bujur = $this->input->post('bujur');
          $status = $this->input->post('status');
          $where = array(
            'map_id' => $id
          );
          $data = array(
            'nama_lokasi' => $nama,
            'map_tanggal' => $tanggal,
            'deskripsi_lokasi' => $deskripsi,
            'alamat_lokasi' => $alamat,
            'lintang_lokasi' => $lintang,
            'bujur_lokasi' => $bujur,
            'status_lokasi' => $status,
          );
          $this->m_data->update_data($where,$data,'map');
          if (!empty($_FILES['berkas']['name'])){
            $config['upload_path'] = './gambar/map/';
            $config['allowed_types'] = 'gif|jpg|png';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('berkas')) {
              // mengambil data tentang gambar
              $gambar = $this->upload->data();
              $data = array(
                'gambar_lokasi' => $gambar['file_name'],
              );
              $this->m_data->update_data($where,$data,'map');
              $this->session->set_flashdata('msg', ' Diubah');
              redirect(base_url().'dashboard/sig');
            } else {
              $this->form_validation->set_message('berkas', $data['gambar_error'] = $this->upload->display_errors());
              $where = array(
                'map_id' => $id
              );
              $data['map'] = $this->m_data->edit_data($where,'map')->result();
              $data['map'] = $this->m_data->get_data('map')->result();
              $this->load->view('dashboard/v_header');
              $this->load->view('view_admin/v_sig_edit',$data);
              $this->load->view('dashboard/v_footer');
            }
          }else{
            $this->session->set_flashdata('msg', ' Diubah');
            redirect(base_url().'dashboard/sig');
          }
        }else{
          $id = $this->input->post('id');
          $where = array(
            'map_id' => $id
          );
          $data['map'] = $this->m_data->edit_data($where,'map')->result();
          $data['map'] = $this->m_data->get_data('map')->result();
          $this->load->view('dashboard/v_header');
          $this->load->view('view_admin/v_sig_edit',$data);
          $this->load->view('dashboard/v_footer');
        }
      }
      //CRUD SIG hapus
      public function sig_hapus($id)
      {
        $where = array(
          'map_id' => $id
        );
        $this->db->where('map_id',$id);
        $query = $this->m_data->get_data('map');
        $row = $query->row();

        unlink("./gambar/map/$row->gambar_lokasi");
        $this->m_data->delete_data($where,'map');
        $this->session->set_flashdata('msg', ' Dihapus');
        redirect(base_url().'dashboard/sig');
      }
      // end crud SIG

      //CRUD Donasi edit
      public function donasi_edit($id)
      {
        $where = array(
          'donasi_id' => $id
        );
        $data['donasi'] = $this->m_data->get_data('donasi')->result();
        $data['donasi'] = $this->m_data->edit_data($where,'donasi')->result();
        $data['artikel'] = $this->db->query("SELECT * FROM artikel,kategori WHERE artikel.artikel_kategori=kategori.kategori_id AND kategori.kategori_nama='Event' AND artikel.artikel_status='publish' order by artikel_id desc")->result();
        $this->load->view('dashboard/v_header');
        $this->load->view('view_admin/v_donasi_edit',$data);
        $this->load->view('dashboard/v_footer');
      }
      // CRUD SIG update
      public function donasi_update()
      {
        // Wajib isi form
        $this->form_validation->set_rules('nama_event','Nama Event','required');
        $this->form_validation->set_rules('jumlah_donasi','Jumlah Donasi','required');
        $this->form_validation->set_rules('status_donasi','Status','required');

        if($this->form_validation->run() != false){
          $id = $this->input->post('id');
          $namaevent = $this->input->post('nama_event');
          $jumlahdonasi = $this->input->post('jumlah_donasi');
          $status = $this->input->post('status_donasi');
          $where = array(
            'donasi_id' => $id
          );
          $data = array(
            'artikel_id' => $namaevent,
            'jumlah_donasi' =>$jumlahdonasi,
            'status_donasi' =>$status,
          );
          $this->m_data->update_data($where,$data,'donasi');
          if (!empty($_FILES['struk']['name'])){
            $config['upload_path'] = './gambar/donasi/';
            $config['allowed_types'] = 'gif|jpg|png';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('struk')) {
              // mengambil data tentang gambar
              $gambar = $this->upload->data();
              $data = array(
                'struk' => $gambar['file_name'],
              );
              $this->m_data->update_data($where,$data,'donasi');
              $this->session->set_flashdata('msg', ' Diubah');
              redirect(base_url().'dashboard/donasi');
            } else {
              $this->form_validation->set_message('struk', $data['gambar_error'] = $this->upload->display_errors());
              $where = array(
                'donasi_id' => $id
              );
              $data['donasi'] = $this->m_data->get_data('donasi')->result();
              $data['donasi'] = $this->m_data->edit_data($where,'donasi')->result();
              $data['artikel'] = $this->db->query("SELECT * FROM artikel,kategori WHERE artikel.artikel_kategori=kategori.kategori_id AND kategori.kategori_nama='Event' AND artikel.artikel_status='publish' order by artikel_id desc")->result();
              $this->load->view('dashboard/v_header');
              $this->load->view('view_admin/v_donasi_edit',$data);
              $this->load->view('dashboard/v_footer');
            }
          }else{
            $this->session->set_flashdata('msg', ' Diubah');
            redirect(base_url().'dashboard/donasi');
          }
        }else{
          $id = $this->input->post('id');
          $where = array(
            'donasi_id' => $id
          );
          $data['donasi'] = $this->m_data->get_data('donasi')->result();
          $data['donasi'] = $this->m_data->edit_data($where,'donasi')->result();
          $data['artikel'] = $this->db->query("SELECT * FROM artikel,kategori WHERE artikel.artikel_kategori=kategori.kategori_id AND kategori.kategori_nama='Event' AND artikel.artikel_status='publish' order by artikel_id desc")->result();
          $this->load->view('dashboard/v_header');
          $this->load->view('view_admin/v_donasi_edit',$data);
          $this->load->view('dashboard/v_footer');
        }
      }
      //CRUD Donasi hapus
      public function donasi_hapus($id)
      {
        $where = array(
          'donasi_id' => $id
        );
        $this->db->where('donasi_id',$id);
        $query = $this->m_data->get_data('donasi');
        $row = $query->row();

        unlink("./gambar/donasi/$row->struk");
        unlink("./gambar/barcode/$row->barcode");
        $this->m_data->delete_data($where,'donasi');
        $this->session->set_flashdata('msg', ' Dihapus');
        redirect(base_url().'dashboard/donasi');
      }

      // Donatur Fungsi
      // CRUD Donatur
      public function donatur()
      {
        $data['donatur'] = $this->db->query("SELECT * FROM donasi,artikel,pengguna WHERE pengguna.pengguna_id=donasi.pengguna_id AND artikel.artikel_id=donasi.artikel_id ORDER BY donasi.donasi_id DESC")->result();
        $data['msg'] = $this->session->flashdata('msg');
        $this->load->view('dashboard/v_header');
        $this->load->view('view_admin/v_donatur',$data);
        $this->load->view('dashboard/v_footer');
      }

      //CRUD SIG edit
      public function donatur_edit($id)
      {
        $where = array(
          'donasi_id' => $id
        );
        $data['donatur'] = $this->m_data->get_data('donasi')->result();
        $data['donatur'] = $this->m_data->edit_data($where,'donasi')->result();
        $data['artikel'] = $this->db->query("SELECT * FROM artikel,kategori WHERE artikel.artikel_kategori=kategori.kategori_id AND kategori.kategori_nama='Event' order by artikel_id desc")->result();
        $this->load->view('dashboard/v_header');
        $this->load->view('view_admin/v_donatur_edit',$data);
        $this->load->view('dashboard/v_footer');
      }
      // CRUD Donatur update
      public function donatur_update()
      {
        // Wajib isi form
        $this->form_validation->set_rules('nama_event','Nama Event','required');
        $this->form_validation->set_rules('jumlah_donasi','Jumlah Donasi','required');
        $this->form_validation->set_rules('status_donasi','Status','required');

        if($this->form_validation->run() != false){
          $id = $this->input->post('id');
          $namaevent = $this->input->post('nama_event');
          $jumlahdonasi = $this->input->post('jumlah_donasi');
          $status = $this->input->post('status_donasi');
          $where = array(
            'donasi_id' => $id
          );
          $data = array(
            'artikel_id' => $namaevent,
            'jumlah_donasi' =>$jumlahdonasi,
            'status_donasi' =>$status,
          );
          $this->m_data->update_data($where,$data,'donasi');
          $this->session->set_flashdata('msg', ' Diubah');
          if (!empty($_FILES['struk']['name'])){
            $config['upload_path'] = './gambar/donasi/';
            $config['allowed_types'] = 'gif|jpg|png';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('struk')) {
              // mengambil data tentang gambar
              $gambar = $this->upload->data();
              $data = array(
                'struk' => $gambar['file_name'],
              );
              $this->m_data->update_data($where,$data,'donasi');
              $this->session->set_flashdata('msg', ' Diubah');
              redirect(base_url().'admin/donatur');
            } else {
              $this->form_validation->set_message('struk', $data['gambar_error'] = $this->upload->display_errors());
              $where = array(
                'donasi_id' => $id
              );
              $data['donasi'] = $this->m_data->get_data('donasi')->result();
              $data['donasi'] = $this->m_data->edit_data($where,'donasi')->result();
              $data['artikel'] = $this->db->query("SELECT * FROM artikel,kategori WHERE artikel.artikel_kategori=kategori.kategori_id AND kategori.kategori_nama='Event' order by artikel_id desc")->result();
              $this->load->view('dashboard/v_header');
              $this->load->view('view_admin/v_donasi_edit',$data);
              $this->load->view('dashboard/v_footer');
            }
          }else{
            $this->session->set_flashdata('msg', ' Diubah');
            redirect(base_url().'admin/donatur');
          }
        }else{
          $id = $this->input->post('id');
          $where = array(
            'donasi_id' => $id
          );
          $data['donasi'] = $this->m_data->get_data('donasi')->result();
          $data['donasi'] = $this->m_data->edit_data($where,'donasi')->result();
          $data['artikel'] = $this->db->query("SELECT * FROM artikel,kategori WHERE artikel.artikel_kategori=kategori.kategori_id AND kategori.kategori_nama='Event' order by artikel_id desc")->result();
          $this->load->view('dashboard/v_header');
          $this->load->view('view_admin/v_donasi_edit',$data);
          $this->load->view('dashboard/v_footer');
        }
      }
      //CRUD donatur hapus
      public function donatur_hapus($id)
      {
        $where = array(
          'donasi_id' => $id
        );
        $this->db->where('donasi_id',$id);
        $query = $this->db->get('donasi');
        $row = $query->row();

        unlink("./gambar/donasi/$row->struk");
        unlink("./gambar/barcode/$row->barcode");
        $this->m_data->delete_data($where,'donasi');
        $this->session->set_flashdata('msg', ' Dihapus');
        redirect(base_url().'admin/donatur');
      }



}
?>
