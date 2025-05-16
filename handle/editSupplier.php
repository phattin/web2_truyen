<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/supplierDB.php"; // File thao tác DB

header('Content-Type: application/json');

// Lấy dữ liệu POST
$supplierID = $_POST['supplierID'] ?? null;
$supplierName = $_POST['supplierName'] ?? null;
$phone = $_POST['phone'] ?? null;
$email = $_POST['email'] ?? null;
$address = $_POST['address'] ?? null;

// Kiểm tra thiếu dữ liệu
if (!$supplierID || !$supplierName || !$phone || !$email || !$address) {
    echo json_encode([
        "success" => false,
        "message" => "Thiếu dữ liệu đầu vào"
    ]);
    exit;
}

// Gọi hàm cập nhật nhà cung cấp trong DB
$supplierDB = new supplierDB();
$result = $supplierDB->updateSupplier(
    $supplierID,
    $supplierName,
    $phone,
    $email,
    $address,
    0 // IsDeleted = 0 (còn hoạt động)
);

if ($result) {
    echo json_encode([
        "success" => true
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Lỗi khi chỉnh sửa database"
    ]);
}
?>
