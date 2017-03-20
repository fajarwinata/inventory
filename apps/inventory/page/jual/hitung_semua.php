<div class="card-box table-responsive">
	<table id="datatable-buttons" class="table table-striped table-bordered">

  <thead>
  <tr>
    <th>No</th>
    <th>Departemen</th>
    <th>Nama Aset</th>
    <th>Barcode</th>
    <th>Tanggal Perolehan</th>
    <th>Tanggal Terjual</th>
    <th>Jumlah<br>Unit</th>
    <th>Harga<br>Per Unit</th>
    <th>Harga <br>Perolehan</th>

    <th>Nilai Buku</th>

    <th>Ruangan</th>
  </tr>
  </thead>

 <tbody>
<?php  
	// $kd_barang = $_POST['cmbBarang'];
	// $harga_beli= $_POST['txtHargaBeli'];
	// $jumlah= $_POST['txtJumlah'];
	// $barcode= $_POST['barcode'];
	$init= "SELECT * FROM `pengadaan_item`";
	$res = mysql_query($init, $koneksidb) or die ("Gagal Query".mysql_error());
		$no=0;
	  while ($val = mysql_fetch_array($res)) {


		  $init2= mysql_query("SELECT * FROM `barang_inventaris` WHERE status_barang='Terjual' AND kd_barang='$val[kd_barang]'");
			while ($val2 = mysql_fetch_array($init2)) {

				$no++;
				$no_pengadaan = $val['no_pengadaan'];
	  		$query= "SELECT `tgl_pengadaan` FROM `pengadaan` WHERE no_pengadaan= '$no_pengadaan'";
			$myQry1 = mysql_query($query, $koneksidb) or die ("Gagal Query".mysql_error());
	  			while ($myData1 = mysql_fetch_array($myQry1)) {
				$originalDate= $myData1['tgl_pengadaan'];
			  $tgl_pengadaan = date("d F Y", strtotime($originalDate));
	  		}

				$query2= "SELECT `tgl_jual` FROM `jual` WHERE kd_inven= '$val2[kd_inventaris]'";
				$myQry11 = mysql_query($query2, $koneksidb) or die ("Gagal Query".mysql_error());
				while ($myData1 = mysql_fetch_array($myQry11)) {
					$originalDate1= $myData1['tgl_jual'];
					$tgl_jual = date("d F Y", strtotime($originalDate1));
				}

	  		$kd_barang= $val['kd_barang'];
	  		$qry= "SELECT `nm_barang` FROM `barang` WHERE kd_barang= '$kd_barang' LIMIT 1";
	  		$result = mysql_query($qry, $koneksidb) or die ("Gagal Query".mysql_error());
	  			while ($hasil = mysql_fetch_array($result)) {
	  				$nm_barang=$hasil['nm_barang'];
	  			}

	  		$mySql1 = "SELECT `kd_inventaris` FROM `barang_inventaris` WHERE kd_barang= '$kd_barang' LIMIT 1";
			$myQry1 = mysql_query($mySql1, $koneksidb) or die ("Gagal Query".mysql_error());
	 		 while ($myData1 = mysql_fetch_array($myQry1)) {
	 	 		$barcode=$myData1['kd_inventaris'] ;

		 	 		$query1 = "SELECT `no_penempatan` FROM `penempatan_item` WHERE kd_inventaris= '$barcode'";
					$res1 = mysql_query($query1, $koneksidb) or die ("Gagal Query".mysql_error());
					  while ($val1 = mysql_fetch_array($res1)) {
					  		$no_penempatan= $val1['no_penempatan'];

					  }
					if (mysql_num_rows($res1) != 0) {

					$query2 = "SELECT `kd_lokasi` FROM `penempatan` WHERE no_penempatan= '$no_penempatan'";
					$res2 = mysql_query($query2, $koneksidb) or die ("Gagal Query".mysql_error());
					  while ($val2 = mysql_fetch_array($res2)) {
					  		$kd_lokasi= $val2['kd_lokasi'];

					  }

					$query3 = "SELECT `kd_departemen`,`nm_lokasi` FROM `lokasi` WHERE kd_lokasi= '$kd_lokasi'";
					$res3 = mysql_query($query3, $koneksidb) or die ("Gagal Query".mysql_error());
					  while ($val3 = mysql_fetch_array($res3)) {
					  		$kd_departemen= $val3['kd_departemen'];
					  		$nm_lokasi= $val3['nm_lokasi'];
					  }

					$query4 = "SELECT `nm_departemen` FROM `departemen` WHERE kd_departemen= '$kd_departemen'";
					$res4 = mysql_query($query4, $koneksidb) or die ("Gagal Query".mysql_error());
					  while ($val4 = mysql_fetch_array($res4)) {
					  		$nm_departemen= $val4['nm_departemen'];
					  }
					}else{
						$nm_departemen = "Barang belum ditempatkan";
						$nm_lokasi = "Barang belum ditempatkan";
					}

	 		 }

	  		//$deskripsi= $val['deskripsi'];
	  		$jumlah= $val['jumlah'];
	  		$harga_beli= $val['harga_beli'];
	  		//print_r($val);

	  		//KALKULASI
				  setlocale(LC_TIME, 'nl_NL');
				  // if ($_POST['value']==null) {
				  // 	$persen1=$_POST['value'];
				  // 	$persen=$persen1/100;
				  // }else 
				  $persen=100;
				  
				  $mutasi_masuk=0;	
				  $mutasi_keluar=0;
				  $harga_total= $harga_beli;
				  $harga_perolehan = $harga_total + $mutasi_masuk - $mutasi_keluar;
				  $penystpertahun= $harga_total * $persen;
				  $penystperbulan= $penystpertahun / 12;



				  /*hitung_bulan
				  	$d1 = strtotime($originalDate);
					$d2 = strtotime("2016-02-01");
					$min_date = min($d1, $d2);
					$max_date = max($d1, $d2);
					$bulan = 0;

					while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
					    $bulan++;
					} */
				  setlocale(LC_TIME, 'id_ID.utf8','ind');
				  $date = new DateTime($tgl_pengadaan);
				  $date2 = new DateTime($tgl_jual);
				  $indate= strftime("%d %B %Y", $date->getTimestamp());
				  $indate2= strftime("%d %B %Y", $date2->getTimestamp());
				  //$year=strftime("%Y", $date->getTimestamp());
				  //$month=strftime("%m", $date->getTimestamp());
				  $yearnow= date("Y");
				  //$hit= $yearnow-$year;

		  		  $harga_buku4 = $harga_total-$harga_total;

				  
	  ?>
	  
	  <tr>
		    <td><?php echo $no; ?></td>
		    <td><?php echo $nm_departemen; ?></td>
		    <td><?php echo $nm_barang; ?></td>
		    <td><?php echo $barcode; ?></td>
		    <td><?php echo $indate;  ?></td>
		    <td><?php echo $indate2;  ?></td>
		    <td><?php echo $jumlah; ?></td>
		    <td><?php echo number_format($harga_beli, 0, ' ', '.'); ?></td>
		    <td><?php echo number_format($harga_total, 0, ' ', '.');; ?></td>

		    <td><?php echo number_format($harga_buku4, 0, ' ', '.'); ?></td>
		     
		    <td><?php echo $nm_lokasi; ?></td>
     </tr>
   
	
<?php
} }
?>
  </tbody>
</table>
</div>

