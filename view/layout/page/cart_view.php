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
<div class="container">
    <h2>🛒 Giỏ Hàng Của Bạn</h2>

    <table id="cart-table">
        <tr>
            <th><input type="checkbox" class="cbCart-all"></th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Tổng tiền</th>
            <th>Hành động</th>
        </tr>

        <?php
        if (!empty($_SESSION['cart'])):
            foreach ($_SESSION['cart'] as $key => $item):
                $subtotal = $item['price'] * $item['quantity'];
        ?>
            <tr>
                <td><input type="checkbox" class="cbCart-item"></td>
                <td style="display:none" class="idProduct-cart"><?= $item['id'] ?></td>
                <td class="nameProduct-cart"><?= htmlspecialchars($item['name']) ?></td>
                <td class="priceProduct-cart"><?= number_format($item['price'], 0, ',', '.') ?> VNĐ</td>
                <td>
                    <div class="quantity-control">
                        <button class="btn-quantity btn-decrease" data-id="<?= $item['id'] ?>">-</button>
                        <input type="number" class="quantity-input" data-id="<?= $item['id'] ?>" value="<?= $item['quantity'] ?>" min="1">
                        <button class="btn-quantity btn-increase" data-id="<?= $item['id'] ?>">+</button>
                    </div>
                </td>
                <td class="totalPrice-cart"><?= number_format($subtotal, 0, ',', '.') ?> VNĐ</td>
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
            <td colspan="2"><strong class="totalAllPrice-cart">0 VND</strong></td>
        </tr>
    </table>

    <br>
    <div class="btn btn-checkout">Thanh toán</div>
    <a href="index.php?page=home" class="btn btn-continue">Tiếp tục mua hàng</a>
</div>
<script src="view/layout/js/cart_view.js"></script>
</body>
</html>
