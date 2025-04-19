<?php
session_start(); 
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "Khách";
$conn = connectDB::getConnection();
$sql = "SELECT Username FROM account";
$result = $conn->query($sql);
$conn->close();

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ Admin</title>
    <link rel="stylesheet" href="/webbantruyen/view/layout/css/adminHome.css">

 
</head>

<body>
    <div class="container">
        <header>
            <h2>Xin chào <?php echo htmlspecialchars($username); ?>!</h2>
        </header>
        <nav class="sidebar">
            <h3>Chức năng</h3>
            <ul>
                <li onclick="Switch(1)"><a>Trang chủ</a></li>
                <li onclick="Switch(2)"><a>Quản lý nhân viên</a></li>
                <li onclick="Switch(3)"><a>Quản lý khách hàng</a></li>
                <li onclick="Switch(4)"><a>Quản lý sản phẩm</a></li>
                <li onclick="Switch(5)"><a>Phân quyền</a></li>
                <li onclick="Switch(6)"><a>ROLE</a></li>
                <li><a href="/webbantruyen/view/layout/page/logout.php" onclick="return confirm('Bạn có chắc muốn đăng xuất?');" >Đăng xuất</a></li>
            </ul>
        </nav>

        <main id="content"></main>
        <div id="ChiTiet" class="ChiTiet"></div>
        <div id="Function" class="Function"></div>
        
    </div>
    <script src="../layout/js/Load_content.js"></script>
    <script src="../layout/js/Chitiet.js"></script>
    <script src="../layout/js/permissions.js"></script>
    <script src="../layout/js/jquery-3.7.1.min.js"></script>
</body>
</html>
