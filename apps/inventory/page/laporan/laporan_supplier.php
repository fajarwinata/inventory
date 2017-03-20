<h2> LAPORAN DATA SUPPLIER </h2>
<div class="card-box table-responsive">
  <table id="datatable-buttons" class="table table-striped table-bordered">
    <thead>
    <tr>
    <th width="24" align="center" bgcolor="#CCCCCC"><strong>No</strong></th>
    <th width="51" bgcolor="#CCCCCC"><strong>Kode</strong></th>
    <th width="200" bgcolor="#CCCCCC"><strong>Nama Supplier </strong></th>
    <th width="475" bgcolor="#CCCCCC"><strong>Alamat Lengkap  </strong></th>
    <th width="124" bgcolor="#CCCCCC"><strong>No. Telepon </strong></th>
  </tr>
    </thead>
    <tbody>
<?php
	// Menampilkan data Supplier
	$mySql = "SELECT * FROM supplier ORDER BY kd_supplier ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_supplier']; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td><?php echo $myData['alamat']; ?></td>
    <td><?php echo $myData['no_telepon']; ?></td>
  </tr>
<?php } ?>
    </tbody>
</table>
  </div>
  <a href="cetak/supplier.php" target="_blank" class="btn btn-large btn-primary">
    <i class="fa fa-print"></i>&nbsp;&nbsp; CETAK DATA
  </a>
<a href="?open=Laporan-Cetak" class="btn btn-large btn-warning">
  <i class="fa fa-bars"></i>&nbsp;&nbsp; KEMBALI KE MENU
</a>