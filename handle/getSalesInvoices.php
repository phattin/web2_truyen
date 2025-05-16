<?php
// getSalesInvoices.php
include_once($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/order_history_utils.php");

// Lấy các tham số tìm kiếm
$province = isset($_GET['province']) ? $_GET['province'] : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$district = isset($_GET['district']) ? $_GET['district'] : '';

$conn = connectToDatabase();

// Kiểm tra kết nối
if (!$conn) {
    die("Lỗi kết nối đến cơ sở dữ liệu");
}

// Điều kiện mặc định
$base_condition = " WHERE 1=1 ";
$conditions = [];

// Lọc theo khoảng thời gian
if (!empty($start_date) && !empty($end_date)) {
    $start_date_escaped = $conn->real_escape_string($start_date);
    $end_date_escaped = $conn->real_escape_string($end_date);
    $conditions[] = "si.Date BETWEEN '$start_date_escaped' AND '$end_date_escaped'";
} elseif (!empty($start_date)) {
    $start_date_escaped = $conn->real_escape_string($start_date);
    $conditions[] = "si.Date >= '$start_date_escaped'";
} elseif (!empty($end_date)) {
    $end_date_escaped = $conn->real_escape_string($end_date);
    $conditions[] = "si.Date <= '$end_date_escaped'";
}

// Lọc theo tỉnh/thành phố
if (!empty($province)) {
    $province_escaped = $conn->real_escape_string($province);
    $conditions[] = "si.Address LIKE '%$province_escaped%'";
}

// Lọc theo quận/huyện
if (!empty($district)) {
    $district_escaped = $conn->real_escape_string($district);
    $conditions[] = "si.Address LIKE '%$district_escaped%'";
}

// Gộp điều kiện
if (!empty($conditions)) {
    $base_condition .= " AND " . implode(" AND ", $conditions);
}

$sql = "
    SELECT si.Status, si.SalesID, c.FullName, c.Username, si.Address, c.Phone, si.Date, si.PromotionID, si.TotalPrice 
    FROM sales_invoice si
    LEFT JOIN customer c ON si.CustomerID = c.CustomerID
    $base_condition
    ORDER BY si.Date DESC
";

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

        // Lấy danh sách sản phẩm
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
                    <tr>
                        <th style='color: black;'>Tên sản phẩm</th>
                        <th style='color: black;'>Tác giả</th>
                        <th style='color: black;'>Nhà xuất bản</th>
                        <th style='color: black;'>Số lượng</th>
                        <th style='color: black;'>Giá</th>
                        <th style='color: black;'>Thành tiền</th>
                    </tr>
                  </thead><tbody>";

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
            echo "</tbody><tfoot>
                <tr>
                    <td colspan='5' style='text-align: right'><strong>Tổng cộng:</strong></td>
                    <td><strong>" . number_format($total, 0, ',', '.') . "đ</strong></td>
                </tr>
              </tfoot>";
            echo "</table>";
        } else {
            echo "<p>Không có sản phẩm nào trong hóa đơn này.</p>";
        }
        $stmt->close();

        echo "<div class='invoice-actions'>";
        $status = $row['Status'];
        $status_options = [
            'Chưa xác nhận',
            'Đã xác nhận',
            'Đã giao thành công',
            'Đã hủy'
        ];

        // Nếu trạng thái là 'Đã giao thành công' hoặc 'Đã hủy' thì disable select
        $disable_select = ($status === 'Đã giao thành công' || $status === 'Đã hủy') ? "disabled" : "";

        echo "<select id='status_$salesID' class='status-select' data-current-status='" . htmlspecialchars($status) . "' onchange='updateStatus(\"$salesID\", this.value, this)' $disable_select>";
        foreach ($status_options as $option) {
            $selected = ($option === $status) ? "selected" : "";
            echo "<option value='$option' $selected>$option</option>";
        }
        echo "</select>";
        echo "<button style='margin-left:20px;' class='btn-print' onclick='printInvoice(\"" . $salesID . "\")'>In hóa đơn</button>";
        echo "</div>";
    }
} else {
    if ($conn->error) {
        echo "<p class='error'>Lỗi truy vấn: " . $conn->error . "</p>";
    } else {
        echo "<p class='no-results'>Không tìm thấy hóa đơn nào phù hợp với điều kiện tìm kiếm.</p>";
    }
}

$conn->close();
?>
