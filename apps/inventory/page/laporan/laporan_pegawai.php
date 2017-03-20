<?php
include_once "library/inc.seslogin.php";
?>
<h2> LAPORAN DATA PEGAWAI </h2>
<div class="card-box table-responsive">
  <table id="datatable-buttons" class="table table-striped table-bordered">
    <thead>
  <tr>
    <th width="23" align="center" bgcolor="#CCCCCC"><strong>No</strong></th>
    <th width="50" bgcolor="#CCCCCC"><strong>Kode</strong></th>
    <th width="210" bgcolor="#CCCCCC"><strong>Nama Pegawai </strong></th>
    <th width="90" bgcolor="#CCCCCC"><strong>Jns Kelamin</strong></th>
    <th width="296" bgcolor="#CCCCCC"><strong>Alamat Tinggal  </strong></th>
    <th width="100" bgcolor="#CCCCCC"><strong>No. Telepon </strong></th>
  </tr>
  </thead>
    <tbody>
<?php
	// Menampilkan data Pegawai
	$mySql = "SELECT * FROM pegawai ORDER BY kd_pegawai ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_pegawai']; ?></td>
    <td><?php echo $myData['nm_pegawai']; ?></td>
    <td><?php echo $myData['jns_kelamin']; ?></td>
    <td><?php echo $myData['alamat']; ?></td>
    <td><?php echo $myData['no_telepon']; ?></td>
  </tr>
<?php } ?>
    </tbody>
</table>
  </div>
<br />
<a href="cetak/pegawai.php" target="_blank" class="btn btn-large btn-primary">
  <i class="fa fa-print"></i>&nbsp;&nbsp; CETAK DATA
</a>
<a href="?open=Laporan-Cetak" class="btn btn-large btn-warning">
  <i class="fa fa-bars"></i>&nbsp;&nbsp; KEMBALI KE MENU
</a>