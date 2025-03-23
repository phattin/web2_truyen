<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? null;
    $price = $_POST['price'] ?? null;
    $quantity = $_POST['quantity'] ?? 1;

    if ($id && $name && $price) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity
            ];
        }

        file_put_contents('debug_cart.log', print_r($_SESSION['cart'], true)); // Debug session
        echo json_encode(["success" => true, "cart_count" => count($_SESSION['cart'])]);
        exit();
    } else {
        echo json_encode(["success" => false, "message" => "Dữ liệu không hợp lệ."]);
        exit();
    }
}