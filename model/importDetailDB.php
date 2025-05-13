<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/webbantruyen/model/connectDB.php";

class importDetailDB {
    private static $conn;

    public function __construct() {
        if (self::$conn === null) {
            self::$conn = connectDB::getConnection();
            if (self::$conn === null) {
                die("Lỗi: Không thể kết nối đến CSDL trong importDetailDB!");
            }
        }
    }

    public function __destruct() {
        if (self::$conn !== null) {
            connectDB::closeConnection(self::$conn);
            self::$conn = null;
        }
    }

    public static function getAllImportDetail() {
        $conn = connectDB::getConnection();
        $sql = "SELECT * FROM import_invoice_detail";
        $result = mysqli_query($conn, $sql);

        $detailList = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $detailList[] = $row;
        }

        connectDB::closeConnection($conn);
        return $detailList;
    }

    public static function getImportDetailByImportID($importID) {
        $conn = connectDB::getConnection();
        $sql = "SELECT * FROM import_invoice_detail WHERE ImportID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $importID);
        $stmt->execute();

        $result = $stmt->get_result();
        $detailList = [];
        while ($row = $result->fetch_assoc()) {
            $detailList[] = $row;
        }

        $stmt->close();
        connectDB::closeConnection($conn);
        return $detailList;
    }

    public function addImportDetail($importID, $productID, $quantity, $price, $totalPrice) {
        $conn = connectDB::getConnection();
        $sql = "INSERT INTO import_invoice_detail (ImportID, ProductID, Quantity, Price, TotalPrice) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiid", $importID, $productID, $quantity, $price, $totalPrice);
        $success = $stmt->execute();

        $stmt->close();
        connectDB::closeConnection($conn);
        return $success;
    }
}
?>
