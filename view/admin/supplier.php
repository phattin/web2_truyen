<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/roleDB.php";

$isLoggedIn = isset($_SESSION['username']) && isset($_SESSION['role']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
$role = $isLoggedIn ? $_SESSION['role'] : '';
$functionDetail = roleDB::getAllFunctionDetailByRoleID($role);

// Phân quyền F010
$canView = $canAdd = $canEdit = $canDelete = false;

foreach ($functionDetail as $func) {
    if ($func["FunctionID"] === "F010") {
        if ($func["Option"] === "Xem")     $canView = true;
        if ($func["Option"] === "Thêm")    $canAdd = true;
        if ($func["Option"] === "Sửa")     $canEdit = true;
        if ($func["Option"] === "Xóa")     $canDelete = true;
    }
}

if ($canView) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/supplierDB.php";
    $suppliers = supplierDB::getAllSupplier(); // Hàm này cần trả về tất cả supplier, kể cả IsDeleted = 0

    if ($canAdd) {
        echo "<input type='button' value='Thêm' class='blue-btn' onclick='themNCC()' style='width:100%;'>";
    }

    echo "
    <table class='product-admin-table'>
        <tr>
            <th>Mã nhà cung cấp</th>
            <th>Tên nhà cung cấp</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Thao tác</th>
        </tr>";

    foreach ($suppliers as $supplier) {
        if ($supplier["IsDeleted"] == 0) {
            echo "<tr id='supplier-row-" . htmlspecialchars($supplier["SupplierID"]) . "'>
                    <td>" . htmlspecialchars($supplier["SupplierID"]) . "</td>
                    <td>" . htmlspecialchars($supplier["SupplierName"]) . "</td>
                    <td>" . htmlspecialchars($supplier["Phone"]) . "</td>
                    <td>" . htmlspecialchars($supplier["Email"]) . "</td>
                    <td>" . htmlspecialchars($supplier["Address"]) . "</td>
                    <td class='function-icon'>";
                    
            if ($canEdit) {
                echo "<i class='fa-regular fa-pen-to-square edit-icon' onclick='suaNCC(`" . $supplier["SupplierID"] . "`)'></i>";
            }
            if ($canDelete) {
                echo "<i class='fa-regular fa-trash-can delete-icon' onclick='xoaNCC(`" . $supplier["SupplierID"] . "`)'></i>";
            }

            echo "</td></tr>";
        }
    }

    echo "</table>";
}
?>
