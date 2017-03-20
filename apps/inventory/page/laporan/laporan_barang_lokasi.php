<?php

// Variabel SQL
$filterSQL= "";

// Variabel data Combo Lokasi
$kodeDepartemen	= isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : 'Semua'; // dari URL
$dataDepartemen	= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $kodeDepartemen; // dari Form

// Variabel data Combo Lokasi
$kodeLokasi	= isset($_GET['kodeLokasi']) ? $_GET['kodeLokasi'] : 'Semua'; // dari URL
$dataLokasi	= isset($_POST['cmbLokasi']) ? $_POST['cmbLokasi'] : $kodeLokasi; // dari Form

# MEMBUAT FILTER DATA
if (trim($dataLokasi) =="Semua") {
	if (trim($dataDepartemen) =="Semua") {
		// Jika Lokasi Kosong Semua, dan Departemen Kosong
		$filterSQL = "";
	}
	else {
		// dan Jika Lokasi Kosong (Semua), dan Departemen dipilih
		$filterSQL = " AND lokasi.kd_departemen='$dataDepartemen'";
	}
}
else {
	// Jika Lokasi dipilih
	$filterSQL = "AND penempatan.kd_lokasi='$dataLokasi'";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM penempatan_item as Pi
					LEFT JOIN penempatan ON Pi.no_penempatan=penempatan.no_penempatan 
					LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
					$filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging:".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$baris);
?>
<h2> LAPORAN DATA BARANG PER LOKASI</h2>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT> 

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td><b> Departemen </b></td>
      <td><b>:</b></td>
      <td>
		  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
		  <select name="cmbDepartemen" onchange="javascript:submitform();" class="form-control has-feedback-left">
          <option value="Semua">....</option>
          <?php
		  // Skrip menampilkan data Departemen dalam ComboBox
	  $comboSql = "SELECT * FROM departemen ORDER BY kd_departemen";
	  $comboQry = mysql_query($comboSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($comboData = mysql_fetch_array($comboQry)) {
		if ($comboData['kd_departemen'] == $dataDepartemen) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$comboData[kd_departemen]' $cek>$comboData[nm_departemen]</option>";
	  }
	  ?>
        </select>
			  <span class="fa fa-puzzle-piece form-control-feedback left" aria-hidden="true"></span>
	  </div>
	  </td>
    </tr>
    <tr>
      <td width="137"><b> Lokasi </b></td>
      <td width="6"><b>:</b></td>
      <td width="743">
		  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	  <select name="cmbLokasi" class="form-control has-feedback-left">
          <?php
		  // Menampilkan data Lokasi per Departemen yang dipilih dari ComboBox
	  $comboSql = "SELECT * FROM lokasi WHERE kd_departemen='$dataDepartemen' ORDER BY kd_lokasi";
	  $comboQry = mysql_query($comboSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($comboData = mysql_fetch_array($comboQry)) {
		if ($comboData['kd_lokasi'] == $dataLokasi) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$comboData[kd_lokasi]' $cek>$comboData[nm_lokasi]</option>";
	  }
	  ?>
      </select>
			  <span class="fa fa-location-arrow form-control-feedback left" aria-hidden="true"></span>
			  </div>
      <input name="btnTampil" class="btn btn-info" type="submit" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>
<div class="card-box table-responsive">
<table id="datatable-buttons" class="table table-striped table-bordered">
	<thead>
  <tr>
    <th width="22" bgcolor="#CCCCCC"><strong>No</strong></th>
    <th width="106" bgcolor="#CCCCCC"><strong>Kode Label </strong></th>
    <th width="371" bgcolor="#CCCCCC"><strong>Nama Barang</strong></th>
    <th width="180" bgcolor="#CCCCCC"><strong>Kategori</strong></th>
    <th width="120" bgcolor="#CCCCCC"><strong>Merek</strong></th>
    <th width="70" bgcolor="#CCCCCC"><strong>Satuan</strong></th>
  </tr>
  </thead>
	<tbody>
  <?php
	# MENJALANKAN QUERY, menampilkan daftar nama barang yang ada di setiap Lokasi Penempatan
	$mySql 	= "SELECT Pi.kd_inventaris, barang.*, kategori.nm_kategori FROM penempatan_item as Pi
					LEFT JOIN penempatan ON Pi.no_penempatan=penempatan.no_penempatan 
					LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
					LEFT JOIN barang_inventaris ON Pi.kd_inventaris=barang_inventaris.kd_inventaris
					LEFT JOIN barang ON barang.kd_barang=barang_inventaris.kd_barang
					LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
				WHERE Pi.status_aktif='Yes' $filterSQL
				ORDER BY Pi.kd_inventaris ASC LIMIT $hal, $baris";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		// gradasi warna

	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_inventaris']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_kategori']; ?></td>
    <td><?php echo $myData['merek']; ?></td>
    <td><?php echo $myData['satuan']; ?></td>
  </tr>
  <?php } ?>
	</tbody>
	</table>
	</div>
<table width="100%">
  <tr>
    <td >
		<a href="cetak/barang_lokasi.php?kodeLokasi=<?php echo $dataLokasi; ?>" target="_blank" class="btn btn-large btn-primary">
			<i class="fa fa-print"></i>&nbsp;&nbsp; CETAK DATA
		</a>
		<a href="?open=Laporan-Cetak" class="btn btn-large btn-warning">
			<i class="fa fa-bars"></i>&nbsp;&nbsp; KEMBALI KE MENU
		</a>
	</td>
    <td bgcolor="#F5F5F5"><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
  </tr>
</table>
<br />
