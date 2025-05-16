<?php
$file_path = $_SERVER["DOCUMENT_ROOT"] . "/webbantruyen/model/connectDB.php";
if (file_exists($file_path)) {
    require_once $file_path;
} else {
    die("Lỗi: Không tìm thấy file connectDB.php!");
}

class roleDB {
    private static $conn;

    public function __construct() {
        if (self::$conn === null) {
            self::$conn = connectDB::getConnection();
            if (self::$conn === null) {
                die("Lỗi: Không thể kết nối đến cơ sở dữ liệu trong roleDB constructor!");
            }
        }
    }

    public function __destruct() {
        if (self::$conn !== null) {
            connectDB::closeConnection(self::$conn);
            self::$conn = null;
        }
    }

    // Lấy tất cả khuyến mãi
    public static function getAllRole() {
        $conn = connectDB::getConnection();
        $sql = "SELECT * FROM role";
        $result = mysqli_query($conn, $sql);

        $roleList = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $roleList[] = $row;
        }

        connectDB::closeConnection($conn);
        return $roleList;
    }

    //Kiểm tra có quyền nào đã sử dụng trong tài khoản chưa
    public static function checkRoleUsed($roleID) {
        $conn = connectDB::getConnection();
        $sql = "SELECT * FROM account WHERE RoleID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $roleID);
        $stmt->execute();
        $result = $stmt->get_result();
        $isUsed = false;
        if ($result->num_rows > 0) {
            $isUsed = true;
        }
        connectDB::closeConnection($conn);
        return $isUsed;
    }
    public static function getRoleByID($roleID) {
        $conn = connectDB::getConnection();
        $strSQL = "SELECT * FROM role WHERE RoleID = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $roleID);
        $stmt->execute();
        $result = $stmt->get_result();
        $role = null;
        if ($result->num_rows > 0) {
            $role = $result->fetch_assoc();
        }
        connectDB::closeConnection($conn);
        return $role;
    }

    public static function getRoleIDByUsername($username) {
        $conn = connectDB::getConnection();
        $strSQL = "SELECT RoleID FROM account WHERE Username = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $roleID = null;
        if ($result->num_rows > 0) {
            $roleID = $result->fetch_assoc()['RoleID'];
        }
        connectDB::closeConnection($conn);
        return $roleID;
    }

    public static function removeRole($roleID) {
        $conn = connectDB::getConnection();
        $sql = "Delete from role WHERE RoleID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $roleID);
        $success = $stmt->execute();

        connectDB::closeConnection($conn);
        return $success;
    }

    public static function getAllFunctionDetailByRoleID($roleID) {
    $conn = connectDB::getConnection();
    $sql = "SELECT * FROM function_detail WHERE RoleID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $roleID);
    $stmt->execute();
    $result = $stmt->get_result();

    $roleDetailList = [];
    while ($row = $result->fetch_assoc()) {
        $roleDetailList[] = $row;
    }

    connectDB::closeConnection($conn);
    return $roleDetailList;
}
}
?>
