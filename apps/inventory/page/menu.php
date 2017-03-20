<?php
if(isset($_SESSION['SES_ADMIN'])){
# JIKA YANG LOGIN LEVEL ADMIN, menu di bawah yang dijalankan
?>
<ul class="nav side-menu">
	<li><a href="?open"><i class="fa fa-home"></i> Beranda <span class="label label-success pull-right">Dashboard</span></a></li>
	<li><a><i class="fa fa-table"></i> Master Data <span class="fa fa-chevron-down"></span></a>
                    	
                    	<?php  
						$class = "class='current-page'";
						?>
                    	<ul class="nav child_menu" <?php if($_GET['open'] == "Petugas-Data" | $_GET['open'] == "Pegawai-Data" | $_GET['open'] == "Supplier-Data" | $_GET['open'] == "Supplier-Data" | $_GET['open'] == "Departemen-Data" | $_GET['open'] == "Lokasi-Data" | $_GET['open'] == "Kategori-Data" | $_GET['open'] == "Barang-Data") echo "style='display: block;'" ?> >
						<li <?php if($_GET['open'] == "Petugas-Data") echo $class; ?> ><a href='?open=Petugas-Data' title='Petugas'>Data Petugas</a></li>
						<li <?php if($_GET['open'] == "Pegawai-Data") echo $class; ?> ><a href='?open=Pegawai-Data' title='Pegawai'>Data Pegawai</a></li>
						<li <?php if($_GET['open'] == "Supplier-Data") echo $class; ?> ><a href='?open=Supplier-Data' title='Supplier'>Data Supplier</a></li>
						<li <?php if($_GET['open'] == "Departemen-Data") echo $class; ?> ><a href='?open=Departemen-Data' title='Departemen'>Data Departemen</a></li>
						<li <?php if($_GET['open'] == "Lokasi-Data") echo $class; ?> ><a href='?open=Lokasi-Data' title='Lokasi'>Data Lokasi</a></li>
						<li <?php if($_GET['open'] == "Kategori-Data") echo $class; ?> ><a href='?open=Kategori-Data' title='Kategori'>Data Kategori</a></li>
						<li <?php if($_GET['open'] == "Barang-Data") echo $class; ?> ><a href='?open=Barang-Data' title='Barang'>Data Barang</a></li>
						</ul>
						
	</li>
	<li><a><i class="fa fa-edit"></i> Transaksi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" <?php if($_GET['open'] == md5('penyusutan') | $_GET['open'] == md5('pengadaan') | $_GET['open'] == md5('penempatan') | $_GET['open'] == md5('mutasi') | $_GET['open'] == md5('peminjaman')) echo "style='display: block;'" ?>>
						<li <?php if($_GET['open'] == md5('pengadaan')) echo $class; ?> ><a href='?open=<?php echo md5('pengadaan')?>' title='Transaksi Pengadaan' >Transaksi Pengadaan</a> </li>
						<li <?php if($_GET['open'] == md5('penempatan')) echo $class; ?> ><a href='?open=<?php echo md5('penempatan')?>' title='Transaksi Penempatan'>Transaksi Penempatan</a> </li>
						<li <?php if($_GET['open'] == md5('mutasi')) echo $class; ?> ><a href='?open=<?php echo md5('mutasi')?>' title='Transaksi Mutasi' >Transaksi Mutasi</a> </li>
						<li <?php if($_GET['open'] == md5('peminjaman')) echo $class; ?> ><a href='?open=<?php echo md5('peminjaman')?>' title='Transaksi Peminjaman' >Transaksi Peminjaman</a> </li>
						<li <?php if($_GET['open'] == md5('jual')) echo $class; ?> ><a href='?open=<?php echo md5('jual')?>' title='Transaksi Jual Barang' >Transaksi Jual Barang</a> </li>
						<li <?php if($_GET['open'] == md5('penyusutan')) echo $class; ?> ><a href='?open=<?php echo md5('penyusutan')?>' title='Penyusutan Harga Barang'>Penyusutan Harga Barang</a> </li>
						<li <?php if($_GET['open'] == md5('rusak')) echo $class; ?> ><a href='?open=<?php echo md5('rusak')?>' title='Transaksi Barang Rusak' >Reg. Barang Rusak</a> </li>
					</ul>
					
	</li>				
	<li <?php if($_GET['open'] == 'Cetak-Barcode') echo $class; ?>><a href='?open=Cetak-Barcode' title='Cetak Barcode'><i class="fa fa-print"></i> Cetak Label Barang</a></li>
	<li <?php if($_GET['open'] == 'Laporan-Cetak') echo $class; ?>><a href='?open=Laporan-Cetak' title='Laporan'><i class="fa fa-print"></i> Laporan &amp; Cetak Data</a></li>
	<li <?php if($_GET['open'] == 'Backup-Restore') echo $class; ?>><a href='?open=Backup-Restore' title='Restore-Backup'><i class="fa fa-database"></i> Backup &amp; Restore All Data</a></li>

</ul>
<?php
}
elseif(isset($_SESSION['SES_PETUGAS'])){
# JIKA YANG LOGIN LEVEL PETUGAS, menu di bawah yang dijalankan
?>
<ul class="nav side-menu">
<li><a href="?open"><i class="fa fa-home"></i> Beranda <span class="label label-success pull-right">Dashboard</span></a></li>
<li><a><i class="fa fa-edit"></i> Transaksi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: block;">
						<li><a href='?open=<?php echo md5('penyusutan')?>' title='Penyusutan Harga Barang'>Penyusutan Harga Barang</a> </li>
						<li><a href='?open=<?php echo md5('pengadaan')?>' title='Transaksi Pengadaan' >Transaksi Pengadaan</a> </li>
						<li><a href='?open=<?php echo md5('penempatan')?>' title='Transaksi Penempatan'>Transaksi Penempatan</a> </li>
						<li><a href='?open=<?php echo md5('mutasi')?>' title='Transaksi Mutasi' >Transaksi Mutasi</a> </li>
						<li><a href='?open=<?php echo md5('peminjaman')?>' title='Transaksi Peminjaman' >Transaksi Peminjaman</a> </li>
					</ul>
	</li>
	</ul>				
<?php
}
else {
# JIKA BELUM LOGIN (BELUM ADA SESION LEVEL YG DIBACA)
?>
<!--<ul>
	<li><a href='?open=Login' title='Login System'>Login</a></li>	
</ul>-->
<?php
}
?>