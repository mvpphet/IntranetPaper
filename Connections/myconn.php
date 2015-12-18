<?php
        $servername = "10.32.172.132";
        $username = "wantpaper";
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