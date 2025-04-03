<?php
session_start();
header('Content-Type: application/json');

include($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php"); // Kết nối CSDL
$conn = connectDB::getConnection();

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;
$newQuantity = $data['quantity'] ?? 0;

if ($id && isset($_SESSION['cart'])) {
    // Lấy số lượng sản phẩm từ cơ sở dữ liệu
    $sql = "SELECT Quantity FROM product WHERE ProductID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $maxQuantity = $product['Quantity']; // Số lượng tối đa trong kho

        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                // Kiểm tra nếu số lượng vượt quá số lượng trong kho
                if ($newQuantity > $maxQuantity) {
                    echo json_encode([
                        "success" => false,
                        "message" => "Chỉ còn $maxQuantity cuốn truyện! Bạn hãy mua thêm sản phẩm khác"
                    ]);
                    exit();
                }

                // Cập nhật số lượng trong giỏ hàng
                $item['quantity'] = $newQuantity > 0 ? $newQuantity : 1; // Không cho nhỏ hơn 1
                echo json_encode(["success" => true]);
                exit();
            }
        }
    } else {
        echo json_encode(["success" => false, "message" => "Sản phẩm không tồn tại."]);
        exit();
    }
}

echo json_encode(["success" => false, "message" => "Sản phẩm không tồn tại."]);