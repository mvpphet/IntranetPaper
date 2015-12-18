<?php
include './Connections/conn.php';
include './Connections/connOracle.php';
include './log.php';

session_start();

if(!isset($_SESSION['SMU_ID']) || $_SESSION['SMU_ID'] == "" || $_SESSION['SMU_ID'] == null){
  header("Location: ./index.php"); 
  exit;
}

if(isset($_POST['deletePermission'])){
  $sql = "DELETE FROM permission WHERE userName = '".$_POST['deletePermission']."'";
  if (!mysqli_query($conn, $sql)) {
    #echo "Record deleted unsuccessfully";
    echo "<script language='javascript'> alert('การลบผิดผลาด'); </script>";
  }
  else{
    savelog("ลบสิทธิ์การใช้งานของ ".$_POST['deletePermission']);
  }
  echo "<script language='javascript'> window.location='intranet_paper_admin.php'; </script>"; 
  exit;
}


if (isset($_POST['addPermission'])) {
  if(!empty($_POST['userName'])){
    $userToAddP = $_POST['userName'];
    $userPer = $_POST['permissionSelect'];

    $sql = "INSERT INTO permission (userName, authorization) VALUES ( '$userToAddP', '$userPer')";
    if (!$conn->query($sql) === TRUE) {
      #echo $conn->error;
      echo "<script language='javascript'> alert('ผู้ใช้ที่ต้องการเพิ่มมีสิทธิ์การใช้งานก่อนหน้าแล้ว'); </script>";
    }
    else{
      if($userPer == 0){
        $CPer = "Super user";
      }
      else{
        $CPer = "user";
      }
      savelog("เพิ่มสิทธิ์การเใช้งานของ ".$userToAddP." เป็น ".$CPer);
    }
  }
  echo "<script language='javascript'> window.location='intranet_paper_admin.php'; </script>"; 
  exit;
}


if (isset($_POST['addPaperType'])) {
  if(!empty($_POST['typeName'])){
    
    $sql = "INSERT INTO paperType (paperType_Name, paperType_belongTo)
    VALUES ( '".$_POST['typeName']."', '".$_SESSION['SMU_ID']."')";

    if (!$conn->query($sql) === TRUE) {
      echo $conn->error;
      die();
    }
    else{
      $last_ID = $conn->insert_id;
      savelog("เพิ่มประเภทเอกสารชื่อ ".$_POST['typeName']." ID ".$last_ID);
    }

    $sql = "UPDATE paperType SET paperType_Seq = '$last_ID' WHERE paperType_ID = $last_ID";
    if (!$conn->query($sql) === TRUE){
      echo "Action Error!!!2";
    }
    $conn->close();
  }
  else{
    echo "<script language='javascript'> alert('กรุณาใส่ชื่อชนิดเอกสาร'); </script>";
  }

  echo "<script language='javascript'> window.location='intranet_paper_admin.php'; </script>";  
  //header("Location: ./intranet_paper_admin.php");
  exit;
}

$base_directory = './paper/';
$paper_URL = "";
if(isset($_POST['deletePaper'])) {
  $sql_smu = "SELECT paper_URL , paper_Name FROM paper WHERE paper_ID = " . $_POST['deletePaper'] . " ORDER BY paper_UploadDate ASC";
  $result_smu = $conn->query($sql_smu);
  if ($result_smu->num_rows > 0) {
    
    $rows = $result_smu->fetch_assoc();
    $paper_URL = $rows["paper_URL"];
    $paper_Name = $rows["paper_Name"];
    if(!empty($paper_URL)){
      if(!unlink($base_directory.$paper_URL)){
        #echo "Error delete file.";
        die("Error delete file.");
      }
      $sql = "DELETE FROM paper WHERE paper_ID = " . $_POST['deletePaper'];
      if (!mysqli_query($conn, $sql)) {
        #echo "Record deleted unsuccessfully";
        die("Error delete file from data base.");
      }
      else{
        savelog("ลบเอกสารชื่อ : " .$paper_Name);
      }
    }
  }
  header("Location: ./intranet_paper_admin.php");
  exit;
}

if(isset($_POST['deletePaperType'])) {
  #echo $_POST['deletePaperType'];
  $sql_smu = "SELECT paper_URL , paper_Name FROM paper WHERE paper_Type = ".$_POST['deletePaperType'];
  $result_smu = $conn->query($sql_smu);
  if ($result_smu->num_rows > 0) {
    while($rows = $result_smu->fetch_assoc()){
      $paper_URL = $rows["paper_URL"];
      $paper_Name = $rows["paper_Name"];
      if(!empty($paper_URL)){
        if(!unlink($base_directory.$paper_URL)){
          #echo "Error delete file.";
        }
        else{
          savelog("ลบเอกสารชื่อ : " .$paper_Name);
        }
      }
    } 
  }

  $sql = "DELETE FROM paperType WHERE paperType_ID = " . $_POST['deletePaperType'];
    if (!mysqli_query($conn, $sql)) {
      #echo "Record deleted unsuccessfully";
    }
    else{
          savelog("ลบประเภทเอกสาร ID : " .$_POST['deletePaperType']);
        }
  header("Location: ./intranet_paper_admin.php");
  exit;
}
?>

<!-- ****************************************************** FOR UPLOAD ************************************************************* -->
<?php
if(isset($_POST['paperName'])){
  if(!empty($_POST['paperName'])){
    if(isset($_FILES["FileInput"]) && $_FILES["FileInput"]["error"]== UPLOAD_ERR_OK){
      ############ Edit settings ##############
      $UploadDirectory  = "paper/"; //specify upload directory ends with / (slash)
      ##########################################
      
      /*
      Note : You will run into errors or blank page if "memory_limit" or "upload_max_filesize" is set to low in "php.ini". 
      Open "php.ini" file, and search for "memory_limit" or "upload_max_filesize" limit 
      and set them adequately, also check "post_max_size".
      */
      
      //check if this is an ajax request
      if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
        die();
      }
      
      
      //Is file size is less than allowed size.
      if ($_FILES["FileInput"]["size"] > 5242880) {
        die("File size is too big!");
      }

      //allowed file type Server side check
      switch(strtolower($_FILES['FileInput']['type']))
        {
          //allowed file types
          case 'image/png': 
          case 'image/gif': 
          case 'image/jpeg': 
          case 'image/pjpeg':
          case 'text/plain':
          case 'text/html': //html file
          case 'application/x-zip-compressed':
          case 'application/pdf':
          case 'application/msword':
          case 'application/vnd.ms-excel':
          case 'video/mp4':
            break;
          default:
            die('Unsupported File!'); //output error
      }
      
      $File_Name          = strtolower($_FILES['FileInput']['name']);
      $File_Ext           = substr($File_Name, strrpos($File_Name, '.')); //get file extention
      $Random_Number      = rand(0, 99999); //Random number to be added to name.
      #$NewFileName     = $Random_Number.$File_Ext; //new file name     
      $Str_file       = explode(".",$_FILES['FileInput']['name']);
      #$NewFileName     = strtolower($_FILES['FileInput']['name']);
      #$NewFileName     = $_FILES['FileInput']['name'].'_'.rand(0,100).$File_Ext;
      $NewFileName  = $Str_file[0].'_'.$Random_Number.'.'.$Str_file[1];
      if(move_uploaded_file($_FILES['FileInput']['tmp_name'], $UploadDirectory.$NewFileName ))
         {
          if(isset($_POST['paperTypeSelect'])) {
            $mysqltime = date_create()->format('Y-m-d');#date ("Y-m-d", $phptime);
            $sql = "INSERT INTO paper (paper_Name, paper_Type, paper_URL, paper_UploadDate)
            VALUES ( ' " . $_POST['paperName'] . "', '". $_POST['paperTypeSelect'] ."' ,'" .$NewFileName . "', '" .$mysqltime. "')";
            if (!$conn->query($sql) === TRUE) {
              echo "<script type=\"text/javascript\">";
              echo "alert(\"การอัฟโหลดผิดพลาด เนื่องจากฐานข้อมูล !!!\");"; 
              echo "</script>"; 
            }
          }
        echo "<script language='javascript'> window.location='intranet_paper_admin.php'; </script>";  
        die('Success! File Uploaded.');
      }else{
        die('error uploading File!');
      }
      
    }
    else{
      # die('Something wrong with upload! Is "upload_max_filesize" set correctly?');
      die('error uploading File!');
    }
  }
  else{
    echo "<script type=\"text/javascript\">";
    echo "alert(\"กรุณาใส่ชื่อเอกสาร\");"; 
    echo "</script>"; 
    die('error uploading File!');
  }
}
?>