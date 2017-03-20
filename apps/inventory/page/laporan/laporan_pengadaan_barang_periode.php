<?php

# Deklarasi variabel
$filterSQL = ""; 
$tglAwal	= ""; 
$tglAkhir	= "";

# Set Tanggal skrg
$tglAwal 	= isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : date('m')."/01/".date('Y');

$tglAkhir 	= isset($_GET['txtTglAkhir']) ? $_GET['txtTglAkhir'] : date('m/d/Y');

// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
	$filterSQL = "AND ( tgl_pengadaan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	$filterSQL = "";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/pengadaan_barang_periode.php?tglAwal=$tglAwal&tglAkhir=$tglAkhir')";
	echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$barisData 	= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM pengadaan, pengadaan_item WHERE pengadaan.no_pengadaan = pengadaan_item.no_pengadaan $filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumData	= mysql_num_rows($pageQry);
$maksData	= ceil($jumData/$barisData);
?>
<h2>  LAPORAN PENGADAAN BARANG PER PERIODE </h2>
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
    <th width="27" ><b>No</b></th>
    <th width="54" ><strong>Tanggal</strong></th>
    <th width="95" ><strong>No. Pengadaan </strong></th>
    <th width="46" ><strong>Kode </strong></th>
    <th width="369" ><b>Nama Barang</b></th>
    <th width="20" ><b> Hrg. Beli (Rp)</b></th>
    <th width="20" ><b>Jml</b></th>
    <th width="50" ><strong> Tot. Harga(Rp)</strong></th>
  </tr>
  </thead>
    <tbody>
  <?php
  	// deklarasi variabel
	$subTotal 		= 0; 
	$totalHarga 	= 0; 
	$totalBarang 	= 0;  
	
	//  Perintah SQL menampilkan data barang daftar pengadaan
	$mySql ="SELECT pengadaan_item.*, pengadaan.tgl_pengadaan, barang.nm_barang 
			 FROM pengadaan, pengadaan_item
			 	LEFT JOIN barang ON pengadaan_item.kd_barang=barang.kd_barang 
			 WHERE pengadaan.no_pengadaan=pengadaan_item.no_pengadaan
			 $filterSQL
			 ORDER BY pengadaan.tgl_pengadaan ";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	$nomor  = 0;
	while($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$subTotal 	= $myData['harga_beli'] * $myData['jumlah'];
		$totalHarga	= $totalHarga + $subTotal;
		$totalBarang= $totalBarang + $myData['jumlah'];

	?>
  <tr >
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pengadaan']); ?></td>
    <td><?php echo $myData['no_pengadaan']; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($myData['harga_beli']); ?></td>
    <td align="center"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subTotal); ?></td>
  </tr>
  <?php 
}?>
  </tbody>
    </table>
  </div>
<table width="100%">
  <tr>
    <td >
      <a href="cetak/pengadaan_barang_periode.php?tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>" target="_blank" class="btn btn-large btn-primary">
        <i class="fa fa-print"></i>&nbsp;&nbsp; CETAK DATA
      </a>
      <a href="?open=Laporan-Cetak" class="btn btn-large btn-warning">
        <i class="fa fa-bars"></i>&nbsp;&nbsp; KEMBALI KE MENU
      </a>

    </td>
    <td colspan="6" align="right"><b> GRAND TOTAL : </b></td>
    <td align="right" ><strong><?php echo format_angka($totalBarang); ?> Unit</strong></td>
    <td align="right" >Rp. <strong><?php echo format_angka($totalHarga); ?></strong></td>
    <td align="right"><b>Jumlah Data :</b> <?php echo $jumData; ?></td>
  </tr>
</table>

