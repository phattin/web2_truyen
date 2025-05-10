<?php
    header('Content-Type: application/json'); // Đặt header JSON

    if (isset($_GET['act'])) {
        $act = $_GET['act'];
    } else {
        $act = "home";
    }

    // Kiểm tra session
    if (session_status() === PHP_SESSION_NONE)
    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'] . '/webbantruyen/model/productDB.php';
    $conn = connectDB::getConnection();

    $limit = 9;
    $page_number = isset($_GET['page_number']) ? max(1, (int)$_GET['page_number']) : 1;
    $offset = ($page_number - 1) * $limit;

    // Lấy thể loại từ URL nếu có
    $genre = isset($_GET['genre']) ? $_GET['genre'] : '';

    // Lấy toàn bộ sản phẩm
    $products = productDB::getAllProduct();

    // Lọc sản phẩm theo thể loại
    if ($genre != '')
        $products = productDB::getProductHasGenre($genre);

    $productsFound = $products; // Khởi tạo mảng sản phẩm đã tìm kiếm
    // // Gửi mảng vào để tìm kiếm
    // echo "<script>const products = " . json_encode($products) . ";</script>";

    // // Lấy sản phẩm đã tìm kiếm
    // // Kiểm tra nếu có dữ liệu gửi đến
    // if (isset($_POST["productsFound"]))
    //     $productsFound = json_decode($_POST["productsFound"], true);
    // else 
    //     $productsFound = $products;

    // Lấy sản phẩm cho trang hiện tại
    $result = array_slice($productsFound, $offset, $limit);

    // Tổng số trang
    $total_products = count($productsFound);
    $total_pages = ceil($total_products / $limit);

    connectDB::closeConnection($conn);

    // Nội dung HTML thay đổi theo chế độ
    ob_start();
    $response = [
        "status" => "success",
        "current_page" => $page_number,
        "total_pages" => $total_pages,
        "data" => $result
    ];  
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['displayProduct'] = $response;
    // Trả về JSON hợp lệ
    echo json_encode($response);
?>
