<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="view/layout/css/right_header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="view/layout/css/headerResponsive.css">
</head>

<body>
    <link rel="stylesheet" href="view/layout/css/cart.css">
    <script src="view/layout/js/cart.js"></script>

    <header>
        <div class="container">
            <div class="logo">
                <img src="view/layout/font_logo/logo2.jpg" alt="">
            </div>
            <div class="search-bar">
                <input type="text" id="find-product" placeholder="Tìm truyện...">
                <i class="fa-solid fa-magnifying-glass"
                    onclick="if(document.querySelector('main.container') != null) document.querySelector('main.container').scrollIntoView({ behavior: 'smooth' })"></i>
            </div>

            <div class="auth-container">
                <?php if (isset($_SESSION['username'])): ?>
                    <!-- Nếu đã đăng nhập -->
                    <a href="index.php?page=cart_view" class="btn-cart" id="cart-icon">
                        <i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i>
                    </a>
                    <div class="user-menu">
                        <!-- Đặt icon giỏ hàng trước -->
                        <div class="user-info">
                            <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="dropdown-menu">
                            <a href="index.php?page=profile">Thông tin cá nhân</a>
                            <a href="index.php?page=order_history">Lịch sử mua hàng</a>
                            <a href="view/layout/page/logout.php" class="btn-logout"
                                onclick="return confirm('Bạn có chắc muốn đăng xuất?');">Đăng xuất</a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Nếu chưa đăng nhập -->
                    <div class="auth-buttons">

                        <a href="index.php?page=register" class="btn-register"
                            style="color:#ff4b2b;text-decoration: none;">Đăng ký</a>
                        <a href="index.php?page=login" class="btn-login">Đăng nhập</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <script>
        // document.getElementById("find-product").addEventListener("keydown", function (event) {
        //     if (document.querySelector('main.container')) {
        //         //Ấn Enter thì cuộn xuống sản phẩm
        //         if (event.key == 'Enter')
        //             document.querySelector('main.container').scrollIntoView({ behavior: 'smooth' })
        //         const sanPham = document.getElementById("find-product").value.trim().toLowerCase();
        //         if (products != null) {
        //             // Lọc sản phẩm từ mảng products có sẵn từ PHP
        //             const productsFound = products.filter(product => product['ProductName'].toLowerCase().includes(sanPham));

        //             // Gửi kết quả qua PHP bằng AJAX
        //             const xhr = new XMLHttpRequest();
        //             xhr.open("POST", "/webbantruyen/view/midContent.php", true);
        //             xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //             xhr.send("productsFound=" + encodeURIComponent(JSON.stringify(productsFound)));

        //             // Xử lý phản hồi từ PHP
        //             xhr.onload = function () {
        //                 if (xhr.status === 200) {
        //                     document.querySelector("main.container").innerHTML = xhr.responseText;
        //                 } else {
        //                     console.error("Lỗi AJAX:", xhr.statusText);
        //                 }
        //             };
        //         }
        //     }
        // });
    </script>
</body>

</html>