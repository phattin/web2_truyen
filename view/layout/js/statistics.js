function LoadStatistics() {
    let url = "/webbantruyen/view/admin/statistics.php";
    $("#admin-content").load(url, function (response, status, xhr) {
        if (status === "error") {
            console.error("Lỗi khi tải trang:", xhr.status, xhr.statusText);
            $("#admin-content").html("<p>Không thể tải thống kê.</p>");
        }
    });
}
// statistics.js - Fix for invoice details modal
$(document).ready(function() {
    // Function to show invoice details in a modal
    window.showInvoiceDetails = function(salesID, element) {
        // Create modal if it doesn't exist
        if ($("#invoice-modal").length === 0) {
            $("body").append(
                `<div id="invoice-modal" class="modal">
                    <div class="modal-content">
                        <span class="close-modal">&times;</span>
                        <div id="invoice-details-content"></div>
                    </div>
                </div>`
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
            error: function(xhr, status, error) {
                console.error("Error loading invoice details:", error);
                $("#invoice-details-content").html(`
                    <p class='error'>Không thể tải chi tiết hóa đơn. Vui lòng thử lại.</p>
                    <p>Lỗi: ${xhr.status} - ${xhr.statusText}</p>
                `);
            }
        });
        
        // If the element parameter is provided, remove the "Xem chi tiết" link
        if (element) {
            $(element).remove();
        }
    };
});