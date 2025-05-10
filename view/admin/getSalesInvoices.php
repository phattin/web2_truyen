<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/order_history_utils.php");

$conn = connectToDatabase();
$search = isset($_GET['search']) ? $_GET['search'] : '';
$search_condition = buildSearchConditionForAll($conn, $search);
$result_distinct_sales = getOrdersList($conn, $search_condition, 0, 10); // Lấy 10 hóa đơn đầu tiên

if ($result_distinct_sales && $result_distinct_sales->num_rows > 0) {
    echo "<table class='invoice-table'>";
    echo "<thead>
            <tr>
                <th>SalesID</th>
                <th>Ngày</th>
                <th>Địa chỉ</th>
                <th>Điện thoại</th>
                <th>Tổng tiền</th>
            </tr>
          </thead>";
    echo "<tbody>";
    while ($row = $result_distinct_sales->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['SalesID']) . "</td>";
        echo "<td>" . date('d/m/Y', strtotime($row['Date'])) . "</td>";
        echo "<td>" . htmlspecialchars($row['Address']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Phone']) . "</td>";
        echo "<td>" . number_format($row['Total'], 0, ',', '.') . "đ</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>Không tìm thấy hóa đơn nào.</p>";
}

$conn->close();
?>