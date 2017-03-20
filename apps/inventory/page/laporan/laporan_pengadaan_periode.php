<?php
include_once "library/inc.seslogin.php";

# Deklarasi variabel
$filterSQL = ""; 
$tglAwal	= ""; 
$tglAkhir	= "";

# Set Tanggal skrg
$tglAwal 	= isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : date('m')."/01/".date('Y');

$tglAkhir 	= isset($_GET['txtTglAkhir']) ? $_GET['txtTglAkhir'] : date('m/d/Y');

// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
	$filterSQL = "WHERE ( tgl_pengadaan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	$filterSQL = "";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/pengadaan_periode.php?tglAwal=$tglAwal&tglAkhir=$tglAkhir')";
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
<h2>LAPORAN DATA  PENGADAAN PER PERIODE </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="111"><strong>Periode </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="770">
        <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback" class="form-control has-feedback-left">
          <input name="txtTglAwal" type="text"  id="single_cal1" value="<?php echo $tglAwal?>" placeholder="Tanggal Awal" aria-describedby="inputSuccess2Status" class="form-control has-feedback-left" required/>
          <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback" class="form-control has-feedback-left">
          <input name="txtTglAkhir" type="text" id="single_cal2" value="<?php echo $tglAkhir?>" placeholder="Tanggal Akhir" aria-describedby="inputSuccess2Status" class="form-control has-feedback-left" required/>
          <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback" class="form-control has-feedback-left">
          <input name="btnTampil" type="submit" value=" Tampilkan " class="btn btn-info"/>
        </div>
      </td>
    </tr>
  </table>
</form>

<div class="card-box table-responsive">
  <table id="datatable-buttons" class="table table-striped table-bordered">
    <thead>
  <tr>
    <th width="21" rowspan="2" align="center" bgcolor="#F5F5F5"><strong>No</strong></th>
    <th width="80" rowspan="2" bgcolor="#F5F5F5"><strong>Tanggal</strong></th>
    <th width="120" rowspan="2" bgcolor="#F5F5F5"><strong>No. Pengadaan</strong></th>
    <th width="201" rowspan="2" bgcolor="#F5F5F5"><strong>Keterangan</strong></th>
    <th width="200" rowspan="2" bgcolor="#F5F5F5"><strong>Supplier </strong></th>
    <th width="20" align="right" bgcolor="#F5F5F5"><strong>Qty</strong></th>
    <th width="120" align="right" bgcolor="#F5F5F5"><strong>Belanja (Rp) </strong></th>
    <th width="37" rowspan="2" align="center" bgcolor="#F5F5F5"><strong>Tools</strong></th>
  </tr>
    </thead>
    <tbody>
  <?php
	# Perintah untuk menampilkan Semua Data Transaksi Pengadaan, menggunakan Filter Periode
	$mySql = "SELECT pengadaan.*, supplier.nm_supplier FROM pengadaan 
				LEFT JOIN supplier ON pengadaan.kd_supplier=supplier.kd_supplier 
				$filterSQL
				ORDER BY pengadaan.no_pengadaan DESC LIMIT $hal, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query pengadaan salah : ".mysql_error());
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
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pengadaan']); ?></td>
    <td><?php echo $myData['no_pengadaan']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td align="center"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_belanja']); ?></td>
    <td align="center"><a href="cetak/pengadaan_cetak.php?Kode=<?php echo $Kode; ?>" target="_blank" class="btn btn-round btn-info">Cetak</a></td>
  </tr>
  <?php } ?>
    </tbody>
    </table></div>
<table width="100%">
  <tr>
    <td >
      <a href="cetak/pengadaan_periode.php?tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>" target="_blank" class="btn btn-large btn-primary">
        <i class="fa fa-print"></i>&nbsp;&nbsp; CETAK DATA
      </a>
      <a href="?open=Laporan-Cetak" class="btn btn-large btn-warning">
        <i class="fa fa-bars"></i>&nbsp;&nbsp; KEMBALI KE MENU
      </a>
    </td>
    <td align="right"><b>Jumlah Data :</b> <?php echo $jml; ?></td>

  </tr>
</table>
<br />