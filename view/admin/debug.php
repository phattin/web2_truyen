<?php
// debug.php - Đặt tại thư mục gốc của dự án

// Hiển thị lỗi PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>PHP Debug Information</h2>";

// Kiểm tra kết nối cơ sở dữ liệu
include_once($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/order_history_utils.php");

try {
    $conn = connectToDatabase();
    if ($conn) {
        echo "<p style='color: green;'>✓ Kết nối cơ sở dữ liệu thành công!</p>";
        
        // Kiểm tra bảng sales_invoice
        $test_query = "SELECT COUNT(*) as count FROM sales_invoice";
        $result = $conn->query($test_query);
        
        if ($result) {
            $row = $result->fetch_assoc();
            echo "<p>Số lượng hóa đơn trong hệ thống: " . $row['count'] . "</p>";
        } else {
            echo "<p style='color: red;'>Lỗi truy vấn bảng sales_invoice: " . $conn->error . "</p>";
        }
        
        $conn->close();
    } else {
        echo "<p style='color: red;'>✗ Không thể kết nối đến cơ sở dữ liệu!</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>Lỗi: " . $e->getMessage() . "</p>";
}

// Kiểm tra các đường dẫn
echo "<h3>Đường dẫn</h3>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "</p>";

// Kiểm tra tệp getSalesInvoices.php
$salesInvoicesPath = $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/handle/getSalesInvoices.php";
echo "<p>Đường dẫn đến getSalesInvoices.php: " . $salesInvoicesPath . "</p>";
echo "<p>File tồn tại: " . (file_exists($salesInvoicesPath) ? "Có" : "Không") . "</p>";

// Thông tin PHP
echo "<h3>Thông tin PHP</h3>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Loaded Extensions: </p><ul>";
$extensions = get_loaded_extensions();
sort($extensions);
foreach ($extensions as $ext) {
    echo "<li>" . $ext . "</li>";
}
echo "</ul>";

// Thông tin POST và GET
echo "<h3>Dữ liệu POST</h3>";
echo "<pre>" . print_r($_POST, true) . "</pre>";

echo "<h3>Dữ liệu GET</h3>";
echo "<pre>" . print_r($_GET, true) . "</pre>";
?>