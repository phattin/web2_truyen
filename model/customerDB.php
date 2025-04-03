<?php
    $file_path = $_SERVER["DOCUMENT_ROOT"] . "/webbantruyen/model/customerDB.php";
    if (file_exists($file_path)) {
        require $file_path;
    } else {
        die("Lỗi: Không tìm thấy file customerDB.php!");
    }
    class customerDB{
        private static $conn;
        public static function getAllCustomer(){
            //Mở database
            $conn = connectDB::getConnection();
            //Lệnh sql
            $strSQL = 'Select * from customer';
            //Thực hiện sql
            $result = mysqli_query($conn, $strSQL);
            //Thực hiện chức năng
            $customerList = [];
            while($row = mysqli_fetch_assoc($result))
                $customerList[] = $row;
            //Đóng kết nối
            connectDB::closeConnection($conn);
            return $customerList;
        }
    }

?>