<?php
        include './Connections/conn.php';
        session_start();
        if(!isset($_SESSION['U_ID']) || $_SESSION['U_ID'] == "" || $_SESSION['U_ID'] == null){
        header("Location: ./index.php");
        }

        if(!isset($_GET["smuid"]))
        {
          header("Location: ./index.php");
          die();
        }
        else
        {
            $_SESSION['SMU_ID'] = $_GET["smuid"];
        }

        header("Location: ./intranet_paper_admin.php");
        die();
?>