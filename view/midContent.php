<?php
    // Kiểm tra session
if (session_status() === PHP_SESSION_NONE)
    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'] . '/webbantruyen/model/productDB.php';

    $limitHome = 9;
    $pageHome = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $offsetHome = ($pageHome - 1) * $limitHome;


    // Lấy toàn bộ sản phẩm
    $productsHome = productDB::getAllProduct();

    // Gửi mảng vào để tìm kiếm
    // echo "<script>const productsHome = " . json_encode($productsHome) . ";</script>";

    // Lấy sản phẩm đã tìm kiếm
    // Kiểm tra nếu có dữ liệu gửi đến
    // if (isset($_POST["productsHomeFound"]))
    //     $productsHomeFound = json_decode($_POST["productsHomeFound"], true);
    // else 
    //     $productsHomeFound = $productsHome;

    // Lấy sản phẩm cho trang hiện tại
    $resultHome = array_slice($productsHome, $offsetHome, $limitHome);

    // Tổng số trang
    $total_productsHome = count($productsHome);
    $total_pagesHome = ceil($total_productsHome / $limitHome);

    // Trả về HTML thay vì tải lại trang
    ob_start();
?>

<div class="product-grid">
    <?php
    foreach ($resultHome as $productHome) {
        // Lấy thông tin sản phẩm và xử lý
        $productID = $productHome['ProductID'];
        $productImg = $productHome['ProductImg'];
        $productName = $productHome['ProductName']; 
        $importPrice = $productHome['ImportPrice'];
        $ros = $productHome['ROS'];
        
        // Tính toán giá bán
        $price = round($importPrice * $ros / 1000) * 1000;
        $formattedPrice = number_format($price, 0, ',', '.') . ' VNĐ';
    ?>
        <div class="product-item">
            <a href="index.php?page=product_detail&id=<?= $productID ?>">
                <img src="view/layout/images/<?= $productImg ?>" alt="<?= $productName ?>">
            </a>
            <h3><?= $productName ?></h3>
            <p class="price"><?= $formattedPrice ?></p>

            <!-- Form gửi sản phẩm vào giỏ hàng -->
            <form action="view/layout/page/cart.php" method="POST">
                <input type="hidden" name="id" value="<?= $productID ?>">
                <input type="hidden" name="name" value="<?= $productName ?>">
                <input type="hidden" name="price" value="<?= $formattedPrice ?>">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-add-to-cart">Thêm vào giỏ hàng</button>
            </form>
        </div>
    <?php
    }
    ?>
</div>

<!-- Phân trang -->
<div class="pagination">
    <ul>
        <?php
        for ($i = 1; $i <= $total_pagesHome; $i++) {
            // Tạo các nút phân trang với dữ liệu về số trang
            if($i!=1)
                echo '<li class="btn-pagination" data-page="home" data-page_number="' . $i . '">' . $i . '</li>';
            else
                echo '<li class="btn-pagination active" data-page="home" data-page_number="' . $i . '">' . $i . '</li>';
        }
        echo '<li class="btn-pagination" data-page="${page}" data-page_number="2">&gt;</li>'
        ?>
    </ul>
</div>

<?php
$response = ob_get_clean();
echo $response;
?>