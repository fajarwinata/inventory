<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>

  <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Awesome Flat Login Form" />
  <meta name="keywords" content="Login, Flat, HTML5, CSS3" />
  <meta name="author" content="Fajar Winata - Inventory" />
  <title>Inventory Binakarir</title>

  <link href="css/login_style.css" rel="stylesheet" type="text/css">
  <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
  <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="vendors/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="styles/favicon.png" rel="icon">
  <link href="styles/login.css" rel="stylesheet">

  <link rel="shortcut icon" href="../inventory.ico"/>
  <link rel="apple-touch-icon" href="../inventory.ico"/>

</head>
<body>
<?php if ($_GET){ 
switch($_GET['open']){
	case'error':
	?>
	<div id="error">
	<div class="container">
    <section class="notif notif-alert">
      <h6 class="notif-title">Kesalahan!</h6>
      <p>
	  Kesalahan dalam memilih Level
	  </p>
      
    </section>
  </div>
  </div>
	<?php
	default:
	break;
	}
 } ?>
  <div class="logo"></div>
  <div class="login"> <!-- Login -->
    <h1><img src="images/inv_kk_logo.png" style="margin-top:10px; margin-bottom: -10px"/></h1>

    <form name="logForm" method="post" action="?open=Login-Validasi" class="form" >

      <p class="field">
        <input type="text" name="txtUser" placeholder="Username" required/>
        <i class="fa fa-user"></i>
      </p>

      <p class="field">
        <input type="password" name="txtPassword" placeholder="Password" required/>
        <i class="fa fa-lock"></i>
      </p>
	  
	  <p class="field">
        <select name="cmbLevel">
		<option value="Kosong">....</option>
		<?php
		$pilihan = array("Petugas", "Admin");
		foreach ($pilihan as $nilai) {
			if ($_POST['cmbLevel']==$nilai) {
				$cek="selected";
			} else { $cek = ""; }
			echo "<option value='$nilai' $cek>$nilai</option>";
		}
		?>
		</select>
      </p>

      <p class="submit"><input type="submit" name="btnLogin" value="Login"></p>

      <p class="remember">
        <input type="checkbox" id="remember" name="remember" />
        <label for="remember"><span></span>Remember Me</label>
      </p>

      <!--<p class="forgot">
        <a href="#">Forgot Password?</a>
      </p>-->

    </form>
  </div> <!--/ Login-->
  <div class="copyright">
    <p>Copyright &copy; <?php echo date("Y"); ?>. Aplikasi Manajemen Aset Kantor PT Care Indonesia Solusi</p>
    <p>Created by <a href="https://www.fajar-ch.in" target="_blank">Mr. Fajar Winata</a></p>
  </div>
</body>
</html>
