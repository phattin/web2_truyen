<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/roleDB.php";

$isLoggedIn = isset($_SESSION['username']) && isset($_SESSION['role']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
$role = $isLoggedIn ? $_SESSION['role'] : '';
$functionDetail = roleDB::getAllFunctionDetailByRoleID($role);
// Phân quyền F005 - quản lý nhân viên
$canAdd = $canView = $canEdit = $canDelete = false;

foreach ($functionDetail as $function) {
    if ($function["FunctionID"] === "F005") {
        if ($function["Option"] === "Thêm") $canAdd = true;
        if ($function["Option"] === "Xem")  $canView = true;
        if ($function["Option"] === "Sửa")  $canEdit = true;
        if ($function["Option"] === "Xóa")  $canDelete = true;
    }
}

if ($canAdd) {
    echo "<input type='button' value='Thêm' class='blue-btn' onclick='themNV()' style='width:100%;'>";
}

if ($canView) {
    echo "
    <table class='product-admin-table'>
        <tr>
            <th>Mã nhân viên</th>
            <th>Họ tên</th>
            <th>Giới tính</th>
            <th>Ngày sinh</th>
            <th>SĐT</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Lương</th>
            <th>Ngày vào làm</th>
            <th>Thao tác</th>
        </tr>";

    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/employeeDB.php";
    $employees = employeeDB::getAllEmployee();

    foreach ($employees as $emp) {
        if ($emp["EmployeeID"] !== "NV000") {
            echo "<tr id='employee-row-".$emp["EmployeeID"]."'>
                    <td>" . htmlspecialchars($emp["EmployeeID"]) . "</td>
                    <td>" . htmlspecialchars($emp["Fullname"]) . "</td>
                    <td>" . htmlspecialchars($emp["Gender"]) . "</td>
                    <td>" . htmlspecialchars($emp["BirthDay"]) . "</td>
                    <td>" . htmlspecialchars($emp["Phone"]) . "</td>
                    <td>" . htmlspecialchars($emp["Email"]) . "</td>
                    <td>" . htmlspecialchars($emp["Address"]) . "</td>
                    <td>" . htmlspecialchars($emp["Salary"]) . "</td>
                    <td>" . htmlspecialchars($emp["StartDate"]) . "</td>
                    <td class='function-icon'>";
            
            if ($canEdit) {
                echo "<i class='fa-regular fa-pen-to-square edit-icon' onclick='suaNV(`".$emp["EmployeeID"]."`)'></i>";
            }

            if ($canDelete) {
                echo "<i class='fa-regular fa-trash-can delete-icon' onclick='xoaNV(`".$emp["EmployeeID"]."`)'></i>";
            }

            echo "</td></tr>";
        }
    }

    echo "</table>";
}
?>
