<?php
$file_path = $_SERVER["DOCUMENT_ROOT"] . "/webbantruyen/model/connectDB.php";
if (file_exists($file_path)) {
    require_once $file_path;
} else {
    die("Lỗi: Không tìm thấy file connectDB.php!");
}

class supplierDB {
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

    // Lấy tất cả nhà cung cấp
    public static function getAllSupplier() {
        $conn = connectDB::getConnection();
        $sql = "SELECT * FROM supplier WHERE IsDeleted = 0";
        $result = mysqli_query($conn, $sql);

        $supplierList = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $supplierList[] = $row;
        }

        connectDB::closeConnection($conn);
        return $supplierList;
    }

    // Lấy nhà cung cấp theo ID
    public static function getSupplierByID($supplierID) {
        $conn = connectDB::getConnection();
        $sql = "SELECT * FROM supplier WHERE SupplierID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $supplierID);
        $stmt->execute();
        $result = $stmt->get_result();

        $supplier = null;
        if ($result->num_rows > 0) {
            $supplier = $result->fetch_assoc();
        }

        $stmt->close();
        connectDB::closeConnection($conn);
        return $supplier;
    }

    // Tạo mã nhà cung cấp mới
    public static function getNewSupplierID() {
        $conn = connectDB::getConnection();
        $sql = "SELECT MAX(SupplierID) AS maxID FROM supplier";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $maxID = $row['maxID'];
        connectDB::closeConnection($conn);

        if (!$maxID) {
            return 'S001';
        }

        $num = (int)substr($maxID, 2);
        $num++;
        return 'S' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }

    // Thêm nhà cung cấp
    public function addSupplier($id, $name, $phone, $email, $address, $isDeleted) {
        $conn = connectDB::getConnection();
        $sql = "INSERT INTO supplier (SupplierID, SupplierName, Phone, Email, Address, IsDeleted) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $id, $name, $phone, $email, $address, $isDeleted);
        $success = $stmt->execute();
        $stmt->close();
        connectDB::closeConnection($conn);
        return $success;
    }

    // Sửa nhà cung cấp
    public function updateSupplier($id, $name, $phone, $email, $address, $isDeleted) {
        $conn = connectDB::getConnection();
        $sql = "UPDATE supplier SET SupplierName = ?, Phone = ?, Email = ?, Address = ?, IsDeleted = ? WHERE SupplierID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssis", $name, $phone, $email, $address, $isDeleted, $id);
        $success = $stmt->execute();
        $stmt->close();
        connectDB::closeConnection($conn);
        return $success;
    }

    // Xóa (mềm) nhà cung cấp
    public function removeSupplier($id) {
        $conn = connectDB::getConnection();
        $sql = "UPDATE supplier SET IsDeleted = 1 WHERE SupplierID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $success = $stmt->execute();
        $stmt->close();
        connectDB::closeConnection($conn);
        return $success;
    }
}
?>
