<?php
include_once "library/inc.seslogin.php";
?>
<h2> LAPORAN DATA KATEGORI </h2>
<div class="card-box table-responsive">
  <table id="datatable-buttons" class="table table-striped table-bordered">
    <thead>
    <tr>
      <th width="21" align="center" bgcolor="#CCCCCC"><b>No</b></th>
      <th width="50" bgcolor="#CCCCCC"><strong>Kode</strong></th>
      <th width="608" bgcolor="#CCCCCC"><b>Nama Kategori </b></th>
      <th width="100" align="center" bgcolor="#CCCCCC"><b>Qty Barang </b> </th>
    </tr>
    </thead>
    <tbody>
  <?php
	  // Menampilkan daftar kategori
	$mySql = "SELECT * FROM kategori ORDER BY kd_kategori ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_kategori'];
		
		// Menghitung jumlah barang per Kategori
		$my2Sql = "SELECT COUNT(*) As qty_barang FROM barang WHERE kd_kategori='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_kategori']; ?></td>
    <td><?php echo $myData['nm_kategori']; ?></td>
    <td align="center"><?php echo $my2Data['qty_barang']; ?></td>
  </tr>
  <?php } ?>
    </tbody>
</table>
  </div>
<br />
<a href="cetak/kategori.php" target="_blank" class="btn btn-large btn-primary">
  <i class="fa fa-print"></i>&nbsp;&nbsp; CETAK DATA
</a>
<a href="?open=Laporan-Cetak" class="btn btn-large btn-warning">
  <i class="fa fa-bars"></i>&nbsp;&nbsp; KEMBALI KE MENU
</a>
