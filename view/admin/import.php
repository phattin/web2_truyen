<?php
echo"
    <input type='button' value='Nhập hàng' class='blue-btn' onclick='themHDN()' style='width:100%;'>
    <table class='product-admin-table'>
        <tr>
            <th>Mã hóa đơn nhập</th>
            <th>Tên nhân viên</th>
            <th>Tên nhà cung cấp</th>
            <th>Ngày nhập</th>
            <th>Tổng tiền</th>
            <th>Thao tác</th>
        </tr>";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/importDB.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/employeeDB.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/supplierDB.php";
        $imports = importDB::getAllImports();
        foreach ($imports as $import) {
            echo "<tr id='import-row-".$import["ImportID"]."'>
                    <td>" . $import["ImportID"] . "</td>
                    <td>" . employeeDB::getEmployeeByID($import["EmployeeID"])["Fullname"] . "</td>
                    <td>" . supplierDB::getSupplierByID($import["SupplierID"])["SupplierName"] . "</td>
                    <td>" . $import["Date"] . "</td>
                    <td>" . $import["TotalPrice"] . "</td>
                    <td class='function-icon'>
                        <i class='fa-regular fa-eye detail-icon' onclick='ChitietHDN(`".$import["ImportID"]."`)'></i>
                        <i class='fa-regular fa-pen-to-square edit-icon' onclick='suaHDN(`".$import["ImportID"]."`)'></i>
                        <i class='fa-regular fa-trash-can delete-icon' onclick='xoaHDN(`".$import["ImportID"]."`)'></i>
                    </td>
                </tr>";
        }
echo "
    </table>
    "
?>