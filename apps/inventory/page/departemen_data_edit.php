<?php
include_once "library/inc.seslogin.php";

# TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtNama		= $_POST['txtNama'];
	$txtKeterangan	= $_POST['txtKeterangan'];
	
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Departemen</b> tidak boleh kosong !";		
	}
	if (trim($txtKeterangan)=="") {
		$pesanError[] = "Data <b>Keterangan</b> tidak boleh kosong !";		
	}
	
	# Validasi Nama departemen, jika sudah ada akan ditolak
	$Kode	= $_POST['txtKode'];
	$cekSql	= "SELECT * FROM departemen WHERE nm_departemen='$txtNama' AND NOT(kd_departemen='$Kode')";
	$cekQry	= mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($cekQry)>=1){
		$pesanError[] = "Maaf, departemen <b> $txtNama </b> sudah ada, ganti dengan yang lain";
	}
	
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo " <div class='x_content bs-example-popovers'>";
		echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>";
		echo "<img src='images/inv_icn_kesalahan.png' /> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div></div> <br>"; 
	}
	else {
		# SIMPAN PERUBAHAN DATA, Jika jumlah error pesanError tidak ada, simpan datanya
		$Kode	= $_POST['txtKode'];
		$mySql	= "UPDATE departemen SET nm_departemen='$txtNama', keterangan='$txtKeterangan' WHERE kd_departemen ='$Kode'";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Departemen-Data'>";
		}
		exit;
	}	
} // Penutup Tombol Simpan

# TAMPILKAN DATA LOGIN UNTUK DIEDIT
$Kode	 = $_GET['Kode']; 
$mySql	 = "SELECT * FROM departemen WHERE kd_departemen='$Kode'";
$myQry	 = mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
$myData	 = mysql_fetch_array($myQry);

	// Menyimpan data ke variabel temporary (sementara)
	$dataKode	= $myData['kd_departemen'];
	$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_departemen'];
	$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $myData['keterangan'];
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1">
<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Ubah Data Departemen <small>&nbsp;</small></h2>
					<a href="?open=Departemen-Data"  class="btn btn-warning">Batal &amp; Kembali</a>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
				  
	  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">		  
	  <input name="textfield" type="text"  value="<?php echo $dataKode; ?>" class="form-control has-feedback-left"  readonly="readonly"/>
      <span class="fa fa-check-square-o form-control-feedback left" aria-hidden="true"></span>
	  <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td>
	  </div>
	  
	  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">	
      <input name="txtNama" type="text" value="<?php echo $dataNama; ?>" class="form-control has-feedback-left" />
	  <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
	  </div>
    	
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">		
      <input name="txtKeterangan" type="text"  value="<?php echo $dataKeterangan; ?>" class="form-control has-feedback-left" />
      <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
	  </div>
		  
	  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">	
	          <input type="submit" name="btnSimpan" class="btn btn-primary" value=" Simpan " /> </td>
			  </div>
	</div>
		</div>
			</div>
		</div>	    
</form>

