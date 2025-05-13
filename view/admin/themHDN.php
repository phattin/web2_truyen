<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<style>
    .product-add-form{
        margin: 10px auto;
        padding: 0;
    }
    .import-box {
        max-width: 1200px;
        background: #fff;
        border-radius: 12px;
        font-family: Arial, sans-serif;
        width: 100%;
        height: 100%;
    }

    .import-box-content{
        display: flex;
        gap: 20px;
        flex-wrap: nowrap;
    }

    .import-box .close-btn {
        float: right;
        background-color: red;
        color: white;
        border: none;
        font-weight: bold;
        padding: 6px 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .import-box .import-info {
        display: flex;
        justify-content: space-between;
        text-align: left;
        gap: 40px;
        margin-bottom: 20px;
    }

    .import-box-left{
        border-right: 2px solid;
    }
    .import-box-left, .import-box-right {
        width: 50%;
        padding: 20px;
        overflow: auto;
    }

    .import-box .left-info,
    .import-box .right-info {
        flex: 1;
    }

    .payment-import-list {
        margin-bottom: 20px;
        height: 300px;
        overflow-y: auto;
    }

    .import-box .import-info-item {
        margin-bottom: 15px;
    }

    .import-product-input {
        margin-bottom: 15px;
    }
    .import-box select,
    .import-box input[type="text"],
    .import-box input[type="number"] {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    .import-box .import-product-list {
        margin-bottom: 20px;
        height: 300px;
        overflow-y: auto;
    }

    .import-box .product-admin-table,
    .import-box .payment-import-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .import-box .form-content {
        display: flex;
        gap: 40px;
        margin: 20px 0;
    }

    .import-box .left-panel,
    .import-box .right-panel {
        flex: 1;
    }

    .import-box .image-upload-container label {
        display: block;
        margin-bottom: 8px;
    }

    .import-box .image-upload-container input[type="file"] {
        display: block;
        margin-bottom: 10px;
    }

    .import-box #preview {
        width: 100%;
        max-width: 200px;
        border: 1px solid #ccc;
        border-radius: 8px;
        margin-top: 10px;
    }

    .import-box .product-form-button {
        text-align: right;
        margin-top: 10px;
    }

    .import-box .product-form-button .blue-btn {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 8px 14px;
        border-radius: 6px;
        margin-left: 10px;
        cursor: pointer;
    }

    .import-box .payment-import-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        justify-content: center;
        margin: 15px 0;
    }

    .import-box .payment-btn {
        background-color: green;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .import-box .totalprice_import {
        font-weight: bold;
        color: red;
        margin-left: 10px;
    }
</style>

<div class="import-box">
    <input type="button" value="X" class="close-btn" onclick="Close_ChucNang()">
    <h2 style="text-align:center; margin-bottom:50px">Nhập hàng</h2>

    <div class="import-box-content">
        <div class="import-box-left">
            <h3 style="text-align:center; margin-bottom:30px;">Danh sách sản phẩm</h3>
            <div class="import-product-list">
                <table class='product-admin-table'>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Tác giả</th>
                        <th>Kho</th>
                        <th>Giá nhập</th>
                    </tr>
                    <?php
                    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/productDB.php";
                    foreach (productDB::getAllProduct() as $product) {
                        echo "<tr onclick='showDetailProduct(this)' id='product-row-{$product["ProductID"]}' style='cursor:pointer;'>
                                <td class='import-product-id'>{$product["ProductID"]}</td>
                                <td class='import-product-name'>{$product["ProductName"]}</td>
                                <td>{$product["Author"]}</td>
                                <td>{$product["Quantity"]}</td>
                                <td class='import-product-img' style='display:none'>{$product["ProductImg"]}</td>
                                <td class='import-product-price'>{$product["ImportPrice"]}</td>
                            </tr>";
                    }
                    ?>
                </table>
            </div>
        
            <form id="product-add-form" class="product-add-form">
                <div class="form-content">
                    <div class="left-panel">
                        <div class="image-upload-container">
                            <label for="image-upload">Hình ảnh sản phẩm:</label>
                            <img id="preview-import" src="#" alt="Xem trước" style="display:none; width: 100px;">
                        </div>
                    </div>
        
                    <div class="right-panel" style="display:block; text-align:left;">
                        <div class='import-product-input' style="margin-bottom: 0;">
                            <strong>Mã sản phẩm:</strong>
                            <span id="productID"></span>
                        </div>
                        <div class='import-product-input'>
                            <strong>Tên truyện:</strong>
                            <span id="productName"></span>
                        </div>
                        <div class='import-product-input'>
                            <label for="quantity">Số lượng:</label>
                            <input type="number" id="quantity" name="quantity" value="0" min="1" required>
                        </div>
                        <div class='import-product-input'>
                            <label for="importPrice">Giá nhập:</label>
                            <input type="number" id="importPrice" name="price" value="0" min="1" required>
                        </div>
                    </div>
                </div>
        
                <div class="product-form-button">
                    <button type="button" onclick="addProductToImportList()" id="add-product-submit-btn" class="add-product-submit-btn blue-btn">Thêm</button>
                </div>
            </form>
        </div>
        <div class="import-box-right">
            <div class="import-info">
                <div class="left-info">
                    <div class="import-info-item">
                        <strong>Mã hóa đơn nhập:</strong>
                        <span>
                            <?php 
                            require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/importDB.php";
                            $newImportID = importDB::getNewImportID();
                            echo $newImportID;
                            ?>
                        </span>
                        <input type="text" id="importID" value="<?php echo $newImportID; ?>" style="display:none;">
                    </div>
                    <div class="import-info-item">
                        <strong>Ngày nhập:</strong>
                        <span>
                            <?php
                            date_default_timezone_set('Asia/Ho_Chi_Minh');
                            $date = date('Y-m-d');
                            echo $date;
                            ?> 
                            <input type="text" id="import-date" value="<?php echo $date; ?>" style="display:none;">
                        </span>
                    </div>
                    <div class="import-info-item">
                        <strong>Nhân viên nhập:</strong>
                        <span id="import-employee">
                            <?php
                            if (isset($_SESSION['username'])) {
                                require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/employeeDB.php";
                                $username = $_SESSION['username'];
                                $employee = employeeDB::getEmployeeByUsername($username);
                                if ($employee) {
                                    echo $employee["Fullname"];
                                    echo "<input type='text' id='import-employeeID' value='".$employee['EmployeeID']."' style='display:none;'>";
                                } else {
                                    echo "Không tìm thấy nhân viên.";
                                }
                            }
                            ?>
                        </span>
                    </div>
                    <div class="import-info-item">
                        <strong>Tổng đơn:</strong>
                        <span class="totalprice_import">0</span>
                    </div>
                </div>
        
                <div class="right-info">
                    <div class="import-info-item">
                        <strong>Nhà cung cấp:</strong>
                        <select id="supplier" name="supplier">
                            <?php
                            require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/supplierDB.php";
                            foreach (supplierDB::getAllSupplier() as $supplier) {
                                echo "<option value='{$supplier["SupplierID"]}'>{$supplier["SupplierName"]}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="import-info-item">
                        <label for='import-ros'><strong>Lãi suất (%):</strong></label>
                        <input type="number" id="import-ros">
                    </div>
                </div>
            </div>
            <div class="payment-import">
                <h3 style="text-align:center; margin:30px;">Danh sách sản phẩm đã chọn</h3>
                <div class="payment-import-list">
                    <table class="payment-import-table">
                        <thead>
                            <tr>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody id="import-product-list"></tbody>
                    </table>
                </div>
        
                <div class="payment-import-btn">
                    <input type="number" id="quantity-import" style='width: 100px;'>
                    <button type='button' class='edit-quantity-btn blue-btn'>Sửa số lượng</button>
                    <button type='button' class='delete-import-btn close-btn'>Xóa</button>
                </div>
            </div>
        
            <div class="payment-import-btn">
                <button type='button' class='payment-btn'>Thanh toán</button>
            </div>
        </div>
    </div>
</div>

<script>
    function Close_ChucNang() {
        document.getElementById("overlay-chucnang").style.display = "none";
        document.getElementById("Function").style.display = "none";
    }

    const selectedProducts = {};

    function showDetailProduct(element){
        const id = element.querySelector(".import-product-id").innerText;
        const name = element.querySelector(".import-product-name").innerText;
        const img = element.querySelector(".import-product-img").innerText;
        document.getElementById("productID").innerText = id;
        document.getElementById("productName").innerText = name;
        document.getElementById("importPrice").value = element.querySelector(".import-product-price").innerText;
        document.getElementById("preview-import").src = "/webbantruyen/view/layout/images/" + img;
        document.getElementById("preview-import").style.display = "block";  

    }

    function addProductToImportList() {
        const id = document.getElementById("productID").innerText;
        const name = document.getElementById("productName").innerText;
        const quantity = parseInt(document.getElementById("quantity").value);
        const price = parseInt(document.getElementById("importPrice").value);

        if (!id || !name) {
            alert("Vui lòng chọn sản phẩm từ danh sách!");
            return;
        }

        if (isNaN(quantity) || quantity <= 0) {
            alert("Số lượng phải là số nguyên dương!");
            return;
        }

        if (isNaN(price) || price <= 0) {
            alert("Giá nhập phải là số nguyên dương!");
            return;
        }

        if (!window.selectedProducts) window.selectedProducts = {};

        if (selectedProducts[id]) {
            selectedProducts[id].quantity += quantity;
            selectedProducts[id].total = selectedProducts[id].quantity * price;

            const row = document.querySelector(`#import-product-list tr[data-id='${id}']`);
            if (row) {
                row.children[2].textContent = selectedProducts[id].quantity;
                row.children[3].textContent = price;
                row.children[4].textContent = selectedProducts[id].total;
            }
        } else {
            const total = quantity * price;
            selectedProducts[id] = {id, name, quantity, price, total };

            const newRow = document.createElement("tr");
            newRow.setAttribute("data-id", id);

            newRow.innerHTML = `
                <td>${id}</td>
                <td>${name}</td>
                <td>${quantity}</td>
                <td>${price}</td>
                <td>${total}</td>
            `;

            document.getElementById("import-product-list").appendChild(newRow);
        }

        updateTotalPrice();

        // Clear input
        document.getElementById("quantity").value = '';
        document.getElementById("importPrice").value = '';
    }

    function updateTotalPrice() {
        let total = 0;
        console.log(selectedProducts);
        for (const key in selectedProducts) {
            console.log(selectedProducts[key]);
            total += selectedProducts[key].total;
        }
        $(".totalprice_import").text(total);
    }

    let selectedRow = null;

    document.getElementById("import-product-list").addEventListener("click", function(e) {
        const row = e.target.closest("tr");
        if (!row) return;

        const id = row.getAttribute("data-id");
        selectedRow = id;

        const product = selectedProducts[id];
        if (product) {
            document.getElementById("quantity-import").value = product.quantity;
        }
    });

    document.querySelector(".edit-quantity-btn").addEventListener("click", function() {
        if (!selectedRow) {
            alert("Vui lòng chọn sản phẩm trong danh sách đã chọn để sửa.");
            return;
        }

        const newQuantity = parseInt(document.getElementById("quantity-import").value);
        if (isNaN(newQuantity) || newQuantity <= 0) {
            alert("Số lượng phải là số nguyên dương.");
            return;
        }

        selectedProducts[selectedRow].quantity = newQuantity;
        selectedProducts[selectedRow].total = newQuantity * selectedProducts[selectedRow].price;

        const row = document.querySelector(`#import-product-list tr[data-id='${selectedRow}']`);
        if (row) {
            row.children[2].textContent = newQuantity;
            row.children[4].textContent = selectedProducts[selectedRow].total;
        }

        updateTotalPrice();
        document.getElementById("quantity-import").value = '';
        selectedRow = null;
    });

    document.querySelector(".delete-import-btn").addEventListener("click", function() {
        if (!selectedRow) {
            alert("Vui lòng chọn sản phẩm để xóa.");
            return;
        }

        delete selectedProducts[selectedRow];

        const row = document.querySelector(`#import-product-list tr[data-id='${selectedRow}']`);
        if (row) {
            row.remove();
        }

        updateTotalPrice();
        document.getElementById("quantity-import").value = '';
        selectedRow = null;
    });

    $(".payment-btn").click(function () {
        const ros = parseFloat($("#import-ros").val());
        const total = parseFloat($(".totalprice_import").text());

        if ($("#import-ros").val().trim() === "") {
            alert("Vui lòng nhập lãi suất (ROS)!");
            return;
        }

        if (isNaN(ros) || ros <= 0) {
            alert("Lãi suất phải là một số dương!");
            return;
        }

        if (Object.keys(selectedProducts).length === 0 || total <= 0) {
            alert("Chưa có sản phẩm nào được chọn để nhập!");
            return;
        }

        const data = {
            importID: $("#importID").val(),
            date: $("#import-date").val(),
            employeeID: $("#import-employeeID").val(),
            supplierID: $("#supplier").val(),
            totalPrice: total,
            ros: ros,
            products: selectedProducts
        };

        console.log(data);

        $.ajax({
            url: "/webbantruyen/handle/addImport.php",
            method: "POST",
            data: { action: "import", data: JSON.stringify(data) },
            success: function (res) {
                alert("Nhập hàng thành công!");
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", {
                    status: status,
                    error: error,
                    responseText: xhr.responseText
                });

                alert("Đã xảy ra lỗi khi nhập hàng:\n\n" +
                    "Trạng thái: " + status + "\n" +
                    "Lỗi: " + error + "\n" +
                    "Chi tiết phản hồi: " + xhr.responseText);
            }
        });
    });

</script>
