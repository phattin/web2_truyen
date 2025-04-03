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
                        <strong>Tên: </strong><span class="payment-customer-name">Nguyễn Văn A</span>
                    </div>
                    <div class="payment-customer-title">
                        <strong>Email: </strong><span class="payment-customer-email">asd@</span>
                    </div>
                    <label for="phone-payment">Số điện thoại:</label><br />
                    <input type="number" id="phone-payment" placeholder="Số điện thoại" required /><br />
                    <label for="address-payment">Địa chỉ: (Nếu thay đổi địa chỉ vui lòng nhập lại)</label><br />
                    <input type="text" id="address-payment" placeholder="Nhập địa chỉ" required /><br />
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
                                    <span class="payment-date">22/09/2005</span></strong>
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
                    <tbody></tbody>
                    <tfoot>
                        <tr style="border-top: 1px solid #ddd">
                            <td colspan="2">Tổng tạm tính:</td>
                            <td>
                                <span class="payment-total-product-price-value">1.200.200</span><sup>đ</sup>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Giao hàng:</td>
                            <td>Giao hàng miễn phí</td>
                        </tr>
                        <tr>
                            <td colspan="2">Tổng đơn:</td>
                            <td>
                                <span class="payment-total-price-value">12.000.0000</span><sup>đ</sup>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <h3>Phương thức thanh toán</h3>
                <div>
                    <input type="radio" id="cash-on-delivery" name="payment" value="tm" />
                    <label for="cash-on-delivery">Thanh toán khi nhận hàng</label>
                </div>
                <div>
                    <input type="radio" id="atm-payment" name="payment" value="atm" />
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
    <script src="../js/checkout.js"></script>
</body>
</html>
