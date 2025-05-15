<?php
include("../model/ThemSuaXoa.php");


$UsernameOld = $_POST['UsernameOld'];
$IsDeleted = $_POST['IsDeleted'];

$a = new ThemSuaXoa();

// Cập nhật bảng account trước
$sql = "UPDATE `account` SET 
    `IsDeleted` = '$IsDeleted'
    WHERE `Username` = '$UsernameOld';";
$a->Sua($sql);


header('Content-Type: application/json');
echo json_encode(["status" => "success"]);
?>
