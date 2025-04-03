<?php
session_start();

?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <link rel="stylesheet" href="view/layout/css/cart-view.css">
    
</head>
<body>
<script src="view/layout/js/cart_view.js"></script>
<div class="container">
    <h2>🛒 Giỏ Hàng Của Bạn</h2>

    <table>
        <tr>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Tổng tiền</th>
            <th>Hành động</th>
        </tr>

        <?php
        $total = 0;
        if (!empty($_SESSION['cart'])):
            foreach ($_SESSION['cart'] as $key => $item):
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
        ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= number_format($item['price'], 0, '.', ',') ?> VNĐ</td>
                <td>
                    <div class="quantity-control">
                        <button class="btn-quantity btn-decrease" data-id="<?= $item['id'] ?>">-</button>
                        <input type="number" class="quantity-input" data-id="<?= $item['id'] ?>" value="<?= $item['quantity'] ?>" min="1">
                        <button class="btn-quantity btn-increase" data-id="<?= $item['id'] ?>">+</button>
                    </div>
                </td>
                <td><?= number_format($subtotal, 0, '.', ',') ?> VNĐ</td>
                <td>
                    <button class="btn btn-delete" data-id="<?= $item['id'] ?>">Xóa</button>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="empty-cart">
                    <div class="empty-cart-content">
                        <!-- <img src="view/layout/images/empty-cart.png" alt="Giỏ hàng trống"> -->
                        <h3>Giỏ hàng của bạn đang trống</h3>
                        <p>Hãy thêm sản phẩm vào giỏ hàng để bắt đầu mua sắm!</p>
                        <!-- <a href="index.php?page=home" class="btn btn-continue">Tiếp tục mua sắm</a> -->
                    </div>
                </td>
            </tr>
        <?php endif; ?>

        <tr>
            <td colspan="3"><strong>Tổng cộng</strong></td>
            <td colspan="2"><strong><?= number_format($total, 0, '.', ',') ?> VNĐ</strong></td>
        </tr>
    </table>

    <br>
    <a href="/webbantruyen/view/layout/page/checkout.php" class="btn btn-checkout">Thanh toán</a>
    <a href="index.php?page=home" class="btn btn-continue">Tiếp tục mua hàng</a>
</div>

</body>
</html>
