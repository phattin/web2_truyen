<?php
    $file_path = $_SERVER["DOCUMENT_ROOT"] . "/webbantruyen/model/connectDB.php";
    if (file_exists($file_path)) {
        require_once $file_path;
    } else {
        die("Lỗi: Không tìm thấy file connectDB.php!");
    }
    class productDB{
        // Lấy danh sách tất cả sản phẩm
        private static $conn;
        // Lấy tổng số sản phẩm để tính số trang
        public function getTotalProducts() {
            $result = $this->conn->query("SELECT COUNT(*) AS total FROM product WHERE Status = 'Hiện'");
            $row = $result->fetch_assoc();
            return $row['total'];
        }
    
        // Lấy danh sách sản phẩm có phân trang
        public function getProductsByPage($limit, $offset) {
            $stmt = $this->conn->prepare("SELECT * FROM product WHERE Status = 'Hiện' LIMIT ? OFFSET ?");
            $stmt->bind_param("ii", $limit, $offset);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public static function getAllProduct(){
            //Mở database
            $conn = connectDB::getConnection();
            //Lệnh sql
            $strSQL = "Select * from product WHERE Status = 'Hiện'";
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

        public static function getProductHasGenre($id) {
            // Mở database
            $conn = connectDB::getConnection();
            // Lệnh SQL đúng
            $strSQL = "SELECT * 
                       FROM product 
                       JOIN genre_detail ON product.ProductID = genre_detail.ProductID 
                       WHERE product.Status = 'Hiện' AND genre_detail.GenreID = ?";
        
            // Thực hiện SQL
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            // Lưu danh sách sản phẩm
            $productList = [];
            while ($row = $result->fetch_assoc()) {
                $productList[] = $row;
            }
            // Đóng kết nối
            connectDB::closeConnection($conn);
            return $productList;
        }

        // Thêm sản phẩm mới
        public function addProduct($id, $name, $img, $author, $publisher, $quantity, $importPrice, $ros, $description, $supplierID, $status) {
            //Mở database
            $conn = ConnectDB::getConnection();
            //Lệnh sql
            $strSQL = "INSERT INTO product (`ProductID`, `ProductName`, `ProductImg`, `Author`, `Publisher`, `Quantity`, `ImportPrice`, `ROS`, `Description`, `SupplierID`, `Status`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            //Thực hiện sql
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("sssssiiiisi", $id, $name, $img, $author, $publisher, $quantity, $importPrice,  $ros, $description, $supplierID, $status);
            //Thực hiện chức năng
            $success = $stmt->execute();

            //Đóng kết nối
            $stmt->close();
            ConnectDB::closeConnection($conn);
            return $success;
        }

        //Sửa sản phẩm
        public function updateProduct($id, $name, $img, $author, $publisher, $quantity, $importPrice, $ros, $description, $supplierID, $status) {
            //Mở database
            $conn = ConnectDB::getConnection();
            //Lệnh sql
            $strSQL = "UPDATE product SET ProductName = ?, ProductImg = ?, Author = ?, Publisher = ?, Quantity = ?, ImportPrice = ? , ROS = ?, `Description` = ?, SupplierID = ?, `Status` = ? 
                       WHERE ProductID = ?";
            //Thực hiện sql
            $stmt = $conn->prepare($strSQL);
            if (!$stmt) 
                die("Lỗi chuẩn bị SQL: " . $conn->error);
            $stmt->bind_param("ssssiissisi", $name, $img, $author, $publisher, $quantity, $importPrice, $ros, $description, $supplierID, $status, $id);
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
            $strSQL = "UPDATE product SET `Status` = ? WHERE ProductID = ?";
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