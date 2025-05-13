<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php");

$conn = connectDB::getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = trim($_POST['identifier'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $sql = "SELECT a.Username, a.Password, a.RoleID 
            FROM account a 
            JOIN customer c ON a.Username = c.Username 
            WHERE c.Email = ? OR a.Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['Password'])) {
            $_SESSION['username'] = $user['Username'];
            $_SESSION['role'] = $user['RoleID'];

            $redirectURL = ($user['RoleID'] === 'R1') ? "/webbantruyen/index.php?page=admin" : "/webbantruyen/index.php";

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