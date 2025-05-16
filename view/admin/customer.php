<?php
echo"
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
                // Kiểm tra trạng thái khóa
                $isBlocked = $customer["IsBlocked"] == 1;

                echo "<tr id='customer-row-".$customer["CustomerID"]."'>
                        <td>" . $customer["CustomerID"] . "</td>
                        <td>" . $customer["Fullname"] . "</td>
                        <td>" . $customer["Username"] . "</td>
                        <td>" . $customer["Email"] . "</td>
                        <td>" . $customer["Address"] . "</td>
                        <td>" . $customer["Phone"] . "</td>
                        <td>" . $customer["TotalSpending"] . "</td>
                        <td class='function-icon'>
                            <i class='fa-regular fa-pen-to-square edit-icon' onclick='suaKH(`".$customer["CustomerID"]."`)'></i>
                            <i class='fa-solid fa-unlock unlock-icon' 
                            style='display: ".($isBlocked ? "inline-block" : "none").";'
                            onclick='unlockKH(`".$customer["CustomerID"]."`)'></i>
                            <i class='fa-solid fa-lock lock-icon' 
                            style='display: ".(!$isBlocked ? "inline-block" : "none").";'
                            onclick='lockKH(`".$customer["CustomerID"]."`)'></i>
                        </td>
                    </tr>";
            }
        }
echo "
    </table>
    "
?>