<?
  include './Connections/conn.php';
  function savelog($action)
  {
    global $conn;
    if(isset($_SESSION['U_ID'])){
      $userid = $_SESSION['U_ID'];
    }
    else{
      header("Location: ./index.php");
      die();
    }
    //echo "ip: | $ip | "." action: | $action |"." reaction: |"." date: | $date |";
    
    $sql = "INSERT INTO Log (log_id, log_ip, log_action, log_date)
    VALUES ('".$userid."','".get_client_ip()."', '".$action."', '".date_create()->format('Y-m-d G:i:s')."')";

    if ($conn->query($sql) === TRUE) {
      //echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
      die();
    }
  }

function get_client_ip() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function functionQ($fill, $table, $_where, $_equ, $conn)
{
  $sql = "SELECT $fill FROM $table WHERE $_where = $_equ";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return $row[$fill];
  }
  else {
    return "";
  }
}
function function_count($fill,$table,$conn)
{
    $sql = "SELECT $fill FROM $table";
    $result = $conn->query($sql);
      $count = 0;
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
          $count++;
              if($count>=20)
                      $count=20;
            }
    }
    return $count;
}
?>
