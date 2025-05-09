<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRUYEN</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="view/layout/css/main.css">
    <link rel="stylesheet" href="./view/layout/css/checkout.css">
    <link rel="stylesheet" href="./view/layout/font/fontawesome-free-6.7.2-web/css/all.min.css">
</head>
<script src="/webbantruyen/view/layout/js/jquery-3.7.1.min.js"></script>
<script src="/webbantruyen/view/layout/js/product_ajax.js"></script>
<body>
    <?php
    $page = isset($_GET['page']) ? $_GET['page'] : "home";
    if($page =='cart_view'){
        include_once("view/layout/page/cart_view.php");
    } elseif ($page == 'admin' || isset($_GET['admin'])) {
        header("Location: /webbantruyen/view/admin/index.php");
        exit(); // Đảm bảo không chạy tiếp phần còn lại của mã
    } elseif ($page == 'login' || $page == 'register' || $page == 'profile' || $page == 'cart'|| $page == 'order_history') {
        include("view/layout/page/$page.php");
    } else {
        include_once("view/header.php");
        include_once("view/banner.php");
        include_once("view/navbar.php");
        
        if ($page == 'trangChu') {
            include_once("home.php");
        }
        
        // Chi tiết sản phẩm
        elseif ($page == 'product_detail') {
            echo '<main class="container">';
            include_once("view/layout/page/product_detail.php");
            echo '</main>';
        } else {
            echo '<main class="container">';
            include_once("view/midContent.php");
            echo '</main>';
        }
        
        include_once("view/footer.php");
    }
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    ?>

    
</body>
<script src="view/layout/js/main.js"></script>

</html>


<!-- include_once("view/navbar.php");
    include_once("view/midContent.php"); -->