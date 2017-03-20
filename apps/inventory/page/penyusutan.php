
				<div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-bars"></i> Penyusutan <small>Status Barang</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <a href="<?php echo "?open=".md5('penyusutan') ?>" class="btn btn-app">
                      <i class="fa fa-money"></i> Hitung Satuan
                    </a>
                  <a href="<?php echo "?open=".md5('penyusutan')."&&data=".md5('all')?>" class="btn btn-app">
                      <i class="fa fa-table"></i> Semua Data
                  </a>
				<?php 
				if(isset($_GET['data'])){
				if($_GET['open'] == md5('penyusutan') && $_GET['data'] == md5('all'))
					
					include("page/penyusutan/hitung_semua.php");
					
				} else {
					
					include("page/penyusutan/index.php");
					
				}
					?>
                                          
                    </div></div>