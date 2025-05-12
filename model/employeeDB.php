<?php
$file_path = $_SERVER["DOCUMENT_ROOT"] . "/webbantruyen/model/connectDB.php";
if (file_exists($file_path)) {
    require_once $file_path;
} else {
    die("Lỗi: Không tìm thấy file connectDB.php!");
}

class employeeDB {
    private static $conn;

    public function __construct() {
        if (self::$conn === null) {
            self::$conn = connectDB::getConnection();
            if (self::$conn === null) {
                die("Lỗi: Không thể kết nối đến cơ sở dữ liệu trong employeeDB constructor!");
            }
        }
    }

    public function __destruct() {
        if (self::$conn !== null) {
            connectDB::closeConnection(self::$conn);
            self::$conn = null;
        }
    }

    // Lấy danh sách tất cả nhân viên
    public static function getAllEmployee() {
        $conn = connectDB::getConnection();
        $strSQL = "SELECT * FROM employee WHERE IsDeleted = 0";
        $result = mysqli_query($conn, $strSQL);
        $employeeList = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $employeeList[] = $row;
        }
        connectDB::closeConnection($conn);
        return $employeeList;
    }

    // Lấy nhân viên theo ID
    public static function getEmployeeByID($employeeID) {
        $conn = connectDB::getConnection();
        $strSQL = "SELECT * FROM employee WHERE EmployeeID = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $employeeID);
        $stmt->execute();
        $result = $stmt->get_result();
        $employee = null;
        if ($result->num_rows > 0) {
            $employee = $result->fetch_assoc();
        }
        connectDB::closeConnection($conn);
        return $employee;
    }

    // Thêm nhân viên mới
    public function addEmployee($id, $name, $username, $birthday, $phone, $email, $address, $gender, $salary, $startDate, $status) {
        $conn = connectDB::getConnection();
        $strSQL = "INSERT INTO employee 
        (EmployeeID, Fullname, Username, BirthDay, Phone, Email, Address, Gender, Salary, StartDate, IsDeleted) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("ssssssssdis", $id, $name, $username, $birthday, $phone, $email, $address, $gender, $salary, $startDate, $status);
        $success = $stmt->execute();
        $stmt->close();
        connectDB::closeConnection($conn);
        return $success;
    }

    // Cập nhật thông tin nhân viên
    public function updateEmployee($id, $name, $username, $birthday, $phone, $email, $address, $gender, $salary, $startDate, $status) {
        $conn = connectDB::getConnection();
        $strSQL = "UPDATE employee SET 
            Fullname = ?, 
            Username = ?, 
            BirthDay = ?, 
            Phone = ?, 
            Email = ?, 
            Address = ?, 
            Gender = ?, 
            Salary = ?, 
            StartDate = ?, 
            IsDeleted = ?
            WHERE EmployeeID = ?";
        $stmt = $conn->prepare($strSQL);
        if (!$stmt) die("Lỗi chuẩn bị SQL: " . $conn->error);
        $stmt->bind_param("sssssssdsis", $name, $username, $birthday, $phone, $email, $address, $gender, $salary, $startDate, $status, $id);
        $success = $stmt->execute();
        $stmt->close();
        connectDB::closeConnection($conn);
        return $success;
    }

    // Xóa mềm nhân viên (IsDeleted = 1)
    public function removeEmployee($id) {
        $conn = connectDB::getConnection();
        $strSQL = "UPDATE employee SET IsDeleted = 1 WHERE EmployeeID = ?";
        $stmt = $conn->prepare($strSQL);
        if (!$stmt) die("Lỗi chuẩn bị SQL: " . $conn->error);
        $stmt->bind_param("s", $id);
        $success = $stmt->execute();
        $stmt->close();
        connectDB::closeConnection($conn);
        return $success;
    }
    public static function getEmployeeByUsername($username) {
        $conn = connectDB::getConnection();
        $strSQL = "SELECT * FROM employee WHERE Username = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $employee = null;
        if ($result->num_rows > 0) {
            $employee = $result->fetch_assoc();
        }
        connectDB::closeConnection($conn);
        return $employee;
    }
}
?>
