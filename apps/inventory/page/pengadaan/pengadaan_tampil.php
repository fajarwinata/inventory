<?php
//  Bulan Terpilih, dari URL dan Form
$bulan		= isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Baca dari URL, jika tidak ada diisi bulan sekarang
$dataBulan 	= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : $bulan; // Baca dari form Submit, jika tidak ada diisi dari $bulan

//  Tahun Terpilih, dari URL dan Form
$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

# Membuat Filter Bulan
if($dataBulan and $dataTahun) {
	if($dataBulan == "00") {
		// Jika tidak memilih bulan
		$filterSQL = "WHERE LEFT(tgl_pengadaan,4)='$dataTahun'";
	}
	else {
		// Jika memilih bulan dan tahun
		$filterSQL = "WHERE LEFT(tgl_pengadaan,4)='$dataTahun' AND MID(tgl_pengadaan,6,2)='$dataBulan'";
	}
}
else {
	$filterSQL = "";
}

?>
<h2>TAMPIL DATA PENGADAAN </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
 
	  <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
	  <select name="cmbBulan" class="form-control has-feedback-left">
      <?php
		// Daftar nama bulan
		$listBulan = array("00" => "....", "01" => "Januari", "02" => "Februari", "03" => "Maret",
					 "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
					 "08" => "Agustus", "09" => "September", "10" => "Oktober",
					 "11" => "November", "12" => "Desember");
		
		// Membuat daftar Bulan dari bulan 01 sampai 12, lalu menampilkan nama bulannya
		foreach($listBulan as $bulanke => $bulannm) {
			if ($bulanke == $dataBulan) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$bulanke' $cek>$bulannm</option>";
		}
	  ?>
        </select>
		<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
		</div>
		 <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
        <select name="cmbTahun" class="form-control has-feedback-left">
        <?php
		$thnSql = "SELECT MIN(LEFT(tgl_pengadaan,4)) As thn_kecil, MAX(LEFT(tgl_pengadaan,4)) As thn_besar FROM pengadaan";
		$thnQry	= mysql_query($thnSql, $koneksidb) or die ("Error".mysql_error());
		$thnData	= mysql_fetch_array($thnQry);
		
		// Tahun terbaca dalam tabel transaksi
		$thnKecil = $thnData['thn_kecil'];
		$thnBesar = $thnData['thn_besar'];
		
		// Menampilkan daftar Tahun, dari tahun terkecil sampai Terbesar (tahun sekarang)
		for($thn = $thnKecil; $thn <= $thnBesar; $thn++) {
			if ($thn == $dataTahun) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$thn' $cek> $thn</option>";
		}
	  ?>
      </select>
	  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
	  </div>

	   <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
	  <input name="btnTampil" type="submit" class="btn btn-success" value=" Tampilkan " />
	  </div>
	
</form>
 
<div class="card-box table-responsive">
<table id="datatable-buttons" class="table table-striped table-bordered">
  <thead>
    <th width="5px">No</th>
    <th width="20px">Tanggal</th>
    <th width="20px">No. Pengadaan</th>
    <th>Keterangan</th>
    <th>Supplier </th>
    <th width="5px">Qty Barang</th>
    <th width="50px">Total Biaya (Rp) </th>
    <th width="150px">Tools</th>
  </thead>
  <tbody>
  <?php
	# Perintah untuk menampilkan Semua Daftar Transaksi pengadaan
	$mySql = "SELECT pengadaan.*, supplier.nm_supplier FROM pengadaan 
				LEFT JOIN supplier ON pengadaan.kd_supplier=supplier.kd_supplier 
				$filterSQL
				ORDER BY pengadaan.no_pengadaan DESC ";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
		$nomor = 0;
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		# Membaca Kode pengadaan/ Nomor transaksi
		$Kode = $myData['no_pengadaan'];
		
		# Menghitung Total pengadaan (belanja) setiap nomor transaksi
		$my2Sql = "SELECT SUM(jumlah) AS total_barang,  
						  SUM(harga_beli * jumlah) AS total_belanja 
				   FROM pengadaan_item WHERE no_pengadaan='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
		
	?>
	
	<tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pengadaan']); ?></td>
    <td><?php echo $myData['no_pengadaan']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_belanja']); ?></td>
    <td width="40" align="center"><a href="?open=<?php echo md5('pengadaan-hapus')?>&&Kode=<?php echo $Kode; ?>" target="_self"
	onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENGADAAN INI ... ?')" class="btn btn-danger">Delete</a>
	<a href="cetak/pengadaan_cetak.php?Kode=<?php echo $Kode; ?>" target="_blank" class="btn btn-info">Cetak</a></td>
	</tr>
	
  <?php } ?>
  </tbody>
</table>
</div>
