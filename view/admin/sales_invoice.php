<!-- sales_invoice.php -->
<div class="sales-invoice-container">
    <h2>Danh Sách Hóa Đơn Bán</h2>
    
    <div class="search-container">
        <div class="search-row">
            <input type="text" id="search-input" class="search-input" placeholder="Tìm kiếm theo mã hóa đơn, tên khách hàng hoặc tên sản phẩm">
            <input type="text" id="address-input" class="search-input" placeholder="Tìm kiếm theo địa chỉ">
        </div>
        <div class="date-row">
            <div class="date-input-group">
                <label for="start-date">Từ ngày:</label>
                <input type="date" id="start-date" class="date-input">
            </div>
            <div class="date-input-group">
                <label for="end-date">Đến ngày:</label>
                <input type="date" id="end-date" class="date-input">
            </div>
            <button id="search-btn" class="search-button blue-btn">Tìm kiếm</button>
            <button id="reset-btn" class="reset-button">Đặt lại</button>
        </div>
    </div>
    
    <div id="invoice-list" class="invoice-list">
        <!-- Danh sách hóa đơn sẽ được tải ở đây -->
        <div class="loading">Đang tải dữ liệu...</div>
    </div>
</div>

<style>
.search-container {
    margin-bottom: 20px;
}

.search-row, .date-row {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
    align-items: center;
}

.search-input, .date-input {
    flex-grow: 1;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.date-input-group {
    display: flex;
    align-items: center;
    gap: 5px;
}

.date-input-group label {
    white-space: nowrap;
}

.search-button, .reset-button {
    padding: 8px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.search-button.blue-btn {
    background-color: #007bff;
    color: white;
}

.reset-button {
    background-color: #6c757d;
    color: white;
}

.search-button:hover, .reset-button:hover {
    opacity: 0.9;
}

/* Thêm style cho nút in */
.btn-print {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
}

.btn-print:hover {
    background-color: #218838;
}
</style>

<script>
// Kiểm tra nếu jQuery tồn tại
if (typeof jQuery === 'undefined') {
    console.error("jQuery không được tìm thấy. Vui lòng thêm thư viện jQuery vào trang web.");
    document.getElementById("invoice-list").innerHTML = "<p class='error'>Lỗi: jQuery không được tìm thấy!</p>";
} else {
    // Hàm in hóa đơn
    function printInvoice(salesID) {
        // Mở cửa sổ mới để in hóa đơn
        const printWindow = window.open(`/webbantruyen/handle/printInvoice.php?salesID=${encodeURIComponent(salesID)}`, '_blank', 'width=800,height=600');
        
        if (!printWindow) {
            alert('Trình duyệt đã chặn cửa sổ popup. Vui lòng cho phép popup để in hóa đơn.');
            return;
        }
        
        // Tự động in khi cửa sổ được load
        printWindow.onload = function() {
            // Bạn có thể comment dòng này nếu không muốn tự động mở hộp thoại in
            // printWindow.print();
        };
    }

    // Hiển thị danh sách hóa đơn
    function loadInvoices(search = "", start_date = "", end_date = "", address = "") {
        console.log("Hàm loadInvoices được gọi với các tham số:", { search, start_date, end_date, address });
        
        const invoiceList = document.getElementById("invoice-list");
        if (!invoiceList) {
            console.error("Không tìm thấy phần tử #invoice-list trong DOM.");
            return;
        }
        
        invoiceList.innerHTML = "<div class='loading'>Đang tải dữ liệu...</div>";
        
        // Thực hiện AJAX request
        $.ajax({
            url: "/webbantruyen/handle/getSalesInvoices.php",
            type: "GET",
            data: { 
                search: search, 
                start_date: start_date, 
                end_date: end_date,
                address: address
            },
            dataType: "html",
            success: function(response) {
                console.log("Phản hồi từ server nhận được thành công");
                
                // Kiểm tra nếu response trống hoặc không hợp lệ
                if (!response || response.trim() === "") {
                    invoiceList.innerHTML = "<p class='no-results'>Không có dữ liệu hóa đơn nào được trả về.</p>";
                    return;
                }
                
                // Cập nhật nội dung
                invoiceList.innerHTML = response;
                
                // Gắn sự kiện cho các nút in
                const printButtons = document.querySelectorAll('.btn-print');
                printButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const salesID = this.getAttribute('data-sales-id');
                        printInvoice(salesID);
                    });
                });
            },
            error: function(xhr, status, error) {
                console.error("Lỗi AJAX khi tải danh sách hóa đơn:", error);
                console.error("Mã trạng thái:", xhr.status);
                console.error("Phản hồi:", xhr.responseText);
                
                invoiceList.innerHTML = "<p class='error'>Không thể tải danh sách hóa đơn. Lỗi: " + error + "</p>";
            },
            complete: function() {
                console.log("Yêu cầu AJAX đã hoàn thành");
            }
        });
    }

    // Tìm kiếm hóa đơn
    function searchInvoices() {
        const searchInput = document.getElementById("search-input");
        const startDateInput = document.getElementById("start-date");
        const endDateInput = document.getElementById("end-date");
        const addressInput = document.getElementById("address-input");
        
        if (searchInput && startDateInput && endDateInput && addressInput) {
            const searchValue = searchInput.value.trim();
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;
            const addressValue = addressInput.value.trim();
            
            console.log("Đang tìm kiếm hóa đơn với các thông số:", { 
                searchValue, 
                startDate, 
                endDate,
                addressValue 
            });
            
            loadInvoices(searchValue, startDate, endDate, addressValue);
        }
    }

    // Đặt lại bộ lọc
    function resetFilters() {
        document.getElementById("search-input").value = "";
        document.getElementById("start-date").value = "";
        document.getElementById("end-date").value = "";
        document.getElementById("address-input").value = "";
        
        // Tải lại danh sách hóa đơn ban đầu
        loadInvoices();
    }

    // Khi tài liệu đã sẵn sàng
    $(document).ready(function() {
        console.log("DOM đã sẵn sàng");
        
        // Tự động tải danh sách hóa đơn
        loadInvoices();
        
        // Gắn sự kiện tìm kiếm
        $("#search-btn").on("click", function() {
            console.log("Nút tìm kiếm được nhấn");
            searchInvoices();
        });

        // Gắn sự kiện đặt lại bộ lọc
        $("#reset-btn").on("click", function() {
            console.log("Nút đặt lại được nhấn");
            resetFilters();
        });
        
        // Xử lý sự kiện nhấn Enter trong các ô tìm kiếm
        $("#search-input, #address-input, #start-date, #end-date").on("keypress", function(e) {
            if (e.which === 13) {
                console.log("Phím Enter được nhấn trong ô tìm kiếm");
                e.preventDefault();
                searchInvoices();
            }
        });
    });

    // Đảm bảo các hàm có sẵn trong phạm vi toàn cục
    window.loadInvoices = loadInvoices;
    window.searchInvoices = searchInvoices;
    window.resetFilters = resetFilters;
    window.printInvoice = printInvoice;
}
</script>