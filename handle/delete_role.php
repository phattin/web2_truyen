<?php
include("../model/ThemSuaXoa.php");

header('Content-Type: application/json');

$id = $_GET['RoleID'] ?? null;

if (!$id) {
    echo json_encode(["status" => "error", "message" => "Thiếu RoleID"]);
    exit;
}

$a = new ThemSuaXoa();

// Xóa ở bảng `function_detail` trước (nếu có khóa ngoại)
// Xóa ở bảng `role` sau
$a->Xoa("UPDATE `account` SET `RoleID`='R003' WHERE RoleID = '$id'");
$a->Xoa("DELETE FROM `function_detail` WHERE RoleID = '$id'");
$a->Xoa("DELETE FROM `role` WHERE RoleID = '$id'");

echo json_encode(["status" => "success"]);
?>