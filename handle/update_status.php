<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/salesInvoiceDB.php");

$data = json_decode(file_get_contents("php://input"), true);
$sales_id = $data['sales_id'] ?? '';
$status = $data['status'] ?? '';

if (empty($sales_id) || empty($status)) {
    http_response_code(400);
    echo "Thiếu thông tin.";
    exit;
}

if (salesInvoiceDB::updateStatus($sales_id, $status)) {
    echo "Cập nhật thành công.";
} else {
    http_response_code(500);
    echo "Lỗi khi cập nhật: ";
}

$conn->close();
?>
