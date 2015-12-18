<?php
        session_start();

        if(!isset($_SESSION['SMU_ID']) || $_SESSION['SMU_ID'] == "" || $_SESSION['SMU_ID'] == null){
          #header("Location: ./index.php");
        }

        $servername = "127.0.0.1";
        $username = "root";
        $password = "imed";
        $dbname = "intranetpaper";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        $conn->query("SET CHARACTER SET 'UTF8'");
        $conn->set_charset("UTF8");
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        #$SMU_ID = $_SESSION['SMU_ID'];
        $SMU_ID = "1000";
?>

<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="Materialize is a modern responsive CSS framework based on Material Design by Google. ">
    <link rel="stylesheet" href="font/PraKas/stylesheet.css" type="text/css" charset="utf-8" />

    <title>จัดการ เอกสารภายใน</title>
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
      <div class="container"><a href="#" data-activates="nav-mobile" class="button-collapse top-nav full"><i class="mdi-navigation-menu"></i></a></div>
      <ul id="nav-mobile" class="side-nav fixed" >
        <li class="logo">
          <a id="logo-container" href="http://www.med.nu.ac.th/" class="brand-logo">
            <img src="pic/14404_logo-med-www.png" alt="" class="circle responsive-img" style="width:150px;">
          </a>
          <li><a href="./" class="waves-effect waves-teal">หน้าหลัก</a></li>
        </li>
        
        <?php
                    echo "<li><a href=\"#section-0\" class=\"waves-effect waves-teal\">เพิ่มเอกสาร</a></li>";
                    $sql = "SELECT paperType_ID ,paperType_Name FROM paperType WHERE paperType_BelongTo = $SMU_ID";
                    $result = $conn->query($sql);
                    $i = 1;
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $myname = $row["paperType_Name"];
                            echo "<li><a href=\"#section-$i\" class=\"waves-effect waves-teal\">$myname</a></li>";
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

    <div id ="section-0" class="section scrollspy" style="padding-top: 0px; padding-bottom: 0px;">
        <div class="col s12 m6">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <span class="card-title">เพิ่มเอกสาร</span>
                    <hr>
                    <div class="row">
                      <div class="row" style="margin:0px;">
                        เพิ่มประเภทเอกสาร
                      </div>
                      <form method="post" action="ajax.php">
                        <div class="input-field col s7 grey lighten-5" style="border-radius: 2px; margin-top:5px;">
                          <input placeholder="" id="first_name" type="text" class="validate grey-text text-darken-3" style="margin-bottom: 2px;">
                        </div>
                        <div class="col s5">
                          <button class="btn waves-effect waves-light" type="submit" name="addPaperType" value="insert_paper" style="line-height: 47px; margin-top:6px; height:45px; margin-top:5px;">เพิ่มประเภท<i class="mdi-av-playlist-add left"></i></button>
                        </div>
                        </form>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="row" style="margin:0px;">
                        เพิ่มเอกสาร
                      </div>
                        <div class="input-field col s7" style="margin-top:0px;">
                            <form method="post" action="ajax.php">
                                <select name="paperTypeSelect" class="grey lighten-5 grey-text text-darken-3">
                                    <?php
                                        $sql = "SELECT paperType_ID ,paperType_Name FROM paperType WHere paperType_BelongTo = " . $SMU_ID ." ORDER BY paperType_Seq ASC" ;
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                        // output data of each row
                                            while($row = $result->fetch_assoc()) {
                                                $paperTypeName = $row["paperType_Name"];
                                                $paperTypeID = $row["paperType_ID"];
                                                echo "<option value=" . $paperTypeID ."\">". $paperTypeName . "</option>";
                                            }
                                        }
                                        else{
                                            echo "<option value=\"\"> ไม่พบเอกสาร </option>";
                                        }
                                    //$conn->close();
                                    ?>
                                </select>
                                <input type="submit" value="Submit the form" class="btn">
                            </form>
                        </div>
                      <div class="col s5">
                          <a class="waves-effect waves-light btn" style="line-height: 30px; margin-top:6px;"><i class="mdi-av-playlist-add left"></i>เพิ่มประเภท</a>
                      </div>
                          <div class="row">
                          <!--Top -->
                          <?php 
                            echo "top <br>";
                          ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                              echo "<div class=\"card blue-grey darken-1\">";
                              echo "<div class=\"card-content white-text\">";
                              echo "<span class=\"card-title\">$myname</span>"; //หัวข้อ SML
                              echo "<hr>";
                              echo "<br>";
                              $sql_smu = "SELECT paper_Name ,paper_ID ,paper_UploadDate FROM paper WHERE paper_Type = $myID ORDER BY paper_UploadDate ASC";
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
                                    echo "<a href=\"#\" class=\"btn red right\" style=\"margin-top:-39px; margin-right: 4px;\"><i class=\"mdi-navigation-close left\" style\"margin-right:5px;\"></i>ลบ</a>";
                                    echo "</ul>";
                                    echo "</div>";
                                } 
                              }
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
                              echo "<div class=\"card blue-grey darken-1\">";
                              echo "<div class=\"card-content white-text\">";
                              echo "<span class=\"card-title\">ไม่พบเอกสาร</span>"; //หัวข้อ SML
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