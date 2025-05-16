<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/roleDB.php";

$isLoggedIn = isset($_SESSION['username']) && isset($_SESSION['role']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
$role = $isLoggedIn ? $_SESSION['role'] : '';
$functionDetail = roleDB::getAllFunctionDetailByRoleID($role);
// Kiểm tra quyền Thêm sản phẩm (F002 - Thêm)
$showAdd = false;
foreach ($functionDetail as $function) {
    if ($function["FunctionID"] === "F002" && $function["Option"] === "Thêm") {
        $showAdd = true;
        break;
    }
}
if ($showAdd) {
    echo "<input type='button' value='Thêm' class='blue-btn TSP' onclick='ThemSP()' style='width:100%;'>";
}

// Kiểm tra quyền Xem sản phẩm (F002 - Xem)
$showTable = false;
foreach ($functionDetail as $function) {
    if ($function["FunctionID"] === "F002" && $function["Option"] === "Xem") {
        $showTable = true;
        break;
    }
}

if ($showTable) {
    echo "<table class='product-admin-table'>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Tác giả</th>
            <th>Số lượng</th>
            <th>Thao tác</th>
        </tr>";

    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/productDB.php";
    $products = productDB::getAllProduct();

    // Kiểm tra quyền Sửa và Xóa
    $canEdit = false;
    $canDelete = false;
    foreach ($functionDetail as $function) {
        if ($function["FunctionID"] === "F002") {
            if ($function["Option"] === "Sửa") $canEdit = true;
            if ($function["Option"] === "Xóa") $canDelete = true;
        }
    }

    foreach ($products as $product) {
        echo "<tr id='product-row-".$product["ProductID"]."'>
                <td>" . htmlspecialchars($product["ProductID"]) . "</td>
                <td>" . htmlspecialchars($product["ProductName"]) . "</td>
                <td>" . htmlspecialchars($product["Author"]) . "</td>
                <td>" . htmlspecialchars($product["Quantity"]) . "</td>
                <td class='function-icon'>
                    <i class='fa-regular fa-eye detail-icon' onclick='ChitietSP(`".$product["ProductID"]."`)'></i>";
        
        if ($canEdit) {
            echo "<div class='SSP'><i class='fa-regular fa-pen-to-square edit-icon' onclick='editSP(`".$product["ProductID"]."`)'></i></div>";
        }
        if ($canDelete) {
            echo "<div class='XSP'><i class='fa-regular fa-trash-can delete-icon' onclick='deleteSP(`".$product["ProductID"]."`)'></i></div>";
        }

        echo "</td></tr>";
    }

    echo "</table>";
}
?>
