<?php
# Tombol Simpan diklik
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtNama		= $_POST['txtNama'];
	$cmbKelamin		= $_POST['cmbKelamin'];
	$txtAlamat		= $_POST['txtAlamat'];
	$txtTelepon		= $_POST['txtTelepon'];
	
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Pegawai</b> tidak boleh kosong, silahkan dilengkapi !";		
	}
	if (trim($cmbKelamin)=="Kosong") {
		$pesanError[] = "Data <b>Kelamin</b> belum dipilih, silahkan pilih pada Combo !";		
	}
	if (trim($txtAlamat)=="") {
		$pesanError[] = "Data <b>Alamat Lengkap</b> tidak boleh kosong, silahkan dilengkapi !";		
	}
	if (trim($txtTelepon)=="") {
		$pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong, silahkan dilengkapi !";		
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
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database	
		$kodeBaru	= buatKode("pegawai", "P");
		$mySql	= "INSERT INTO pegawai (kd_pegawai, nm_pegawai, jns_kelamin, alamat, no_telepon) 
					VALUES ('$kodeBaru',
							'$txtNama',
							'$cmbKelamin',
							'$txtAlamat',
							'$txtTelepon')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Pegawai-Data'>";
		}
		exit;
	}	
} // Penutup Tombol Simpan
	
# MASUKKAN DATA DARI FORM KE VARIABEL TEMPORARY (SEMENTARA)
$dataKode	= buatKode("pegawai", "P");
$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataKelamin= isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : '';
$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
$dataTelepon= isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : '';
?>
<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Data Pegawai <small>&nbsp;</small></h2>
					<button type="button" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg">Tambah Pegawai</button>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
				  <div class="card-box table-responsive">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th width="25"><b>No</b></th>
							<th width="50">Kode</th>
							<th width="124"><b>Nama Pegawai </b></th>
							<th width="40"><b>Gender </b></th>
							<th width="332"><b>Alamat</b></th>
							<th width="100">&nbsp;</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
	  // Skrip menampilkan data Petugas
	$mySql 	= "SELECT * FROM pegawai ORDER BY kd_pegawai ASC";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_pegawai'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_pegawai']; ?></td>
        <td><?php echo $myData['nm_pegawai']; ?></td>
        <td><?php echo $myData['jns_kelamin']; ?></td>
        <td><?php echo $myData['alamat']; ?></td>
        <td width="40" align="center"><a href="?open=Pegawai-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" 
				onclick="return confirm('YAKIN AKAN MENGHAPUS DATA PEGAWAI INI ... ?')" class="btn btn-danger">Delete</a>
		<a href="?open=Pegawai-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data" class="btn btn-info">Edit</a></td>
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
                          <h4 class="modal-title" id="myModalLabel"><img src="images/inv_icn_m2.png" class="img-circle" width="46px"/> Tambah Pegawai</h4>
                        </div>
                        <div class="modal-body">
                          
						  <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
								  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								  <input name="textfield" type="text" value="<?php echo $dataKode; ?>" class="form-control has-feedback-left" size="10" maxlength="6" readonly="readonly"/>							
								  <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
								  </div>
								  
								  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								  <input name="txtNama" type="text" value="<?php echo $dataNama; ?>" class="form-control has-feedback-right" placeholder="Nama Pegawai"/>
								  <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
								  </div>
								 								  
								  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								  <input name="txtAlamat" value="<?php echo $dataAlamat; ?>" class="form-control has-feedback-left" placeholder="Alamat" />
								  <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
								  </div>
								  
									<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
									<select name="cmbKelamin" class="form-control" required>
									  <?php
									  $pilihan	= array("Laki-laki", "Perempuan");
									  foreach ($pilihan as $nilai) {
										if ($dataKelamin==$nilai) {
											$cek=" selected";
										} else { $cek = ""; }
										echo "<option value='$nilai' $cek>$nilai</option>";
									  }
									  ?>
									</select>
								  </div>
								  
								  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								  <input name="txtTelepon" value="<?php echo $dataTelepon; ?>" class="form-control has-feedback-left" placeholder="Telepon" />
								  <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
								  </div>
								  
						  
						  
						  </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <input type="submit" name="btnSimpan" class="btn btn-primary" value="Simpan"/>
                        </div>
						</form>

                      </div>
                    </div>
                  </div>

			
