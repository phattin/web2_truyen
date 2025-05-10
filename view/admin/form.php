<?php
//chitiet sanpham
    if(isset($_POST["product_id"])) {
        $productID = $_POST["product_id"];

        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/productDB.php";
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
            "supplierID" => $supplierID
        ]);
    }
//chitiet khach hang
    /*if(!isset($_POST["username"])) {
        $username = $_POST["username"];

        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
        $conn = connectDB::getConnection();
        $sql_data='SELECT * FROM `account` WHERE Username="'.$username.'";';
        $result_sql=$conn->query( $sql_data );
        while($row=$result_sql->fetch_assoc()){
            $username = $row["Username"];
            $password = $row["Password"];
            $roleID = $row["RoleID"];
            $status = $row["Status"];
        };

        echo json_encode([
            "username" => $username,
            "password" => $password,
            "roleID" => $roleID,
            "status" => $status,
        ]);
        $conn->close();
    }*/

//chitiet ROLE
    /*if(!isset($_POST["roleID"])) {
        $roleID = $_POST["roleID"];

        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
        $conn = connectDB::getConnection();
        $sql_data='SELECT * FROM `role` WHERE RoleID="'.$roleID.'";';
        $result_sql=$conn->query( $sql_data );
        while($row=$result_sql->fetch_assoc()){
            $roleID = $row["RoleID"];
            $roleName = $row["RoleName"];
            $status = $row["Status"];
        };

        echo json_encode([
            "roleID" => $roleID,
            "roleName" => $roleName,
            "status" => $status,
        ]);
        $conn->close();
    }*/
//chitiet NV
if(isset($_POST["usernameNV"])) {
    $username = $_POST["usernameNV"];

    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
    $conn = connectDB::getConnection();
    $sql_data='SELECT * FROM `employee` WHERE `Username`="'.$username.'";';
    $result_sql=$conn->query( $sql_data );
    while($row=$result_sql->fetch_assoc()){
        $employeeID = $row["EmployeeID"];
        $fullname = $row["Fullname"];
        $username = $row["Username"];
        $birthDay = $row["BirthDay"];
        $phone = $row["Phone"];
        $email = $row["Email"];
        $address = $row["Address"];
        $Gender = $row["Gender"];
        $salary = $row["Salary"];
        $startDate = $row["StartDate"];
        $status = $row["Status"];
    };

    echo json_encode([
        "employeeID" => $employeeID,
        "fullname" => $fullname,
        "username" => $username,
        "birthDay" => $birthDay,
        "phone" => $phone,
        "email" => $email,
        "address" => $address,
        "Gender" => $Gender,
        "salary" => $salary,
        "startDate" => $startDate,
        "status" => $status,
    ]);
    $conn->close();
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
        
?>
