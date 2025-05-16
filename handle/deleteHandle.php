<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/productDB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/promotionDB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/employeeDB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/accountDB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/supplierDB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/roleDB.php";

header('Content-Type: application/json');

// Kiểm tra loại dữ liệu cần xóa
$productID = $_POST['productID'] ?? null;
$promotionID = $_POST['promotionID'] ?? null;
$employeeID = $_POST['employeeID'] ?? null;
$supplierID = $_POST['supplierID'] ?? null;
$roleID = $_POST['roleID'] ?? null;
$isLoggedIn = isset($_SESSION['username']) && isset($_SESSION['role']);
$username = $isLoggedIn ? $_SESSION['username'] : '';

if ($productID) {
    // Xóa sản phẩm
    $productDB = new productDB();
    $result = $productDB->removeProduct($productID);

    if ($result) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Lỗi khi xóa sản phẩm trong database"
        ]);
    }

} else if ($promotionID) {
    // Xóa khuyến mãi
    $promotionDB = new promotionDB();
    $result = $promotionDB->removePromotion($promotionID);

    if ($result) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Lỗi khi xóa khuyến mãi trong database"
        ]);
    }

} 
else if ($supplierID) {
    // Xóa nhà cung cấp
    $supplierDB = new supplierDB();
    $result = $supplierDB->removeSupplier($supplierID);

    if ($result) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Lỗi khi xóa nhà cung cấp trong database"
        ]);
    }

}
else if ($roleID) {
    // Xóa nhà cung cấp
    $roleDB = new roleDB();
    if ($roleID == "R001") {
        echo json_encode([
            "success" => false,
            "message" => "Không thể xóa vai trò quản trị viên"
        ]);
        exit;
    }
    if(roleDB::checkRoleUsed($roleID)) {
        echo json_encode([
            "success" => false,
            "message" => "Không thể xóa vai trò này vì nó đang được sử dụng"
        ]);
        exit;
    }
    $result = $roleDB->removeRole($roleID);

    if ($result) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Lỗi khi xóa nhà cung cấp trong database"
        ]);
    }

}
else if ($employeeID) {
    // Xóa nhân viên
    $employeeDB = new employeeDB();
    $accountDB = new accountDB();
    $employeeLoggedIn = $employeeDB->getEmployeeByUsername($username);
    $account = $accountDB->getAccountByEmployeeID($employeeID);
    if ($employeeLoggedIn['EmployeeID'] == $employeeID) {
        echo json_encode([
            "success" => false,
            "message" => "Không thể xóa nhân viên đang đăng nhập"
        ]);
        exit;
    }
    $result = $employeeDB->removeEmployee($employeeID) && $accountDB->removeAccount($account['Username']);

    if ($result) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Lỗi khi xóa nhân viên trong database"
        ]);
    }

} 
else {
    echo json_encode([
        "success" => false,
        "message" => "Thiếu dữ liệu đầu vào"
    ]);
}
?>
