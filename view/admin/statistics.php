<!-- statistics.php - Updated with button removal -->
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
    $(".date-preset").on("click", function() {
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
                
                // Add event handlers for detail links
                $(".view-details").on("click", function(e) {
                    e.preventDefault();
                    const salesID = $(this).data("salesid");
                    showInvoiceDetails(salesID, this);
                    
                    // Remove the clicked "Xem chi tiết" link
                    $(this).remove();
                });
            },
            error: function (xhr, status, error) {
                console.error("Lỗi khi tải thống kê:", error);
                $("#statistics-result").html("<p class='error'>Không thể tải thống kê. Vui lòng thử lại.</p>").show();
                $("#loading-indicator").hide();
            }
        });
    });
    
    // Function to show invoice details in a modal
    function showInvoiceDetails(salesID, element) {
        // Create modal if it doesn't exist
        if ($("#invoice-modal").length === 0) {
            $("body").append(
                `<div id="invoice-modal" class="modal">
                    <div class="modal-content">
                        <span class="close-modal">&times;</span>
                        <div id="invoice-details-content"></div>
                    </div>
                </div>
                <style>
                    .modal {
                        display: none;
                        position: fixed;
                        z-index: 1000;
                        left: 0;
                        top: 0;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(0,0,0,0.5);
                    }
                    .modal-content {
                        background-color: white;
                        margin: 5% auto;
                        padding: 20px;
                        border-radius: 8px;
                        width: 80%;
                        max-width: 800px;
                        max-height: 80vh;
                        overflow-y: auto;
                    }
                    .close-modal {
                        color: #aaa;
                        float: right;
                        font-size: 28px;
                        font-weight: bold;
                        cursor: pointer;
                    }
                    .close-modal:hover {
                        color: black;
                    }
                </style>`
            );

            // Close modal when clicking X or outside modal
            $(".close-modal").on("click", function() {
                $("#invoice-modal").hide();
            });
            $(window).on("click", function(event) {
                if ($(event.target).is("#invoice-modal")) {
                    $("#invoice-modal").hide();
                }
            });
        }

        // Show modal and load invoice details
        $("#invoice-details-content").html('<div class="spinner"></div><p>Đang tải chi tiết...</p>');
        $("#invoice-modal").show();

        $.ajax({
            url: "/webbantruyen/view/admin/getInvoiceDetails.php",
            type: "GET",
            data: { salesID: salesID },
            dataType: "html",
            success: function(response) {
                $("#invoice-details-content").html(response);
            },
            error: function() {
                $("#invoice-details-content").html("<p class='error'>Không thể tải chi tiết hóa đơn. Vui lòng thử lại.</p>");
            }
        });
    }
    
    // Trigger initial load with default dates
    $("#statistics-form").submit();
});
</script>