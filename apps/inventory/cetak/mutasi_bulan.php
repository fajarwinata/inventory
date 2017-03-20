<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

// Membuat daftar bulan
$listBulan = array("01" => "Januari", "02" => "Februari", "03" => "Maret",
				 "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
				 "08" => "Agustus", "09" => "September", "10" => "Oktober",
				 "11" => "November", "12" => "Desember");

// Membaca data Bulan dan Tahun dari URL
$dataTahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$dataBulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');

if($dataBulan and $dataTahun) {
	if($dataBulan=="00") {
		// Filter tahun
		$filterSQL	= "WHERE LEFT(tgl_mutasi,4)='$dataTahun'";
		
		$infoBulan	= "";
	}
	else {
		// Filter bulan dan tahun
		$filterSQL = "WHERE MID(tgl_mutasi,6,2)='$dataBulan' AND LEFT(tgl_mutasi,4)='$dataTahun'";
		
		$infoBulan	= $listBulan[$dataBulan].", ";
	}
}
else {
	$filterSQL = "";
}
?>
<html>
<head>
<title>:: Laporan Mutasi per Bulan & Tahun - Inventory Kantor (Aset Barang)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="window.print()">
<h2>LAPORAN MUTASI PER BULAN & TAHUN</h2>
<table width="500" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN </strong></td>
  </tr>
  <tr>
    <td width="132"><strong> Bulan Penempatan </strong></td>
    <td width="5"><strong>:</strong></td>
    <td width="349"><?php echo $infoBulan.$dataTahun; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="35" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="72" bgcolor="#F5F5F5"><strong>Tanggal</strong></td>
    <td width="106" bgcolor="#F5F5F5"><strong>No. Mutasi</strong></td>
    <td width="151" bgcolor="#F5F5F5"><strong>Lokasi Lama </strong></td>
    <td width="106" bgcolor="#F5F5F5"><strong>No. Penempatan </strong></td>
    <td width="145" bgcolor="#F5F5F5"><strong>Lokasi Baru </strong></td>
    <td width="168" bgcolor="#F5F5F5"><strong>Keterangan</strong></td>
    <td width="76" align="right" bgcolor="#F5F5F5"><strong>Qty Barang</strong></td>
  </tr>
  <?php
	// Skrip untuk menampilkan data Mutasi dengan filter Bulan dan Tahun, informasi dilengkapi data Lokasi
	$mySql = "SELECT mutasi.*, lokasi.nm_lokasi FROM mutasi 
				LEFT JOIN lokasi ON mutasi.kd_lokasi=lokasi.kd_lokasi 
				$filterSQL
				ORDER BY mutasi.no_mutasi DESC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		# Membaca Kode mutasi/ Nomor transaksi
		$noMutasi = $myData['no_mutasi'];

		# Perintah untuk mendapatkan data dari hasil Penempatan Baru
		$noPenempatan	= $myData['no_mutasi'];
		$my2Sql = "SELECT mutasi.*, lokasi.nm_lokasi FROM mutasi 
					LEFT JOIN lokasi ON mutasi.kd_lokasi=lokasi.kd_lokasi 
					WHERE mutasi.no_mutasi='$noPenempatan'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
		
		# Menghitung Total barang yang dimutasi setiap nomor transaksi
		$my3Sql = "SELECT COUNT(*) AS total_barang FROM mutasi_item WHERE no_mutasi='$noPenempatan'";
		$my3Qry = mysql_query($my3Sql, $koneksidb)  or die ("Query 3 salah : ".mysql_error());
		$my3Data = mysql_fetch_array($my3Qry);
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_mutasi']); ?></td>
    <td><?php echo $myData['no_mutasi']; ?></td>
    <td><?php echo $myData['nm_lokasi']; ?></td>
    <td><?php echo $myData['no_mutasi']; ?></td>
    <td><?php echo $my2Data['nm_lokasi']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="right"><?php echo format_angka($my3Data['total_barang']); ?></td>
  </tr>
  <?php } ?>
</table>
<script>
	window.onfocus=function(){
		close();
	}
</script>
</body>

</html>