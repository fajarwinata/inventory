<?php
// Membaca User yang Login
$userLogin	= $_SESSION['SES_LOGIN'];

# HAPUS DAFTAR BARANG DI TMP
if(isset($_GET['Act'])){
	$Act	= $_GET['Act'];
	$ID		= $_GET['ID'];
	
	if(trim($Act)=="Delete"){
		# Hapus Tmp jika datanya sudah dipindah
		$mySql = "DELETE FROM tmp_peminjaman WHERE id='$ID' AND kd_petugas='$userLogin'";
		mysql_query($mySql, $koneksidb) or die ("Gagal menghapus tmp : ".mysql_error());
	}
	if(trim($Act)=="Sucsses"){
		echo "<b>DATA BERHASIL DISIMPAN</b> <br><br>";
	}
}
// =========================================================================

# TOMBOL TAMBAH (KODE BARANG) DIKLIK & SAAT ADA KODE INVENTARIS DIINPUT PADA KOTAK OLEH BARCODE ATAU COPY-PASTE-TAB
if(isset($_POST['btnTambah']) or isset($_POST['txtKodeInventaris']) ){
	// Baca variabel
	$txtKodeInventaris	= $_POST['txtKodeInventaris'];
	$txtKodeInventaris	= str_replace("'","&acute;",$txtKodeInventaris);
	
	// Validasi form
	$pesanError = array();
	if(trim($txtKodeInventaris)=="") {
		$pesanError[] = "Data <b>Kode/ Label Barang</b> belum diisi, ketik secara manual atau dari <b>Barcode Reader</b> !";		
	}
	
	# Periksa 1, apakah Kode Inventaris yang dimasukkan ada di dalam Database
	$cekSql	= "SELECT * FROM barang_inventaris WHERE kd_inventaris='$txtKodeInventaris' OR RIGHT(kd_inventaris,6) ='$txtKodeInventaris'";
	$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query".mysql_error());
	if(mysql_num_rows($cekQry) < 1) {
		$pesanError[] = "Barang Kode/ Label <b>$txtKodeInventaris</b> tidak ditemukan dalam database!";
	}
	else {
		// Jika kode barang ditemukan di tabel barang_inventaris, maka periksa status-nya 
		$cekData = mysql_fetch_array($cekQry);
		if($cekData['status_barang']=="Ditempatkan") {
			$pesanError[] = "Barang dengan Kode <b>$txtKodeInventaris</b> tidak dapat dipinjam, karna <b> sudah ditempatkan/ dipakai</b>!";
		}
		if($cekData['status_barang']=="Dipinjam") {
			$pesanError[] = "Barang dengan Kode <b>$txtKodeInventaris</b> tidak dapat dipinjam, karna <b> sedang dipinjam</b>!";
		}
	}
	
	# Periksa 2, apakah Kode Inventaris sudah diinput atau belum
	$cek2Sql	= "SELECT * FROM tmp_peminjaman WHERE kd_inventaris='$txtKodeInventaris' OR RIGHT(kd_inventaris,6) ='$txtKodeInventaris'";
	$cek2Qry = mysql_query($cek2Sql, $koneksidb) or die ("Gagal Query".mysql_error());
	if(mysql_num_rows($cek2Qry) >=1) {
		$pesanError[] = "Barang dengan Kode <b>$txtKodeInventaris</b> sudah di-Input, silahkan masukan data yang lain !";
	}
			
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>";
		echo "<img src='images/inv_icn_kesalahan.png' /> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div></div> <br>";
	}
	else {
		# Jika jumlah error pesanError tidak ada			
		// Masukkan data ke dalam tabel TMP (grid)
		$tmpSql 	= "INSERT INTO tmp_peminjaman (kd_inventaris, kd_petugas) VALUES ('$txtKodeInventaris', '$userLogin')";
		mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());
	}

}

// ============================================================================

# ========================================================================================================
# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnSimpan'])){
	// Baca variabel from
	$txtTanggal 	= InggrisTgl($_POST['txtTanggal']);
	$txtTglKembali 	= InggrisTgl($_POST['txtTglKembali']);
	$cmbPegawai		= $_POST['cmbPegawai'];
	$txtKeterangan	= $_POST['txtKeterangan'];
	
	// Validasi form	
	$pesanError = array();
	if (trim($txtTanggal)=="--") {
		$pesanError[] = "Data <b>Tgl. Transaksi</b> belum diisi, pilih pada Kalender !";		
	}
	if (trim($txtTglKembali)=="--") {
		$pesanError[] = "Data <b>Tanggal Kembali</b> belum diisi, pilih pada Kalender !";		
	}
	if (trim($cmbPegawai)=="Kosong") {
		$pesanError[] = "Data <b>Pegawai</b> belum diisi, pilih pada combo !";		
	}
	
	# Periksa apakah sudah ada barang yang dimasukkan
	$cekSql ="SELECT * FROM tmp_peminjaman WHERE kd_petugas='$userLogin'";
	$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query cek Tmp 1".mysql_error());
	if (mysql_num_rows($cekQry) < 1) {
		$pesanError[] = "<b>DAFTAR BARANG MASIH KOSONG</b>, Daftar item barang yang dipinjam belum dimasukan ";
	}
	else {
		// Tampilkan datanya, lalu cek Status-nya
		while($cekData= mysql_fetch_array($cekQry)) {
			$kodeInv	= $cekData['kd_inventaris'];
			
			# VALIDASI JIKA MASIH ADA BARANG YANG SUDAH DITEMPATKAN/ DIPINJAM
			$cek2Sql	= "SELECT * FROM barang_inventaris WHERE kd_inventaris='$kodeInv'";
			$cek2Qry 	= mysql_query($cek2Sql, $koneksidb) or die ("Gagal Query cek tmp 2 baca : ".mysql_error());
			if(mysql_num_rows($cek2Qry) >= 1) {
				$cek2Data	= mysql_fetch_array($cek2Qry);
				$kodeInv	= $cek2Data['kd_inventaris'];
				
				// membuat pesan
				if($cek2Data['status_barang']=="Ditempatkan") {
					$pesanError[] = "Kode <b>$kodeInv</b> statusnya masih <b>Ditempatkan</b>, silahkan ganti dengan yang lain ! ";
				}
				if($cek2Data['status_barang']=="Dipinjam") {
					$pesanError[] = "Kode <b>$kodeInv</b> statusnya masih <b>Dipinjam</b>, silahkan ganti dengan yang lain ! ";
				}
			}
		}
	}
			
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>";
		echo "<img src='images/inv_icn_kesalahan.png' /> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div></div> <br>";
	}
	else {
		# SIMPAN DATA KE DATABASE
		# Jika jumlah error pesanError tidak ada
		$kodeBaru = buatKode("peminjaman", "PJ");
		$mySql	= "INSERT INTO peminjaman (no_peminjaman, tgl_peminjaman, tgl_akan_kembali, kd_pegawai, keterangan, kd_petugas)
					VALUES ('$kodeBaru', '$txtTanggal', '$txtTglKembali', '$cmbPegawai', '$txtKeterangan', '$userLogin')";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		
		if($myQry){
			# …LANJUTAN, SIMPAN DATA
			# Ambil semua data barang yang dipilih, berdasarkan Petugas yg login
			$tmpSql ="SELECT * FROM tmp_peminjaman WHERE kd_petugas='$userLogin'";
			$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
			while ($tmpData = mysql_fetch_array($tmpQry)) {
				// Baca data dari tabel Inventaris Barang
				$kodeInventaris 	= $tmpData['kd_inventaris'];
				
				// Masukkan semua data di atas dari tabel TMP ke tabel ITEM
				$itemSql = "INSERT INTO peminjaman_item (no_peminjaman, kd_inventaris) VALUES ('$kodeBaru', '$kodeInventaris')";
				mysql_query($itemSql, $koneksidb) or die ("Gagal Query ".mysql_error());
				
				// Skrip Update status barang : Dipinjam
				$mySql = "UPDATE barang_inventaris SET status_barang='Dipinjam' WHERE kd_inventaris='$kodeInventaris'";
				mysql_query($mySql, $koneksidb) or die ("Gagal Query Edit Status".mysql_error());
			}
			
			# Kosongkan Tmp jika datanya sudah dipindah
			$hapusSql = "DELETE FROM tmp_peminjaman WHERE kd_petugas='$userLogin'";
			mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
			
			// Refresh form
			echo "<script>";
			//echo "window.open('../cetak/peminjaman_cetak.php?noNota=$kodeBaru', width=330,height=330,left=100, top=25)";
			echo "window.open('../cetak/peminjaman_cetak.php?noNota=$kodeBaru')";
			echo "</script>";
		}
	}	
}
	
# TAMPILKAN DATA KE FORM
$dataKode 			= buatKode("peminjaman", "PJ");
$dataTglTransaksi 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataTglKembali 	= isset($_POST['txtTglKembali']) ? $_POST['txtTglKembali'] : date('d-m-Y');
$dataPegawai		= isset($_POST['cmbPegawai']) ? $_POST['cmbPegawai'] : '';
$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
?>

<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT> 

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"  name="form1">
<table width="900" cellpadding="3" cellspacing="1" class="table-list">
	<tr>
	  <td bgcolor="#F5F5F5"><strong>PEMINJAMAN</strong></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td width="21%"><strong>No. Peminjaman </strong></td>
	  <td width="1%"><strong>:</strong></td>
	  <td width="78%">
	  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	  <input name="txtNomor" value="<?php echo $dataKode; ?>" class="form-control has-feedback-left" size="23" maxlength="20" readonly="readonly"/>
	  <span class="fa fa-check-square-o form-control-feedback left" aria-hidden="true"></span>
	  </div>
	  </td>
	</tr>
	<tr>
      <td><strong>Tgl. Peminjaman </strong></td>
	  <td><strong>:</strong></td>
	  <td><div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	  <input type="text" name="txtTanggal" id="single_cal1" placeholder="Masukan Tanggal" aria-describedby="inputSuccess2Status" class="form-control has-feedback-left" />
	  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
	  <span id="inputSuccess2Status4" class="sr-only">(success)</span>
      </div></td>
    </tr>
	<tr>
      <td><strong>Tgl. Kembali </strong></td>
	  <td><strong>:</strong></td>
	  <td>
	  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	  <input type="text" name="txtTglKembali" id="single_cal2" placeholder="Masukan Tanggal" aria-describedby="inputSuccess2Status" class="form-control has-feedback-left" />
	  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
	  <span id="inputSuccess2Status4" class="sr-only">(success)</span>
      </div>
	  </td>
    </tr>
	<tr>
      <td><strong>Data Pegawai </strong></td>
	  <td><strong>:</strong></td>
	  <td><b>
	  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
        <select name="cmbPegawai" class="form-control has-feedback-left">
          <option value="Kosong">....</option>
          <?php
		  // Menampilkan data Pegawai
	  $comboSql = "SELECT * FROM pegawai ORDER BY kd_pegawai";
	  $comboQry = mysql_query($comboSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($comboData = mysql_fetch_array($comboQry)) {
	  	if ($dataPegawai == $comboData['kd_pegawai']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$comboData[kd_pegawai]' $cek>[ $comboData[kd_pegawai] ] $comboData[nm_pegawai]</option>";
	  }
	  ?>
        </select>
		<span class="fa fa-users form-control-feedback left" aria-hidden="true"></span>
		</div>
      </b></td>
    </tr>
	<tr>
      <td><strong>Keterangan</strong></td>
	  <td><strong>:</strong></td>
	  <td>
	  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback" >
	  <input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" class="form-control has-feedback-left" maxlength="100" />
	  <span class="fa fa-info form-control-feedback left" aria-hidden="true"></span>
	  </div>
	  </td>
    </tr>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td bgcolor="#F5F5F5"><strong>INPUT BARANG </strong></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td><strong>Kode/ Label Barang </strong></td>
	  <td><strong>:</strong></td>
	  <td><b>
	     <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback" >
	    <input name="txtKodeInventaris" id="txtKodeInventaris" class="form-control has-feedback-left" maxlength="40" onchange="javascript:submitform();" required/>
	    <span class="fa fa-check-square-o form-control-feedback left" aria-hidden="true"></span>
		</div>
      <input name="btnTambah" type="submit" style="cursor:pointer;" class="btn btn-info" value=" Tambah " />
      </b></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td><strong>:</strong></td>
	  <td>
	  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback" >
	  <input name="txtNamaBrg"  id="txtNamaBrg" size="80" maxlength="100" class="form-control has-feedback-left" disabled="disabled" />
	   <span class="fa fa-barcode form-control-feedback left" aria-hidden="true"></span>
	  </div>
	  </td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>
	    <a href="javaScript: void(0)" onclick="popup('pencarian_barang.php')" target="_self"><strong>Pencarian Barang</strong></a>, bisa pakai <strong>Barcode Reader</strong> untuk membaca label barang </td>
    </tr>
</table>
<div class="card-box table-responsive">
<table id="datatable-buttons" class="table table-striped table-bordered">
 <thead>
   <tr>
    <th width="23" align="center" ><strong>No</strong></th>
    <th width="102" ><strong>Kode</strong></th>
    <th width="434" ><strong>Nama Barang </strong></th>
    <th width="203" ><strong>Merek</strong></th>
    <th width="46" align="center" ><strong>Tools</strong></th>
  </tr>
  </thead>
  <tbody>
<?php
// Qury menampilkan data dalam Grid TMP_peminjaman 
$tmpSql ="SELECT tmp.*, barang.* FROM tmp_peminjaman As tmp
		LEFT JOIN barang_inventaris ON tmp.kd_inventaris  = barang_inventaris.kd_inventaris
		LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
		WHERE tmp.kd_petugas='$userLogin'
		ORDER BY barang.kd_barang ";
$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0;  
while($tmpData = mysql_fetch_array($tmpQry)) {
	$nomor++;
	$ID			= $tmpData['id'];
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><b><?php echo $tmpData['kd_inventaris']; ?></b></td>
    <td><?php echo $tmpData['nm_barang']; ?></td>
    <td><?php echo $tmpData['merek']; ?></td>
    <td align="center" bgcolor="#FFFFCC"><a href="?open=<?php echo md5('peminjaman')?>&&Act=Delete&ID=<?php echo $ID; ?>" target="_self">Delete</a></td>
  </tr>
<?php } ?>
</tbody>
</table>
</div>
	<input name="btnSimpan" type="submit" style="cursor:pointer;" class="btn btn-success" value=" SIMPAN DATA " />
</form>
