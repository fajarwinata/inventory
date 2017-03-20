<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

?>
<html>
<head>
<title> :: Laporan Data Petugas - Inventory Kantor ( Aset Kantor )</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body onload="javascript:window.print()">
<h2> LAPORAN DATA PETUGAS </h2>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="30" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="52" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="344" bgcolor="#F5F5F5"><strong>Nama Petugas</strong></td>
    <td width="136" bgcolor="#F5F5F5"><b>No. Telepon </b></td>
    <td width="126" bgcolor="#F5F5F5"><strong>Username</strong></td>
    <td width="81" bgcolor="#F5F5F5"><strong>Level</strong></td>
  </tr>
  <?php
  	// Menampilkan data Petugas
	$mySql = "SELECT * FROM petugas ORDER BY kd_petugas ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor	 = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_petugas']; ?></td>
    <td><?php echo $myData['nm_petugas']; ?></td>
    <td><?php echo $myData['no_telepon']; ?></td>
    <td><?php echo $myData['username']; ?></td>
    <td><?php echo $myData['level']; ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
<img src="../images/btn_delete.png" width="20" onClick="javascript:window.close()" /> (Batal)

</body>
<script>
  window.onfocus=function(){
    window.close();
  }
</script>
</html>