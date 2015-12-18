<?php
include './Connections/conn.php';
include './Connections/connOracle.php';
session_start();

if(!isset($_GET["smutid"]))
{
  $SMUT_ID = "0";
}
else
{
  $SMUT_ID = $_GET["smutid"];
}

if(!isset($_GET["smuid"]))
{
  $SMU_ID = "0";
}
else
{
  $SMU_ID = $_GET["smuid"];
}
?>

<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <meta name="description" content="Materialize is a modern responsive CSS framework based on Material Design by Google. ">
  <link rel="stylesheet" href="font/PraKas/stylesheet.css" type="text/css" charset="utf-8" />

  <title>ดาวน์โหลด เอกสารภายใน</title>
  <link href="css/ghpages-materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
</head>
<body>

 <style type="text/css">
 body{
  font-family: 'cs_prakasregular';
}
</style>
<header>
  <nav class="top-nav green darken-4">
    <div class="container">

      <?php
      $sql = "SELECT SMUType_Name FROM SMUType WHERE SMUType_ID = $SMUT_ID";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      if ($result->num_rows > 0) {
        $typename = $row["SMUType_Name"] . " - ";
      }
      else{
        $typename = "";
      }
      ?>
      <?php
      $sql = "SELECT * FROM SMU WHERE SMU_ID = $SMU_ID";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      if ($result->num_rows > 0) {
        $name = $row["SMU_Name"];
      }
      else{
        $name = "";
      }
      echo "<div class=\"nav-wrapper\" style=\"height: 122px;\"><a><h5 style=\"margin: 0px; height: 122px;\"><br><br>ดาวน์โหลดเอกสาร$typename$name</h5></a></div>";
      ?> 
    </div>
  </nav>
  <div class="container"><a href="#" data-activates="nav-mobile" class="button-collapse top-nav full"><i class="mdi-navigation-menu"></i></a></div>
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
    
    <?php
    
    $sql = "SELECT paperType_ID ,paperType_Name FROM paperType WHERE paperType_BelongTo = $SMU_ID";
    $result = $conn->query($sql);
    $i = 1;
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $myname = $row["paperType_Name"];
        echo "<li style=\"padding-right: 0px;\"><a href=\"#section-$i\" class=\"waves-effect waves-teal\" style=\"padding: 0px;\">$myname</a></li>";
        $i++;
      }
    }
                    #else {
                    #     echo "<li><a class=\"waves-effect waves-teal\">ไม่พบเอกสาร</a></li>";
                    #}
    
    ?>
  </ul>
</header>
<main>
  <?php
  $sql = "SELECT * FROM paperType WHERE paperType_BelongTo = $SMU_ID";
  $result = $conn->query($sql);
  $i = 1;
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) 
    {
      $myname = $row["paperType_Name"];
      $myID = $row["paperType_ID"];

      echo "<div id =\"section-$i\" class=\"section scrollspy\" style=\"padding-top: 0px; padding-bottom: 0px;\">";
      echo "<div class=\"col s12 m6\">";
      echo "<div class=\"card grey lighten-2\">";
      echo "<div class=\"card-content grey-text text-darken-2\">";
                              echo "<span class=\"card-title grey-text text-darken-2\">$myname</span>"; //หัวข้อ SML
                              echo "<hr>";
                              echo "<br>";
                              $sql_smu = "SELECT paper_Name ,paper_ID ,paper_UploadDate FROM paper WHERE paper_Type = $myID ORDER BY paper_UploadDate ASC";
                              $result_smu = $conn->query($sql_smu);
                              $j = 1;
                              if ($result_smu->num_rows > 0) {
                                echo "<div class=\"container\">";
                                echo "<ul class=\"collection z-depth-1\">";   
                                while($rows = $result_smu->fetch_assoc())
                                {
                                  $paper_name = $rows["paper_Name"];
                                  $paper_id = $rows["paper_ID"];
                                  $paper_uploaddate = $rows["paper_UploadDate"];
                                  
                                    //echo "<a href=\"./SMU_Paper_Download.php?pid=$paper_id\" target=\"_blank\" class=\"collection-item teal-text text-darken-4\">$paper_name ( " . date("d-m-Y", strtotime($paper_uploaddate)) . " )</a>";
                                  echo "<a href=\"./SMU_Paper_Download.php?pid=$paper_id\" class=\"collection-item teal-text text-darken-4\">$paper_name 
                                  <span class=\"badge\">( " . date("d-m-Y", strtotime($paper_uploaddate)) . " )</span>
                                  </a>";
                                  
                                } 
                              }
                              echo "</ul>";
                              echo "</div>";
                              echo "</div>";
                              echo "</div>";
                              echo "</div>";
                              echo "</div>  ";
                              $i++;
                            }
                          }
                          else {
                            //echo $sql_smu.$conn->error;
                            echo "<div class=\"section scrollspy\" style=\"padding-top: 0px; padding-bottom: 0px;\">";
                            echo "<div class=\"col s12 m6\">";
                            echo "<div class=\"card grey lighten-2\">";
                            echo "<div class=\"card-content grey-text text-darken-2\">";
                              echo "<span class=\"card-title grey-text text-darken-2\">ไม่พบเอกสาร</span>"; //หัวข้อ SML
                              echo "</div>";
                              echo "</div>";
                              echo "</div>";
                              echo "</div>  ";
                            }
                            $conn->close();
                            ?>

                            <div class="fixed-action-btn" style="bottom: 25px; right: 25px;">
                              <a class="btn-floating btn-large red tooltipped" href="#top" data-position="left" data-delay="50" data-tooltip="ขึ้นบน">
                                <i class="large mdi-editor-publish" ></i>
                              </a>
                            </div>
                          </main>


                          <!--  Scripts-->
                          <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
                          <script>if (!window.jQuery) { document.write('<script src="bin/jquery-2.1.1.min.js"><\/script>'); }
                          </script>
                          <script src="js/materialize.js"></script>
                          <script src="js/init.js"></script>
                          <!-- Twitter Button -->
                          <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>


                          <script>
                          $("a[href='#top']").click(function () {
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            return false;
                          });
                          </script>
                        </body>
                        </html>