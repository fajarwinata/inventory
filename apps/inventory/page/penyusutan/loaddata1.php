<?php  
	include "../../library/inc.connection.php";
	$kd_barang = $_POST['kd_barang'];
	//echo $kd_barang;

	$mySql = "SELECT `harga_beli` FROM `pengadaan_item` WHERE kd_barang= '$kd_barang'";
	  $myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($myData = mysql_fetch_array($myQry)) {
	  		//return json_encode($myData);
	  		$harga_beli=$myData['harga_beli'] ;
	  		
	  }

	$mySql1 = "SELECT `kd_inventaris` FROM `barang_inventaris` WHERE kd_barang= '$kd_barang'";
	  $myQry1 = mysql_query($mySql1, $koneksidb) or die ("Gagal Query".mysql_error());
	 
	  echo "<select name='barcode' class='form-control has-feedback-left'>"; $value=0;
	  while ($myData1 = mysql_fetch_array($myQry1)) {
	  		$value++;
	  		//return json_encode($myData);
	  		$kd_inventaris=$myData1['kd_inventaris'] ;
	  		echo "<option value=".$kd_inventaris.">".$kd_inventaris."</option>";
	  }
	  echo "</select>";
	  
?>
