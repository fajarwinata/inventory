<?php
if(isset($_SESSION['SES_ADMIN'])) {
	include("page/main_admin.php");	
	exit;
}
else if(isset($_SESSION['SES_PETUGAS'])) {
	include("page/main_admin.php");	
	exit;
}
else {
	include("page/login.php");	
}
?>