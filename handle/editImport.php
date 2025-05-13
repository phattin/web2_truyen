<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'updateStatus') {
    $importID = $_POST['importID'];
    $status = $_POST['status'];

    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/importDB.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/productDB.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/importDetailDB.php";

    $result = importDB::updateImportStatus($importID, $status);

    if ($result && $status == "Đã nhận") {
        $import = importDB::getImportByID($importID);
        $productDB = new productDB();
        $products = importDetailDB::getImportDetailByImportID($importID);

        foreach ($products as $product) {
            $productID = $product['ProductID'];
            $quantity = $product['Quantity'];
            $importPrice = $product['Price'];
            $ros = $import['ROS'];

            // Cập nhật số lượng tồn kho
            $productDB->updateProductQuantity($productID, $quantity);

            // Kiểm tra để cập nhật giá nếu cần
            $productTemp = $productDB->getProductByID($productID);
            if ($productTemp && ($productTemp['Quantity'] * (1 + $productTemp['ROS']) < $importPrice * (1 + $ros))) {
                $productDB->updateProductPrice($productID, $importPrice, $ros);
            }
        }
    }

    echo $result ? "success" : "error";
}
?>