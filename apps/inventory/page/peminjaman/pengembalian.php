<?php
// Membaca User yang Login
$userLogin	= $_SESSION['SES_LOGIN'];

# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnSimpan'])){
	// Baca variabel from
	$txtTanggal 	= InggrisTgl($_POST['txtTanggal']);
	$txtKeterangan	= $_POST['txtKeterangan'];
	
	// Validasi
	$pesanError = array();
	if(trim($txtTanggal)=="--") {
		$pesanError[] = "Data <b>Tanggal Kembali</b> belum diisi, pilih pada combo !";		
	}
	if(trim($txtKeterangan)=="") {
		$pesanError[] = "Data <b>Keterangan</b> belum diisi, silahkan diperbaiki !";		
	}
			
	// JIKA ADA PESAN ERROR DARI VALIDASI
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
		
		// Skrip Update status barang (used=keluar/dipakai)
		$txtKode	= $_POST['txtKode'];
		$mySql = "UPDATE peminjaman SET status_kembali='Kembali', tgl_kembali='$txtTanggal' WHERE no_peminjaman='$txtKode'";
		mysql_query($mySql, $koneksidb) or die ("Gagal Query Edit Status : ".mysql_error());
		
		# PROSES SIMPAN DATA PENGEMBALIAN
		// Periksa data Pengembalian, apakah sudah dikembalikan
		$cekSql ="SELECT * FROM pengembalian WHERE no_peminjaman='$txtKode'";
		$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query Tmp : ".mysql_error());
		if(mysql_num_rows($cekQry) >=1) {			
			// Update informasi pengembalian
			$my2Sql	= "UPDATE pengembalian SET tgl_pengembalian = '$txtTanggal', keterangan = '$txtKeterangan', kd_petugas ='$userLogin' 
						WHERE no_peminjaman='$txtKode'";
			$my2Qry=mysql_query($my2Sql, $koneksidb) or die ("Gagal query kembali : ".mysql_error());
		}
		else {
			// Skrip menyimpan Pengembalian
			$kodeBaru = buatKode("pengembalian", "KB");
			$my2Sql	= "INSERT INTO pengembalian (no_pengembalian, tgl_pengembalian, no_peminjaman, keterangan, kd_petugas)
						VALUES ('$kodeBaru', '$txtTanggal', '$txtKode', '$txtKeterangan', '$userLogin')";
			$my2Qry=mysql_query($my2Sql, $koneksidb) or die ("Gagal query kembali : ".mysql_error());
		}
		
		# PROSES MENGEMBALIKAN STATUS BARANG 
		// Membaca daftar Kode Inventaris
		$tmpSql ="SELECT * FROM peminjaman_item WHERE no_peminjaman='$txtKode'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp : ".mysql_error());
		while ($tmpData = mysql_fetch_array($tmpQry)) {
			$kodeInventaris	= $tmpData['kd_inventaris'];
			
			// Skrip Update status barang (used=keluar/dipakai)
			$mySql = "UPDATE barang_inventaris SET status_barang='Tersedia' WHERE kd_inventaris='$kodeInventaris'";
			mysql_query($mySql, $koneksidb) or die ("Gagal Query Edit Status : ".mysql_error());
		}
		
		// Konfirmasi
		echo "<div class='alert alert-success alert-dismissible fade in' role='alert'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>";
		
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div></div> <br>";
		
		// Refresh
		echo "<meta http-equiv='refresh' content='2; url=?open=".md5('peminjaman')."&&data=".md5('all')."'>";
	}	
}

# TAMPILKAN DATA UNTUK DIEDIT
$Kode	 = $_GET['Kode']; 
$mySql = "SELECT * FROM peminjaman WHERE no_peminjaman='$Kode'";
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
$myData= mysql_fetch_array($myQry);

// Variabel data form
$dataTransaksi 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"  name="frmadd">
<table width="900" cellpadding="3" cellspacing="1" class="table-list">
	<tr>
	  <td bgcolor="#F5F5F5"><strong>PENGEMBALIAN</strong></td>
	  <td>&nbsp;</td>
	  <td><input name="txtKode" type="hidden" value="<?php echo $Kode; ?>" /></td>
    </tr>
	<tr>
	  <td width="21%"><strong>No. Peminjaman </strong></td>
	  <td width="1%"><strong>:</strong></td>
	  <td width="78%"><strong><?php echo $myData['no_peminjaman']; ?></strong></td>
	</tr>
	<tr>
      <td><strong>Tgl. Peminjaman </strong></td>
	  <td><strong>:</strong></td>
	  <td><strong><?php echo IndonesiaTgl($myData['tgl_peminjaman']); ?></strong></td>
    </tr>
	<tr>
      <td><strong>Tgl. Kembali </strong></td>
	  <td><strong>:</strong></td>
	  <td>
	  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	  <input type="text" name="txtTanggal" id="single_cal1" placeholder="Masukan Tanggal" aria-describedby="inputSuccess2Status" class="form-control has-feedback-left" />
	  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
	  <span id="inputSuccess2Status4" class="sr-only">(success)</span>
      </div>
	  </td>
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
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>
	  <input name="btnSimpan" type="submit" style="cursor:pointer;" class="btn btn-primary" value=" SIMPAN " />
	  </td>
    </tr>
</table>

<div class="card-box table-responsive">
<table id="datatable-buttons" class="table table-striped table-bordered">
<thead>
  <tr>
    <th width="5px" align="center" ><strong>No</strong></th>
    <th width="40px" ><strong>Kode</strong></th>
    <th width="72px" ><strong>Nama Barang</strong></th>
    <th width="50px" ><strong>Kategori</strong></th>
  </tr>
  </thead>
  <tbody>
<?php
// Qury menampilkan data dalam Grid TMP_peminjaman 
$tmpSql ="SELECT barang.nm_barang, kategori.nm_kategori, peminjaman_item.* 
		FROM  peminjaman_item
			LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris = barang_inventaris.kd_inventaris
			LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
			LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
		WHERE peminjaman_item.no_peminjaman='$Kode'
		ORDER BY barang.kd_barang ";
$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0;  
while($tmpData = mysql_fetch_array($tmpQry)) {
	$nomor++;
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><b><?php echo $tmpData['kd_inventaris']; ?></b></td>
    <td><?php echo $tmpData['nm_barang']; ?></td>
    <td><?php echo $tmpData['nm_kategori']; ?></td>
  </tr>
<?php } ?>
</tbody>
</table>
</div>
</form>
