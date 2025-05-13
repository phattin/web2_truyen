<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/productDB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/promotionDB.php";

header('Content-Type: application/json');

// Kiểm tra loại dữ liệu cần xóa
$productID = $_POST['productID'] ?? null;
$promotionID = $_POST['promotionID'] ?? null;

if ($productID) {
    // Xóa sản phẩm
    $productDB = new productDB();
    $result = $productDB->removeProduct($productID);

    if ($result) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Lỗi khi xóa sản phẩm trong database"
        ]);
    }

} else if ($promotionID) {
    // Xóa khuyến mãi
    $promotionDB = new promotionDB();
    $result = $promotionDB->removePromotion($promotionID);

    if ($result) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Lỗi khi xóa khuyến mãi trong database"
        ]);
    }

} else {
    echo json_encode([
        "success" => false,
        "message" => "Thiếu dữ liệu đầu vào"
    ]);
}
?>
