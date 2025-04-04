<?php
$file_path = $_SERVER["DOCUMENT_ROOT"] . "/webbantruyen/model/salesInvoiceDB.php";
if (file_exists($file_path)) 
    require_once $file_path;
else 
    die("Lỗi: Không tìm thấy file salesInvoiceDB.php!");
$file_path = $_SERVER["DOCUMENT_ROOT"] . "/webbantruyen/model/salesInvoiceDetailDB.php";
if (file_exists($file_path)) 
    require_once $file_path;
else 
    die("Lỗi: Không tìm thấy file salesInvoiceDetailDB.php!");
// Kiểm tra nếu dữ liệu đã được gửi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra xem các biến đã có dữ liệu hay chưa
    if (isset($_POST['salesID']) &&isset($_POST['productsCheckout']) && isset($_POST['totalPrice']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['note']) && isset($_POST['paymentMethod']) && isset($_POST['date']) && isset($_POST['promotionID']) && isset($_POST['customerID'])) {
        // Lấy dữ liệu từ POST
        $salesID = $_POST['salesID'];
        $productsCheckout = json_decode($_POST['productsCheckout'], true);
        $totalPrice = $_POST['totalPrice'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $note = $_POST['note'];
        $paymentMethod = $_POST['paymentMethod'];
        $date = $_POST['date'];
        $promotionID = $_POST['promotionID'];
        $customerID = $_POST['customerID'];
        // Kết nối đến cơ sở dữ liệu
        if (salesInvoiceDB::addSalesInvoice($salesID, $customerID, $phone, $address, $date, $promotionID, $totalPrice, $paymentMethod, $note, 'Chưa xác nhận')) {
            // Nếu thêm hóa đơn thành công, thêm chi tiết hóa đơn
            foreach ($productsCheckout as $product) {
                $productID = $product['id'];
                $quantity = $product['quantity'];
                $price = $product['price'];
                $totalPrice = $product['totalPrice'];
                if(!salesInvoiceDetailDB::addSalesInvoiceDetail($salesID, $productID, $quantity, $price, $totalPrice)){
                    // Nếu thêm chi tiết hóa đơn thất bại, in ra thông báo lỗi
                    echo "Lỗi: Không thể thêm chi tiết hóa đơn cho sản phẩm ID: $productID";
                    exit;
                }
            }
        }

    } else{
        // Nếu thiếu dữ liệu, in ra thông báo
        echo "Dữ liệu không đầy đủ!";
    }
} else {
    echo "Không nhận được yêu cầu POST.";
}
?>