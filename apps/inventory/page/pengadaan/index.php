
<table width="100%" class="table-common" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#F5F5F5"><a href="?open=Pengadaan-Baru" target="_self"><b>Pengadaan  Baru</b></a> | 
	 <a href="?open=Pengadaan-Tampil" target="_self"><b>Data Pengadaan </b></a> </td>
  </tr>
</table>

<?php 
# KONTROL MENU PROGRAM
if(isset($_GET['open'])) {
	// Jika mendapatkan variabel URL ?page
	switch($_GET['open']){				
		case 'Pengadaan-Baru' :
			if(!file_exists ("pengadaan_baru.php")) die ("Empty Main Page!"); 
			include "pengadaan_baru.php";	break;
		case 'Pengadaan-Tampil' : 
			if(!file_exists ("pengadaan_tampil.php")) die ("Empty Main Page!"); 
			include "pengadaan_tampil.php";	break;
		case 'Pengadaan-Hapus' : 
			if(!file_exists ("pengadaan_hapus.php")) die ("Empty Main Page!"); 
			include "pengadaan_hapus.php";	break;
	}
}
else {
	include "pengadaan_baru.php";
}
 ?>
