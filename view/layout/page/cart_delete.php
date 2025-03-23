<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;

if ($id && isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $id) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reset lại chỉ số mảng
            echo json_encode(["success" => true]);
            exit();
        }
    }
}

echo json_encode(["success" => false, "message" => "Sản phẩm không tồn tại."]);