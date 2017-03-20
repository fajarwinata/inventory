<h2> LAPORAN DATA PETUGAS </h2>
<div class="card-box table-responsive">
  <table id="datatable-buttons" class="table table-striped table-bordered">
    <thead>
    <tr>
      <th width="22" align="center" bgcolor="#CCCCCC"><b>No</b></th>
      <th width="50" bgcolor="#CCCCCC"><strong>Kode</strong></th>
      <th width="372" bgcolor="#CCCCCC"><b>Nama Petugas </b></th>
      <th width="130" bgcolor="#CCCCCC"><b>No. Telepon </b></th>
      <th width="120" bgcolor="#CCCCCC"><b>Username</b></th>
      <th width="75" bgcolor="#CCCCCC"><b>Level</b></th>
    </tr>
    </thead>
    <tbody>
      <?php
      // Menampilkan data Petugas
      $mySql 	= "SELECT * FROM petugas ORDER BY kd_petugas";
      $myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
      $nomor  = 0;
      while ($myData = mysql_fetch_array($myQry)) {
          $nomor++;

          // gradasi warna
          if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
      ?>
    <tr bgcolor="<?php echo $warna; ?>">
      <td align="center"><?php echo $nomor; ?></td>
      <td><?php echo $myData['kd_petugas']; ?></td>
      <td><?php echo $myData['nm_petugas']; ?></td>
      <td><?php echo $myData['no_telepon']; ?></td>
      <td><?php echo $myData['username']; ?></td>
      <td><?php echo $myData['level']; ?></td>
    </tr>
    <?php } ?>
    </tbody>
  </table>
  </div>
<br />
<a href="cetak/petugas.php" target="_blank" class="btn btn-large btn-primary">
  <i class="fa fa-print"></i>&nbsp;&nbsp; CETAK DATA
</a>
<a href="?open=Laporan-Cetak" class="btn btn-large btn-warning">
  <i class="fa fa-bars"></i>&nbsp;&nbsp; KEMBALI KE MENU
</a>