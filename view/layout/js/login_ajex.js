document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("login-form").addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent the default form submission
        
        // Get form values
        let email = document.getElementById("email").value.trim();
        let password = document.getElementById("password").value.trim();
        let statusMessage = document.getElementById("status-message");
        
        // Clear previous error messages
        statusMessage.textContent = "";
        
        // Validate form data
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            statusMessage.textContent = "Email không hợp lệ!";
            return;
        }
        
        if (password === "") {
            statusMessage.textContent = "Mật khẩu không được để trống!";
            return;
        }
        
        // Show loading message
        statusMessage.textContent = "Đang xử lý...";
        statusMessage.style.color = "blue";
        
        // Create FormData object
        let formData = new FormData();
        formData.append("email", email);
        formData.append("password", password);
        
        // Create and configure AJAX request
        let xhr = new XMLHttpRequest();
        xhr.open("POST", window.location.href, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Check if the response contains a redirect
                    if (xhr.responseText.includes("loading-screen")) {
                        // Insert the loading screen into the DOM
                        document.body.innerHTML = xhr.responseText;
                    } else if (xhr.responseText.includes("alert")) {
                        // Extract the alert message and show it
                        let alertMatch = xhr.responseText.match(/alert\('([^']+)'\)/);
                        if (alertMatch && alertMatch[1]) {
                            statusMessage.textContent = alertMatch[1];
                            statusMessage.style.color = "red";
                        } else {
                            statusMessage.textContent = "Đã xảy ra lỗi khi đăng nhập.";
                            statusMessage.style.color = "red";
                        }
                    }
                } else {
                    statusMessage.textContent = "Đã xảy ra lỗi khi gửi yêu cầu đăng nhập.";
                    statusMessage.style.color = "red";
                }
            }
        };
        xhr.send(formData);
    });
});

function goBack() {
    window.history.back();
}