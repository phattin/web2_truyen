document.getElementById('register-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    if (password !== confirmPassword) {
        alert('Mật khẩu không khớp!');
    } else {
        alert('Đăng ký thành công!');
        // Gửi dữ liệu đăng ký lên server (có thể sử dụng fetch hoặc XMLHttpRequest)
    }
});

document.getElementById('login-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Kiểm tra thông tin đăng nhập (giả lập)
    if (email === 'test@example.com' && password === '123456') {
        alert('Đăng nhập thành công!');
        // Chuyển hướng đến trang chính
    } else {
        alert('Email hoặc mật khẩu không đúng!');
    }
});