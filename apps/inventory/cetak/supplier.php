<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
?>
<html>
<head>
<title>:: Laporan Data Supplier - Inventory Kantor ( Aset Kantor )</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.print()">
<h2> LAPORAN DATA SUPPLIER </h2>
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="26" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="56" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="246" bgcolor="#F5F5F5"><strong>Nama Supplier </strong></td>
    <td width="420" bgcolor="#F5F5F5"><strong>Alamat Lengkap </strong></td>
    <td width="126" bgcolor="#F5F5F5"><strong>No. Telepon </strong></td>
  </tr>
  <?php
    // Menampilkan data Supplier
	$mySql = "SELECT * FROM supplier ORDER BY kd_supplier ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_supplier']; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
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