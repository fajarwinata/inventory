<?php
include_once "../library/inc.seslogin.php";

// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
if(isset($_GET['Kode'])){
	$Kode	= $_GET['Kode'];
	
	# VALIDASI
	$pesanError = array();
	
	// Baca data Kode Inventaris dari Pengadaan yang akan dihapus
	// Jika ternata Kode/Barang sudah ada yang Ditempatkan, atau ditempatkan, maka Penghapusan Gagal (Tidak diijinkan)
	$cekSql	= "SELECT * FROM penempatan_item, barang_inventaris WHERE penempatan_item.kd_inventaris = barang_inventaris.kd_inventaris
				AND barang_inventaris.no_pengadaan='$Kode'";
	$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query Cek 1 : ".mysql_error());
	if(mysql_num_rows($cekQry) >=1 ) {
		$qtyPenempatan	= mysql_num_rows($cekQry);
		
		$pesanError[] = "<b>Ada $qtyPenempatan Barang yang sudah Ditempatkan</b>, sehingga penghapusan dibatalkan !";	
	}
	
	// Baca data Kode Inventaris dari Pengadaan yang akan dihapus
	// Jika ternata Kode/Barang sudah ada yang dipinjam, atau ditempatkan, maka Penghapusan Gagal (Tidak diijinkan)
	$cekSql	= "SELECT * FROM peminjaman_item, barang_inventaris WHERE peminjaman_item.kd_inventaris = barang_inventaris.kd_inventaris
				AND barang_inventaris.no_pengadaan='$Kode'";
	$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query Cek 1 : ".mysql_error());
	if(mysql_num_rows($cekQry) >=1 ) {
		$qtyPeminjaman	= mysql_num_rows($cekQry);
		
		$pesanError[] = "<b>Ada $qtyPeminjaman Barang yang sudah Dipinjam</b>, sehingga penghapusan dibatalkan !";	
	}

	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
		
		// Refresh halaman
		echo "<meta http-equiv='refresh' content='2; url=?open=Pengadaan-Tampil'>";
	}
	else {
		# JIKA TIDAK MENEMUKAN ERROR

		// Hapus data pada tabel anak (pengadaan_item)
		$hapusSql = "DELETE FROM pengadaan_item WHERE no_pengadaan='$Kode'";
		mysql_query($hapusSql, $koneksidb) or die ("Eror hapus data 1 ".mysql_error());
		
		// Hapus data pada tabel barang (barang_inventaris)
		$hapus2Sql = "DELETE FROM  barang_inventaris WHERE no_pengadaan='$Kode'";
		mysql_query($hapus2Sql, $koneksidb) or die ("Eror hapus data 2 ".mysql_error());

		// Hapus data sesuai Kode yang didapat di URL
		$hapus3Sql = "DELETE FROM pengadaan WHERE no_pengadaan='$Kode'";
		mysql_query($hapus3Sql, $koneksidb) or die ("Eror hapus data 3 ".mysql_error());
		
		// Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?open=Pengadaan-Tampil'>";
	}
}
else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
?>
