<?php
echo"
    <input type='button' value='Thêm' class='blue-btn' id='TSP' onclick='ThemSP()' style='width:100%;'>
    <table class='product-admin-table'>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Tác giả</th>
            <th>Số lượng</th>
            <th>Thao tác</th>
        </tr>";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/productDB.php";
        $products = productDB::getAllProduct();
        foreach ($products as $product) {
            echo "<tr id='product-row-".$product["ProductID"]."'>
                    <td>" . $product["ProductID"] . "</td>
                    <td>" . $product["ProductName"] . "</td>
                    <td>" . $product["Author"] . "</td>
                    <td>" . $product["Quantity"] . "</td>
                    <td class='function-icon'>
                        <i class='fa-regular fa-eye detail-icon' onclick='ChitietSP(`".$product["ProductID"]."`)'></i>
                        <i class='fa-regular fa-pen-to-square edit-icon' id='SSP' onclick='editSP(`".$product["ProductID"]."`)'></i>
                        <i class='fa-regular fa-trash-can delete-icon' id='XSP' onclick='deleteSP(`".$product["ProductID"]."`)'></i>
                    </td>
                </tr>";
        }
echo "
    </table>
    "
?>