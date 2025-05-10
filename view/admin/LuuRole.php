<?php
include ("../../model/ThemSuaXoa.php");

$permissions = json_decode($_POST['permissions'], true);
$a = New ThemSuaXoa();
foreach ($permissions as $permission) {
    $username = $permission['id'];
    $option = $permission['selectedValue'];

    // Lấy RoleID từ bảng Role
    $sql = "SELECT RoleID FROM `role` WHERE RoleName='$option'";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
    $conn = connectDB::getConnection();
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $roleID = $row['RoleID'];
    $conn->close();
    // Cập nhật quyền cho tài khoản
    $sql = "UPDATE `account` SET `RoleID`='$roleID' WHERE Username='$username'";
    $a->Sua($sql);

}

// Trả về kết quả
echo json_encode([
    "status" => "success",
    "message" => "Cập nhật quyền thành công"
]);
?>