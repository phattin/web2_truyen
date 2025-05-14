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
            $strSQL = "Select * from product WHERE IsDeleted =  0";
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
            $strSQL = "SELECT DISTINCT product.* 
                       FROM product 
                       JOIN category ON product.CategoryID = category.CategoryID 
                       JOIN genre_detail ON category.CategoryID = genre_detail.CategoryID 
                       WHERE product.IsDeleted = 0 AND genre_detail.GenreID = ?";
        
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

        public static function getProductHasCategory($id) {
            // Mở database
            $conn = connectDB::getConnection();
            // Lệnh SQL đúng
            $strSQL = "SELECT DISTINCT product.* 
                       FROM product 
                       JOIN category ON product.CategoryID = category.CategoryID 
                       WHERE product.IsDeleted = 0 AND category.CategoryID = ?";
        
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
        public function addProduct($id, $name, $img, $category, $author, $publisher, $quantity, $importPrice, $ros, $description, $supplierID, $status) {
            //Mở database
            $conn = ConnectDB::getConnection();
            //Lệnh sql
            $strSQL = "INSERT INTO product (`ProductID`, `ProductName`, `ProductImg`, `CategoryID`, `Author`, `Publisher`, `Quantity`, `ImportPrice`, `ROS`, `Description`, `SupplierID`, `IsDeleted`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            //Thực hiện sql
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("ssssssiiiisi", $id, $name, $img, $category, $author, $publisher, $quantity, $importPrice,  $ros, $description, $supplierID, $status);
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
        public function updateProduct($id, $name, $img, $category, $author, $publisher, $quantity, $importPrice, $ros, $description, $supplierID, $status) {
            //Mở database
            $conn = ConnectDB::getConnection();
            //Lệnh sql
            $strSQL = "UPDATE product SET ProductName = ?, ProductImg = ?, Category = ?, Author = ?, Publisher = ?, Quantity = ?, ImportPrice = ? , ROS = ?, `Description` = ?, SupplierID = ?, `IsDeleted` = ? 
                       WHERE ProductID = ?";
            //Thực hiện sql
            $stmt = $conn->prepare($strSQL);
            if (!$stmt) 
                die("Lỗi chuẩn bị SQL: " . $conn->error);
            $stmt->bind_param("sssssiiissis", $name, $img, $category, $author, $publisher, $quantity, $importPrice, $ros, $description, $supplierID, $status, $id);
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
        public function getTotalFilteredProducts($minPrice = null, $maxPrice = null, $categories = [], $search = '') {
            $sql = "SELECT COUNT(DISTINCT p.ProductID) AS total FROM product p
                    LEFT JOIN category c ON c.CategoryID = p.CategoryID";
            $conditions = ["p.IsDeleted = 0"];
            $params = [];
            $types = "";

            // Lọc theo minPrice
            if ($minPrice !== null) {
                $conditions[] = "p.ImportPrice * (1 + p.ROS) >= ?";
                $params[] = $minPrice;
                $types .= "d";
            }
            // Lọc theo maxPrice
            if ($maxPrice !== null) {
                $conditions[] = "p.ImportPrice * (1 + p.ROS) <= ?";
                $params[] = $maxPrice;
                $types .= "d";
            }
            // Lọc theo thể loại
            if (!empty($categories)) {
                // Tạo chuỗi dấu hỏi cho từng phần tử trong mảng $categories
                $placeholders = implode(',', array_fill(0, count($categories), '?'));
                $conditions[] = "p.CategoryID IN ($placeholders)";
                $params = array_merge($params, $categories);
                $types .= str_repeat("s", count($categories));  // 'i' cho integer nếu CategoryID là kiểu số
            }
            // Lọc theo tên sản phẩm
            if (!empty($search)) {
                $conditions[] = "LOWER(p.ProductName) LIKE ?";
                $params[] = "%" . strtolower($search) . "%";
                $types .= "s";
            }

            // Tạo phần điều kiện WHERE
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            // Chuẩn bị câu SQL
            $stmt = self::$conn->prepare($sql);
            if (!$stmt) {
                die("Lỗi chuẩn bị SQL: " . self::$conn->error);
            }

            // Gắn tham số vào câu SQL
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
        public function getFilteredProducts($limit, $offset, $minPrice = null, $maxPrice = null, $categories = [], $search = '') {
            $sql = "SELECT DISTINCT p.* FROM product p
                    LEFT JOIN category c ON c.CategoryID = p.CategoryID";
            $conditions = ["p.IsDeleted = 0"];
            $params = [];
            $types = "";

            // Lọc theo giá trị minPrice
            if ($minPrice !== null) {
                $conditions[] = "p.ImportPrice * (1 + p.ROS) >= ?";
                $params[] = $minPrice;
                $types .= "d";  // Sử dụng 'd' cho double
            }
            // Lọc theo giá trị maxPrice
            if ($maxPrice !== null) {
                $conditions[] = "p.ImportPrice * (1 + p.ROS) <= ?";
                $params[] = $maxPrice;
                $types .= "d";  // Sử dụng 'd' cho double
            }
            // Lọc theo thể loại nếu có
            if (!empty($categories)) {
                // Tạo chuỗi dấu hỏi cho từng phần tử trong mảng $categories
                $placeholders = implode(',', array_fill(0, count($categories), '?'));
                $conditions[] = "p.CategoryID IN ($placeholders)";
                $params = array_merge($params, $categories);
                $types .= str_repeat("s", count($categories));  // 'i' cho integer nếu CategoryID là kiểu số
            }
            // Lọc theo tên sản phẩm
            if (!empty($search)) {
                $conditions[] = "LOWER(p.ProductName) LIKE ?";
                $params[] = "%" . strtolower($search) . "%";
                $types .= "s";  // 's' cho string
            }

            // Xây dựng câu SQL điều kiện
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            // Thêm phân trang vào câu SQL
            $sql .= " ORDER BY p.ProductName ASC LIMIT ? OFFSET ?";
            $params[] = $limit;
            $params[] = $offset;
            $types .= "ii";  // 'ii' cho integer, dùng cho limit và offset

            // Thực thi câu lệnh
            $stmt = self::$conn->prepare($sql);
            if (!$stmt) {
                die("Lỗi chuẩn bị SQL: " . self::$conn->error);
            }

            // Gắn tham số vào câu SQL
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }

            // Thực thi và lấy kết quả
            $stmt->execute();
            $result = $stmt->get_result();
            $productList = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            // Thêm câu SQL vào mỗi sản phẩm để debug
            foreach($productList as &$product) {
                $product['sql'] = $sql;  // Thêm SQL vào mỗi sản phẩm để kiểm tra
                $product['params'] = $params;  // Thêm SQL vào mỗi sản phẩm để kiểm tra
            }

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