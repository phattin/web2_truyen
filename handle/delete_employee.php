<?php
include("../model/ThemSuaXoa.php");

header('Content-Type: application/json');

$id = $_GET['EmployeeID'] ?? null;

if (!$id) {
    echo json_encode(["status" => "error", "message" => "Thiếu RoleID"]);
    exit;
}

$a = new ThemSuaXoa();


$a->Xoa("DELETE FROM `account` WHERE EmployeeID = '$id'");
$a->Xoa("DELETE FROM `employee` WHERE EmployeeID = '$id'");

echo json_encode(["status" => "success"]);
?>