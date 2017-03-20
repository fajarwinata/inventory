<?php
// Variabel SQL
$filterSQL= "";

// Temporary Variabel form
$Dept			= isset($_GET['Dept']) ? $_GET['Dept'] : 'Kosong'; // dari URL
$dataDepartemen	= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $Dept; // dari Form

if (trim($dataDepartemen) =="Kosong") {
	$filterSQL = "";
}
else {
	$filterSQL = "WHERE lokasi.kd_departemen='$dataDepartemen'";
}

# Tombol Simpan diklik
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtNama		= $_POST['txtNama'];
	$txtNama		= str_replace("'","&acute;",$txtNama); // menghalangi penulisan tanda petik satu (')
	$cmbDepartemen	= $_POST['cmbDepartemen'];
	
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Lokasi</b> tidak boleh kosong !";		
	}
	if (trim($cmbDepartemen)=="Kosong") {
		$pesanError[] = "Data <b>Departemen</b> belum dipilih, silahkan pilih pada Combo !";		
	}
	
	# Validasi Nama lokasi, jika sudah ada akan ditolak
	$cekSql="SELECT * FROM lokasi WHERE kd_departemen='$cmbDepartemen' AND nm_lokasi='$txtNama'";
	$cekQry=mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($cekQry)>=1){
		$pesanError[] = "Maaf, Nama Lokasi : <b> $txtNama </b> sudah ada, ganti dengan yang lain";
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
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database
		$kodeBaru	= buatKode("lokasi", "L");
		$mySql	= "INSERT INTO lokasi (kd_lokasi, nm_lokasi, kd_departemen) VALUES ('$kodeBaru', '$txtNama', '$cmbDepartemen')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Lokasi-Data'>";
		}
		exit;
	}	
} // Penutup Tombol Simpan

# MASUKKAN DATA KE VARIABEL
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
$dataKode	= buatKode("lokasi", "L");
$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataDepartemen	= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : '';
?>
<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Data Lokasi <small>&nbsp;</small></h2>
					<button type="button" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg">Tambah Lokasi</button>
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
				  <select name="cmbDepartemen" class="form-control">
					  <option value="Kosong">Pilih Departemen...</option>
					  <?php
					  // Skrip menampilkan data Departemen dalam ComboBox
				  $dataSql = "SELECT * FROM departemen ORDER BY kd_departemen";
				  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
				  while ($dataRow = mysql_fetch_array($dataQry)) {
					if ($dataRow['kd_departemen'] == $dataDepartemen) {
						$cek = " selected";
					} else { $cek=""; }
					echo "<option value='$dataRow[kd_departemen]' $cek>$dataRow[nm_departemen]</option>";
				  }
				  ?>
				  </select>
				  </div>
				  <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">	
				  
				  <input name="btnTampil" type="submit" value=" Filter " class="btn btn-info" />
				  
				  </div>
				  </form>
				  
                  <div class="x_content">
				  
				  <div class="card-box table-responsive">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th width="25"><b>No</b></th>
							<th width="50">Kode</th>
							<th width="124"><b>Nama Lokasi </b></th>
							<th width="100"><b>Departemen </b></th>
							<th width="100">&nbsp;</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
	  // Menampilkan data Lokasi, dilengkapi dengan data Departemen dari tabel relasi
	$mySql = "SELECT lokasi.*, departemen.nm_departemen FROM lokasi 
				LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
				$filterSQL
				ORDER BY kd_lokasi ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
		$nomor	= 0;
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_lokasi'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
     <tr bgcolor="<?php echo $warna; ?>">
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_lokasi']; ?></td>
        <td><?php echo $myData['nm_lokasi']; ?></td>
        <td><?php echo $myData['nm_departemen']; ?></td>
        <td width="41" align="center">
		<a href="?open=Lokasi-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" 
				onclick="return confirm('YAKIN AKAN MENGHAPUS DATA LOKASI INI ... ?')" class="btn btn-danger"> Delete</a>
		<a href="?open=Lokasi-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data" class="btn btn-info"> Edit</a></td>
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
                          <h4 class="modal-title" id="myModalLabel"><img src="images/inv_icn_m5.png" class="img-circle" width="46px"/> Tambah Lokasi</h4>
                        </div>
                        <div class="modal-body">
                          
						  <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
								  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								  <input name="textfield" type="text" value="<?php echo $dataKode; ?>" class="form-control has-feedback-left" size="10" maxlength="6" readonly="readonly"/>							
								  <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
								  </div>
								  
								  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								  <input name="txtNama" type="text" value="<?php echo $dataNama; ?>" class="form-control has-feedback-right" placeholder="Nama Lokasi"/>
								  <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
								  </div>
								  			
								 <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">				
								  <select name="cmbDepartemen" class="form-control">
								  <option value="Kosong">Pilih Departemen</option>
								  <?php
								  // Menampilkan data Departemen
								$mySql = "SELECT * FROM departemen ORDER BY kd_departemen";
								$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
								while ($myData = mysql_fetch_array($myQry)) {
								if ($myData['kd_departemen']== $dataDepartemen) {
									$cek = " selected";
								} else { $cek=""; }
								echo "<option value='$myData[kd_departemen]' $cek>$myData[nm_departemen] </option>";
								}
								?>
							  </select>
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

