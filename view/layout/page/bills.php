<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/webbantruyen/model/salesInvoiceDB.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/webbantruyen/model/salesInvoiceDetailDB.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/webbantruyen/model/customerDB.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/webbantruyen/model/productDB.php';

    // Kiểm tra nếu có salesID trong session
    if (!isset($_SESSION['last_salesID'])) {
        echo "Không tìm thấy hóa đơn!";
        exit;
    }

    $salesID = $_SESSION['last_salesID'];
    // unset($_SESSION['last_salesID']); // Xóa để tránh load lại

    // Lấy thông tin hóa đơn
    $sales = salesInvoiceDB::getSalesInvoiceByID($salesID); // bạn cần viết hàm này
    $customer = customerDB::getCustomerByID($sales['CustomerID']); // và hàm này
    $details = salesInvoiceDetailDB::getSalesInvoiceDetailBySalesID($salesID); // chi tiết sản phẩm
    echo "<script>console.log(".json_encode($details).")</script>";
?>

<style>
@media print {
    @page {
        margin: 0;
        size: auto;
    }

    body {
        margin: 0;
    }

    /* Ẩn header/footer của trình duyệt nếu có thể */
    html, body {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
}
</style>

<link rel="stylesheet" href="/webbantruyen/view/layout/css/bills.css">
<div class="bills-page">
    <div class="bills-box">
        <i class="fa-solid fa-rectangle-xmark close"></i>
        <form class="bill-form">
            <table class="bills-table">
                <thead>
                    <tr class="bills-header">
                        <th colspan="4" class="bills-title" style="text-align: center; font-size: 20px;">HÓA ĐƠN</th>
                    <tr style="border-bottom: 1px solid #ddd">
                        <th colspan="4" style="text-align: right;">
                            <strong>Ngày đặt:
                                <span class="bills-date"><?= $sales['Date'] ?></span></strong>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4" class="bills-heading" style="text-align:center">Thông tin khách hàng</th>
                    </tr>
                    <tr>
                        <th colspan="2" class="bills-customer-info">Tên khách hàng:</th>
                        <td colspan="2" class="bills-customer-name"><?= $customer['Fullname'] ?></td>
                    </tr>
                    <tr>
                        <th colspan="2" class="bills-customer-info">Số điện thoại:</th>
                        <td colspan="2" class="bills-customer-phone"><?= $sales['Phone'] ?></td>
                    </tr>
                    <tr>
                        <th colspan="2" class="bills-customer-info">Địa chỉ:</th>
                        <td colspan="2" class="bills-customer-address"><?= $sales['Address'] ?></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #ddd">
                        <th colspan="2" class="bills-customer-payment">Thanh toán:</th>
                        <td colspan="2" class="bills-customer-payment"><?= $sales['PaymentMethod'] ?></td>
                    </tr>
                    <tr class="order-header">
                        <th colspan="4" style="text-align: center;"><strong>SẢN PHẨM</strong></th>
                    </tr>
                    <tr style="border-bottom: 1px solid #ddd">
                        <th class="bills-product-name" style="width: 25%;">Tên sản phẩm</th>
                        <th class="bills-quantity" style="width: 16%;">Số lượng</th>
                        <th class="bills-price" style="width: 30%;">Đơn giá</th>
                        <th class="bills-totalPrice" style="width: 30%;">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($details as $item): ?>
                    <?php 
                        $productDetail = productDB::getProductByID($item['ProductID']); 
                    ?>
                    <tr class="bills-product-item">
                        <td class="bills-product-name"><?= $productDetail['ProductName'] ?></td>
                        <td class="bills-quantity"><?= $item['Quantity'] ?></td>
                        <td class="bills-price"><?= number_format($item['Price'], 0, ',', '.') ?> VND</td>
                        <td class="bills-totalPrice"><?= number_format($item['TotalPrice'], 0, ',', '.') ?> VND</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr style="border-top: 1px solid #ddd">
                        <td colspan="3">Tổng tạm tính:</td>
                        <td>
                            <span class="bills-total-product-price-value"><?= number_format($sales['TotalPrice'], 0, ',', '.') ?> VND</span>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid #ddd">
                        <td colspan="3">Khuyến mãi:</td>
                        <td id="idKhuyenMai" style="display: none;"><?= $sales['PromotionID'] ?></td>
                        <td id="tenKhuyenMai"><?= $sales['PromotionID'] ?></td>
                    </tr>
                    <tr>
                        <td colspan="3"><strong>Tổng đơn:</strong></td>
                        <td>
                            <span class="bills-total-price-value"><strong><?= number_format($sales['TotalPrice'], 0, ',', '.') ?> VND</strong></span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>
    <div class="bills-button-group">
        <button class="btn btn-print-bill">In hóa đơn</button>
        <button class="btn btn-close-bill">Quay về trang chủ</button>
    </div>
</div>
<script>
    // Chức năng in hóa đơn
    document.querySelector('.btn-print-bill').addEventListener('click', function() {
        window.print(); // Gọi phương thức in
    });

    // Chức năng quay về trang chủ
    document.querySelector('.btn-close-bill').addEventListener('click', function() {
        window.location.href = '/webbantruyen/'; // Quay về trang chủ
    });
</script>