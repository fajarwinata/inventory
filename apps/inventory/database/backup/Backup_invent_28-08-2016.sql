-- MySQL dump 10.13  Distrib 5.5.27, for Win32 (x86)
--
-- Host: localhost    Database: invent
-- ------------------------------------------------------
-- Server version	5.5.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `barang`
--

DROP TABLE IF EXISTS `barang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barang` (
  `kd_barang` char(5) NOT NULL,
  `nm_barang` varchar(100) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `merek` varchar(100) NOT NULL,
  `jumlah` int(6) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `kd_kategori` char(4) NOT NULL,
  PRIMARY KEY (`kd_barang`),
  UNIQUE KEY `kd_buku` (`kd_barang`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang`
--

LOCK TABLES `barang` WRITE;
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
INSERT INTO `barang` VALUES ('B0001','TOSHIBA Satellite C800D-1003 - Black ','Notebook / Laptop 13 inch - 14 inch AMD Dual Core E1-1200, 2GB DDR3, 320GB HDD, DVD - RW, WiFi, Bluetooth, VGA AMD Radeon HD 7000 Series, Camera, 14','TOSHIBA',2,'Unit','K002'),('B0002','TOSHIBA Satellite C40-A106 - Black','Notebook / Laptop 13 inch - 14 inch Intel Core i3-2348M, 2GB DDR3, 500GB HDD, DVD - RW, WiFi, Bluetooth, VGA Intel HD Graphics, Camera, 14','TOSHIBA',3,'Unit','K002'),('B0003','Printer Canon LBP 5100 Laser Jet','Canon LBP 5100 Laser Jet','Canon',2,'Unit','K003'),('B0004','Printer Canon IP 2770','Canon IP 2770','Canon',6,'Unit','K003'),('B0005','Printer Brother Colour Laser HL-2150N Mono','Brother Colour Laser HL-2150N Mono Laser Printer, Networking','Brother',4,'Unit','K003'),('B0006','UPS Prolink Pro 700','Prolink Pro 700','Prolink',2,'Unit','K004'),('B0007','UPS Prolink IPS 500i Inverter 500VA','Prolink IPS 500i Inverter 500VA','Prolink',7,'Unit','K004'),('B0008','Meja Komputer Crystal Grace 101','Crystal Grace 101 (100x45x70)','Crystal Grace',7,'Unit','K005'),('B0009','Komputer Kantor - Paket 1','Motherboard PCP+ 790Gx Baby Raptor\r\nProcessor AMD Athlon II 64 X2 250\r\nMemory 1 GB DDR2 PC6400 800 MHz\r\nHarddisk WDC 320 GB Sata\r\nDVD±RW/RAM 24x Sata\r\nKeyboard + Mouse SPC\r\nCasing Libera Series 500 Wa','Rakitan',12,'Unit','K001'),('B0010','Komputer Kantor - Paket 2','Dual Core (2.6 Ghz) TRAY\r\nMainboard ASUS P5 KPL AM-SE ( Astrindo )\r\nMemory DDR2 V-gen 2 Gb PC 5300\r\nHarddisk 250 Gb Seagate/WDC/Maxtor SATA\r\nKeyboard + Mouse Logitech\r\nCasing SPC 350w + 1 FAN CPU\r\nLCD','Rakitan',7,'Unit','K001'),('B0011','LCD LG 19 Inch','LG 19 Inch L1942S (Square)','LG',7,'Unit','K006'),('B0012','Jam','Dinding','Casino',0,'Unit','K004');
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barang_inventaris`
--

DROP TABLE IF EXISTS `barang_inventaris`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barang_inventaris` (
  `kd_inventaris` char(12) NOT NULL,
  `kd_barang` char(5) NOT NULL,
  `no_pengadaan` char(7) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `status_barang` enum('Tersedia','Ditempatkan','Dipinjam','Rusak','Terjual') NOT NULL DEFAULT 'Tersedia',
  UNIQUE KEY `kd_inventaris` (`kd_inventaris`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang_inventaris`
--

LOCK TABLES `barang_inventaris` WRITE;
/*!40000 ALTER TABLE `barang_inventaris` DISABLE KEYS */;
INSERT INTO `barang_inventaris` VALUES ('B0001.000001','B0001','BB00002','2015-08-06','Terjual'),('B0001.000002','B0001','BB00002','2015-08-06','Terjual'),('B0002.000003','B0002','BB00002','2015-08-06','Rusak'),('B0002.000004','B0002','BB00002','2015-08-06','Rusak'),('B0002.000005','B0002','BB00002','2015-08-06','Tersedia'),('B0003.000006','B0003','BB00003','2015-08-06','Rusak'),('B0003.000007','B0003','BB00003','2015-08-06','Rusak'),('B0004.000008','B0004','BB00003','2015-08-06','Rusak'),('B0004.000009','B0004','BB00003','2015-08-06','Tersedia'),('B0004.000010','B0004','BB00003','2015-08-06','Tersedia'),('B0004.000011','B0004','BB00003','2015-08-06','Tersedia'),('B0004.000012','B0004','BB00003','2015-08-06','Tersedia'),('B0004.000013','B0004','BB00003','2015-08-06','Tersedia'),('B0005.000014','B0005','BB00003','2015-08-06','Tersedia'),('B0005.000015','B0005','BB00003','2015-08-06','Tersedia'),('B0005.000016','B0005','BB00003','2015-08-06','Tersedia'),('B0005.000017','B0005','BB00003','2015-08-06','Tersedia'),('B0006.000018','B0006','BB00004','2015-08-06','Tersedia'),('B0006.000019','B0006','BB00004','2015-08-06','Tersedia'),('B0007.000020','B0007','BB00004','2015-08-06','Tersedia'),('B0007.000021','B0007','BB00004','2015-08-06','Tersedia'),('B0007.000022','B0007','BB00004','2015-08-06','Tersedia'),('B0007.000023','B0007','BB00004','2015-08-06','Tersedia'),('B0007.000024','B0007','BB00004','2015-08-06','Tersedia'),('B0007.000025','B0007','BB00004','2015-08-06','Tersedia'),('B0007.000026','B0007','BB00004','2015-08-06','Tersedia'),('B0008.000027','B0008','BB00005','2015-08-06','Tersedia'),('B0008.000028','B0008','BB00005','2015-08-06','Tersedia'),('B0008.000029','B0008','BB00005','2015-08-06','Tersedia'),('B0008.000030','B0008','BB00005','2015-08-06','Tersedia'),('B0008.000031','B0008','BB00005','2015-08-06','Tersedia'),('B0008.000032','B0008','BB00005','2015-08-06','Tersedia'),('B0008.000033','B0008','BB00005','2015-08-06','Tersedia'),('B0009.000034','B0009','BB00001','2015-08-06','Tersedia'),('B0009.000035','B0009','BB00001','2015-08-06','Tersedia'),('B0009.000036','B0009','BB00001','2015-08-06','Tersedia'),('B0009.000037','B0009','BB00001','2015-08-06','Tersedia'),('B0010.000038','B0010','BB00001','2015-08-06','Tersedia'),('B0010.000039','B0010','BB00001','2015-08-06','Tersedia'),('B0011.000040','B0011','BB00006','2015-08-06','Tersedia'),('B0011.000041','B0011','BB00006','2015-08-06','Tersedia'),('B0011.000042','B0011','BB00006','2015-08-06','Tersedia'),('B0011.000043','B0011','BB00006','2015-08-06','Tersedia'),('B0011.000044','B0011','BB00006','2015-08-06','Tersedia'),('B0011.000045','B0011','BB00006','2015-08-06','Tersedia'),('B0011.000046','B0011','BB00006','2015-08-06','Tersedia'),('B0009.000049','B0009','BB00007','2016-07-28','Tersedia'),('B0009.000048','B0009','BB00007','2016-07-28','Tersedia'),('B0009.000047','B0009','BB00007','2016-07-28','Tersedia'),('B0009.000050','B0009','BB00007','2016-07-28','Tersedia'),('B0009.000051','B0009','BB00007','2016-07-28','Tersedia'),('B0010.000052','B0010','BB00008','2016-07-28','Tersedia'),('B0010.000053','B0010','BB00008','2016-07-28','Tersedia'),('B0010.000054','B0010','BB00008','2016-07-28','Tersedia'),('B0010.000055','B0010','BB00010','2016-08-28','Tersedia'),('B0010.000056','B0010','BB00010','2016-08-28','Tersedia');
/*!40000 ALTER TABLE `barang_inventaris` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departemen`
--

DROP TABLE IF EXISTS `departemen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departemen` (
  `kd_departemen` char(4) NOT NULL,
  `nm_departemen` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  PRIMARY KEY (`kd_departemen`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departemen`
--

LOCK TABLES `departemen` WRITE;
/*!40000 ALTER TABLE `departemen` DISABLE KEYS */;
INSERT INTO `departemen` VALUES ('D001','Prodi TI','Teknik Informatika'),('D002','Prodi SI','Sistem Informasi'),('D003','Prodi MI','Manajemen Informatika'),('D004','Prodi KA','Komputer Akuntansi'),('D005','Prodi TK','Teknik Komputer'),('D006','Pengajaran','Pengajaran'),('D007','Perpustakaan','Perpustakaan'),('D008','Ruang Kelas - Gedung S','Ruang Kelas Gedung Selatan'),('D009','Ruang Kelas - Gedung U','Ruang Kelas Gedung Utara'),('D010','Matahari','Matahari DS');
/*!40000 ALTER TABLE `departemen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jual`
--

DROP TABLE IF EXISTS `jual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jual` (
  `no_jual` varchar(7) NOT NULL,
  `tgl_jual` date NOT NULL,
  `kd_inven` varchar(20) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `kd_petugas` varchar(20) NOT NULL,
  PRIMARY KEY (`no_jual`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jual`
--

LOCK TABLES `jual` WRITE;
/*!40000 ALTER TABLE `jual` DISABLE KEYS */;
INSERT INTO `jual` VALUES ('PJ00001','2016-08-26','B0001.000001','JUAAAL','P005'),('PJ00002','2016-08-26','B0001.000002','as','P005');
/*!40000 ALTER TABLE `jual` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori` (
  `kd_kategori` char(4) NOT NULL,
  `nm_kategori` varchar(100) NOT NULL,
  PRIMARY KEY (`kd_kategori`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES ('K001','Komputer Gas'),('K002','Laptop'),('K003','Printer'),('K004','UPS Power Suply'),('K005','Meja Komputer'),('K006','Monitor');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lokasi`
--

DROP TABLE IF EXISTS `lokasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lokasi` (
  `kd_lokasi` char(5) NOT NULL,
  `nm_lokasi` varchar(100) NOT NULL,
  `kd_departemen` char(4) NOT NULL,
  PRIMARY KEY (`kd_lokasi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lokasi`
--

LOCK TABLES `lokasi` WRITE;
/*!40000 ALTER TABLE `lokasi` DISABLE KEYS */;
INSERT INTO `lokasi` VALUES ('L0001','Kepala Prodi TI','D001'),('L0002','Ruang Dosen TI','D001'),('L0003','Kepala Prodi SI','D002'),('L0004','Ruang Dosen SI','D002'),('L0005','Kepala Prodi MI','D003'),('L0006','Ruang Dosen MI','D003'),('L0007','Kepala Prodi KA','D004'),('L0008','Ruang Dosen KA','D004'),('L0009','Kepala Prodi TK','D005'),('L0010','Ruang Dosen TK','D005'),('L0011','Kepala Pengajaran','D006'),('L0012','Ruang Pengajaran','D006'),('L0013','Kepala Perpustakaan','D007'),('L0014','Ruang Perpustakaan','D007'),('L0015','Kelas S.1.1','D008');
/*!40000 ALTER TABLE `lokasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mutasi`
--

DROP TABLE IF EXISTS `mutasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mutasi` (
  `no_mutasi` char(7) NOT NULL,
  `tgl_mutasi` date NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`no_mutasi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mutasi`
--

LOCK TABLES `mutasi` WRITE;
/*!40000 ALTER TABLE `mutasi` DISABLE KEYS */;
INSERT INTO `mutasi` VALUES ('MB00001','2016-08-25','oke','P005');
/*!40000 ALTER TABLE `mutasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mutasi_asal`
--

DROP TABLE IF EXISTS `mutasi_asal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mutasi_asal` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `no_mutasi` char(7) NOT NULL,
  `no_penempatan` char(7) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mutasi_asal`
--

LOCK TABLES `mutasi_asal` WRITE;
/*!40000 ALTER TABLE `mutasi_asal` DISABLE KEYS */;
INSERT INTO `mutasi_asal` VALUES (1,'MB00001','PB00011','B0001.000002');
/*!40000 ALTER TABLE `mutasi_asal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mutasi_tujuan`
--

DROP TABLE IF EXISTS `mutasi_tujuan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mutasi_tujuan` (
  `no_mutasi` char(7) NOT NULL,
  `no_penempatan` char(7) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mutasi_tujuan`
--

LOCK TABLES `mutasi_tujuan` WRITE;
/*!40000 ALTER TABLE `mutasi_tujuan` DISABLE KEYS */;
INSERT INTO `mutasi_tujuan` VALUES ('MB00001','PB00013','oke');
/*!40000 ALTER TABLE `mutasi_tujuan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pegawai`
--

DROP TABLE IF EXISTS `pegawai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pegawai` (
  `kd_pegawai` char(5) NOT NULL,
  `nm_pegawai` varchar(100) NOT NULL,
  `jns_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  PRIMARY KEY (`kd_pegawai`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pegawai`
--

LOCK TABLES `pegawai` WRITE;
/*!40000 ALTER TABLE `pegawai` DISABLE KEYS */;
INSERT INTO `pegawai` VALUES ('P0001','Juwanto','Laki-laki','Jl. Manggarawan, 130, Labuhan Ratu 7','081911818188'),('P0002','Riswantoro','Laki-laki','Jl. Suhada, Way Jepara, Lampung Timur','021511881818'),('P0003','Sardi Sudrajad','Laki-laki','Jl. Margahayu 120, Labuhan Ratu baru, Way Jepara','081921341111'),('P0004','Atika Lusiana','Perempuan','Jl. Margahayu 120, Labuhan Ratu baru, Way Jepara','08192223333'),('P0006','Umi Rahayu','Perempuan','Jl. Way Jepara, Lampung Timur','081911118181'),('P0007','Chin Wei','Laki-laki','Jl Jurang No. 115 Sukamau Bandung','081221718831');
/*!40000 ALTER TABLE `pegawai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peminjaman`
--

DROP TABLE IF EXISTS `peminjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peminjaman` (
  `no_peminjaman` char(7) NOT NULL,
  `tgl_peminjaman` date NOT NULL,
  `tgl_akan_kembali` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `kd_pegawai` char(5) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `status_kembali` enum('Pinjam','Kembali') NOT NULL DEFAULT 'Pinjam',
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`no_peminjaman`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peminjaman`
--

LOCK TABLES `peminjaman` WRITE;
/*!40000 ALTER TABLE `peminjaman` DISABLE KEYS */;
INSERT INTO `peminjaman` VALUES ('PJ00001','2016-07-28','2016-07-28','0000-00-00','P0001','','Pinjam','P001');
/*!40000 ALTER TABLE `peminjaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peminjaman_item`
--

DROP TABLE IF EXISTS `peminjaman_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peminjaman_item` (
  `no_peminjaman` char(7) NOT NULL,
  `kd_inventaris` char(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peminjaman_item`
--

LOCK TABLES `peminjaman_item` WRITE;
/*!40000 ALTER TABLE `peminjaman_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `peminjaman_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penempatan`
--

DROP TABLE IF EXISTS `penempatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penempatan` (
  `no_penempatan` char(7) NOT NULL,
  `tgl_penempatan` date NOT NULL,
  `kd_lokasi` char(5) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `jenis` enum('Baru','Mutasi') NOT NULL DEFAULT 'Baru',
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`no_penempatan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penempatan`
--

LOCK TABLES `penempatan` WRITE;
/*!40000 ALTER TABLE `penempatan` DISABLE KEYS */;
INSERT INTO `penempatan` VALUES ('PB00001','2015-07-24','L0001','Untuk operasional Kepala Propdi TI','Baru','P001'),('PB00002','2015-07-27','L0002','Untuk operasional Dosen Propdi TI','Baru','P001'),('PB00003','2015-07-29','L0003','Untuk operasional Propdi SI','Baru','P001'),('PB00004','2015-08-06','L0004','Untuk operasional Dosen Prodi SI','Baru','P001'),('PB00005','2015-08-06','L0005','Untuk operasional Kepala Prodi MI','Baru','P001'),('PB00006','2015-08-06','L0006','Untuk Operasional Dosen Prodi MI','Baru','P001'),('PB00007','2015-08-06','L0007','Untuk Operasional Kepala Prodi KA','Baru','P001'),('PB00008','2015-08-06','L0008','Untuk Operasional Dosen Prodi KA','Baru','P001'),('PB00009','2015-08-06','L0010','Pemindahan barang','Mutasi','P001'),('PB00010','2016-07-28','L0001','Penempatan','Baru','P001'),('PB00011','2016-07-28','L0001','Penempatan','Baru','P001'),('PB00012','2016-07-28','L0001','Penempatan','Baru','P001'),('PB00013','2016-08-25','L0015','oke','Mutasi','P005');
/*!40000 ALTER TABLE `penempatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penempatan_item`
--

DROP TABLE IF EXISTS `penempatan_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penempatan_item` (
  `no_penempatan` char(7) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  `status_aktif` enum('Yes','No') NOT NULL DEFAULT 'Yes'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penempatan_item`
--

LOCK TABLES `penempatan_item` WRITE;
/*!40000 ALTER TABLE `penempatan_item` DISABLE KEYS */;
INSERT INTO `penempatan_item` VALUES ('PB00010','B0003.000006','Yes'),('PB00010','B0003.000007','Yes'),('PB00011','B0001.000002','No'),('PB00011','B0001.000001','Yes'),('PB00012','B0002.000004','Yes'),('PB00012','B0002.000003','Yes'),('PB00013','B0001.000002','Yes');
/*!40000 ALTER TABLE `penempatan_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengadaan`
--

DROP TABLE IF EXISTS `pengadaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengadaan` (
  `no_pengadaan` char(7) NOT NULL,
  `tgl_pengadaan` date NOT NULL,
  `kd_supplier` char(4) NOT NULL,
  `jenis_pengadaan` varchar(100) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`no_pengadaan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengadaan`
--

LOCK TABLES `pengadaan` WRITE;
/*!40000 ALTER TABLE `pengadaan` DISABLE KEYS */;
INSERT INTO `pengadaan` VALUES ('BB00001','2015-06-04','S001','Pembelian','Pembelian dari Khas Kantor','P001'),('BB00002','2015-07-07','S002','Pembelian','Pengadaan dari uang Kas','P001'),('BB00003','2015-07-22','S002','Sumbangan','Sumbangan Uang dari Pemda','P001'),('BB00004','2015-08-06','S002','Pembelian','Pembelian dari Kas Kantor','P001'),('BB00005','2015-08-06','S004','Pembelian','Pembelian dari Kas Kantor','P001'),('BB00006','2015-08-06','S001','Pembelian','Pembelian dari Kas Kantor','P001'),('BB00007','2016-07-28','S001','Pembelian','pembelian','P001'),('BB00008','2016-07-28','S001','Pembelian','pembelian','P001'),('BB00009','2016-08-23','S005','Wakaf','oooo','P006'),('BB00010','2016-08-28','S001','Pembelian','oke','P005');
/*!40000 ALTER TABLE `pengadaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengadaan_item`
--

DROP TABLE IF EXISTS `pengadaan_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengadaan_item` (
  `no_pengadaan` char(7) NOT NULL,
  `kd_barang` char(5) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `harga_beli` int(12) NOT NULL,
  `jumlah` int(4) NOT NULL,
  KEY `nomor_penjualan_tamu` (`no_pengadaan`,`kd_barang`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengadaan_item`
--

LOCK TABLES `pengadaan_item` WRITE;
/*!40000 ALTER TABLE `pengadaan_item` DISABLE KEYS */;
INSERT INTO `pengadaan_item` VALUES ('BB00001','B0010','Komputer Rakitan Core 2 Duwo CPU Komplit',3200000,2),('BB00001','B0009','Komputer Rakitan Dual Core CPU Komplit',3000000,4),('BB00002','B0001','Toshiba Satellite C800D-1003 Black',7300000,2),('BB00002','B0002','Toshiba Satelite C40-A106 Black baru',5800000,3),('BB00003','B0004','Printer Canon IP 2770',470000,6),('BB00003','B0005','Printer Brother Colour Laser HL-2150N Mono',1200000,4),('BB00003','B0003','Printer Canon LBP 5100 Laser Jet',1350000,2),('BB00004','B0006','UPS Prolink Pro 700',450000,2),('BB00004','B0007','UPS Prolink IPS 500i Inverter 500VA',680000,7),('BB00005','B0008','Meja Komputer Crystal Grace 101',270000,7),('BB00006','B0011','LCD LG 19 Inch',1250000,7),('BB00007','B0009','Beli komputer lagi',3500000,5),('BB00008','B0010','Pembelian lagi',2500000,3),('BB00009','B0013','fddddddd',1000000,3),('BB00010','B0010','j',10000,2);
/*!40000 ALTER TABLE `pengadaan_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengembalian`
--

DROP TABLE IF EXISTS `pengembalian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengembalian` (
  `no_pengembalian` char(7) NOT NULL,
  `tgl_pengembalian` date NOT NULL,
  `no_peminjaman` char(7) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`no_pengembalian`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengembalian`
--

LOCK TABLES `pengembalian` WRITE;
/*!40000 ALTER TABLE `pengembalian` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengembalian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `petugas`
--

DROP TABLE IF EXISTS `petugas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `petugas` (
  `kd_petugas` char(4) NOT NULL,
  `nm_petugas` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `level` varchar(20) NOT NULL DEFAULT 'Kasir'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `petugas`
--

LOCK TABLES `petugas` WRITE;
/*!40000 ALTER TABLE `petugas` DISABLE KEYS */;
INSERT INTO `petugas` VALUES ('P001','Administrator','081911111111111','admin','21232f297a57a5a743894a0e4a801fc3','Admin'),('P002','Fitria Prasetya','081911111111','kasir','c7911af3adbd12a035b289556d96470a','Petugas'),('P004','Nama Petugas','08192222333','petugas','afb91ef692fd08c445e8cb1bab2ccf9c','Petugas'),('P005','Fajar Winata','081221718831','fajarwinata','24e95b6da2c98b4d802b593ef2cd82ef','Admin'),('P006','sendiri','09809876543','sendiri','827ccb0eea8a706c4c34a16891f84e7b','Admin'),('P007','fajar','0812','fajar','24bc50d85ad8fa9cda686145cf1f8aca','Petugas');
/*!40000 ALTER TABLE `petugas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rusak`
--

DROP TABLE IF EXISTS `rusak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rusak` (
  `no_rusak` varchar(7) NOT NULL,
  `tgl_rusak` date NOT NULL,
  `kd_inven` varchar(20) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `kd_petugas` varchar(20) NOT NULL,
  PRIMARY KEY (`no_rusak`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rusak`
--

LOCK TABLES `rusak` WRITE;
/*!40000 ALTER TABLE `rusak` DISABLE KEYS */;
INSERT INTO `rusak` VALUES ('PR00001','2016-08-26','B0001.000001','tes','P005'),('PR00002','2016-08-26','B0001.000002','','P005'),('PR00003','2016-08-26','B0002.000003','','P005'),('PR00004','2016-08-26','','uya','P005'),('PR00005','2016-08-26','','','P005'),('PR00006','2016-08-26','','tesssss','P005'),('PR00007','2016-08-26','B0004.000008','wow','P005'),('PR00008','2016-08-26','B0001.000001','hmmm','P005');
/*!40000 ALTER TABLE `rusak` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier` (
  `kd_supplier` char(4) NOT NULL,
  `nm_supplier` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  PRIMARY KEY (`kd_supplier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier`
--

LOCK TABLES `supplier` WRITE;
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` VALUES ('S001','ELS Computer','Jl. Adisucipto, Yogyakarta','02741111111'),('S002','ALNECT Computer','Jl. Janti, Jembatan Layang, Yogyakarta','08191010101'),('S003','MAKRO Gudang Rabat','Jl. Maguwo Yogyakarta','081912121212'),('S004','Gondang Jaya Mebel','Jl. Adisucipto, Yogyakarta','027412121212'),('S005','PROGO Toserba','Jl. Malioboro, Yogyakarta','0819111199911');
/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tmp_jual`
--

DROP TABLE IF EXISTS `tmp_jual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tmp_jual` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `kd_petugas` char(4) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmp_jual`
--

LOCK TABLES `tmp_jual` WRITE;
/*!40000 ALTER TABLE `tmp_jual` DISABLE KEYS */;
/*!40000 ALTER TABLE `tmp_jual` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tmp_mutasi`
--

DROP TABLE IF EXISTS `tmp_mutasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tmp_mutasi` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `no_penempatan` char(7) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmp_mutasi`
--

LOCK TABLES `tmp_mutasi` WRITE;
/*!40000 ALTER TABLE `tmp_mutasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `tmp_mutasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tmp_peminjaman`
--

DROP TABLE IF EXISTS `tmp_peminjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tmp_peminjaman` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `kd_petugas` char(4) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmp_peminjaman`
--

LOCK TABLES `tmp_peminjaman` WRITE;
/*!40000 ALTER TABLE `tmp_peminjaman` DISABLE KEYS */;
/*!40000 ALTER TABLE `tmp_peminjaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tmp_penempatan`
--

DROP TABLE IF EXISTS `tmp_penempatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tmp_penempatan` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `kd_petugas` char(4) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmp_penempatan`
--

LOCK TABLES `tmp_penempatan` WRITE;
/*!40000 ALTER TABLE `tmp_penempatan` DISABLE KEYS */;
/*!40000 ALTER TABLE `tmp_penempatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tmp_pengadaan`
--

DROP TABLE IF EXISTS `tmp_pengadaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tmp_pengadaan` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `kd_petugas` char(4) NOT NULL,
  `kd_barang` char(5) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `harga_beli` int(12) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmp_pengadaan`
--

LOCK TABLES `tmp_pengadaan` WRITE;
/*!40000 ALTER TABLE `tmp_pengadaan` DISABLE KEYS */;
/*!40000 ALTER TABLE `tmp_pengadaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tmp_rusak`
--

DROP TABLE IF EXISTS `tmp_rusak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tmp_rusak` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `kd_petugas` char(4) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmp_rusak`
--

LOCK TABLES `tmp_rusak` WRITE;
/*!40000 ALTER TABLE `tmp_rusak` DISABLE KEYS */;
/*!40000 ALTER TABLE `tmp_rusak` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-08-28 19:25:10
