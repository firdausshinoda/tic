-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 25, 2022 at 03:30 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_jurnal`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int(10) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `nama_admin` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` mediumtext DEFAULT NULL,
  `type` enum('SUPERADMIN','ADMIN','BENDAHARA') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_author`
--

CREATE TABLE `tb_author` (
  `id_author` int(10) NOT NULL,
  `id_gelar` int(10) DEFAULT NULL,
  `id_negara` int(10) DEFAULT NULL,
  `no_author` varchar(20) DEFAULT NULL,
  `foto_author` varchar(20) DEFAULT NULL,
  `nama_depan` varchar(50) DEFAULT NULL,
  `nama_tengah` varchar(50) DEFAULT NULL,
  `nama_belakang` varchar(50) DEFAULT NULL,
  `jenis_kelamin` enum('MALE','FEMALE') DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `pddk_terakhir` varchar(50) DEFAULT NULL,
  `institusi` mediumtext DEFAULT NULL,
  `research` mediumtext DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `alamat` mediumtext DEFAULT NULL,
  `kota` varchar(50) DEFAULT NULL,
  `kode_pos` varchar(20) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `no_fax` varchar(20) DEFAULT NULL,
  `orcid_id` mediumtext DEFAULT NULL,
  `informasi_lain` mediumtext DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email_password` enum('TERKIRIM','GAGAL TERKIRIM') DEFAULT 'TERKIRIM',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_cohost`
--

CREATE TABLE `tb_cohost` (
  `id_cohost` int(10) NOT NULL,
  `id_event` int(10) DEFAULT NULL,
  `thumbnail` varchar(20) DEFAULT NULL,
  `nama` text DEFAULT NULL,
  `link` mediumtext DEFAULT NULL,
  `stt_data` enum('DRAFT','PUBLISH') DEFAULT 'DRAFT',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_event`
--

CREATE TABLE `tb_event` (
  `id_event` int(10) NOT NULL,
  `event` text DEFAULT NULL,
  `slug_event` mediumtext DEFAULT NULL,
  `tahun_event` int(4) DEFAULT NULL,
  `pamflet` varchar(20) DEFAULT NULL,
  `stt_aktif` int(1) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_gelar`
--

CREATE TABLE `tb_gelar` (
  `id_gelar` int(10) NOT NULL,
  `gelar` varchar(30) DEFAULT NULL,
  `stt_data` enum('DRAFT','PUBLISH') DEFAULT 'DRAFT',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_indexing`
--

CREATE TABLE `tb_indexing` (
  `id_indexing` int(10) NOT NULL,
  `id_event` int(10) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `logo` varchar(20) DEFAULT NULL,
  `link` mediumtext DEFAULT NULL,
  `stt_data` enum('DRAFT','PUBLISH') DEFAULT 'DRAFT',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_invited_speaker`
--

CREATE TABLE `tb_invited_speaker` (
  `id_invited_speaker` int(10) NOT NULL,
  `id_event` int(10) DEFAULT NULL,
  `id_sub` int(10) DEFAULT NULL,
  `thumbnail` varchar(20) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `institusi` mediumtext DEFAULT NULL,
  `topik` mediumtext DEFAULT NULL,
  `stt_data` enum('DRAFT','PUBLISH') DEFAULT 'DRAFT',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenis_pembayaran`
--

CREATE TABLE `tb_jenis_pembayaran` (
  `id_jenis_pembayaran` int(10) NOT NULL,
  `id_event` int(10) DEFAULT NULL,
  `jenis_pembayaran` enum('BANK','PAYPAL') DEFAULT NULL,
  `nama_jenis_pembayaran` varchar(50) DEFAULT NULL,
  `nomor_jenis_pembayaran` varchar(30) DEFAULT NULL,
  `an_jenis_pembayaran` varchar(30) DEFAULT NULL,
  `logo_1` varchar(20) DEFAULT NULL,
  `logo_2` varchar(20) DEFAULT NULL,
  `logo_3` varchar(20) DEFAULT NULL,
  `logo_4` varchar(20) DEFAULT NULL,
  `logo_5` varchar(20) DEFAULT NULL,
  `stt_data` enum('DRAFT','PUBLISH') NOT NULL DEFAULT 'DRAFT',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jurnal`
--

CREATE TABLE `tb_jurnal` (
  `id_jurnal` int(10) NOT NULL,
  `id_event` int(10) DEFAULT NULL,
  `id_scope` int(10) DEFAULT NULL,
  `id_author` int(10) DEFAULT NULL,
  `id_jurnal_author` int(10) DEFAULT NULL,
  `id_author_corresponding` int(10) DEFAULT NULL,
  `id_jenis_pembayaran` int(10) DEFAULT NULL,
  `id_reviewer` int(10) DEFAULT NULL,
  `no_abstrak` varchar(20) DEFAULT NULL,
  `slug_jurnal` mediumtext DEFAULT NULL,
  `judul_jurnal` mediumtext DEFAULT NULL,
  `abstrak_jurnal` longtext DEFAULT NULL,
  `abstrak_jurnal_normal` mediumtext DEFAULT NULL,
  `file_nama` varchar(20) DEFAULT NULL,
  `file_pembayaran` varchar(20) DEFAULT NULL,
  `tipe_pembayaran` varchar(5) DEFAULT NULL,
  `keyword_jurnal` mediumtext DEFAULT NULL,
  `link_video` mediumtext DEFAULT NULL,
  `pembayaran_an` varchar(30) DEFAULT NULL,
  `pembayaran_bank` varchar(30) DEFAULT NULL,
  `pembayaran_invoice` varchar(10) DEFAULT NULL,
  `stt_pembayaran` enum('NOT PAID YET','PAID') DEFAULT 'NOT PAID YET',
  `stt_pembayaran_date_upload` datetime DEFAULT NULL,
  `stt_pembayaran_konfirmasi` enum('EMPTY','WAITING FOR CONFIRMATION','ACCEPTED') DEFAULT 'EMPTY',
  `stt_jurnal` enum('DRAFT','COMPLETED FOR A REVIEW','ABSTRACT ACCEPTED','ABSTRACT NOT ACCEPTED','WILL BE PROCESSED') DEFAULT 'DRAFT',
  `stt_full_paper` enum('EMPTY','REVISION REQUIRED','WILL BE PROCESSED') DEFAULT 'EMPTY',
  `stt_revisi_paper` enum('EMPTY','FILLED') DEFAULT 'EMPTY',
  `stt_progres_paper` enum('EMPTY','WAITING REVISED PAPER','WILL BE PROCESSED') DEFAULT 'EMPTY',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jurnal_author`
--

CREATE TABLE `tb_jurnal_author` (
  `id_jurnal_author` int(10) NOT NULL,
  `id_author` int(10) DEFAULT NULL,
  `id_jurnal` int(10) DEFAULT NULL,
  `id_negara` int(10) DEFAULT NULL,
  `nama_depan` varchar(30) DEFAULT NULL,
  `nama_tengah` varchar(30) DEFAULT NULL,
  `nama_belakang` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `orcid_id` mediumtext DEFAULT NULL,
  `institusi` mediumtext DEFAULT NULL,
  `biodata` mediumtext DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jurnal_pendukung`
--

CREATE TABLE `tb_jurnal_pendukung` (
  `id_jurnal_pendukung` int(10) NOT NULL,
  `id_jurnal` int(10) DEFAULT NULL,
  `file_nama` varchar(50) DEFAULT NULL,
  `file_pendukung` varchar(20) DEFAULT NULL,
  `file_tipe` varchar(30) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jurnal_qa`
--

CREATE TABLE `tb_jurnal_qa` (
  `id_jurnal_qa` int(10) NOT NULL,
  `id_author` int(10) DEFAULT NULL,
  `id_reviewer` int(10) DEFAULT NULL,
  `id_jurnal` int(10) DEFAULT NULL,
  `stt_user` enum('ADMIN','AUTHOR','REVIEWER') DEFAULT 'AUTHOR',
  `pertanyaan` mediumtext DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jurnal_qa_sub`
--

CREATE TABLE `tb_jurnal_qa_sub` (
  `id_jurnal_qa_sub` int(10) NOT NULL,
  `id_jurnal_qa` int(10) DEFAULT NULL,
  `id_author` int(10) DEFAULT NULL,
  `id_reviewer` int(10) DEFAULT NULL,
  `stt_user` enum('ADMIN','AUTHOR','REVIEWER') DEFAULT 'AUTHOR',
  `pertanyaan` mediumtext DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jurnal_revisi`
--

CREATE TABLE `tb_jurnal_revisi` (
  `id_jurnal_revisi` int(10) NOT NULL,
  `id_jurnal` int(10) DEFAULT NULL,
  `revisi_ke` int(10) DEFAULT NULL,
  `revisi` mediumtext DEFAULT NULL,
  `file_revisi_reviewer` varchar(20) DEFAULT NULL,
  `file_revisi_author` varchar(20) DEFAULT NULL,
  `stt_revisi` enum('REVISION REQUIRED','WILL BE PROCESSED') DEFAULT 'REVISION REQUIRED',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kerjasama`
--

CREATE TABLE `tb_kerjasama` (
  `id_kerjasama` int(10) NOT NULL,
  `id_event` int(10) DEFAULT NULL,
  `logo` varchar(20) DEFAULT NULL,
  `nama` text DEFAULT NULL,
  `link` mediumtext DEFAULT NULL,
  `stt_data` enum('DRAFT','PUBLISH') DEFAULT 'DRAFT',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_keynote_speaker`
--

CREATE TABLE `tb_keynote_speaker` (
  `id_keynote_speaker` int(10) NOT NULL,
  `id_event` int(10) DEFAULT NULL,
  `id_sub` int(10) DEFAULT NULL,
  `thumbnail` varchar(20) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `institusi` mediumtext DEFAULT NULL,
  `topik` mediumtext DEFAULT NULL,
  `stt_data` enum('DRAFT','PUBLISH') DEFAULT 'DRAFT',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kontak`
--

CREATE TABLE `tb_kontak` (
  `id_kontak` int(10) NOT NULL,
  `judul` varchar(20) DEFAULT NULL,
  `icon` varchar(40) DEFAULT NULL,
  `isi` mediumtext DEFAULT NULL,
  `stt_data` enum('DRAFT','PUBLISH') DEFAULT 'DRAFT',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_negara`
--

CREATE TABLE `tb_negara` (
  `id_negara` int(10) NOT NULL,
  `negara` text DEFAULT NULL,
  `phone_code` int(5) DEFAULT NULL,
  `stt_data` enum('DRAF','PUBLISH') DEFAULT 'DRAF',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_no`
--

CREATE TABLE `tb_no` (
  `id_no` int(10) NOT NULL,
  `id_event` int(10) DEFAULT NULL,
  `no_abs` int(10) DEFAULT 0,
  `no_author` int(10) DEFAULT 0,
  `no_participan` int(10) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_notif_admin`
--

CREATE TABLE `tb_notif_admin` (
  `id_notif_admin` int(10) NOT NULL,
  `id_author` int(10) DEFAULT NULL,
  `id_participan` int(10) DEFAULT NULL,
  `id_jurnal` int(10) DEFAULT NULL,
  `judul` mediumtext DEFAULT NULL,
  `pesan` mediumtext DEFAULT NULL,
  `stt_view` int(1) DEFAULT 0,
  `stt_notif` enum('OTHER','JURNAL','REVISION','PAYMENT','PAYMENT-PARTICIPAN') DEFAULT NULL,
  `stt_user` enum('ALL','ADMIN') DEFAULT 'ALL',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_notif_author`
--

CREATE TABLE `tb_notif_author` (
  `id_notif_author` int(10) NOT NULL,
  `id_jurnal` int(10) DEFAULT NULL,
  `id_jurnal_qa` int(10) DEFAULT NULL,
  `id_author` int(10) DEFAULT NULL,
  `judul` mediumtext DEFAULT NULL,
  `pesan` mediumtext DEFAULT NULL,
  `stt_view` int(1) DEFAULT 0,
  `stt_notif` enum('OTHER','JURNAL','QA FORUM','MY QUESTION','REVISION') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_notif_participan`
--

CREATE TABLE `tb_notif_participan` (
  `id_notif_participan` int(10) NOT NULL,
  `id_participan` int(10) DEFAULT NULL,
  `judul` mediumtext DEFAULT NULL,
  `pesan` mediumtext DEFAULT NULL,
  `stt_view` int(1) DEFAULT 0,
  `stt_notif` enum('PAYMENT') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_notif_reviewer`
--

CREATE TABLE `tb_notif_reviewer` (
  `id_notif_reviewer` int(10) NOT NULL,
  `id_jurnal` int(10) DEFAULT NULL,
  `id_jurnal_qa` int(10) DEFAULT NULL,
  `id_reviewer` int(10) DEFAULT NULL,
  `judul` mediumtext DEFAULT NULL,
  `pesan` mediumtext DEFAULT NULL,
  `stt_view` int(1) DEFAULT 0,
  `stt_notif` enum('OTHER','MY QUESTION','REVISION','ABSTRACT') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_participan`
--

CREATE TABLE `tb_participan` (
  `id_participan` int(10) NOT NULL,
  `id_gelar` int(10) DEFAULT NULL,
  `id_negara` int(10) DEFAULT NULL,
  `id_jenis_pembayaran` int(10) DEFAULT NULL,
  `id_event` int(10) DEFAULT NULL,
  `no_participan` varchar(20) DEFAULT NULL,
  `foto_participan` varchar(20) DEFAULT NULL,
  `nama_depan` varchar(50) DEFAULT NULL,
  `nama_tengah` varchar(50) DEFAULT NULL,
  `nama_belakang` varchar(50) DEFAULT NULL,
  `jenis_kelamin` enum('MALE','FEMALE') DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `pddk_terakhir` varchar(50) DEFAULT NULL,
  `institusi` mediumtext DEFAULT NULL,
  `research` mediumtext DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `alamat` mediumtext DEFAULT NULL,
  `kota` varchar(50) DEFAULT NULL,
  `kode_pos` varchar(20) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `no_fax` varchar(20) DEFAULT NULL,
  `orcid_id` mediumtext DEFAULT NULL,
  `informasi_lain` mediumtext DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email_password` enum('TERKIRIM','GAGAL TERKIRIM') DEFAULT 'TERKIRIM',
  `pembayaran_bank` varchar(30) DEFAULT NULL,
  `pembayaran_an` varchar(30) DEFAULT NULL,
  `pembayaran_invoice` varchar(10) DEFAULT NULL,
  `stt_pembayaran` enum('NOT PAID YET','PAID') DEFAULT 'NOT PAID YET',
  `stt_pembayaran_konfirmasi` enum('EMPTY','WAITING FOR CONFIRMATION','ACCEPTED') DEFAULT 'EMPTY',
  `file_pembayaran` varchar(20) DEFAULT NULL,
  `tipe_pembayaran` varchar(5) DEFAULT NULL,
  `stt_pembayaran_date_upload` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_reviewer`
--

CREATE TABLE `tb_reviewer` (
  `id_reviewer` int(10) NOT NULL,
  `foto_reviewer` varchar(20) DEFAULT NULL,
  `password` mediumtext DEFAULT NULL,
  `email` text DEFAULT NULL,
  `nama_depan` varchar(50) DEFAULT NULL,
  `nama_tengah` varchar(50) DEFAULT NULL,
  `nama_belakang` varchar(50) DEFAULT NULL,
  `jenis_kelamin` enum('MALE','FEMALE') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_scope`
--

CREATE TABLE `tb_scope` (
  `id_scope` int(10) NOT NULL,
  `id_sub` int(10) DEFAULT NULL,
  `scope` text DEFAULT NULL,
  `stt_data` enum('DRAFT','PUBLISH') DEFAULT 'DRAFT',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_setting`
--

CREATE TABLE `tb_setting` (
  `id_setting` int(10) NOT NULL,
  `id_event` int(10) DEFAULT NULL,
  `tema` mediumtext DEFAULT NULL,
  `deskripsi_singkat` mediumtext DEFAULT NULL,
  `deskripsi_panjang` longtext DEFAULT NULL,
  `deskripsi_kategori` longtext DEFAULT NULL,
  `submission` longtext DEFAULT NULL,
  `publication_opportunity` longtext DEFAULT NULL,
  `committee` longtext DEFAULT NULL,
  `call_for_paper` mediumtext DEFAULT NULL,
  `fee` longtext DEFAULT NULL,
  `about` longtext DEFAULT NULL,
  `faq` longtext DEFAULT NULL,
  `harga_jurnal_lokal` int(10) DEFAULT 0,
  `harga_jurnal_internasional` int(10) DEFAULT 0,
  `harga_participan_lokal` int(10) DEFAULT NULL,
  `harga_participan_internasional` int(10) DEFAULT NULL,
  `tgl_mulai_pendaftaran` date DEFAULT NULL,
  `tgl_akhir_pendaftaran` date DEFAULT NULL,
  `tgl_akhir_abstrak` date DEFAULT NULL,
  `tgl_akhir_pembayaran` date DEFAULT NULL,
  `tgl_akhir_full_paper` date DEFAULT NULL,
  `tgl_akhir_video` date DEFAULT NULL,
  `tgl_mulai_qa` date DEFAULT NULL,
  `tgl_akhir_qa` date DEFAULT NULL,
  `tgl_loi` date DEFAULT NULL,
  `tgl_loa` date DEFAULT NULL,
  `tgl_mulai_mereview` date DEFAULT NULL,
  `tgl_akhir_mereview` date DEFAULT NULL,
  `tgl_mulai_revisi` date DEFAULT NULL,
  `tgl_akhir_revisi` date DEFAULT NULL,
  `tgl_conference` date DEFAULT NULL,
  `ketua_nama` varchar(35) DEFAULT NULL,
  `ketua_file_ttd` varchar(20) DEFAULT NULL,
  `bendahara_nama` varchar(35) DEFAULT NULL,
  `bendahara_file_ttd` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_sosmed`
--

CREATE TABLE `tb_sosmed` (
  `id_sosmed` int(10) NOT NULL,
  `icon` varchar(20) DEFAULT NULL,
  `sosmed` varchar(50) DEFAULT NULL,
  `link` mediumtext DEFAULT NULL,
  `stt_data` enum('DRAFT','PUBLISH') DEFAULT 'DRAFT',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_sub`
--

CREATE TABLE `tb_sub` (
  `id_sub` int(10) NOT NULL,
  `id_event` int(10) DEFAULT NULL,
  `sub` text DEFAULT NULL,
  `slug` mediumtext DEFAULT NULL,
  `thumbnail` varchar(20) DEFAULT NULL,
  `deskripsi` mediumtext DEFAULT NULL,
  `template` varchar(20) DEFAULT NULL,
  `stt_data` enum('DRAFT','PUBLISH') DEFAULT 'DRAFT',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_timeline`
--

CREATE TABLE `tb_timeline` (
  `id_timeline` int(10) NOT NULL,
  `id_event` int(10) DEFAULT NULL,
  `timeline` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `stt_data` enum('DRAFT','PUBLISH') DEFAULT 'DRAFT',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `del_flage` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_vc`
--

CREATE TABLE `tb_vc` (
  `id_vc` int(10) NOT NULL,
  `id_sub` int(10) DEFAULT NULL,
  `vc` varchar(50) DEFAULT NULL,
  `icon` varchar(20) DEFAULT NULL,
  `link` mediumtext DEFAULT NULL,
  `stt_data` enum('DRAFT','PUBLISH') DEFAULT 'DRAFT',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `tb_author`
--
ALTER TABLE `tb_author`
  ADD PRIMARY KEY (`id_author`);

--
-- Indexes for table `tb_cohost`
--
ALTER TABLE `tb_cohost`
  ADD PRIMARY KEY (`id_cohost`);

--
-- Indexes for table `tb_event`
--
ALTER TABLE `tb_event`
  ADD PRIMARY KEY (`id_event`);

--
-- Indexes for table `tb_gelar`
--
ALTER TABLE `tb_gelar`
  ADD PRIMARY KEY (`id_gelar`);

--
-- Indexes for table `tb_indexing`
--
ALTER TABLE `tb_indexing`
  ADD PRIMARY KEY (`id_indexing`);

--
-- Indexes for table `tb_invited_speaker`
--
ALTER TABLE `tb_invited_speaker`
  ADD PRIMARY KEY (`id_invited_speaker`);

--
-- Indexes for table `tb_jenis_pembayaran`
--
ALTER TABLE `tb_jenis_pembayaran`
  ADD PRIMARY KEY (`id_jenis_pembayaran`);

--
-- Indexes for table `tb_jurnal`
--
ALTER TABLE `tb_jurnal`
  ADD PRIMARY KEY (`id_jurnal`);

--
-- Indexes for table `tb_jurnal_author`
--
ALTER TABLE `tb_jurnal_author`
  ADD PRIMARY KEY (`id_jurnal_author`);

--
-- Indexes for table `tb_jurnal_pendukung`
--
ALTER TABLE `tb_jurnal_pendukung`
  ADD PRIMARY KEY (`id_jurnal_pendukung`);

--
-- Indexes for table `tb_jurnal_qa`
--
ALTER TABLE `tb_jurnal_qa`
  ADD PRIMARY KEY (`id_jurnal_qa`);

--
-- Indexes for table `tb_jurnal_qa_sub`
--
ALTER TABLE `tb_jurnal_qa_sub`
  ADD PRIMARY KEY (`id_jurnal_qa_sub`);

--
-- Indexes for table `tb_jurnal_revisi`
--
ALTER TABLE `tb_jurnal_revisi`
  ADD PRIMARY KEY (`id_jurnal_revisi`);

--
-- Indexes for table `tb_kerjasama`
--
ALTER TABLE `tb_kerjasama`
  ADD PRIMARY KEY (`id_kerjasama`);

--
-- Indexes for table `tb_keynote_speaker`
--
ALTER TABLE `tb_keynote_speaker`
  ADD PRIMARY KEY (`id_keynote_speaker`);

--
-- Indexes for table `tb_kontak`
--
ALTER TABLE `tb_kontak`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indexes for table `tb_negara`
--
ALTER TABLE `tb_negara`
  ADD PRIMARY KEY (`id_negara`);

--
-- Indexes for table `tb_no`
--
ALTER TABLE `tb_no`
  ADD PRIMARY KEY (`id_no`);

--
-- Indexes for table `tb_notif_admin`
--
ALTER TABLE `tb_notif_admin`
  ADD PRIMARY KEY (`id_notif_admin`);

--
-- Indexes for table `tb_notif_author`
--
ALTER TABLE `tb_notif_author`
  ADD PRIMARY KEY (`id_notif_author`);

--
-- Indexes for table `tb_notif_participan`
--
ALTER TABLE `tb_notif_participan`
  ADD PRIMARY KEY (`id_notif_participan`);

--
-- Indexes for table `tb_notif_reviewer`
--
ALTER TABLE `tb_notif_reviewer`
  ADD PRIMARY KEY (`id_notif_reviewer`);

--
-- Indexes for table `tb_participan`
--
ALTER TABLE `tb_participan`
  ADD PRIMARY KEY (`id_participan`);

--
-- Indexes for table `tb_reviewer`
--
ALTER TABLE `tb_reviewer`
  ADD PRIMARY KEY (`id_reviewer`);

--
-- Indexes for table `tb_scope`
--
ALTER TABLE `tb_scope`
  ADD PRIMARY KEY (`id_scope`);

--
-- Indexes for table `tb_setting`
--
ALTER TABLE `tb_setting`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indexes for table `tb_sosmed`
--
ALTER TABLE `tb_sosmed`
  ADD PRIMARY KEY (`id_sosmed`);

--
-- Indexes for table `tb_sub`
--
ALTER TABLE `tb_sub`
  ADD PRIMARY KEY (`id_sub`);

--
-- Indexes for table `tb_timeline`
--
ALTER TABLE `tb_timeline`
  ADD PRIMARY KEY (`id_timeline`);

--
-- Indexes for table `tb_vc`
--
ALTER TABLE `tb_vc`
  ADD PRIMARY KEY (`id_vc`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_author`
--
ALTER TABLE `tb_author`
  MODIFY `id_author` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_cohost`
--
ALTER TABLE `tb_cohost`
  MODIFY `id_cohost` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_event`
--
ALTER TABLE `tb_event`
  MODIFY `id_event` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_gelar`
--
ALTER TABLE `tb_gelar`
  MODIFY `id_gelar` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_indexing`
--
ALTER TABLE `tb_indexing`
  MODIFY `id_indexing` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_invited_speaker`
--
ALTER TABLE `tb_invited_speaker`
  MODIFY `id_invited_speaker` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_jenis_pembayaran`
--
ALTER TABLE `tb_jenis_pembayaran`
  MODIFY `id_jenis_pembayaran` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_jurnal`
--
ALTER TABLE `tb_jurnal`
  MODIFY `id_jurnal` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_jurnal_author`
--
ALTER TABLE `tb_jurnal_author`
  MODIFY `id_jurnal_author` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_jurnal_pendukung`
--
ALTER TABLE `tb_jurnal_pendukung`
  MODIFY `id_jurnal_pendukung` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_jurnal_qa`
--
ALTER TABLE `tb_jurnal_qa`
  MODIFY `id_jurnal_qa` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_jurnal_qa_sub`
--
ALTER TABLE `tb_jurnal_qa_sub`
  MODIFY `id_jurnal_qa_sub` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_jurnal_revisi`
--
ALTER TABLE `tb_jurnal_revisi`
  MODIFY `id_jurnal_revisi` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_kerjasama`
--
ALTER TABLE `tb_kerjasama`
  MODIFY `id_kerjasama` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_keynote_speaker`
--
ALTER TABLE `tb_keynote_speaker`
  MODIFY `id_keynote_speaker` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_kontak`
--
ALTER TABLE `tb_kontak`
  MODIFY `id_kontak` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_negara`
--
ALTER TABLE `tb_negara`
  MODIFY `id_negara` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_no`
--
ALTER TABLE `tb_no`
  MODIFY `id_no` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_notif_admin`
--
ALTER TABLE `tb_notif_admin`
  MODIFY `id_notif_admin` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_notif_author`
--
ALTER TABLE `tb_notif_author`
  MODIFY `id_notif_author` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_notif_participan`
--
ALTER TABLE `tb_notif_participan`
  MODIFY `id_notif_participan` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_notif_reviewer`
--
ALTER TABLE `tb_notif_reviewer`
  MODIFY `id_notif_reviewer` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_participan`
--
ALTER TABLE `tb_participan`
  MODIFY `id_participan` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_reviewer`
--
ALTER TABLE `tb_reviewer`
  MODIFY `id_reviewer` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_scope`
--
ALTER TABLE `tb_scope`
  MODIFY `id_scope` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_setting`
--
ALTER TABLE `tb_setting`
  MODIFY `id_setting` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_sosmed`
--
ALTER TABLE `tb_sosmed`
  MODIFY `id_sosmed` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_sub`
--
ALTER TABLE `tb_sub`
  MODIFY `id_sub` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_timeline`
--
ALTER TABLE `tb_timeline`
  MODIFY `id_timeline` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_vc`
--
ALTER TABLE `tb_vc`
  MODIFY `id_vc` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
