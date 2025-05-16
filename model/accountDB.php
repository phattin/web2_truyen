<?php
$file_path = $_SERVER["DOCUMENT_ROOT"] . "/webbantruyen/model/connectDB.php";
if (file_exists($file_path)) {
    require_once $file_path;
} else {
    die("Lỗi: Không tìm thấy file connectDB.php!");
}

class accountDB {
    private static $conn;

    public function __construct() {
        if (self::$conn === null) {
            self::$conn = connectDB::getConnection();
            if (self::$conn === null) {
                die("Lỗi: Không thể kết nối đến cơ sở dữ liệu trong accountDB constructor!");
            }
        }
    }

    public function __destruct() {
        if (self::$conn !== null) {
            connectDB::closeConnection(self::$conn);
            self::$conn = null;
        }
    }

    // Lấy toàn bộ tài khoản
    public static function getAllAccount() {
        $conn = connectDB::getConnection();
        $strSQL = "SELECT * FROM account";
        $result = mysqli_query($conn, $strSQL);
        $accountList = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $accountList[] = $row;
        }
        connectDB::closeConnection($conn);
        return $accountList;
    }

    // Lấy tài khoản theo username
    public static function getAccountByUsername($username) {
        $conn = connectDB::getConnection();
        $strSQL = "SELECT * FROM account WHERE Username = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $account = null;
        if ($result->num_rows > 0) {
            $account = $result->fetch_assoc();
        }
        connectDB::closeConnection($conn);
        return $account;
    }

    public static function getAccountByEmployeeID($employeeID) {
        $conn = connectDB::getConnection();
        $strSQL = "SELECT * FROM account WHERE EmployeeID = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $employeeID);
        $stmt->execute();
        $result = $stmt->get_result();
        $account = null;
        if ($result->num_rows > 0) {
            $account = $result->fetch_assoc();
        }
        connectDB::closeConnection($conn);
        return $account;
    }

    // Thêm tài khoản mới
    public function addAccount($username, $password, $employeeID, $roleID) {
        $conn = connectDB::getConnection();
        $strSQL = "INSERT INTO account (Username, Password, EmployeeID, RoleID) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($strSQL);
        if (!$stmt) die("Lỗi prepare: " . $conn->error);
        $stmt->bind_param("ssss", $username, $password, $employeeID, $roleID);
        $success = $stmt->execute();
        $stmt->close();
        connectDB::closeConnection($conn);
        return $success;
    }

    // Cập nhật tài khoản
    public function updateAccount($username, $password, $employeeID, $roleID) {
        $conn = connectDB::getConnection();
        $strSQL = "UPDATE account SET Password = ?, EmployeeID = ?, RoleID = ? WHERE Username = ?";
        $stmt = $conn->prepare($strSQL);
        if (!$stmt) die("Lỗi prepare: " . $conn->error);
        $stmt->bind_param("ssss", $password, $employeeID, $roleID, $username);
        $success = $stmt->execute();
        $stmt->close();
        connectDB::closeConnection($conn);
        return $success;
    }
    public function updateAccountWithoutPassword($username, $employeeID, $roleID) {
        $conn = connectDB::getConnection();
        $strSQL = "UPDATE account SET EmployeeID = ?, RoleID = ? WHERE Username = ?";
        $stmt = $conn->prepare($strSQL);
        if (!$stmt) die("Lỗi prepare: " . $conn->error);
        $stmt->bind_param("sss", $employeeID, $roleID, $username);
        $success = $stmt->execute();
        $stmt->close();
        connectDB::closeConnection($conn);
        return $success;
    }

    

    // Xóa tài khoản
    public function removeAccount($username) {
        $conn = connectDB::getConnection();
        $strSQL = "DELETE FROM account WHERE Username = ?";
        $stmt = $conn->prepare($strSQL);
        if (!$stmt) die("Lỗi prepare: " . $conn->error);
        $stmt->bind_param("s", $username);
        $success = $stmt->execute();
        $stmt->close();
        connectDB::closeConnection($conn);
        return $success;
    }
}
?>