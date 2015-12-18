<?php
	include'./log.php';
	session_start();
	if(isset($_SESSION['SMU_ID'])){
		savelog("ออกจากระบบ");
	}
	session_unset();
	session_destroy();
	header("Location: ./index.php");
  	exit;
?>