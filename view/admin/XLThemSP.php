<?php   
    include("../../model/ThemSuaXoa.php");
    include("../layout/js/Load_content.js");
    include("../../model/connectDB.php");
    include("../../model/ID.php");
    $a = new connectDB();
    $conn = $a->getConnection();

    $newIDSP = generateNextID($conn, 'product', 'ProductID', 'P');


    //Thêm sản phẩm mới
    if(isset($_GET["ProductName"])){
        $ProductID = $newIDSP; // ID sản phẩm mới
        $ProductName = $_GET["ProductName"];
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
    }     $ProductImg = $_GET["ProductImg"];
  

    //Xóa sản phẩm
    if(isset($_GET["ProductID"])){
        $ProductID = $_GET["ProductID"];
        $sql = "DELETE FROM product WHERE ProductID='$ProductID'";
        $a = new ThemSuaXoa();
        $a->Xoa($sql);
        header("Location: /webbantruyen/view/admin/");
    }
?>