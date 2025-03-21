<?php
$file_path = $_SERVER["DOCUMENT_ROOT"] . "/webbantruyen/model/genreDB.php";
if (file_exists($file_path)) {
    require_once $file_path;
} else {
    die("Lỗi: Không tìm thấy file genreDB.php!");
}

if (isset($_GET['id'])) {
    $productID = $_GET['id'];
    $genres = genreDB::getGenresOfProduct($productID);
    $conn = connectDB::getConnection();

    $query = "SELECT p.*, s.SupplierName FROM product p 
              JOIN supplier s ON p.SupplierID = s.SupplierID 
              WHERE p.ProductID = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $productID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Sản phẩm không tồn tại!";
        exit;
    }

    connectDB::closeConnection($conn);
} else {
    echo "Không có sản phẩm được chọn!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['ProductName']; ?> - Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="view/layout/css/product_detail.css">
</head>

<body>

    <div class="product-container">
        <div class="product-img">
        <img src="view/layout/images/<?php echo $product['ProductImg']; ?>" alt="<?php echo $product['ProductName']; ?>">
        </div>
        <div class="product-info">
            <h1><?php echo $product['ProductName']; ?></h1>
            <p><strong>Tác giả:</strong> <?php echo $product['Author']; ?></p>
            <p><strong>Nhà xuất bản:</strong> <?php echo $product['Publisher']; ?></p>
            <p><strong>Số lượng còn lại:</strong> <?php echo $product['Quantity']; ?></p>
            <p><strong>Nhà cung cấp:</strong> <?php echo $product['SupplierName']; ?></p>
            <p>
                <strong>Thể loại:</strong>
                <?php
                $lastIndex = count($genres) - 1;
                foreach ($genres as $index => $genre) {
                    echo '<a href="?genre='. $genre['GenreID'] .'">' . $genre['GenreName'] . '</a>';
                    if ($index < $lastIndex) {
                        echo " - ";
                    }
                }
                ?>
            </p>
            <p><strong>Mô tả:</strong> <?php echo $product['Description']; ?></p>

            <div class="product-buttons">
                <button class="buy-btn">Mua ngay</button>
            </div>
        </div>
    </div>

</body>

</html>