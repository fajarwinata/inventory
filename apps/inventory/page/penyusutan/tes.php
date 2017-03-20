<?php 
	$dec = $_POST['value'];
	$kd_barang= $_POST['kd_barang'];
 ?>
 <?php  

	include "../library/inc.connection.php";
	// $kd_barang = $_POST['cmbBarang'];
	// $harga_beli= $_POST['txtHargaBeli'];
	// $jumlah= $_POST['txtJumlah'];
	// $barcode= $_POST['barcode'];
	$init= "SELECT * FROM `pengadaan_item` WHERE kd_barang='$kd_barang' ORDER BY `kd_barang` ASC";
	$res = mysql_query($init, $koneksidb) or die ("Gagal Query".mysql_error());
		$no=0;
	  while ($val = mysql_fetch_array($res)) {
	  		$no++;
	  		$no_pengadaan = $val['no_pengadaan'];
	  		$query= "SELECT `tgl_pengadaan` FROM `pengadaan` WHERE no_pengadaan= '$no_pengadaan'";
			$myQry1 = mysql_query($query, $koneksidb) or die ("Gagal Query".mysql_error());
	  			while ($myData1 = mysql_fetch_array($myQry1)) {
	  					$originalDate= $myData1['tgl_pengadaan'];
	  					$tgl_pengadaan = date("d F Y", strtotime($originalDate));
	  		// $bulan= date("n", strtotime($originalDate));
	  		// $tahun= strtotime($originalDate)-;
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
					$query5 = "SELECT `status_barang` FROM `barang_inventaris` WHERE kd_inventaris= '$barcode'";
					$res5 = mysql_query($query5, $koneksidb) or die ("Gagal Query".mysql_error());
	  					while ($val5 = mysql_fetch_array($res5)) {
	  				$status_barang= $val5['status_barang'];
	  				}
	 		 }

	  		$deskripsi= $val['deskripsi'];
	  		$jumlah= $val['jumlah'];
	  		$harga_beli= $val['harga_beli'];
	  		//print_r($val);

	  		//KALKULASI
				  setlocale(LC_TIME, 'nl_NL');
				  // if ($_POST['value']==null) {
				  // 	$persen1=$_POST['value'];
				  // 	$persen=$persen1/100;
				  // }else 
			
				  $persen=$dec;	
				  $mutasi_masuk=0;	
				  $mutasi_keluar=0;
				  $harga_total= $harga_beli * $jumlah;
				  $harga_perolehan = $harga_total + $mutasi_masuk - $mutasi_keluar;
				  $penystpertahun= $harga_total * $persen;
				  $penystperbulan= $penystpertahun / 12;

				  //hitung_bulan
				  	$d1 = strtotime($originalDate);
					$d2 = strtotime("2016-02-01");
					$min_date = min($d1, $d2);
					$max_date = max($d1, $d2);
					$bulan = 0;

					while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
					    $bulan++;
					}
				  setlocale(LC_TIME, 'id_ID.utf8','ind');
				  $date = new DateTime($tgl_pengadaan);
				  $indate= strftime("%d %B %Y", $date->getTimestamp());
				  $year=strftime("%Y", $date->getTimestamp());
				  $month=strftime("%m", $date->getTimestamp());
				  $yearnow= 2016;
				  $hit= $yearnow-$year;

				  if ($hit==5) {
				  		  $peny_2015= $penystperbulan*48;
						  $akumulasi = ($harga_total/48)*$bulan;
						  $harga_buku =0;
						  
						  $peny_2016 = 0;
						  $akumulasi2 = $peny_2015 + $peny_2016;
						  $harga_buku2 = 0;

						  $peny_2017= 0;
						  $akumulasi3 = $peny_2017 + $akumulasi2;
						  $harga_buku3 = 0;

						  $peny_2018= 0;
						  $akumulasi4 = $peny_2018 + $akumulasi3;
						  $harga_buku4 = 0;

				  }elseif ($hit==4) {
				  		  $peny_2015= $penystperbulan*$bulan;
						  $akumulasi = ($harga_total/48)*$bulan;
						  $harga_buku = $harga_total- $peny_2015;
						  
						  $sisabulan= $month - 1;
						  $peny_2016 = ($penystperbulan)*$sisabulan;
						  $akumulasi2 = ($penystperbulan)*48;
						  $harga_buku2 = $harga_total- $akumulasi2;

						  $peny_2017= 0;
						  $akumulasi3 = $peny_2017 + $akumulasi2;
						  $harga_buku3 = 0;

						  $peny_2018= 0;
						  $akumulasi4 = $peny_2018 + $akumulasi3;
						  $harga_buku4 = 0;
				  
				  }elseif ($hit==3){
				  		  $peny_2015= $penystperbulan*$bulan;
						  $akumulasi = ($harga_total/48)*$bulan;
						  $harga_buku = $harga_total- $peny_2015;
						  
						  $peny_2016 = ($penystperbulan)*12;
						  $akumulasi2 = $peny_2015 + $peny_2016;
						  $harga_buku2 = $harga_total- $akumulasi2;

						  $sisabulan= $month - 1;
						  $peny_2017= ($penystperbulan)*$sisabulan;
						  $akumulasi3 = ($penystperbulan)*48;
						  $harga_buku3 = $harga_total- $akumulasi3;

						  $peny_2018= 0;
						  $akumulasi4 = $peny_2018 + $akumulasi3;
						  $harga_buku4 = 0;

				  }elseif($hit==2){
				  		  $peny_2015= $penystperbulan*$bulan;
						  $akumulasi = ($harga_total/48)*$bulan;
						  $harga_buku = $harga_total- $peny_2015;
						  
						  $peny_2016 = ($penystperbulan)*12;
						  $akumulasi2 = $peny_2015 + $peny_2016;
						  $harga_buku2 = $harga_total- $akumulasi2;

						  $peny_2017= ($penystperbulan)*12;
						  $akumulasi3 = $peny_2017 + $akumulasi2;
						  $harga_buku3 = $harga_total- $akumulasi3;

						  $sisabulan= $month - 1;
						  $peny_2018= ($penystperbulan)*$sisabulan;
						  $akumulasi4 = ($penystperbulan)*48;
						  $harga_buku4 = $harga_total- $akumulasi4;

				  }else{
						  $peny_2015= $penystperbulan*$bulan;
						  $akumulasi = ($harga_total/48)*$bulan;
						  $harga_buku = $harga_total- $peny_2015;
						  
						  $peny_2016 = ($penystperbulan)*12;
						  $akumulasi2 = $peny_2015 + $peny_2016;
						  $harga_buku2 = $harga_total- $akumulasi2;

						  $peny_2017= ($penystperbulan)*12;
						  $akumulasi3 = $peny_2017 + $akumulasi2;
						  $harga_buku3 = $harga_total- $akumulasi3;

						  $peny_2018= ($penystperbulan)*12;
						  $akumulasi4 = $peny_2018 + $akumulasi3;
						  $harga_buku4 = $harga_total- $akumulasi4;
				}
				  
	  ?>
 	 <tr name="coba">
		    <td class="tg-yw4l"><?php echo $no; ?></td>
		    <td class="tg-yw4l"><?php echo $nm_departemen; ?></td>
		    <td class="tg-yw4l"><?php echo $nm_barang; ?></td>
		    <td class="tg-yw4l"><?php echo $barcode; ?></td>
		    <td class="tg-yw4l"><?php echo $indate;  ?></td>
		    <td class="tg-yw4l"><?php echo $jumlah; ?></td>
		    <td class="tg-yw4l"><?php echo number_format($harga_beli, 0, ' ', '.'); ?></td>
		    <td class="tg-yw4l"><?php echo number_format($harga_total, 0, ' ', '.');; ?></td>
		    <td id="persen" name="persen" class="tg-yw4l">25%<br><button onclick="myFunction(<?php echo $no-1;?>,'<?php echo $kd_barang;?>')" style="font-size: 8pt;">Ubah%</button></td>

		    <td class="tg-yw4l"><?php echo number_format($penystpertahun, 0, ' ', '.'); ?></td>
		    <td class="tg-yw4l"><?php echo number_format($penystperbulan, 0, ' ', '.'); ?></td>

		    <td class="tg-yw4l" style="background: #b3b3ae;"><?php echo number_format($peny_2015, 0, ' ', '.'); ?></td>
		    <td class="tg-yw4l" style="background: #b3b3ae;"><?php echo number_format($harga_buku, 0, ' ', '.'); ?></td>

		    <td class="tg-yw4l" style="background: #d9e8fb;"><?php echo number_format($peny_2016, 0, ' ', '.'); ?></td>
		    <td class="tg-yw4l" style="background: #d9e8fb;"><?php echo number_format($akumulasi2, 0, ' ', '.'); ?></td>
		    <td class="tg-yw4l" style="background: #d9e8fb;"><?php echo number_format($harga_buku2, 0, ' ', '.'); ?></td>

		    <td class="tg-yw4l" style="background: #46d46b;"><?php echo number_format($peny_2017, 0, ' ', '.'); ?></td>
		    <td class="tg-yw4l" style="background: #46d46b;"><?php echo number_format($akumulasi3, 0, ' ', '.'); ?></td>
		    <td class="tg-yw4l" style="background: #46d46b;"><?php echo number_format($harga_buku3, 0, ' ', '.'); ?></td>

		    <td class="tg-yw4l" style="background: #b3bd10;"><?php echo number_format($peny_2018, 0, ' ', '.'); ?></td>
		    <td class="tg-yw4l" style="background: #b3bd10;"><?php echo number_format($akumulasi4, 0, ' ', '.'); ?></td>
		    <td class="tg-yw4l" style="background: #b3bd10;"><?php echo number_format($harga_buku4, 0, ' ', '.'); ?></td>
		     
		    <td class="tg-yw4l"><?php echo $nm_lokasi; ?></td>
		    <td class="tg-yw4l"><?php echo $status_barang; ?></td>
     </tr>
     <?php
}
?>
 