<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;
$change = $data['change'] ?? 0;

if ($id && isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $id) {
            $item['quantity'] += $change;
            if ($item['quantity'] <= 0) {
                $item['quantity'] = 1; // Không cho số lượng nhỏ hơn 1
            }
            echo json_encode(["success" => true]);
            exit();
        }
    }
}

echo json_encode(["success" => false, "message" => "Sản phẩm không tồn tại."]);