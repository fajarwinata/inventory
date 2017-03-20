<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>INV.Binakarir - <?php echo $_SESSION['SES_NAMA'] ?></title>
	<link href="styles/favicon.png" rel="icon">
	<link rel="stylesheet" type="text/css" href="plugins/tigra_calendar/tcal.css" />

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
	<!-- Datatables -->
    <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
   
  
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="?open" class="site_title"><img src="images/inv_kk_logo_small.png" alt="..."></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="images/inv_adm.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Hallo,</span>
                <h2><?php echo $_SESSION['SES_NAMA'] ?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>&nbsp;</h3>
				<?php include("menu.php"); ?>
				
              </div>
              

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
            <p align="right" style="margin-right:10px">PT Care Indonesia Solusi <br>App Inv Ver 2.2<br> Created By<br> Mr. Fajar Winata</p>
              <!-- <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a href='?open=Logout' data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>-->
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                
                <li class="col-md-3 col-lg-3 col-sm-12 col-xs-4">
                <div class="btn-group">
                		
                      <a href="?open=Logout" type="button" class="btn btn-danger"><i class="fa fa-sign-out pull-right" style="height:20px" > Logout</i></a>
                      <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Profil <?php echo $_SESSION['SES_NAMA'] ?></a>
                        </li>
                      </ul>
                    </div>
                
                </li>
                
                
                
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
		<div class="right_col" role="main">
        <?php 
		
		if ($_GET['open'] == "Halaman-Utama" | $_GET['open'] == "") 
		{ include("dashboard_data.php"); } 
		elseif ($_GET['open'] == "Petugas-Data") 
		{ include("petugas_data.php"); }
		elseif ($_GET['open'] == "Petugas-Edit") 
		{ include("petugas_data_edit.php"); }
		elseif ($_GET['open'] == "Pegawai-Data") 
		{ include("pegawai_data.php"); }
		elseif ($_GET['open'] == "Pegawai-Edit") 
		{ include("pegawai_data_edit.php"); }
		elseif ($_GET['open'] == "Supplier-Data") 
		{ include("supplier_data.php"); }
		elseif ($_GET['open'] == "Supplier-Edit") 
		{ include("supplier_data_edit.php"); }
		elseif ($_GET['open'] == "Departemen-Data") 
		{ include("departemen_data.php"); }
		elseif ($_GET['open'] == "Departemen-Edit") 
		{ include("departemen_data_edit.php"); }
		elseif ($_GET['open'] == "Lokasi-Data") 
		{ include("lokasi_data.php"); }
		elseif ($_GET['open'] == "Lokasi-Edit") 
		{ include("lokasi_data_edit.php"); }
		elseif ($_GET['open'] == "Kategori-Data") 
		{ include("kategori_data.php"); }
		elseif ($_GET['open'] == "Kategori-Edit") 
		{ include("kategori_data_edit.php"); }
		elseif ($_GET['open'] == "Barang-Data") 
		{ include("barang_data.php"); }
		elseif ($_GET['open'] == "Barang-Edit") 
		{ include("barang_data_edit.php"); }
		elseif ($_GET['open'] == md5('penyusutan'))
		{ include("page/penyusutan.php"); }
		elseif ($_GET['open'] == md5('pengadaan'))
		{ include("page/pengadaan.php"); }
		elseif ($_GET['open'] == md5('penempatan'))
		{ include("page/penempatan.php"); }
		elseif ($_GET['open'] == md5('mutasi'))
		{ include("page/pemutasian.php"); }
		elseif ($_GET['open'] == md5('peminjaman'))
		{ include("page/peminjaman.php"); }
        elseif ($_GET['open'] == md5('rusak'))
		{ include("page/rusak.php"); }
        elseif ($_GET['open'] == md5('jual'))
        { include("page/jual.php"); }
		elseif ($_GET['open'] == "Cetak-Barcode")
		{ include("page/cetak_barcode.php"); }
		elseif ($_GET['open'] == "Cetak-Barcode-View")
		{ include("page/cetak_barcode_view.php"); }
        elseif ($_GET['open'] == "Laporan-Cetak")
        { include("page/menu_laporan.php"); }
        elseif ($_GET['open'] == "Backup-Restore")
        { include("database/index.php"); }

        //KONTEN LAPORAN
        switch($_GET['open']) {
          case 'Laporan-Petugas' :
            if (!file_exists("page/laporan/laporan_petugas.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_petugas.php";
            break;

          case 'Laporan-Barang' :
            if (!file_exists("page/laporan/laporan_barang.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_barang.php";
            break;

          case 'Laporan-Barang-Kategori' :
            if (!file_exists("page/laporan/laporan_barang_kategori.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_barang_kategori.php";
            break;

          case 'Laporan-Barang-Lokasi' :
            if (!file_exists("page/laporan/laporan_barang_lokasi.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_barang_lokasi.php";
            break;

          case 'Laporan-Departemen' :
            if (!file_exists("page/laporan/laporan_departemen.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_departemen.php";
            break;

          case 'Laporan-Supplier' :
            if (!file_exists("page/laporan/laporan_supplier.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_supplier.php";
            break;

          case 'Laporan-Suppier' :
            if (!file_exists("page/laporan/laporan_supplier.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_supplier.php";
            break;

          case 'Laporan-Pegawai' :
            if (!file_exists("page/laporan/laporan_pegawai.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_pegawai.php";
            break;

          case 'Laporan-Lokasi' :
            if (!file_exists("page/laporan/laporan_lokasi.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_lokasi.php";
            break;

          case 'Laporan-Kategori' :
            if (!file_exists("page/laporan/laporan_kategori.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_kategori.php";
            break;

          # LAPORAN TRANSAKSI MUTASI (PEMINDAHAN TEMPAT)
          case 'Laporan-Mutasi-Periode' :
            if(!file_exists ("page/laporan/laporan_mutasi_periode.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_mutasi_periode.php"; break;

          case 'Laporan-Mutasi-Barang-Lokasi' :
            if(!file_exists ("page/laporan/laporan_mutasi_barang_lokasi.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_mutasi_barang_lokasi.php"; break;

          // PENGADAAN BARANG
          case 'Laporan-Pengadaan-Periode' :
            if(!file_exists ("page/laporan/laporan_pengadaan_periode.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_pengadaan_periode.php"; break;

          case 'Laporan-Pengadaan-Barang-Periode' :
            if(!file_exists ("page/laporan/laporan_pengadaan_barang_periode.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_pengadaan_barang_periode.php"; break;


          case 'Laporan-Pengadaan-Barang-Kategori' :
            if(!file_exists ("page/laporan/laporan_pengadaan_barang_kategori.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_pengadaan_barang_kategori.php"; break;

          case 'Laporan-Pengadaan-Supplier' :
            if(!file_exists ("page/laporan/laporan_pengadaan_supplier.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_pengadaan_supplier.php"; break;

          case 'Laporan-Pengadaan-Barang-Supplier' :
            if(!file_exists ("page/laporan/laporan_pengadaan_barang_supplier.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_pengadaan_barang_supplier.php"; break;

          # LAPORAN TRANSAKSI PENEMPATAN
          case 'Laporan-Penempatan-Periode' :
            if(!file_exists ("page/laporan/laporan_penempatan_periode.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_penempatan_periode.php"; break;

          case 'Laporan-Penempatan-Lokasi' :
            if(!file_exists ("page/laporan/laporan_penempatan_lokasi.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_penempatan_lokasi.php"; break;

          # LAPORAN TRANSAKSI PEMINJAMAN
          case 'Laporan-Peminjaman-Periode' :
            if(!file_exists ("page/laporan/laporan_peminjaman_periode.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_peminjaman_periode.php"; break;

          case 'Laporan-Peminjaman-Bulan' :
            if(!file_exists ("page/laporan/laporan_peminjaman_bulan.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_peminjaman_bulan.php"; break;

          case 'Laporan-Peminjaman-Pegawai' :
            if(!file_exists ("page/laporan/laporan_peminjaman_pegawai.php")) die ("File tidak ditemukan !");
            include "page/laporan/laporan_peminjaman_pegawai.php"; break;

        }
		
		
		
		
		?>
		</div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Copy Right &copy; <?php echo date("Y"); ?> Binakarir <a href="#">App Ver. 2.2</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
	
    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="vendors/Flot/jquery.flot.js"></script>
    <script src="vendors/Flot/jquery.flot.pie.js"></script>
    <script src="vendors/Flot/jquery.flot.time.js"></script>
    <script src="vendors/Flot/jquery.flot.stack.js"></script>
    <script src="vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    
    <script src="js/moment/moment.min.js"></script>
    <script src="js/datepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
	
	<!-- Datatables -->
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>
	
	

    
    <!-- bootstrap-daterangepicker -->
    <script>
      $(document).ready(function() {
        var cb = function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
          $('#reportrange_right span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        };

        var optionSet1 = {
          startDate: moment().subtract(29, 'days'),
          endDate: moment(),
          minDate: '01/01/2012',
          maxDate: '12/31/2015',
          dateLimit: {
            days: 60
          },
          showDropdowns: true,
          showWeekNumbers: true,
          timePicker: false,
          timePickerIncrement: 1,
          timePicker12Hour: true,
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          opens: 'right',
          buttonClasses: ['btn btn-default'],
          applyClass: 'btn-small btn-primary',
          cancelClass: 'btn-small',
          format: 'MM/DD/YYYY',
          separator: ' to ',
          locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
          }
        };

        $('#reportrange_right span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

        $('#reportrange_right').daterangepicker(optionSet1, cb);

        $('#reportrange_right').on('show.daterangepicker', function() {
          console.log("show event fired");
        });
        $('#reportrange_right').on('hide.daterangepicker', function() {
          console.log("hide event fired");
        });
        $('#reportrange_right').on('apply.daterangepicker', function(ev, picker) {
          console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
        });
        $('#reportrange_right').on('cancel.daterangepicker', function(ev, picker) {
          console.log("cancel event fired");
        });

        $('#options1').click(function() {
          $('#reportrange_right').data('daterangepicker').setOptions(optionSet1, cb);
        });

        $('#options2').click(function() {
          $('#reportrange_right').data('daterangepicker').setOptions(optionSet2, cb);
        });

        $('#destroy').click(function() {
          $('#reportrange_right').data('daterangepicker').remove();
        });

      });
    </script>

    <script>
      $(document).ready(function() {
        var cb = function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        };

        var optionSet1 = {
          startDate: moment().subtract(29, 'days'),
          endDate: moment(),
          minDate: '01/01/2012',
          maxDate: '12/31/2015',
          dateLimit: {
            days: 60
          },
          showDropdowns: true,
          showWeekNumbers: true,
          timePicker: false,
          timePickerIncrement: 1,
          timePicker12Hour: true,
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          opens: 'left',
          buttonClasses: ['btn btn-default'],
          applyClass: 'btn-small btn-primary',
          cancelClass: 'btn-small',
          format: 'MM/DD/YYYY',
          separator: ' to ',
          locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
          }
        };
        $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
        $('#reportrange').daterangepicker(optionSet1, cb);
        $('#reportrange').on('show.daterangepicker', function() {
          console.log("show event fired");
        });
        $('#reportrange').on('hide.daterangepicker', function() {
          console.log("hide event fired");
        });
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
          console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
        });
        $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
          console.log("cancel event fired");
        });
        $('#options1').click(function() {
          $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
        });
        $('#options2').click(function() {
          $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
        });
        $('#destroy').click(function() {
          $('#reportrange').data('daterangepicker').remove();
        });
      });
    </script>

    <script>
      $(document).ready(function() {
        $('#single_cal1').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
        $('#single_cal2').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_2"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
        $('#single_cal3').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_3"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
        $('#single_cal4').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_4"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>

    <script>
      $(document).ready(function() {
        $('#reservation').daterangepicker(null, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>
    <!-- /bootstrap-daterangepicker -->
    
    
	<!-- Datatables -->
    <script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                //{
                //  extend: "print",
                //  className: "btn-sm"
                //},
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();

        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        var $datatable = $('#datatable-checkbox');

        $datatable.dataTable({
          'order': [[ 1, 'asc' ]],
          'columnDefs': [
            { orderable: false, targets: [0] }
          ]
        });
        $datatable.on('draw.dt', function() {
          $('input').iCheck({
            checkboxClass: 'icheckbox_flat-green'
          });
        });

        TableManageButtons.init();
      });
    </script>
    <!-- /Datatables -->
	
    <!-- Flot -->
    <script>
      $(document).ready(function() {
        var data1 = [
          [gd(2012, 1, 1), 17],
          [gd(2012, 1, 2), 74],
          [gd(2012, 1, 3), 6],
          [gd(2012, 1, 4), 39],
          [gd(2012, 1, 5), 20],
          [gd(2012, 1, 6), 85],
          [gd(2012, 1, 7), 7]
        ];

        var data2 = [
          [gd(2012, 1, 1), 82],
          [gd(2012, 1, 2), 23],
          [gd(2012, 1, 3), 66],
          [gd(2012, 1, 4), 9],
          [gd(2012, 1, 5), 119],
          [gd(2012, 1, 6), 6],
          [gd(2012, 1, 7), 9]
        ];
        $("#canvas_dahs").length && $.plot($("#canvas_dahs"), [
          data1, data2
        ], {
          series: {
            lines: {
              show: false,
              fill: true
            },
            splines: {
              show: true,
              tension: 0.4,
              lineWidth: 1,
              fill: 0.4
            },
            points: {
              radius: 0,
              show: true
            },
            shadowSize: 2
          },
          grid: {
            verticalLines: true,
            hoverable: true,
            clickable: true,
            tickColor: "#d5d5d5",
            borderWidth: 1,
            color: '#fff'
          },
          colors: ["rgba(38, 185, 154, 0.38)", "rgba(3, 88, 106, 0.38)"],
          xaxis: {
            tickColor: "rgba(51, 51, 51, 0.06)",
            mode: "time",
            tickSize: [1, "day"],
            //tickLength: 10,
            axisLabel: "Date",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 10
          },
          yaxis: {
            ticks: 8,
            tickColor: "rgba(51, 51, 51, 0.06)",
          },
          tooltip: false
        });

        function gd(year, month, day) {
          return new Date(year, month - 1, day).getTime();
        }
      });
    </script>
    <!-- /Flot -->

    <!-- JQVMap -->
    <script>
      $(document).ready(function(){
        $('#world-map-gdp').vectorMap({
            map: 'world_en',
            backgroundColor: null,
            color: '#ffffff',
            hoverOpacity: 0.7,
            selectedColor: '#666666',
            enableZoom: true,
            showTooltip: true,
            values: sample_data,
            scaleColors: ['#E6F2F0', '#149B7E'],
            normalizeFunction: 'polynomial'
        });
      });
    </script>
    <!-- /JQVMap -->

    <!-- Skycons -->
    <script>
      $(document).ready(function() {
        var icons = new Skycons({
            "color": "#73879C"
          }),
          list = [
            "clear-day", "clear-night", "partly-cloudy-day",
            "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
            "fog"
          ],
          i;

        for (i = list.length; i--;)
          icons.set(list[i], list[i]);

        icons.play();
      });
    </script>
    <!-- /Skycons -->

    <!-- Doughnut Chart -->
    <script>
      $(document).ready(function(){
        var options = {
          legend: false,
          responsive: false
        };

        new Chart(document.getElementById("canvas1"), {
          type: 'doughnut',
          tooltipFillColor: "rgba(51, 51, 51, 0.55)",
          data: {
            labels: [
              "Symbian",
              "Blackberry",
              "Other",
              "Android",
              "IOS"
            ],
            datasets: [{
              data: [15, 20, 30, 10, 30],
              backgroundColor: [
                "#BDC3C7",
                "#9B59B6",
                "#E74C3C",
                "#26B99A",
                "#3498DB"
              ],
              hoverBackgroundColor: [
                "#CFD4D8",
                "#B370CF",
                "#E95E4F",
                "#36CAAB",
                "#49A9EA"
              ]
            }]
          },
          options: options
        });
      });
    </script>
    <!-- /Doughnut Chart -->
    
    

    <!-- gauge.js -->
    <script>
      var opts = {
          lines: 12,
          angle: 0,
          lineWidth: 0.4,
          pointer: {
              length: 0.75,
              strokeWidth: 0.042,
              color: '#1D212A'
          },
          limitMax: 'false',
          colorStart: '#1ABC9C',
          colorStop: '#1ABC9C',
          strokeColor: '#F0F3F3',
          generateGradient: true
      };
      var target = document.getElementById('foo'),
          gauge = new Gauge(target).setOptions(opts);

      gauge.maxValue = 6000;
      gauge.animationSpeed = 32;
      gauge.set(3200);
      gauge.setTextField(document.getElementById("gauge-text"));
    </script>
    <!-- /gauge.js -->
	<script type="text/javascript">
	function myFunction(no,kd_barang) {
		 // document.getElementsByName("persen")[no].innerHTML = "<form id='form' method='post' onsubmit='return hitung()'><input id='value' type='text' name='value' style='width: 30pt;'><input type='submit' value='Ubah'></form>";
    var persen = prompt("Masukkan persentase (tanpa tanda %). Contoh: 25", "25");
    
    if (persen != null) {
    	var dec = persen/100
        document.getElementsByName("persen")[no].innerHTML = persen + "%";
        
        var kd_barang=kd_barang
        $.ajax({
			type: 'post',
			url: 'tes.php',
			data: {
			value:dec,kd_barang:kd_barang
			},
			success: function (response) {
			console.log(response)
			//document.getElementsByName("coba")[no].replaceWith(response) ;
			var plus= no+1
			 $(".coba-"+plus).replaceWith(response);
			 document.getElementsByName("persen")[no].innerHTML = persen + "%";
			// We get the element having id of display_info and put the response inside it
			//$( '#persen' ).html(value);

			}
		   });
		return false;
    }
}
	 
</script>
<script type="text/javascript">
	var table2_Props = {
    col_1: "select",col_2: "select",
    col_0: "none",col_3: "none",col_4: "none",col_5: "none",col_6: "none",col_7: "none",col_8: "none",col_8: "none",col_9: "none",col_10: "none",col_11: "none",col_12: "none",col_13: "none",col_14: "none",col_15: "none",col_16: "none",col_17: "none",col_18: "none",col_19: "none",col_20: "none",col_21: "none",col_22: "none",col_23: "none",col_24: "none",
    display_all_text: " [ Tampil Semua ] ",
    sort_select: true
	};
		var tf2 = setFilterGrid("table2", table2_Props);
</script>
	

	
	
  </body>
</html>
