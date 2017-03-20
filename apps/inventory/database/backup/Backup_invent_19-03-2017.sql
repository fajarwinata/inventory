-- MySQL dump 10.16  Distrib 10.1.19-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: localhost
-- ------------------------------------------------------
-- Server version	10.1.19-MariaDB

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mutasi_asal`
--

LOCK TABLES `mutasi_asal` WRITE;
/*!40000 ALTER TABLE `mutasi_asal` DISABLE KEYS */;
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
  `level` varchar(20) NOT NULL DEFAULT 'Kasir',
  PRIMARY KEY (`kd_petugas`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `petugas`
--

LOCK TABLES `petugas` WRITE;
/*!40000 ALTER TABLE `petugas` DISABLE KEYS */;
INSERT INTO `petugas` VALUES ('P001','Shafira H. Kusumah','081572433334','shafira','2ec4b0bdf35a294f7b42496e0a19ceea','Admin');
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
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

-- Dump completed on 2017-03-19 11:15:33
