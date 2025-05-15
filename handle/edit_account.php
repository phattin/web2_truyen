<?php
include("../model/ThemSuaXoa.php");

$PasswordNew = $_POST['PasswordNew'];
$UsernameNew = $_POST['UsernameNew'];
$EmployeeID = $_POST['EmployeeID'];
$UsernameOld = $_POST['UsernameOld'];
$IsDeleted = $_POST['IsDeleted'];
$PasswordNewHash=password_hash($PasswordNew, PASSWORD_DEFAULT);

$a = new ThemSuaXoa();

$sql = "UPDATE `account` SET 
    `Username` = '$UsernameNew',
    `Password` = '$PasswordNewHash',
    `EmployeeID` = '$EmployeeID',
    `IsDeleted` = '$IsDeleted'
    WHERE `Username` = '$UsernameOld';";
$a->Sua($sql);


header('Content-Type: application/json');
echo json_encode(["status" => "success"]);
?>
