<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
?>
<html>
<head>
<title>:: Laporan Data Pegawai - Inventory Kantor ( Aset Kantor )</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.print()">
<h2> LAPORAN DATA PEGAWAI </h2>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="23" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="50" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="210" bgcolor="#CCCCCC"><strong>Nama Pegawai </strong></td>
    <td width="90" bgcolor="#CCCCCC"><strong>Jns Kelamin</strong></td>
    <td width="296" bgcolor="#CCCCCC"><strong>Alamat Tinggal </strong></td>
    <td width="100" bgcolor="#CCCCCC"><strong>No. Telepon </strong></td>
  </tr>
  <?php
  	// Menampilkan data Pegawai
	$mySql = "SELECT * FROM pegawai ORDER BY kd_pegawai ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_pegawai']; ?></td>
    <td><?php echo $myData['nm_pegawai']; ?></td>
    <td><?php echo $myData['jns_kelamin']; ?></td>
    <td><?php echo $myData['alamat']; ?></td>
    <td><?php echo $myData['no_telepon']; ?></td>
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