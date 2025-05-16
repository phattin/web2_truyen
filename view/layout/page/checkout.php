<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/webbantruyen/model/customerDB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/webbantruyen/model/salesInvoiceDB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/webbantruyen/model/promotionDB.php';
// Kiểm tra nếu có dữ liệu từ form
if (isset($_POST['productsCheckout']) && isset($_POST['totalAllPrice'])) {
    $productsCheckout = json_decode($_POST['productsCheckout'], true); // Chuyển chuỗi JSON thành mảng
    $totalAllPrice = $_POST['totalAllPrice'];
    $saleID = salesInvoiceDB::getIncreaseSalesInvoiceID(); // Lấy mã hóa đơn mới
}
    $customer = customerDB::getCustomerByUsername($_SESSION['username']);
    $promotions = promotionDB::getValidPromotions();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/webbantruyen/view/layout/css/checkout.css">
    <title>Thanh toán</title>
</head>
<body>
<div class="payment">
        <div class="payment-box">
            <i class="fa-solid fa-rectangle-xmark close"></i>
            <div class="payment-container">
                <h3>THÔNG TIN THANH TOÁN</h3>
                <form>
                    <div class="payment-customer-title">
                        <strong>Tên: </strong><span class="payment-customer-name"><?= $customer['Fullname'] ?></span>
                    </div>
                    <div class="payment-customer-title">
                        <strong>Email: </strong><span class="payment-customer-email"><?= $customer['Email'] ?></span>
                    </div>
                    <label for="phone-payment">Số điện thoại: <span style="color:red">(*)</span></label><br />
                    <input type="number" id="phone-payment" placeholder="Số điện thoại" value="<?= $customer['Phone'] ?>" required /><br />
                    <input type="radio" id="oldPhone" name="phoneShip" value="oldPhone" style="width: 10px" checked />
                    <label for="oldPhone">Số điện thoại của tài khoản</label> <br />
                    <input type="radio" id="newPhone" name="phoneShip" value="newPhone" style="width: 10px" />
                    <label for="newPhone">Số điện thoại khác</label><br />
                    <label>Địa chỉ: <span style="color:red">(*)</span></label><br />

                    <input type="text" id="address-payment" placeholder="Nhập địa chỉ" value="<?= $customer['Address'] ?>" required readonly /><br />

                    <input type="radio" id="oldAddress" name="AddressShip" value="oldAddress" style="width: 10px" checked />
                    <label for="oldAddress">Địa chỉ của tài khoản</label> <br />

                    <input type="radio" id="newAddress" name="AddressShip" value="newAddress" style="width: 10px" />
                    <label for="newAddress">Địa chỉ khác</label><br />

                    <!-- Phần nhập chi tiết địa chỉ khi chọn địa chỉ khác -->
                    <div id="detailed-address" style="display:none; margin-top: 10px;">

                        <label for="province">Tỉnh/Thành phố: <span style="color:red">(*)</span></label><br />
                        <select id="province" name="province">
                            <option value="">-- Chọn tỉnh/thành phố --</option>
                            <option value="Hanoi">Hà Nội</option>
                            <option value="HCM">Hồ Chí Minh</option>
                            <option value="Danang">Đà Nẵng</option>
                            <!-- Thêm tỉnh/thành khác nếu cần -->
                        </select><br />

                        <label for="district">Quận/Huyện: <span style="color:red">(*)</span></label><br />
                        <select id="district" name="district" disabled>
                            <option value="">-- Chọn quận/huyện --</option>
                        </select><br />

                        <label for="ward" style="display: none;">Phường/Xã: <span style="color:red">(*)</span></label><br />
                        <select style="display: none;" id="ward" name="ward" disabled>
                            <option value="">-- Chọn phường/xã --</option>
                        </select><br />

                        <label for="specific-address">Địa chỉ cụ thể: <span style="color:red">(*)</span></label><br />
                        <input type="text" id="specific-address" placeholder="Nhập địa chỉ cụ thể" /><br />
                    </div>
                    <label for="note-payment">Ghi chú đơn hàng (tùy chọn)</label> <br />
                    <textarea id="note-payment"
                        placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay địa chỉ giao hàng chi tiết"></textarea>
                </form>
            </div>

            <form class="order-summary">
                <table class="payment-table">
                    <thead>
                        <tr style="border-bottom: 1px solid #ddd">
                            <th colspan="2" class="payment-heading">ĐƠN HÀNG CỦA BẠN</th>
                            <th>
                                <strong>Ngày đặt:
                                    <span class="payment-date"><?= date("Y-m-d") ?></span></strong>
                            </th>
                        </tr>
                        <tr class="order-header">
                            <th colspan="2"><strong>SẢN PHẨM</strong></th>
                            <th><strong>TẠM TÍNH</strong></th>
                        </tr>
                        <tr style="border-bottom: 1px solid #ddd">
                            <th class="payment-product-name">Tên sản phẩm</th>
                            <th class="payment-quantity">Số lượng</th>
                            <th class="payment-price"></th>
                        </tr>
                    </thead>
                    <tbody>
<?php
                        // Lặp qua từng sản phẩm trong giỏ hàng và hiển thị thông tin
                        foreach ($productsCheckout as $product) {
                            $productName = htmlspecialchars($product['name']);
                            $productQuantity = htmlspecialchars($product['quantity']);
                            $productPrice = htmlspecialchars($product['price']);
                            $totalPrice = htmlspecialchars($product['totalPrice']);
                        ?>
                            <tr class="payment-product-item">
                                <td class="payment-product-name"><?= $productName ?></td>
                                <td class="payment-quantity"><?= $productQuantity ?></td>
                                <td class="payment-price"><?= $totalPrice ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr style="border-top: 1px solid #ddd">
                            <td colspan="2">Tổng tạm tính:</td>
                            <td>
                                <span class="payment-total-product-price-value"><?= $totalAllPrice ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Khuyến mãi:</td>
                            <td colspan="2">
                                <select id="selectKhuyenMai" onchange="chonKhuyenMai()">
                                    <?php foreach ($promotions as $promo): ?>
                                        <option 
                                            value="<?= $promo['PromotionID'] ?>" 
                                            data-name="<?= $promo['PromotionName'] ?>" 
                                            data-discount="<?= $promo['Discount'] ?>"
                                        >
                                            <?= $promo['PromotionName'] ?> (Giảm <?= $promo['Discount'] ?>%)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Tổng đơn:</td>
                            <td>
                                <span class="payment-total-price-value"><?= $totalAllPrice ?></span>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <h3>Phương thức thanh toán</h3>
                <div>
                    <input type="radio" id="cash-on-delivery" name="payment" value="Tiền mặt" checked/>
                    <label for="cash-on-delivery">Thanh toán khi nhận hàng</label>
                </div>
                <div>
                    <input type="radio" id="atm-payment" name="payment" value="Đã chuyển khoản" />
                    <label for="atm-payment">Thanh toán bằng ATM</label>
                    <div id="atm-options">
                        <label for="bank">Chọn ngân hàng:</label>
                        <select id="bank">
                            <option value="">Chọn ngân hàng</option>
                            <option value="vietcombank">Vietcombank</option>
                            <option value="techcombank">Techcombank</option>
                            <option value="vpbank">VPBank</option>
                            <option value="agribank">Agribank</option>
                        </select>
                        <br /><br />
                        <label for="card-number">Số thẻ:</label>
                        <input type="number" id="card-number" placeholder="Nhập số thẻ ATM" required />
                    </div>
                </div>
                <div class="payment-submit-background">
                    <button type="submit" class="submit-payment-btn">Thanh toán</button>
                </div>
            </form>
        </div>
    </div>
    <script src="/webbantruyen/view/layout/js/jquery-3.7.1.min.js"></script>
    <script>
        const addressInput = document.getElementById("address-payment");
        const oldAddressRadio = document.getElementById("oldAddress");
        const newAddressRadio = document.getElementById("newAddress");
        const detailedAddressDiv = document.getElementById("detailed-address");

        const customerAddress = "<?= $customer['Address'] ?>"; // Địa chỉ của tài khoản

        function updateAddressInput() {
            if (oldAddressRadio.checked) {
                // Địa chỉ của tài khoản
                addressInput.value = customerAddress;
                addressInput.readOnly = true;
                detailedAddressDiv.style.display = "none";
                addressInput.style.display = "block";

                // Reset các select input chi tiết địa chỉ
                document.getElementById("province").value = "";
                document.getElementById("district").innerHTML = '<option value="">-- Chọn quận/huyện --</option>';
                document.getElementById("district").disabled = true;
                document.getElementById("ward").innerHTML = '<option value="">-- Chọn phường/xã --</option>';
                document.getElementById("ward").disabled = true;
                document.getElementById("specific-address").value = "";

            } else {
                // Địa chỉ khác
                addressInput.style.display = "none";
                addressInput.value = "";
                addressInput.readOnly = false;
                detailedAddressDiv.style.display = "block";
            }
        }

        // Gọi khi trang tải lần đầu
        updateAddressInput();

        // Lắng nghe sự kiện thay đổi radio
        oldAddressRadio.addEventListener("change", updateAddressInput);
        newAddressRadio.addEventListener("change", updateAddressInput);

        // --- Ví dụ load quận/huyện theo tỉnh ---
        // Dữ liệu mẫu để demo, bạn thay bằng dữ liệu thực tế hoặc ajax call nếu cần
        const districtsByProvince = {
            Hanoi: ["Ba Đình", "Hoàn Kiếm", "Đống Đa", "Cầu Giấy"],
            HCM: ["Quận 1", "Quận 3", "Quận 10", "Bình Thạnh"],
            Danang: ["Hải Châu", "Thanh Khê", "Liên Chiểu"]
        };

        const wardsByDistrict = {
            "Ba Đình": ["Phúc Xá", "Trúc Bạch", "Vĩnh Phúc"],
            "Hoàn Kiếm": ["Phúc Tân", "Hàng Trống", "Hàng Bạc"],
            "Đống Đa": ["Ô Chợ Dừa", "Kim Liên", "Khâm Thiên"],
            "Cầu Giấy": ["Dịch Vọng", "Nghĩa Đô", "Yên Hòa"],

            "Quận 1": ["Bến Nghé", "Bến Thành", "Cầu Ông Lãnh"],
            "Quận 3": ["Ward 1", "Ward 2", "Ward 3"],
            "Quận 10": ["Ward 10-1", "Ward 10-2"],
            "Bình Thạnh": ["Ward B1", "Ward B2"],

            "Hải Châu": ["Thạch Thang", "Hải Châu 1"],
            "Thanh Khê": ["Thanh Khê Đông", "Thanh Khê Tây"],
            "Liên Chiểu": ["Hòa Khánh Bắc", "Hòa Khánh Nam"]
        };

        const provinceSelect = document.getElementById("province");
        const districtSelect = document.getElementById("district");
        const wardSelect = document.getElementById("ward");

        // Khi chọn tỉnh/thành
        provinceSelect.addEventListener("change", () => {
            const province = provinceSelect.value;
            if (province && districtsByProvince[province]) {
                districtSelect.disabled = false;
                districtSelect.innerHTML = '<option value="">-- Chọn quận/huyện --</option>';
                districtsByProvince[province].forEach(district => {
                    const opt = document.createElement("option");
                    opt.value = district;
                    opt.textContent = district;
                    districtSelect.appendChild(opt);
                });
            } else {
                districtSelect.disabled = true;
                districtSelect.innerHTML = '<option value="">-- Chọn quận/huyện --</option>';
                wardSelect.disabled = true;
                wardSelect.innerHTML = '<option value="">-- Chọn phường/xã --</option>';
            }
            wardSelect.disabled = true;
            wardSelect.innerHTML = '<option value="">-- Chọn phường/xã --</option>';
        });

        // Khi chọn quận/huyện
        districtSelect.addEventListener("change", () => {
            const district = districtSelect.value;
            if (district && wardsByDistrict[district]) {
                wardSelect.disabled = false;
                wardSelect.innerHTML = '<option value="">-- Chọn phường/xã --</option>';
                wardsByDistrict[district].forEach(ward => {
                    const opt = document.createElement("option");
                    opt.value = ward;
                    opt.textContent = ward;
                    wardSelect.appendChild(opt);
                });
            } else {
                wardSelect.disabled = true;
                wardSelect.innerHTML = '<option value="">-- Chọn phường/xã --</option>';
            }
        });
        
        const COD = document.querySelector("#cash-on-delivery");
        const atmOptions = document.getElementById("atm-options");
        const atmPayment = document.querySelector("#atm-payment");
        
        atmPayment.addEventListener("click", togglePaymentOptions);
        function togglePaymentOptions() {
            atmOptions.style.display = "block";
        }
        
        COD.addEventListener("click", toggleCOD);
        function toggleCOD() {
            atmOptions.style.display = "none";
        }

        //Lua chon sdt
        
        const phoneInput = document.getElementById("phone-payment");
        const oldPhoneRadio = document.getElementById("oldPhone");
        const newPhoneRadio = document.getElementById("newPhone");
        console.log(oldPhoneRadio, newPhoneRadio);
        const customerPhone = "<?= $customer['Phone'] ?>"; // Lấy số điện thoại từ PHP


        function updatePhoneInput() {
            if (oldPhoneRadio.checked) {
                phoneInput.value = customerPhone;
                phoneInput.readOnly = true;
            } else {
                phoneInput.value = "";
                phoneInput.readOnly = false;
            }
        }

        // Gọi khi trang tải lần đầu
        updatePhoneInput();

        // Lắng nghe sự kiện thay đổi radio
        oldPhoneRadio.addEventListener("change", updatePhoneInput);
        newPhoneRadio.addEventListener("change", updatePhoneInput);

        // //Lua chon address
        // console.log(oldAddressRadio, newAddressRadio);
        // const customerAddress = "<?= $customer['Address'] ?>"; // Lấy số điện thoại từ PHP


        // function updateAddressInput() {
        //     if (oldAddressRadio.checked) {
        //         addressInput.value = customerAddress;
        //         addressInput.readOnly = true;
        //     } else {
        //         addressInput.value = "";
        //         addressInput.readOnly = false;
        //     }
        // }

        // Gọi khi trang tải lần đầu
        updateAddressInput();

        // Lắng nghe sự kiện thay đổi radio
        oldAddressRadio.addEventListener("change", updateAddressInput);
        newAddressRadio.addEventListener("change", updateAddressInput);

        function chonKhuyenMai() {
            var select = document.getElementById("selectKhuyenMai");
            var selectedOption = select.options[select.selectedIndex];
            var discountPercent = parseFloat(selectedOption.text.match(/(\d+)%/)[1]); // Lấy phần trăm giảm từ chuỗi
            var promotionID = selectedOption.value;

            var totalElement = document.querySelector(".payment-total-product-price-value");
            var total = parseFloat(totalElement.innerText.replace(/\./g, '')); // Bỏ dấu chấm rồi parse số

            var discountAmount = total * (discountPercent / 100);
            var finalTotal = Math.round(total - discountAmount);

            // Cập nhật tổng đơn sau khuyến mãi
            document.querySelector(".payment-total-price-value").innerText = numberWithDots(finalTotal) + " VND";

            // Lưu ID khuyến mãi nếu cần
            var promotionIDElement = document.getElementById("idKhuyenMai");
            if (!promotionIDElement) {
                promotionIDElement = document.createElement("span");
                promotionIDElement.id = "idKhuyenMai";
                promotionIDElement.style.display = "none";
                document.body.appendChild(promotionIDElement);
            }
            promotionIDElement.innerText = promotionID;
        }

        // Hàm format số có dấu chấm phân cách hàng nghìn
        function numberWithDots(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

    </script>
    <script>
        $(document).on("click",'.submit-payment-btn', function (event) {
        event.preventDefault();
        // Lấy giá trị 
        const provinceSelect = document.getElementById("province");
        const districtSelect = document.getElementById("district");
        const detailAddressInput = document.getElementById("specific-address");
        const oldAddressRadio = document.getElementById("oldAddress");
        const newAddressRadio = document.getElementById("newAddress");
        if ((provinceSelect.value === "" || districtSelect.value === "" || detailAddressInput.value === "") && newAddressRadio.checked) {
            alert("Vui lòng nhập đầy đủ địa chỉ");
            return;
        }
        const salesID = "<?= $saleID ?>"; // Lấy mã hóa đơn từ PHP
        const phone = document.getElementById("phone-payment").value;
        const address = document.getElementById("address-payment").value;
        const note = document.getElementById("note-payment").value || '';
        const paymentMethod = document.querySelector('input[name="payment"]:checked').value;
        const totalPrice = parseFloat( document.querySelector(".payment-total-price-value").innerText.replace(/\./g, ''))
        const date = document.querySelector(".payment-date").innerText;
        const select = document.getElementById("selectKhuyenMai");
        const selectedOption = select.options[select.selectedIndex];
        const promotionID = selectedOption.value;
        const customerID = "<?= $customer['CustomerID'] ?>"; // Lấy mã khách hàng từ PHP
        const address2 = detailAddressInput.value + ", " + districtSelect.value + ", " + provinceSelect.value;

        // Kiểm tra xem tất cả các trường đã được điền chưa
        if (phone === "") {
            alert("Vui lòng điền đầy đủ thông tin!");
            return;
        }
        if (oldAddressRadio.checked && address === "") {
            alert("Vui lòng điền đầy đủ thông tin!");
            return;
        }
        const regex = /^[0-9]{10}$/; // Kiểm tra định dạng số điện thoại
        if (!regex.test(phone)) {
            alert("Số điện thoại không hợp lệ! Vui lòng nhập lại.");
            return;
        }
        // Gửi dữ liệu đến server bằng AJAX
        $.ajax({
            url: "/webbantruyen/handle/checkoutHandle.php",
            type: "POST",
            data: {
                salesID: salesID,
                productsCheckout: JSON.stringify(<?= json_encode($productsCheckout) ?>),
                totalPrice: totalPrice,
                phone: phone,
                address: oldAddressRadio.checked ? address : address2,
                note: note,
                paymentMethod: paymentMethod,
                date: date,
                promotionID: promotionID,
                customerID: customerID
            },
            success: function (response) {
                // Xử lý phản hồi từ server nếu cần
                let res;
                try {
                    res = JSON.parse(response); // <-- Parse JSON string thành object
                } catch (e) {
                    console.error("Phản hồi không phải JSON hợp lệ:", response);
                    alert("Có lỗi xảy ra! Vui lòng thử lại.");
                    return;
                }
                console.log("Dữ liệu đã gửi:", res.data);
                if (res.success){
                    alert("Đặt hàng thành công!");
                    
                    window.location.href = "/webbantruyen/view/layout/page/bills.php";
                }
                else{
                    alert("Đặt hàng thất bại! Vui lòng thử lại.");
                    console.error(res.success);
                    console.error(res.message); // In lỗi ra console để kiểm tra
                }
                
                // window.location.href = "index.php?page=home"; // Chuyển hướng về trang chủ sau khi đặt hàng thành công
            },
            error: function (xhr, status, error) {
                console.error("Lỗi:", error);
                console.log("Phản hồi từ server:", xhr.responseText);
                alert("Có lỗi xảy ra trong quá trình đặt hàng. Vui lòng thử lại.");
            }
        });
    });
        
    </script>
</body>
</html>
