<?php
//chitiet sanpham
    if(isset($_POST["product_id"])) {
        $productID = $_POST["product_id"];

        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/productDB.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/supplierDB.php";
        $product = productDB::getProductByID($productID);
        $productID = $product["ProductID"];
        $productName = $product["ProductName"];
        $productImg = $product["ProductImg"];
        $author = $product["Author"];
        $publisher = $product["Publisher"];
        $quantity = $product["Quantity"];
        $importPrice = $product["ImportPrice"];
        $ros = $product["ROS"];
        $description = $product["Description"];
        $supplierID = $product["SupplierID"];
        $allSuppliers = supplierDB::getAllSupplier();

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
            "allSupplier" => $allSuppliers,
        ]);
    }

//chitiet ROLE
    if(isset($_POST["roleID"])) {
        $roleID = $_POST["roleID"];

        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
        $conn = connectDB::getConnection();
        $sql_data='SELECT * FROM `role`LEFT JOIN `function_detail` ON role.RoleID=function_detail.RoleID WHERE role.RoleID = "'.$roleID.'";';
        $result_sql=$conn->query($sql_data );
        $data=[];
        while($row=$result_sql->fetch_assoc()){
            $data[] = [
                "RoleName" => $row["RoleName"],
                "RoleID" => $row["RoleID"],
                "FunctionID" => $row["FunctionID"],
                "Option" => $row["Option"],
            ];
        };
        $conn->close();
        echo json_encode($data);
        
    }
// chi tiet TK 
if(isset($_POST["Username"])) {
        $Username = $_POST["Username"];

        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
        $conn = connectDB::getConnection();
        $sql_data='SELECT * FROM `account` WHERE `Username` ="'.$Username.'";';
        $result_sql=$conn->query( $sql_data );
        while($row=$result_sql->fetch_assoc()){
            $username = $row["Username"];
            $Password = $row["Password"];
            $RoleID = $row["RoleID"];
            $EmployeeID = $row["EmployeeID"];
            $isDeleted = isset($row["IsDeleted"]) ? (int) $row["IsDeleted"] : 0;
        };
 
        header('Content-Type: application/json');

        echo json_encode([
            "username" => $username,
            "Password" => $Password,
            "RoleID" => $RoleID,
            "EmployeeID" => $EmployeeID,
            "isDeleted" => $isDeleted,
        ]);
    }


//chitiet NV  
    if(isset($_POST["EmployeeID"])) {
        $EmployeeID = $_POST["EmployeeID"];

        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
        $conn = connectDB::getConnection();
        $sql_data='SELECT * FROM `employee` WHERE `EmployeeID` ="'.$EmployeeID.'";';
        $result_sql=$conn->query( $sql_data );
        while($row=$result_sql->fetch_assoc()){
            $employeeID = $row["EmployeeID"];
            $fullname = $row["Fullname"];
            $birthDay = $row["BirthDay"];
            $phone = $row["Phone"];
            $email = $row["Email"];
            $address = $row["Address"];
            $Gender = $row["Gender"];
            $salary = $row["Salary"];
            $startDate = $row["StartDate"];
            $isDeleted = isset($row["IsDeleted"]) ? (int) $row["IsDeleted"] : 0;
        };
        if(is_null($isDeleted)){
            $isDeleted='0';
        }
        header('Content-Type: application/json');

        echo json_encode([
            "employeeID" => $employeeID,
            "fullname" => $fullname,
            "birthDay" => $birthDay,
            "phone" => $phone,
            "email" => $email,
            "address" => $address,
            "Gender" => $Gender,
            "salary" => $salary,
            "startDate" => $startDate,
            "isDeleted" => $isDeleted,
        ]);
    }

//chitiet KH

    if(isset($_POST["usernameKH"])) {
        $customername = $_POST["usernameKH"];

        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
        $conn = connectDB::getConnection();
        $sql_data='SELECT * FROM `customer` WHERE Username="'.$customername.'";';
        $result_sql=$conn->query( $sql_data );
        while($row=$result_sql->fetch_assoc()){
            $customerID = $row["CustomerID"];
            $fullname = $row["Fullname"];
            $username = $row["Username"];
            $phone = $row["Phone"];
            $email = $row["Email"];
            $address = $row["Address"];
            $totalSpending = $row["TotalSpending"];
            $status = $row["Status"];
        };

        echo json_encode([
            "CustomerID" => $customerID,
            "Fullname" => $fullname,
            "Username" => $username,
            "Phone" => $phone,
            "Email" => $email,
            "Address" => $address,
            "TotalSpending" => $totalSpending,
            "Status" => $status,
        ]);
        $conn->close();
    }

    if(isset($_POST["importID"])) {
        $importID = $_POST["importID"];

        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/productDB.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/importDB.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/importDetailDB.php";
        $import = importDB::getImportByID($importID);
        $importDetails = importDetailDB::getImportDetailByImportID($importID);
        foreach ($importDetails as &$detail) {
            $product = productDB::getProductByID($detail["ProductID"]);
            $detail["ProductName"] = $product["ProductName"];
        }

        echo json_encode([
            "importID" => $import["ImportID"],
            "employeeID" => $import["EmployeeID"],
            "supplierID" => $import["SupplierID"],
            "importDate" => $import["Date"],
            "totalPrice" => $import["TotalPrice"],
            "status" => $import["Status"],
            "importDetails" => $importDetails,
        ]);
    }

    //chitiet khuyen mai
    if(isset($_POST["promotion_id"])) {
        $promotionID = $_POST["promotion_id"];

        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/promotionDB.php";
        $promotion = promotionDB::getPromotionByID($promotionID);
        $promotionID = $promotion["PromotionID"];
        $promotionName = $promotion["PromotionName"];
        $discount = $promotion["Discount"];
        $startDate = $promotion["StartDate"];
        $endDate = $promotion["EndDate"];
        echo json_encode([
            "promotionID" => $promotionID,
            "promotionName" => $promotionName,
            "discount" => $discount,
            "startDate" => $startDate,
            "endDate" => $endDate
        ]);
    }
        
?>
