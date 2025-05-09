<?php
    $file_path = $_SERVER["DOCUMENT_ROOT"] . "/webbantruyen/model/connectDB.php";
    if (file_exists($file_path)) {
        require_once $file_path;
    } else {
        die("Lỗi: Không tìm thấy file connectDB.php!");
    }
    class supplierDB{
        // Lấy danh sách tất cả nhà cung cấp
        private static $conn;

        public function __construct() {
            if (self::$conn === null) {
                self::$conn = connectDB::getConnection();
                if (self::$conn === null) {
                    die("Lỗi: Không thể kết nối đến cơ sở dữ liệu trong supplierDB constructor!");
                }
            }
        }

        public function __destruct() {
            if (self::$conn !== null) {
                connectDB::closeConnection(self::$conn);
                self::$conn = null;
            }
        }
        public static function getAllSupplier(){
            //Mở database
            $conn = connectDB::getConnection();
            //Lệnh sql
            $strSQL = "Select * from supplier WHERE  IsDeleted =  0";
            //Thực hiện sql
            $result = mysqli_query($conn, $strSQL);
            //Thực hiện chức năng
            $supplierList = [];
            while($row = mysqli_fetch_assoc($result))
                $supplierList[] = $row;
            //Đóng kết nối
            connectDB::closeConnection($conn);
            return $supplierList;
        }

        // Lấy thông tin nhà cung cấp theo mã nhà cung cấp
        public static function getSupplierByID($supplierID) {
            // Mở database
            $conn = connectDB::getConnection();
            // Lệnh SQL đúng
            $strSQL = "SELECT * FROM supplier WHERE SupplierID = ?";
        
            // Thực hiện SQL
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("s", $supplierID);
            $stmt->execute();
            $result = $stmt->get_result();
        
            // Lưu thông tin nhà cung cấp
            $supplier = null;
            if ($result->num_rows > 0)
                $supplier = $result->fetch_assoc();
        
            // Đóng kết nối
            connectDB::closeConnection($conn);
        
            return $supplier;
        }

        // Thêm nhà cung cấp mới
        public function addSupplier($id, $name, $phone, $email, $address, $status) {
            //Mở database
            $conn = ConnectDB::getConnection();
            //Lệnh sql
            $strSQL = "INSERT INTO supplier (`SupplierID`, `SupplierName`, `Phone`, `Email`, `Address`, `IsDeleted`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            //Thực hiện sql
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("sssss", $id, $name, $phone, $email, $address, $status);
            //Thực hiện chức năng
            $success = $stmt->execute();

            //Đóng kết nối
            $stmt->close();
            ConnectDB::closeConnection($conn);
            return $success;
        }

        //Sửa nhà cung cấp
        public function updateSupplier($id, $name, $phone, $email, $address, $status) {
            //Mở database
            $conn = ConnectDB::getConnection();
            //Lệnh sql
            $strSQL = "UPDATE supplier SET 
                        SupplierName = ?, 
                        Phone = ?, 
                        Email = ?, 
                        Address = ?, 
                        IsDeleted = ? 
                        WHERE SupplierID = ?";
            //Thực hiện sql
            $stmt = $conn->prepare($strSQL);
            if (!$stmt) 
                die("Lỗi chuẩn bị SQL: " . $conn->error);
            $stmt->bind_param("ssssss", $name, $phone, $email, $address, $status, $id);
            //Thực hiện chức năng
            $success = $stmt->execute();
            //Đóng kết nối
            $stmt->close();
            ConnectDB::closeConnection($conn);
        
            return $success;
        }

        //Sửa nhà cung cấp
        public function removeSupplier($id) {
            //Mở database
            $conn = ConnectDB::getConnection();
            //Lệnh sql
            $strSQL = "UPDATE supplier SET `IsDeleted` = 1 WHERE SupplierID = ?";
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
    }
?>