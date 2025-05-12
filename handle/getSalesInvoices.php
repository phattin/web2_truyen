<?php
//getSalesInvoices.php
include_once($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/order_history_utils.php");

$search = isset($_GET['search']) ? $_GET['search'] : '';
$conn = connectToDatabase();

// Kiểm tra kết nối
if (!$conn) {
    die("Lỗi kết nối đến cơ sở dữ liệu");
}

$sql = "
    SELECT si.SalesID, c.FullName, c.Username, c.Address, c.Phone, si.Date, si.PromotionID, si.TotalPrice 
    FROM sales_invoice si
    LEFT JOIN customer c ON si.CustomerID = c.CustomerID
";

if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $sql .= " WHERE si.SalesID LIKE '%$search%' OR c.FullName LIKE '%$search%' OR EXISTS (
        SELECT 1 FROM sales_invoice_detail sid 
        JOIN product p ON sid.ProductID = p.ProductID 
        WHERE sid.SalesID = si.SalesID AND p.ProductName LIKE '%$search%'
    )";
}

$sql .= " ORDER BY si.Date DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $salesID = $row['SalesID'];
        echo "<div class='invoice'>";
        echo "<h3>Hóa đơn: " . htmlspecialchars($salesID) . "</h3>";
        echo "<p>Khách hàng: " . htmlspecialchars($row['FullName'] ?? 'N/A') . " (" . htmlspecialchars($row['Username'] ?? 'N/A') . ")</p>";
        echo "<p>Địa chỉ: " . htmlspecialchars($row['Address'] ?? 'N/A') . "</p>";
        echo "<p>Điện thoại: " . htmlspecialchars($row['Phone'] ?? 'N/A') . "</p>";
        echo "<p>Ngày: " . htmlspecialchars($row['Date']) . "</p>";
        echo "<p>Mã khuyến mãi: " . htmlspecialchars($row['PromotionID'] ?: 'Không có') . "</p>";
        echo "<p>Tổng tiền: " . number_format($row['TotalPrice'], 0, ',', '.') . "đ</p>";

        // Lấy danh sách sản phẩm theo SalesID
        $product_sql = "
            SELECT p.ProductName, p.Author, p.Publisher, sid.Price, sid.Quantity 
            FROM sales_invoice_detail sid
            JOIN product p ON sid.ProductID = p.ProductID
            WHERE sid.SalesID = ?
        ";
        
        $stmt = $conn->prepare($product_sql);
        if (!$stmt) {
            echo "<p class='error'>Lỗi chuẩn bị truy vấn: " . $conn->error . "</p>";
            continue;
        }
        
        $stmt->bind_param("s", $salesID);
        $stmt->execute();
        $product_result = $stmt->get_result();

        if ($product_result && $product_result->num_rows > 0) {
            echo "<table class='product-table'>";
            echo "<thead>
                    <tr style='background-color:rgb(18, 18, 18)'>
                        <th>Tên sản phẩm</th>
                        <th>Tác giả</th>
                        <th>Nhà xuất bản</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Thành tiền</th>
                    </tr>
                  </thead>";
            echo "<tbody>";
            $total = 0;
            while ($product = $product_result->fetch_assoc()) {
                $subtotal = $product['Price'] * $product['Quantity'];
                $total += $subtotal;
                echo "<tr>";
                echo "<td>" . htmlspecialchars($product['ProductName']) . "</td>";
                echo "<td>" . htmlspecialchars($product['Author']) . "</td>";
                echo "<td>" . htmlspecialchars($product['Publisher']) . "</td>";
                echo "<td>" . htmlspecialchars($product['Quantity']) . "</td>";
                echo "<td>" . number_format($product['Price'], 0, ',', '.') . "đ</td>";
                echo "<td>" . number_format($subtotal, 0, ',', '.') . "đ</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "<tfoot>
                    <tr>
                        <td colspan='5' style='text-align: right'><strong>Tổng cộng:</strong></td>
                        <td><strong>" . number_format($total, 0, ',', '.') . "đ</strong></td>
                    </tr>
                  </tfoot>";
            echo "</table>";
            $stmt->close();
        } else {
            echo "<p>Không có sản phẩm nào trong hóa đơn này.</p>";
            if ($stmt->error) {
                echo "<p class='error'>Lỗi truy vấn: " . $stmt->error . "</p>";
            }
        }

        // Nút in hóa đơn
        echo "<div class='invoice-actions'>";
        echo "<button class='btn-print' onclick='printInvoice(\"" . $salesID . "\")'>In hóa đơn</button>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p class='no-results'>Không tìm thấy hóa đơn nào.</p>";
    if ($conn->error) {
        echo "<p class='error'>Lỗi truy vấn: " . $conn->error . "</p>";
    }
}

$conn->close();
?>
<head>
    <link rel="stylesheet" href="/webbantruyen/view/layout/css/HoaDon.css">
</head>