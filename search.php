
<?php 
require_once('Connections/conn.php'); 
include 'log.php';
$colname_Recordset1 = " ";
if (isset($_POST['keyword'])) {
  $colname_Recordset1 = $_POST['keyword'];
}
include './Connections/connOracle.php';
  session_start();
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

  <header>
    <div class="section scrollspy" id = "section-0" style="padding:0px">
      <nav class="top-nav orange">
        <div class="container">
          <div class="nav-wrapper"><a class="page-title">ค้นหาเอกสารภายใน</a></div>                                                                
        </div>
      </nav>
    </div>
    <div class="container">
      <a href="#" data-activates="nav-mobile" class="button-collapse top-nav full">
        <i class="mdi-navigation-menu"></i>
      </a>
    </div>
    <ul id="nav-mobile" class="side-nav fixed" >
      <li class="logo" style="margin-bottom:0px;">
        <a id="logo-container" href="http://www.med.nu.ac.th/" class="brand-logo">
          <img src="pic/14404_logo-med-www.png" alt="" class="circle responsive-img" style="width:150px;">
        </a>
      </li>
      <?php
    if(isset($_SESSION['SMU_ID'])){

      $stid = oci_parse($con, "select MNAME from HR.V_EMPLOY WHERE INTERNETACCOUNT = '".$_SESSION['U_ID']."'");
          oci_execute($stid);

          if(($row = oci_fetch_assoc($stid))){
            $Name = $row['MNAME'];
          }

          oci_free_statement($stid);
          oci_close($con);
      
      echo "<li class=\"grey lighten-2\" style=\"padding-left: 0px; padding-right: 0px;\"><a class=\"waves-effect waves-cyan accent-1 grey lighten-2\" style=\"padding-right: 0px;\">สวัสดี ".$Name."</a></li>";
    }
      echo "<li style=\"padding-right: 0px; margin-top:15px;\"><a href=\"./\" class=\"waves-effect waves-cyan accent-1\" style=\"padding: 0px;\">หน้าหลัก</a></li>";
    ?>
    </ul>
  </header>



  <main>
    <div class="container">
      <br><br>
      <div class="row" style="margin:0px">
        <div class="card lime grey lighten-5" style="margin-top: 0px;">
          <form id="search" name="search" method="post" action="search.php" style = "margin:0px;" >
            <div class="col s4"><p style="text-align:right;"><b>คำที่ต้องการค้นหา</p></b></div>                        
            <div class="col s4" align="center"><input name="keyword" type="text" id="keyword" style="margin-bottom: 5px;"></div> 
            <div class="col s4" style = "padding:5px;">
              <button class="btn waves-effect waves-light blue-grey lighten-1" type="submit" name="action">ค้นหา
                <i class="mdi-content-send right"></i>
              </div>
            </form>
          </div>
        </div>
        <?php
        $sql = "SELECT * FROM paper where paper_Name like '%$colname_Recordset1%'";                      
        $result = $conn->query($sql);
        $i = 0;

        if ($result->num_rows > 0) {
          echo "<ul class=\"collection\">";                              
          while($row = $result->fetch_assoc()) {
            /*************************************************************************/
            $paper_name = $row['paper_Name'];
            $paper_url = $row['paper_URL'];
            $paper_date = $row['paper_UploadDate'];
            $paper_id = $row['paper_ID'];
            /*************************************************************************/
            $paper_type = functionQ("paper_type","paper","paper_ID",$paper_id,$conn); 
            $paperType_belongTo = functionQ("paperType_belongTo","papertype","paperType_ID",$paper_type,$conn);
            $belongTo = functionQ("belongTo","smu","SMU_ID",$paperType_belongTo,$conn);
            $smu_type_name = functionQ("SMUType_Name","smutype","SMUType_ID",$belongTo,$conn);
            $smu_name = functionQ("SMU_NAME","smu","SMU_ID",$paperType_belongTo,$conn);
            /*************************************************************************/ 
            echo 
            "<a href=\"paper/$paper_url\" class=\"collection-item\">$paper_name  $smu_type_name $smu_name 
            <span class=\"badge\">( " . date("d-m-Y", strtotime($paper_date)) . " )</span>
            </a>";
            $i++;
          }
          echo "</ul>"; 
          echo "<div class =\"row\" align=\"center\">";
          echo "<span class=\"green-text text-darken-4\">ผลการค้นหา พบทั้งหมด <b>$i</b> รายการ</span><br>";
          echo "</div>";
        }
        else{
          echo "<div class =\"row\" align=\"center\">";
          echo "<span class=\"red-text text-darken-2\">ไม่พบ <b>$colname_Recordset1 </b>จากรายการที่ค้นหา </span><br>";
          echo "</div>";
        }                   
        ?>
      </div>
    </main>
    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script>if (!window.jQuery) { document.write('<script src="bin/jquery-2.1.1.min.js"><\/script>'); }
    </script>
    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="js/materialize.js"></script>
    <script src="js/init.js"></script>
  </body>
  </html>
