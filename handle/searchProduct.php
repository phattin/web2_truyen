<?php
header('Content-Type: application/json');
require_once $_SERVER["DOCUMENT_ROOT"] . "/webbantruyen/model/productDB.php";

if (session_status() === PHP_SESSION_NONE)
    session_start();

$limit = 9;
$page_number = isset($_POST['page_number']) ? max(1, (int)$_POST['page_number']) : 1;
$offset = ($page_number - 1) * $limit;

// Lấy dữ liệu sản phẩm từ session
$allProducts = isset($_SESSION['displayProduct']) ? $_SESSION['displayProduct']['data'] : productDB::getAllProduct();

// Lấy từ khóa tìm kiếm
$keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';

// Lọc sản phẩm theo keyword (nếu có)
$filteredProducts = [];
if ($keyword == '' || $keyword == null) {
    $filteredProducts = $allProducts; // Nếu không có từ khóa, lấy tất cả sản phẩm
} else {
    foreach ($allProducts as $product) {
        $productName = $product['ProductName'];
        if (stripos($productName, $keyword) !== false) {
            $filteredProducts[] = $product; // Thêm vào mảng nếu khớp từ khóa
        }
    }
}

$total_products = count($filteredProducts);
$total_pages = ceil($total_products / $limit);
$current_page_data = array_slice(array_values($filteredProducts), $offset, $limit);

// Trả về kết quả
$response = [
    "status" => "success",
    "current_page" => $page_number,
    "total_pages" => $total_pages,
    "data" => $current_page_data
];

echo json_encode($response);
