<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/productDB.php"; // File thao tác DB

header('Content-Type: application/json');
$fileName = "";
// Kiểm tra nếu có file ảnh được gửi lên
if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/view/layout/images/";
    $fileTmpPath = $_FILES['productImage']['tmp_name'];
    $fileName = basename($_FILES['productImage']['name']);
    
    // Đổi tên file cho tránh trùng
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
    $newFileName = uniqid('img_', true) . '.' . $extension;
    $destPath = $uploadDir . $newFileName;
    $productImg = $newFileName;

    // Lưu file
    if (!move_uploaded_file($fileTmpPath, $destPath)) {
        echo json_encode([
            "success" => false,
            "message" => "Lỗi khi lưu file ảnh"
        ]);
        exit;
    }
}
// Lấy dữ liệu POST
$productID = $_POST['productID'] ?? null;
$productName = $_POST['productName'] ?? null;
$categoryID = $_POST['category'] ?? null;
$author = $_POST['author'] ?? null;
$publisher = $_POST['publisher'] ?? null;
$description = $_POST['description'] ?? null;
$quantity = $_POST['quantity'] ?? 0;
$importPrice = $_POST['importPrice'] ?? 0;
$ros = $_POST['ros'] ?? 0;
$supplierID = $_POST['supplier'] ?? null;

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
    $categoryID,
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