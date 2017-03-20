<h2> LAPORAN DATA DEPARTEMEN </h2>
<div class="card-box table-responsive">
  <table id="datatable-buttons" class="table table-striped table-bordered">
    <thead>
    <tr>
      <th width="26" align="center" bgcolor="#CCCCCC"><b>No</b></th>
      <th width="50" bgcolor="#CCCCCC"><strong>Kode</strong></th>
      <th width="251" bgcolor="#CCCCCC"><b>Nama Departemen </b></th>
      <th width="372" bgcolor="#CCCCCC"><strong>Keterangan</strong></th>
      <th width="75" align="right" bgcolor="#CCCCCC"><b>Qty Lokasi </b> </th>
    </tr>
    </thead>
    <tbody>
    <?php
        // Menampilkan data Departemen
      $mySql = "SELECT * FROM departemen ORDER BY kd_departemen ASC";
      $myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
      $nomor = 0;
      while ($myData = mysql_fetch_array($myQry)) {
          $nomor++;
          $Kode = $myData['kd_departemen'];

          // Menghitung jumlah lokasi/lokasi per departemen
          $my2Sql = "SELECT COUNT(*) As qty_lokasi FROM lokasi WHERE kd_departemen='$Kode'";
          $my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query salah : ".mysql_error());
          $my2Data = mysql_fetch_array($my2Qry);

          // gradasi warna
          if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
      ?>
    <tr bgcolor="<?php echo $warna; ?>">
      <td align="center"><?php echo $nomor; ?></td>
      <td><?php echo $myData['kd_departemen']; ?></td>
      <td><?php echo $myData['nm_departemen']; ?></td>
      <td><?php echo $myData['keterangan']; ?></td>
      <td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $my2Data['qty_lokasi']; ?></td>
    </tr>
    <?php } ?>
    </tbody>
  </table>
  </div>
<br />
  <a href="cetak/departemen.php" target="_blank" class="btn btn-large btn-primary">
  <i class="fa fa-print"></i>&nbsp;&nbsp; CETAK DATA
    </a>
<a href="?open=Laporan-Cetak" class="btn btn-large btn-warning">
  <i class="fa fa-bars"></i>&nbsp;&nbsp; KEMBALI KE MENU
</a>