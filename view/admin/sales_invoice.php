<?php
?>
<div class="sales-invoice-container">
    <h2>Danh Sách Hóa Đơn Bán</h2>

    <div class="search-container">
        <input type="text" id="search-input" class="search-input" placeholder="Tìm kiếm theo SalesID hoặc sản phẩm">
        <button id="search-btn" class="search-button blue-btn">Tìm kiếm</button>
    </div>

    <div id="invoice-list" class="invoice-list">
        <!-- Danh sách hóa đơn sẽ được tải ở đây -->
    </div>
</div>

<div id="overlay-chucnang" class="overlay-chucnang">
    <div id="Function" class="function-container">
        <!-- Chi tiết hóa đơn sẽ được tải ở đây -->
    </div>
    <button class="close-btn" onclick="closeOverlay()">X</button>
</div>