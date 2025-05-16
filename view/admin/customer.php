<?php
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
                <td>" . $customer["CustomerID"] . "</td>
                <td>" . $customer["Fullname"] . "</td>
                <td>" . $customer["Username"] . "</td>
                <td>" . $customer["Email"] . "</td>
                <td>" . $customer["Address"] . "</td>
                <td>" . $customer["Phone"] . "</td>
                <td>" . $customer["TotalSpending"] . "</td>
                <td class='function-icon'>
                    <i class='fa-regular fa-pen-to-square edit-icon' onclick='suaKH(`" . $customer["CustomerID"] . "`)'></i>
                    <i class='fa-solid fa-lock lock-icon' 
                        style='display: " . ($isBlocked ? "inline-block" : "none") . ";' 
                    ></i>
                    <i class='fa-solid fa-unlock unlock-icon' 
                        style='display: " . (!$isBlocked ? "inline-block" : "none") . ";' 
                    ></i>
                </td>
            </tr>";
    }
}
echo "</table>";
?>
<script>
$(document).ready(function () {
    // Bấm lock
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

    // Bấm unlock
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