
<?php
    if ($_POST['action'] == 'import') {
        $data = json_decode($_POST['data'], true);

        $importID = $data['importID'];
        $employeeID = $data['employeeID'];
        $supplierID = $data['supplierID'];
        $date = $data['date'];
        $totalPrice = $data['totalPrice'];
        $ros = $data['ros'] / 100;
        $products = $data['products'];

        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/importDB.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/productDB.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/importDetailDB.php";
        $importDB = new importDB();
        $importDetailDB = new importDetailDB();
        $productDB = new productDB();
        if(!$importDB -> addImport($importID, $employeeID, $supplierID, $date, $totalPrice, $ros, 'Đã đặt')) {
            echo "error";
            exit;
        }
        foreach ($products as $product) {
            $productID = $product['id'];
            $productName = $product['name'];
            $quantity = $product['quantity'];
            $importPrice = $product['price'];
            $totalImport = $product['total'];

            if($importDetailDB -> addImportDetail($importID, $productID, $quantity, $importPrice, $totalImport) == false) {
                echo "error";
                exit;
            }
        }
        echo "success";
    }
?>