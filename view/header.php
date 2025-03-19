<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="view/layout/css/right_header.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"> <!-- FontAwesome -->
</head>
<body>
<header>
    <div class="container">
        <div class="logo">
            <img src="view/layout/font_logo/logo2.jpg" alt="">
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Tìm truyện...">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>

        <?php if (isset($_SESSION['username'])): ?>
            <!-- Nếu đã đăng nhập, hiển thị avatar + username + dropdown menu -->
            <div class="user-menu">
                <div class="user-info">
                    
                    <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <i class="fa-solid fa-user"></i> 
                </div>
                <div class="dropdown-menu">
                    <a href="index.php?page=profile">Thông tin cá nhân</a>
                    <a href="view/layout/page/logout.php" class="btn-logout" onclick="return confirm('Bạn có chắc muốn đăng xuất?');">Đăng xuất</a>
                </div>
            </div>
        <?php else: ?>
            <!-- Nếu chưa đăng nhập, hiển thị nút đăng nhập và đăng ký -->
            <div class="auth-buttons">
                <a href="index.php?page=register" class="btn-register" style="color:#ff4b2b;text-decoration: none;">Đăng ký</a>
                <a href="index.php?page=login" class="btn-login">Đăng nhập</a>
            </div>
        <?php endif; ?>
    </div>
</header>
</body>
</html>
