<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/accountDB.php"; // File thao tác DB

header('Content-Type: application/json');

// Lấy dữ liệu POST
$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;
$employeeID = $_POST['employeeID'] ?? null;
$roleID = $_POST['roleID'] ?? null;

// Kiểm tra thiếu dữ liệu
if (!$username || !$password || !$employeeID || !$roleID) {
    echo json_encode([
        "success" => false,
        "message" => "Thiếu dữ liệu đầu vào"
    ]);
    exit;
}

// Mã hóa mật khẩu
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Gọi hàm thêm tài khoản vào DB
$accountDB = new accountDB();
$result = $accountDB->addAccount($username, $hashedPassword, $employeeID, $roleID);

if ($result) {
    echo json_encode([
        "success" => true
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Lỗi khi thêm vào database"
    ]);
}
?>
