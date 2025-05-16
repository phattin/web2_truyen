<!-- sales_invoice.php -->
<div class="sales-invoice-container">
    <h2>Danh Sách Hóa Đơn Bán</h2>
    
    <div class="search-container">
        <div class="search-row">
            <select id="province-select" class="search-input">
                <option value="">Chọn tỉnh/thành phố</option>
                <!-- Các tỉnh/thành sẽ được load vào đây -->
            </select>

            <select id="district-select" class="search-input" disabled>
                <option value="">Chọn quận/huyện</option>
                <!-- Các quận/huyện sẽ được load dựa trên tỉnh/thành -->
            </select>
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
<link rel="stylesheet" href="/webbantruyen/view/layout/css/sales_invoice.css">
<script>
    if (typeof provinces === 'undefined') {
    var provinces = {
        "Hà Nội": ["Ba Đình", "Hoàn Kiếm", "Tây Hồ", "Đống Đa", "Hai Bà Trưng", "Cầu Giấy"],
        "HCM": ["Quận 1", "Quận 2", "Quận 3", "Quận 4", "Quận 5", "Quận 10"],
        "Đà Nẵng": ["Hải Châu", "Thanh Khê", "Sơn Trà", "Ngũ Hành Sơn"]
    };
}

    function populateProvinces() {
        const provinceSelect = document.getElementById("province-select");
        for (const province in provinces) {
            const option = document.createElement("option");
            option.value = province;
            option.textContent = province;
            provinceSelect.appendChild(option);
        }
    }

    function populateDistricts(province) {
        const districtSelect = document.getElementById("district-select");
        districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>'; // reset

        if (!province || !provinces[province]) {
            districtSelect.disabled = true;
            return;
        }

        provinces[province].forEach(district => {
            const option = document.createElement("option");
            option.value = district;
            option.textContent = district;
            districtSelect.appendChild(option);
        });

        districtSelect.disabled = false;
    }
    populateProvinces();
    document.getElementById("province-select").addEventListener("change", function() {
        const selectedProvince = this.value;
        populateDistricts(selectedProvince);
    });
</script>
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
    function loadInvoices(province = "", start_date = "", end_date = "", district = "") {
        console.log("Hàm loadInvoices được gọi với các tham số:", { province, start_date, end_date, district });
        
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
                province: province, 
                start_date: start_date, 
                end_date: end_date,
                district: district
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
    if(typeof statusOrder === 'undefined') {
        var statusOrder = [
            'Chưa xác nhận',
            'Đã xác nhận',
            'Đã giao thành công',
            'Đã hủy'
        ];
    }

    function updateStatus(salesID, newStatus, selectElement) {
        const currentStatus = $(selectElement).data('current-status');

        // Kiểm tra thứ tự trạng thái
        if (statusOrder.indexOf(newStatus) < statusOrder.indexOf(currentStatus)) {
            alert("Không thể cập nhật trạng thái ngược lại!");
            // Reset lại select về trạng thái cũ
            $(selectElement).val(currentStatus);
            return;
        }

        if (!confirm("Bạn có chắc muốn cập nhật trạng thái?")) {
            // Người dùng hủy thì reset về trạng thái cũ
            $(selectElement).val(currentStatus);
            return;
        }

        $.ajax({
            url: "/webbantruyen/handle/update_status.php",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify({
                sales_id: salesID,
                status: newStatus
            }),
            success: function(response) {
                alert("Cập nhật trạng thái thành công!");
                // Cập nhật lại data-current-status cho select
                $(selectElement).data('current-status', newStatus);
                // Nếu newStatus là trạng thái cuối cùng thì disable select
                if (newStatus === 'Đã giao thành công' || newStatus === 'Đã hủy') {
                    $(selectElement).prop('disabled', true);
                }
            },
            error: function(xhr, status, error) {
                alert("Lỗi khi cập nhật trạng thái!");
                console.error(error);
                // Reset lại select về trạng thái cũ nếu lỗi
                $(selectElement).val(currentStatus);
            }
        });
    }

    // Tìm kiếm hóa đơn
    function searchInvoices() {
        const provinceSelect = document.getElementById("province-select");
        const startDateInput = document.getElementById("start-date");
        const endDateInput = document.getElementById("end-date");
        const districtSelect = document.getElementById("district-select");
        
        if (provinceSelect && startDateInput && endDateInput && districtSelect) {
            const provinceValue = provinceSelect.value;
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;
            const districtValue = districtSelect.value;
            
            console.log("Đang tìm kiếm hóa đơn với các thông số:", { 
                provinceValue, 
                startDate, 
                endDate,
                districtValue 
            });
            
            loadInvoices(provinceValue, startDate, endDate, districtValue);
        }
    }

    // Đặt lại bộ lọc
    function resetFilters() {
        document.getElementById("province-select").value = "";
        document.getElementById("start-date").value = "";
        document.getElementById("end-date").value = "";
        document.getElementById("district-select").value = "";
        
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