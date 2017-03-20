<?php
# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM barang";
$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging:".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<h2>LAPORAN DATA BARANG</h2>
<div class="card-box table-responsive">
	<table id="datatable-buttons" class="table table-striped table-bordered">
		<thead>
		  <tr>
			<th width="23" bgcolor="#CCCCCC"><strong>No</strong></th>
			<th width="50" bgcolor="#CCCCCC"><strong>Kode</strong></th>
			<th width="261" bgcolor="#CCCCCC"><strong>Nama Barang</strong></th>
			<th width="155" bgcolor="#CCCCCC"><strong>Kategori</strong></th>
			<th width="67" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></th>
			<th width="73" align="right" bgcolor="#CCCCCC"><strong> Tersedia </strong></th>
			<th width="92" align="right" bgcolor="#CCCCCC"><strong>Ditempatkan</strong></th>
			<th width="93" align="right" bgcolor="#CCCCCC"><strong>Dipinjam</strong></th>
			<th width="40" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></th>
		  </tr>
		</thead>
		<tbody>
		  <?php
			# MENJALANKAN QUERY
			$mySql 	= "SELECT barang.*, kategori.nm_kategori FROM barang
						LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
						ORDER BY barang.kd_barang ASC LIMIT $hal, $row";
			$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
			$nomor  = $hal;
			while ($myData = mysql_fetch_array($myQry)) {
				$nomor++;
				$Kode = $myData['kd_barang'];

				// Membuat variabel akan diisi angka
				$jumTersedia =0;
				$jumDitempatkan =0;
				$jumDipinjam =0;

				// Query menampilkan data Inventaris per Kode barang
				$my2Sql = "SELECT * FROM barang_inventaris WHERE kd_barang='$Kode'";
				$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
				while($my2Data = mysql_fetch_array($my2Qry)) {
					if($my2Data['status_barang']=="Tersedia") {
						$jumTersedia++;
					}

					if($my2Data['status_barang']=="Ditempatkan") {
						$jumDitempatkan++;
					}

					if($my2Data['status_barang']=="Dipinjam") {
						$jumDipinjam++;
					}
				}
				// gradasi warna
				if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
			?>
		  <tr bgcolor="<?php echo $warna; ?>">
			<td><?php echo $nomor; ?></td>
			<td><?php echo $myData['kd_barang']; ?></td>
			<td><?php echo $myData['nm_barang']; ?></td>
			<td><?php echo $myData['nm_kategori']; ?></td>
			<td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $myData['jumlah']; ?></td>
			<td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $jumTersedia; ?></td>
			<td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $jumDitempatkan; ?></td>
			<td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $jumDipinjam; ?></td>
			<td align="center"><a href="cetak/barang_view.php?Kode=<?php echo $Kode; ?>" target="_blank">View</a></td>
		  </tr>
		<?php } ?>
		</tbody>
	</table>
	</div>
	<table width="100%">
  <tr>
    <td><a href="cetak/barang.php" target="_blank" class="btn btn-large btn-primary">
			<i class="fa fa-print"></i>&nbsp;&nbsp; CETAK DATA
		</a>
		<a href="?open=Laporan-Cetak" class="btn btn-large btn-warning">
			<i class="fa fa-bars"></i>&nbsp;&nbsp; KEMBALI KE MENU
		</a>
	</td>
    <td bgcolor="#CCCCCC" style="padding: 10px"><b>Jumlah Data : </b> <?php echo $jml; ?> </td>
  </tr>
</table>

