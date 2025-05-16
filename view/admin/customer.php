<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/roleDB.php";

$isLoggedIn = isset($_SESSION['username']) && isset($_SESSION['role']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
$role = $isLoggedIn ? $_SESSION['role'] : '';
$functionDetail = roleDB::getAllFunctionDetailByRoleID($role);
// Phân quyền F006 - quản lý khách hàng
$canView = $canEdit = $canLock = false;

foreach ($functionDetail as $function) {
    if ($function["FunctionID"] === "F006") {
        if ($function["Option"] === "Xem")  $canView = true;
        if ($function["Option"] === "Sửa")  $canEdit = true;
        if ($function["Option"] === "Xóa") $canLock = true;
    }
}

if ($canView) {
    echo "
    <table class='product-admin-table'>
        <tr>
            <th>Mã khách hàng</th>
            <th>Tên khách hàng</th>
            <th>Tên đăng nhập</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>SĐT</th>
            <th>Tổng chi</th>
            <th>Thao tác</th>
        </tr>";

    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/customerDB.php";
    $customers = customerDB::getAllCustomer();

    foreach ($customers as $customer) {
        if ($customer["CustomerID"] !== "PR000") {
            $isBlocked = $customer["IsBlocked"] == 1;

            echo "<tr id='customer-row-" . $customer["CustomerID"] . "'>
                    <td>" . htmlspecialchars($customer["CustomerID"]) . "</td>
                    <td>" . htmlspecialchars($customer["Fullname"]) . "</td>
                    <td>" . htmlspecialchars($customer["Username"]) . "</td>
                    <td>" . htmlspecialchars($customer["Email"]) . "</td>
                    <td>" . htmlspecialchars($customer["Address"]) . "</td>
                    <td>" . htmlspecialchars($customer["Phone"]) . "</td>
                    <td>" . htmlspecialchars($customer["TotalSpending"]) . "</td>
                    <td class='function-icon'>";
            
            if ($canEdit) {
                echo "<i class='fa-regular fa-pen-to-square edit-icon' onclick='suaKH(`" . $customer["CustomerID"] . "`)'></i>";
            }

            if ($canLock) {
                echo "<i class='fa-solid fa-lock lock-icon' 
                        style='display: " . ($isBlocked ? "inline-block" : "none") . ";'></i>
                      <i class='fa-solid fa-unlock unlock-icon' 
                        style='display: " . (!$isBlocked ? "inline-block" : "none") . ";'></i>";
            }

            echo "</td></tr>";
        }
    }
    echo "</table>";
}
?>

<?php if ($canLock): ?>
<script>
$(document).ready(function () {
    // Mở khóa
    $(".unlock-icon").on("click", function () {
        const customerID = $(this).closest("tr").attr("id").replace("customer-row-", "");
        $.ajax({
            type: "POST",
            url: "/webbantruyen/handle/customerLockHandle.php",
            data: {
                customerID: customerID,
                action: "lock"
            },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    alert("Đã khóa khách hàng");
                    const row = $("#customer-row-" + customerID);
                    row.find(".unlock-icon").hide();
                    row.find(".lock-icon").show();
                } else {
                    alert("Lỗi: " + response.message);
                }
            },
            error: function () {
                alert("Đã xảy ra lỗi khi gửi yêu cầu khóa!");
            }
        });
    });

    // Khóa
    $(".lock-icon").on("click", function () {
        const customerID = $(this).closest("tr").attr("id").replace("customer-row-", "");
        $.ajax({
            type: "POST",
            url: "/webbantruyen/handle/customerLockHandle.php",
            data: {
                customerID: customerID,
                action: "unlock"
            },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    alert("Đã mở khóa khách hàng");
                    const row = $("#customer-row-" + customerID);
                    row.find(".lock-icon").hide();
                    row.find(".unlock-icon").show();
                } else {
                    alert("Lỗi: " + response.message);
                }
            },
            error: function () {
                alert("Đã xảy ra lỗi khi gửi yêu cầu mở khóa!");
            }
        });
    });
});
</script>
<?php endif; ?>
