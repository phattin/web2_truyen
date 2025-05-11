<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/order_history_utils.php");

$search = isset($_GET['search']) ? $_GET['search'] : '';
$conn = connectToDatabase();

$sql = "
    SELECT si.SalesID, c.FullName, c.Username, c.Address, c.Phone, si.Date, si.PromotionID, si.TotalPrice 
    FROM sales_invoice si
    LEFT JOIN customer c ON si.CustomerID = c.CustomerID
";

if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $sql .= " WHERE si.SalesID LIKE '%$search%' OR EXISTS (
        SELECT 1 FROM sales_invoice_detail sid 
        JOIN product p ON sid.ProductID = p.ProductID 
        WHERE sid.SalesID = si.SalesID AND p.ProductName LIKE '%$search%'
    )";
}

$sql .= " ORDER BY si.Date DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='invoice'>";
        echo "<h3>Hóa đơn: " . htmlspecialchars($row['SalesID']) . "</h3>";
        echo "<p>Khách hàng: " . htmlspecialchars($row['FullName'] ?? 'N/A') . " (" . htmlspecialchars($row['Username'] ?? 'N/A') . ")</p>";
        echo "<p>Địa chỉ: " . htmlspecialchars($row['Address'] ?? 'N/A') . "</p>";
        echo "<p>Điện thoại: " . htmlspecialchars($row['Phone'] ?? 'N/A') . "</p>";
        echo "<p>Ngày: " . htmlspecialchars($row['Date']) . "</p>";
        echo "<p>Tổng tiền: " . number_format($row['TotalPrice'], 0, ',', '.') . "đ</p>";
        echo "<button class='view-btn' onclick='viewInvoiceDetails(\"" . $row['SalesID'] . "\")'>Xem chi tiết</button>";
        echo "</div>";
    }
} else {
    echo "<p class='no-results'>Không tìm thấy hóa đơn nào.</p>";
}

$conn->close();
?>