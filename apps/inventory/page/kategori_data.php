<?php
include_once "library/inc.seslogin.php";

# Tombol Simpan diklik
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtNama= $_POST['txtNama'];
	
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Kategori</b> tidak boleh kosong !";		
	}
	
	# Validasi Nama Kategori, jika sudah ada akan ditolak
	$cekSql="SELECT * FROM kategori WHERE nm_kategori='$txtNama'";
	$cekQry=mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($cekQry)>=1){
		$pesanError[] = "Maaf, Nama Kategori <b> $txtNama </b> sudah ada, ganti dengan yang lain";
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
		$kodeBaru	= buatKode("kategori", "K");
		$mySql	= "INSERT INTO kategori (kd_kategori, nm_kategori) VALUES ('$kodeBaru','$txtNama')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Kategori-Data'>";
		}
		exit;
	}	
} // Penutup Tombol Simpan

# MASUKKAN DATA KE VARIABEL
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
$dataKode	= buatKode("kategori", "K");
$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
?>
<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Data Kategori Barang <small>&nbsp;</small></h2>
					<button type="button" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg">Tambah Kategori</button>
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
							<th width="124"><b>Kategori </b></th>
							<th width="25"><b>QTY Barang</b></th>
							<th width="100">&nbsp;</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
	  // Menampilkan daftar kategori
	$mySql = "SELECT * FROM kategori ORDER BY kd_kategori ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_kategori'];
		
		// Menghitung jumlah barang per Kategori
		$my2Sql = "SELECT COUNT(*) As qty_barang FROM barang WHERE kd_kategori='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
     <tr bgcolor="<?php echo $warna; ?>">
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_kategori']; ?></td>
        <td><?php echo $myData['nm_kategori']; ?></td>
        <td align="right"><?php echo $my2Data['qty_barang']; ?> Unit</td>
        <td width="41" align="center">
		<a href="?open=Kategori-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" 
				onclick="return confirm('YAKIN AKAN MENGHAPUS DATA KETGORI INI ... ?')" class="btn btn-danger"> Delete</a>
		<a href="?open=Kategori-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data" class="btn btn-info"> Edit</a></td>
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
                          <h4 class="modal-title" id="myModalLabel"><img src="images/inv_icn_m6.png" class="img-circle" width="46px"/> Tambah Kategori</h4>
                        </div>
                        <div class="modal-body">
                          
						  <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
								  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								  <input name="textfield" type="text" value="<?php echo $dataKode; ?>" class="form-control has-feedback-left" size="10" maxlength="6" readonly="readonly"/>							
								  <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
								  </div>
								  
								  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								  <input name="txtNama" type="text" value="<?php echo $dataNama; ?>" class="form-control has-feedback-right" placeholder="Nama Kategori"/>
								  <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
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

