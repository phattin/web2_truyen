//HoaDon.js
if (typeof jQuery === 'undefined') {
    console.error("jQuery không được tìm thấy. Vui lòng thêm thư viện jQuery vào trang web.");
    document.getElementById("invoice-list").innerHTML = "<p class='error'>Lỗi: jQuery không được tìm thấy!</p>";
} else {
    // Hiển thị danh sách hóa đơn
    function loadInvoices(search = "") {
        console.log("Hàm loadInvoices được gọi với tham số search:", search);
        
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
            data: { search: search },
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
                
                // Kiểm tra nếu vẫn hiển thị "Đang tải dữ liệu..."
                if (invoiceList.innerText.includes("Đang tải dữ liệu...")) {
                    console.error("Dữ liệu đã được tải nhưng vẫn hiển thị 'Đang tải dữ liệu...'");
                }
            },
            error: function(xhr, status, error) {
                console.error("Lỗi AJAX khi tải danh sách hóa đơn:", error);
                console.error("Mã trạng thái:", xhr.status);
                console.error("Phản hồi:", xhr.responseText);
                
                invoiceList.innerHTML = "<p class='error'>Không thể tải danh sách hóa đơn. Lỗi: " + error + "</p>";
            },
            complete: function() {
                console.log("Yêu cầu AJAX đã hoàn thành");
                
                // Thêm sự kiện cho các nút xem chi tiết (nếu có)
                const viewButtons = document.querySelectorAll(".btn-view-invoice");
                if (viewButtons.length > 0) {
                    viewButtons.forEach(function(button) {
                        button.addEventListener("click", function() {
                            const salesID = this.getAttribute("data-sales-id");
                            viewInvoiceDetails(salesID);
                        });
                    });
                }
            }
        });
    }

    // Xem chi tiết hóa đơn
    function viewInvoiceDetails(salesID) {
        console.log("Đang xem chi tiết hóa đơn:", salesID);
        
        const overlay = document.getElementById("overlay-chucnang");
        const functionContainer = document.getElementById("Function");
        
        if (!overlay || !functionContainer) {
            console.error("Không tìm thấy phần tử overlay hoặc function container");
            return;
        }
        
        overlay.style.display = "block";
        functionContainer.innerHTML = "<div class='loading'>Đang tải chi tiết hóa đơn...</div>";
        
        $.ajax({
            url: "/webbantruyen/view/admin/getInvoiceDetails.php",
            type: "POST",
            data: { salesID: salesID },
            dataType: "html",
            success: function(response) {
                functionContainer.innerHTML = response;
            },
            error: function(xhr, status, error) {
                console.error("Lỗi khi tải chi tiết hóa đơn:", error);
                functionContainer.innerHTML = "<p class='error'>Không thể tải chi tiết hóa đơn: " + error + "</p>";
            }
        });
    }

    // In hóa đơn
    function printInvoice(salesID) {
        if (!salesID) {
            console.error("Không có SalesID để in hóa đơn");
            return;
        }
        
        console.log("Đang in hóa đơn:", salesID);
        
        // Mở cửa sổ in hóa đơn
        const printWindow = window.open(`/webbantruyen/handle/printInvoice.php?salesID=${salesID}`, '_blank');
        
        if (!printWindow) {
            alert("Trình duyệt đã chặn cửa sổ pop-up. Vui lòng cho phép pop-up cho trang web này.");
        }
    }

    // Đóng overlay
    function closeOverlay() {
        const overlay = document.getElementById("overlay-chucnang");
        if (overlay) {
            overlay.style.display = "none";
        }
    }

    // Tìm kiếm hóa đơn
    function searchInvoices() {
        const searchInput = document.getElementById("search-input");
        if (searchInput) {
            const searchValue = searchInput.value.trim();
            console.log("Đang tìm kiếm hóa đơn với từ khóa:", searchValue);
            loadInvoices(searchValue);
        }
    }

    // Xử lý khi trang đã sẵn sàng
    $(document).ready(function() {
        console.log("DOM đã sẵn sàng");
        
        // Nếu đang ở trang hóa đơn, tự động tải danh sách
        if (document.getElementById("invoice-list")) {
            console.log("Trang hóa đơn được phát hiện, bắt đầu tải danh sách");
            loadInvoices();
            
            // Gắn sự kiện tìm kiếm
            $("#search-btn").on("click", function() {
                console.log("Nút tìm kiếm được nhấn");
                searchInvoices();
            });
            
            $("#search-input").on("keypress", function(e) {
                if (e.which === 13) {
                    console.log("Phím Enter được nhấn trong ô tìm kiếm");
                    e.preventDefault();
                    searchInvoices();
                }
            });
            
            // Gắn sự kiện đóng overlay
            $(".close-btn").on("click", function() {
                closeOverlay();
            });
        } else {
            console.log("Không phải trang hóa đơn, bỏ qua việc tải danh sách");
        }
    });

    // Đảm bảo các hàm có sẵn trong phạm vi toàn cục
    window.loadInvoices = loadInvoices;
    window.viewInvoiceDetails = viewInvoiceDetails;
    window.printInvoice = printInvoice;
    window.closeOverlay = closeOverlay;
    window.searchInvoices = searchInvoices;
}