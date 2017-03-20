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
		$filterSQL = "WHERE LEFT(tgl_mutasi,4)='$dataTahun'";
	}
	else {
		// Jika memilih bulan dan tahun
		$filterSQL = "WHERE LEFT(tgl_mutasi,4)='$dataTahun' AND MID(tgl_mutasi,6,2)='$dataBulan'";
	}
}
else {
	$filterSQL = "";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris	= 50;
$hal	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM mutasi $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$baris);
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    <tr>
      <td colspan="3" ><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="138"><strong>Bulan &amp; Tahun </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="743">
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
		$thnSql = "SELECT MIN(LEFT(tgl_penempatan,4)) As thn_kecil, MAX(LEFT(tgl_penempatan,4)) As thn_besar FROM penempatan";
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
		</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnTampil" type="submit" class="btn btn-success" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>

<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
<div class="card-box table-responsive">
<table id="datatable-buttons" class="table table-striped table-bordered">
<thead>
  <tr>
    <th width="5px" align="center" ><strong>No</strong></th>
    <th width="80" ><strong>Tanggal</strong></th>
    <th width="110" ><strong>No. Mutasi</strong></th>
    <th width="70px" ><strong>No. Penempatan </strong></th>
    <th width="70px" ><strong>Lokasi Baru </strong></th>
    <th width="193" ><strong>Keterangan</strong></th>
    <th width="80" align="right" ><strong>Qty Barang</strong></th>
    <th width="180px" ><strong>Tools</strong></th>
  </tr>
  </thead>
  <tbody>
  <?php
	// Srkip menampilkan data Mutasi
	$mySql = "SELECT * FROM mutasi $filterSQL ORDER BY  no_mutasi DESC ";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		# Membaca Kode mutasi/ Nomor transaksi
		$Kode 	= $myData['no_mutasi'];

		// Membaca informasi penempatan baru
		$my2Sql	= "SELECT mutasi_tujuan.*, lokasi.nm_lokasi FROM mutasi_tujuan 
					LEFT JOIN penempatan ON mutasi_tujuan.no_penempatan = penempatan.no_penempatan
					LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
					WHERE mutasi_tujuan.no_mutasi = '$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry); 
		
		// Menghitung Total barang yang dimutasi 
		$my3Sql = "SELECT COUNT(*) AS total_barang FROM mutasi_asal WHERE no_mutasi='$Kode'";
		$my3Qry = mysql_query($my3Sql, $koneksidb)  or die ("Query 3 salah : ".mysql_error());
		$my3Data = mysql_fetch_array($my3Qry);
		
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_mutasi']); ?></td>
    <td><?php echo $myData['no_mutasi']; ?></td>
    <td><?php echo $my2Data['no_penempatan']; ?></td>
    <td><?php echo $my2Data['nm_lokasi']; ?></td>
    <td><?php echo $my2Data['keterangan']; ?></td>
    <td align="right"><?php echo format_angka($my3Data['total_barang']); ?></td>
    <td width="42" align="center"><a href="?open=<?php echo md5('mutasi-hapus')?>&&Kode=<?php echo $Kode; ?>" target="_self"
	onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA MUTASI INI ... ?')" class="btn btn-danger">Hapus</a>
	<a href="cetak/mutasi_cetak.php?noMutasi=<?php echo $Kode; ?>" target="_blank" class="btn btn-info">Cetak</a></td>
  </tr>
  <?php } ?>
  </tbody>
</table>
</div>

