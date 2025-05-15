<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="view/layout/css/sign_in.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="container" style="position: relative;">
        <div class="form-container">
            <div class="close-btn" onclick="goBack()">✖</div>
            <h2>Đăng nhập</h2>
            <form id="login-form" method="POST">
                <div class="input-group" >
                    <i class="fas fa-user"></i>
                    <input type="text" name="identifier" id="identifier" placeholder="Email hoặc Username" required>
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
        </div>
    </div>

    <script src="/webbantruyen/view/layout/js/jquery-3.7.1.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("login-form").addEventListener("submit", function (e) {
                e.preventDefault(); // Ngăn chặn hành vi submit mặc định

                const identifier = document.getElementById("identifier").value.trim(); // Có thể là email hoặc username
                const password = document.getElementById("password").value.trim();

                // Kiểm tra dữ liệu đầu vào
                if (identifier === "") {
                    alert("Vui lòng nhập email hoặc tên đăng nhập!");
                    return;
                }

                if (password === "") {
                    alert("Mật khẩu không được để trống!");
                    return;
                }

                // Gửi dữ liệu qua AJAX
                $.ajax({
                    url: "/webbantruyen/handle/login_ajax.php", // Đường dẫn xử lý đăng nhập
                    type: "POST",
                    data: {
                        identifier: identifier,
                        password: password
                    },
                    dataType: "json", // Phản hồi từ server là JSON
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
                                    <div class='text'>Đăng nhập thành công!</div>
                                    <div class='line'></div>
                                </div>
                            `;

                            // Chuyển hướng sau 2 giây
                            setTimeout(function () {
                                window.location.href = res.redirectURL; // URL chuyển hướng từ server
                            }, 2000);
                        } else {
                            alert(res.message || "Có lỗi xảy ra khi đăng nhập!");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Lỗi:", error);
                        console.log("Phản hồi từ server:", xhr.responseText);
                        alert("Sai tên tài khoản hoặc Email ");
                    }
                });
            });
        });

        function goBack() {
            window.location.href = "index.php";
        }
    </script>
</body>

</html>