<?php

# Supplier terpilih
$kodeSupplier = isset($_GET['kodeSupplier']) ? $_GET['kodeSupplier'] : 'Semua';
$dataSupplier = isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : $kodeSupplier;

#  Tahun Terpilih
$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

# MEMBUAT SUB SQL FILTER
if(trim($dataSupplier)=="Semua") {
	// Semua Supplier
	$filterSQL 	= "AND LEFT(tgl_pengadaan,4)='$dataTahun'";
}
else {
	// Supplier terpilih, dan Tahun Terpilih
	$filterSQL 	= " AND pengadaan.kd_supplier ='$dataSupplier' AND LEFT(pengadaan.tgl_pengadaan,4)='$dataTahun'";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
		// Buka file
		echo "<script>";
		echo "window.open('cetak/pengadaan_barang_supplier.php?kodeSupplier=$dataSupplier&tahun=$dataTahun')";
		echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$barisData 	= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM pengadaan, pengadaan_item WHERE pengadaan.no_pengadaan = pengadaan_item.no_pengadaan  $filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumData	= mysql_num_rows($pageQry);
$maksData	= ceil($jumData/$barisData);
?>
<h2>  LAPORAN PENGADAAN BARANG PER SUPPLIER </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="111"><strong> Supplier  </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="770">
        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
          <select name="cmbSupplier" class="form-control has-feedback-left">
            <option value="Semua"> .... </option>
            <?php
            $mySql = "SELECT * FROM supplier ORDER BY kd_supplier";
            $myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
            while ($myData = mysql_fetch_array($myQry)) {
              if ($dataKategori == $myData['kd_supplier']) {
                $cek = " selected";
              } else { $cek=""; }
              echo "<option value='$myData[kd_supplier]' $cek> $myData[nm_supplier]</option>";
            }
            $mySql ="";
            ?>
          </select>
          <span class="fa fa-puzzle-piece form-control-feedback left" aria-hidden="true"></span>
        </div>
      </td>
    </tr>
    <tr>
      <td><strong>Tahun </strong></td>
      <td><strong>:</strong></td>
      <td>
        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
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
          <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
        </div>
        <input name="btnTampil" type="submit" class="btn btn-info" value=" Tampilkan " />
    </tr>
  </table>
</form>

<br />
<div class="card-box table-responsive">
  <table id="datatable-buttons" class="table table-striped table-bordered">
    <thead>
    <tr>
      <th width="27" align="center" bgcolor="#CCCCCC"><b>No</b></th>
      <th width="54" bgcolor="#CCCCCC"><strong>Tanggal</strong></th>
      <th width="95" bgcolor="#CCCCCC"><strong>No. Pengadaan </strong></th>
      <th width="46" bgcolor="#CCCCCC"><strong>Kode </strong></th>
      <th width="369" bgcolor="#CCCCCC"><b>Nama Barang</b></th>
      <th width="110" align="right" bgcolor="#CCCCCC"><b> Hrg. Beli (Rp)</b></th>
      <th width="48" align="right" bgcolor="#CCCCCC"><b>Jumlah</b></th>
      <th width="110" align="right" bgcolor="#CCCCCC"><strong> Tot. Harga(Rp)</strong></th>
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
			 ORDER BY pengadaan.tgl_pengadaan LIMIT $halaman, $barisData";
    $myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
    $nomor  = $halaman;
    while($myData = mysql_fetch_array($myQry)) {
      $nomor++;
      $subTotal 	= $myData['harga_beli'] * $myData['jumlah'];
      $totalHarga	= $totalHarga + $subTotal;
      $totalBarang= $totalBarang + $myData['jumlah'];

      // gradasi warna
      if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
      ?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo IndonesiaTgl($myData['tgl_pengadaan']); ?></td>
        <td><?php echo $myData['no_pengadaan']; ?></td>
        <td><?php echo $myData['kd_barang']; ?></td>
        <td><?php echo $myData['nm_barang']; ?></td>
        <td align="right"><?php echo format_angka($myData['harga_beli']); ?></td>
        <td align="right"><?php echo $myData['jumlah']; ?></td>
        <td align="right"><?php echo format_angka($subTotal); ?></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>
<table width="100%">
  <tr>
    <td>
      <a href="cetak/pengadaan_barang_supplier.php?kodeKategori=<?php echo $dataKategori; ?>&tahun=<?php echo $dataTahun; ?>" target="_blank" class="btn btn-large btn-primary">
        <i class="fa fa-print"></i>&nbsp;&nbsp; CETAK DATA
      </a>
      <a href="?open=Laporan-Cetak" class="btn btn-large btn-warning">
        <i class="fa fa-bars"></i>&nbsp;&nbsp; KEMBALI KE MENU
      </a>
    </td>
    <td align="right"><b> GRAND TOTAL : </b></td>
    <td align="right" ><strong><?php echo format_angka($totalBarang); ?></strong></td>
    <td align="right" >Rp. <strong><?php echo format_angka($totalHarga); ?></strong></td>
    <td align="right" ><b>Jumlah Data :</b> <?php echo $jumData; ?></td>

  </tr>
</table>