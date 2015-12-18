<?php
	$con = oci_connect('hris', 'hris', '10.32.10.13/hr' , 'AL32UTF8');
	
	if (!$con) {
	    $e = oci_error();
	    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	    die("Oracle Connection failed");
	}

	
?>