<?php
# Tombol Simpan diklik
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtNama		= $_POST['txtNama'];
	$cmbKelamin		= $_POST['cmbKelamin'];
	$txtAlamat		= $_POST['txtAlamat'];
	$txtTelepon		= $_POST['txtTelepon'];
	
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Pegawai</b> tidak boleh kosong, silahkan dilengkapi !";		
	}
	if (trim($cmbKelamin)=="Kosong") {
		$pesanError[] = "Data <b>Kelamin</b> belum dipilih, silahkan pilih pada Combo !";		
	}
	if (trim($txtAlamat)=="") {
		$pesanError[] = "Data <b>Alamat Lengkap</b> tidak boleh kosong, silahkan dilengkapi !";		
	}
	if (trim($txtTelepon)=="") {
		$pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong, silahkan dilengkapi !";		
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
		$mySql	= "UPDATE pegawai SET nm_pegawai='$txtNama', jns_kelamin='$cmbKelamin', alamat='$txtAlamat',
					no_telepon='$txtTelepon' WHERE kd_pegawai ='$Kode'";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Pegawai-Data'>";
		}
		exit;
	}	
} // Penutup Tombol Simpan

# MENGAMBIL DATA YANG DIEDIT, SESUAI KODE YANG DIDAPAT DARI URL
$Kode	= $_GET['Kode']; 
$mySql	= "SELECT * FROM pegawai WHERE kd_pegawai='$Kode'";
$myQry	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
$myData = mysql_fetch_array($myQry);

	# MASUKKAN DATA DARI FORM KE VARIABEL TEMPORARY (SEMENTARA)
	$dataKode	= $myData['kd_pegawai'];
	$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_pegawai'];
	$dataKelamin= isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : $myData['jns_kelamin'];
	$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : $myData['alamat'];
	$dataTelepon= isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : $myData['no_telepon'];
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1">
<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Ubah Data Pegawai <small>&nbsp;</small></h2>
					<a href="?open=Pegawai-Data"  class="btn btn-warning">Batal &amp; Kembali</a>
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
	  <input name="txtTelepon" type="text" value="<?php echo $dataTelepon; ?>" class="form-control has-feedback-left" />
      <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
	  </div>
	
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">		
      <input name="txtAlamat" type="text"  value="<?php echo $dataAlamat; ?>" class="form-control has-feedback-left" />
      <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
	  </div>
		  
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">	
        <select name="cmbKelamin" class="form-control">
          <?php
		  $pilihan	= array("Laki-laki", "Perempuan");
          foreach ($pilihan as $nilai) {
            if ($dataKelamin==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
	  </div>
	  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">	
	          <input type="submit" name="btnSimpan" class="btn btn-primary" value=" Simpan " /> </td>
			  </div>
	</div>
		</div>
			</div>
		</div>	    
</form>

