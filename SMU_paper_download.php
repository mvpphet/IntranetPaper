<?php
        include './Connections/conn.php';

        if(isset($_GET["pid"]))
        {
          $P_ID = $_GET["pid"];

        $sql = "SELECT paper_URL FROM paper WHERE paper_ID = $P_ID"; #หาชนิดเอกสาร
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $paperURL = $row["paper_URL"];
                if($paperURL === null)
                {
                    echo "ไม่พบเอกสาร";
                }
                else{
                    header("Location: ./paper/$paperURL");
                    die();
                }
            }
            else{
            echo "ไม่พบเอกสาร";
            }
        $conn->close();
        }
        else{
            echo "ไม่พบเอกสาร";
        }


        /*$sql = "SELECT paper_Type FROM paper WHERE paper_ID = $P_ID"; #หาชนิดเอกสาร
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
               $paperType = $row["paper_Type"];
                    $sql = "SELECT paperType_BelongTo FROM paperType WHERE paperType_ID = $paperType"; #หาsmu
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $smuID = $row["paperType_BelongTo"];
                        $sql = "SELECT BelongTo FROM SMU WHERE SMU_ID = $smuID"; #หาsmuType
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $smuTypeID = $row["paperType_BelongTo"];
                    echo "";
                }
            }
        }*/
?>