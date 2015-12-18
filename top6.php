<?php
              include 'log.php';
              include './Connections/conn.php';
              ?>

<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <meta name="description" content="Materialize is a modern responsive CSS framework based on Material Design by Google. ">
  <link rel="stylesheet" href="font/PraKas/stylesheet.css" type="text/css" charset="utf-8" />
  <title>ค้นหา</title>
  <link href="css/ghpages-materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
  <style type="text/css">
  body{
    font-family: 'cs_prakasregular';
  }
  </style>
</head>
<body>
              
  <?
              $sql = "SELECT * FROM Log Order by log_id DESC";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {


                      while($row = $result->fetch_assoc()) {
                      $id = $row["log_id"];
                      $ip = $row["log_ip"];
                      $ac = $row["log_action"];
                      $time = $row["log_date"];
                      echo "$id : $ip : $ac : $time <br>";
                    }
                  }
                  ?>

        
</body>
</html>
