<?php
// Variabel SQL
$filterSQL= "";

// Temporary Variabel form
$Kat			= isset($_GET['Kat']) ? $_GET['Kat'] : 'Semua'; // dari URL
$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $Kat; // dari Form

// Membuat SQL Filter data
if (trim($dataKategori) =="Semua") {
	$filterSQL = "";
}
else {
	$filterSQL = "WHERE barang.kd_kategori='$dataKategori'";
}

# TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtNama		= $_POST['txtNama'];
	$txtNama		= str_replace("'","&acute;",$txtNama); // menghalangi penulisan tanda petik satu (')
	
	$txtKeterangan	= $_POST['txtKeterangan'];
	$txtKeterangan	= str_replace("'","&acute;",$txtKeterangan); // menghalangi penulisan tanda petik satu (')
	
	$txtMerek		= $_POST['txtMerek'];
	$txtMerek		= str_replace("'","&acute;",$txtMerek); // menghalangi penulisan tanda petik satu (')
	
	$cmbSatuan		= $_POST['cmbSatuan'];
	$cmbKategori	= $_POST['cmbKategori'];

	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Barang</b> tidak boleh kosong !";		
	}
	if (trim($txtKeterangan)=="") {
		$pesanError[] = "Data <b>Keterangan</b> tidak boleh kosong !";		
	}
	if (trim($txtMerek)=="") {
		$pesanError[] = "Data <b>Merek</b> tidak boleh kosong !";		
	}
	if (trim($cmbSatuan)=="Kosong") {
		$pesanError[] = "Data <b>Satuan Barang</b> belum dipilih !";		
	}
	if (trim($cmbKategori)=="Kosong") {
		$pesanError[] = "Data <b>Kategori Barang</b> belum dipilih !";		
	}
		
	# Validasi Nama barang, jika sudah ada akan ditolak
	$sqlCek="SELECT * FROM barang WHERE nm_barang='$txtNama'";
	$qryCek=mysql_query($sqlCek, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($qryCek)>=1){
		$pesanError[] = "Maaf, Nama Barang <b> $txtNama </b> sudah dipakai, ganti dengan yang lain";
	}


	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# SIMPAN DATA KE DATABASE. // Jika tidak menemukan error, simpan data ke database
		$kodeBarang	= buatKode("barang", "B");
		$mySql	= "INSERT INTO barang (kd_barang, nm_barang, keterangan, merek, satuan, jumlah, kd_kategori) 
							VALUES ('$kodeBarang',
									'$txtNama',
									'$txtKeterangan',
									'$txtMerek',
									'$cmbSatuan',
									'0',
									'$cmbKategori')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){		
			echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Data'>";
		}
		exit;
	}

} // Penutup POST
	
# MASUKKAN DATA KE VARIABEL
$dataKode		= buatKode("barang", "B");
$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataMerek		= isset($_POST['txtMerek']) ? $_POST['txtMerek'] : '';
$dataSatuan		= isset($_POST['cmbSatuan']) ? $_POST['cmbSatuan'] : '';
$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
?>
<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Data Barang <small>&nbsp;</small></h2>
					<button type="button" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg">Tambah Barang</button>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
					
					  <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
						  <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
						  <select name="cmbKategori" class=" form-control">
							  <option value="Semua">Pilih Kategori</option>
							  <?php
							  // Menampilkan data Kategori
						  $dataSql = "SELECT * FROM kategori ORDER BY kd_kategori";
						  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
						  while ($dataRow = mysql_fetch_array($dataQry)) {
							if ($dataRow['kd_kategori'] == $dataKategori) {
								$cek = " selected";
							} else { $cek=""; }
							echo "<option value='$dataRow[kd_kategori]' $cek>$dataRow[nm_kategori]</option>";
						  }
						  ?>
						  </select>
						  </div>
							  <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
						  <input name="btnTampil" type="submit" class="btn btn-info" value=" Filter " />
							  </div>
					  </form>
					  
					  
                  <div class="x_content">
					  
				  <div class="card-box table-responsive">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th width="25"><b>No</b></th>
							<th width="50">Kode</th>
							<th width="124"><b>Nama Barang </b></th>
							<th width="50"><b>Merek</b></th>
							<th width="25">Jumlah</th>
							<th width="100">&nbsp;</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
						  // Menampilkan daftar kategori
						$mySql = "SELECT * FROM barang $filterSQL ORDER BY kd_barang ASC";
						$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
						$nomor = 0; 
						while ($myData = mysql_fetch_array($myQry)) {
							$nomor++;
							$Kode = $myData['kd_barang'];

							// gradasi warna
							if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
						?>
     <tr bgcolor="<?php echo $warna; ?>">
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_barang']; ?></td>
        <td><?php echo $myData['nm_barang']; ?></td>
        <td><?php echo $myData['merek']; ?></td>
        <td align="center"><?php echo format_angka($myData['jumlah'])." ". $myData['satuan']; ?></td>
        <td width="41" align="center">
		<a href="?open=Barang-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" 
				onclick="return confirm('YAKIN AKAN MENGHAPUS DATA BARANG INI ... ?')" class="btn btn-danger"> Delete</a>
		<a href="?open=Barang-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data" class="btn btn-info"> Edit</a></td>
      </tr>
      <?php } ?>
                      </tbody>
                    </table>
					</div>
                  </div>
                </div>
              </div>
            </div>

		<!--MODAL-->
			<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel"><img src="images/inv_icn_m7.png" class="img-circle" width="46px"/> Tambah Barang</h4>
                        </div>
                        <div class="modal-body">
                          
						  <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
								  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								  <input name="textfield" type="text" value="<?php echo $dataKode; ?>" class="form-control has-feedback-left" size="10" maxlength="6" readonly="readonly"/>							
								  <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
								  </div>
								  
								  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								  <input name="txtNama" type="text" value="<?php echo $dataNama; ?>" class="form-control has-feedback-right" placeholder="Nama Barang"/>
								  <span class="fa fa-file-archive-o form-control-feedback right" aria-hidden="true"></span>
								  </div>
							  
							  	  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								  <input name="txtKeterangan" type="text" value="<?php echo $dataKeterangan; ?>" class="form-control has-feedback-right" placeholder="Keterangan"/>
								  <span class="fa fa-info form-control-feedback right" aria-hidden="true"></span>
								  </div>
							  
							  	  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								  <input name="txtMerek" type="text" value="<?php echo $dataMerek; ?>" class="form-control has-feedback-right" placeholder="Merek"/>
								  <span class="fa fa-institution form-control-feedback right" aria-hidden="true"></span>
								  </div>
							  
							  	  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								  <select name="cmbSatuan" class="form-control">
									  <option value="Kosong">Pilih Satuan</option>
									  <?php
									  // Menampilkan data Satuan  ke comboBox, satuan ada pada file library/inc.pilihan.php
									  include_once "library/inc.pilihan.php";
									  foreach ($satuan as $nilai) {
										if ($dataSatuan == $nilai) {
											$cek=" selected";
										} else { $cek = ""; }
										echo "<option value='$nilai' $cek>$nilai</option>";
									  }
									  ?>
								 </select>
								  
								  </div>
							  
							    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								  <select name="cmbKategori" class="form-control">
									  <option value="Kosong">Pilih Kategori</option>
										  <?php
										  // Menampilkan data kategori ke comboBox
										$mySql = "SELECT * FROM kategori ORDER BY nm_kategori";
										$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
										while ($myData = mysql_fetch_array($myQry)) {
										if ($myData['kd_kategori']== $dataKategori) {
											$cek = " selected";
										} else { $cek=""; }
										echo "<option value='$myData[kd_kategori]' $cek>$myData[nm_kategori] </option>";
										}
										?>
								 	  </select>
								 </div>
							     
							
							  	
							  
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <input type="submit" name="btnSimpan" class="btn btn-primary" value="Simpan"/>
                        </div>
						</form>

                      </div>
                    </div>
                  </div>

