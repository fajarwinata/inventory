<?php 
# LOGIN dari file login.php
if(isset($_POST['btnLogin'])){
	# Baca variabel form
	$txtUser 		= $_POST['txtUser'];
	$txtUser 		= str_replace("'","&acute;",$txtUser);
	
	$txtPassword	= $_POST['txtPassword'];
	$txtPassword	= str_replace("'","&acute;",$txtPassword);
	
	$cmbLevel		= $_POST['cmbLevel'];
	
	# Validasi form
	$pesanError = array();
	if ( trim($txtUser)=="") {
		$pesanError[] = "Data <b> Username </b>  tidak boleh kosong !";		
	}
	if (trim($txtPassword)=="") {
		$pesanError[] = "Data <b> Password </b> tidak boleh kosong !";		
	}
	if (trim($cmbLevel)=="Kosong") {
		$pesanError[] = "Data <b>Level</b> belum dipilih !";		
	}
	
	
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		// Tampilkan lagi form login
		include "page/login.php";
		?>
	<div class="container">	
    <section class="notif notif-warn">
      <h6 class="notif-title">Warning!</h6>
      <p><?php
	  $noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
	  ?>
	  </p>
      
    </section>
	</div>
		<?php
				
		
	}
	else {
		# LOGIN CEK KE TABEL USER LOGIN
		$mySql = "SELECT * FROM petugas WHERE username='$txtUser' AND password='".md5($txtPassword)."' AND level='$cmbLevel'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Query Salah : ".mysql_error());
		$myData= mysql_fetch_array($myQry);
		
		# JIKA LOGIN SUKSES
		if(mysql_num_rows($myQry) >=1) {
			$_SESSION['SES_LOGIN'] = $myData['kd_petugas']; 
			$_SESSION['SES_USER'] = $myData['username']; 
			
			// Jika yang login Administrator
			if($cmbLevel=="Admin") {
				$_SESSION['SES_ADMIN'] = "Admin";
				$_SESSION['SES_NAMA'] = $myData['nm_petugas'];
			}
			
			// Jika yang login Petugas
			if($cmbLevel=="Petugas") {
				$_SESSION['SES_PETUGAS'] = "Petugas";
				$_SESSION['SES_NAMA'] = $myData['nm_petugas'];
			}
			
			// Refresh
			echo "<meta http-equiv='refresh' content='0; url=?open=Halaman-Utama'>";
		}
		else {
			 echo "Login Anda bukan $cmbLevel ...";
			 header ("location:?open=error");
			 			 
		}
	}
} // End POST
?>
 
