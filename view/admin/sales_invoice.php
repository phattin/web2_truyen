<?php
?>
<div class="overlay-chucnang">
    <input type="button" value="X" class="close-btn" onclick="Close_ChucNang()">
    <h2 style="text-align:center; margin:30px;">Danh Sách Hóa Đơn Bán</h2>

    <div class="search-container">
        <form id="search-form" method="GET">
            <input type="text" name="search" id="search-input" class="search-input" placeholder="Tìm kiếm theo SalesID, sản phẩm">
            <button type="button" id="search-btn" class="search-button blue-btn">Tìm kiếm</button>
        </form>
    </div>

    <div id="invoice-list" class="invoice-list">
        <!-- Danh sách hóa đơn sẽ được tải động tại đây -->
    </div>
</div>

<div class="sales-invoice-container">
    <h2>Danh Sách Hóa Đơn Bán</h2>
    <table>
        <thead>
            <tr>
                <th>SalesID</th>
                <th>Ngày</th>
                <th>Địa chỉ</th>
                <th>Điện thoại</th>
                <th>Tổng tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once($_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/order_history_utils.php");
            $conn = connectToDatabase();
            $result = $conn->query("SELECT * FROM sales_invoice");

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['SalesID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Address']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Phone']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Total']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Không có hóa đơn nào.</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<script>
    // Hàm đóng overlay
    function Close_ChucNang() {
        document.getElementById("overlay-chucnang").style.display = "none";
        document.getElementById("Function").style.display = "none";
    }

    // Hàm tải danh sách hóa đơn
    function loadInvoices(search = "") {
        $.ajax({
            url: "/webbantruyen/handle/getSalesInvoices.php", // File xử lý lấy danh sách hóa đơn
            type: "POST",
            data: { search: search },
            dataType: "html",
            success: function (response) {
                $("#invoice-list").html(response);
            },
            error: function (xhr, status, error) {
                console.error("Lỗi khi tải danh sách hóa đơn:", error);
                $("#invoice-list").html("<p>Không thể tải danh sách hóa đơn.</p>");
            }
        });
    }

    // Xử lý sự kiện tìm kiếm
    $("#search-btn").on("click", function () {
        const search = $("#search-input").val().trim();
        loadInvoices(search);
    });

    // Tải danh sách hóa đơn khi mở overlay
    $(document).ready(function () {
        loadInvoices(); // Tải danh sách hóa đơn mặc định
    });
</script>