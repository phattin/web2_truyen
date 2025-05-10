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
<style>
</style>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/webbantruyen/view/layout/css/adminHome.css">
    <link rel="stylesheet" href="/webbantruyen/view/layout/css/adminForm.css">
    
</head>

<body>
    <div class="container">
        <header>
            <h2>Xin chào <?php echo htmlspecialchars($username); ?>!</h2>
        </header>
        <nav class="sidebar">
            <h3>Chức năng</h3>
            <ul>
                <li onclick="Switch('tc')"><a>Trang chủ</a></li>
                <li onclick="Switch('nv')"><a>Quản lý nhân viên</a></li>
                <li onclick="Switch('kh')"><a>Quản lý khách hàng</a></li>
                <li onclick="Switch('sp')"><a>Quản lý sản phẩm</a></li>
                <li onclick="Switch('km')"><a>Quản lý khuyến mãi</a></li>
                <li onclick="Switch('tl')"><a>Thể loại truyện</a></li>
                <li onclick="Switch('hdb')"><a>Hóa đơn bán</a></li>
                <li onclick="Switch('hdn')"><a>Hóa đơn nhập</a></li>
                <li onclick="Switch('ncc')"><a>Quản lý nhà cung cấp</a></li>
                <li onclick="Switch('pq')"><a>Phân quyền</a></li>
                <li onclick="Switch('role')"><a>ROLE</a></li>
                <li onclick="Switch('tk')"><a>Thống kê</a></li>
                <li><a href="/webbantruyen/view/layout/page/logout.php" onclick="return confirm('Bạn có chắc muốn đăng xuất?');" >Đăng xuất</a></li>
            </ul>
        </nav>

        <main id="admin-content"></main>
        <div id="overlay-chitiet" onclick="Close_Chitiet()" class="overlay-chitiet"><div id="ChiTiet" class="ChiTiet" onclick="event.stopPropagation();">></div></div>
        <div id="overlay-chucnang" onclick="Close_ChucNang()" class="overlay-chucnang"><div id="Function" class="ChucNang" onclick="event.stopPropagation();"></div></div>
        
    </div>
    <script src="/webbantruyen/view/layout/js/Load_content.js"></script>
    <script src="/webbantruyen/view/layout/js/Chitiet.js"></script>
    <script src="/webbantruyen/view/layout/js/permissions.js"></script>
    <script src="/webbantruyen/view/layout/js/jquery-3.7.1.min.js"></script>
    <script src="/webbantruyen/view/layout/js/them_ajax.js"></script>
    <script src="/webbantruyen/view/layout/js/admin_function.js"></script>
    <script src="/webbantruyen/view/layout/js/Xoa.js"></script>
</body>
</html>
