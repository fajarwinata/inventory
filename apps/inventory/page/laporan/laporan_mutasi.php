<?php
include_once "library/inc.seslogin.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM mutasi";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<h2>LAPORAN DATA MUTASI </h2>
<div class="card-box table-responsive">
    <table id="datatable-buttons" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th width="26" align="center" bgcolor="#CCCCCC"><strong>No</strong></th>
            <th width="63" bgcolor="#CCCCCC"><strong>Tanggal</strong></th>
            <th width="101" bgcolor="#CCCCCC"><strong>No. Mutasi</strong></th>
            <th width="145" bgcolor="#CCCCCC"><strong>Lokasi Lama </strong></th>
            <th width="110" bgcolor="#CCCCCC"><strong>No. Penempatan </strong></th>
            <th width="145" bgcolor="#CCCCCC"><strong>Lokasi Baru </strong></th>
            <th width="148" bgcolor="#CCCCCC"><strong>Keterangan</strong></th>
            <th width="79" align="right" bgcolor="#CCCCCC"><strong>Qty Barang</strong></th>
            <th width="37" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></th>
          </tr>
          </thead>
        <tbody>

<?php
	# Perintah untuk menampilkan Semua Daftar Transaksi mutasi
	$mySql = "SELECT mutasi.*, lokasi.nm_lokasi FROM mutasi 
				LEFT JOIN lokasi ON mutasi.kd_lokasi=lokasi.kd_lokasi 
				ORDER BY mutasi.no_mutasi DESC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		# Membaca Kode mutasi/ Nomor transaksi
		$noMutasi = $myData['no_mutasi'];

		# Perintah untuk mendapatkan data dari hasil Penempatan Baru
		$noPenempatan	= $myData['no_penempatan'];
		$my2Sql = "SELECT penempatan.*, lokasi.nm_lokasi FROM penempatan 
					LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi 
					WHERE penempatan.no_penempatan='$noPenempatan'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
		
		# Menghitung Total barang yang dimutasi setiap nomor transaksi
		$my3Sql = "SELECT COUNT(*) AS total_barang FROM penempatan_item WHERE no_penempatan='$noPenempatan'";
		$my3Qry = mysql_query($my3Sql, $koneksidb)  or die ("Query 3 salah : ".mysql_error());
		$my3Data = mysql_fetch_array($my3Qry);
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_mutasi']); ?></td>
    <td><?php echo $myData['no_mutasi']; ?></td>
    <td><?php echo $myData['nm_lokasi']; ?></td>
    <td><?php echo $myData['no_penempatan']; ?></td>
    <td><?php echo $my2Data['nm_lokasi']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="right"><?php echo format_angka($my3Data['total_barang']); ?></td>
    <td align="center"><a href="../../cetak/mutasi_cetak.php?noMutasi=<?php echo $noMutasi; ?>" target="_blank">Cetak</a></td>
  </tr>
  <?php } ?>
        </tbody>
        </table></div>
<table>
  <tr>
    <td ><b>Jumlah Data :</b> <a href="cetak/mutasi.php" target="_blank" class="btn btn-large btn-primary">
            <i class="fa fa-print"></i>&nbsp;&nbsp; CETAK DATA
        </a>
        <a href="?open=Laporan-Cetak" class="btn btn-large btn-warning">
            <i class="fa fa-bars"></i>&nbsp;&nbsp; KEMBALI KE MENU
        </a>
    </td>
    <td colspan="3"><b>Jumlah Data :</b> <?php echo $jml; ?></td>
  </tr>
</table>
