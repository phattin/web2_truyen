<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRUYEN</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="view/layout/css/main.css">
    <link rel="stylesheet" href="./view/layout/font/fontawesome-free-6.7.2-web/css/all.min.css">
</head>

<body>
<?php
    $page = isset($_GET['page']) ? $_GET['page'] : "home";
    if ($page == 'admin') {
        include_once("view/admin/admin.php");
    } elseif ($page == 'login' || $page == 'register' || $page == 'profile' || $page == 'cart') {
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
            include_once("view/layout/page/product_detail.php");
        } else {
            include_once("view/midContent.php");
        }

        include_once("view/footer.php");
    }
    ?>
</body>

</html>


<!-- include_once("view/navbar.php");
    include_once("view/midContent.php"); -->