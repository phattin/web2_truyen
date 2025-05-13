<?php
//getInvoiceDetails.php - Fix for session validation issue
include_once($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/order_history_utils.php");

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get the sales ID from the request
$salesID = isset($_GET['salesID']) ? $_GET['salesID'] : '';

// Check if salesID is provided
if (empty($salesID)) {
    echo "<p class='error'>Mã hóa đơn không hợp lệ.</p>";
    exit;
}

// Connect to database
$conn = connectToDatabase();

// Validate the sales invoice exists and belongs to the appropriate context
// For statistics page (admin view), we don't need to validate username
$sql_validate = "SELECT si.SalesID, si.CustomerID, si.Date, si.TotalPrice, c.FullName, c.Phone, c.Address
                FROM sales_invoice si
                JOIN customer c ON si.CustomerID = c.CustomerID
                WHERE si.SalesID = ?";

$stmt = $conn->prepare($sql_validate);
$stmt->bind_param("s", $salesID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p class='error'>Không tìm thấy hóa đơn.</p>";
    exit;
}

$invoice = $result->fetch_assoc();

// Get invoice details
$sql_details = "SELECT sd.ProductID, p.ProductName, p.Author, sd.Quantity, sd.Price, sd.TotalPrice
               FROM sales_invoice_detail sd
               JOIN product p ON sd.ProductID = p.ProductID
               WHERE sd.SalesID = ?";

$stmt = $conn->prepare($sql_details);
$stmt->bind_param("s", $salesID);
$stmt->execute();
$result_details = $stmt->get_result();

// Generate HTML
?>
<div class="invoice-details">
    <h2>Chi Tiết Hóa Đơn: <?php echo htmlspecialchars($salesID); ?></h2>
    
    <div class="invoice-info">
        <div class="info-row">
            <div class="info-label">Ngày mua:</div>
            <div class="info-value"><?php echo htmlspecialchars($invoice['Date']); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Khách hàng:</div>
            <div class="info-value"><?php echo htmlspecialchars($invoice['FullName']); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Số điện thoại:</div>
            <div class="info-value"><?php echo htmlspecialchars($invoice['Phone']); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Địa chỉ:</div>
            <div class="info-value"><?php echo htmlspecialchars($invoice['Address']); ?></div>
        </div>
    </div>
    
    <h3>Danh sách sản phẩm</h3>
    <table class="product-table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Sản phẩm</th>
                <th>Tác giả</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $stt = 1;
            $grandTotal = 0;
            while ($detail = $result_details->fetch_assoc()) {
                $grandTotal += $detail['TotalPrice'];
            ?>
                <tr>
                    <td><?php echo $stt++; ?></td>
                    <td><?php echo htmlspecialchars($detail['ProductName']); ?></td>
                    <td><?php echo htmlspecialchars($detail['Author']); ?></td>
                    <td><?php echo $detail['Quantity']; ?></td>
                    <td><?php echo number_format($detail['Price'], 0, ',', '.'); ?>đ</td>
                    <td><?php echo number_format($detail['TotalPrice'], 0, ',', '.'); ?>đ</td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="total-label">Tổng cộng:</th>
                <th class="total-amount"><?php echo number_format($invoice['TotalPrice'], 0, ',', '.'); ?>đ</th>
            </tr>
        </tfoot>
    </table>
    
    <div class="invoice-actions">
        <button class="btn-print" onclick="printInvoice('<?php echo $salesID; ?>')">In hóa đơn</button>
    </div>
</div>

<script>
    function printInvoice(salesID) {
        // Open print window for this invoice
        window.open('/webbantruyen/handle/printInvoice.php?id=' + salesID, '_blank');
    }
    
    function closeInvoiceDetails() {
        // Close modal if in a modal context
        if (window.parent.document.getElementById('invoice-modal')) {
            window.parent.document.getElementById('invoice-modal').style.display = 'none';
        }
    }
</script>
<?php
$conn->close();
?>