<?php
include("../model/ThemSuaXoa.php");

header('Content-Type: application/json');

$id = $_GET['Username'] ?? null;

if (!$id) {
    echo json_encode(["status" => "error", "message" => "Thiếu RoleID"]);
    exit;
}

$a = new ThemSuaXoa();

$a->Xoa("DELETE FROM `customer` WHERE Username = '$id'");
$a->Xoa("DELETE FROM `employee` WHERE Username = '$id'");
$a->Xoa("DELETE FROM `account` WHERE Username = '$id'");

echo json_encode(["status" => "success"]);
?>