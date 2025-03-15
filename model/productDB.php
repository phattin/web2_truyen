<?php
    require 'connectDB.php';
    class productDB{
        // Lấy danh sách tất cả sản phẩm
        public function getAllProduct(){
            //Mở database
            $conn = connectDB::getConnection();
            //Lệnh sql
            $strSQL = 'Select * from product';
            //Thực hiện sql
            $result = mysqli_query($conn, $strSQL);
            //Thực hiện chức năng
            $productList = [];
            while($row = mysqli_fetch_assoc($result))
                $productList[] = $row;
            //Đóng kết nối
            connectDB::closeConnection($conn);
            return $productList;
        }

        // Thêm sản phẩm mới
        public function addProduct($id, $name, $img, $author, $publisher, $quantity, $ros, $description, $supplierID, $status) {
            //Mở database
            $conn = ConnectDB::getConnection();
            //Lệnh sql
            $strSQL = "INSERT INTO product (`ProductID`, `ProductName`, `ProductImg`, `Author`, `Publisher`, `Quantity`, `ROS`, `Description`, `SupplierID`, `Status`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            //Thực hiện sql
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("sssssiiisi", $id, $name, $img, $author, $publisher, $quantity, $ros, $description, $supplierID, $status);
            //Thực hiện chức năng
            $success = $stmt->execute();

            //Đóng kết nối
            $stmt->close();
            ConnectDB::closeConnection($conn);
            return $success;
        }

        //Sửa sản phẩm
        public function updateProduct($id, $name, $img, $author, $publisher, $quantity, $ros, $description, $supplierID, $status) {
            //Mở database
            $conn = ConnectDB::getConnection();
            //Lệnh sql
            $strSQL = "UPDATE product SET ProductName = ?, ProductImg = ?, Author = ?, Publisher = ?, Quantity = ?, ROS = ?, Description = ?, SupplierID = ?, Status = ? 
                       WHERE ProductID = ?";
            //Thực hiện sql
            $stmt = $conn->prepare($strSQL);
            if (!$stmt) 
                die("Lỗi chuẩn bị SQL: " . $conn->error);
            $stmt->bind_param("ssssiisisi", $name, $img, $author, $publisher, $quantity, $ros, $description, $supplierID, $status, $id);
            //Thực hiện chức năng
            $success = $stmt->execute();
            //Đóng kết nối
            $stmt->close();
            ConnectDB::closeConnection($conn);
        
            return $success;
        }

        //Sửa sản phẩm
        public function removeProduct($id) {
            //Mở database
            $conn = ConnectDB::getConnection();
            //Lệnh sql
            $strSQL = "UPDATE product SET Status = ? WHERE ProductID = ?";
            //Thực hiện sql
            $stmt = $conn->prepare($strSQL);
            if (!$stmt) 
                die("Lỗi chuẩn bị SQL: " . $conn->error);
            $stmt->bind_param("ss", "Ẩn", $id);
            //Thực hiện chức năng
            $success = $stmt->execute();
            //Đóng kết nối
            $stmt->close();
            ConnectDB::closeConnection($conn);
        
            return $success;
        }
    }
?>