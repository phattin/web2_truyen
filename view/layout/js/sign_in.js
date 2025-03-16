document.addEventListener("DOMContentLoaded", function () {
    // Xử lý đăng ký
    document.getElementById("register-form")?.addEventListener("submit", function (e) {
        e.preventDefault();
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm-password").value;

        if (password !== confirmPassword) {
            alert("Mật khẩu xác nhận không khớp!");
            return;
        }

        // Lấy dữ liệu từ form
        const formData = new FormData(this);

        fetch("./view/page/register.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            if (data.includes("Đăng ký thành công")) {
                alert("Đăng ký thành công! Vui lòng đăng nhập.");
                window.location.href = "index.php?page=login"; // Chuyển hướng đến trang đăng nhập
            } else {
                alert(data); // Hiển thị lỗi từ server
            }
        })
        .catch(error => console.error("Lỗi:", error));
    });

    // Xử lý đăng nhập
    document.getElementById("login-form")?.addEventListener("submit", function (e) {
        e.preventDefault();
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;

        fetch("./view/page/login.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
        })
        .then(response => response.text())
        .then(data => {
            if (data.includes("Đăng nhập thành công")) {
                window.location.href = "index.php"; // Chuyển hướng sau khi đăng nhập thành công
            } else {
                alert("Sai email hoặc mật khẩu!"); // Thông báo lỗi
            }
        })
        .catch(error => console.error("Lỗi:", error));
    });
});
