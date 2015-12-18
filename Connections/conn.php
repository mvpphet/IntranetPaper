<?php
        $servername = "med-p1-b2:3307";
        $username = "intranetpaper";
        $password = "12345678p@";
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