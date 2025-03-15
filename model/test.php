<?php
require 'productDB.php';

$productDB = new productDB();

// Xử lý thêm sản phẩm
if (isset($_POST['add'])) {
    $productDB->addProduct($_POST['id'], $_POST['name'], $_POST['img'], $_POST['author'], $_POST['publisher'], $_POST['quantity'], $_POST['ros'], $_POST['description'], $_POST['supplierID'], $_POST['status']);
}

// Xử lý cập nhật sản phẩm
if (isset($_POST['update'])) {
    $productDB->updateProduct($_POST['id'], $_POST['name'], $_POST['img'], $_POST['author'], $_POST['publisher'], $_POST['quantity'], $_POST['ros'], $_POST['description'], $_POST['supplierID'], $_POST['status']);
}

// Xử lý xóa mềm sản phẩm
if (isset($_POST['remove'])) {
    $productDB->removeProduct($_POST['id']);
}

// Lấy danh sách sản phẩm
$products = $productDB->getAllProduct();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Product Management</title>
    <style>
        table, th, td { border: 1px solid black; border-collapse: collapse; padding: 8px; }
        form { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>Danh sách sản phẩm</h2>
    <table>
        <tr>
            <th>ID</th><th>Tên</th><th>Ảnh</th><th>Tác giả</th><th>Nhà XB</th><th>Số lượng</th><th>ROS</th><th>Mô tả</th><th>SupplierID</th><th>Trạng thái</th><th>Hành động</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product['ProductID'] ?></td>
                <td><?= $product['ProductName'] ?></td>
                <td><img src="<?= $product['ProductImg'] ?>" width="50"></td>
                <td><?= $product['Author'] ?></td>
                <td><?= $product['Publisher'] ?></td>
                <td><?= $product['Quantity'] ?></td>
                <td><?= $product['ROS'] ?></td>
                <td><?= $product['Description'] ?></td>
                <td><?= $product['SupplierID'] ?></td>
                <td><?= $product['Status'] ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="id" value="<?= $product['ProductID'] ?>">
                        <button type="submit" name="remove">Ẩn</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Thêm sản phẩm mới</h2>
    <form method="post">
        <input type="text" name="id" placeholder="Mã sản phẩm" required>
        <input type="text" name="name" placeholder="Tên sản phẩm" required>
        <input type="text" name="img" placeholder="Ảnh URL">
        <input type="text" name="author" placeholder="Tác giả">
        <input type="text" name="publisher" placeholder="Nhà xuất bản">
        <input type="number" name="quantity" placeholder="Số lượng" required>
        <input type="number" name="ros" placeholder="ROS" required>
        <input type="text" name="description" placeholder="Mô tả">
        <input type="text" name="supplierID" placeholder="Supplier ID" required>
        <select name="status">
            <option value="Hoạt động">Hoạt động</option>
            <option value="Ẩn">Ẩn</option>
        </select>
        <button type="submit" name="add">Thêm</button>
    </form>

    <h2>Cập nhật sản phẩm</h2>
    <form method="post">
        <input type="text" name="id" placeholder="Mã sản phẩm cần sửa" required>
        <input type="text" name="name" placeholder="Tên mới">
        <input type="text" name="img" placeholder="Ảnh URL mới">
        <input type="text" name="author" placeholder="Tác giả mới">
        <input type="text" name="publisher" placeholder="Nhà xuất bản mới">
        <input type="number" name="quantity" placeholder="Số lượng mới">
        <input type="number" name="ros" placeholder="ROS mới">
        <input type="text" name="description" placeholder="Mô tả mới">
        <input type="number" name="supplierID" placeholder="Supplier ID mới">
        <select name="status">
            <option value="Hoạt động">Hoạt động</option>
            <option value="Ẩn">Ẩn</option>
        </select>
        <button type="submit" name="update">Cập nhật</button>
    </form>
</body>
</html>
