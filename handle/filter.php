<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/webbantruyen/model/productDB.php";

// Kiểm tra xem có phải là yêu cầu AJAX và có action là 'filter' hay không
if (isset($_POST['act']) && $_POST['act'] === 'filter') {
    // Lấy dữ liệu lọc từ POST request
    $minPrice = isset($_POST['min_price']) && $_POST['min_price'] !== '' ? floatval($_POST['min_price']) : null;
    $maxPrice = isset($_POST['max_price']) && $_POST['max_price'] !== '' ? floatval($_POST['max_price']) : null;
    $categories = isset($_POST['categories']) ? $_POST['categories'] : [];
    $search = isset($_POST['search']) ? trim($_POST['search']) : '';
    $pageNumber = isset($_POST['page_number']) ? intval($_POST['page_number']) : 1;

    // Số sản phẩm trên mỗi trang
    $limit = 9;
    $offset = ($pageNumber - 1) * $limit;

    // Khởi tạo đối tượng productDB
    $productDB = new productDB();

    // Lấy tổng số sản phẩm sau khi lọc
    $totalProducts = $productDB->getTotalFilteredProducts($minPrice, $maxPrice,  $categories, $search);
    $totalPages = ceil($totalProducts / $limit);

    // Lấy danh sách sản phẩm đã lọc và phân trang
    $products = $productDB->getFilteredProducts($limit, $offset, $minPrice, $maxPrice, $categories, $search);
    // Trả về dữ liệu JSON
    $response = [
        'data' => $products,
        'total_pages' => $totalPages,
        'current_page' => $pageNumber
    ];

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['displayProduct'] = $response;

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Xử lý trường hợp truy cập trực tiếp hoặc không đúng action
    http_response_code(400);
    echo json_encode(['error' => 'Yêu cầu không hợp lệ']);
}