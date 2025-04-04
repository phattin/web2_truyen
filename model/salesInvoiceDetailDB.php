<?php
    $file_path = $_SERVER["DOCUMENT_ROOT"] . "/webbantruyen/model/connectDB.php";
    if (file_exists($file_path)) {
        require_once $file_path;
    } else {
        die("Lỗi: Không tìm thấy file connectDB.php!");
    }
    class salesInvoiceDetailDB{
    
        public static function getAllSalesInvoice(){
            //Mở database
            $conn = connectDB::getConnection();
            //Lệnh sql
            $strSQL = "Select * from sales_invoice_detail WHERE Status = 'Hiện'";
            //Thực hiện sql
            $result = mysqli_query($conn, $strSQL);
            //Thực hiện chức năng
            $salesInvoiceDetailList = [];
            while($row = mysqli_fetch_assoc($result))
                $salesInvoiceDetailList[] = $row;
            //Đóng kết nối
            connectDB::closeConnection($conn);
            return $salesInvoiceDetailList;
        }


        // Thêm chi tiết hóa đơn
        public static function addSalesInvoiceDetail($salesID, $productID, $quantity, $price, $totalPrice) {
            //Mở database
            $conn = ConnectDB::getConnection();
            //Lệnh sql
            $strSQL = "INSERT INTO sales_invoice_detail (`SalesID`, `ProductID`, `Quantity`, `Price`, `TotalPrice`) 
                        VALUES (?, ?, ?, ?, ?)";
            //Thực hiện sql
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("ssiis",$salesID, $productID, $quantity, $price, $totalPrice);
            //Thực hiện chức năng
            $success = $stmt->execute();

            //Đóng kết nối
            $stmt->close();
            ConnectDB::closeConnection($conn);
            return $success;
        }

    }
?>