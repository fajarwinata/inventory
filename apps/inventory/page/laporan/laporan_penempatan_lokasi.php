<?php
include_once "library/inc.seslogin.php";

// Variabel SQL
$filterSQL= "";

// Variabel data Combo Lokasi
$kodeDepartemen	= isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : 'Semua'; // dari URL
$dataDepartemen	= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $kodeDepartemen; // dari Form

// Variabel data Combo Lokasi
$kodeLokasi	= isset($_GET['kodeLokasi']) ? $_GET['kodeLokasi'] : 'Semua'; // dari URL
$dataLokasi	= isset($_POST['cmbLokasi']) ? $_POST['cmbLokasi'] : $kodeLokasi; // dari Form

# MEMBUAT FILTER DATA
if (trim($dataLokasi) =="Semua") {
	if (trim($dataDepartemen) =="Semua") {
		// Jika Lokasi Kosong Semua, dan Departemen Kosong
		$filterSQL = "";
	}
	else {
		// dan Jika Lokasi Kosong (Semua), dan Departemen dipilih
		$filterSQL = " WHERE lokasi.kd_departemen='$dataDepartemen'";
	}
}
else {
	// Jika Lokasi dipilih
	$filterSQL = "WHERE penempatan.kd_lokasi='$dataLokasi'";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
		// Buka file
		echo "<script>";
		echo "window.open('cetak/penempatan_lokasi.php?kodeLokasi=$dataLokasi', width=330,height=330,left=100, top=25)";
		echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM penempatan LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$baris);
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT> 

<h2>LAPORAN DATA PENEMPATAN PER LOKASI </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td><b> Departemen </b></td>
      <td><b>:</b></td>
      <td>
		  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback" >
		  <select name="cmbDepartemen" onchange="javascript:submitform();" class="form-control has-feedback-left">
          <option value="Semua">....</option>
          <?php
		  // Skrip menampilkan data Departemen dalam ComboBox
	  $comboSql = "SELECT * FROM departemen ORDER BY kd_departemen";
	  $comboQry = mysql_query($comboSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($comboData = mysql_fetch_array($comboQry)) {
		if ($comboData['kd_departemen'] == $dataDepartemen) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$comboData[kd_departemen]' $cek>$comboData[nm_departemen]</option>";
	  }
	  ?>
      </select>
			  <span class="fa fa-puzzle-piece form-control-feedback left" aria-hidden="true"></span>
		  </div>
	  </td>
    </tr>
    <tr>
      <td width="137"><b> Lokasi </b></td>
      <td width="6"><b>:</b></td>
      <td width="743">
		  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback" >
		  <select name="cmbLokasi" class="form-control has-feedback-left">
          <option value="Semua"> ....</option>
          <?php
		  // Menampilkan data Lokasi per Departemen yang dipilih dari ComboBox
	  $comboSql = "SELECT * FROM lokasi WHERE kd_departemen='$dataDepartemen' ORDER BY kd_lokasi";
	  $comboQry = mysql_query($comboSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($comboData = mysql_fetch_array($comboQry)) {
		if ($comboData['kd_lokasi'] == $dataLokasi) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$comboData[kd_lokasi]' $cek>$comboData[nm_lokasi]</option>";
	  }
	  ?>
        </select>
		  <span class="fa fa-location-arrow form-control-feedback left" aria-hidden="true"></span>
		  </div>
          <input name="btnTampil" type="submit" value=" Tampilkan " class="btn btn-info"/></td>
    </tr>
  </table>
</form>

<div class="card-box table-responsive">
	<table id="datatable-buttons" class="table table-striped table-bordered">
		<thead>
  <tr>
    <th width="24" align="center" bgcolor="#CCCCCC"><strong>No</strong></th>
    <th width="70" bgcolor="#CCCCCC"><strong>Tanggal</strong></th>
    <th width="112" bgcolor="#CCCCCC"><strong>No. Transaksi</strong></th>
    <th width="285" bgcolor="#CCCCCC"><strong>Keterangan</strong></th>
    <th width="243" bgcolor="#CCCCCC"><strong>Lokasi</strong></th>
    <th width="90" align="right" bgcolor="#CCCCCC"><strong>Qty Barang</strong></th>
    <th width="40" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></th>
  </tr>
  </thead>
		<tbody>
  <?php
	// Skrip menampilkan data Transaksi Penempatan, dilengkapi informasi Lokasi, dan filter per Lokasi
	$mySql = "SELECT penempatan.*, lokasi.nm_lokasi FROM penempatan 
				LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi 
				$filterSQL
				ORDER BY penempatan.no_penempatan DESC LIMIT $hal, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		# Membaca Kode penempatan/ Nomor transaksi
		$noNota = $myData['no_penempatan'];
		
		# Menghitung Total Barang yang ditempatkan dilokasi terpilih
		$my2Sql = "SELECT COUNT(*) AS total_barang FROM penempatan_item WHERE  no_penempatan='$noNota'";
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
    <td align="center"><a href="cetak/penempatan_cetak.php?noNota=<?php echo $noNota; ?>" target="_blank" class="btn btn-round btn-info">Cetak</a></td>
  </tr>
  <?php } ?>
		</tbody>
		</table>
	</div>
<table width="100%">
  <tr>
    <td>
		<a href="cetak/penempatan_lokasi.php?kodeLokasi=<?php echo $dataLokasi; ?>" target="_blank" class="btn btn-large btn-primary">
			<i class="fa fa-print"></i>&nbsp;&nbsp; CETAK DATA
		</a>
		<a href="?open=Laporan-Cetak" class="btn btn-large btn-warning">
			<i class="fa fa-bars"></i>&nbsp;&nbsp; KEMBALI KE MENU
		</a>
	</td>
    <td><b>Jumlah Data :</b> <?php echo $jml; ?></td>

  </tr>
</table>