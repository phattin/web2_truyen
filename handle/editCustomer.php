<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/customerDB.php"; // File thao tác DB

header('Content-Type: application/json');

// Lấy dữ liệu POST
$customerID = $_POST['customerID'] ?? null;
$fullname = $_POST['fullname'] ?? null;
$email = $_POST['email'] ?? null;
$address = $_POST['address'] ?? null;
$phone = $_POST['phone'] ?? null;

// Kiểm tra thiếu dữ liệu
if (!$customerID || !$fullname || !$email || !$address || !$phone) {
    echo json_encode([
        "success" => false,
        "message" => "Thiếu dữ liệu đầu vào"
    ]);
    exit;
}

// Gọi hàm cập nhật khách hàng trong DB
$customerDB = new customerDB();
$result = $customerDB->updateCustomer(
    $customerID,
    $fullname,
    $email,
    $address,
    $phone
);

if ($result) {
    echo json_encode([
        "success" => true
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Lỗi khi cập nhật thông tin khách hàng trong database"
    ]);
}
?>