<?php
session_start();
header('Content-Type: application/json');

include($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/productDB.php");
$conn = connectDB::getConnection();

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;
$newQuantity = $data['quantity'] ?? 0;

if ($id && isset($_SESSION['cart'])) {
    // Lấy sản phẩm từ cơ sở dữ liệu
    $product = productDB::getProductByID($id);

    if ($product) {
        $maxQuantity = $product['Quantity']; // Số lượng tối đa trong kho
        $price = round($product['ImportPrice'] * $product['ROS'] / 1000) * 1000;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                // Kiểm tra nếu số lượng vượt quá số lượng trong kho
                if ($newQuantity > $maxQuantity) {
                    echo json_encode([
                        "success" => false,
                        "message" => "Chỉ còn $maxQuantity cuốn truyện! Bạn hãy mua thêm sản phẩm khác"
                    ]);
                    exit();
                }

                // Cập nhật số lượng trong giỏ hàng
                $item['quantity'] = $newQuantity > 0 ? $newQuantity : 1; // Không cho nhỏ hơn 1
                $newPrice = $price * $newQuantity;
                echo json_encode([
                    "success" => true,
                    "newQuantity" => $newQuantity,
                    "productPrice" => $newPrice
                ]);
                exit();
            }
        }
    } else {
        echo json_encode(["success" => false, "message" => "Sản phẩm không tồn tại."]);
        exit();
    }
}

echo json_encode(["success" => false, "message" => "Sản phẩm không tồn tại."]);