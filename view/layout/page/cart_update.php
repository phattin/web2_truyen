<?php
session_start();
file_put_contents('debug_cart.log', print_r($_SESSION, true));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? null;
    $price = $_POST['price'] ?? null;
    $quantity = (int)$_POST['quantity'] ?? 1;

    if ($id && $name && $price) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += $quantity; // Cộng dồn số lượng
        } else {
            $_SESSION['cart'][$id] = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity
            ];
        }
    }

    
    echo json_encode(["success" => true, "cart_count" => count($_SESSION['cart'])]);
    exit();
}
?>
