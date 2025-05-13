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

        public function __construct() {
            if (self::$conn === null) {
                self::$conn = connectDB::getConnection();
                if (self::$conn === null) {
                    die("Lỗi: Không thể kết nối đến cơ sở dữ liệu trong productDB constructor!");
                }
            }
        }

        public function __destruct() {
            if (self::$conn !== null) {
                connectDB::closeConnection(self::$conn);
                self::$conn = null;
            }
        }
        // Lấy tổng số sản phẩm để tính số trang
        public function getTotalProducts() {
            $result = $this->conn->query("SELECT COUNT(*) AS total FROM product WHERE  IsDeleted =  0");
            $row = $result->fetch_assoc();
            return $row['total'];
        }
    
        // Lấy danh sách sản phẩm có phân trang
        public function getProductsByPage($limit, $offset) {
            $stmt = $this->conn->prepare("SELECT * FROM product WHERE  IsDeleted =  0 LIMIT ? OFFSET ?");
            $stmt->bind_param("ii", $limit, $offset);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public static function getAllProduct(){
            //Mở database
            $conn = connectDB::getConnection();
            //Lệnh sql
            $strSQL = "Select * from product WHERE  IsDeleted =  0";
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

        // Lấy thông tin sản phẩm theo mã sản phẩm
        public static function getProductByID($productID) {
            // Mở database
            $conn = connectDB::getConnection();
            // Lệnh SQL đúng
            $strSQL = "SELECT * FROM product WHERE ProductID = ?";
        
            // Thực hiện SQL
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("s", $productID);
            $stmt->execute();
            $result = $stmt->get_result();
        
            // Lưu thông tin sản phẩm
            $product = null;
            if ($result->num_rows > 0)
                $product = $result->fetch_assoc();
        
            // Đóng kết nối
            connectDB::closeConnection($conn);
        
            return $product;
        }

        public static function getProductHasGenre($id) {
            // Mở database
            $conn = connectDB::getConnection();
            // Lệnh SQL đúng
            $strSQL = "SELECT * 
                       FROM product 
                       JOIN genre_detail ON product.ProductID = genre_detail.ProductID 
                       WHERE product. IsDeleted =  0 AND genre_detail.GenreID = ?";
        
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
            $strSQL = "INSERT INTO product (`ProductID`, `ProductName`, `ProductImg`, `Author`, `Publisher`, `Quantity`, `ImportPrice`, `ROS`, `Description`, `SupplierID`, `IsDeleted`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
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

        public static function getNewProductID() {
            // Mở kết nối
            $conn = connectDB::getConnection();

            // Lấy mã sản phẩm lớn nhất
            $sql = "SELECT MAX(ProductID) AS maxID FROM product";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $maxID = $row['maxID'];

            // Đóng kết nối
            connectDB::closeConnection($conn);

            // Nếu chưa có sản phẩm nào
            if (!$maxID) {
                return 'P001';
            }

            // Tách số từ mã, ví dụ: P005 -> 5
            $num = (int)substr($maxID, 1);
            $num++;

            // Tạo mã mới
            $newID = 'P' . str_pad($num, 3, '0', STR_PAD_LEFT);

            return $newID;
        }

        //Sửa sản phẩm
        public function updateProduct($id, $name, $img, $author, $publisher, $quantity, $importPrice, $ros, $description, $supplierID, $status) {
            //Mở database
            $conn = ConnectDB::getConnection();
            //Lệnh sql
            $strSQL = "UPDATE product SET ProductName = ?, ProductImg = ?, Author = ?, Publisher = ?, Quantity = ?, ImportPrice = ? , ROS = ?, `Description` = ?, SupplierID = ?, `IsDeleted` = ? 
                       WHERE ProductID = ?";
            //Thực hiện sql
            $stmt = $conn->prepare($strSQL);
            if (!$stmt) 
                die("Lỗi chuẩn bị SQL: " . $conn->error);
            $stmt->bind_param("ssssiiissis", $name, $img, $author, $publisher, $quantity, $importPrice, $ros, $description, $supplierID, $status, $id);
            //Thực hiện chức năng
            $success = $stmt->execute();
            //Đóng kết nối
            $stmt->close();
            ConnectDB::closeConnection($conn);
        
            return $success;
        }

        //Xóa sản phẩm
        public function removeProduct($id) {
            //Mở database
            $conn = ConnectDB::getConnection();
            //Lệnh sql
            $strSQL = "UPDATE product SET `IsDeleted` = 1 WHERE ProductID = ?";
            //Thực hiện sql
            $stmt = $conn->prepare($strSQL);
            if (!$stmt) 
                die("Lỗi chuẩn bị SQL: " . $conn->error);
            $stmt->bind_param("s", $id);
            //Thực hiện chức năng
            $success = $stmt->execute();
            //Đóng kết nối
            $stmt->close();
            ConnectDB::closeConnection($conn);
        
            return $success;
        }
        
        
        // Lấy tổng số sản phẩm sau khi lọc
        public function getTotalFilteredProducts($minPrice = null, $maxPrice = null, $genres = [], $isNew = null, $isHot = null) {
            $sql = "SELECT COUNT(DISTINCT p.ProductID) AS total FROM product p";
            $conditions = [];
            $params = [];
            $types = "";

            $sql .= " LEFT JOIN genre_detail gd ON p.ProductID = gd.ProductID";

            if ($minPrice !== null) {
                $conditions[] = "p.ImportPrice * ( 1 + p.ROS ) >= ?";
                $params[] = $minPrice;
                $types .= "d";
            }
            if ($maxPrice !== null) {
                $conditions[] = "p.ImportPrice * ( 1 + p.ROS ) <= ?";
                $params[] = $maxPrice;
                $types .= "d";
            }
            if (!empty($genres)) {
                $placeholders = implode(',', array_fill(0, count($genres), '?'));
                $conditions[] = "gd.GenreID IN ($placeholders)";
                $params = array_merge($params, $genres);
                $types .= str_repeat("s", count($genres));
            }
            if ($isNew === true) {
                // Giả sử có một trường đánh dấu sản phẩm mới, ví dụ: IsNew
                $conditions[] = "p.IsNew = 1";
            }
            if ($isHot === true) {
                // Giả sử có một trường đánh dấu sản phẩm hot, ví dụ: IsHot
                $conditions[] = "p.IsHot = 1";
            }
            $conditions[] = "p. IsDeleted =  0";

            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            $stmt = self::$conn->prepare($sql);
            if (!$stmt) {
                die("Lỗi chuẩn bị SQL: " . self::$conn->error);
            }

            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();
            return $row['total'];
        }

        // Lấy danh sách sản phẩm đã lọc có phân trang
        public function getFilteredProducts($limit, $offset, $minPrice = null, $maxPrice = null, $genres = [], $isNew = null, $isHot = null) {
            $sql = "SELECT DISTINCT p.* FROM product p";
            $conditions = [];
            $params = [];
            $types = "";

            $sql .= " LEFT JOIN genre_detail gd ON p.ProductID = gd.ProductID";

            if ($minPrice !== null) {
                $conditions[] = "p.ImportPrice * ( 1 + p.ROS ) >= ?";
                $params[] = $minPrice;
                $types .= "d";
            }
            if ($maxPrice !== null) {
                $conditions[] = "p.ImportPrice * ( 1 + p.ROS ) <= ?";
                $params[] = $maxPrice;
                $types .= "d";
            }
            if (!empty($genres)) {
                $placeholders = implode(',', array_fill(0, count($genres), '?'));
                $conditions[] = "gd.GenreID IN ($placeholders)";
                $params = array_merge($params, $genres);
                $types .= str_repeat("s", count($genres));
            }
            if ($isNew === true) {
                $conditions[] = "p.IsNew = 1";
            }
            if ($isHot === true) {
                $conditions[] = "p.IsHot = 1";
            }
            $conditions[] = "p. IsDeleted =  0";

            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            $sql .= " LIMIT ? OFFSET ?";
            $params[] = $limit;
            $params[] = $offset;
            $types .= "ii";

            $stmt = self::$conn->prepare($sql);
            if (!$stmt) {
                die("Lỗi chuẩn bị SQL: " . self::$conn->error);
            }

            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            $productList = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $productList;
        }

        public function updateProductQuantity($productID, $quantity) {
            // Mở database
            $conn = ConnectDB::getConnection();
            // Lệnh sql
            $strSQL = "UPDATE product SET Quantity = ? WHERE ProductID = ?";
            // Thực hiện sql
            $stmt = $conn->prepare($strSQL);
            if (!$stmt) 
                die("Lỗi chuẩn bị SQL: " . $conn->error);

            $product = $this->getProductByID($productID);
            if (!$product) {
                die("Lỗi: Không tìm thấy sản phẩm với ID $productID");
            }

            $newQuantity = $product["Quantity"] + $quantity;
            $stmt->bind_param("is", $newQuantity, $productID);
            
            // Thực hiện chức năng
            $success = $stmt->execute();
            // Đóng kết nối
            $stmt->close();
            ConnectDB::closeConnection($conn);

            return $success;
        }


        public function updateProductPrice($productID, $price, $ros) {
            // Mở database
            $conn = ConnectDB::getConnection();
            // Lệnh sql
            $strSQL = "UPDATE product SET ImportPrice = ?, ROS = ? WHERE ProductID = ?";
            // Thực hiện sql
            $stmt = $conn->prepare($strSQL);
            if (!$stmt) 
                die("Lỗi chuẩn bị SQL: " . $conn->error);
            $stmt->bind_param("dds", $price, $ros, $productID);
            // Thực hiện chức năng
            $success = $stmt->execute();
            // Đóng kết nối
            $stmt->close();
            ConnectDB::closeConnection($conn);
        
            return $success;
        }
    }
?>