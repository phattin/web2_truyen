<?php
    require 'model/connectDB.php';
    $conn = connectDB::getConnection();

    $limit = 9;
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $offset = ($page - 1) * $limit;

    $result = $conn->query("SELECT * FROM product LIMIT $limit OFFSET $offset");
    $total_products = $conn->query("SELECT COUNT(*) AS total FROM product")->fetch_assoc()['total'];
    $total_pages = ceil($total_products / $limit);

    connectDB::closeConnection($conn);
?>

<main class="container">
<div class="product-grid">
    <?php while ($product = $result->fetch_assoc()): ?>
        <div class="product-item">
            <a href="index.php?page=product_detail&id=<?= $product['ProductID'] ?>">
                <img src="view/layout/images/<?= $product['ProductImg'] ?>" alt="<?= $product['ProductName'] ?>">
            </a>
            <h3><?= $product['ProductName'] ?></h3>
            <p class="price"><?= $product['ROS'] ?> $</p>
            <button class="btn-add-to-cart">Thêm vào giỏ hàng</button>
        </div>
    <?php endwhile; ?>
</div>


    <!-- Phân trang -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" class="btn-pagination">❮</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i ?>" class="btn-pagination <?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
        <?php if ($page < $total_pages): ?>
            <a href="?page=<?= $page + 1 ?>" class="btn-pagination">❯</a>
        <?php endif; ?>
    </div>
</main>
