<?php
header('Content-Type: application/json');
include($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php");

$conn = connectDB::getConnection();
$response = ["success" => false, "message" => ""];

function generateCustomerID($conn) {
    $sql = "SELECT CustomerID FROM customer ORDER BY CustomerID DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $number = (int) substr($row['CustomerID'], 1);
        $newID = 'C' . str_pad($number + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $newID = "C001";
    }
    return $newID;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
    $roleID = 'R3';
    $status = 'Hiện';

    // Check username
    $stmt = $conn->prepare("SELECT * FROM account WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $usernameResult = $stmt->get_result();

    if ($usernameResult->num_rows > 0) {
        $response["message"] = "Tên đăng nhập đã tồn tại!";
        echo json_encode($response);
        exit;
    }

    // Check email
    $stmt = $conn->prepare("SELECT * FROM customer WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $emailResult = $stmt->get_result();

    if ($emailResult->num_rows > 0) {
        $response["message"] = "Email đã được sử dụng!";
        echo json_encode($response);
        exit;
    }

    // Thêm tài khoản
    $stmt = $conn->prepare("INSERT INTO account (Username, Password, RoleID, Status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $roleID, $status);

    if ($stmt->execute()) {
        $customerID = generateCustomerID($conn);
        $stmt = $conn->prepare("INSERT INTO customer (CustomerID, Username, Fullname, Email, Phone, Address) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $customerID, $username, $fullname, $email, $phone, $address);
        if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = "Đăng ký thành công!";
        } else {
            $response["message"] = "Lỗi khi thêm vào bảng customer!";
        }
    } else {
        $response["message"] = "Lỗi khi thêm tài khoản!";
    }

    echo json_encode($response);
}
?>
