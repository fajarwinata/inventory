<?php
include_once "library/inc.seslogin.php";

// Variabel SQL
$filterSQL= "";

// Temporary Variabel form
$kodeSupplier	= isset($_GET['kodeSupplier']) ? $_GET['kodeSupplier'] : 'Semua'; // dari URL
$dataSupplier	= isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : $kodeSupplier; // dari Form

#  Tahun Terpilih
$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun


// Membuat filter SQL
if ($dataSupplier=="Semua") {
	// Semua Supplier, dan Tahun terpilih
	$filterSQL 	= "WHERE LEFT(pengadaan.tgl_pengadaan,4)='$dataTahun'";
}
else {
	// Supplier terpilih, dan Tahun Terpilih
	$filterSQL 	= " WHERE pengadaan.kd_supplier ='$dataSupplier' AND LEFT(pengadaan.tgl_pengadaan,4)='$dataTahun'";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
		// Buka file
		echo "<script>";
		echo "window.open('cetak/pengadaan_supplier.php?kodeSupplier=$dataSupplier&tahun=$dataTahun')";
		echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pengadaan $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$baris);
?>
<h2>LAPORAN DATA  PENGADAAN PER SUPPLIER </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="111"><strong> Supplier </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="770">
		  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	  <select name="cmbSupplier" class="form-control has-feedback-left">
        <option value="Semua"> ... </option>
        <?php
	  $tampilSql = "SELECT * FROM supplier ORDER BY kd_supplier";
	  $tampilQry = mysql_query($tampilSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($tampilData = mysql_fetch_array($tampilQry)) {
		if ($tampilData['kd_supplier'] == $dataSupplier) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$tampilData[kd_supplier]' $cek> $tampilData[nm_supplier]</option>";
	  }
	  ?>
      </select>
			  <span class="fa fa-puzzle-piece form-control-feedback left" aria-hidden="true"></span>
		  </div>
	  </td>
    </tr>
    <tr>
      <td><strong>Periode Tahun </strong></td>
      <td><strong>:</strong></td>
      <td>
		  <div class="col-md-3 col-sm-3 col-xs-6 form-group has-feedback">
		  <select name="cmbTahun" class="form-control has-feedback-left">
          <?php
		# Baca tahun terendah(kecil), dan tahun tertinggi(besar) di tabel Transaksi
		$thnSql = "SELECT MIN(LEFT(tgl_pengadaan,4)) As tahun_kecil, MAX(LEFT(tgl_pengadaan,4)) As tahun_besar FROM pengadaan";
		$thnQry	= mysql_query($thnSql, $koneksidb) or die ("Error".mysql_error());
		$thnRow	= mysql_fetch_array($thnQry);
		
		// Membaca tahun
		$thnKecil = $thnRow['tahun_kecil'];
		$thnBesar = $thnRow['tahun_besar'];
		
		// Menampilkan daftar Tahun, dari tahun terkecil sampai Terbesar (tahun sekarang)
		for($thn= $thnKecil; $thn <= $thnBesar; $thn++) {
			if ($thn == $dataTahun) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$thn' $cek>$thn</option>";
		}
	  ?>
        </select>
			  <span class="fa fa-puzzle-piece form-control-feedback left" aria-hidden="true"></span>
		  </div>
          <input name="btnTampil" type="submit" value=" Tampilkan " class="btn btn-info"/></td>
    </tr>
  </table>
</form>

<div class="card-box table-responsive">
	<table id="datatable-buttons" class="table table-striped table-bordered">
		<thead>
  
  <tr>
    <th width="22" align="center" ><strong>No</strong></th>
    <th width="80" ><strong>Tanggal</strong></th>
    <th width="120" ><strong>No. Pengadaan</strong></th>
    <th width="372" ><strong>Keterangan</strong></th>
    <th width="20" align="right" ><strong>Total Barang</strong></th>
    <th width="130" align="right" ><strong>Total Belanja (Rp) </strong></th>
    <th width="40" align="center" ><strong>Tools</strong></th>
  </tr>
  </thead>
		<tbody>
  <?php
	# Skrip untuk menampilkan Data Trans Pengadaan, dilengkapi informasi Supplier dari tabel relasi
	$mySql = "SELECT pengadaan.*, supplier.nm_supplier FROM pengadaan 
				LEFT JOIN supplier ON pengadaan.kd_supplier=supplier.kd_supplier 
				$filterSQL
				ORDER BY pengadaan.no_pengadaan DESC LIMIT $hal, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = $hal; 
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
		
		// gradasi warna

	?>
  <tr >
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pengadaan']); ?></td>
    <td><?php echo $myData['no_pengadaan']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_belanja']); ?></td>
    <td align="center"><a href="cetak/pengadaan_cetak.php?Kode=<?php echo $Kode; ?>" target="_blank" class="btn btn-info">Cetak</a></td>
  </tr>
  <?php } ?>
		</tbody>
		</table>
	</div>
<table width="100%">
  <tr>
    <td>
		<a href="cetak/pengadaan_supplier.php?kodeSupplier=<?php echo $dataSupplier; ?>&tahun=<?php echo $dataTahun; ?>" target="_blank" class="btn btn-large btn-primary">
			<i class="fa fa-print"></i>&nbsp;&nbsp; CETAK DATA
		</a>
		<a href="?open=Laporan-Cetak" class="btn btn-large btn-warning">
			<i class="fa fa-bars"></i>&nbsp;&nbsp; KEMBALI KE MENU
		</a>
	</td>
    <td><b>Jumlah Data :</b> <?php echo $jml; ?></td>
  </tr>
</table>
<br />