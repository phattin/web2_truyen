<?php
$file_path = $_SERVER["DOCUMENT_ROOT"] . "/webbantruyen/model/connectDB.php";
if (file_exists($file_path)) {
    require_once $file_path;
} else {
    die("Lỗi: Không tìm thấy file connectDB.php!");
}

class promotionDB {
    private static $conn;

    public function __construct() {
        if (self::$conn === null) {
            self::$conn = connectDB::getConnection();
            if (self::$conn === null) {
                die("Lỗi: Không thể kết nối đến cơ sở dữ liệu trong promotionDB constructor!");
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
    public static function getAllPromotion() {
        $conn = connectDB::getConnection();
        $sql = "SELECT * FROM promotion WHERE IsDeleted = 0";
        $result = mysqli_query($conn, $sql);

        $promotionList = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $promotionList[] = $row;
        }

        connectDB::closeConnection($conn);
        return $promotionList;
    }

    // Lấy khuyến mãi theo ID
    public static function getPromotionByID($promotionID) {
        $conn = connectDB::getConnection();
        $sql = "SELECT * FROM promotion WHERE PromotionID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $promotionID);
        $stmt->execute();
        $result = $stmt->get_result();

        $promotion = null;
        if ($result->num_rows > 0) {
            $promotion = $result->fetch_assoc();
        }

        $stmt->close();
        connectDB::closeConnection($conn);
        return $promotion;
    }

    // Tạo mã khuyến mãi mới
    public static function getNewPromotionID() {
        $conn = connectDB::getConnection();
        $sql = "SELECT MAX(PromotionID) AS maxID FROM promotion";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $maxID = $row['maxID'];
        connectDB::closeConnection($conn);

        if (!$maxID) {
            return 'PR001';
        }

        $num = (int)substr($maxID, 2); // Bỏ 'KM'
        $num++;
        return 'PR' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }

    // Thêm khuyến mãi
    public function addPromotion($id, $name, $discount, $startDate, $endDate, $isDeleted) {
        $conn = connectDB::getConnection();
        $sql = "INSERT INTO promotion (PromotionID, PromotionName, Discount, StartDate, EndDate, IsDeleted) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdssi", $id, $name, $discount, $startDate, $endDate, $isDeleted);
        $success = $stmt->execute();
        $stmt->close();
        connectDB::closeConnection($conn);
        return $success;
    }

    // Sửa khuyến mãi
    public function updatePromotion($id, $name, $discount, $startDate, $endDate, $isDeleted) {
        $conn = connectDB::getConnection();
        $sql = "UPDATE promotion SET PromotionName = ?, Discount = ?, StartDate = ?, EndDate = ?, IsDeleted = ? WHERE PromotionID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdssis", $name, $discount, $startDate, $endDate, $isDeleted, $id);
        $success = $stmt->execute();
        $stmt->close();
        connectDB::closeConnection($conn);
        return $success;
    }

    // Xóa (mềm) khuyến mãi
    public function removePromotion($id) {
        $conn = connectDB::getConnection();
        $sql = "UPDATE promotion SET IsDeleted = 1 WHERE PromotionID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $success = $stmt->execute();
        $stmt->close();
        connectDB::closeConnection($conn);
        return $success;
    }
}
?>
