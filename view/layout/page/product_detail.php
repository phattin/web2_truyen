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
    <style>
        .btn-add-to-cart {
            background-color: #a3f86a;
            /* Màu cam nổi bật */
            color: rgb(71, 71, 72);
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            margin-left: 20px;
        }

        .btn-add-to-cart :hover {
            background-color: #56e6f0;
            /* Màu cam đậm hơn khi hover */
            transform: scale(1.05);
            /* Phóng to nhẹ */
            box-shadow: 0px 6px 8px rgba(0, 0, 0, 0.15);
        }

        /* Hiệu ứng khi nhấn */
        .btn-add-to-cart:active {
            background-color: #d94a3c;
            /* Màu cam đậm hơn khi nhấn */
            transform: scale(0.95);
            /* Thu nhỏ nhẹ */
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <div class="product-container product-item">
        <div class="product-img">
            <img src="view/layout/images/<?php echo $product['ProductImg']; ?>"
                alt="<?php echo $product['ProductName']; ?>">
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
                <form action="view/layout/page/cart.php" method="POST">
                    <input type="hidden" name="id" value="<?= $product['ProductID'] ?>">
                    <input type="hidden" name="name" value="<?= $product['ProductName'] ?>">
                    <input type="hidden" name="price"
                        value="<?= round((int) $product['ImportPrice'] * (float) $product['ROS'], -3) ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="button" style="background-color:rgb(80, 176, 214); color:rgb(39, 40, 40)" class="btn-add-to-cart" data-id="<?= $product['ProductID'] ?>">Mua ngay</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.querySelector('.product-container').scrollIntoView({ behavior: 'smooth' });
    </script>
</body>

</html>