<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php");

$conn = connectDB::getConnection();

// Xử lý đăng nhập trong cùng file này
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra nếu là AJAX request
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Truy vấn kiểm tra tài khoản và lấy RoleID
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

            // Chuyển hướng dựa trên RoleID
            $redirectURL = ($user['RoleID'] === 'R1') ? "/webbantruyen/index.php?page=admin" : "/webbantruyen/index.php?trangChu";

            if ($isAjax) {
                // Trả về JSON cho AJAX request
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Đăng nhập thành công!',
                    'redirectURL' => $redirectURL
                ]);
                exit;
            } else {
                // Form submit thông thường
                echo "<style>
                        body { margin: 0; padding: 0; overflow: hidden; }
                        #loading-screen {
                            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                            background: #074b80; display: flex; justify-content: center; align-items: center;
                            flex-direction: column; color: white; font-size: 20px; font-weight: bold;
                            z-index: 9999;
                        }
                        .path { fill: none; stroke: white; stroke-width: 4; stroke-linecap: round;
                                stroke-dasharray: 300; stroke-dashoffset: 300;
                                animation: draw 2.2s linear forwards; }
                        @keyframes draw { from { stroke-dashoffset: 300; } to { stroke-dashoffset: 0; } }
                    </style>
                    <div id='loading-screen'>
                        <svg width='300' height='100' viewBox='0 0 300 100'>
                            <path class='path' d='M10,50 Q60,10 110,50 T210,50 T310,50'/>
                        </svg>
                        <p>Đăng nhập thành công!</p>
                    </div>
                  <script>
                        setTimeout(function() {
                            window.location.href = '$redirectURL';
                        }, 2000);
                    </script>";
                exit;
            }
        } else {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Sai mật khẩu!']);
                exit;
            } else {
                echo "<script>alert('Sai mật khẩu!');</script>";
            }
        }
    } else {
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Email không tồn tại!']);
            exit;
        } else {
            echo "<script>alert('Email không tồn tại!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
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
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            transition: background 0.3s ease, color 0.3s ease;
        }

        .close-btn:hover {
            color: white;
            background: red;
        }

        #loading-spinner {
            display: none;
            text-align: center;
            margin-top: 10px;
        }

        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top: 4px solid #3498db;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #login-message {
            margin-top: 10px;
            padding: 8px;
            border-radius: 4px;
            text-align: center;
            display: none;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <div class="container" style="position: relative;">
        <div class="form-container">
            <div class="close-btn" onclick="goBack()">✖</div>
            <h2>Đăng nhập</h2>
            <form id="login-form" method="POST">
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Mật khẩu" required>
                </div>
                <button type="submit">Đăng nhập</button>
                <div id="loading-spinner">
                    <div class="spinner"></div> Đang xử lý...
                </div>
                <div id="login-message"></div>
            </form>
            <p>Chưa có tài khoản? <a href="index.php?page=register">Đăng ký</a></p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("login-form").addEventListener("submit", function (e) {
                e.preventDefault();

                let email = document.getElementById("email").value.trim();
                let password = document.getElementById("password").value.trim();
                let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!emailRegex.test(email)) {
                    alert("Email không hợp lệ!");
                    return;
                }

                if (password === "") {
                    alert("Mật khẩu không được để trống!");
                    return;
                }

                fetch("/webbantruyen/view/layout/page/login_ajax.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: new URLSearchParams({ email, password })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            document.body.innerHTML = `
                    <style>
                        body { margin: 0; padding: 0; overflow: hidden; }
                        #loading-screen {
                            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                            background: #074b80; display: flex; justify-content: center; align-items: center;
                            flex-direction: column; color: white; font-size: 20px; font-weight: bold;
                            z-index: 9999;
                        }
                        .path { fill: none; stroke: white; stroke-width: 4; stroke-linecap: round;
                                stroke-dasharray: 300; stroke-dashoffset: 300;
                                animation: draw 2.2s linear forwards; }
                        @keyframes draw { from { stroke-dashoffset: 300; } to { stroke-dashoffset: 0; } }
                    </style>
                    <div id='loading-screen'>
                        <svg width='300' height='100' viewBox='0 0 300 100'>
                            <path class='path' d='M10,50 Q60,10 110,50 T210,50 T310,50'/>
                        </svg>
                        <p>Đăng nhập thành công!</p>
                    </div>
                `;
                            setTimeout(() => {
                                window.location.href = data.redirect;
                            }, 2000);
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Lỗi:", error);
                        alert("Đã xảy ra lỗi. Vui lòng thử lại!");
                    });
            });
        });
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("login-form").addEventListener("submit", function (e) {
                let email = document.getElementById("email").value.trim();
                let password = document.getElementById("password").value.trim();
                let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    alert("Email không hợp lệ!");
                    e.preventDefault();
                    return;
                }
                if (password === "") {
                    alert("Mật khẩu không được để trống!");
                    e.preventDefault();
                    return;
                }
            });
        });
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>