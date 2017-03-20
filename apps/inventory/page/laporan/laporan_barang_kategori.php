<?php
// Variabel SQL
$filterSQL= "";

// Temporary Variabel form
$kodeKategori	= isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua'; // dari URL
$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKategori; // dari Form

# PENCARIAN DATA BERDASARKAN FILTER DATA
if(isset($_POST['btnTampil'])) {
	# PILIH KATEGORI
	if (trim($dataKategori) =="Semua") {
		$filterSQL = "";
	}
	else {
		$filterSQL = "WHERE kd_kategori='$dataKategori'";
	}
}
else {
	if(isset($kodeKategori)) {
		$filterSQL = "WHERE kd_kategori='$kodeKategori'";
	}
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row 	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM barang $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging:".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<h2> LAPORAN DATA BARANG PER KATEGORI</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">

	<table width="900" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="137"><b>Nama Kategori </b></td>
      <td width="5"><b>:</b></td>
      <td width="744">
		  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
			  <select name="cmbKategori" class="form-control has-feedback-left">
				  <option value="Semua"> .... </option>
				  <?php
				  // Menampilkan data Kategori ke dalam ComboBox (ListMenu)
			  $dataSql = "SELECT * FROM kategori ORDER BY kd_kategori";
			  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
			  while ($dataRow = mysql_fetch_array($dataQry)) {
				if ($dataRow['kd_kategori'] == $dataKategori) {
					$cek = " selected";
				} else { $cek=""; }
				echo "<option value='$dataRow[kd_kategori]' $cek>$dataRow[nm_kategori]</option>";
			  }
			  ?>
			  </select>
			  <span class="fa fa-puzzle-piece form-control-feedback left" aria-hidden="true"></span>
		  </div>
      <input name="btnTampil" class="btn btn-info" type="submit" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>
<div class="card-box table-responsive">
	<table id="datatable-buttons" class="table table-striped table-bordered">
		<thead>
		  <tr>
			<th width="23" bgcolor="#CCCCCC"><strong>No</strong></th>
			<th width="45" bgcolor="#CCCCCC"><strong>Kode</strong></th>
			<th width="329" bgcolor="#CCCCCC"><strong>Nama Barang</strong></th>
			<th width="140" bgcolor="#CCCCCC"><strong>Merek</strong></th>
			<th width="10" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></th>
			<th width="10" align="right" bgcolor="#CCCCCC"><strong> Tersedia </strong></th>
			<th width="10" align="right" bgcolor="#CCCCCC"><strong>Di-<br>tempat-<br>kan</strong></th>
			<th width="10" align="right" bgcolor="#CCCCCC"><strong>Dipinjam</strong></th>
			<th width="40" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></th>
		  </tr>
		  </thead>
		  <tbody>
		  <?php
			// Skrip menampilkan data Barang dengan filter Kategori
			$mySql 	= "SELECT * FROM barang $filterSQL ORDER BY kd_barang ASC LIMIT $hal, $row";
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
			<td><?php echo $myData['merek']; ?></td>
			<td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $myData['jumlah']; ?></td>
			<td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $jumTersedia; ?></td>
			<td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $jumDitempatkan; ?></td>
			<td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $jumDipinjam; ?></td>
			<td align="center"><a href="cetak/barang_view.php?Kode=<?php echo $Kode; ?>" target="_blank"><img src="images/btn_print.png" height="20"/></a></td>
		  </tr>
		  <?php } ?>
		  </tbody>
		</table>
	</div>
	<table width="100%">
  <tr>
    <td>
		<a href="cetak/barang_kategori.php?kodeKategori=<?php echo $dataKategori; ?>" target="_blank" class="btn btn-large btn-primary">
			<i class="fa fa-print"></i>&nbsp;&nbsp; CETAK SEMUA
		</a>
		<a href="?open=Laporan-Cetak" class="btn btn-large btn-warning">
			<i class="fa fa-bars"></i>&nbsp;&nbsp; KEMBALI KE MENU
		</a>
	</td>
    <td bgcolor="#F5F5F5"><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
  </tr>
</table>

