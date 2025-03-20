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
    <link rel="stylesheet" href="view/layout/css/adminHome.css">

</head>

<body>
    <header>
        <h2>Xin chào <?php echo htmlspecialchars($username); ?>!</h2>
    </header>
    <div class="container">
        <nav class="sidebar">
            <h3>Chức năng</h3>
            <ul>
                <li><a href="admin_home.php">Trang chủ</a></li>
                <li><a href="add_employee.php">Thêm nhân viên</a></li>
                <li><a href="permissions.php">Quyền</a></li>
                <li><a href="view/layout/page/logout.php" onclick="return confirm('Bạn có chắc muốn đăng xuất?');" >Đăng xuất</a></li>
            </ul>
        </nav>
        
    </div>
</body>
</html>
