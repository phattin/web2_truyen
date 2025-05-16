<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/roleDB.php";

// Check if user is logged in and has admin privileges
$isLoggedIn = isset($_SESSION['username']) && isset($_SESSION['role']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
$role = $isLoggedIn ? $_SESSION['role'] : '';
$functionDetail = roleDB::getAllFunctionDetailByRoleID($role);
echo "<div id='function-wrapper'>";

// Kiểm tra quyền "Thêm"
$showAddButton = false;
foreach ($functionDetail as $function) {
    if ($function["FunctionID"] === "F001" && $function["Option"] === "Thêm") {
        $showAddButton = true;
        break;
    }
}
if ($showAddButton) {
    echo "<input type='button' value='Thêm' class='blue-btn' onclick='themTK()' style='width:100%;'>";
}

// Kiểm tra quyền "Xem"
$showTable = false;
foreach ($functionDetail as $function) {
    if ($function["FunctionID"] === "F001" && $function["Option"] === "Xem") {
        $showTable = true;
        break;
    }
}

if ($showTable) {
    echo "<table class='product-admin-table'>
        <tr>
            <th>Username</th>
            <th>Mã nhân viên</th>
            <th>Tên nhân viên</th>
            <th>Mã quyền</th>
            <th>Tên quyền</th>
            <th>Thao tác</th>
        </tr>";

    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/accountDB.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/employeeDB.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/roleDB.php";

    $accounts = accountDB::getAllAccount();

    // Kiểm tra quyền "Sửa" và "Xóa"
    $canEdit = false;
    $canDelete = false;
    foreach ($functionDetail as $function) {
        if ($function["FunctionID"] === "F001") {
            if ($function["Option"] === "Sửa") $canEdit = true;
            if ($function["Option"] === "Xóa") $canDelete = true;
        }
    }

    foreach ($accounts as $acc) {
        $employee = employeeDB::getEmployeeByID(htmlspecialchars($acc["EmployeeID"]));
        $employeeName = $employee ? $employee["Fullname"] : "Không tìm thấy nhân viên";

        $role = roleDB::getRoleByID(htmlspecialchars($acc["RoleID"]));
        $roleName = $role ? $role["RoleName"] : "Không tìm thấy quyền";

        echo "<tr id='account-row-".$acc["Username"]."'>
                <td>" . htmlspecialchars($acc["Username"]) . "</td>
                <td>" . htmlspecialchars($acc["EmployeeID"]) . "</td>
                <td>" . $employeeName . "</td>
                <td>" . htmlspecialchars($acc["RoleID"]) . "</td>
                <td>" . $roleName . "</td>
                <td class='function-icon'>";

        if ($canEdit) {
            echo "<i class='fa-regular fa-pen-to-square edit-icon' onclick='suaTK(`".$acc["Username"]."`)'></i>";
        }
        if ($canDelete) {
            echo "<i class='fa-regular fa-trash-can delete-icon' onclick='xoaTK(`".$acc["Username"]."`)'></i>";
        }

        echo "</td></tr>";
    }

    echo "</table>";
}

echo "</div>";
?>