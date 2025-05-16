<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/roleDB.php";

$isLoggedIn = isset($_SESSION['username']) && isset($_SESSION['role']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
$role = $isLoggedIn ? $_SESSION['role'] : '';
$functionDetail = roleDB::getAllFunctionDetailByRoleID($role);
// Kiểm tra phân quyền F007
$canView = $canAdd = $canEdit = $canDelete = $canDetail = false;

foreach ($functionDetail as $func) {
    if ($func["FunctionID"] === "F007") {
        if ($func["Option"] === "Xem")     $canView = true;
        if ($func["Option"] === "Thêm")    $canAdd = true;
        if ($func["Option"] === "Sửa")     $canEdit = true;
        if ($func["Option"] === "Xóa")     $canDelete = true;
        if ($func["Option"] === "Chi tiết") $canDetail = true;
    }
}

if ($canView) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
    $conn = connectDB::getConnection();
    $sql_data_acc = 'SELECT * FROM `role`';
    $result_acc = $conn->query($sql_data_acc);

    if ($canAdd) {
        echo "<input type='button' value='Thêm' class='blue-btn TQ' onclick='ThemRole()' style='width:100%;'>";
    }

    echo "
    <table>
        <tr>
            <th>ROLE ID</th>
            <th>Tên ROLE</th>
            <th>Chức năng</th>
        </tr>";

    while ($row = $result_acc->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["RoleID"]) . "</td>
                <td>" . htmlspecialchars($row["RoleName"]) . "</td>
                <td class='function-icon'>";

        if ($canDetail) {
            echo "<i class='fa-regular fa-eye detail-icon XemQ' onclick='ChitietRole(\"" . $row["RoleID"] . "\")'></i>";
        }

        if ($canEdit) {
            echo "<div class='SSP'>
                    <i class='fa-regular fa-pen-to-square edit-icon' onclick='SuaRole(\"" . $row["RoleID"] . "\")'></i>
                  </div>";
        }

        if ($canDelete) {
            echo "<div class='XSP'>
                    <i class='fa-regular fa-trash-can delete-icon' onclick='XoaRole(\"" . $row["RoleID"] . "\")'></i>
                  </div>";
        }

        echo "</td></tr>";
    }

    echo "</table>";
    $conn->close();
}
?>
