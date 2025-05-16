<?php
session_start();
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

        // Lay du lieu tu POST va Luu cac du lieu vao data
        $data = [
            'salesID' => $_POST['salesID'],
            'productsCheckout' => json_decode($_POST['productsCheckout'], true),
            'totalPrice' => changePrice($_POST['totalPrice']),
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
            'note' => $_POST['note'],
            'paymentMethod' => $_POST['paymentMethod'],
            'date' => $_POST['date'],
            'promotionID' => $_POST['promotionID'],
            'customerID' => $_POST['customerID']
        ];
        // Kết nối đến cơ sở dữ liệu
        if (salesInvoiceDB::addSalesInvoice($data['salesID'], $data['customerID'], $data['phone'], $data['address'], $data['date'], $data['promotionID'], $data['totalPrice'], $data['paymentMethod'], $data['note'], 'Chưa xác nhận')) {
            // Nếu thêm hóa đơn thành công, thêm chi tiết hóa đơn
            foreach ($data['productsCheckout'] as $product) {
                $data['productID'] = $product['id'];
                $data['quantity'] = $product['quantity'];
                $data['price'] = changePrice($product['price']);
                $data['totalPrice'] = changePrice($product['totalPrice']);
                if(!salesInvoiceDetailDB::addSalesInvoiceDetail($data['salesID'], $data['productID'], $data['quantity'], $data['price'], $data['totalPrice'])){
                    // Nếu thêm chi tiết hóa đơn thất bại, in ra thông báo lỗi
                    echo json_encode(["success" => False, "message" => 'Lỗi: Không thể thêm chi tiết hóa đơn với ID sản phẩm: '.$data["productID"]]);
                    exit;
                }
            }
            $_SESSION['last_salesID'] = $data['salesID'];
            $_SESSION['cart'] = [];
            echo json_encode(["success" => True, "message" => "Thêm hóa đơn thành công!", 'data' => $data]);
        }
        else {
            // Nếu thêm hóa đơn thất bại, in ra thông báo lỗi
            echo json_encode(["success" => False, "message" => "Lỗi: Không thể thêm hóa đơn với ID: ".$data['salesID']]);
            exit;
        }
    } else{
        // Nếu thiếu dữ liệu, in ra thông báo
        echo json_encode(["success" => False, "message" => "Lỗi: Thiếu dữ liệu trong yêu cầu POST."]);
    }
} else {
    echo json_encode(["success" => False, "message" => "Lỗi: Yêu cầu không phải là POST."]);
}

function changePrice($price) {
    // Chuyển đổi giá thành định dạng tiền tệ
    return (int)preg_replace('/[^0-9]/', '', $price);
}
?>