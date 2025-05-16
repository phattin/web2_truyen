<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/roleDB.php";

$isLoggedIn = isset($_SESSION['username']) && isset($_SESSION['role']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
$role = $isLoggedIn ? $_SESSION['role'] : '';
$functionDetail = roleDB::getAllFunctionDetailByRoleID($role);
// Phân quyền F009
$canView = $canAdd = $canEdit = $canDelete = false;

foreach ($functionDetail as $func) {
    if ($func["FunctionID"] === "F009") {
        if ($func["Option"] === "Xem")     $canView = true;
        if ($func["Option"] === "Thêm")    $canAdd = true;
        if ($func["Option"] === "Sửa")     $canEdit = true;
        if ($func["Option"] === "Xóa")     $canDelete = true;
    }
}

if ($canView) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/promotionDB.php";
    $promotions = promotionDB::getAllPromotion();

    if ($canAdd) {
        echo "<input type='button' value='Thêm' class='blue-btn' onclick='themKM()' style='width:100%;'>";
    }

    echo "
    <table class='product-admin-table'>
        <tr>
            <th>Mã khuyến mãi</th>
            <th>Tên khuyến mãi</th>
            <th>Giá trị giảm(%)</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Thao tác</th>
        </tr>";

    foreach ($promotions as $promotion) {
        if ($promotion["PromotionID"] !== "PR000") {
            echo "<tr id='promotion-row-" . $promotion["PromotionID"] . "'>
                    <td>" . htmlspecialchars($promotion["PromotionID"]) . "</td>
                    <td>" . htmlspecialchars($promotion["PromotionName"]) . "</td>
                    <td>" . $promotion["Discount"] . "</td>
                    <td>" . $promotion["StartDate"] . "</td>
                    <td>" . $promotion["EndDate"] . "</td>
                    <td class='function-icon'>";
                    
            if ($canEdit) {
                echo "<i class='fa-regular fa-pen-to-square edit-icon' onclick='suaKM(`" . $promotion["PromotionID"] . "`)'></i>";
            }
            if ($canDelete) {
                echo "<i class='fa-regular fa-trash-can delete-icon' onclick='xoaKM(`" . $promotion["PromotionID"] . "`)'></i>";
            }

            echo "</td></tr>";
        }
    }

    echo "</table>";
}
?>
