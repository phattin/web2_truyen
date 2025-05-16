<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/employeeDB.php"; // File thao tác DB

header('Content-Type: application/json');

// Lấy dữ liệu POST
$employeeID = $_POST['employeeID'] ?? null;
$fullname = $_POST['fullname'] ?? null;
$birthday = $_POST['birthday'] ?? null;
$phone = $_POST['phone'] ?? null;
$email = $_POST['email'] ?? null;
$address = $_POST['address'] ?? null;
$gender = $_POST['gender'] ?? null;
$salary = $_POST['salary'] ?? null;
$startDate = $_POST['startDate'] ?? null;

// Kiểm tra thiếu dữ liệu
if (
    !$employeeID || !$fullname || !$birthday || !$phone || !$email ||
    !$address || !$gender || !$salary || !$startDate
) {
    echo json_encode([
        "success" => false,
        "message" => "Thiếu dữ liệu đầu vào"
    ]);
    exit;
}

// Gọi hàm cập nhật nhân viên trong DB
$employeeDB = new employeeDB();
$result = $employeeDB->updateEmployee(
    $employeeID,
    $fullname,
    $birthday,
    $phone,
    $email,
    $address,
    $gender,
    $salary,
    $startDate,
    0
);

if ($result) {
    echo json_encode([
        "success" => true
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Lỗi khi cập nhật thông tin nhân viên trong database"
    ]);
}
?>