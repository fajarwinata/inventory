<?php
// Membaca User yang Login
$userLogin	= $_SESSION['SES_LOGIN'];

# HAPUS DAFTAR BARANG DI TMP
if(isset($_GET['Act'])){
	$Act	= $_GET['Act'];
	$ID		= $_GET['ID'];
	
	if(trim($Act)=="Delete"){
		# Hapus Tmp jika datanya sudah dipindah
		$mySql = "DELETE FROM tmp_pengadaan WHERE id='$ID' AND kd_petugas='$userLogin'";
		mysql_query($mySql, $koneksidb) or die ("Gagal menghapus tmp : ".mysql_error());
	}
	if(trim($Act)=="Sucsses"){
		echo "<b>DATA BERHASIL DISIMPAN</b> <br><br>";
	}
}
// =========================================================================

$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
$dataBarang		= isset($_POST['cmbBarang']) ? $_POST['cmbBarang'] : '';
$dataDeskripsi	= isset($_POST['txtDeskripsi']) ? $_POST['txtDeskripsi'] : '';

# TOMBOL TAMBAH DIKLIK
if(isset($_POST['btnTambah'])){
	# Baca variabel Input Barang
		$cmbBarang = $_POST['cmbBarang'];


	$txtDeskripsi	= $_POST['txtDeskripsi'];
	$txtDeskripsi	= str_replace("'","&acute;",$txtDeskripsi);
	
	$txtHargaBeli	= $_POST['txtHargaBeli'];
	$txtHargaBeli	= str_replace("'","&acute;", $txtHargaBeli);
	$txtHargaBeli	= str_replace(".","", $txtHargaBeli);
	
	$txtJumlah		= $_POST['txtJumlah'];

	// Validasi form
	$pesanError = array();
	if (trim($cmbBarang)=="" OR trim($cmbBarang)=="Kosong") {
		$pesanError[] = "Data <b>Nama Barang belum dipilih</b>, harus Anda memilih dari combo";
	}
	if (trim($txtDeskripsi)=="") {
		$pesanError[] = "Data <b>Deskripsi belum diisi</b>, silahkan perbaiki datanya !";		
	}
	if (trim($txtHargaBeli)=="" or ! is_numeric(trim($txtHargaBeli))) {
		$pesanError[] = "Data <b>Harga Barang/ Beli (Rp) belum diisi</b>, silahkan <b>isi dengan angka/ harga pengadaan per unit</b> !";		
	}
	if (trim($txtJumlah)=="" or ! is_numeric(trim($txtJumlah))) {
		$pesanError[] = "Data <b>Jumlah (Qty) belum diisi</b>, silahkan <b>isi dengan angka </b> !";		
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
		# Jika jumlah error pesanError tidak ada, skrip di bawah dijalankan
		// Data yang ditemukan dimasukkan ke keranjang transaksi
		$tmpSql 	= "INSERT INTO tmp_pengadaan (kd_barang, deskripsi, harga_beli, jumlah, kd_petugas) 
					VALUES ('$cmbBarang', '$txtDeskripsi', '$txtHargaBeli', '$txtJumlah','$userLogin')";
		mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());
		
		// kosongkan variabel Input Barang
		$dataBarang		= "";
		$dataDeskripsi	= "";
		$dataHargaBeli	= "";
		$dataJumlah		= "";
		
	}
}
else {
	// kosongkan variabel Input Barang
	$dataBarang		= "";
	$dataDeskripsi	= "";
	$dataHargaBeli	= "";
	$dataJumlah		= "";
}
// ============================================================================

# ========================================================================================================
# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca variabel
	$txtTanggal 	= InggrisTgl($_POST['txtTanggal']);
	$cmbSupplier	= $_POST['cmbSupplier'];
	$cmbJenis		= $_POST['cmbJenis'];
	$txtKeterangan	= $_POST['txtKeterangan'];
			
	// Validasi Form
	$pesanError = array();
	if (trim($txtTanggal)=="--") {
		$pesanError[] = "Data <b>Tgl. Pengadaan</b> belum diisi, pilih pada combo !";		
	}
	if (trim($cmbSupplier)=="Kosong") {
		$pesanError[] = "Data <b> Nama Supplier</b> belum dipilih, silahkan pilih pada combo !";		
	}
	if (trim($cmbJenis)=="Kosong") {
		$pesanError[] = "Data <b> Nama Jenis</b> belum dipilih, silahkan pilih pada combo !";		
	}

	# Validasi jika belum ada satupun data item yang dimasukkan
	$tmpSql ="SELECT COUNT(*) As qty FROM tmp_pengadaan WHERE kd_petugas='$userLogin'";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$tmpData = mysql_fetch_array($tmpQry);
	if ($tmpData['qty'] < 1) {
		$pesanError[] = "<b>DAFTAR BARANG MASIH KOSONG</b>, Daftar item barang yang dibeli belum dimasukan ";
	}
			
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo " <div class='x_content bs-example-popovers'>";
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
		$kodeBaru = buatKode("pengadaan", "BB");
		$mySql	= "INSERT INTO pengadaan (no_pengadaan, tgl_pengadaan, keterangan, kd_supplier, jenis_pengadaan, kd_petugas) 
					VALUES ('$kodeBaru', '$txtTanggal', '$txtKeterangan', '$cmbSupplier', '$cmbJenis', '$userLogin')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			# Ambil semua data barang/barang yang dipilih, berdasarkan petugas yg login
			$tmpSql ="SELECT * FROM tmp_pengadaan WHERE kd_petugas='$userLogin'";
			$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp : ".mysql_error());
			while ($tmpData = mysql_fetch_array($tmpQry)) {
				$dataKode 		= $tmpData['kd_barang'];
				$dataDeskripsi 	= $tmpData['deskripsi'];
				$dataHarga 		= $tmpData['harga_beli'];
				$dataJumlah		= $tmpData['jumlah'];
				
				// Masukkan semua barang/barang dari TMP ke tabel pengadaan detail
				$itemSql	= "INSERT INTO pengadaan_item (no_pengadaan, kd_barang, deskripsi, harga_beli, jumlah) 
								VALUES ('$kodeBaru', '$dataKode', '$dataDeskripsi', '$dataHarga', '$dataJumlah')";
				mysql_query($itemSql, $koneksidb) or die ("Gagal Query Item : ".mysql_error());

				// Update stok (Jumlah barang + jumlah barang masuk)
				$stokSql = "UPDATE barang SET jumlah = jumlah + $dataJumlah WHERE kd_barang='$dataKode'";
				mysql_query($stokSql, $koneksidb) or die ("Gagal Query Update Stok : ".mysql_error());

				# Membuat Kode koleksi Buku
				for($i =1; $i <= $dataJumlah; $i++) {
					// Membuat Kode Label Inventaris baru, menggunakan Fungsi buatKodeKoleksi() dari library/inc.library.php
					$kodeDepan		= $dataKode.".";
					$kodeInventaris = buatKodeKoleksi2("barang_inventaris", $kodeDepan);
					
					// Input data kode Inventaris
					$tgl_masuk	= date('Y-m-d');
					$mySql	= "INSERT INTO barang_inventaris(kd_inventaris, kd_barang, no_pengadaan, tgl_masuk, status_barang) 
								VALUES('$kodeInventaris', '$dataKode', '$kodeBaru', '$tgl_masuk', 'Tersedia')";
					mysql_query($mySql, $koneksidb) or die ("Gagal query inventaris : ".mysql_error());
				}
			}
			
			# Kosongkan Tmp jika datanya sudah dipindah
			$hapusSql = "DELETE FROM tmp_pengadaan WHERE kd_petugas='$userLogin'";
			mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp ".mysql_error());
			
			// Refresh halaman
			echo "<meta http-equiv='refresh' content='0; url=?open=".md5('pengadaan')."&&data=".md5('all')."'>";

			echo "<script>";
			echo "window.open('cetak/pengadaan_cetak.php?noNota=$noTransaksi')";
			echo "</script>";
		}
	}	
}

# TAMPILKAN DATA KE FORM
$noTransaksi 	= buatKode("pengadaan", "BB");
$tglTransaksi 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');

$dataSupplier	= isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : '';

$dataJenis		= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : '';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';

?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"  name="form1">
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
			<div class="x_panel tile">
				<div class="x_title">
					<h2>Tambah Barang Kedalam Transaksi</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="dashboard-widget-content">
							<table width="100%" cellspacing="1" class="table-list" style="margin-top:0px;">
							<tr>
							  <td><strong>Kategori</strong></td>
							  <td><b>:</b></td>
							  <td>
							  <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
							  <select name="cmbKategori" onchange="javascript:submitform();" class="form-control has-feedback-left">
								  <option value="Kosong"> .... </option>
								  <?php
							  $daftarSql = "SELECT * FROM kategori  ORDER BY kd_kategori";
							  $daftarQry = mysql_query($daftarSql, $koneksidb) or die ("Gagal Query".mysql_error());
							  while ($daftarData = mysql_fetch_array($daftarQry)) {
								if ($daftarData['kd_kategori'] == $dataKategori) {
									$cek = " selected";
								} else { $cek=""; }
								echo "<option value='$daftarData[kd_kategori]' $cek> $daftarData[nm_kategori]</option>";
							  }
							  ?>
							  </select>
							  <span class="fa fa-puzzle-piece form-control-feedback left" aria-hidden="true"></span>
							  </div>
								</td>
							</tr>
							<tr>
							  <td><strong>Nama Barang </strong></td>
							  <td><strong>:</strong></td>
							  <td><b>
							  <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
								<select name="cmbBarang" class="form-control has-feedback-left">
								  <?php
							  $mySql = "SELECT * FROM barang WHERE kd_kategori='$dataKategori' ORDER BY nm_barang";
							  $myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
							  while ($myData = mysql_fetch_array($myQry)) {
								if ($dataBarang == $myData['kd_barang']) {
									$cek = " selected";
								} else { $cek=""; }
								echo "<option value='$myData[kd_barang]' $cek> [ $myData[kd_barang] ] $myData[nm_barang]</option>";
							  }
							  ?>
								</select>
								<span class="fa fa-qrcode form-control-feedback left" aria-hidden="true"></span>
								</div>
							  </b><a href="?open=Pencarian-Barang" target="_blank"></a></td>
							</tr>
							<tr>
							  <td><strong>Deskripsi Barang </strong></td>
							  <td><strong>:</strong></td>
							  <td>
							  <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
							  <input name="txtDeskripsi" value="<?php echo $dataDeskripsi; ?>"  class="form-control has-feedback-left" size="80" maxlength="100" />
							  <span class="fa fa-info form-control-feedback left" aria-hidden="true"></span>
							  </div>
							  </td>
							</tr>
							<tr>
							  <td><strong>Harga Barang/ Beli (Rp.) </strong></td>
							  <td><strong>:</strong></td>
							  <td>
									  <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
								<input name="txtHargaBeli"  size="18" maxlength="12" class="form-control has-feedback-left"/>
								 <span class="fa fa-money form-control-feedback left" aria-hidden="true"></span>
										  </div>
								</td>
								</tr>
								<tr>
									<td>Jumlah</td>
									<td>:</td>
									<td>
										<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
										<input name="txtJumlah" maxlength="4" value="1" class="form-control has-feedback-left" />
									<span class="fa fa-sort-numeric-asc form-control-feedback left" aria-hidden="true"></span>
										</div>
										<strong>
								<input name="btnTambah" type="submit" style="cursor:pointer;" class="btn btn-primary" value=" Tambah"  />
										</strong>
									</td>
							</tr>
							<tr>
							  <td>&nbsp;</td>
							  <td>&nbsp;</td>
							  <td>&nbsp;</td>
							</tr>
						</table>

						<table id="datatable-buttons" class="table table-striped table-bordered">
							<thead>
							<tr>
								<th><strong>No</strong></th>
								<th><strong>Kode </strong></th>
								<th><strong>Nama Barang </strong></th>
								<th><strong>Deskripsi</strong></th>
								<th><strong>Harga (Rp) </strong></th>
								<th><strong>Jumlah</strong></th>
								<th><strong>Total Biaya (Rp)</strong></th>
								<th>&nbsp;</th>
							</tr>
							</thead>
							<tbody>
							<?php
							//  tabel menu
							$tmpSql ="SELECT tmp_pengadaan.*, barang.nm_barang FROM tmp_pengadaan, barang
						  WHERE tmp_pengadaan.kd_barang=barang.kd_barang AND tmp_pengadaan.kd_petugas='$userLogin' ORDER BY id";
							$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
							$nomor=0; $subTotal=0; $totalBelanja = 0; $qtyItem = 0;
							while($tmpData = mysql_fetch_array($tmpQry)) {
								$ID			= $tmpData['id'];
								$qtyItem	= $qtyItem + $tmpData['jumlah'];
								$subTotal		= $tmpData['harga_beli'] * $tmpData['jumlah']; // Harga beli dari tabel tmp_pengadaan (harga terbaru yang diinput)
								$totalBelanja	= $totalBelanja + $subTotal;
								$nomor++;
								// gradasi warna
								if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
								?>
								<tr bgcolor="<?php echo $warna; ?>">
									<td align="center"><?php echo $nomor; ?></td>
									<td><?php echo $tmpData['kd_barang']; ?></td>
									<td><?php echo $tmpData['nm_barang']; ?></td>
									<td><?php echo $tmpData['deskripsi']; ?></td>
									<td align="right" bgcolor="<?php echo $warna; ?>"><?php echo format_angka($tmpData['harga_beli']); ?></td>
									<td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $tmpData['jumlah']; ?></td>
									<td align="right" bgcolor="<?php echo $warna; ?>"><?php echo format_angka($subTotal); ?></td>
									<td align="center" bgcolor="#FFFFCC"><a href="?open=<?php echo md5('pengadaan')?>&&Act=Delete&ID=<?php echo $ID; ?>" target="_self">Delete</a></td>
								</tr>

								<?php
							}?>
							<tr>
								<td colspan="5" align="right"><b> GRAND TOTAL : </b></td>
								<td align="right" ><strong><?php echo $qtyItem; ?></strong></td>
								<td align="right" ><strong>Rp. <?php echo format_angka($totalBelanja); ?></strong></td>
								<td align="center" >&nbsp;</td>
							</tr>
							</tbody>
						</table>
					</div>
					</div>
					</div>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" >
						<div class="x_panel tile" style="background:#82fde7; color: #131213">
							<div class="x_title">
								<h2>Simpan Transaksi</h2>

								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<div class="dashboard-widget-content" >
									<table>
										<tr>
											<td width="24%"><strong>No. Pengadaan </strong></td>
											<td width="1%"><strong>:</strong></td>
											<td width="75%">
												<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
													<input name="txtNomor" value="<?php echo $noTransaksi; ?>" class="form-control has-feedback-left" maxlength="20" readonly="readonly"/>
													<span class="fa fa-check-square-o form-control-feedback left" aria-hidden="true"></span>
												</div>
											</td></tr>
										<tr>
											<td><strong>Tgl.  Pengadaan </strong></td>
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
											<td><strong>Supplier (Asal Barang) </strong></td>
											<td><strong>:</strong></td>
											<td><b>
													<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
														<select name="cmbSupplier" class="form-control has-feedback-left">
															<option value="Kosong">....</option>
															<?php
															$mySql = "SELECT * FROM supplier ORDER BY kd_supplier";
															$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
															while ($myData = mysql_fetch_array($myQry)) {
																if ($dataSupplier == $myData['kd_supplier']) {
																	$cek = " selected";
																} else { $cek=""; }
																echo "<option value='$myData[kd_supplier]' $cek>[ $myData[kd_supplier] ] $myData[nm_supplier]</option>";
															}
															?>
														</select>
														<span class="fa fa-cubes form-control-feedback left" aria-hidden="true"></span>
													</div>
												</b></td>
										</tr>
										<tr>
											<td><strong>Jenis Pengadaan </strong></td>
											<td><strong>:</strong></td>
											<td><b>
													<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
														<select name="cmbJenis" class="form-control has-feedback-left">
															<option value="Kosong">....</option>
															<?php
															include_once "../library/inc.pilihan.php";
															foreach ($jenisPengadaan as $nilai) {
																if ($dataJenis == $nilai) {
																	$cek=" selected";
																} else { $cek = ""; }
																echo "<option value='$nilai' $cek>$nilai</option>";
															}
															?>
														</select>
														<span class="fa fa-cogs form-control-feedback left" aria-hidden="true"></span>
													</div>
												</b></td>
										</tr>
										<tr>
											<td><strong>Keterangan</strong></td>
											<td><strong>:</strong></td>
											<td>
												<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
													<input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" class="form-control has-feedback-left" maxlength="100" />
													<span class="fa fa-info form-control-feedback left" aria-hidden="true"></span>
												</div>
											</td>
										</tr>

										<tr>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
											<td>


												<span class="fa fa-info left" aria-hidden="true"></span>
												<h4>Resume</h4>
												<p>Jumlah Barang Dalam Transaksi <b><?php echo $qtyItem; ?></b></p></td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td>&nbsp;</td>

											<td><input name="btnSimpan" type="submit" style="cursor:pointer;" class="btn btn-success" value=" SIMPAN TRANSAKSI " />

											</td>
										</tr>
									</table>
								</div>
								</div>
								</div>
								</div>


		</div>
</form>
  
<script>
function submitform() {
	document.form1.submit();
}
</script>


