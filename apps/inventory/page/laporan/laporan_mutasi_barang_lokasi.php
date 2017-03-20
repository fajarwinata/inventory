<?php

# Deklarasi variabel
$tglAwal	= ""; 
$tglAkhir	= "";
$filterSQL 	= "";
$filterPeriode	= ""; 

# Membaca Variabel filter yang dikirim Form Filter
$kodeLokasi= isset($_POST['cmbLokasi']) ? $_POST['cmbLokasi'] : 'SEMUA';
$tglAwal 	= isset($_POST['cmbTglAwal']) ? $_POST['cmbTglAwal'] : date('m')."/01/".date('Y');
$tglAkhir 	= isset($_POST['cmbTglAkhir']) ? $_POST['cmbTglAkhir'] : date('m/d/Y');

// Sql untuk filter periode
$filterPeriode = " AND ( mutasi.tgl_mutasi BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";

# TOMBOL TAMPIL DIKLIK
if (isset($_POST['btnTampil'])) {
	
	// Jika lokasi dipilih
	if (trim($kodeLokasi)=="SEMUA") {
		//Query #1 (all)
		$filterSQL 	= $filterPeriode."";
	}
	else {
		//Query #2 (filter)
		$filterSQL 	= $filterPeriode." AND penempatan.kd_lokasi ='$kodeLokasi'";
	}
}
else {
	$filterSQL	= $filterPeriode."";
}
	
# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
		// Buka file
		echo "<script>";
		echo "window.open('cetak/mutasi_barang_lokasi.php?kodeLokasi=$kodeLokasi&tglAwal=$tglAwal&tglAkhir=$tglAkhir')";
		echo "</script>";
}
?>
<h2>  LAPORAN MUTASI BARANG - PER LOKASI </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table-list">
    <tr>
      <td colspan="3"><strong>PILIH LOKASI:</strong></td>
    </tr>
    <tr>
      <td width="90"><strong> Lokasi  Lama</strong></td>
      <td width="5"><strong>:</strong></td>
      <td>
        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
        <select name="cmbLokasi" class="form-control has-feedback-left">
          <option value="SEMUA">- SEMUA -</option>
          <?php
	  $mySql = "SELECT * FROM lokasi ORDER BY kd_lokasi";
	  $myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($kolomData = mysql_fetch_array($myQry)) {
	  	if ($kodeLokasi == $kolomData['kd_lokasi']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$kolomData[kd_lokasi]' $cek>$kolomData[nm_lokasi]</option>";
	  }
	  $mySql ="";
	  ?>
        </select>
          <span class="fa fa-location-arrow form-control-feedback left" aria-hidden="true"></span>
        </div>
      </td>
    </tr>
    <tr>
      <td><strong>Periode </strong></td>
      <td><strong>:</strong></td>
      <td>
        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
        <input name="cmbTglAwal" type="text"  id="single_cal1" value="<?php echo $tglAwal?>" placeholder="Tanggal Awal" aria-describedby="inputSuccess2Status" class="form-control has-feedback-left" required/>
        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback" >
        <input name="cmbTglAkhir" type="text" id="single_cal2" value="<?php echo $tglAkhir?>" placeholder="Tanggal Akhir" aria-describedby="inputSuccess2Status" class="form-control has-feedback-left" required/>
        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
          </div>
      </td>

    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnTampil" type="submit" class="btn btn-info" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>

<br />
<div class="card-box table-responsive">
  <table id="datatable-buttons" class="table table-striped table-bordered">
    <thead>
  <tr>
    <th width="25" align="center" bgcolor="#F5F5F5"><b>No</b></th>
    <th width="77" bgcolor="#F5F5F5"><strong>Tanggal</strong></th>
    <th width="50" bgcolor="#F5F5F5"><strong>No.<br>Mutasi</strong></th>
    <th width="66" bgcolor="#F5F5F5"><strong>Kode </strong></th>
    <th width="288" bgcolor="#F5F5F5"><b>Nama Barang</b></th>
    <th width="50" bgcolor="#F5F5F5"><strong>No.<br>Penempatan </strong></th>
    <th width="162" bgcolor="#F5F5F5"><strong>Lokasi Baru </strong></th>
    <th width="50" align="center" bgcolor="#F5F5F5"><b>Jumlah</b></th>
  </tr>
  </thead>
    <tbody>
  <?php
  	// deklarasi variabel
	$totalBarang 	= 0;  
	
	//  Perintah SQL menampilkan data barang daftar mutasi
	$mySql ="SELECT mutasi.no_mutasi, penempatan.no_penempatan, penempatan.tgl_penempatan, barang.kd_barang, barang.nm_barang
			 FROM mutasi, penempatan, penempatan_item
			 	LEFT JOIN barang_inventaris ON penempatan_item.kd_inventaris=barang_inventaris.kd_inventaris
			 	LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
			 WHERE penempatan.no_penempatan=penempatan_item.no_penempatan
			 $filterSQL
			 ORDER BY penempatan.tgl_penempatan";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	$nomor  = 0;   
	while($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		# Membaca Kode
		$noNota = $myData['no_penempatan'];
		$kodeBrg= $myData['kd_barang'];
		
		# Menghitung Total Barang yang ditempatkan dilokasi terpilih
		$my2Sql = "SELECT COUNT(*) AS total_barang FROM penempatan_item as PI, barang_inventaris as BI 
					WHERE PI.kd_inventaris=BI.kd_inventaris AND BI.kd_barang='$kodeBrg' AND PI.no_penempatan='$noNota'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
		
		$totalBarang= $totalBarang + $my2Data['total_barang'];
		
		# Membaca Nama Lokasi Penempatan Baru
		$my3Sql = "SELECT lokasi.nm_lokasi FROM penempatan LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi 
					WHERE penempatan.no_penempatan='$noNota'";
		$my3Qry = mysql_query($my3Sql, $koneksidb)  or die ("Query 3 salah : ".mysql_error());
		$my3Data = mysql_fetch_array($my3Qry); 
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_penempatan']); ?></td>
    <td><?php echo $myData['no_mutasi']; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['no_penempatan']; ?></td>
    <td><?php echo $my3Data['nm_lokasi']; ?></td>
    <td align="center"><?php echo $my2Data['total_barang']; ?></td>
  </tr>
  <?php 
}?>
    </tbody>
    </table></div>
<table width="100%">
  <tr>
    <td>
      <a href="cetak/mutasi_barang_lokasi.php?kodeLokasi=<?php echo $kodeLokasi; ?>&tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>" target="_blank" class="btn btn-large btn-primary">
        <i class="fa fa-print"></i>&nbsp;&nbsp; CETAK DATA
      </a>
      <a href="?open=Laporan-Cetak" class="btn btn-large btn-warning">
        <i class="fa fa-bars"></i>&nbsp;&nbsp; KEMBALI KE MENU
      </a>
    </td>
    <td align="right"><b>  Total Data : </b></td>
    <td align="center" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalBarang); ?></strong></td>
  </tr>
</table>
