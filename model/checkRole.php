<?php
    $ID_Role = $_GET['RoleID'];
    include("connectDB.php");
    $a = new connectDB();
    $conn = $a->getConnection();
    $sql = "SELECT * FROM `function_detail` WHERE `RoleID` = '$ID_Role'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)){
        $data[] = [
            "FunctionID" => $row['FunctionID'],
            "Option" => $row['Option']
        ];
    }     
    echo json_encode($data);
    $conn->close();
?>