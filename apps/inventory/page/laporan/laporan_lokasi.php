<h2> LAPORAN DATA LOKASI </h2>
<div class="card-box table-responsive">
  <table id="datatable-buttons" class="table table-striped table-bordered">
    <thead>
    <tr>
    <td width="23" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="54" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="380" bgcolor="#CCCCCC"><b>Nama Lokasi </b></td>
    <td width="322" bgcolor="#CCCCCC"><b>Departemen </b></td>  
    </tr>
    </thead>
    <tbody>

  <?php
	  // Menampilkan data Lokasi, dilengkapi dengan data Departemen dari tabel relasi
	$mySql = "SELECT lokasi.*, departemen.nm_departemen FROM lokasi 
				LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
				ORDER BY kd_lokasi ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_lokasi'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_lokasi']; ?></td>
    <td><?php echo $myData['nm_lokasi']; ?></td>
    <td><?php echo $myData['nm_departemen']; ?></td>
  </tr>
  <?php } ?>
    </tbody>
</table>
  </div>
<br />
<a href="cetak/lokasi.php" target="_blank" class="btn btn-large btn-primary">
  <i class="fa fa-print"></i>&nbsp;&nbsp; CETAK DATA
</a>
<a href="?open=Laporan-Cetak" class="btn btn-large btn-warning">
  <i class="fa fa-bars"></i>&nbsp;&nbsp; KEMBALI KE MENU
</a>