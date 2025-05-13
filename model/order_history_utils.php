<?php
//order_history_utils.php .
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
 * Xây dựng điều kiện tìm kiếm dựa trên username, từ khóa, địa chỉ và khoảng thời gian
 * 
 * @param mysqli $conn Kết nối cơ sở dữ liệu
 * @param string $username Tên đăng nhập của khách hàng
 * @param string $search Từ khóa tìm kiếm
 * @param string $start_date Ngày bắt đầu
 * @param string $end_date Ngày kết thúc
 * @param string $address Địa chỉ để tìm kiếm
 * @return string Điều kiện tìm kiếm
 */
function buildSearchCondition($conn, $username, $search = '', $start_date = '', $end_date = '', $address = '') {
    // Điều kiện cơ bản để lọc theo username của khách hàng đang đăng nhập
    $base_condition = " WHERE c.Username = '" . $conn->real_escape_string($username) . "'";
    
    $conditions = [];
    
    // Tìm kiếm theo từ khóa
    if (!empty($search)) {
        $search = $conn->real_escape_string($search);
        $conditions[] = "(s.SalesID LIKE '%$search%' OR p.ProductName LIKE '%$search%')";
    }
    
    // Lọc theo khoảng thời gian
    if (!empty($start_date) && !empty($end_date)) {
        $start_date = $conn->real_escape_string($start_date);
        $end_date = $conn->real_escape_string($end_date);
        $conditions[] = "s.Date BETWEEN '$start_date' AND '$end_date'";
    } elseif (!empty($start_date)) {
        $start_date = $conn->real_escape_string($start_date);
        $conditions[] = "s.Date >= '$start_date'";
    } elseif (!empty($end_date)) {
        $end_date = $conn->real_escape_string($end_date);
        $conditions[] = "s.Date <= '$end_date'";
    }
    
    // Tìm kiếm theo địa chỉ
    if (!empty($address)) {
        $address = $conn->real_escape_string($address);
        $conditions[] = "c.Address LIKE '%$address%'";
    }
    
    // Kết hợp các điều kiện
    if (!empty($conditions)) {
        $base_condition .= " AND " . implode(" AND ", $conditions);
    }
    
    return $base_condition;
}

// Các hàm khác giữ nguyên như cũ
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

function getOrdersList($conn, $search_condition, $offset, $records_per_page) {
    $sql_distinct_sales = "
        SELECT DISTINCT s.SalesID, s.Date, c.Address, c.Phone 
        FROM sales_invoice s
        JOIN customer c ON s.CustomerID = c.CustomerID
        LEFT JOIN sales_invoice_detail sd ON s.SalesID = sd.SalesID
        LEFT JOIN product p ON sd.ProductID = p.ProductID
        $search_condition
        ORDER BY s.Date DESC
        LIMIT ?, ?
    ";
    
    $stmt = $conn->prepare($sql_distinct_sales);
    $stmt->bind_param("ii", $offset, $records_per_page);
    $stmt->execute();
    return $stmt->get_result();
}

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

function calculateOrderTotal($result_details) {
    $grand_total = 0;
    while ($detail_row = $result_details->fetch_assoc()) {
        $grand_total += $detail_row['TotalPrice'];
    }
    // Reset con trỏ kết quả để có thể duyệt lại
    $result_details->data_seek(0);
    return $grand_total;
}

function generatePaginationHTML($current_page, $total_pages, $search, $start_date = '', $end_date = '', $address = '') {
    $html = '<div class="pagination">';
    
    // Nút Previous
    if ($current_page > 1) {
        $base_url = "/webbantruyen/index.php?page=order_history";
        $params = [
            'p' => $current_page - 1,
            'search' => urlencode($search),
            'start_date' => urlencode($start_date),
            'end_date' => urlencode($end_date),
            'address' => urlencode($address)
        ];
        
        $url = $base_url . '&' . http_build_query($params);
        $html .= '<a href="' . $url . '">&laquo;</a>';
    }
    
    // Hiển thị tối đa 5 trang gần nhất
    $start_page = max(1, $current_page - 2);
    $end_page = min($total_pages, $start_page + 4);
    
    // Hiển thị trang đầu tiên và dấu ba chấm nếu cần
    if ($start_page > 1) {
        $base_url = "/webbantruyen/index.php?page=order_history";
        $params = [
            'p' => 1,
            'search' => urlencode($search),
            'start_date' => urlencode($start_date),
            'end_date' => urlencode($end_date),
            'address' => urlencode($address)
        ];
        
        $url = $base_url . '&' . http_build_query($params);
        $html .= '<a href="' . $url . '">1</a>';
        
        if ($start_page > 2) {
            $html .= '<span>...</span>';
        }
    }
    
    // Hiển thị các trang giữa
    for ($i = $start_page; $i <= $end_page; $i++) {
        $base_url = "/webbantruyen/index.php?page=order_history";
        $params = [
            'p' => $i,
            'search' => urlencode($search),
            'start_date' => urlencode($start_date),
            'end_date' => urlencode($end_date),
            'address' => urlencode($address)
        ];
        
        $url = $base_url . '&' . http_build_query($params);
        $active_class = ($i == $current_page) ? ' class="active"' : '';
        $html .= '<a href="' . $url . '"' . $active_class . '>' . $i . '</a>';
    }
    
    // Hiển thị trang cuối cùng và dấu ba chấm nếu cần
    if ($end_page < $total_pages) {
        if ($end_page < $total_pages - 1) {
            $html .= '<span>...</span>';
        }
        
        $base_url = "/webbantruyen/index.php?page=order_history";
        $params = [
            'p' => $total_pages,
            'search' => urlencode($search),
            'start_date' => urlencode($start_date),
            'end_date' => urlencode($end_date),
            'address' => urlencode($address)
        ];
        
        $url = $base_url . '&' . http_build_query($params);
        $html .= '<a href="' . $url . '">' . $total_pages . '</a>';
    }
    
    // Nút Next
    if ($current_page < $total_pages) {
        $base_url = "/webbantruyen/index.php?page=order_history";
        $params = [
            'p' => $current_page + 1,
            'search' => urlencode($search),
            'start_date' => urlencode($start_date),
            'end_date' => urlencode($end_date),
            'address' => urlencode($address)
        ];
        
        $url = $base_url . '&' . http_build_query($params);
        $html .= '<a href="' . $url . '">&raquo;</a>';
    }
    
    $html .= '</div>';
    return $html;
}