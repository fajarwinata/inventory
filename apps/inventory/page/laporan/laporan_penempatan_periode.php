<?php

# Deklarasi variabel
$filterSQL = ""; 
$tglAwal	= ""; 
$tglAkhir	= "";


# Set Tanggal skrg
$tglAwal 	= isset($_POST['cmbTglAwal']) ? $_POST['cmbTglAwal'] : date('m')."/01/".date('Y');

$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('m/d/Y');

// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
	$filterSQL = "WHERE ( tgl_penempatan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	$filterSQL = "";
}


# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	//echo "window.open('cetak/penempatan_periode.php?tglAwal=$tglAwal&tglAkhir=$tglAkhir', width=330,height=330,left=100, top=25)";
	echo "window.open('cetak/penempatan_periode.php?tglAwal=$tglAwal&tglAkhir=$tglAkhir')";
	echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM penempatan $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<h2>LAPORAN DATA PENEMPATAN  PER PERIODE</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="111"><strong>Periode </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="770"><div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback" class="form-control has-feedback-left">
          <input name="cmbTglAwal" type="text"  id="single_cal1" value="<?php echo $tglAwal?>" placeholder="Tanggal Awal" aria-describedby="inputSuccess2Status" class="form-control has-feedback-left" required/>
          <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback" class="form-control has-feedback-left">
          <input name="cmbTglAkhir" type="text" id="single_cal2" value="<?php echo $tglAkhir?>" placeholder="Tanggal Akhir" aria-describedby="inputSuccess2Status" class="form-control has-feedback-left" required/>
          <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback" class="form-control has-feedback-left">
          <input name="btnTampil" type="submit" value=" Tampilkan " class="btn btn-info"/>
        </div></td>
    </tr>
  </table>
</form>

<div class="card-box table-responsive">
  <table id="datatable-buttons" class="table table-striped table-bordered">
    <thead>
  <tr>
    <th width="26" align="center" bgcolor="#CCCCCC"><strong>No</strong></th>
    <th width="70" bgcolor="#CCCCCC"><strong>Tanggal</strong></th>
    <th width="120" bgcolor="#CCCCCC"><strong>No. Transaksi</strong></th>
    <th width="275" bgcolor="#CCCCCC"><strong>Keterangan</strong></th>
    <th width="249" bgcolor="#CCCCCC"><strong>Lokasi</strong></th>
    <th width="80" align="right" bgcolor="#CCCCCC"><strong>Qty Barang</strong></th>
    <th width="44" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></th>
  </tr>
  </thead>
    <tbody>
<?php
	// Skrip menampilkan data Transaksi Penempatan
	$mySql = "SELECT penempatan.*, lokasi.nm_lokasi FROM penempatan 
				LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi 
				$filterSQL
				ORDER BY penempatan.no_penempatan DESC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $hal;  
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		# Membaca Kode penempatan/ Nomor transaksi
		$noNota = $myData['no_penempatan'];
		
		# Menghitung Total penempatan (belanja) setiap nomor transaksi
		$my2Sql = "SELECT COUNT(*) AS total_barang FROM penempatan_item WHERE no_penempatan='$noNota'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_penempatan']); ?></td>
    <td><?php echo $myData['no_penempatan']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td><?php echo $myData['nm_lokasi']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td align="center"><a href="../../cetak/penempatan_cetak.php?noNota=<?php echo $noNota; ?>" target="_blank">Cetak</a></td>
  </tr>
  <?php } ?>
    </tbody>
    </table>
  </div>
<table width="100%">
  <tr>
    <td>
      <a href="cetak/penempatan_periode.php?tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>" target="_blank" class="btn btn-large btn-primary">
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