<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php");

header('Content-Type: application/json');

$conn = connectDB::getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT a.Username, a.Password, a.RoleID, c.Email 
            FROM account a 
            JOIN customer c ON a.Username = c.Username 
            WHERE c.Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['Password'])) {
            $_SESSION['username'] = $user['Username'];
            $_SESSION['email'] = $user['Email'];
            $_SESSION['role'] = $user['RoleID'];

            $redirectURL = ($user['RoleID'] === 'R1') ? "/webbantruyen/index.php?page=admin" : "/webbantruyen/index.php?trangChu";

            echo json_encode([
                'status' => 'success',
                'redirect' => $redirectURL
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Sai mật khẩu!']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email không tồn tại!']);
    }
}
