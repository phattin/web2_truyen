<?php
    $productID = $_POST["product_id"];

    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
    $conn = connectDB::getConnection();
    $sql_data='SELECT * FROM `product` WHERE ProductID="'.$productID.'";';
    $result_sql=$conn->query( $sql_data );
    while($row=$result_sql->fetch_assoc()){
        $productID = $row["ProductID"];
        $productName = $row["ProductName"];
        $productImg = $row["ProductImg"];
        $author = $row["Author"];
        $publisher = $row["Publisher"];
        $quantity = $row["Quantity"];
        $importPrice = $row["ImportPrice"];
        $ros = $row["ROS"];
        $description = $row["Description"];
        $supplierID = $row["SupplierID"];
        $status = $row["Status"];
    };

    echo json_encode([
        "productID" => $productID,
        "productName" => $productName,
        "productImg" => $productImg,
        "author" => $author,
        "publisher" => $publisher,
        "quantity" => $quantity,
        "importPrice" => $importPrice,
        "ros" => $ros,
        "description" => $description,
        "supplierID" => $supplierID,
        "status" => $status,
    ]);
    $conn->close();
?>
