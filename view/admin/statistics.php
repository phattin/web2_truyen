<!-- statistics.php -->
<div class="statistics-container">
    <h2>Thống Kê Doanh Thu</h2>

    <div class="filter-container">
        <form id="statistics-form">
            <div class="date-range">
                <div class="date-input">
                    <label for="start-date">Từ ngày:</label>
                    <input type="date" id="start-date" name="start-date" required>
                </div>

                <div class="date-input">
                    <label for="end-date">Đến ngày:</label>
                    <input type="date" id="end-date" name="end-date" required>
                </div>
            </div>

            <div class="quick-dates">
                <button type="button" class="date-preset" data-days="7">7 ngày qua</button>
                <button type="button" class="date-preset" data-days="30">30 ngày qua</button>
                <button type="button" class="date-preset" data-days="90">90 ngày qua</button>
                <button type="button" class="date-preset" data-month="current">Tháng này</button>
                <button type="button" class="date-preset" data-month="last">Tháng trước</button>
            </div>

            <div class="form-actions">
                <button type="submit" class="blue-btn">Xem thống kê</button>
            </div>
        </form>
    </div>

    <div id="loading-indicator" style="display: none;">
        <div class="spinner"></div>
        <p>Đang tải dữ liệu...</p>
    </div>

    <div id="statistics-result">
        <!-- Kết quả thống kê sẽ được hiển thị ở đây -->
    </div>
</div>

<link rel="stylesheet" href="/webbantruyen/view/layout/css/statistics.css">
<link rel="stylesheet" href="/webantruyen/view/layout/css/statistics2.css">

<script>
    // Đoạn mã JavaScript cho file statistics.php

    $(document).ready(function () {
        // Set default dates (last 30 days)
        function setDefaultDates() {
            const endDate = new Date();
            const startDate = new Date();
            startDate.setDate(startDate.getDate() - 30);

            $("#end-date").val(formatDate(endDate));
            $("#start-date").val(formatDate(startDate));
        }

        // Format date to YYYY-MM-DD
        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Initialize with default dates
        setDefaultDates();

        // Handle preset date buttons
        $(".date-preset").on("click", function () {
            const endDate = new Date();
            const startDate = new Date();

            if ($(this).data("days")) {
                // Last X days
                startDate.setDate(endDate.getDate() - $(this).data("days"));
            } else if ($(this).data("month") === "current") {
                // Current month
                startDate.setDate(1);
            } else if ($(this).data("month") === "last") {
                // Last month
                endDate.setDate(0); // Last day of previous month
                startDate.setMonth(endDate.getMonth());
                startDate.setDate(1);
            }

            $("#end-date").val(formatDate(endDate));
            $("#start-date").val(formatDate(startDate));
        });

        // Handle form submission
        $("#statistics-form").on("submit", function (e) {
            e.preventDefault();

            const startDate = $("#start-date").val();
            const endDate = $("#end-date").val();

            if (!startDate || !endDate) {
                alert("Vui lòng nhập đầy đủ khoảng thời gian.");
                return;
            }

            if (new Date(endDate) < new Date(startDate)) {
                alert("Ngày kết thúc phải sau ngày bắt đầu.");
                return;
            }

            // Show loading indicator
            $("#loading-indicator").show();
            $("#statistics-result").hide();

            // Send AJAX request to get statistics data
            $.ajax({
                url: "/webbantruyen/handle/getStatistics.php",
                type: "POST",
                data: { startDate, endDate },
                dataType: "html",
                success: function (response) {
                    $("#statistics-result").html(response).show();
                    $("#loading-indicator").hide();
                },
                error: function (xhr, status, error) {
                    console.error("Lỗi khi tải thống kê:", error);
                    $("#statistics-result").html("<p class='error'>Không thể tải thống kê. Vui lòng thử lại.</p>").show();
                    $("#loading-indicator").hide();
                }
            });
        });

        // Khởi tạo modal một lần và tái sử dụng
        if ($("#invoice-modal").length === 0) {
            $("body").append(`
            <div id="invoice-modal" class="modal">
                <div class="modal-content">
                    <span class="close-modal">&times;</span>
                    <div id="invoice-details-content"></div>
                </div>
            </div>
        `);
        }

        // Sự kiện đóng modal được đặt ở cấp document
        $(document).off("click", ".close-modal").on("click", ".close-modal", function () {
            $("#invoice-modal").hide();
        });

        $(document).on("click", function (event) {
            if ($(event.target).is("#invoice-modal")) {
                $("#invoice-modal").hide();
            }
        });

        // Đăng ký sự kiện cho nút ESC để đóng modal
        $(document).on("keydown", function (event) {
            if (event.key === "Escape" && $("#invoice-modal").is(":visible")) {
                $("#invoice-modal").hide();
            }
        });

        // Sự kiện toàn cục để xem chi tiết hóa đơn, sử dụng event delegation
        $(document).off("click", ".view-details").on("click", ".view-details", function (e) {
            e.preventDefault();
            const salesID = $(this).data("salesid");
            showInvoiceDetails(salesID);
        });

        // Trigger initial load with default dates
        $("#statistics-form").submit();
    });

    // Hàm toàn cục để hiển thị chi tiết hóa đơn
    function showInvoiceDetails(salesID) {
        // Show modal and load invoice details
        $("#invoice-details-content").html('<div class="spinner"></div><p>Đang tải chi tiết...</p>');
        $("#invoice-modal").show();
        
        $.ajax({
            url: "/webbantruyen/view/admin/getInvoiceDetails.php",
            type: "GET",
            data: { salesID: salesID },
            dataType: "html",
            success: function (response) {
                $("#invoice-details-content").html(response);
            },
            error: function () {
                $("#invoice-details-content").html("<p class='error'>Không thể tải chi tiết hóa đơn. Vui lòng thử lại.</p>");
            }
        });
    }
</script>