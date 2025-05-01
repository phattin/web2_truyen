<?php
session_start(); // Bắt đầu phiên làm việc

// Nhập file chứa các hàm truy vấn
include_once($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/order_history_utils.php");

// Khởi tạo các biến
$username = $_SESSION['username'];
$error = "";
$success = "";

// Lấy tham số tìm kiếm từ URL
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Kết nối CSDL
$conn = connectToDatabase();

// Xây dựng điều kiện tìm kiếm
$search_condition = buildSearchCondition($conn, $username, $search);

// Đếm tổng số hóa đơn
$total_records = countTotalOrders($conn, $search_condition);

// Thiết lập thông số phân trang
$records_per_page = 5;
$current_page = isset($_GET['p']) ? (int) $_GET['p'] : 1;

// Tính toán thông tin phân trang
$pagination = calculatePagination($total_records, $records_per_page, $current_page);
$current_page = $pagination['current_page'];
$offset = $pagination['offset'];
$total_pages = $pagination['total_pages'];

// Lấy danh sách hóa đơn
$result_distinct_sales = getOrdersList($conn, $search_condition, $offset, $records_per_page);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Sử Mua Hàng</title>
    <link rel="stylesheet" href="view/layout/css/order_history.css">
</head>

<body>
    <div class="container">
        <div class="close-btn" onclick="goBack()">✖</div>
        <script>
            function goBack() {
                window.location.href = "index.php";
            }
        </script>

        <h1>Lịch Sử Mua Hàng</h1>

        <div class="user-info">
            Xin chào, <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>. Đây là lịch sử mua hàng của
            bạn.
        </div>

        <form method="GET" action="/webbantruyen/index.php">
            <div class="search-container">
                <input type="hidden" name="page" value="order_history">
                <input type="text" name="search" class="search-input" placeholder="Tìm kiếm theo SalesID, sản phẩm"
                    value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="search-button">Tìm kiếm</button>
            </div>
        </form>

        <?php
        if ($result_distinct_sales && $result_distinct_sales->num_rows > 0) {
            // Hiển thị từng hóa đơn
            while ($sales_row = $result_distinct_sales->fetch_assoc()) {
                $sales_id = $sales_row['SalesID'];
                ?>
                <div class="invoice-header">
                    <div class="invoice-details">
                        <div class="invoice-detail-item">
                            <div class="invoice-detail-label">SalesID:</div>
                            <div><?php echo htmlspecialchars($sales_row['SalesID']); ?></div>
                        </div>
                        <div class="invoice-detail-item">
                            <div class="invoice-detail-label">Ngày:</div>
                            <div><?php echo date('d/m/Y', strtotime($sales_row['Date'])); ?></div>
                        </div>
                        <div class="invoice-detail-item">
                            <div class="invoice-detail-label">Địa chỉ:</div>
                            <div><?php echo htmlspecialchars($sales_row['Address']); ?></div>
                        </div>
                        <div class="invoice-detail-item">
                            <div class="invoice-detail-label">Điện thoại:</div>
                            <div><?php echo htmlspecialchars($sales_row['Phone']); ?></div>
                        </div>
                    </div>
                </div>

                <?php
                // Lấy chi tiết sản phẩm cho hóa đơn này
                $result_details = getOrderDetails($conn, $sales_id);

                if ($result_details && $result_details->num_rows > 0) {
                    ?>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã sản phẩm</th>
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
                                $grand_total = 0;
                                while ($detail_row = $result_details->fetch_assoc()) {
                                    $grand_total += $detail_row['TotalPrice'];
                                    ?>
                                    <tr>
                                        <td data-label="Mã sản phẩm"><?php echo htmlspecialchars($detail_row['ProductID']); ?></td>
                                        <td data-label="Tên sản phẩm"><?php echo htmlspecialchars($detail_row['ProductName']); ?></td>
                                        <td data-label="Tác giả"><?php echo htmlspecialchars($detail_row['Author']); ?></td>
                                        <td data-label="Nhà xuất bản"><?php echo htmlspecialchars($detail_row['Publisher']); ?></td>
                                        <td data-label="Số lượng"><?php echo number_format($detail_row['Quantity']); ?></td>
                                        <td data-label="Đơn giá"><?php echo number_format($detail_row['Price']) . 'đ'; ?></td>
                                        <td data-label="Thành tiền"><?php echo number_format($detail_row['TotalPrice']) . 'đ'; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr class="total-row">
                                    <td colspan="6" style="text-align: right;" data-label="Tổng cộng">Tổng cộng:</td>
                                    <td data-label="Giá trị"><?php echo number_format($grand_total) . 'đ'; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php
                } else {
                    echo "<p class='no-records'>Không có chi tiết sản phẩm nào cho hóa đơn này.</p>";
                }
            }
        } else {
            echo "<p class='no-records'>Không tìm thấy hóa đơn nào.</p>";
        }
        ?>

        <!-- Phân trang -->
        <?php
        if ($total_pages > 1) {
            echo generatePaginationHTML($current_page, $total_pages, $search);
        }
        ?>
    </div>
</body>

</html>

<?php
// Đóng kết nối database
$conn->close();
?>