<?php
    $file_path = $_SERVER["DOCUMENT_ROOT"] . "/webbantruyen/model/connectDB.php";
    if (file_exists($file_path)) {
        require_once $file_path;
    } else {
        die("Lỗi: Không tìm thấy file connectDB.php!");
    }

    class importDB {
        private static $conn;

        public function __construct() {
            if (self::$conn === null) {
                self::$conn = connectDB::getConnection();
                if (self::$conn === null) {
                    die("Lỗi: Không thể kết nối đến cơ sở dữ liệu trong importDB constructor!");
                }
            }
        }

        public function __destruct() {
            if (self::$conn !== null) {
                connectDB::closeConnection(self::$conn);
                self::$conn = null;
            }
        }

        // Lấy tất cả phiếu nhập
        public static function getAllImports() {
            $conn = connectDB::getConnection();
            $sql = "SELECT * FROM import_invoice";
            $result = mysqli_query($conn, $sql);
            $importList = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $importList[] = $row;
            }
            connectDB::closeConnection($conn);
            return $importList;
        }

        // Lấy phiếu nhập theo ID
        public static function getImportByID($id) {
            $conn = connectDB::getConnection();
            $sql = "SELECT * FROM import_invoice WHERE ImportID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $import = null;
            if ($result->num_rows > 0) {
                $import = $result->fetch_assoc();
            }
            $stmt->close();
            connectDB::closeConnection($conn);
            return $import;
        }

        // Thêm phiếu nhập mới
        public function addImport($importID, $employeeID, $supplierID, $date, $totalPrice) {
            $conn = connectDB::getConnection();
            $sql = "INSERT INTO import_invoice (ImportID, EmployeeID, SupplierID, Date, TotalPrice) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssd", $importID, $employeeID, $supplierID, $date, $totalPrice);
            $success = $stmt->execute();
            $stmt->close();
            connectDB::closeConnection($conn);
            return $success;
        }
    }
?>
