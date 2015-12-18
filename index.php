<?php
session_start();
include './Connections/conn.php';
include './Connections/connOracle.php';
include 'log.php';
?>

<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <meta name="description" content="Materialize is a modern responsive CSS framework based on Material Design by Google. ">
  <link rel="stylesheet" href="font/PraKas/stylesheet.css" type="text/css" charset="utf-8" />

  <title>ดาวน์โหลด เอกสารภายใน</title>
  <link href="css/ghpages-materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
  <!--[if lt IE 11]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

 <style type="text/css">
 body{
  font-family: 'cs_prakasregular';
}
header, main, footer {
  padding-left: auto;
}
</style>
<header>
  <div class="section scrollspy" id = "section-0" style="padding:0px">

    <nav class="top-nav orange ">
      <div class="container">
        <div class="nav-wrapper"><a class="page-title">ดาวน์โหลดเอกสารภายใน</a></div>                                                                
      </div>
    </nav>

  </div>
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
      
      echo "<li style=\"padding-right: 0px; margin-top:15px;\"><a href=\"#section-0\" class=\"waves-effect waves-cyan accent-1\" style=\"padding: 0px;\">หน้าหลัก</a></li>";
      echo "<li style=\"padding-right: 0px;\"><a href=\"./manual.pdf\" target=\"_blank\" class=\"waves-effect waves-cyan accent-1\" style=\"padding: 0px;\">คู่มือการใช้งานทั่วไป</a></li>";
      echo "<li style=\"padding-right: 0px;\"><a href=\"./user_manual.pdf\" target=\"_blank\" class=\"waves-effect waves-cyan accent-1\" style=\"padding: 0px;\">คู่มือการใช้งานสำหรับจัดการเอกสาร</a></li>";
      echo "<li style=\"padding-right: 0px;\"><a href=\"./intranet_paper_admin.php\"class=\"waves-effect waves-cyan accent-1 modal-trigger\" style=\"padding: 0px;\">หน้าสำหรับผู้ดูแลระบบ</a></li>";
      echo "<li style=\"padding-right: 0px;\"><a href=\"./logout.php\" class=\"waves-effect waves-cyan accent-1\" style=\"padding: 0px;\" >ออกจากระบบ</a></li>";
    }
    else{
      echo "<li style=\"padding-right: 0px; margin-top:15px;\"><a href=\"#section-0\" class=\"waves-effect waves-cyan accent-1\" style=\"padding: 0px;\">หน้าหลัก</a></li>";
      echo "<li style=\"padding-right: 0px;\"><a href=\"./manual.pdf\" target=\"_blank\" class=\"waves-effect waves-cyan accent-1\" style=\"padding: 0px;\">คู่มือการใช้งาน</a></li>";
      echo "<li style=\"padding-right: 0px;\"><a href=\"#modal1\"class=\"waves-effect waves-cyan accent-1 modal-trigger\" style=\"padding: 0px;\">สำหรับผู้ดูแลระบบ</a></li>";
    }
    ?>
    <?php
    $sql = "SELECT SMUType_Name FROM SMUType";
    $result = $conn->query($sql);
    $i = 1;
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $myname = $row["SMUType_Name"];
        echo "<li style=\"padding-right: 0px;\">
        <a href=\"#section-$i\" class=\"waves-effect waves-cyan accent-1\" style=\"padding: 0px;\">$myname</a>
        </li>";
        $i++;
      }
    }
    ?>
  </ul>
</header>
</style>
<main>
 <form method="post" action="login.php">
  <div id="modal1" class="modal">
    <div class="modal-content"style="padding: 10px 10px 0px 10px;">
      <h4>
        สำหรับผู้ดูแลระบบ
      </h4>
      <div class="row" style="margin-bottom: 0px;">
        <form class="row" style="margin-bottom: 0px;">
          <div class="input-field col s6">
            <i class="mdi-action-account-circle prefix">
            </i>
            <input name="userName" type="text" class="validate">
            <label for="icon_prefix">
              ชื่อผู้ใช้
            </label>
          </div>
          <div class="input-field col s6">
            <i class="mdi-communication-vpn-key prefix">
            </i>
            <input name="password" type="password" class="validate">
            <label for="icon_telephone">
              รหัสผ่าน
            </label>
          </div>
        </form>
      </div>
    </div>
    <div class="modal-footer" style="padding: 0px 6px 4px 6px;">
      <a class=" modal-action modal-close btn blue-grey" style="margin-right: 15px;">
        ยกเลิก
      </a>
      <button class=" modal-action modal-close btn blue-grey" style="margin-right: 15px;" type="submit" name="btnLogin">
        ลงชื่อเข้าใช้
      </button>
    </div>
  </div>
</from>

<div class="row" style="margin:0px">
  <div class="card lime grey lighten-5" style="margin: 0px;">
    <form id="search" name="search" method="post" action="search.php" style = "margin:0px;" >
      <div class="col s4">
        <p style="text-align:right;"><b>คำที่ต้องการค้นหา</p></b>
      </div>

      <div class="col s4" align="center">
        <input name="keyword" type="text" id="keyword" style="margin-bottom: 5px; ">
      </div>

      <div class="col s4" style = "padding:5px;">
        <button class="btn waves-effect waves-light blue-grey lighten-1" type="submit" name="action">ค้นหา
          <i class="mdi-content-send right"></i>
        </div>
      </form>
    </div>
  </div>

  <?php 

  $count = function_count("paper_id","paper",$conn);     

  if($count>0) { ?>
  <div id ="section-90" class="section scrollspy" style="padding-top: 0px; padding-bottom: 0px;">
    <div class="col s12 m6">
      <div class="card grey lighten-2" >
        <div class="card-content white-text">
          <span class="card-title grey-text text-darken-2"><?php echo "$count"; ?> เอกสารล่าสุด</span>
          <hr>
          <br>
          <!--             -->
          <?php
          $sql = "SELECT * FROM paper ORDER BY paper_UploadDate DESC";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            echo "<ul class=\"collection z-depth-1\">";
            while($row = $result->fetch_assoc()){
              /*************************************************************************/
              $paper_name = $row['paper_Name'];
              $paper_url = $row['paper_URL'];
              $paper_date = $row['paper_UploadDate'];
              $paper_id = $row['paper_ID'];
              /*************************************************************************/
              /** functionQ("xxxx","xxxx","xxxx","xxxx",$conn);*/
              $paper_type = functionQ("paper_type","paper","paper_ID",$paper_id,$conn); 
              $paperType_belongTo = functionQ("paperType_belongTo","papertype","paperType_ID",$paper_type,$conn);
              $belongTo = functionQ("belongTo","smu","SMU_ID",$paperType_belongTo,$conn);
              $smu_type_name = functionQ("SMUType_Name","smutype","SMUType_ID",$belongTo,$conn);
              $smu_name = functionQ("SMU_NAME","smu","SMU_ID",$paperType_belongTo,$conn);
              /*************************************************************************/ 
              echo "<a href=\"paper/$paper_url\" class=\"collection-item \">$paper_name  $smu_type_name $smu_name 
              <span class=\"badge\">( " . date("d-m-Y", strtotime($paper_date)) . " )</span>
              </a>";
            }
            echo "</ul>"; 
          }
          ?>
        </div>
      </div>
    </div>
  </div>

  <?php } ?>
  <?php
  $sql = "SELECT * FROM SMUType";
  $result = $conn->query($sql);
  $i = 1;
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) 
    {
      $myurl = $row["SMUType_Pic_URL"];
      $myname = $row["SMUType_Name"];
      $myID = $row["SMUType_ID"];

      echo "<div id =\"section-$i\" class=\"section scrollspy\" style=\"padding-top: 0px; padding-bottom: 0px;\">";
      echo "<div class=\"col s12 m6\">";
                              echo "<div class=\"card grey lighten-2\" >"; #blue-grey darken-1 #green darken-4
                              echo "<div class=\"card-content white-text\">";
                              echo "<span class=\"card-title grey-text text-darken-2 \">$myname</span>"; //หัวข้อ SML
                              echo "<hr>";
                              echo "<br>";
                              echo "<div class=\"container z-depth-1\" style=\" padding:0px;\">";
                              $sql_smu = "SELECT * FROM smu where $myID = belongto";
                              $result_smu = $conn->query($sql_smu);
                              $j = 1;

                              if ($result_smu->num_rows > 0) {
                                while($rows = $result_smu->fetch_assoc())
                                {
                                  $smu_name = $rows["SMU_Name"];
                                  $smu_id = $rows["SMU_ID"];
                                  #echo "<div class=\"container \">";
                                  echo "<ul class=\"collection \" style=\"margin:-1px 0px 0px 0px;\">";
                                  echo "<a href=\"./SMU_Paper.php?smutid=$myID&smuid=$smu_id\" class=\"collection-item teal-text text-darken-4\">$smu_name</a>";
                                  echo "</ul>";
                                  #echo "</div>";
                                } 
                              }
                              echo "</div>";
                              echo "</div>";
                              echo "</div>";
                              echo "</div>";
                              echo "</div>  ";
                              $i++;
                            }
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
                        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
                        <script src="js/materialize.js"></script>
                        <script src="js/init.js"></script>
                        <!-- Twitter Button -->
                        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

                        <script>
                        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                        ga('create', 'UA-56218128-1', 'auto');
                        ga('require', 'displayfeatures');
                        ga('send', 'pageview');
                        </script>
                        <script>
                        $("a[href='#top']").click(function () {
                          $("html, body").animate({ scrollTop: 0 }, "slow");
                          return false;
                        });
                        </script>
                      </body>
                      </html>
