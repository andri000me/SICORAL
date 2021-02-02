-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Feb 2021 pada 15.46
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `website_ci`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatif`
--

CREATE TABLE `alternatif` (
  `alternatif_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `artikel`
--

CREATE TABLE `artikel` (
  `artikel_id` int(11) NOT NULL,
  `artikel_tanggal` datetime NOT NULL,
  `artikel_judul` varchar(255) NOT NULL,
  `artikel_slug` varchar(255) NOT NULL,
  `artikel_konten` longtext NOT NULL,
  `artikel_sampul` varchar(255) NOT NULL,
  `artikel_author` int(11) NOT NULL,
  `artikel_kategori` int(11) NOT NULL,
  `artikel_status` enum('publish','draft') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `artikel`
--

INSERT INTO `artikel` (`artikel_id`, `artikel_tanggal`, `artikel_judul`, `artikel_slug`, `artikel_konten`, `artikel_sampul`, `artikel_author`, `artikel_kategori`, `artikel_status`) VALUES
(8, '2020-11-09 00:22:29', 'PPSI', 'ppsi', '<p>Ini adalah pameran mahasiswa Universitas Mercubuana kelas reguler 2 Menteng</p>\r\n', 'logo_coral.png', 1, 56, 'publish'),
(9, '2020-11-10 22:24:04', 'Pembudidayaan Terumbu Karang ', 'pembudidayaan-terumbu-karang', '<p><strong>Jakarta, Humas LIPI.</strong>&nbsp;Tim peneliti Lembaga Ilmu Pengetahuan Indonesia (LIPI) dari Pusat Penelitian Oseanografi melihat kerusakan terumbu karang yang berakibat buruk bagi ekosistem laut masih terus terjadi belakangan ini. Kendati beragam upaya telah dilakukan pemerintah dan&nbsp;<em>stakeholders</em>&nbsp;terkait perbaikannya, namun pemerintah perlu lebih mempergencar lagi upaya itu. Utamanya, pemulihan kerusakan dengan budidaya terumbu karang.<br />\r\n&nbsp;<br />\r\n&ldquo;Budidaya terumbu karang bisa menjadi solusi untuk memelihara ekosistem terumbu karang yang rusak. Budidaya perlu digalakkan agar kondisi terumbu karang di Indonesia tetap terjaga kelestariannya,&rdquo; Kata Suharsono, peneliti senior Pusat Penelitian Oseanografi LIPI dalam&nbsp;<em>Media Briefing</em>&nbsp;&ldquo;Hasil-Hasil Riset Kelautan&rdquo; usai pembukaan&nbsp;<em>Oceanography Science Week</em>&nbsp;(OSW) 2018, Selasa (20/2/2018), di Jakarta.<br />\r\n&nbsp;<br />\r\nKendati demikian, Suharsono menyebutkan bahwa kesadaran dan pengetahuan masyarakat akan pentingnya terumbu karang saat ini masih rendah. Selain itu, ditambah dengan kapabilitas dan kapasitas&nbsp;<em>stakeholders</em>&nbsp;terkait masin minim dalam budidaya terumbu karang. &ldquo;Inilah yang perlu ditingkatkan dan diperhatikan oleh pemerintah,&rdquo; sambungnya.<br />\r\n&nbsp;<br />\r\nSelain mempergencar budidaya terumbu karang, Suharsono juga mendorong agar semua pemangku kepentingan bahu-membahu dalam mengurangi faktor penyebab kerusakan terumbu karang. &ldquo;Kesadaran bersama harus terus dipupuk agar terumbu karang tetap lestari,&rdquo; tuturnya.<br />\r\n&nbsp;<br />\r\nSelama ini, faktor signifikan penyebab kerusakan terumbu karang adalah perubahan iklim dan polusi akibat ulah manusia. Selain juga, faktor lain seperti penyakit, predasi maupun pemakaian alat tangkap nelayan yang juga merusak.<br />\r\n&nbsp;<br />\r\nIntan Suci Nurhati, peneliti Pusat Penelitian Oseanografi LIPI menambahkan, terumbu karang yang telah rusak biasanya tumbuh dalam kondisi rentan osteoporosis, yang akhirnya menjadi rapuh. Kasus ini banyak terjadi di Kepulauan Seribu, Jakarta.<br />\r\n&nbsp;<br />\r\nUntuk mengatasi permasalah ini, kata Intan, lagi-lagi faktor penyebab kerusakan perlu dicegah, terutama karena ulah manusia yang merusak ekosistem laut. Kesadaran akan pentingnya ekosistem laut perlu selalu ditumbuhkembangkan, salah satunya adalah dengan tidak membuang sampah ke laut.</p>\r\n', 'web_design21.jpg', 1, 56, 'publish');

-- --------------------------------------------------------

--
-- Struktur dari tabel `arus_kas`
--

CREATE TABLE `arus_kas` (
  `arus_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `barang_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `biaya_kategori`
--

CREATE TABLE `biaya_kategori` (
  `biaya_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `bukti_pengajuan`
--

CREATE TABLE `bukti_pengajuan` (
  `bukti_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `donasi`
--

CREATE TABLE `donasi` (
  `donasi_id` int(11) NOT NULL,
  `nomor_resi` varchar(50) NOT NULL,
  `pengguna_id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `jumlah_donasi` bigint(13) NOT NULL,
  `status_donasi` int(1) NOT NULL,
  `tanggal_donasi` datetime NOT NULL,
  `struk` varchar(255) NOT NULL,
  `barcode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `donasi`
--

INSERT INTO `donasi` (`donasi_id`, `nomor_resi`, `pengguna_id`, `artikel_id`, `jumlah_donasi`, `status_donasi`, `tanggal_donasi`, `struk`, `barcode`) VALUES
(16, '9772816112020', 1, 9, 25000, 1, '2020-11-16 00:26:30', 'logo_coral.png', '9772816112020.jpg'),
(17, '8652816112020', 1, 8, 35000, 1, '2020-11-16 00:26:45', 'nasi_goreng.jpg', '8652816112020.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `halaman`
--

CREATE TABLE `halaman` (
  `halaman_id` int(11) NOT NULL,
  `halaman_judul` varchar(255) NOT NULL,
  `halaman_slug` varchar(255) NOT NULL,
  `halaman_konten` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `halaman`
--

INSERT INTO `halaman` (`halaman_id`, `halaman_judul`, `halaman_slug`, `halaman_konten`) VALUES
(1, 'Kontak Kami', 'kontak-kami', '<p>Berikut ini adalah kontak yang dapat dihubungi:</p>\r\n\r\n<p>WhatsApp : 083879903136</p>\r\n\r\n<p>Email : sadamhusein77.sh@gmail.com</p>\r\n\r\n<p>Website : https://www.malasngoding.com</p>\r\n'),
(2, 'Tentang Kami', 'tentang-kami', '<h1><strong>What is Lorem Ipsum?</strong></h1>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n'),
(4, 'Layanan', 'layanan', '<p>Kualitas Layanan atau dalam bahasa Inggris Service quality adalah ketidaksesuaian antara harapan sebuah layanan dengan kinerja SQ = P - E. Sebuah Bisnis dengan kualitas layanan yang tinggi maka akan memenuhi kebutuhan pelanggan sementara sisanya secara kompetitif ekonomi</p>\r\n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `in_barang`
--

CREATE TABLE `in_barang` (
  `in_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` int(11) NOT NULL,
  `kategori_nama` varchar(255) NOT NULL,
  `kategori_slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `kategori_nama`, `kategori_slug`) VALUES
(56, 'Event', 'event');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `kriteria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `login_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `map`
--

CREATE TABLE `map` (
  `map_id` int(11) NOT NULL,
  `map_author` int(11) NOT NULL,
  `map_tanggal` datetime NOT NULL,
  `nama_lokasi` varchar(50) NOT NULL,
  `deskripsi_lokasi` longtext NOT NULL,
  `alamat_lokasi` varchar(255) NOT NULL,
  `lintang_lokasi` varchar(50) NOT NULL,
  `bujur_lokasi` varchar(50) NOT NULL,
  `gambar_lokasi` varchar(255) NOT NULL,
  `status_lokasi` int(11) NOT NULL,
  `qr_code` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `map`
--

INSERT INTO `map` (`map_id`, `map_author`, `map_tanggal`, `nama_lokasi`, `deskripsi_lokasi`, `alamat_lokasi`, `lintang_lokasi`, `bujur_lokasi`, `gambar_lokasi`, `status_lokasi`, `qr_code`) VALUES
(7, 1, '2020-11-16 00:21:47', 'Pantai Ancol', 'Ini adalah daerah pertama penanaman terumbukarang di daerah Jakarta', 'Daerah Khusus Ibukota Jakarta', '-6.1192554', '106.8478001', 'web_design2.jpg', 1, ''),
(8, 1, '2020-11-15 23:34:40', 'Pantai Anyer', 'Ini adalah pantai anyer Banten', 'Jl. Raya Anyer-Sirih, Sindanglaya, Serang, Banten 42167', '-6.0935689', '105.8870289', 'logo_coral4.png', 1, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `out_barang`
--

CREATE TABLE `out_barang` (
  `Out_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan`
--

CREATE TABLE `pengaturan` (
  `nama` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `logo` varchar(255) NOT NULL,
  `link_facebook` varchar(255) NOT NULL,
  `link_twitter` varchar(255) NOT NULL,
  `link_instagram` varchar(255) NOT NULL,
  `link_github` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengaturan`
--

INSERT INTO `pengaturan` (`nama`, `deskripsi`, `logo`, `link_facebook`, `link_twitter`, `link_instagram`, `link_github`) VALUES
('SI CORAL', 'Corel Reefs Reflect The Beauty of Indonesian Sea', 'logo_coral.png', '#', '#', '#', '#');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `pengguna_id` int(11) NOT NULL,
  `pengguna_nama` varchar(50) NOT NULL,
  `pengguna_email` varchar(255) NOT NULL,
  `pengguna_username` varchar(50) NOT NULL,
  `pengguna_password` varchar(255) NOT NULL,
  `pengguna_level` enum('admin','penulis') NOT NULL,
  `pengguna_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`pengguna_id`, `pengguna_nama`, `pengguna_email`, `pengguna_username`, `pengguna_password`, `pengguna_level`, `pengguna_status`) VALUES
(1, 'Sadam Husein77', 'sadamhusein77.sh@gmail.com', 'admin', '5e09d2375484aec5f74ef78277128cc9', 'admin', 1),
(2, 'Wak Johny', 'wakjohny@gmail.com', 'johny', 'd0b4449cf30599ceb527201ec5a86ef7', 'penulis', 1),
(3, 'Lucyana Aprianti', 'lucyanoaprianti@gmail.com', 'lucyprb', '00432636afcd89c6810af515516528cc', 'penulis', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `perizinan`
--

CREATE TABLE `perizinan` (
  `perizinan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `persediaan`
--

CREATE TABLE `persediaan` (
  `persediaan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rab`
--

CREATE TABLE `rab` (
  `rab_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `relawan`
--

CREATE TABLE `relawan` (
  `relawan_id` int(11) NOT NULL,
  `nama_relawan` varchar(50) NOT NULL,
  `no_ktp` bigint(16) NOT NULL,
  `alamat_relawan` text NOT NULL,
  `jenis_kelamin` int(1) NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `foto_relawan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `resi_donasi`
--

CREATE TABLE `resi_donasi` (
  `resi_Id` int(11) NOT NULL,
  `nomor_Resi` int(50) NOT NULL,
  `barcode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `role_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tracking`
--

CREATE TABLE `tracking` (
  `tracking_id` int(11) NOT NULL,
  `resi_Id` int(11) NOT NULL,
  `tgl_update` datetime NOT NULL,
  `donasi_id` int(11) NOT NULL,
  `pengguna_id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `vendor`
--

CREATE TABLE `vendor` (
  `vendor_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`alternatif_id`);

--
-- Indeks untuk tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`artikel_id`);

--
-- Indeks untuk tabel `arus_kas`
--
ALTER TABLE `arus_kas`
  ADD PRIMARY KEY (`arus_Id`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`barang_id`);

--
-- Indeks untuk tabel `biaya_kategori`
--
ALTER TABLE `biaya_kategori`
  ADD PRIMARY KEY (`biaya_id`);

--
-- Indeks untuk tabel `bukti_pengajuan`
--
ALTER TABLE `bukti_pengajuan`
  ADD PRIMARY KEY (`bukti_Id`);

--
-- Indeks untuk tabel `donasi`
--
ALTER TABLE `donasi`
  ADD PRIMARY KEY (`donasi_id`);

--
-- Indeks untuk tabel `halaman`
--
ALTER TABLE `halaman`
  ADD PRIMARY KEY (`halaman_id`);

--
-- Indeks untuk tabel `in_barang`
--
ALTER TABLE `in_barang`
  ADD PRIMARY KEY (`in_Id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`kriteria_id`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`login_Id`);

--
-- Indeks untuk tabel `map`
--
ALTER TABLE `map`
  ADD PRIMARY KEY (`map_id`);

--
-- Indeks untuk tabel `out_barang`
--
ALTER TABLE `out_barang`
  ADD PRIMARY KEY (`Out_id`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`pengguna_id`);

--
-- Indeks untuk tabel `perizinan`
--
ALTER TABLE `perizinan`
  ADD PRIMARY KEY (`perizinan_id`);

--
-- Indeks untuk tabel `persediaan`
--
ALTER TABLE `persediaan`
  ADD PRIMARY KEY (`persediaan_id`);

--
-- Indeks untuk tabel `rab`
--
ALTER TABLE `rab`
  ADD PRIMARY KEY (`rab_id`);

--
-- Indeks untuk tabel `relawan`
--
ALTER TABLE `relawan`
  ADD PRIMARY KEY (`relawan_id`);

--
-- Indeks untuk tabel `resi_donasi`
--
ALTER TABLE `resi_donasi`
  ADD PRIMARY KEY (`resi_Id`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indeks untuk tabel `tracking`
--
ALTER TABLE `tracking`
  ADD PRIMARY KEY (`tracking_id`);

--
-- Indeks untuk tabel `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_Id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `alternatif_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `artikel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `arus_kas`
--
ALTER TABLE `arus_kas`
  MODIFY `arus_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `barang_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `biaya_kategori`
--
ALTER TABLE `biaya_kategori`
  MODIFY `biaya_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `bukti_pengajuan`
--
ALTER TABLE `bukti_pengajuan`
  MODIFY `bukti_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `donasi`
--
ALTER TABLE `donasi`
  MODIFY `donasi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `halaman`
--
ALTER TABLE `halaman`
  MODIFY `halaman_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `in_barang`
--
ALTER TABLE `in_barang`
  MODIFY `in_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `kriteria_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `login_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `map`
--
ALTER TABLE `map`
  MODIFY `map_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `out_barang`
--
ALTER TABLE `out_barang`
  MODIFY `Out_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `pengguna_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `perizinan`
--
ALTER TABLE `perizinan`
  MODIFY `perizinan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `persediaan`
--
ALTER TABLE `persediaan`
  MODIFY `persediaan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rab`
--
ALTER TABLE `rab`
  MODIFY `rab_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `relawan`
--
ALTER TABLE `relawan`
  MODIFY `relawan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `resi_donasi`
--
ALTER TABLE `resi_donasi`
  MODIFY `resi_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tracking`
--
ALTER TABLE `tracking`
  MODIFY `tracking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor_Id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
