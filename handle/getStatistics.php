<?php
//getStatistics.php .
include_once($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/order_history_utils.php");

// Input validation
$startDate = isset($_POST['startDate']) ? $_POST['startDate'] : null;
$endDate = isset($_POST['endDate']) ? $_POST['endDate'] : null;

// Lấy tham số sắp xếp
$customerSort = isset($_POST['customerSort']) ? $_POST['customerSort'] : 'desc';
$productSort = isset($_POST['productSort']) ? $_POST['productSort'] : 'desc';
$invoiceSort = isset($_POST['invoiceSort']) ? $_POST['invoiceSort'] : 'desc';

// Đảm bảo tham số sắp xếp hợp lệ
$validSortOrders = ['asc', 'desc'];
$customerSort = in_array($customerSort, $validSortOrders) ? $customerSort : 'desc';
$productSort = in_array($productSort, $validSortOrders) ? $productSort : 'desc';
$invoiceSort = in_array($invoiceSort, $validSortOrders) ? $invoiceSort : 'desc';

if (!$startDate || !$endDate) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Vui lòng nhập đầy đủ khoảng thời gian.'
    ]);
    exit;
}

// Validate date format and range
if (strtotime($endDate) < strtotime($startDate)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Ngày kết thúc phải sau ngày bắt đầu.'
    ]);
    exit;
}

try {
    $conn = connectToDatabase();
    
    // Summary statistics
    $summary = getOrderSummary($conn, $startDate, $endDate);
    
    // Top 5 customers với tham số sắp xếp
    $topCustomers = getTopCustomers($conn, $startDate, $endDate, $customerSort);
    
    // Top 5 products với tham số sắp xếp
    $topProducts = getTopProducts($conn, $startDate, $endDate, $productSort);
    
    // Invoice list với tham số sắp xếp
    $invoices = getInvoiceList($conn, $startDate, $endDate, $invoiceSort);
    
    // Generate HTML output
    $html = generateStatisticsHTML($summary, $topCustomers, $topProducts, $invoices);
    
    echo $html;
    
} catch (Exception $e) {
    echo "<p class='error'>Lỗi hệ thống: " . htmlspecialchars($e->getMessage()) . "</p>";
} finally {
    $conn->close();
}

/**
 * Lấy tổng hợp thống kê đơn hàng trong khoảng thời gian
 */
function getOrderSummary($conn, $startDate, $endDate) {
    $sql = "
        SELECT 
            COALESCE(COUNT(DISTINCT si.SalesID), 0) AS TotalInvoices,
            COALESCE(SUM(si.TotalPrice), 0) AS TotalRevenue,
            COALESCE(COUNT(DISTINCT si.CustomerID), 0) AS TotalCustomers,
            COALESCE(ROUND(AVG(si.TotalPrice), 0), 0) AS AverageInvoice
        FROM sales_invoice si
        WHERE si.Date BETWEEN ? AND ?
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_assoc();
}

/**
 * Lấy top 5 khách hàng mua nhiều nhất
 * @param string $sortOrder 'asc' hoặc 'desc'
 */
function getTopCustomers($conn, $startDate, $endDate, $sortOrder = 'desc') {
    $sql = "
        SELECT 
            c.CustomerID, 
            c.FullName, 
            c.Username, 
            COALESCE(COUNT(DISTINCT si.SalesID), 0) AS OrderCount,
            COALESCE(SUM(si.TotalPrice), 0) AS TotalSpent
        FROM sales_invoice si
        JOIN customer c ON si.CustomerID = c.CustomerID
        WHERE si.Date BETWEEN ? AND ?
        GROUP BY c.CustomerID, c.FullName, c.Username
        ORDER BY TotalSpent " . strtoupper($sortOrder) . "
        LIMIT 5
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    
    return $stmt->get_result();
}

/**
 * Lấy top 5 sản phẩm bán chạy nhất
 * @param string $sortOrder 'asc' hoặc 'desc'
 */
function getTopProducts($conn, $startDate, $endDate, $sortOrder = 'desc') {
    $sql = "
        SELECT 
            p.ProductID,
            p.ProductName,
            p.Author,
            COALESCE(SUM(sid.Quantity), 0) AS TotalQuantity,
            COALESCE(SUM(sid.TotalPrice), 0) AS TotalRevenue
        FROM sales_invoice si
        JOIN sales_invoice_detail sid ON si.SalesID = sid.SalesID
        JOIN product p ON sid.ProductID = p.ProductID
        WHERE si.Date BETWEEN ? AND ?
        GROUP BY p.ProductID, p.ProductName, p.Author
        ORDER BY TotalQuantity " . strtoupper($sortOrder) . "
        LIMIT 5
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    
    return $stmt->get_result();
}

/**
 * Lấy danh sách hóa đơn trong khoảng thời gian
 * @param string $sortOrder 'asc' hoặc 'desc'
 */
function getInvoiceList($conn, $startDate, $endDate, $sortOrder = 'desc') {
    $sql = "
        SELECT 
            si.SalesID, 
            c.FullName, 
            si.Date, 
            si.TotalPrice,
            (SELECT COUNT(*) FROM sales_invoice_detail WHERE SalesID = si.SalesID) AS ItemCount
        FROM sales_invoice si
        JOIN customer c ON si.CustomerID = c.CustomerID
        WHERE si.Date BETWEEN ? AND ?
        ORDER BY si.TotalPrice " . strtoupper($sortOrder) . ", si.Date DESC
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    
    return $stmt->get_result();
}

/**
 * Tạo HTML cho kết quả thống kê
 */
function generateStatisticsHTML($summary, $topCustomers, $topProducts, $invoices) {
    $html = '<div class="statistics-results">';
    
    // Summary section
    $html .= '<div class="summary-cards">
        <div class="summary-card">
            <div class="card-value">' . number_format($summary['TotalInvoices'], 0, ',', '.') . '</div>
            <div class="card-label">Tổng đơn hàng</div>
        </div>
        <div class="summary-card">
            <div class="card-value">' . number_format($summary['TotalRevenue'], 0, ',', '.') . 'đ</div>
            <div class="card-label">Tổng doanh thu</div>
        </div>
        <div class="summary-card">
            <div class="card-value">' . number_format($summary['TotalCustomers'], 0, ',', '.') . '</div>
            <div class="card-label">Khách hàng mua</div>
        </div>
        <div class="summary-card">
            <div class="card-value">' . number_format($summary['AverageInvoice'], 0, ',', '.') . 'đ</div>
            <div class="card-label">Giá trị trung bình/đơn</div>
        </div>
    </div>';
    
    // Top customers section
    if ($topCustomers->num_rows > 0) {
        $html .= "<h3>Top 5 Khách Hàng Mua Nhiều Nhất</h3>";
        $html .= "<table class='statistics-table'>";
        $html .= "<thead>
                <tr>
                    <th style='color: black;'>STT</th>
                    <th style='color: black;'>Tên khách hàng</th>
                    <th style='color: black;'>Tên đăng nhập</th>
                    <th style='color: black;'>Số đơn hàng</th>
                    <th style='color: black;'>Tổng tiền mua</th>
                </tr>
              </thead>";
        $html .= "<tbody>";
        $stt = 1;
        while ($row = $topCustomers->fetch_assoc()) {
            $html .= "<tr>";
            $html .= "<td>" . $stt++ . "</td>";
            $html .= "<td>" . htmlspecialchars($row['FullName']) . "</td>";
            $html .= "<td>" . htmlspecialchars($row['Username']) . "</td>";
            $html .= "<td>" . number_format($row['OrderCount'], 0, ',', '.') . "</td>";
            $html .= "<td>" . number_format($row['TotalSpent'], 0, ',', '.') . "đ</td>";
            $html .= "</tr>";
        }
        $html .= "</tbody>";
        $html .= "</table>";
    } else {
        $html .= "<h3>Top 5 Khách Hàng Mua Nhiều Nhất</h3>";
        $html .= "<p>Không tìm thấy khách hàng nào trong khoảng thời gian này.</p>";
    }
    
    // Top products section
    if ($topProducts->num_rows > 0) {
        $html .= "<h3>Top 5 Sản Phẩm Bán Chạy Nhất</h3>";
        $html .= "<table class='statistics-table'>";
        $html .= "<thead>
                <tr>
                    <th style='color: black;'>STT</th>
                    <th style='color: black;'>Tên sản phẩm</th>
                    <th style='color: black;'>Tác giả</th>
                    <th style='color: black;'>Số lượng bán</th>
                    <th style='color: black;'>Doanh thu</th>
                </tr>
              </thead>";
        $html .= "<tbody>";
        $stt = 1;
        while ($row = $topProducts->fetch_assoc()) {
            $html .= "<tr>";
            $html .= "<td>" . $stt++ . "</td>";
            $html .= "<td>" . htmlspecialchars($row['ProductName']) . "</td>";
            $html .= "<td>" . htmlspecialchars($row['Author']) . "</td>";
            $html .= "<td>" . number_format($row['TotalQuantity'], 0, ',', '.') . "</td>";
            $html .= "<td>" . number_format($row['TotalRevenue'], 0, ',', '.') . "đ</td>";
            $html .= "</tr>";
        }
        $html .= "</tbody>";
        $html .= "</table>";
    } else {
        $html .= "<h3>Top 5 Sản Phẩm Bán Chạy Nhất</h3>";
        $html .= "<p>Không tìm thấy sản phẩm nào được bán trong khoảng thời gian này.</p>";
    }
    
    // Invoice list section
    if ($invoices->num_rows > 0) {
        $html .= "<h3>Danh Sách Hóa Đơn</h3>";
        $html .= "<table class='statistics-table'>";
        $html .= "<thead>
                <tr>
                    <th style='color: black;'>STT</th>
                    <th style='color: black;'>Mã hóa đơn</th>
                    <th style='color: black;'>Khách hàng</th>
                    <th style='color: black;'>Ngày</th>
                    <th style='color: black;'>Số sản phẩm</th>
                    <th style='color: black;'>Tổng tiền</th>
                    <th style='color: black;'>Chi tiết</th>
                </tr>
              </thead>";
        $html .= "<tbody>";
        $stt = 1;
        while ($row = $invoices->fetch_assoc()) {
            $html .= "<tr>";
            $html .= "<td>" . $stt++ . "</td>";
            $html .= "<td>" . htmlspecialchars($row['SalesID']) . "</td>";
            $html .= "<td>" . htmlspecialchars($row['FullName']) . "</td>";
            $html .= "<td>" . htmlspecialchars($row['Date']) . "</td>";
            $html .= "<td>" . $row['ItemCount'] . "</td>";
            $html .= "<td>" . number_format($row['TotalPrice'], 0, ',', '.') . "đ</td>";
            $html .= "<td><a href='#' class='view-details' data-salesid='" . $row['SalesID'] . "' onclick='showInvoiceDetails(\"" . $row['SalesID'] . "\", this); return false;'>Xem chi tiết</a></td>";
            $html .= "</tr>";
        }
        $html .= "</tbody>";
        $html .= "</table>";
    } else {
        $html .= "<h3>Danh Sách Hóa Đơn</h3>";
        $html .= "<p>Không tìm thấy hóa đơn nào trong khoảng thời gian này.</p>";
    }
    
    $html .= '</div>';
    return $html;
}
?>