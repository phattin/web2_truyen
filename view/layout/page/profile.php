<?php
include($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php");

$conn = connectDB::getConnection();
$conn->set_charset("utf8mb4");

$username = $_SESSION['username'] ?? '';
$email = $fullname = $address = $phone = '';
$totalSpending = 0;

// Lấy thông tin người dùng
if (!empty($username)) {
    $sql = "SELECT c.Email, c.Fullname, c.Address, c.Phone, c.TotalSpending, c.Username
            FROM customer c 
            WHERE c.Username = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $email = $user['Email'] ?? 'Chưa có';
            $fullname = $user['Fullname'] ?? 'Chưa có';
            $address = $user['Address'] ?? 'Chưa có';
            $phone = $user['Phone'] ?? 'Chưa có';
            $totalSpending = $user['TotalSpending'] ?? 0;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = trim($_POST['username'] ?? '');
    $newEmail = trim($_POST['email'] ?? '');
    $fullname = trim($_POST['fullname'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if (!empty($newUsername) && !empty($newEmail)) {
        // Kiểm tra username và email đã tồn tại chưa (trừ của người dùng hiện tại)
        $checkSQL = "SELECT Username, Email FROM customer WHERE (Username = ? OR Email = ?) AND Username != ?";
        if ($stmt = $conn->prepare($checkSQL)) {
            $stmt->bind_param("sss", $newUsername, $newEmail, $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Kiểm tra chi tiết để hiển thị thông báo lỗi cụ thể
                $existingData = $result->fetch_assoc();
                if ($existingData['Username'] == $newUsername) {
                    echo "<script>alert('Username đã tồn tại!'); window.location.href='index.php?page=profile';</script>";
                } else {
                    echo "<script>alert('Email đã tồn tại!'); window.location.href='index.php?page=profile';</script>";
                }
                exit();
            } else {
                try {
                    // Chỉ cập nhật thông tin trong bảng customer, cho phép đổi Username
                    $updateCustomerSQL = "UPDATE customer SET Username = ?, Email = ?, Fullname = ?, Address = ?, Phone = ? WHERE Username = ?";
                    if ($stmt = $conn->prepare($updateCustomerSQL)) {
                        $stmt->bind_param("ssssss", $newUsername, $newEmail, $fullname, $address, $phone, $username);
                        if (!$stmt->execute()) {
                            throw new Exception("Lỗi cập nhật thông tin: " . $stmt->error);
                        }
                        
                        // Cập nhật session với username mới
                        $_SESSION['username'] = $newUsername;
                        echo "<script>alert('Cập nhật thành công!'); window.location.href='index.php?page=profile';</script>";
                        exit();
                    }
                } catch (Exception $e) {
                    echo "<script>alert('" . addslashes($e->getMessage()) . "'); window.location.href='index.php?page=profile';</script>";
                    exit();
                }
            }
        } else {
            die("Lỗi kiểm tra dữ liệu trùng: " . $conn->error);
        }
    } else {
        echo "<script>alert('Vui lòng nhập đầy đủ thông tin!'); window.location.href='index.php?page=profile';</script>";
        exit();
    }
}

?>



<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <link rel="stylesheet" href="view/layout/css/profile.css">
</head>

<body>
    <div class="container">
        <div class="close-btn" onclick="goBack()">✖</div>

        <h2>Thông tin cá nhân</h2>
        <form method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn cập nhật thông tin?');">
            <div class="profile-info">
                <p><strong>Username:</strong> <input type="text" name="username"
                        value="<?= htmlspecialchars($username) ?>" disabled> <button type="button" class="btn-edit" onclick="toggleEdit(this)">Sửa</button></p>
                <p><strong>Email:</strong> <input type="email" name="email" value="<?= htmlspecialchars($email) ?>"
                        disabled> <button type="button" class="btn-edit" onclick="toggleEdit(this)">Sửa</button></p>
                <p><strong>Họ và tên:</strong> <input type="text" name="fullname"
                        value="<?= htmlspecialchars($fullname) ?>" disabled> <button type="button" class="btn-edit"
                        onclick="toggleEdit(this)">Sửa</button></p>
                <p><strong>Địa chỉ:</strong> <input type="text" name="address" value="<?= htmlspecialchars($address) ?>"
                        disabled> <button type="button" class="btn-edit" onclick="toggleEdit(this)">Sửa</button></p>
                <p><strong>Số điện thoại:</strong> <input type="tel" name="phone"
                        value="<?= htmlspecialchars($phone) ?>" disabled> <button type="button" class="btn-edit"
                        onclick="toggleEdit(this)">Sửa</button></p>
                <p><strong style="margin-top: 15px;">Tổng chi tiêu:</strong>
                    <span><?= number_format($totalSpending, 0, ',', '.') ?> VNĐ</span>
                </p>
            </div>
            <button type="submit" class="btn-save" id="save-btn">Cập nhật</button>
        </form>

    </div>

    <script>
        function logout() {
            if (confirm("Bạn có chắc chắn muốn thoát không?")) {
                window.location.href = "logout.php";
            }
        }
    </script>
    <script>
        function goBack() {
            window.location.href = "index.php";
        }
    </script>



    <script>
        function toggleEdit(button) {
            let input = button.previousElementSibling;
            if (input.disabled) {
                input.removeAttribute("disabled"); // Bỏ disabled
                input.focus();
            } else {
                input.setAttribute("disabled", "true"); // Nếu muốn tắt lại
            }

            document.getElementById("save-btn").style.display = "block";
        }

        // Khi submit form, bật lại các input bị disabled để gửi dữ liệu
        document.querySelector("form").addEventListener("submit", function () {
            document.querySelectorAll("input[disabled]").forEach(input => input.removeAttribute("disabled"));
        });

    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector("form").addEventListener("submit", function (e) {
                const phoneInput = document.querySelector("input[name='phone']");
                const phone = phoneInput.value.trim();

                // Kiểm tra số điện thoại phải đủ 10 chữ số
                if (!/^\d{10}$/.test(phone)) {
                    e.preventDefault();
                    alert("Số điện thoại phải có đúng 10 chữ số!");
                    phoneInput.focus();
                    return false;
                }
            });
        });
    </script>
</body>

</html>