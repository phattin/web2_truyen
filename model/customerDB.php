<?php
    $file_path = $_SERVER["DOCUMENT_ROOT"] . "/webbantruyen/model/connectDB.php";
    if (file_exists($file_path)) {
        require_once $file_path;
    } else {
        die("Lỗi: Không tìm thấy file connectDB.php!");
    }
    class customerDB{
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

        public static function getCustomerByUsername($username) {
            // Mở database
            $conn = connectDB::getConnection();
    
            $strSQL = 'SELECT customer.*, account.* 
                       FROM customer
                       JOIN account ON customer.Username = account.Username
                       WHERE customer.Username = ?';
        
            // Chuẩn bị câu lệnh SQL
            if ($stmt = mysqli_prepare($conn, $strSQL)) {
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
        
                // Kiểm tra kết quả có hợp lệ không
                if ($result) 
                    $customer = mysqli_fetch_assoc($result);
                else 
                    $customer = null; // Nếu lỗi hoặc không có dữ liệu
        
                // Đóng statement
                mysqli_stmt_close($stmt);
            } else 
                $customer = null; // Nếu lỗi khi prepare SQL
        
            // Đóng kết nối
            connectDB::closeConnection($conn);
        
            return $customer;
        }

        public static function getCustomerByID($customerID) {
            // Mở database
            $conn = connectDB::getConnection();
    
            $strSQL = 'SELECT customer.*, account.* 
                       FROM customer
                       JOIN account ON customer.Username = account.Username
                       WHERE customer.CustomerID = ?';
        
            // Chuẩn bị câu lệnh SQL
            if ($stmt = mysqli_prepare($conn, $strSQL)) {
                mysqli_stmt_bind_param($stmt, "s", $customerID);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
        
                // Kiểm tra kết quả có hợp lệ không
                if ($result) 
                    $customer = mysqli_fetch_assoc($result);
                else 
                    $customer = null; // Nếu lỗi hoặc không có dữ liệu
        
                // Đóng statement
                mysqli_stmt_close($stmt);
            } else 
                $customer = null; // Nếu lỗi khi prepare SQL
        
            // Đóng kết nối
            connectDB::closeConnection($conn);
        
            return $customer;
        }
        
    }
?>