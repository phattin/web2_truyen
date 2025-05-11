<?php
echo"
    <input type='button' value='Thêm' class='blue-btn' onclick='themHDN()' style='width:100%;'>
    <table class='product-admin-table'>
        <tr>
            <th>Mã hóa đơn nhập</th>
            <th>Mã nhân viên</th>
            <th>Mã nhà cung cấp</th>
            <th>Ngày nhập</th>
            <th>Tổng tiền</th>
            <th>Thao tác</th>
        </tr>";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/importDB.php";
        $imports = importDB::getAllImports();
        foreach ($imports as $import) {
            echo "<tr id='import-row-".$import["ImportID"]."'>
                    <td>" . $import["ImportID"] . "</td>
                    <td>" . $import["EmployeeID"] . "</td>
                    <td>" . $import["SupplierID"] . "</td>
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