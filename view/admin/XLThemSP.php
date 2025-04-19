<?php   
    include("../../model/ThemSuaXoa.php");
    include("../../model/ID.php");
    $ProductID = $newID;
    $ProductName = $_GET["ProductName"];
    $ProductImg = $_GET["ProductImg"];
    $Author = $_GET["Author"];
    $Publisher = $_GET["Publisher"];
    $Quantity = (int) $_GET["Quantity"];
    $ImportPrice = (int) $_GET["ImportPrice"];
    $ROS = (float) $_GET["ROS"];
    $Description = $_GET["Description"];
    $SupplierID = $_GET["SupplierID"];
    $Status = $_GET["Status"];

    $sql = "INSERT INTO product 
        (ProductID, ProductName, ProductImg, Author, Publisher, Quantity, ImportPrice, ROS, Description, SupplierID, Status) 
        VALUES 
        ('$ProductID', '$ProductName', '$ProductImg', '$Author', '$Publisher', 
        $Quantity, $ImportPrice, $ROS, '$Description', '$SupplierID', '$Status')";

    $a = new ThemSuaXoa();
    $a->Them($sql);
?>