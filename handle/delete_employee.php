<?php
include("../model/ThemSuaXoa.php");

header('Content-Type: application/json');

$id = $_GET['IDaccount'] ?? null;

if (!$id) {
    echo json_encode(["status" => "error", "message" => "Thiếu RoleID"]);
    exit;
}

$a = new ThemSuaXoa();

// Xóa ở bảng `function_detail` trước (nếu có khóa ngoại)
// Xóa ở bảng `role` sau
$a->Xoa("DELETE FROM `employee` WHERE EmployeeID = '$id'");

echo json_encode(["status" => "success"]);
?>