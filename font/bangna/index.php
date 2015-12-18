<?php
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


?>


<html>
<head>
    <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <link rel="stylesheet" href="css/all.min-9cc91b65.css">
    <link rel="stylesheet" href="css/vendor.min-01a3ae75.css">
        <link rel="stylesheet" href="stylesheet.css" type="text/css" charset="utf-8" />

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

    <title>ทดสอบ</title>
</head>
<body>

<style type="text/css">
                    body{
                font-family: 'bangna_newregular';
                            }
        </style>
<div class="io-site">
        <div class="io-nav" style="visibility: inherit; opacity: 1;">
            <div class="io-nav-inner" style="transform: matrix(1, 0, 0, 1, 0, 0);">
                <header class="io-nav-header red accent-2" style="width: 250px;">
                    <div class="io-nav-text">
                        <div class="io-nav-header-name white-text darken-1" style="visibility: inherit; opacity: 1;">
                            Joel <strong>Cox</strong>
                        </div>
                        <div class="io-nav-header-email" style="visibility: inherit; opacity: 1;">
                        Ui &amp; UX Designer
                        </div>
                        <div class="io-nav-header-email" style="visibility: inherit; opacity: 1;">
                        JavaScript Engineer
                        </div>
                    </div>
                </header>
                
                <div class="io-navigation ng-scope" du-scroll-container="container">
                    <a href="toptest.php" du-smooth-scroll="" du-scrollspy="" class="io-navigation-item waves-effect">
                        <i class="mdi-social-person red-text accent-2" style="visibility: inherit;"></i>
                        <div class="io-navigation-item-text grey-text darken-1" style="margin-left: 0px; visibility: inherit; opacity: 1;">Home</div>
                    </a>
                    <a href="#section-1" du-smooth-scroll="" du-scrollspy="" class="io-navigation-item waves-effect">
                        <i class="mdi-social-person red-text accent-2" style="visibility: inherit;"></i>
                        <div class="io-navigation-item-text grey-text darken-1" style="margin-left: 0px; visibility: inherit; opacity: 1;">Profile</div>
                    </a>
                    <a href="#section-2" du-smooth-scroll="" du-scrollspy="" class="io-navigation-item waves-effect">
                        <i class="mdi-social-person red-text accent-2" style="visibility: inherit;"></i>
                        <div class="io-navigation-item-text grey-text darken-1" style="margin-left: 0px; visibility: inherit; opacity: 1;">Profile</div>
                    </a>
                </div>
                 
            </div>
        </div>
        
        <div class="io-container ng-scope" id="container" du-scroll-container="">

            <div class="io-content io-profile" id="section-1" style="visibility: inherit; opacity: 1;">
                <div class="io-profile-header">
                    <h1 class="grey-text text-darken-1 ng-binding">Joel<strong class="ng-binding">Cox</strong></h1>
                </div>
            </div>

            <div class="io-content" id="section-2" style="visibility: inherit; opacity: 1;">
                <div class="col s12 io-content-header red accent-2">
                    <h1 class="white-text">Test ภาษาไทย</h1>
                </div>
            </div>
        </div>
    

    
    </div>    

    <script src="js/vendor.min-73bda590.js"></script>
</body>
</html>