<link rel="stylesheet" href="/webbantruyen/view/layout/css/bills.css">
<div class="overlay bill-overlay">
    <div class="bills-box">
        <i class="fa-solid fa-rectangle-xmark close"></i>
        <form class="order-summary">
            <table class="bills-table">
                <thead>
                    <tr style="border-bottom: 1px solid #ddd">
                        <th colspan="2" class="bills-heading">Hóa đơn</th>
                        <th>
                            <strong>Ngày đặt:
                                <span class="bills-date">2025-04-04</span></strong>
                        </th>
                    </tr>
                    <tr class="order-header">
                        <th colspan="2"><strong>SẢN PHẨM</strong></th>
                        <th><strong>TẠM TÍNH</strong></th>
                    </tr>
                    <tr style="border-bottom: 1px solid #ddd">
                        <th class="bills-product-name">Tên sản phẩm</th>
                        <th class="bills-quantity">Số lượng</th>
                        <th class="bills-price"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bills-product-item">
                        <td class="bills-product-name">Sản phẩm A</td>
                        <td class="bills-quantity">2</td>
                        <td class="bills-price">200,000 VND</td>
                    </tr>
                    <tr class="bills-product-item">
                        <td class="bills-product-name">Sản phẩm B</td>
                        <td class="bills-quantity">1</td>
                        <td class="bills-price">150,000 VND</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr style="border-top: 1px solid #ddd">
                        <td colspan="2">Tổng tạm tính:</td>
                        <td>
                            <span class="bills-total-product-price-value">350,000 VND</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Khuyến mãi:</td>
                        <td id="idKhuyenMai" style="display: none;">PR00</td>
                        <td id="tenKhuyenMai">Không</td>
                    </tr>
                    <tr>
                        <td colspan="2">Tổng đơn:</td>
                        <td>
                            <span class="bills-total-price-value">350,000 VND</span>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <h3>Phương thức thanh toán</h3>
            <div>
                <input type="radio" id="cash-on-delivery" name="bills" value="Tiền mặt" checked/>
                <label for="cash-on-delivery">Thanh toán khi nhận hàng</label>
            </div>
            <div>
                <input type="radio" id="atm-bills" name="bills" value="Đã chuyển khoản" />
                <label for="atm-bills">Thanh toán bằng ATM</label>
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
            <div class="bills-submit-background">
                <button type="submit" class="submit-bills-btn">Thanh toán</button>
            </div>
        </form>
    </div>
</div>
