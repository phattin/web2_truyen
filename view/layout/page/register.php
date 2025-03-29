<?php
include($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php");

$conn = connectDB::getConnection(); // Lấy kết nối CSDL
$error = "";   // Khởi tạo biến lỗi
$success = ""; // Khởi tạo biến thành công

// Hàm tạo CustomerID mới
function generateCustomerID($conn)
{
    $sql = "SELECT CustomerID FROM customer ORDER BY CustomerID DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastID = $row['CustomerID'];

        // Tách phần số từ ID (VD: "E02" -> 2)
        $number = (int) substr($lastID, 1);

        // Tăng số và format lại thành "E01", "E02", ...
        $newID = 'C' . str_pad($number + 1, 2, '0', STR_PAD_LEFT);
    } else {
        $newID = "C001"; // ID đầu tiên
    }

    return $newID;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Mã hóa mật khẩu
    $roleID = 'R3'; // Người dùng mặc định
    $status = 'Hiện';

    // Kiểm tra username đã tồn tại chưa
    $check_username_sql = "SELECT * FROM account WHERE Username = ?";
    $stmt = $conn->prepare($check_username_sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $check_username_result = $stmt->get_result();

    // Kiểm tra email đã tồn tại chưa
    $check_email_sql = "SELECT * FROM customer WHERE Email = ?";
    $stmt = $conn->prepare($check_email_sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $check_email_result = $stmt->get_result();

    if ($check_username_result->num_rows > 0) {
        $error = "Tên đăng nhập đã tồn tại!";
    } elseif ($check_email_result->num_rows > 0) {
        $error = "Email đã được sử dụng bởi người khác!";
    } else {
        // Thêm tài khoản vào bảng account
        $sql_account = "INSERT INTO account (Username, Password, RoleID, Status) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_account);
        $stmt->bind_param("ssss", $username, $password, $roleID, $status);

        if ($stmt->execute()) {
            // Tạo CustomerID mới
            $customerID = generateCustomerID($conn);

            // Thêm vào bảng customer
            $sql_customer = "INSERT INTO customer (CustomerID, Username, Email) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql_customer);
            $stmt->bind_param("sss", $customerID, $username, $email);

            if ($stmt->execute()) {
                echo "<style>
                            body {
                                margin: 0;
                                padding: 0;
                                overflow: hidden;
                            }
                            #loading-screen {
                                position: fixed;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                background: #074b80;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                flex-direction: column;
                                color: white;
                                font-size: 20px;
                                font-weight: bold;
                                z-index: 9999;
                                opacity: 0;
                                animation: fadeIn 0.5s ease-in forwards;
                            }
                            .text {
                                opacity: 0;
                                animation: fadeInText 1.5s ease-in forwards;
                            }
                            .line {
                                width: 0;
                                height: 4px;
                                background: white;
                                margin-top: 10px;
                                animation: growLine 2s ease-in forwards;
                            }
                            @keyframes fadeIn {
                                from { opacity: 0; }
                                to { opacity: 1; }
                            }
                            @keyframes fadeInText {
                                0% { opacity: 0; transform: translateY(-10px); }
                                100% { opacity: 1; transform: translateY(0); }
                            }
                            @keyframes growLine {
                                0% { width: 0; }
                                100% { width: 150px; }
                            }
                        </style>

                        <div id='loading-screen'>
                            <div class='text'>Đăng ký thành công!</div>
                            <div class='line'></div>
                        </div>

                        <script>
                            setTimeout(function() {
                                window.location.href = 'index.php?page=login';
                            }, 2000);
                        </script>";

            } else {
                $error = "Lỗi khi thêm vào bảng customer: " . $stmt->error;
            }
        } else {
            $error = "Lỗi khi thêm tài khoản: " . $stmt->error;
        }
    }
}
?>



<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="view/layout/css/sign_in.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .close-btn {
            position: absolute;
            top: 0px;
            right: 0px;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            color: black;
            background: white;
            padding: 5px 10px;
            border-radius: 0 0 0 15px;
            /* Bo góc trái trên và góc dưới */
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            /* Hiệu ứng đổ bóng */
            transition: background 0.3s ease, color 0.3s ease;
        }

        .close-btn:hover {
            color: white;
            background: red;
            /* Chuyển nền đỏ khi hover */
        }
    </style>
</head>

<body>
    <div class="container" style="position: relative;">
        <div class="form-container" >
            <div class="close-btn" onclick="goBack()">✖</div>

            <h2>Đăng ký</h2>

            <?php if (!empty($error)): ?>
                <p style="color: red;"><?= $error; ?></p>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <p style="color: green;"><?= $success; ?></p>
            <?php endif; ?>


            <form id="register-form" method="POST">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" id="username" placeholder="Tên đăng nhập" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Mật khẩu" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="confirm-password" id="confirm-password" placeholder="Xác nhận mật khẩu"
                        required>
                </div>
                <button type="submit">Đăng ký</button>
            </form>

            <p>Đã có tài khoản? <a href="index.php?page=login">Đăng nhập</a></p>
        </div>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("register-form").addEventListener("submit", function (e) {
                const password = document.getElementById("password").value;
                const confirmPassword = document.getElementById("confirm-password").value;

                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert("Mật khẩu xác nhận không khớp!");
                }
            });
        });

    </script>
</body>

</html>