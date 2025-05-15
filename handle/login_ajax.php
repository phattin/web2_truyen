<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php");

$conn = connectDB::getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = trim($_POST['identifier'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Tìm kiếm trong cả hai bảng employee và customer bằng UNION
    $sql = "SELECT a.Username, a.Password, a.RoleID, 'employee' as UserType 
            FROM account a 
            JOIN employee e ON a.Username = e.Username 
            WHERE e.Email = ? OR a.Username = ?
            UNION
            SELECT a.Username, a.Password, a.RoleID, 'customer' as UserType 
            FROM account a 
            JOIN customer c ON a.Username = c.Username 
            WHERE c.Email = ? OR a.Username = ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $identifier, $identifier, $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['Password'])) {
            $_SESSION['username'] = $user['Username'];
            $_SESSION['role'] = $user['RoleID'];
            $_SESSION['userType'] = $user['UserType'];

            // Xác định URL chuyển hướng dựa vào role
            if ($user['RoleID'] == 'R001') {
                $redirectURL = "/webbantruyen/index.php?page=admin";
            } else if ($user['RoleID'] == 'R003') {
                $redirectURL = "/webbantruyen/index.php";
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
                "message" => "Sai mật khẩu!"
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Email hoặc tên đăng nhập không tồn tại!"
        ]);
    }
    exit;
}
?>