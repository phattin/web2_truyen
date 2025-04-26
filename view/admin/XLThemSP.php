<?php   
    include("../../model/ThemSuaXoa.php");
    include("../../model/ID.php");
    include("../layout/js/Load_content.js");

    //Thêm sản phẩm mới
    if(isset($_GET["ProductName"])){
        $ProductID = $newIDSP; // ID sản phẩm mới
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
        header("Location: /webbantruyen/view/admin/");
    }

    //Xóa sản phẩm
    if(isset($_GET["ProductID"])){
        $ProductID = $_GET["ProductID"];
        $sql = "DELETE FROM product WHERE ProductID='$ProductID'";
        $a = new ThemSuaXoa();
        $a->Xoa($sql);
        header("Location: /webbantruyen/view/admin/");
    }
?>