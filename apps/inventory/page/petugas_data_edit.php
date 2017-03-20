<?php
# Tombol Simpan diklik
if(isset($_POST['btnSimpan'])){
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtNama		= $_POST['txtNama'];
	$txtUsername	= $_POST['txtUsername'];
	$txtPassword	= $_POST['txtPassword'];	
	$txtTelepon		= $_POST['txtTelepon'];	
	$cmbLevel		= $_POST['cmbLevel'];
	
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Petugas</b> tidak boleh kosong, silahkan diisi !";		
	}
	if (trim($txtTelepon)=="") {
		$pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong, silahkan diisi !";		
	}
	if (trim($txtUsername)=="") {
		$pesanError[] = "Data <b>Username</b> tidak boleh kosong, silahkan diisi !";		
	}
	if (trim($cmbLevel)=="Kosong") {
		$pesanError[] = "Data <b>Level login</b> belum dipilih, silahkan dipilih dari Combo !";		
	}
			
	# VALIDASI petugas LOGIN (username), jika sudah ada akan ditolak
	$Kode	= $_POST['txtKode'];
	$cekSql	= "SELECT * FROM petugas WHERE username='$txtUsername' AND NOT(kd_petugas ='$Kode')";
	$cekQry	= mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($cekQry)>=1){
		$pesanError[] = "Username : <b> $txtUsername </b> sudah ada, ganti dengan yang lain";
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
		# Cek Password baru
		if (trim($txtPassword)=="") {
			$txtPassLama	= $_POST['txtPassLama'];
			
			$sqlPasword = ", password='$txtPassLama'";
		}
		else {
			$sqlPasword = ",  password ='".md5($txtPassword)."'";
		}
		
		# SIMPAN DATA KE DATABASE (Jika tidak menemukan error, simpan data ke database)
		$Kode	= $_POST['txtKode'];
		$mySql  = "UPDATE petugas SET nm_petugas='$txtNama', username='$txtUsername', 
					no_telepon='$txtTelepon', level='$cmbLevel'
					$sqlPasword  
					WHERE kd_petugas='$Kode'";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Petugas-Data'>";
		}
		exit;
	}	
} // Penutup Tombol Simpan


# TAMPILKAN DATA DARI DATABASE, Untuk ditampilkan kembali ke form edit
$Kode	= $_GET['Kode']; 
$mySql	= "SELECT * FROM petugas WHERE kd_petugas='$Kode'";
$myQry	= mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
$myData = mysql_fetch_array($myQry);

	// Data Variabel Temporary (sementara)
	$dataKode		= $myData['kd_petugas'];
	$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_petugas'];
	$dataUsername	= isset($_POST['txtUsername']) ? $_POST['txtUsername'] : $myData['username'];
	$dataTelepon	= isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : $myData['no_telepon'];
	$dataLevel		= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : $myData['level'];
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Ubah Data Petugas <small>&nbsp;</small></h2>
					<a href="?open=Petugas-Data"  class="btn btn-warning">Batal &amp; Kembali</a>
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
      <input name="txtUsername" type="text"  value="<?php echo $dataUsername; ?>" class="form-control has-feedback-left" />
      <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
	  </div>
	
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">		
	  <input name="txtPassword" type="password" class="form-control has-feedback-left"/>
      <input name="txtPassLama" type="hidden" value="<?php echo $myData['password']; ?>" />
      <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
	  </div>
	  
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">	
        <select name="cmbLevel" class="form-control ">
          <?php
		  $pilihan	= array("Petugas", "Admin");
          foreach ($pilihan as $nilai) {
            if ($dataLevel==$nilai) {
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