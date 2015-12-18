<?

function DBConnect ($db_type,$db_hostname, $db_username, $db_password, $db_name)
{
	try
	{
		$db = NewADOConnection($db_type);
//		$db->NLS_CALENDAR= 'Thai Buddha';
		$db->NLS_DATE_FORMAT= 'DD-MM-YYYY';
		$db->Connect($db_hostname ,$db_username, $db_password, $db_name);
	}
	catch (exception $e) 
	{ 

           //var_dump($e); 
		echo "Web Page Error.";
		//echo "0-".$db_username." ".$db->ErrorMsg();
		exit;

	}
//	echo "success";
//	$recordSet = $db->Execute("select 2 from dual",array());
//	echo "Query OK";
	return $db;
}

?>
