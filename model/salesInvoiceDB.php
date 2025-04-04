<?php
    $file_path = $_SERVER["DOCUMENT_ROOT"] . "/webbantruyen/model/connectDB.php";
    if (file_exists($file_path)) {
        require_once $file_path;
    } else {
        die("Lỗi: Không tìm thấy file connectDB.php!");
    }
    class salesInvoiceDB{
    
        public static function getAllSalesInvoice(){
            //Mở database
            $conn = connectDB::getConnection();
            //Lệnh sql
            $strSQL = "Select * from sales_invoice WHERE Status = 'Hiện'";
            //Thực hiện sql
            $result = mysqli_query($conn, $strSQL);
            //Thực hiện chức năng
            $salesInvoiceList = [];
            while($row = mysqli_fetch_assoc($result))
                $salesInvoiceList[] = $row;
            //Đóng kết nối
            connectDB::closeConnection($conn);
            return $salesInvoiceList;
        }

        // Thêm hóa đơn
        public static function addSalesInvoice($salesID, $customerID, $phone, $address, $date, $promotionID, $totalPrice, $paymentMethod, $note, $status) {
            //Mở database
            $conn = ConnectDB::getConnection();
            //Lệnh sql
            $strSQL = "INSERT INTO salesInvoice (`SalesID`, `CustomerID`, `Phone`, `Address`, `Date`, `PromotionID`, `TotalPrice`, `PaymentMethod`, `Note`, `Status`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            //Thực hiện sql
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("sssssiiiisi",$salesID, $customerID, $phone, $address, $date, $promotionID, $totalPrice, $paymentMethod, $note, $status);
            //Thực hiện chức năng
            $success = $stmt->execute();

            //Đóng kết nối
            $stmt->close();
            ConnectDB::closeConnection($conn);
            return $success;
        }

        //Cập nhật trạng thái hóa đơn
        public static function updateSalesInvoiceStatus($id, $status) {
            //Mở database
            $conn = ConnectDB::getConnection();
            //Lệnh sql
            $strSQL = "UPDATE sales_invoice SET `Status` = ? 
                       WHERE SalesID = ?";
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

        // Lấy mã hóa đơn +1
        public static function getIncreaseSalesInvoiceID() {
            //Mở database
            $conn = ConnectDB::getConnection();
            // Truy vấn để lấy mã hóa đơn cuối cùng
            $query = "SELECT SalesID FROM sales_invoice ORDER BY SalesID DESC LIMIT 1";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                // Lấy mã hóa đơn cuối cùng
                $row = $result->fetch_assoc();
                $lastInvoiceCode = $row['SalesID']; // Ví dụ: "SI001"
                
                // Tách phần số từ mã hóa đơn (loại bỏ "SI" và chuyển sang kiểu số)
                $lastNumber = (int)substr($lastInvoiceCode, 2);
                
                // Tăng số lên 1
                $newNumber = $lastNumber + 1;
                
                // Định dạng lại mã hóa đơn mới (giữ "SI" và đảm bảo số có 3 chữ số)
                $newInvoiceCode = "SI" . str_pad($newNumber, 3, "0", STR_PAD_LEFT);

                
            } else {
                $newInvoiceCode = "SI001"; // Nếu không có hóa đơn nào, bắt đầu từ SI001
            }
            //Đóng kết nối
            ConnectDB::closeConnection($conn);
            return $newInvoiceCode;
        }
    }
?>