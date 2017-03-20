
				<div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-bars"></i> Mutasi <small>Barang</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <a href="<?php echo "?open=".md5('mutasi') ?>" class="btn btn-app">
                      <i class="fa fa-th-large"></i> Mutasi Baru
                    </a>
                  <a href="<?php echo "?open=".md5('mutasi')."&&data=".md5('all')?>" class="btn btn-app">
                      <i class="fa fa-table"></i> Semua Data
                  </a>
				<?php 
				if(isset($_GET['data'])){
				if($_GET['open'] == md5('mutasi') && $_GET['data'] == md5('all'))
					if(!file_exists ("page/mutasi/mutasi_tampil.php")) die ("File tidak ditemukan !");
					include("page/mutasi/mutasi_tampil.php");
					
				} else {
					
					include("page/mutasi/mutasi_baru.php");
					
				}
					?>
                                          
                    </div></div>