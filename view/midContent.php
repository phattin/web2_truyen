<?php
    require_once 'model/productDB.php';
    $conn = connectDB::getConnection();

    $limit = 9;
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $offset = ($page - 1) * $limit;

    // Lấy thể loại từ URL nếu có
    $genre = isset($_GET['genre']) ? $_GET['genre'] : '';

    // Lấy toàn bộ sản phẩm
    $products = productDB::getAllProduct();

    // Lọc sản phẩm theo thể loại
    if ($genre != '')
        $products = productDB::getProductHasGenre($genre);

    // Lấy sản phẩm cho trang hiện tại
    $result = array_slice($products, $offset, $limit);

    // Tổng số trang
    $total_products = count($products);
    $total_pages = ceil($total_products / $limit);

    connectDB::closeConnection($conn);
?>

<main class="container">
    <div class="product-grid">
        <?php foreach ($result as $product): ?>
            <div class="product-item">
                <a href="index.php?page=product_detail&id=<?= $product['ProductID'] ?>">
                    <img src="view/layout/images/<?= $product['ProductImg'] ?>" alt="<?= $product['ProductName'] ?>">
                </a>
                <h3><?= $product['ProductName'] ?></h3>
                <p class="price"><?= number_format(round((int)$product['ImportPrice'] * (float)$product['ROS'], -3), 0, '.', '.') ?> VNĐ</p>
                <button class="btn-add-to-cart">Thêm vào giỏ hàng</button>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Phân trang -->
    <?php if ($total_pages > 1): ?>
        <div class="pagination">
            <?php
                // Tạo URL giữ thể loại nếu có
                $queryString = !empty($genre) ? "genre=$genre&" : "";
            ?>
            <?php if ($page > 1): ?>
                <a href="?<?= $queryString ?>page=<?= $page - 1 ?>" class="btn-pagination">❮</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?<?= $queryString ?>page=<?= $i ?>" class="btn-pagination <?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
                <a href="?<?= $queryString ?>page=<?= $page + 1 ?>" class="btn-pagination">❯</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>