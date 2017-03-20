<?php
if(isset($_POST['submit']))
{

	$tgl=date("_d-m-Y");
	$nama_file= "database/backup/Backup_".$myDbs.$tgl;

	exec("$sqlbin --host=$myHost --user=$myUser --password=$myPass $myDbs > $nama_file.sql", $output, $return);
	
	if(!$return){
		?>
		<div class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
		<i class="fa fa-database"></i>
        <strong>Success!!</strong> Database berhasil di Backcup dan disimpan dalam folder /database/backup/.
        </div>	
	<?php
	} 
	else{
		?>
		<div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
		<i class="fa fa-database"></i>
        <strong>Error!!</strong> Database Gagal di Backcup.
        </div>
		<?php
	}
}
?>
<div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-align-left"></i> PUSAT BACKUP / RECOVERY DATABASE <small>(Mod. Ver. Alfa1.1)</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-download"></i></a>
                        
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <!-- start accordion -->
                    <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                      <div class="panel">
                        <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          <h4 class="panel-title"><i class="fa fa-database"></i> <i class="fa fa-download"></i> BACKUP DATABASE</h4>
                        </a>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne" aria-expanded="true" style="">
                          <div class="panel-body">
                            <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
							<p>Klik Tombol Backup untuk memproses Backup Database</p>
							<input type="submit" name="submit" value="Backup" class="btn btn-warning"/>
							</form>
                          </div>
                        </div>
                      </div>
                      <div class="panel">
                        <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                          <h4 class="panel-title"><i class="fa fa-database"></i> Restore Data</h4>
                        </a>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                          <div class="panel-body">
                            <p><strong> Restore Data</strong>
                            </p>
                            Restore Data hanya bisa dilakukan di PHPMyAdmin, karna data yang di Import bersifat struktur dan data pada database
                          </div>
                        </div>
                      </div>
                      <div class="panel">
                        <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                          <h4 class="panel-title"><i class="fa fa-database"></i> TABEL DALAM BASIS DATA</h4>
                        </a>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false">
                          <div class="panel-body">
                            <?php
							$sql 	= "SHOW TABLES FROM $myDbs";
							$result = mysql_query($sql);
							$no		= 1;
							?>
							<table class="table table-striped">
                              <thead>
                                <tr>
                                  <th width="10%">#</th>
                                  <th width="90%">Tabel</th>
                                </tr>
                              </thead>
                              <tbody>
							  <?php while ($row = mysql_fetch_row($result)) { ?>
                                <tr>
                                  <th scope="row"><?php echo $no; ?></th>
                                  <td><?php echo "{$row[0]}"; ?></td>
                                </tr>
							  <?php $no++; } ?>	
                              </tbody>
                            </table>
							</div>
                        </div>
                      </div>
                    </div>
                    <!-- end of accordion -->


                  </div>
                </div>

