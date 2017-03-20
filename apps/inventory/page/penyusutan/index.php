<?php 
if(isset($_POST['btnSimpan']) | isset($_POST['btnTambah'])){

$kd_barang = $_POST['cmbBarang'];
$harga_beli= $_POST['txtHargaBeli'];
$jumlah= $_POST['txtJumlah'];
$barcode= $_POST['barcode'];


$query = "SELECT `no_penempatan` FROM `penempatan_item` WHERE kd_inventaris= '$barcode'";
$res = mysql_query($query, $koneksidb) or die ("Gagal Query".mysql_error());
while ($val = mysql_fetch_array($res)) {
	$no_penempatan= $val['no_penempatan'];
}
if (!empty($no_penempatan)) {

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

//echo $jumlah;

$mySql = "SELECT `deskripsi`,`no_pengadaan` FROM `pengadaan_item` WHERE kd_barang= '$kd_barang'";
$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
while ($myData = mysql_fetch_array($myQry)) {
	$no_pengadaan= $myData['no_pengadaan'];
	$deskripsi= $myData['deskripsi'];
}
$query= "SELECT `tgl_pengadaan` FROM `pengadaan` WHERE no_pengadaan= '$no_pengadaan'";
$myQry1 = mysql_query($query, $koneksidb) or die ("Gagal Query".mysql_error());
while ($myData1 = mysql_fetch_array($myQry1)) {
	$originalDate= $myData1['tgl_pengadaan'];
	$tgl_pengadaan = date("d-F-Y", strtotime($originalDate));
	// $bulan= date("n", strtotime($originalDate));
	// $tahun= strtotime($originalDate)-;
}

//KALKULASI
setlocale(LC_TIME, 'nl_NL');
$mutasi_masuk=0;
$mutasi_keluar=0;
$harga_total= $harga_beli * $jumlah;
$harga_perolehan = $harga_total + $mutasi_masuk - $mutasi_keluar;

//hitung_bulan
$d1 = strtotime($originalDate);
$d2 = strtotime("2016-02-01");
$min_date = min($d1, $d2);
$max_date = max($d1, $d2);
$bulan = 0;

while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
	$bulan++;
}
$akumulasi = ($harga_total/48)*$bulan;
$harga_buku = $harga_total- $akumulasi;
 
$peny_2016 = ($harga_perolehan/48)*12;
$akumulasi2 = $akumulasi + $peny_2016;
$harga_buku2 = $harga_perolehan-$akumulasi2;

$peny_2017= ($harga_perolehan/48)*12;
$akumulasi3 = $akumulasi2+$peny_2017;
$harga_buku3 = $harga_perolehan-$akumulasi3;

$peny_2018= ($harga_perolehan/48)*12;
$akumulasi4 = $akumulasi3+$peny_2018;
$harga_buku4 = $harga_perolehan-$akumulasi4;
} 
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"  name="form1">
<table width="900" cellspacing="1" class="table-list" style="margin-top:0px;">
	
	<tr>
	  <td><strong>Nama Barang </strong></td>
	  <td><strong>:</strong></td>
	  <td><b>
	  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	    <select id="pilih" name="cmbBarang" onChange="select(this)" class="form-control has-feedback-left">
          <option value="Kosong">....</option>
          <?php
	  $mySql = "SELECT `kd_barang`,`deskripsi`,`harga_beli` FROM `pengadaan_item` WHERE 1 ORDER BY kd_barang ASC";
	  $myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($myData = mysql_fetch_array($myQry)) {
	 
	  	echo "<option value='$myData[kd_barang]' > [ $myData[kd_barang] ] $myData[deskripsi]</option>";
	  }
	  ?>
        </select>
        <span class="fa fa-briefcase form-control-feedback left" aria-hidden="true"></span>
        </div>
	  </b><a href="?page=Pencarian-Barang" target="_blank"></a></td>
    </tr>
	<tr>
		<td><strong>Barcode Barang</strong></td>
		<td><strong>:</strong></td>
		<td><b>
				<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	    		<input id="barcodesemu" name="barcode"  class="form-control has-feedback-left" value=""/>
	    		<span class="fa fa-barcode form-control-feedback left" aria-hidden="true"></span>
	    		<div id="barcode"></div>
	    		</div>
	    	</b>
	    </td>
	   
	</tr> 
	<tr>
	  <td><strong>Harga Barang/ Beli (Rp.) </strong></td>
	  <td><strong>:</strong></td>
	  <td><b>
	    <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
	    <input class="form-control has-feedback" id="hargabarang" name="txtHargaBeli" maxlength="12" value="" required/>
	    <span class="fa fa-money form-control-feedback right" aria-hidden="true"></span>
	    </div>
	    <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
          <input class="form-control has-feedback" name="txtJumlah" maxlength="4" value="1" 
	  		 onblur="if (value == '') {value = '1'}" 
      		 onfocus="if (value == '1') {value =''}"/>
      	<span class="fa fa-sort-numeric-asc form-control-feedback right" aria-hidden="true"></span>	 
      	</div>
         
      </b></td>
    </tr>
     <SCRIPT language="JavaScript">
	  	function select(a){
	  		var e = document.getElementById("pilih");
			var kd_barang = e.options[e.selectedIndex].value
			$.ajax({
				type: 'post',
				url: 'page/penyusutan/loaddata.php',
				data: {
					kd_barang:kd_barang,
				},
				success: function (response) {
			console.log(response)
			//document.getElementById("harga//").innerHTML=response
			document.getElementById("hargabarang").value=response

			}
		   });
			
			$.ajax({
				type: 'post',
				url: 'page/penyusutan/loaddata1.php',
				data: {
					kd_barang:kd_barang,
				},
				success: function (response) {
			console.log(response)
			document.getElementById("barcodesemu").style.display="none"
			document.getElementById("barcode").innerHTML=response

			}
		   });
	  	}
	  </SCRIPT> 
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input name="btnSimpan" type="submit" class="btn btn-success" style="cursor:pointer;" value=" HITUNG " /></td>
    </tr>
</table>
</form>
<?php if(isset($_POST['btnSimpan']) | isset($_POST['btnTambah'])){?>

<div class="card-box table-responsive">
<table id="datatable-buttons" class="table table-striped table-bordered">
<thead>
  <tr>
    <th rowspan="2">-</th>
    <th rowspan="2">Departemen</th>
    <th rowspan="2">Nama Aset</th>
    <th rowspan="2" >Barcode</th>
    <th rowspan="2" >Tanggal Perolehan</th>
    <th rowspan="2" >Jml Unit</th>
    <th rowspan="2" >Harga Per Unit</th>
    <th rowspan="2" >Harga Perolehan s/d 2015</th>
    <th colspan="2" >Mutasi 2016</th>
    <th rowspan="2">Harga Perolehan s/d 2016</th>
    <th rowspan="2">% Pe-<br>nyu-<br>sut-<br>an</th>
    <th rowspan="2">Akumulasi Penyusutan s/d th 2015</th>
    <th rowspan="2">Nilai Buku Per 31 Des 2015</th>
  </tr>
  <tr>
    <td width="10">Bertambah (brg baru)</td>
    <td width="10">Berkurang (rusak/dijual)</td>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td></td>
    <td><?php echo $nm_departemen; ?></td>
    <td><?php echo $deskripsi; ?></td>
    <td><?php echo $barcode; ?></td>
    <td><?php echo $tgl_pengadaan; ?></td>
    <td><?php echo $jumlah; ?></td>
    <td><?php echo number_format($harga_beli, 0, ' ', '.'); ?></td>
    <td><?php echo number_format($harga_total, 0, ' ', '.');; ?></td>
    <td>0</td>
    <td>0</td>
    <td><?php echo number_format($harga_perolehan, 0, ' ', '.');; ?></td>
    <td>25%</td>
    <td><?php echo number_format(round($akumulasi), 0, ' ', '.');; ?></td>
    <td><?php echo number_format($harga_buku, 0, ' ', '.');; ?></td>
  </tr>
  <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
  <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
  <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
  <tr>    
  	<td></td>
    <td>Penyusutan<br>Tahun 2016</td>
    <td>Akumulasi<br>Penyusutan<br>s/d th 2016</td>
    <td>Nilai Buku<br>Per 31 Des 2016</td>

    <td>Penyusutan<br>Tahun 2017</td>
    <td>Akumulasi<br>Penyusutan<br>s/d th 2017</td>
    <td>Nilai Buku<br>Per 31 Des 2017</td>

    <td>Penyusutan<br>Tahun 2018</td>
    <td>Akumulasi<br>Penyusutan<br>s/d th 2018</td>
    <td>Nilai Buku<br>Per 31 Des 2018</td>
    <td>Ruangan</td>
    <td>Status</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td></td>
    <td><?php echo number_format($peny_2016, 0, ' ', '.');; ?></td>
    <td><?php echo number_format($akumulasi2, 0, ' ', '.');; ?></td>
    <td><?php echo number_format($harga_buku2, 0, ' ', '.');; ?></td>

    <td><?php echo number_format($peny_2017, 0, ' ', '.');; ?> </td>
    <td><?php echo number_format($akumulasi3, 0, ' ', '.');; ?> </td>
    <td><?php echo number_format($harga_buku3, 0, ' ', '.');; ?> </td>

    <td><?php echo number_format($peny_2018, 0, ' ', '.');; ?></td>
    <td><?php echo number_format($akumulasi4, 0, ' ', '.');; ?></td>
    <td><?php echo number_format($harga_buku4, 0, ' ', '.');; ?></td>

    <td><?php echo $nm_lokasi; ?></td>
    <td><?php echo $status_barang; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </tbody>
</table>
</div>
	<SCRIPT language="JavaScript">
	  	function pilih(){
	  		var e = document.getElementById("pilih");
			var selected = e.options[e.selectedIndex].value
			//console.log(selected)
			for (var i = 0; i < selected; i++) {
				console.log(selected)
			}
	  	}
	  </SCRIPT> 
<?php } ?>	  
