<?php
include_once "library/inc.seslogin.php";

# Pegawai terpilih
$kodePegawai = isset($_GET['kodePegawai']) ? $_GET['kodePegawai'] : 'Semua';
$dataPegawai = isset($_POST['cmbPegawai']) ? $_POST['cmbPegawai'] : $kodePegawai;

#  Tahun Terpilih
$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

# MEMBUAT SUB SQL FILTER
if(trim($dataPegawai)=="Semua") {
	// Semua Pegawai
	$filterSQL 	= "WHERE LEFT(peminjaman.tgl_peminjaman,4)='$dataTahun'";
}
else {
	// Pegawai terpilih, dan Tahun Terpilih
	$filterSQL 	= " WHERE peminjaman.kd_pegawai ='$dataPegawai' AND LEFT(peminjaman.tgl_peminjaman,4)='$dataTahun'";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
		// Buka file
		echo "<script>";
		//echo "window.open('cetak/peminjaman_pegawai.php?kodePegawai=$dataPegawai&tahun=$dataTahun', width=330,height=330,left=100, top=25)";
		echo "window.open('cetak/peminjaman_pegawai.php?kodePegawai=$dataPegawai&tahun=$dataTahun')";
		echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM peminjaman $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$baris);
?>
<h2>LAPORAN DATA PEMINJAMAN PER PEGAWAI </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="136"><strong> Pegawai </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="745">
        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	  <select name="cmbPegawai" class="form-control has-feedback-left">
        <option value="Semua"> .... </option>
        <?php
		// Menampilkan data Pegawai
	  $mySql = "SELECT * FROM pegawai ORDER BY kd_pegawai";
	  $myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($myData = mysql_fetch_array($myQry)) {
	  	if ($myData['kd_pegawai'] == $dataPegawai) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$myData[kd_pegawai]' $cek> $myData[nm_pegawai]</option>";
	  }
	  ?>
      </select>
          <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
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
		$thnSql = "SELECT MIN(LEFT(tgl_peminjaman,4)) As tahun_kecil, MAX(LEFT(tgl_peminjaman,4)) As tahun_besar FROM peminjaman";
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
          <input name="btnTampil" type="submit" value=" Tampilkan " class="btn btn-info"/></td>
    </tr>
  </table>
</form>

<div class="card-box table-responsive">
<table id="datatable-buttons" class="table table-striped table-bordered">
  <thead>
  <tr>
    <th width="21" align="center" bgcolor="#CCCCCC"><strong>No</strong></th>
    <th width="75" bgcolor="#CCCCCC"><strong>Tanggal</strong></th>
    <th width="108" bgcolor="#CCCCCC"><strong>No. Peminjaman</strong></th>
    <th width="282" bgcolor="#CCCCCC"><strong>Keterangan</strong></th>
    <th width="175" bgcolor="#CCCCCC"><strong>Pegawai</strong></th>
    <th width="81" bgcolor="#CCCCCC"><strong>Status</strong></th>
    <th width="77" align="right" bgcolor="#CCCCCC"><strong>Qty Barang</strong></th>
    <th width="40" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></th>
  </tr>
  </thead>
  <tbody>
  <?php
	// Skrip untuk menampilkan data Transaksi Peminjaman, dilengkapi informasi Nama Pegawai
	// Filter data berdasarkan Nama Pegawai dan Tahun Transaksi
	$mySql = "SELECT peminjaman.*, pegawai.nm_pegawai FROM peminjaman 
				LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai 
				$filterSQL
				ORDER BY peminjaman.no_peminjaman DESC LIMIT $hal, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		// Membaca Kode peminjaman/ Nomor transaksi
		$noNota = $myData['no_peminjaman'];
		
		// Menghitung Total barang yang dipinjam
		$my2Sql = "SELECT COUNT(*) AS total_barang FROM peminjaman_item WHERE no_peminjaman='$noNota'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_peminjaman']); ?></td>
    <td><?php echo $myData['no_peminjaman']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td><?php echo $myData['nm_pegawai']; ?></td>
    <td><?php echo $myData['status_kembali']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td align="center"><a href="cetak/peminjaman_cetak.php?noNota=<?php echo $noNota; ?>" target="_blank" class="btn btn-info">Cetak</a></td>
  </tr>
  <?php } ?>
  </tbody>
</table>
  </div>
<table width="100%">
  <tr>
    <td >
      <a href="cetak/peminjaman_pegawai.php?kodePegawai=<?php echo $dataPegawai; ?>&tahun=<?php echo $dataTahun; ?>" target="_blank" class="btn btn-large btn-primary">
        <i class="fa fa-print"></i>&nbsp;&nbsp; CETAK DATA
      </a>
      <a href="?open=Laporan-Cetak" class="btn btn-large btn-warning">
        <i class="fa fa-bars"></i>&nbsp;&nbsp; KEMBALI KE MENU
      </a>

    </td>
    <td align="right"><b>Jumlah Data :</b> <?php echo $jml; ?></td>
    </tr>
</table>