<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/promotionDB.php"; // File thao tác DB

header('Content-Type: application/json');

// Lấy dữ liệu POST
$promotionID = $_POST['promotionID'] ?? null;
$promotionName = $_POST['promotionName'] ?? null;
$discount = $_POST['discount'] ?? null;
$startDate = $_POST['startDate'] ?? null;
$endDate = $_POST['endDate'] ?? null;

// Kiểm tra thiếu dữ liệu
if (!$promotionID || !$promotionName || !$discount || !$endDate || !$startDate) {
    echo json_encode([
        "success" => false,
        "message" => "Thiếu dữ liệu đầu vào"
    ]);
    exit;
}

// Gọi hàm thêm sản phẩm vào DB
$promotionDB = new promotionDB();
$result = $promotionDB -> addPromotion(
    $promotionID,
    $promotionName,
    $discount,
    $startDate,
    $endDate,
    0
);

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