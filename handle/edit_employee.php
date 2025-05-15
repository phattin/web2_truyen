<?php
include("../model/ThemSuaXoa.php");
if (!$_POST['EmployeeID']) {
    echo json_encode(["status" => "error", "message" => "Thiếu ID"]);
    exit;
}
$a= new ThemSuaXoa();
$sql = "UPDATE `employee` SET 
    `Fullname`='{$_POST['Fullname']}',
    `BirthDay`='{$_POST['BirthDay']}',
    `Phone`='{$_POST['Phone']}',
    `Email`='{$_POST['Email']}',
    `Address`='{$_POST['Address']}',
    `Gender`='{$_POST['Gender']}',
    `Salary`='{$_POST['Salary']}',
    `IsDeleted`='{$_POST['IsDeleted']}'
    WHERE `EmployeeID` = '{$_POST['EmployeeID']}';";
$a->Them($sql);
header('Content-Type: application/json');
echo json_encode(["status" => "success"]);

?>