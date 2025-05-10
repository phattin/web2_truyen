<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/productDB.php"; // File thao tác DB

header('Content-Type: application/json');

// Lấy dữ liệu POST
$productID = isset($_POST['id']) ? $_POST['id'] : null;

// Kiểm tra thiếu dữ liệu
if (!$productID) {
    echo json_encode([
        "success" => false,
        "message" => "Thiếu dữ liệu đầu vào"
    ]);
    exit;
}

// Gọi hàm xóa sản phẩm trong DB
$productDB = new productDB();
$result = $productDB->removeProduct($productID);

if ($result) {
    echo json_encode([
        "success" => true
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Lỗi khi xóa sản phẩm trong database"
    ]);
}
?>
