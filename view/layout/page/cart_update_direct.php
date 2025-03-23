<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;
$newQuantity = $data['quantity'] ?? 0;

if ($id && isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $id) {
            if ($newQuantity < 1) {
                $newQuantity = 1; // Không cho số lượng nhỏ hơn 1
            }
            $item['quantity'] = $newQuantity;
            echo json_encode(["success" => true]);
            exit();
        }
    }
}

echo json_encode(["success" => false, "message" => "Sản phẩm không tồn tại."]);