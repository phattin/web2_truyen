<?php
session_start();/*
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";

$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

if (!$username) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header("Location: /webbantruyen/index.php?page=login");
    exit;
}

$conn = connectDB::getConnection();

// Kiểm tra RoleID của người dùng
$stmt = $conn->prepare("SELECT RoleID FROM account WHERE Username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$IDrole = "";
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['RoleID'] === 'R003') {
        // Nếu RoleID là 'R003', hiển thị thông báo và dừng chương trình
        echo "<script>alert('Bạn không có quyền truy cập vào trang này!'); window.location.href = '/webbantruyen/index.php';</script>";
        exit;
    }
    else
        $IDrole = $row['RoleID'];
} else {
    // Nếu không tìm thấy tài khoản, chuyển hướng đến trang đăng nhập
    header("Location: /webbantruyen/index.php?page=login");
    exit;
}

$stmt->close();
$conn->close();
*/
$IDrole="R001";
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

</head>

<body onload='CheckRole("<?= $GLOBALS["IDrole"] ?>")'>
    <div class="container">
        <header style="display:none;">
            <h2>Xin chào <?php echo htmlspecialchars($username); ?>!</h2>
        </header>
        <nav class="sidebar">
            <h3>Chức năng</h3>
            <ul>
                <li onclick="Switch('tc','<?= $GLOBALS['IDrole'] ?>')" id="TC"><a>Trang chủ</a></li>
                <li onclick="Switch('tk','<?= $GLOBALS['IDrole'] ?>')" id="QLTK"><a>Quản lý tài khoản</a></li>
                <li onclick="Switch('nv','<?= $GLOBALS['IDrole'] ?>')" id="QLVN"><a>Quản lý nhân viên</a></li>
                <li onclick="Switch('kh','<?= $GLOBALS['IDrole'] ?>')" id="QLKH"><a>Quản lý khách hàng</a></li>
                <li onclick="Switch('sp','<?= $GLOBALS['IDrole'] ?>')" id="QLSP"><a>Quản lý sản phẩm</a></li>
                <li onclick="Switch('km','<?= $GLOBALS['IDrole'] ?>')" id="QLKM"><a>Quản lý khuyến mãi</a></li>
                <li onclick="Switch('tl','<?= $GLOBALS['IDrole'] ?>')" id="QLCL"><a>Thể loại truyện</a></li>
                <li onclick="HienThiHoaDon()" id="QLHD"><a>Hóa đơn bán</a></li>
                <li onclick="Switch('hdn','<?= $GLOBALS['IDrole'] ?>')" id="QLHDN"><a>Hóa đơn nhập</a></li>
                <li onclick="Switch('ncc','<?= $GLOBALS['IDrole'] ?>')" id="QLHDB"><a>Quản lý nhà cung cấp</a></li>
                <li onclick="Switch('pq','<?= $GLOBALS['IDrole'] ?>')" class="QLQ"><a>Phân quyền</a></li>
                <li onclick="Switch('role','<?= $GLOBALS['IDrole'] ?>')" class="QLQ"><a>ROLE</a></li>
                <li onclick="LoadStatistics()" id="S"><a>Thống kê</a></li>


                <li><a href="/webbantruyen/view/layout/page/logout.php"
                        onclick="return confirm('Bạn có chắc muốn đăng xuất?');">Đăng xuất</a></li>
            </ul>
        </nav>

        <main id="admin-content"></main>
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