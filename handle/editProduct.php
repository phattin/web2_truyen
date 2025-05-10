<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/productDB.php"; // File thao tác DB

header('Content-Type: application/json');

// Lấy dữ liệu POST
$productID = $_POST['productID'] ?? null;
$productName = $_POST['productName'] ?? null;
$productImg = $_POST['productImg'] ?? null; // Nếu là link ảnh/text
$author = $_POST['author'] ?? null;
$publisher = $_POST['publisher'] ?? null;
$description = $_POST['description'] ?? null;
$quantity = $_POST['quantity'] ?? 0;
$importPrice = $_POST['importPrice'] ?? 0;
$ros = $_POST['ros'] ?? 0;
$supplierID = $_POST['supplierID'] ?? null;

// Kiểm tra thiếu dữ liệu
if (!$productID || !$productName || !$author || !$publisher || !$supplierID) {
    echo json_encode([
        "success" => false,
        "message" => "Thiếu dữ liệu đầu vào"
    ]);
    exit;
}

// Gọi hàm thêm sản phẩm vào DB
$productDB = new productDB();
$result = $productDB -> updateProduct(
    $productID,
    $productName,
    $productImg,
    $author,
    $publisher,
    $quantity,
    $importPrice,
    $ros,
    $description,
    $supplierID,
    0
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