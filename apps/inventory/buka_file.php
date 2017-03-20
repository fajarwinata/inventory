<?php
# KONTROL MENU PROGRAM
if($_GET) {
	// Jika mendapatkan variabel URL ?page
	switch($_GET['open']){
			
		case 'Login' :
			if(!file_exists ("login.php")) die ("File tidak ditemukan !"); 
			include "login.php"; break;
			
		case 'Login-Validasi' :
			if(!file_exists ("login_validasi.php")) die ("File tidak ditemukan !"); 
			include "login_validasi.php"; break;
			
		case 'Logout' :
			if(!file_exists ("login_out.php")) die ("File tidak ditemukan !"); 
			include "login_out.php"; break;		

		# PETUGAS / USER LOGIN (Admin, Petugas)

		case 'Petugas-Delete' :
			if(!file_exists ("proses/petugas_delete.php")) die ("File tidak ditemukan !"); 
			include "proses/petugas_delete.php"; break;		

		# PEGAWAI

		case 'Pegawai-Delete' :
			if(!file_exists ("proses/pegawai_delete.php")) die ("File tidak ditemukan !"); 
			include "proses/pegawai_delete.php"; break;

		# DEPARTEMEN

		case 'Departemen-Delete' :
			if(!file_exists ("proses/departemen_delete.php")) die ("File tidak ditemukan !"); 
			include "proses/departemen_delete.php"; break;		

		# LOKASI / RUANG

		case 'Lokasi-Delete' :
			if(!file_exists ("proses/lokasi_delete.php")) die ("File tidak ditemukan !"); 
			include "proses/lokasi_delete.php"; break;		

		# KATEGORI / PENGELOMPOKAN JENIS BARANG

		case 'Kategori-Delete' :
			if(!file_exists ("proses/kategori_delete.php")) die ("File tidak ditemukan !"); 
			include "proses/kategori_delete.php"; break;		

		# BARANG / PRODUK YANG DIJUAL

		case 'Barang-Delete' :
			if(!file_exists ("proses/barang_delete.php")) die ("File tidak ditemukan !"); 
			include "proses/barang_delete.php"; break;

		case 'Barang-View' :
			if(!file_exists ("barang_view.php")) die ("File tidak ditemukan !"); 
			include "barang_view.php"; break;
			

		# SUPPLIER (PEMASOK)

		case 'Supplier-Delete' :
			if(!file_exists ("proses/supplier_delete.php")) die ("File tidak ditemukan !"); 
			include "proses/supplier_delete.php"; break;


		   #TRANSAKSI
			case md5('pengadaan-hapus') :
				if(!file_exists ("proses/pengadaan_hapus.php")) die ("File tidak ditemukan !");
				include "proses/pengadaan_hapus.php"; break;	
			case md5('penempatan-hapus') :
				if(!file_exists ("proses/penempatan_hapus.php")) die ("File tidak ditemukan !");
				include "proses/penempatan_hapus.php"; break;
			case md5('mutasi-hapus') :
				if(!file_exists ("proses/mutasi_hapus.php")) die ("File tidak ditemukan !");
				include "proses/mutasi_hapus.php"; break;
			case md5('peminjaman-hapus') :
				if(!file_exists ("proses/peminjaman_hapus.php")) die ("File tidak ditemukan !");
				include "proses/peminjaman_hapus.php"; break;

		default:
			if(!file_exists ("main.php")) die ("Empty Main Page!"); 
			include "main.php";						
		break;
	}

}
else {
	// Jika tidak mendapatkan variabel URL : ?open
	if(!file_exists ("main.php")) die ("Empty Main Page!"); 
	include "main.php";	
}
?>