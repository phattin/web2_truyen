<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/webbantruyen/view/layout/css/loginAdmin.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="login-form-container">
        <h2>Đăng nhập trang admin</h2>

        <div class="message-container" style="display: none;">
            <div class="message-content">
                <i class="fas fa-exclamation-circle"></i>
                <span id="message-text"></span>
            </div>
        </div>

        <form id="login-form">
            <div class="form-group">
                <label for="identifier">Email hoặc tên đăng nhập:</label>
                <input type="text" id="identifier" name="identifier" required>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" id="login-submit-btn" class="login-submit-btn">Đăng nhập</button>

           
        </form>
    </div>
    <script>
        $(document).ready(function () {
            // Submit form via AJAX when the form is submitted
            $("#login-form").submit(function (e) {
                e.preventDefault(); // Prevent default form submission

                // Get form values
                const identifier = $("#identifier").val().trim();
                const password = $("#password").val().trim();

                // Validate inputs
                if (!identifier || !password) {
                    showMessage("Vui lòng nhập đầy đủ thông tin đăng nhập.", "error");
                    return false;
                }

                // Disable submit button and show loading state
                $("#login-submit-btn").prop("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...');

                $.ajax({
                    url: "/webbantruyen/handle/employee_login_ajax.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        identifier: identifier,
                        password: password
                    },
                    success: function (response) {
                        if (response.success) {
                            // Show success message
                            showMessage(response.message, "success");

                            // Redirect after a short delay
                            setTimeout(function () {
                                window.location.href = response.redirectURL;
                            }, 1500);
                        } else {
                            // Show error message
                            showMessage(response.message, "error");
                            $("#login-submit-btn").prop("disabled", false).html('Đăng nhập');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        console.log("Response:", xhr.responseText);
                        showMessage("Có lỗi xảy ra khi xử lý yêu cầu. Vui lòng thử lại sau.", "error");
                        $("#login-submit-btn").prop("disabled", false).html('Đăng nhập');
                    }
                });
            });

            // Function to display messages
            function showMessage(message, type) {
                const messageContainer = $(".message-container");
                
                // Update the message text and icon
                $("#message-text").text(message);
                messageContainer.find("i").attr("class", "fas fa-" + (type === 'success' ? 'check-circle' : 'exclamation-circle'));
                
                // Update container class and show it
                messageContainer.attr("class", "message-container " + type + "-message").show();

                // Auto hide message after 5 seconds if it's a success message
                if (type === "success") {
                    setTimeout(function () {
                        messageContainer.fadeOut(500);
                    }, 5000);
                }
            }
        });
    </script>
</body>

</html>