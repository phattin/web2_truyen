<?php
//printInvoice.php
include_once($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/order_history_utils.php");

$salesID = isset($_GET['salesID']) ? $_GET['salesID'] : '';

if (empty($salesID)) {
    die("Không tìm thấy mã hóa đơn.");
}

$conn = connectToDatabase();

// Kiểm tra kết nối
if (!$conn) {
    die("Lỗi kết nối đến cơ sở dữ liệu");
}

// Get invoice information
$invoice_sql = "
    SELECT si.SalesID, c.FullName, c.Username, c.Address, c.Phone, si.Date, si.PromotionID, si.TotalPrice 
    FROM sales_invoice si
    LEFT JOIN customer c ON si.CustomerID = c.CustomerID
    WHERE si.SalesID = ?
";

$stmt = $conn->prepare($invoice_sql);
if (!$stmt) {
    die("Lỗi chuẩn bị truy vấn hóa đơn: " . $conn->error);
}

$stmt->bind_param("s", $salesID);
$stmt->execute();
$invoice_result = $stmt->get_result();

if ($invoice_result->num_rows == 0) {
    die("Không tìm thấy hóa đơn với mã: " . htmlspecialchars($salesID));
}

$invoice = $invoice_result->fetch_assoc();
$stmt->close();

// Get invoice details
$details_sql = "
    SELECT p.ProductName, p.Author, p.Publisher, sid.Price, sid.Quantity 
    FROM sales_invoice_detail sid
    JOIN product p ON sid.ProductID = p.ProductID
    WHERE sid.SalesID = ?
";

$stmt = $conn->prepare($details_sql);
if (!$stmt) {
    die("Lỗi chuẩn bị truy vấn chi tiết hóa đơn: " . $conn->error);
}

$stmt->bind_param("s", $salesID);
$stmt->execute();
$details_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn <?php echo htmlspecialchars($salesID); ?></title>
    <link rel="stylesheet" href="/webbantruyen/view/layout/css/printInvoice.css">
</head>
<body>
    <div class="invoice-header">
        <h1>HÓA ĐƠN BÁN HÀNG</h1>
        <p>Nhà sách Truyện Online</p>
    </div>
    
    <div class="invoice-info">
        <p><strong>Mã hóa đơn:</strong> <?php echo htmlspecialchars($invoice['SalesID']); ?></p>
        <p><strong>Ngày:</strong> <?php echo htmlspecialchars($invoice['Date']); ?></p>
        <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars($invoice['FullName'] ?? 'N/A'); ?> (<?php echo htmlspecialchars($invoice['Username'] ?? 'N/A'); ?>)</p>
        <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($invoice['Address'] ?? 'N/A'); ?></p>
        <p><strong>Điện thoại:</strong> <?php echo htmlspecialchars($invoice['Phone'] ?? 'N/A'); ?></p>
        <?php if (!empty($invoice['PromotionID'])): ?>
        <p><strong>Mã khuyến mãi:</strong> <?php echo htmlspecialchars($invoice['PromotionID']); ?></p>
        <?php endif; ?>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Tác giả</th>
                <th>Nhà xuất bản</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            $stt = 1;
            if ($details_result && $details_result->num_rows > 0) {
                while ($product = $details_result->fetch_assoc()):
                    $subtotal = $product['Price'] * $product['Quantity'];
                    $total += $subtotal;
            ?>
            <tr>
                <td><?php echo $stt++; ?></td>
                <td><?php echo htmlspecialchars($product['ProductName']); ?></td>
                <td><?php echo htmlspecialchars($product['Author']); ?></td>
                <td><?php echo htmlspecialchars($product['Publisher']); ?></td>
                <td><?php echo htmlspecialchars($product['Quantity']); ?></td>
                <td><?php echo number_format($product['Price'], 0, ',', '.'); ?>đ</td>
                <td><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</td>
            </tr>
            <?php 
                endwhile;
            } else {
                echo "<tr><td colspan='7'>Không có sản phẩm nào trong hóa đơn này.</td></tr>";
                if ($stmt->error) {
                    echo "<tr><td colspan='7' class='error'>Lỗi truy vấn: " . $stmt->error . "</td></tr>";
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="6" style="text-align: right;">Tổng cộng:</td>
                <td><?php echo number_format($invoice['TotalPrice'], 0, ',', '.'); ?>đ</td>
            </tr>
        </tfoot>
    </table>
    
    <div class="footer">
        <p>Cảm ơn quý khách đã mua hàng</p>
    </div>
    
    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button class="print-btn" onclick="window.print()">In hóa đơn</button>
        <button class="print-btn" onclick="window.close()">Đóng</button>
    </div>
    
    <script>
        // Auto print when page loads
        window.onload = function() {
            // Uncomment the line below if you want the print dialog to appear automatically
            // window.print();
        };
    </script>
</body>
</html>

<?php 
$stmt->close();
$conn->close(); 
?>