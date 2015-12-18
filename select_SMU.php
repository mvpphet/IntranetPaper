<?php
	session_start();
	if(!isset($_SESSION['U_ID']) || $_SESSION['U_ID'] == "" || $_SESSION['U_ID'] == null){
    header("Location: ./index.php");
  	}
  	
  	include './Connections/conn.php';

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

      <nav class="top-nav orange">
        <div class="container">
          <div class="nav-wrapper"><a class="page-title">หน้าใช้งานชั่วคราว กรุณาติดต่อ 5041</a></div>                                                                
        </div>
      </nav>

    </div>
      <div class="container"><a href="#" data-activates="nav-mobile" class="button-collapse top-nav full"><i class="mdi-navigation-menu"></i></a></div>
      <ul id="nav-mobile" class="side-nav fixed" >
        <li class="logo">
          <a id="logo-container" href="http://www.med.nu.ac.th/" class="brand-logo">
            <img src="pic/14404_logo-med-www.png" alt="" class="circle responsive-img" style="width:150px;">
          </a>
        </li>
        


        <li style="padding-right: 0px;"><a href="#section-0" class="waves-effect waves-cyan accent-1" style="padding: 0px;">หน้าหลัก</a></li>
        <?php
        	echo "<li style=\"padding-right: 0px;\"><a href=\"./logout.php\" class=\"waves-effect waves-cyan accent-1 modal-trigger\" style=\"padding: 0px;\" >ออกจากระบบ</a></li>";
        $sql = "SELECT * FROM SMUType";
          $result = $conn->query($sql);
          $i = 1;
          #$row["SMUType_Pic_URL"];
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              $myurl = $row["SMUType_Pic_URL"];
              $myname = $row["SMUType_Name"];
              echo "<li style=\"padding-right: 0px;\"><a href=\"#section-$i\" class=\"waves-effect waves-cyan accent-1\" style=\"padding: 0px;\">$myname</a></li>";

              #echo "<ul class=\"collection\">";
              #echo "<a href=\"\" class=\"collection-item\" style=\"text-align: center; vertical-align: center;\">$myname</a>";
              #echo "</ul>";
              $i++;
           }
          }

        ?>
      </ul>
    </header>
    </style>
    <main>
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
                              echo "<div class=\"card blue-grey darken-1\" >"; #blue-grey darken-1 #green darken-4
                              echo "<div class=\"card-content white-text\">";
                              echo "<span class=\"card-title\">$myname</span>"; //หัวข้อ SML
                              echo "<hr>";
                              echo "<br>";
                              $sql_smu = "SELECT * FROM smu where $myID = belongto AND (SMUMap IS NULL AND SMUMap2 IS NULL)";
                              $result_smu = $conn->query($sql_smu);
                              $j = 1;

                              if ($result_smu->num_rows > 0) {
                                while($rows = $result_smu->fetch_assoc())
                                {
                                  $smu_name = $rows["SMU_Name"];
                                  $smu_id = $rows["SMU_ID"];
                                    echo "<div class=\"container\">";
                                    echo "<ul class=\"collection\">";
                                    echo "<a href=\"./select_SMU_Op.php?smuid=$smu_id\" class=\"collection-item teal-text text-darken-4\">$smu_name</a>";
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