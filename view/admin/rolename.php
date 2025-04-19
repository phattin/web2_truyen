<?php

 require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
    $conn = connectDB::getConnection();
    $sql_data='SELECT `Username`,`RoleName` FROM `role` , `account` WHERE role.RoleID=account.RoleID ';
    $result_sql=$conn->query( $sql_data );

    while($row=$result_sql->fetch_assoc()){
        $data[] = [
            "RoleName"=>$row["RoleName"],
            "UserName"=>$row["Username"],
        ];
    }
    $row=$result_sql->fetch_assoc();

    echo json_encode(
        $data
    );

    $conn->close();
?>