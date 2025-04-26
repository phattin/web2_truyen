<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="view/layout/css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .input-group {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            padding: 0 0 0 10px;
            background-color: white;
            color: #074b80;
        }

        .input-group:focus-within {
            border-color: #074b80;
            box-shadow: 0 0 10px rgba(7, 75, 128, 0.3);
        }

        .input-group i {
            padding: 0 10px;
            color: #074b80;
            font-size: 16px;
        }

        .input-group input {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            border: none;
            outline: none;
        }
    </style>
</head>

<body>
    <script src="/webbantruyen/view/layout/js/jquery-3.7.1.min.js"></script>
    <div class="container" style="position: relative;">
        <div class="form-container">
            <div class="close-btn" onclick="goBack()">✖</div>

            <h2>Đăng ký</h2>

            <?php if (!empty($error)): ?>
                <p style="color: red;"><?= $error; ?></p>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <p style="color: green;"><?= $success; ?></p>
            <?php endif; ?>

            <form id="register-form" method="POST">
                <div class="form-grid">
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" id="username" placeholder="Tên đăng nhập" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="fullname" id="fullname" placeholder="Họ và tên" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" id="email" placeholder="Email" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-phone"></i>
                        <input type="text" name="phone" id="phone" placeholder="Số điện thoại" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" placeholder="Mật khẩu" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-map-marker-alt"></i>
                        <input type="text" name="address" id="address" placeholder="Địa chỉ" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="confirm-password" id="confirm-password"
                            placeholder="Xác nhận mật khẩu" required>
                    </div>
                </div>
                <button type="submit">Đăng ký</button>
            </form>

            <p>Đã có tài khoản? <a href="index.php?page=login">Đăng nhập</a></p>
        </div>
    </div>
    <script src="/webbantruyen/view/layout/js/jquery-3.7.1.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("register-form").addEventListener("submit", function (e) {
                e.preventDefault(); // Ngăn chặn hành vi submit mặc định

                const fullname = document.getElementById("fullname").value.trim();
                const phone = document.getElementById("phone").value.trim();
                const password = document.getElementById("password").value;
                const confirmPassword = document.getElementById("confirm-password").value;
                const username = document.getElementById("username").value.trim();
                const email = document.getElementById("email").value.trim();
                const address = document.getElementById("address").value.trim();

                // Kiểm tra dữ liệu đầu vào
                if (username === "") {
                    alert("Tên đăng nhập không được để trống!");
                    return;
                }

                if (fullname === "") {
                    alert("Họ và tên không được để trống!");
                    return;
                }

                if (email === "") {
                    alert("Email không được để trống!");
                    return;
                }

                // Kiểm tra định dạng email
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    alert("Email không hợp lệ!");
                    return;
                }

                if (!/^0\d{9}$/.test(phone)) {
                    alert("Số điện thoại phải có đúng 10 số và bắt đầu bằng số 0!");
                    return;
                }

                if (address === "") {
                    alert("Địa chỉ không được để trống!");
                    return;
                }

                if (password === "") {
                    alert("Mật khẩu không được để trống!");
                    return;
                }

                if (password !== confirmPassword) {
                    alert("Mật khẩu và xác nhận mật khẩu không khớp!");
                    return;
                }

                // Gửi dữ liệu qua AJAX
                $.ajax({
                    url: "/webbantruyen/handle/register_ajax.php",
                    type: "POST",
                    data: {
                        username: username,
                        fullname: fullname,
                        email: email,
                        phone: phone,
                        address: address,
                        password: password,
                        "confirm-password": confirmPassword  // Match the parameter name with server
                    },
                    dataType: "json",  // Explicitly expect JSON response
                    success: function (res) {
                        if (res.success) {
                            // Thêm hiệu ứng loading screen
                            document.body.innerHTML += `
                                <style>
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
                            `;

                            // Chuyển hướng sau 2 giây
                            setTimeout(function () {
                                window.location.href = "index.php?page=login";
                            }, 2000);
                        } else {
                            alert(res.message || "Có lỗi xảy ra khi đăng ký!");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Lỗi:", error);
                        console.log("Phản hồi từ server:", xhr.responseText);
                        alert("Có lỗi xảy ra trong quá trình đăng ký. Vui lòng thử lại.");
                    }
                });
            });
        });

        function goBack() {
            window.location.href = "index.php";
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>

</html>