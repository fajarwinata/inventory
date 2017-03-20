<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";

$kategoriSQL= "";
$cariSQL 	= "";

# Temporary Variabel form
$kodeKategori	= isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : '';
$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKategori;

$keyWord		= isset($_GET['keyWord']) ? $_GET['keyWord'] : '';
$dataKataKunci	= isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';

# PENCARIAN DATA BERDASARKAN FILTER DATA (Kode Type Kamar)
if(isset($_POST['btnTampil'])) {
	# PILIH KATEGORI
	if (trim($_POST['cmbKategori']) =="BLANK") {
		$kategoriSQL = "";
	}
	else {
		$kategoriSQL = "AND barang.kd_kategori='$dataKategori'";
	}

}
else {
	//Query #1 (all)
	$supplierSQL= "";
	$kategoriSQL= "";
}


# PENCARIAN DATA BERDASARKAN FILTER DATA (Kode Type Kamar)
if(isset($_POST['btnCari'])) {
	$txtKataKunci	= trim($_POST['txtKataKunci']); 

	$cariSQL		= " AND barang_inventaris.kd_inventaris='$txtKataKunci' OR barang.nm_barang LIKE '%$txtKataKunci%' ";
	
	// Pencarian Multi String (beberapa kata)
	$keyWord 		= explode(" ", $txtKataKunci);
	if(count($keyWord) > 1) {
		foreach($keyWord as $kata) {
			$cariSQL	.= " OR barang.nm_barang LIKE '%$kata%'";
		} 
	}
}
else {
	//Query #1 (all)
	$cariSQL 	= "";
}

?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
<table width="900" border="0" cellpadding="2" cellspacing="1" class="table-list">
<tr>
  <td colspan="3" bgcolor="#F5F5F5"><b>FILTER DATA  </b></td>
</tr>
<tr>
  <td width="186"><b>Nama Kategori </b></td>
  <td width="5"><b>:</b></td>
  <td width="1007">
  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
  <select name="cmbKategori" onChange="javascript:submitform();" class="form-control has-feedback-left">
	<option value="BLANK">....</option>
	<?php
	  $dataSql = "SELECT * FROM kategori ORDER BY kd_kategori";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
		if ($dataRow['kd_kategori'] == $dataKategori) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$dataRow[kd_kategori]' $cek>$dataRow[nm_kategori]</option>";
	  }
	  $sqlData ="";
	  ?>
	  </select>
	  <span class="fa fa-puzzle-piece form-control-feedback left" aria-hidden="true"></span>
	  </div></td>
</tr>

<tr>
  <td><strong>Cari Barang </strong></td>
  <td><strong>:</strong></td>
  <td>
  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
  <input name="txtKataKunci" type="text" value="<?php echo $dataKataKunci; ?>" size="45" maxlength="100" class="form-control has-feedback-left"/>
  <span class="fa fa-puzzle-piece form-control-feedback left" aria-hidden="true"></span>
  </div>
  <input name="btnCari" type="submit" value=" Cari " class="btn btn-warning"/>
      
      </td>
</tr>
</table>
</form>

<form action="cetak_barcode_print.php" method="post" name="form2" target="_blank">
<div class="card-box table-responsive">
 <table id="datatable-buttons" class="table table-striped table-bordered">
  <thead>
  <tr>
   <th width="35" align="center">Pilih</th>
    <th width="50"><strong>Kode</strong></th>
    <th width="402"><b>Nama Barang </b></th>
    <th width="247"><b>Kategori</b></th>
    <th width="5px"><strong>Jml</strong></th>
    <th width="52">Satuan</th>
    
    <th width="37" align="center"><strong>Tools</strong></th>
    </tr>
   </thead>
   <tbody>
  <?php
	# MENJALANKAN QUERY , 
	$mySql = "SELECT barang.*, kategori.nm_kategori FROM barang_inventaris
					LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
					LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
				WHERE barang.kd_barang !='' $kategoriSQL $cariSQL
				GROUP BY barang.kd_barang ORDER BY barang.kd_barang ASC";  
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_barang'];
		
		?>
  <tr>
    <td align="center"><input name="cbKode[]" type="checkbox" id="cbKode" value="<?php echo $Kode; ?>" /></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_kategori']; ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td><?php echo $myData['satuan']; ?></td>
    
    <td align="center">
    <a href="?open=Cetak-Barcode-View&Kode=<?php echo $myData['kd_barang']; ?>" class="btn btn-info">View</a></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
</div><input name="btnCetak" type="submit" value=" Cetak Label " class="btn btn-success" />
<p><strong>* Note:</strong> Centang dulu pada nama barang yang akan dibuat label ( klik <strong>Cek</strong> ), baru klik tombol  <strong>Cetak Barcode</strong></p>
</form>
