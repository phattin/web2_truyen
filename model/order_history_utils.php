<?php
function connectToDatabase() {
    include_once($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php");
    $conn = connectDB::getConnection();
    
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8");
    return $conn;
}

/**
 * Xây dựng điều kiện tìm kiếm dựa trên username và từ khóa
 * 
 * @param mysqli $conn Kết nối cơ sở dữ liệu
 * @param string $username Tên đăng nhập của khách hàng
 * @param string $search Từ khóa tìm kiếm
 * @return string Điều kiện tìm kiếm
 */
function buildSearchCondition($conn, $username, $search = '') {
    // Điều kiện cơ bản để lọc theo username của khách hàng đang đăng nhập
    $base_condition = " WHERE c.Username = '" . $conn->real_escape_string($username) . "'";
    
    if (!empty($search)) {
        $search = $conn->real_escape_string($search);
        return $base_condition . " AND (s.SalesID LIKE '%$search%' OR p.ProductName LIKE '%$search%')";
    } else {
        return $base_condition;
    }
}

/**
 * Đếm tổng số hóa đơn của người dùng theo điều kiện tìm kiếm
 * 
 * @param mysqli $conn Kết nối cơ sở dữ liệu
 * @param string $search_condition Điều kiện tìm kiếm
 * @return int Tổng số hóa đơn
 */
function countTotalOrders($conn, $search_condition) {
    $sql_count = "SELECT COUNT(DISTINCT s.SalesID) as total 
                  FROM sales_invoice s 
                  JOIN Customer c ON s.CustomerID = c.CustomerID
                  LEFT JOIN sales_invoice_detail sd ON s.SalesID = sd.SalesID
                  LEFT JOIN Product p ON sd.ProductID = p.ProductID
                  $search_condition";
    
    $result_count = $conn->query($sql_count);
    $row_count = $result_count->fetch_assoc();
    return $row_count['total'];
}

/**
 * Tính toán thông tin phân trang
 * 
 * @param int $total_records Tổng số bản ghi
 * @param int $records_per_page Số bản ghi mỗi trang
 * @param int $current_page Trang hiện tại
 * @return array Thông tin phân trang
 */
function calculatePagination($total_records, $records_per_page, $current_page) {
    $total_pages = ceil($total_records / $records_per_page);
    
    // Đảm bảo giá trị current_page hợp lệ
    $current_page = max(1, $current_page);
    $current_page = min($current_page, max(1, $total_pages));
    
    $offset = ($current_page - 1) * $records_per_page;
    
    return [
        'total_records' => $total_records,
        'records_per_page' => $records_per_page,
        'total_pages' => $total_pages,
        'current_page' => $current_page,
        'offset' => $offset
    ];
}

/**
 * Lấy danh sách hóa đơn theo điều kiện tìm kiếm và phân trang
 * 
 * @param mysqli $conn Kết nối cơ sở dữ liệu
 * @param string $search_condition Điều kiện tìm kiếm
 * @param int $offset Vị trí bắt đầu
 * @param int $records_per_page Số bản ghi mỗi trang
 * @return mysqli_result Kết quả truy vấn
 */
function getOrdersList($conn, $search_condition, $offset, $records_per_page) {
    $sql_distinct_sales = "SELECT DISTINCT s.SalesID, s.Date, s.Address, s.Phone 
                          FROM sales_invoice s
                          JOIN Customer c ON s.CustomerID = c.CustomerID
                          LEFT JOIN sales_invoice_detail sd ON s.SalesID = sd.SalesID
                          LEFT JOIN Product p ON sd.ProductID = p.ProductID
                          $search_condition
                          ORDER BY s.Date DESC
                          LIMIT $offset, $records_per_page";
    
    return $conn->query($sql_distinct_sales);
}

/**
 * Lấy chi tiết của một hóa đơn cụ thể
 * 
 * @param mysqli $conn Kết nối cơ sở dữ liệu
 * @param string $sales_id ID của hóa đơn
 * @return mysqli_result Kết quả truy vấn
 */
function getOrderDetails($conn, $sales_id) {
    $sql_details = "SELECT p.ProductID, p.ProductName, p.Author, p.Publisher, 
                   sd.Quantity, sd.Price, sd.TotalPrice
                   FROM sales_invoice_detail sd
                   JOIN Product p ON sd.ProductID = p.ProductID
                   WHERE sd.SalesID = ?";
    
    $stmt = $conn->prepare($sql_details);
    $stmt->bind_param("s", $sales_id);
    $stmt->execute();
    return $stmt->get_result();
}

/**
 * Tính tổng giá trị của một hóa đơn
 * 
 * @param mysqli_result $result_details Kết quả truy vấn chi tiết hóa đơn
 * @return float Tổng giá trị hóa đơn
 */
function calculateOrderTotal($result_details) {
    $grand_total = 0;
    while ($detail_row = $result_details->fetch_assoc()) {
        $grand_total += $detail_row['TotalPrice'];
    }
    // Reset con trỏ kết quả để có thể duyệt lại
    $result_details->data_seek(0);
    return $grand_total;
}

/**
 * Tạo HTML cho hệ thống phân trang
 * 
 * @param int $current_page Trang hiện tại
 * @param int $total_pages Tổng số trang
 * @param string $search Từ khóa tìm kiếm
 * @return string HTML cho hệ thống phân trang
 */
function generatePaginationHTML($current_page, $total_pages, $search) {
    $html = '<div class="pagination">';
    
    // Nút Previous
    if ($current_page > 1) {
        $html .= '<a href="/webbantruyen/index.php?page=order_history&p=' . ($current_page - 1) . '&search=' . urlencode($search) . '">&laquo;</a>';
    }
    
    // Hiển thị tối đa 5 trang gần nhất
    $start_page = max(1, $current_page - 2);
    $end_page = min($total_pages, $start_page + 4);
    
    // Hiển thị trang đầu tiên và dấu ba chấm nếu cần
    if ($start_page > 1) {
        $html .= '<a href="/webbantruyen/index.php?page=order_history&p=1&search=' . urlencode($search) . '">1</a>';
        if ($start_page > 2) {
            $html .= '<span>...</span>';
        }
    }
    
    // Hiển thị các trang giữa
    for ($i = $start_page; $i <= $end_page; $i++) {
        $active_class = ($i == $current_page) ? ' class="active"' : '';
        $html .= '<a href="/webbantruyen/index.php?page=order_history&p=' . $i . '&search=' . urlencode($search) . '"' . $active_class . '>' . $i . '</a>';
    }
    
    // Hiển thị trang cuối cùng và dấu ba chấm nếu cần
    if ($end_page < $total_pages) {
        if ($end_page < $total_pages - 1) {
            $html .= '<span>...</span>';
        }
        $html .= '<a href="/webbantruyen/index.php?page=order_history&p=' . $total_pages . '&search=' . urlencode($search) . '">' . $total_pages . '</a>';
    }
    
    // Nút Next
    if ($current_page < $total_pages) {
        $html .= '<a href="/webbantruyen/index.php?page=order_history&p=' . ($current_page + 1) . '&search=' . urlencode($search) . '">&raquo;</a>';
    }
    
    $html .= '</div>';
    return $html;
}