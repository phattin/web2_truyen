<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/accountDB.php"; // File thao tác DB
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/roleDB.php"; // File thao tác DB
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/employeeDB.php"; // File thao tác DB

header('Content-Type: application/json');

// Lấy dữ liệu POST
$username = $_POST['username'] ?? null;
$employeeID = $_POST['employeeID'] ?? null;
$roleID = $_POST['roleID'] ?? null;

// Kiểm tra thiếu dữ liệu
if (!$username || !$employeeID || !$roleID) {
    echo json_encode([
        "success" => false,
        "message" => "Thiếu dữ liệu đầu vào"
    ]);
    exit;
}

$employee = employeeDB::getEmployeeByID($employeeID);
$employeeName = $employee["Fullname"] ?? null;
$role = roleDB::getRoleByID($roleID);
$roleName = $role["RoleName"] ?? null;

// Gọi hàm cập nhật tài khoản trong DB
$accountDB = new accountDB();
$result = $accountDB->updateAccountWithoutPassword($username, $employeeID, $roleID);


if ($result) {
    echo json_encode([
        "success" => true,
        "message" => "Cập nhật tài khoản thành công",
        "roleName" => $roleName,
        "employeeName" => $employeeName
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Lỗi khi cập nhật tài khoản trong database"
    ]);
}
