<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";

// Check if user is logged in and has admin privileges
$isLoggedIn = isset($_SESSION['username']) && isset($_SESSION['role']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
$role = $isLoggedIn ? $_SESSION['role'] : '';

$isAdmin = $isLoggedIn && ($role == 'R001'|| $role == 'R002');
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/webbantruyen/view/layout/css/adminHome.css">
    <link rel="stylesheet" href="/webbantruyen/view/layout/css/adminForm.css">
    <link rel="stylesheet" href="/webbantruyen/view/layout/css/login.css">
    <link rel="stylesheet" href="/webbantruyen/view/layout/css/btnLoginAdmin.css">
    <link rel="stylesheet" href="/webbantruyen/view/layout/css/overlay.css">
 
</head>

<body onload='CheckRole("<?= $role ?>")'>
    <div class="container">
        <header>
            <h2>Trang Quản Trị Hệ Thống</h2>
            <div class="login-container">

                <?php if ($isLoggedIn): ?>
                    <div class="user-info-container">
                        <div class="user-info">
                            <i class="fas fa-user-circle"></i>
                            <span><?= htmlspecialchars($username) ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="user-dropdown">
                            <a href="/webbantruyen/view/admin/logout_admin.php" class="logout-button"
                                onclick="return confirm('Bạn có chắc muốn đăng xuất?');">
                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/webbantruyen/view/admin/login_employee.php" class="login-button">
                        <i class="fas fa-sign-in-alt"></i> Đăng nhập
                    </a>
                <?php endif; ?>
            </div>
        </header>
        <nav class="sidebar">
            <h3>Chức năng</h3>
            <ul>
                <li onclick="checkLoginAndSwitch('tc', '<?= $role ?>')" id="TC"><a>Trang chủ</a></li>
                <li onclick="checkLoginAndSwitch('tk', '<?= $role ?>')" id="QLTK"><a>Quản lý tài khoản</a></li>
                <li onclick="checkLoginAndSwitch('nv', '<?= $role ?>')" id="QLVN"><a>Quản lý nhân viên</a></li>
                <li onclick="checkLoginAndSwitch('kh', '<?= $role ?>')" id="QLKH"><a>Quản lý khách hàng</a></li>
                <li onclick="checkLoginAndSwitch('sp', '<?= $role ?>')" id="QLSP"><a>Quản lý sản phẩm</a></li>
                <li onclick="checkLoginAndSwitch('km', '<?= $role ?>')" id="QLKM"><a>Quản lý khuyến mãi</a></li>
                <li onclick="checkLoginAndSwitch('tl', '<?= $role ?>')" id="QLCL"><a>Thể loại truyện</a></li>
                <li onclick="checkLoginAndHienThiHoaDon()" id="QLHD"><a>Hóa đơn bán</a></li>
                <li onclick="checkLoginAndSwitch('hdn', '<?= $role ?>')" id="QLHDN"><a>Hóa đơn nhập</a></li>
                <li onclick="checkLoginAndSwitch('ncc', '<?= $role ?>')" id="QLHDB"><a>Quản lý nhà cung cấp</a></li>
                <li onclick="checkLoginAndSwitch('pq', '<?= $role ?>')" class="QLQ"><a>Phân quyền</a></li>
                <li onclick="checkLoginAndSwitch('role', '<?= $role ?>')" class="QLQ"><a>ROLE</a></li>
                <li onclick="checkLoginAndLoadStatistics()" id="S"><a>Thống kê</a></li>

                <?php if ($isLoggedIn): ?>
                    <li><a href="/webbantruyen/view/layout/page/logout_admin.php"
                            onclick="return confirm('Bạn có chắc muốn đăng xuất?');">Đăng xuất</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <main id="admin-content">
            <div id="login-required-message" class="login-required-message">
                <i class="fas fa-exclamation-circle"></i> Bạn cần đăng nhập để sử dụng chức năng này!
            </div>
            <?php if (!$isLoggedIn): ?>
                <div style="text-align: center; padding: 50px 20px;">
                    <i class="fas fa-lock" style="font-size: 48px; color: #6c757d; margin-bottom: 20px;"></i>
                    <h3>Vui lòng đăng nhập để sử dụng các chức năng quản trị</h3>
                    <p>Bạn cần có quyền truy cập phù hợp để xem và sử dụng các tính năng quản trị.</p>
                    <a href="/webbantruyen/view/admin/login_employee.php" class="login-button"
                        style="display: inline-block; margin-top: 20px;">
                        <i class="fas fa-sign-in-alt"></i> Đăng nhập ngay
                    </a>
                </div>
            <?php elseif ($isAdmin): ?>
                <div style="text-align: center; padding: 50px 20px;">
                    <i class="fas fa-tasks" style="font-size: 48px; color: #28a745; margin-bottom: 20px;"></i>
                    <h3>Chào mừng đến với Trang Quản Trị</h3>
                    <p>Vui lòng chọn chức năng từ thanh bên trái để bắt đầu.</p>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 50px 20px;">
                    <i class="fas fa-exclamation-triangle"
                        style="font-size: 48px; color: #ffc107; margin-bottom: 20px;"></i>
                    <h3>Không đủ quyền truy cập</h3>
                    <p>Bạn không có quyền truy cập vào trang quản trị. Vui lòng liên hệ quản trị viên nếu bạn cần hỗ trợ.
                    </p>
                </div>
            <?php endif; ?>
        </main>

        <div id="overlay-chitiet" onclick="Close_Chitiet()" class="overlay-chitiet">
            <div id="ChiTiet" class="ChiTiet" onclick="event.stopPropagation();"></div>
        </div>
        <div id="overlay-chucnang" onclick="Close_ChucNang()" class="overlay-chucnang">
            <div id="Function" class="ChucNang" class="function-container" onclick="event.stopPropagation();"></div>
        </div>

    </div>
    <script src="/webbantruyen/view/layout/js/Load_content.js"></script>
    <script src="/webbantruyen/view/layout/js/Chitiet.js"></script>
    <script src="/webbantruyen/view/layout/js/permissions.js"></script>
    <script src="/webbantruyen/view/layout/js/jquery-3.7.1.min.js"></script>
    <script src="/webbantruyen/view/layout/js/them_ajax.js"></script>
    <script src="/webbantruyen/view/layout/js/Them.js"></script>
    <script src="/webbantruyen/view/layout/js/Sua.js"></script>
    <script src="/webbantruyen/view/layout/js/Xoa.js"></script>
    <script src="/webbantruyen/view/layout/js/CheckRole.js"></script>
    <script src="/webbantruyen/view/layout/js/HoaDon.js"></script>
    <script src="/webbantruyen/view/layout/js/statistics.js"></script>
    <script>
        // Kiểm tra đăng nhập trước khi thực hiện chức năng
        const isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;

        // Hàm kiểm tra đăng nhập chung
        function requireLogin() {
            if (!isLoggedIn) {
                const message = document.getElementById('login-required-message');
                message.style.display = 'block';
                setTimeout(() => {
                    message.style.display = 'none';
                }, 3000);
                return false;
            }
            return true;
        }

        // Wrapper functions để kiểm tra đăng nhập trước khi thực hiện chức năng
        function checkLoginAndSwitch(page, role) {
            if (requireLogin()) {
                Switch(page, role);
            }
        }

        function checkLoginAndHienThiHoaDon() {
            if (requireLogin()) {
                HienThiHoaDon();
            }
        }

        function checkLoginAndLoadStatistics() {
            if (requireLogin()) {
                LoadStatistics();
            }
        }

        // Hàm hiển thị hóa đơn bán
        function HienThiHoaDon() {
            $("#admin-content").load("/webbantruyen/view/admin/sales_invoice.php", function (response, status, xhr) {
                if (status === "error") {
                    console.error("Lỗi khi tải hóa đơn bán:", xhr.status, xhr.statusText);
                    $("#admin-content").html("<p>Không thể tải hóa đơn bán.</p>");
                } else {
                    console.log("Đã tải trang hóa đơn bán thành công");
                }
            });
        }

        // Đóng overlay chi tiết
        function Close_Chitiet() {
            document.getElementById("overlay-chitiet").style.display = "none";
        }

        // Đóng overlay chức năng
        function Close_ChucNang() {
            document.getElementById("overlay-chucnang").style.display = "none";
        }

        // Hàm đóng overlay (sử dụng trong HoaDon.js)
        function closeOverlay() {
            document.getElementById("overlay-chucnang").style.display = "none";
        }
    </script>
</body>

</html>