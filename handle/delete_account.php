<?php
session_start();
include("../model/ThemSuaXoa.php");

header('Content-Type: application/json');
$isLoggedIn = isset($_SESSION['username']) && isset($_SESSION['role']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
$id = $_GET['Username'] ?? null;
if ($isLoggedIn == $id) {
    echo json_encode(["status" => "error", "message" => "Không thể xóa tài khoản đang đăng nhập"]);
    exit;
}
if (!$id) {
    echo json_encode(["status" => "error", "message" => "Thiếu username"]);
    exit;
}

$a = new ThemSuaXoa();

$a->Xoa("DELETE FROM `account` WHERE Username = '$id'");

echo json_encode(["status" => "success"]);
?>