<?php
// Tắt hiển thị lỗi trên trình duyệt nhưng vẫn ghi nhật ký
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Đảm bảo không có đầu ra trước header
ob_start();

// Đặt header JSON
header('Content-Type: application/json');

// Include file kết nối database
include($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php");

$conn = connectDB::getConnection();
$response = ["success" => false, "message" => ""];

// Hàm tạo mã CustomerID mới
function generateCustomerID($conn) {
    $prefix = 'C';
    
    // Lấy CustomerID cao nhất hiện có
    $sql = "SELECT CustomerID FROM customer ORDER BY CustomerID DESC LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $number = (int) substr($row['CustomerID'], 1);
    } else {
        $number = 0;
    }

    // Lặp cho đến khi tìm được ID chưa tồn tại
    do {
        $number++;
        $newID = $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);

        $check = $conn->prepare("SELECT CustomerID FROM customer WHERE CustomerID = ?");
        $check->bind_param("s", $newID);
        $check->execute();
        $checkResult = $check->get_result();
    } while ($checkResult->num_rows > 0);

    return $newID;
}


// Xử lý đăng ký người dùng
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm-password'] ?? '';
    $roleID = 'R3';
    $status = 'Hiện';

    // Kiểm tra dữ liệu đầu vào
    if (empty($username)) {
        $response["message"] = "Tên đăng nhập không được để trống!";
        echo json_encode($response);
        exit;
    }

    if (empty($fullname)) {
        $response["message"] = "Họ và tên không được để trống!";
        echo json_encode($response);
        exit;
    }

    if (empty($email)) {
        $response["message"] = "Email không được để trống!";
        echo json_encode($response);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["message"] = "Email không hợp lệ!";
        echo json_encode($response);
        exit;
    }

    if (!preg_match('/^0\d{9}$/', $phone)) {
        $response["message"] = "Số điện thoại phải có đúng 10 số và bắt đầu bằng số 0!";
        echo json_encode($response);
        exit;
    }

    if (empty($address)) {
        $response["message"] = "Địa chỉ không được để trống!";
        echo json_encode($response);
        exit;
    }

    if (empty($password)) {
        $response["message"] = "Mật khẩu không được để trống!";
        echo json_encode($response);
        exit;
    }

    if ($password !== $confirmPassword) {
        $response["message"] = "Mật khẩu và xác nhận mật khẩu không khớp!";
        echo json_encode($response);
        exit;
    }

    try {
        // Kiểm tra tên đăng nhập đã tồn tại chưa
        $stmt = $conn->prepare("SELECT * FROM account WHERE Username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $usernameResult = $stmt->get_result();

        if ($usernameResult->num_rows > 0) {
            $response["message"] = "Tên đăng nhập đã tồn tại!";
            echo json_encode($response);
            exit;
        }

        // Kiểm tra email đã tồn tại chưa
        $stmt = $conn->prepare("SELECT * FROM customer WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $emailResult = $stmt->get_result();

        if ($emailResult->num_rows > 0) {
            $response["message"] = "Email đã được sử dụng!";
            echo json_encode($response);
            exit;
        }

        // Bắt đầu transaction để đảm bảo tính nhất quán của dữ liệu
        $conn->begin_transaction();

        // Mã hóa mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Thêm tài khoản vào bảng account
        $stmt = $conn->prepare("INSERT INTO account (Username, Password, RoleID, Status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hashedPassword, $roleID, $status);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Tạo CustomerID và thêm vào bảng customer
            $customerID = generateCustomerID($conn);
            $stmt = $conn->prepare("INSERT INTO customer (CustomerID, Username, Fullname, Email, Phone, Address) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $customerID, $username, $fullname, $email, $phone, $address);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Hoàn tất transaction
                $conn->commit();
                $response["success"] = true;
                $response["message"] = "Đăng ký thành công!";
            } else {
                // Rollback nếu thêm vào bảng customer thất bại
                $conn->rollback();
                $response["message"] = "Lỗi khi thêm thông tin khách hàng: " . $stmt->error;
            }
        } else {
            // Rollback nếu thêm vào bảng account thất bại
            $conn->rollback();
            $response["message"] = "Lỗi khi tạo tài khoản: " . $stmt->error;
        }
    } catch (Exception $e) {
            @$conn->rollback();
        $response["message"] = "Lỗi hệ thống: " . $e->getMessage();
    }
}

// Đảm bảo đầu ra là JSON hợp lệ
echo json_encode($response);
// Làm sạch buffer đầu ra và kết thúc script
ob_end_flush();
exit;
?>