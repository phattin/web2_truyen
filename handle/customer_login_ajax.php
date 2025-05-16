<?php
//customer_login_ajax.php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php");

$conn = connectDB::getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = trim($_POST['identifier'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    // Tìm kiếm trong bảng customer
    $sql_customer = "SELECT Username, Password, 'customer' as UserType, IsBlocked 
                     FROM customer 
                     WHERE Email = ? OR Username = ?";
                     
    $stmt_customer = $conn->prepare($sql_customer);
    $stmt_customer->bind_param("ss", $identifier, $identifier);
    $stmt_customer->execute();
    $result_customer = $stmt_customer->get_result();
    
    // Kiểm tra xem khách hàng có tồn tại không
    if ($result_customer->num_rows == 0) {
        echo json_encode([
            "success" => false,
            "message" => "Tài khoản khách hàng không tồn tại! Vui lòng kiểm tra lại thông tin đăng nhập."
        ]);
        exit;
    }
    
    $user = $result_customer->fetch_assoc();
    
    // Kiểm tra xem tài khoản có bị chặn không
    if ($user['IsBlocked'] == 1) {
        echo json_encode([
            "success" => false,
            "message" => "Tài khoản này đã bị vô hiệu hóa! Vui lòng liên hệ quản trị viên để được hỗ trợ."
        ]);
        exit;
    }
    
    // Kiểm tra mật khẩu
    if (password_verify($password, $user['Password'])) {
        $_SESSION['username'] = $user['Username'];
        $_SESSION['userType'] = $user['UserType'];

        echo json_encode([
            "success" => true,
            "message" => "Đăng nhập thành công!",
            "redirectURL" => "/webbantruyen/index.php"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Sai mật khẩu! Vui lòng kiểm tra lại."
        ]);
    }
    exit;
}
?>