<?php
// Membaca User yang Login
$userLogin	= $_SESSION['SES_LOGIN'];

# HAPUS DAFTAR BARANG DI TMP
if(isset($_GET['Act'])){
	$Act	= $_GET['Act'];
	$ID		= $_GET['ID'];
	
	if(trim($Act)=="Delete"){
		# Hapus Tmp jika datanya sudah dipindah
		$mySql = "DELETE FROM tmp_penempatan WHERE id='$ID' AND kd_petugas='$userLogin'";
		mysql_query($mySql, $koneksidb) or die ("Gagal menghapus tmp : ".mysql_error());
	}
	if(trim($Act)=="Sucsses"){
		echo "<b>DATA BERHASIL DISIMPAN</b> <br><br>";
	}
}
// =========================================================================

// Isi temporari form Transaksi utama
$dataDepartemen	= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : '';
$dataLokasi		= isset($_POST['cmbLokasi']) ? $_POST['cmbLokasi'] : '';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';

# TOMBOL TAMBAH (KODE BARANG) DIKLIK  & SAAT ADA KODE INVENTARIS DIINPUT PADA KOTAK OLEH BARCODE ATAU COPY-PASTE-TAB
if(isset($_POST['btnTambah']) or isset($_POST['txtKodeInventaris'])){
 	# Baca variabel
	$txtKodeInventaris	= $_POST['txtKodeInventaris'];
	$txtKodeInventaris	= str_replace("'","&acute;",$txtKodeInventaris);
	
	// Validasi form
	$pesanError = array();
	if (trim($txtKodeInventaris) !="") {
		// Jika Kode Inv Barang tidak kosong, maka periksa keberadaan kode dalam database (tabel barang_inventaris)
		# Periksa Database 1, apakah Kode Inventaris yang dimasukkan ada di dalam Database
		$cekSql	= "SELECT * FROM barang_inventaris WHERE kd_inventaris='$txtKodeInventaris' or RIGHT(kd_inventaris,6) ='$txtKodeInventaris'";
		$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query".mysql_error());
		if(mysql_num_rows($cekQry) < 1) {
			$pesanError[] = "Kode Barang <b>$txtKodeInventaris</b> tidak ditemukan dalam database!";
		}
		else {
			// Jika kode barang ditemukan di tabel barang_inventaris, maka periksa status-nya 
			$cekData = mysql_fetch_array($cekQry);
			
			if($cekData['status_barang']=="Ditempatkan") {
				$pesanError[] = "Kode Barang <b>$txtKodeInventaris</b> tidak dapat dipakai, karna <b> sudah Ditempatkan/ dipakai</b>!";
			}
			if($cekData['status_barang']=="Dipinjam") {
				$pesanError[] = "Kode Barang $txtKodeInventaris</b> tidak dapat dipakai, karna <b> sedang Dipinjam</b>!";
			}
		}
	
		# Periksa Database 2, apakah Kode Inventaris sudah diinput atau belum
		$cek2Sql	= "SELECT * FROM tmp_penempatan WHERE kd_inventaris='$txtKodeInventaris'";
		$cek2Qry = mysql_query($cek2Sql, $koneksidb) or die ("Gagal Query".mysql_error());
		if(mysql_num_rows($cek2Qry) >=1) {
			$pesanError[] = "Kode Barang <b>$txtKodeInventaris</b> sudah di-Input, ganti dengan yang lain !";
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
		# JIKA TIDAK MENEMUKAN ERROR
		$bacaSql	= "SELECT * FROM barang_inventaris WHERE ( kd_inventaris='$txtKodeInventaris' OR RIGHT(kd_inventaris,6) ='$txtKodeInventaris' ) 
						AND status_barang='Tersedia'";
		$bacaQry 	= mysql_query($bacaSql, $koneksidb) or die ("Gagal Query baca : ".mysql_error());
		if(mysql_num_rows($bacaQry) >= 1) {
			$bacaData	= mysql_fetch_array($bacaQry);
			
			$kodeInventaris		= $bacaData['kd_inventaris'];
				
			// Menyimpan data ke Keranjang (TMP)
			$tmpSql 	= "INSERT INTO tmp_penempatan (kd_inventaris, kd_petugas) VALUES ('$kodeInventaris', '$userLogin')";
			mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());
		}
	}
}
// ============================================================================

# ========================================================================================================
# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnSimpan'])){
	// Baca variabel from
	$txtTanggal 	= InggrisTgl($_POST['txtTanggal']);
	$cmbLokasi		= $_POST['cmbLokasi'];
	$txtKeterangan	= $_POST['txtKeterangan'];

	// Validasi form
	$pesanError = array();
	if (trim($txtTanggal)=="") {
		$pesanError[] = "Data <b>Tanggal Transaksi</b> belum diisi!";
	}
	if (trim($cmbLokasi)=="Kosong") {
		$pesanError[] = "Data <b>Lokasi / Ruang</b> belum diisi, pilih pada combo !";		
	}
	
	# Periksa apakah sudah ada barang yang dimasukkan
	$tmpSql ="SELECT COUNT(*) As qty FROM tmp_penempatan WHERE kd_petugas='$userLogin'";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$tmpData = mysql_fetch_array($tmpQry);
	if ($tmpData['qty'] < 1) {
		$pesanError[] = "<b>BELUM MENG-INPUT DATA BARANG</b>, minimal 1 Barang.";
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
		$kodeBaru = buatKode("penempatan", "PB");
		$mySql	= "INSERT INTO penempatan (no_penempatan, tgl_penempatan, kd_lokasi, keterangan, jenis, kd_petugas)
					VALUES ('$kodeBaru', '$txtTanggal', '$cmbLokasi', '$txtKeterangan', 'Baru', '$userLogin')";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query penempatan ".mysql_error());
		if($myQry){
			# …LANJUTAN, SIMPAN DATA
			# Ambil semua data barang yang dipilih, berdasarkan Petugas yg login
			$tmpSql ="SELECT * FROM tmp_penempatan WHERE kd_petugas='$userLogin'";
			$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
			while($tmpData = mysql_fetch_array($tmpQry)) {
				// Baca data dari tabel Inventaris Barang
				$dataKode 	= $tmpData['kd_inventaris'];
				
				// MEMINDAH DATA, Masukkan semua dari TMP_Mutasi ke dalam tabel Penempatan_Item
				$itemSql = "INSERT INTO penempatan_item (no_penempatan, kd_inventaris, status_aktif) VALUES ('$kodeBaru', '$dataKode', 'Yes')";
				mysql_query($itemSql, $koneksidb) or die ("Gagal Query penempatan_item : ".mysql_error());
				
				// Skrip Update status barang (used=keluar/dipakai)
				$mySql = "UPDATE barang_inventaris SET status_barang='Ditempatkan' WHERE kd_inventaris='$dataKode'";
				mysql_query($mySql, $koneksidb) or die ("Gagal Query Edit Status".mysql_error());
			}
			
			# Kosongkan Tmp jika datanya sudah dipindah
			$hapusSql = "DELETE FROM tmp_penempatan WHERE kd_petugas='$userLogin'";
			mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
			
			// Refresh form
			echo "<script>";
			echo "window.open('cetak/penempatan_cetak.php?noNota=$kodeBaru')";
			echo "</script>";
		}
	}	
}



# TAMPILKAN DATA KE FORM
$dataKode	 	= buatKode("penempatan", "PB");
$dataTanggal 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataDepartemen	= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : '';
$dataLokasi		= isset($_POST['cmbLokasi']) ? $_POST['cmbLokasi'] : '';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT> 

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"  name="form1">
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
			<div class="x_panel tile">
				<div class="x_title">
					<h2>Tambah Barang Kedalam Daftar Lokasi</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="dashboard-widget-content">
	<table>

	<tr>
	  <td><strong>Kode/ Label Barang </strong></td>
	  <td><strong>:</strong></td>
	  <td><b>
	    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback" >
	    <input name="txtKodeInventaris" id="txtKodeInventaris" class="form-control has-feedback-left" maxlength="40" onchange="javascript:submitform();" />
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
	  <td><a href="javaScript:void(0)" onclick="popup('pencarian_barang.php')" target="_self"><strong>Pencarian Barang</strong></a>, bisa pakai <strong>Barcode Reader</strong> untuk membaca label barang </td>
    </tr>

</table>
			</div>
			</div>
			</div>

			<div class="card-box table-responsive">
				<table id="datatable-buttons" class="table table-striped table-bordered">
					<thead>
					<tr>
						<th width="23" align="center" ><strong>No</strong></th>
						<th width="102" ><strong>Kode</strong></th>
						<th width="434" ><strong>Nama Barang </strong></th>
						<th width="203" ><strong>Merek</strong></th>
						<th width="61" ><strong>Satuan</strong></th>
						<th width="46" align="center" ><strong>Tools</strong></th>
					</tr>
					</thead>
					<tbody>
					<?php
					// Qury menampilkan data dalam Grid TMP_penempatan
					$tmpSql ="SELECT barang.*, tmp.*
		FROM tmp_penempatan As tmp
		LEFT JOIN barang_inventaris ON tmp.kd_inventaris = barang_inventaris.kd_inventaris
		LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
		WHERE tmp.kd_petugas='$userLogin'
		ORDER BY barang.kd_barang ";
					$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
					$nomor=0;
					while($tmpData = mysql_fetch_array($tmpQry)) {
						$nomor++;
						$ID		= $tmpData['id'];
						?>
						<tr>
							<td align="center"><?php echo $nomor; ?></td>
							<td><b><?php echo $tmpData['kd_inventaris']; ?></b></td>
							<td><?php echo $tmpData['nm_barang']; ?></td>
							<td><?php echo $tmpData['merek']; ?></td>
							<td><?php echo $tmpData['satuan']; ?></td>
							<td align="center" bgcolor="#FFFFCC"><a href="?open=<?php echo md5('penempatan')?>&&Act=Delete&ID=<?php echo $ID; ?>" target="_self">Delete</a></td>
						</tr>
						<?php
					}?>
					</tbody>
				</table>
			</div>





			</div>

		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
			<div class="x_panel tile" style="background:#82fde7; color: #131213">
				<div class="x_title">
					<h2>Tempatkan Barang Terdaftar</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="dashboard-widget-content">
	<table cellpadding="3" cellspacing="1" class="table-list">

		<tr>
			<td width="21%"><strong>No. Penempatan </strong></td>
			<td width="1%"><strong>:</strong></td>
			<td width="78%">
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input name="txtNomor" value="<?php echo $dataKode; ?>" class="form-control has-feedback-left" size="23" maxlength="20" readonly="readonly"/>
					<span class="fa fa-check-square-o form-control-feedback left" aria-hidden="true"></span>
				</div>
			</td>
		</tr>
		<tr>
			<td><strong>Tgl. Penempatan </strong></td>
			<td><strong>:</strong></td>
			<td>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input type="text" name="txtTanggal" id="single_cal1" placeholder="Masukan Tanggal" aria-describedby="inputSuccess2Status" class="form-control has-feedback-left" />
					<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
					<span id="inputSuccess2Status4" class="sr-only">(success)</span>
				</div>
			</td>
		</tr>
		<tr>
			<td><strong>Departemen </strong></td>
			<td><strong>:</strong></td>
			<td>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<select name="cmbDepartemen" onchange="javascript:submitform();" class="form-control has-feedback-left">
						<option value="Kosong">....</option>
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
			<td><strong>Lokasi Penempatan </strong></td>
			<td><strong>:</strong></td>
			<td><b>
					<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" >
						<select name="cmbLokasi" class="form-control has-feedback-left">

							<?php
							// Menampilkan data Lokasi dengan filter Nama Departemen yang dipilih
							$comboSql = "SELECT * FROM lokasi WHERE kd_departemen='$dataDepartemen' ORDER BY kd_lokasi";
							$comboQry = mysql_query($comboSql, $koneksidb) or die ("Gagal Query".mysql_error());
							while ($comboData = mysql_fetch_array($comboQry)) {
								if ($dataLokasi == $comboData['kd_lokasi']) {
									$cek = " selected";
								} else { $cek=""; }
								echo "<option value='$comboData[kd_lokasi]' $cek> $comboData[nm_lokasi]</option>";
							}
							?>
						</select>
						<span class="fa fa-puzzle-piece form-control-feedback left" aria-hidden="true"></span>
					</div>
				</b></td>
		</tr>
		<tr>
			<td><strong>Keterangan</strong></td>
			<td><strong>:</strong></td>
			<td>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" >
					<input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" class="form-control has-feedback-left" maxlength="100" />
					<span class="fa fa-info form-control-feedback left" aria-hidden="true"></span>
				</div>
			</td>
		</tr>

		<tr><td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<input name="btnSimpan" type="submit" style="cursor:pointer;" class="btn btn-success" value=" SIMPAN DATA " />
				</div></td>
		</tr>
	</table>

		</div>
		</div>
		</div>
		</div>


		</div>
</form>
