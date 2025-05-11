// Hiển thị danh sách hóa đơn
function loadInvoices(search = "") {
    const invoiceList = document.getElementById("invoice-list");
    if (!invoiceList) {
        console.error("Không tìm thấy phần tử #invoice-list trong DOM.");
        return;
    }

    invoiceList.innerHTML = "<div class='loading'>Đang tải dữ liệu...</div>";

    $.ajax({
        url: "/webbantruyen/handle/getSalesInvoices.php", // File xử lý lấy danh sách hóa đơn
        type: "GET",
        data: { search: search },
        dataType: "html",
        success: function (response) {
            console.log("Phản hồi từ server:", response); // Kiểm tra phản hồi
            invoiceList.innerHTML = response;
        },
        error: function (xhr, status, error) {
            console.error("Lỗi khi tải danh sách hóa đơn:", error);
            invoiceList.innerHTML = "<p class='error'>Không thể tải danh sách hóa đơn.</p>";
        }
    });
}

// Xem chi tiết hóa đơn
function viewInvoiceDetails(salesID) {
    const overlay = document.getElementById("overlay-chucnang");
    const functionContainer = document.getElementById("Function");

    overlay.style.display = "block";
    functionContainer.innerHTML = "<div class='loading'>Đang tải chi tiết hóa đơn...</div>";

    $.ajax({
        url: "/webbantruyen/view/admin/getInvoiceDetails.php", // File xử lý chi tiết hóa đơn
        type: "POST",
        data: { salesID: salesID },
        dataType: "html",
        success: function (response) {
            functionContainer.innerHTML = response;
        },
        error: function (xhr, status, error) {
            console.error("Lỗi khi tải chi tiết hóa đơn:", error);
            functionContainer.innerHTML = "<p class='error'>Không thể tải chi tiết hóa đơn.</p>";
        }
    });
}

// Đóng overlay
function closeOverlay() {
    document.getElementById("overlay-chucnang").style.display = "none";
}

// Tìm kiếm hóa đơn
function searchInvoices() {
    const searchInput = document.getElementById("search-input").value.trim();
    loadInvoices(searchInput);
}

// Gọi hàm khi trang đã sẵn sàng
$(document).ready(function () {
    // Tải danh sách hóa đơn khi trang được tải
    loadInvoices();

    // Gắn sự kiện tìm kiếm
    $("#search-btn").on("click", searchInvoices);
    $("#search-input").on("keypress", function (e) {
        if (e.which === 13) {
            e.preventDefault();
            searchInvoices();
        }
    });
});