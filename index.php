<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRUYENQQ</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="view/layout/css/main.css">
    <link rel="stylesheet" href="./view/layout/font/fontawesome-free-6.7.2-web/css/all.min.css">

</head>

<body>
<?php
$page = isset($_GET['page']) ? $_GET['page'] : "home";

if ($page == 'login' || $page == 'register') {
    include("view/layout/page/$page.php");
} else {
    include_once("view/header.php");
    include_once("view/banner.php");
    include_once("view/navbar.php");
    include_once("view/midContent.php");
    include_once("view/footer.php");
}
?>  
</body>

</html>