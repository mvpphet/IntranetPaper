<?php
		include './Connections/conn.php';
		include './Connections/connOracle.php';
		include './log.php';

		session_start();

		if(isset($_POST['userName'])){
	        $userLogin = $_POST['userName'];
	    }
	    else{
	    	$userLogin = "";
	    }
	    if(isset($_POST['password'])){
	        $passLogin = $_POST['password'];
	    }
	    else{
	    	$passLogin = "";
	    }
		
		if( empty($userLogin) || empty($passLogin) ){	//	check Empty username AND password.
			echo "<script language='javascript'> alert('Incorect username or password.'); </script>";
			echo "<script language='javascript'> window.location='index.php'; </script>";
			exit();
		}
		else{
			//--------------------------------- Check login in database ST------------------------//
			//--------------------------------- Ldap ST---------------------------------//
			$ldaphost = "10.10.10.71";  // your ldap servers
			$ldapuser = "nu\\".$userLogin;
			$ldappass = $passLogin;
			$status ="";

			if($userLogin == "siamminw" || $userLogin == "55361274" || $userLogin == "55362318") {
				$userLogin = 'jiraporntu';
			}
			//$userLogin = 'jiraporntu'; ////////////////////////////////////////////////////////////////////////////////////////
			
			$_SESSION['U_ID'] = $userLogin;
			$ldapconn = @ldap_connect($ldaphost)or die("Connect Error");
			if ($ldapconn){
				$ldapbind = @ldap_bind($ldapconn,$ldapuser,$ldappass);
				if ($ldapbind){
					$userAcess = true;

					$stid = oci_parse($con, "select SMUCODE from HR.V_EMPLOY WHERE INTERNETACCOUNT = '".$userLogin."'");
					oci_execute($stid);

					if(($row = oci_fetch_assoc($stid))){
						$OldSMU = $row['SMUCODE'];
						$_SESSION['currentUserOldSMU'] = $OldSMU;
					}
					else{
						$userAcess = false;
					}

					oci_free_statement($stid);
					oci_close($con);

					if($userAcess){
						$sql_smu = "SELECT THIS_SMU_ID FROM smu_mapping WHERE HR_SMU_ID = $OldSMU";
	  					$result_smu = $conn->query($sql_smu);
	  					if ($result_smu->num_rows > 0) {
	    					while($rows = $result_smu->fetch_assoc()){

	    						$sql_smu = "SELECT authorization FROM permission WHERE userName = '".$userLogin."'";
	  							$result_smu = $conn->query($sql_smu);
	  							if ($result_smu->num_rows > 0) {
	    							$rows2 = $result_smu->fetch_assoc();

	    							$_SESSION['USER_AUTHU'] = $rows2["authorization"];
	    							$_SESSION['SMU_ID'] = $rows["THIS_SMU_ID"];
	    							savelog("เข้าสู่ระบบสำเร็จ");
									header("Location: ./intranet_paper_admin.php");
		                			die();
	    						}
	    						else{
	    							$userAcess = false;
	    						}
	      					}
	      				}
	      				else{
	      					$userAcess = false;
	      				}
	      			}

	      			if(!$userAcess){
						echo "<script language='javascript'> alert('บัญชีไม่ได้รับอนุญาติ กรุณาติดต่อ 5041'); </script>";
						echo "<script language='javascript'> window.location='logout.php'; </script>";
						exit();
	      			}
				}
				else{
					savelog("เข้าสู่ระบบไม่สำเร็จ");
					$status = "LDAP bind failed... ".ldap_error($ldapconn);
					session_unset();
					session_destroy();
					echo "<script language='javascript'> alert('Incorect username or password.'); </script>";
					echo "<script language='javascript'> window.location='logout.php'; </script>";
					exit();
				}    
			}
			else{
				echo "Can't connect to server!";
				echo "<script language='javascript'> alert('Can't connect to server!'); </script>";
				echo "<script language='javascript'> window.location='index.php'; </script>";
				exit();
			}
		}
?>