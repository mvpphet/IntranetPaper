﻿<?php
  include './Connections/conn.php';
  include './Connections/connOracle.php';
  session_start();

  if(!isset($_SESSION['SMU_ID']) || $_SESSION['SMU_ID'] == "" || $_SESSION['SMU_ID'] == null){
    header("Location: ./index.php");
  }
  
  $SMU_ID = $_SESSION['SMU_ID'];
?>

<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="Materialize is a modern responsive CSS framework based on Material Design by Google. ">
    <link rel="stylesheet" href="font/PraKas/stylesheet.css" type="text/css" charset="utf-8" />
    <link href="css/ghpages-materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="css/style.css" rel="stylesheet" type="text/css">
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
            $sql = "SELECT SMU_Name , belongTo FROM SMU WHERE SMU_ID = $SMU_ID";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if ($result->num_rows > 0) {
              $name = $row["SMU_Name"];
              $SMUT_ID = $row["belongTo"];
            }
            else{
              $name = "";
            }

            $sql = "SELECT SMUType_Name FROM SMUType WHERE SMUType_ID = $SMUT_ID";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if ($result->num_rows > 0) {
              $typename = $row["SMUType_Name"] . " - ";
            }
            else{
              $typename = "";
            }

            echo "<div class=\"nav-wrapper\" style=\"height: 122px;\"><a><h5 style=\"margin: 0px; height: 122px;\"><br><br>จัดการเอกสาร$typename$name</h5></a></div>";
            #echo "<div class=\"nav-wrapper\" style=\"height: 122px;\"><div style=\"vertical-align:50%;\"><p style=\"height: 122px;\">ดาวน์โหลดเอกสาร$typename$name</p></div></div>";
          ?> 
        </div>
      </nav>
      <div class="container">
        <a href="#" data-activates="nav-mobile" class="button-collapse top-nav full">
          <i class="mdi-navigation-menu">
          </i>
        </a>
      </div>
      <ul id="nav-mobile" class="side-nav fixed" >
        <li class="logo" style="margin-bottom:0px;">
          <a id="logo-container" href="http://www.med.nu.ac.th/" class="brand-logo">
            <img src="pic/14404_logo-med-www.png" alt="" class="circle responsive-img" style="width:150px;">
          </a>
        </li>
        <?php

      $stid = oci_parse($con, "select MNAME from HR.V_EMPLOY WHERE INTERNETACCOUNT = '".$_SESSION['U_ID']."'");
          oci_execute($stid);

          if(($row = oci_fetch_assoc($stid))){
            $Name = $row['MNAME'];
          }

          oci_free_statement($stid);
          //oci_close($con);
      
      echo "<li class=\"grey lighten-2\" style=\"padding-left: 0px; padding-right: 0px;\"><a class=\"waves-effect waves-cyan accent-1 grey lighten-2\" style=\"padding-right: 0px;\">สวัสดี ".$Name."</a></li>";
      
      echo "<li style=\"padding-right: 0px; margin-top:15px;\"><a href=\"./\" class=\"waves-effect waves-cyan accent-1\" style=\"padding: 0px;\">หน้าหลัก</a></li>";
      echo "<li style=\"padding-right: 0px;\"><a href=\"./logout.php\" class=\"waves-effect waves-cyan accent-1\" style=\"padding: 0px;\" >ออกจากระบบ</a></li>";
    ?>

        <?php

          if($_SESSION['USER_AUTHU'] == "0"){
            echo "<li style=\"padding-right: 0px;\"><a href=\"#section-A\" class=\"waves-effect waves-teal\" style=\"padding: 0px;\">จัดการสิทธิ์</a></li>";
          }

          echo "<li style=\"padding-right: 0px;\"><a href=\"#section-T\" class=\"waves-effect waves-teal\" style=\"padding: 0px;\">เพิ่มประเภทเอกสาร</a></li>";

          $sql = "SELECT * FROM paperType WHERE paperType_BelongTo = $SMU_ID";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
          echo "<li style=\"padding-right: 0px;\"><a href=\"#section-P\" class=\"waves-effect waves-teal\" style=\"padding: 0px;\">เพิ่มเอกสาร</a></li>";
          }
          $sql = "SELECT paperType_ID ,paperType_Name FROM paperType WHERE paperType_BelongTo = $SMU_ID ORDER BY paperType_Seq ASC";
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
      if($_SESSION['USER_AUTHU'] == "0"){
      ?>

      <div id ="section-A" class="section scrollspy" style="padding-top: 0px; padding-bottom: 0px;">
        <div class="row" style="margin:0px;">
          <div class="card grey lighten-2" style="overflow: visible; margin-bottom: 0px;" >
            <div class="card-content grey-text text-darken-2" >
              <span class="card-title grey-text text-darken-2">
                จัดการสิทธิ์
              </span>
              <hr>
              <span>
                เพิ่มสิทธิ์
              </span>
              <div class="row" style="margin:-12px 0px 0px 0px;">
                <form method="post" action="operate.php" value="addPermission" style="margin-top:0px;">
                  <div class="input-field col s6" style="margin-top:0px; padding:0px; border-radius: 2px;">
                    <select name="userName" class="grey lighten-5 grey-text text-darken-3">
                      <?php
                        $sql = "SELECT HR_SMU_ID FROM smu_mapping WHere THIS_SMU_ID = " .$_SESSION['SMU_ID']."";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                          while($row = $result->fetch_assoc()) {
                            $hrid = $row["HR_SMU_ID"];

                            $stid = oci_parse($con, "SELECT MNAME , INTERNETACCOUNT FROM HR.V_EMPLOY WHERE SMUCODE = '".$hrid."' ORDER BY MNAME ASC");
                            oci_execute($stid);
                            while(($rowOc = oci_fetch_assoc($stid)) != false){
                              $acc = $rowOc['INTERNETACCOUNT'];
                              $mname = $rowOc['MNAME'];
                              echo "<option value=\"$acc\">". $mname . "</option>";
                            }

                            oci_free_statement($stid);
                            //oci_close($con);
                          }
                        }
                        else{
                          echo "<option value=\"\"> ไม่พบบุคลากร </option>";
                        }
                      ?>
                    </select>
                  </div>
                  <!-- <div class="input-field col s2 grey lighten-5" style="border-radius: 2px; margin-top:5px; margin-left:5px;"> -->
                  <div class="input-field col s2" style=" border-radius: 2px; padding:0px; margin-left:5px; margin-top:0px;">
                    <select name="permissionSelect" class="grey lighten-5 grey-text text-darken-3">
                      <option value="1"> user </option>
                      <option value="0"> Super user </option>
                    </select>
                  </div>
                </div>
                <div class="row" style="margin:0px 0px 0px 0px;">
                  <button class="btn waves-effect waves-light" type="submit" name="addPermission" value="addPermission" style="position: relative; z-index: 0;">
                    ดำเนินการ
                    <i class="mdi-action-assignment-ind left">
                    </i>
                  </button>
                </div>
              </form>
              <hr>
              <span>
                ลบสิทธิ์
              </span>
              <div class="row" style="margin:0px 0px 0px 0px;">
                <form method="post" action="operate.php">
                  <?php
                    $sql = "SELECT HR_SMU_ID FROM smu_mapping WHere THIS_SMU_ID = " .$_SESSION['SMU_ID']."";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                        $hrid = $row["HR_SMU_ID"];

                        $stid = oci_parse($con, "SELECT MNAME , INTERNETACCOUNT FROM HR.V_EMPLOY WHERE SMUCODE = '".$hrid."' ORDER BY MNAME ASC");
                        oci_execute($stid);

                        while(($rowOc = oci_fetch_assoc($stid)) != false){
                          $acc = $rowOc['INTERNETACCOUNT'];
                          $mname = $rowOc['MNAME'];
                          if($acc != $_SESSION['U_ID']){
                            $sql_smu = "SELECT permission.authorization FROM permission WHERE permission.userName = '$acc' ";
                            $result_smu = $conn->query($sql_smu);
                            //die($conn->error);
                            if ($result_smu->num_rows > 0) {
                              //////////////////////////////////////////////////////////////////////////////////////////
                              while($rows = $result_smu->fetch_assoc()){
                                $aut = $rows['authorization'];
                                if($aut == 0){
                                  $autC = "Super user";
                                }
                                else{
                                  $autC = "user";
                                }

                                  echo "<div class=\"container\">";
                                  echo "<ul class=\"collection\">";
                                  echo "<a class=\"collection-item teal-text text-darken-4\">$mname เป็น $autC</a>";
                                  echo "<button class=\"btn red right\" type=\"submit\" name=\"deletePermission\" value=\"$acc\" style=\"margin-top:-39px; margin-right: 4px;\"><i class=\"mdi-navigation-close left\" style\"margin-right:5px;\"></i>ลบ</button>";
                                  echo "</ul>";
                                  echo "</div>";
                              } 
                            }
                          }
                        }
                        oci_free_statement($stid);
                      }
                    }
                    oci_close($con);
                  ?>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php
      }
      ?>

      <div id ="section-T" class="section scrollspy" style="padding-top: 0px; padding-bottom: 0px;">
        <div class="row" style="margin:0px;">
          <div class="card grey lighten-2" style="overflow: visible; margin-bottom: 0px;" >
            <div class="card-content grey-text text-darken-2" >
              <span class="card-title grey-text text-darken-2">
                เพิ่มประเภทเอกสาร
              </span>
              <hr>
              <span class="grey-text text-darken-2">
                ชื่อประเภทเอกสาร
              </span>
              <div class="row" style="margin:-12px 0px 10px 0px;">
                <form method="post" action="operate.php" value="addPaperType">
                  <div class="input-field col s7 grey lighten-5" style="border-radius: 2px; margin-top:5px;">
                    <input placeholder="" name="typeName" type="text" class="validate grey-text text-darken-3" style="margin-bottom: 2px;">
                  </div>
                </div>
                <div class="row" style="margin:0px 0px 0px 0px;">
                  <button class="btn waves-effect waves-light" type="submit" name="addPaperType" value="insert_paper" style="position: relative; z-index: 0;">
                    เพิ่มประเภท
                    <i class="mdi-av-playlist-add left">
                    </i>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php
        $sql = "SELECT * FROM paperType WHERE paperType_BelongTo = $SMU_ID";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
      ?>
      <div id ="section-P" class="section scrollspy" style="padding-top: 0px; padding-bottom: 0px;">
        <div class="row" style="margin:0px;">
          <div class="card grey lighten-2 grey-text text-darken-2" style="overflow: visible; margin-bottom: 0px;" >
            <div class="card-content grey-text text-darken-2" >
              <span class="card-title grey-text text-darken-2">
                เพิ่มเอกสาร
              </span>
              <hr>
              <form action="operate.php" method="post" enctype="multipart/form-data" id="MyUploadForm" style="margin:0px;">                         
                <div class="row" style="margin:0px;">
                  <span>
                      ชื่อเอกสาร
                  </span>
                  <div class="row">
                    <div class="input-field col s7 grey lighten-5" style="border-radius: 2px; margin-top:5px;">
                      <input placeholder="" name="paperName" type="text" class="validate grey-text text-darken-3" style="margin-bottom: 2px;">
                    </div>
                  </div>
                  <span>
                      ประเภทเอกสาร
                  </span>
                  <div class="row" style="margin:0px;">
                    <div class="input-field col s7" style="margin-top:0px; padding:0px; border-radius: 2px;">
                      <select name="paperTypeSelect" class="grey lighten-5 grey-text text-darken-3">
                        <?php
                          $sql = "SELECT paperType_ID ,paperType_Name FROM paperType WHere paperType_BelongTo = " . $SMU_ID ." ORDER BY paperType_Seq ASC" ;
                          $result = $conn->query($sql);
                          if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                              $paperTypeName = $row["paperType_Name"];
                              $paperTypeID = $row["paperType_ID"];
                              echo "<option value=\"$paperTypeID\">". $paperTypeName . "</option>";
                            }
                          }
                          else{
                            echo "<option value=\"\"> ไม่พบเอกสาร </option>";
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row" style="margin:0px 0px 5px 0px;">
                      <div class="row">
                        <div class="row" style="margin:0px;">
                          <input type="file" class="custom-file-input grey-text text-darken-2" name="FileInput" id="FileInput"/>
                        </div>
                        <div class="col 6" style="text-align:left;">
                        </div>
                       <!--  <img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/> -->
                      </div>
                      <div id="progressbox" >
                        <div id="progressbar">
                        </div >
                        <div id="statustxt">
                          0%
                        </div>
                      </div>
                      <div id="output">
                      </div>
                </div> 
                <button class="btn waves-effect waves-light" type="submit" name="submit-btn" style="position: relative; z-index: 0;">
                    เพิ่มเอกสาร
                    <i class="mdi-av-playlist-add left">
                    </i>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php
        }
      ?>

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
                              echo "<form method=\"post\" action=\"operate.php\" style=\"margin:0px;\" name=\"deletePaperTypeForm\" id=\"deletePaperTypeForm\">";
                              echo "<div class=\"row\" style=\"margin-bottom:-15px;\">";
                              echo "<div class=\"card grey lighten-2\">";
                              echo "<div class=\"card-content grey-text text-darken-2\">";
                              echo "<span class=\"card-title grey-text text-darken-2\">$myname</span>"; //หัวข้อ SML
                              echo "<button class=\"btn waves-effect waves-light right red\" type=\"submit\" name=\"deletePaperType\" value=\"$myID\" style=\"line-height: 47px; margin-top:6px; height:45px; margin-top:0px;\">ลบประเภทเอกสาร<i class=\"mdi-navigation-close left\"></i></button> ";
                              //echo "<button class=\"btn waves-effect waves-light right red\" onclick=\"if(confirm('ยืนยันการลบข้อมูล')){document.deletePaperType.submit();};\" type=\"button\" name=\"deletePaperType\" id=\"deletePaperType\" value=\"$myID\" style=\"line-height: 47px; margin-top:6px; height:45px; margin-top:0px;\" >ลบประเภทเอกสาร<i class=\"mdi-navigation-close left\"></i></button> ";
                              echo "</form>";
                              echo "<hr>";
                              echo "<br>";
                              echo "<form method=\"post\" action=\"operate.php\">";
                              $sql_smu = "SELECT paper_Name ,paper_ID ,paper_UploadDate FROM paper WHERE paper_Type = $myID ORDER BY paper_UploadDate DESC";
                              $result_smu = $conn->query($sql_smu);
                              $j = 1;
                              if ($result_smu->num_rows > 0) {
                                while($rows = $result_smu->fetch_assoc())
                                {
                                  $paper_name = $rows["paper_Name"];
                                  $paper_id = $rows["paper_ID"];
                                  $paper_uploaddate = $rows["paper_UploadDate"];
                                    echo "<div class=\"container\">";
                                    echo "<ul class=\"collection\">";
                                    echo "<a href=\"./SMU_Paper_Download.php?pid=$paper_id\" target=\"_blank\" class=\"collection-item teal-text text-darken-4\">$paper_name ( " . date("d-m-Y", strtotime($paper_uploaddate)) . " )</a>";
                                    echo "<button class=\"btn red right\" type=\"submit\" name=\"deletePaper\" value=\"$paper_id\" style=\"margin-top:-39px; margin-right: 4px;\"><i class=\"mdi-navigation-close left\" style\"margin-right:5px;\"></i>ลบ</button>";
                                    echo "</ul>";
                                    echo "</div>";
                                } 
                              }
                              echo "</form>";
                              echo "</div>";
                              echo "</div>";
                              echo "</div>";
                              echo "</div>  ";
                            $i++;
                          }
                        }
                        else {
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
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="js/jquery.form.min.js"></script>
    <script type="text/javascript" src="js/med.js"></script>
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