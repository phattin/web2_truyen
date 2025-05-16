<?php
    $file_path = $_SERVER["DOCUMENT_ROOT"] . "/webbantruyen/model/connectDB.php";
    if (file_exists($file_path)) {
        require_once $file_path;
    } else {
        die("Lỗi: Không tìm thấy file connectDB.php!");
    }

    class categoryDB {
        private static $conn;

        // Lấy toàn bộ chủng loại
        public static function getAllCategory() {
            $conn = connectDB::getConnection();
            $strSQL = 'SELECT * FROM category';
            $result = mysqli_query($conn, $strSQL);

            $categoryList = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $categoryList[] = $row;
            }

            connectDB::closeConnection($conn);
            return $categoryList;
        }

        // Thêm chủng loại mới
        public function addCategory($id, $name) {
            $conn = connectDB::getConnection();
            $strSQL = "INSERT INTO category (CategoryID, CategoryName) VALUES (?, ?)";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("ss", $id, $name);

            $success = $stmt->execute();

            $stmt->close();
            connectDB::closeConnection($conn);
            return $success;
        }

        // Cập nhật chủng loại
        public function updateCategory($id, $name) {
            $conn = connectDB::getConnection();
            $strSQL = "UPDATE category SET CategoryName = ? WHERE CategoryID = ?";
            $stmt = $conn->prepare($strSQL);

            if (!$stmt) {
                die("Lỗi chuẩn bị SQL: " . $conn->error);
            }

            $stmt->bind_param("ss", $name, $id);
            $success = $stmt->execute();

            $stmt->close();
            connectDB::closeConnection($conn);
            return $success;
        }

        // Lấy chủng loại của 1 sản phẩm
        public static function getCategoriesOfProduct($productID) {
            $conn = connectDB::getConnection();

            $strSQL = "SELECT category.* 
                       FROM product 
                       JOIN category ON product.CategoryID = category.CategoryID 
                       WHERE product.ProductID = ?";

            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("s", $productID);
            $stmt->execute();
            $result = $stmt->get_result();

            $categoryList = [];
            while ($row = $result->fetch_assoc()) {
                $categoryList[] = $row;
            }

            connectDB::closeConnection($conn);
            return $categoryList;
        }

        // Lấy chủng loại theo ID
        public static function getCategoryByID($id) {
            $conn = connectDB::getConnection();

            $strSQL = "SELECT * FROM category WHERE CategoryID = ?";
            $stmt = $conn->prepare($strSQL);

            if (!$stmt) {
                die("Lỗi chuẩn bị SQL: " . $conn->error);
            }

            $stmt->bind_param("s", $id);
            $stmt->execute();

            $result = $stmt->get_result();
            $category = null;

            if ($result->num_rows > 0) {
                $category = $result->fetch_assoc();
            }

            $stmt->close();
            connectDB::closeConnection($conn);

            return $category;
        }
    }
?>
