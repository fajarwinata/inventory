<?php
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtNama		= $_POST['txtNama'];
	$txtNama		= str_replace("'","&acute;",$txtNama); // menghalangi penulisan tanda petik satu (')
	
	$txtKeterangan	= $_POST['txtKeterangan'];
	$txtKeterangan	= str_replace("'","&acute;",$txtKeterangan); // menghalangi penulisan tanda petik satu (')
	
	$txtMerek		= $_POST['txtMerek'];
	$txtMerek		= str_replace("'","&acute;",$txtMerek); // menghalangi penulisan tanda petik satu (')
	
	$cmbSatuan		= $_POST['cmbSatuan'];
	$cmbKategori	= $_POST['cmbKategori'];

	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Barang</b> tidak boleh kosong !";		
	}
	if (trim($txtKeterangan)=="") {
		$pesanError[] = "Data <b>Keterangan</b> tidak boleh kosong !";		
	}
	if (trim($txtMerek)=="") {
		$pesanError[] = "Data <b>Merek</b> tidak boleh kosong !";		
	}
	if (trim($cmbSatuan)=="Kosong") {
		$pesanError[] = "Data <b>Satuan Barang</b> belum dipilih !";		
	}
	if (trim($cmbKategori)=="Kosong") {
		$pesanError[] = "Data <b>Kategori Barang</b> belum dipilih !";		
	}
	
	# Validasi Nama barang, jika sudah ada akan ditolak
	$Kode	= $_POST['txtKode'];
	$sqlCek	= "SELECT * FROM barang WHERE nm_barang='$txtNama' AND NOT(kd_barang='$Kode')";
	$qryCek	= mysql_query($sqlCek, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($qryCek)>=1){
		$pesanError[] = "Maaf, Nama Barang <b> $txtNama </b> sudah dipakai, ganti dengan yang lain";
	}
	
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# TIDAK ADA ERROR, Jika jumlah error message tidak ada, simpan datanya
		$Kode	= $_POST['txtKode'];
		$mySql	= "UPDATE barang SET  nm_barang='$txtNama',
									keterangan='$txtKeterangan',
									merek='$txtMerek',
									satuan='$cmbSatuan',
									kd_kategori='$cmbKategori'
						WHERE kd_barang ='$Kode'";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Data'>";
		}
		exit;
	}	
} // Penutup POST

# TAMPILKAN DATA UNTUK DIEDIT
$Kode	 = $_GET['Kode']; 
$mySql = "SELECT * FROM barang WHERE kd_barang='$Kode'";
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
$myData= mysql_fetch_array($myQry);

	# MASUKKAN DATA KE VARIABEL
	$dataKode	= $myData['kd_barang'];
	$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_barang'];
	$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $myData['keterangan'];
	$dataMerek		= isset($_POST['txtMerek']) ? $_POST['txtMerek'] : $myData['merek'];
	$dataSatuan		= isset($_POST['cmbSatuan']) ? $_POST['cmbSatuan'] : $myData['satuan'];
	$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $myData['kd_kategori'];
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmedit">
	<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">	
		<input name="textfield" value="<?php echo $dataKode; ?>" maxlength="10"  class="form-control has-feedback-left" readonly="readonly"/>
    	<input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" />
		<span class="fa fa-check-square-o form-control-feedback left" aria-hidden="true"></span>
	</div>

		<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
			<input name="txtNama" value="<?php echo $dataNama; ?>" class="form-control has-feedback-left" maxlength="100" />
	    <input name="txtLama" type="hidden" value="<?php echo $myData['nm_barang']; ?>" />
		<span class="fa fa-file-archive-o form-control-feedback left" aria-hidden="true"></span>
		</div>
    
	<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	 <textarea name="txtKeterangan" class="form-control has-feedback-left" style="height:130px"><?php echo $dataKeterangan; ?></textarea>
		<span class="fa fa-info form-control-feedback left" aria-hidden="true"></span>
	</div>
	<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	  <input name="txtMerek" value="<?php echo $dataMerek; ?>" class="form-control has-feedback-left" maxlength="100" />
		<span class="fa fa-institution form-control-feedback left" aria-hidden="true"></span>
	</div>	
    
	<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
        <select name="cmbSatuan" class="form-control has-feedback-left">
          <?php
		  include_once "library/inc.pilihan.php";
          foreach ($satuan as $nilai) {
            if ($dataSatuan == $nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
		<span class="fa fa-briefcase form-control-feedback left" aria-hidden="true"></span>
	</div>
	
	<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
	<select name="cmbKategori" class="form-control has-feedback-left">
        <?php
		$mySql = "SELECT * FROM kategori ORDER BY nm_kategori";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
		while ($myData = mysql_fetch_array($myQry)) {
		if ($myData['kd_kategori']== $dataKategori) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$myData[kd_kategori]' $cek>$myData[nm_kategori] </option>";
		}
		?>
		</select>
	<span class="fa fa-archive form-control-feedback left" aria-hidden="true"></span>
	</div>
	<div class="col-md-3 col-sm-3 col-xs-12">
	  <input type="submit" name="btnSimpan" value=" SIMPAN " class="btn btn-primary" style="cursor:pointer;">
	</div>
    
</form>

