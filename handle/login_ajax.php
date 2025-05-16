<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php");

$conn = connectDB::getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = trim($_POST['identifier'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $userType = trim($_POST['userType'] ?? ''); // Thêm tham số userType để xác định loại người dùng đăng nhập
    
    // Nếu đăng nhập với tư cách khách hàng (customer)
    if ($userType === 'customer') {
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
    } 
    // Nếu đăng nhập với tư cách nhân viên (employee)
    else if ($userType === 'employee') {
        // Tìm kiếm trong bảng employee và account
        $sql_employee = "SELECT a.Username, a.Password, a.RoleID, 'employee' as UserType, a.IsDeleted 
                         FROM employee e 
                         JOIN account a ON e.EmployeeID = a.EmployeeID 
                         WHERE e.Email = ? OR a.Username = ?";
                         
        $stmt_employee = $conn->prepare($sql_employee);
        $stmt_employee->bind_param("ss", $identifier, $identifier);
        $stmt_employee->execute();
        $result_employee = $stmt_employee->get_result();
        
        // Kiểm tra xem nhân viên có tồn tại không
        if ($result_employee->num_rows == 0) {
            echo json_encode([
                "success" => false,
                "message" => "Tài khoản nhân viên không tồn tại! Vui lòng kiểm tra lại thông tin đăng nhập."
            ]);
            exit;
        }
        
        $user = $result_employee->fetch_assoc();
        
        // Kiểm tra xem tài khoản có bị xóa không
        if ($user['IsDeleted'] == 1) {
            echo json_encode([
                "success" => false,
                "message" => "Tài khoản này đã bị vô hiệu hóa! Vui lòng liên hệ quản trị viên để được hỗ trợ."
            ]);
            exit;
        }
        
        // Kiểm tra mật khẩu
        if (password_verify($password, $user['Password'])) {
            $_SESSION['username'] = $user['Username'];
            $_SESSION['role'] = $user['RoleID'];
            $_SESSION['userType'] = $user['UserType'];

            // Xác định URL chuyển hướng dựa vào role
            if ($user['RoleID'] == 'R001' || $user['RoleID'] == 'R002') {
                $redirectURL = "/webbantruyen/index.php?page=admin";
            } else {
                $redirectURL = "/webbantruyen/index.php";
            }

            echo json_encode([
                "success" => true,
                "message" => "Đăng nhập thành công!",
                "redirectURL" => $redirectURL
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Sai mật khẩu! Vui lòng kiểm tra lại."
            ]);
        }
    } 
    // Nếu không xác định được loại người dùng
    else {
        echo json_encode([
            "success" => false,
            "message" => "Vui lòng chọn loại tài khoản để đăng nhập!"
        ]);
    }
    exit;
}
?>