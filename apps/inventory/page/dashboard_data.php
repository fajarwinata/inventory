<!-- top tiles -->
          <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Petugas</span>
			  <?php
			  $pet	=	mysql_query("SELECT COUNT(*) AS jumlah FROM petugas");
			  $arr	=	mysql_fetch_array($pet);
			  ?>
              <div class="count"><?php echo $arr['jumlah']; ?></div>
              <span class="count_bottom">Petugas</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Pegawai</span>
			  <?php
			  $peg	=	mysql_query("SELECT COUNT(*) AS jumlah FROM pegawai");
			  $arr2	=	mysql_fetch_array($peg);
			  ?>
              <div class="count"><?php echo $arr2['jumlah']; ?></div>
              <span class="count_bottom">Pegawai</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-box"></i> Total Supplier</span>
			  <?php
			  $sup	=	mysql_query("SELECT COUNT(*) AS jumlah FROM supplier");
			  $arr3	=	mysql_fetch_array($sup);
			  ?>
              <div class="count green"><?php echo $arr3['jumlah']; ?></div>
              <span class="count_bottom">Supplier</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-home"></i> Total Departemen</span>
              <?php
			  $dep	=	mysql_query("SELECT COUNT(*) AS jumlah FROM departemen");
			  $arr4	=	mysql_fetch_array($dep);
			  ?>
              <div class="count green"><?php echo $arr4['jumlah']; ?></div>
              <span class="count_bottom">Departemen</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-home"></i> Total Lokasi</span>
              <?php
			  $lokasi	=	mysql_query("SELECT COUNT(*) AS jumlah FROM lokasi");
			  $arr5	=	mysql_fetch_array($lokasi);
			  ?>
              <div class="count"><?php echo $arr5['jumlah']; ?></div>
              <span class="count_bottom">Lokasi</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-box"></i> Total Barang</span>
              <?php
			  $barang	=	mysql_query("SELECT COUNT(*) AS jumlah FROM barang");
			  $arr6	=	mysql_fetch_array($barang);
			  ?>
              <div class="count"><?php echo $arr6['jumlah']; ?></div>
              <span class="count_bottom">Jumlah Barang</span>
            </div>
          </div>
          <!-- /top tiles -->
          <br />

          <div class="row">
            <?php if(isset($_SESSION['SES_ADMIN'])){?>
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="x_panel tile fixed_height_320">
                <div class="x_title">
                  <h2>Quick Master Data</h2>
                  <div class="clearfix"></div>
                </div>
				
				<div class="x_content" align="center">
                  <a href='?open=Petugas-Data' title='Petugas'><img src="images/inv_icn_m1.png" alt="..." width="64px"></a>
                  <a href='?open=Pegawai-Data' title='Pegawai'><img src="images/inv_icn_m2.png" alt="..." width="64px"></a>
                  <a href='?open=Supplier-Data' title='Supplier'><img src="images/inv_icn_m3.png" alt="..." width="64px"></a>
                  <a href='?open=Departemen-Data' title='Departemen'><img src="images/inv_icn_m4.png" alt="..." width="64px"></a>
                  <a href='?open=Lokasi-Data' title='Lokasi'><img src="images/inv_icn_m5.png" alt="..." width="64px"></a>
                  <a href='?open=Kategori-Data' title='Kategori'><img src="images/inv_icn_m6.png" alt="..." width="64px"></a>
                  <a href='?open=Barang-Data' title='Barang'><img src="images/inv_icn_m7.png" alt="..." width="64px"></a>
                
                </div>
              </div>
            </div>
            <?php }?>
            
			<div class="col-md-4 col-sm-4 col-xs-12">
              <div class="x_panel tile fixed_height_320">
                <div class="x_title">
                  <h2>Quick Transaction</h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="dashboard-widget-content">
                    <ul class="quick-list">
                      <li><i class="fa fa-edit"></i><a href='?open=<?php echo md5('penyusutan') ?>' title='Penyusutan Harga Barang' >Penyusutan Harga</a>
                      </li>
                      <li><i class="fa fa-bars"></i><a href='?open=<?php echo md5('pengadaan') ?>' title='Transaksi Pengadaan' >Transaksi Pengadaan</a>
                      </li>
                      <li><i class="fa fa-bar-chart"></i><a href='?open=<?php echo md5('penempatan') ?>' title='Transaksi Penempatan' >Transaksi Penempatan</a> </li>
                      <li><i class="fa fa-line-chart"></i><a href='?open=<?php echo md5('mutasi') ?>' title='Transaksi Mutasi' '>Transaksi Mutasi</a>
                      </li>
                      <li><i class="fa fa-bar-chart"></i><a href='?open=<?php echo md5('peminjaman') ?>' title='Transaksi Peminjaman' '>Transaksi Peminjaman</a> </li>
                    </ul>

                    <div class="sidebar-widget">
                      <h4>Pilih Menu Transaksi</h4>
                      <img src="images/inv_icn_trans.png" alt="...">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php if(isset($_SESSION['SES_ADMIN'])){?>
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="x_panel tile fixed_height_320 overflow_hidden">
                <div class="x_title">
                  <h2>Report & Print</h2>
                  
                  <div class="clearfix"></div>
                </div>

                <div class="x_content" align="center">
                  <a href='?open=Cetak-Barcode' title='Cetak BarCode' ><img src="images/inv_icn_print.png" alt="..." width="95px"></a>
                  <a href='?open=Laporan-Cetak' title='Laporan Cetak' ><img src="images/inv_icn_report.png" alt="..." width="95px"></a>
                  <a data-toggle="modal" data-target=".bs-example-modal-sm"><img src="images/inv_icn_excel.png" alt="..." width="95px"></a>
                </div>

              </div>
            </div>
            <?php } ?>
          </div>

          <!-- Small modal -->

          <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">

                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title" id="myModalLabel2">Data Export</h4>
                </div>
                <div class="modal-body">
                  <h4>Aturan dan Kondisi</h4>
                  <p>Export Data disediakan dalam tiga (3) jenis, yaitu <i>Comma Separated Version</i> (CSV), Excel (Xls), dan Clipboard (Save on Temporary)</p>
                  <p>Ketiga fitur diatas dapat diakses secara baik melalui masing-masing tombol yang disimpan diatas data tabel pada tia-tiap konten dalam sistem Inventori ini, setiap data yang di ekspor dapat di kondisikan sesuai dengan batasan yang diinginkan</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

              </div>
            </div>
          </div>
          <!-- /modals -->