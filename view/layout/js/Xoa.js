function deleteSP(id) {
    if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?")) {
        $.ajax({
            url: "/webbantruyen/handle/deleteProduct.php",
            type: "POST",
            data: { productID: id },
            success: function (response) {
                console.log(response)
                if (response.success) {
                    alert("Xóa sản phẩm thành công");
                    // Xóa dòng tương ứng trong bảng
                    const row = document.querySelector(`#product-row-${id}`);
                    if (row) {
                        row.remove();
                    }
                } else {
                    alert("Có lỗi xảy ra, vui lòng thử lại sau: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Lỗi AJAX: ", error);  // Log lỗi khi gặp sự cố với Ajax
                console.log("Phản hồi từ server (error): ", xhr.responseText); // Log thêm thông tin từ server
                alert("Có lỗi xảy ra, vui lòng thử lại sau: " + xhr.responseText);
            }
        });
    }
}

function xoaKM(id) {
    if (confirm("Bạn có chắc chắn muốn xóa khuyến mãi này không?")) {
        $.ajax({
            url: "/webbantruyen/handle/deleteHandle.php",
            type: "POST",
            data: { promotionID: id },
            success: function (response) {
                console.log(response)
                if (response.success) {
                    alert("Xóa khuyến mãi thành công");
                    // Xóa dòng tương ứng trong bảng
                    const row = document.querySelector(`#promotion-row-${id}`);
                    if (row) {
                        row.remove();
                    }
                } else {
                    alert("Có lỗi xảy ra, vui lòng thử lại sau: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Lỗi AJAX: ", error);  // Log lỗi khi gặp sự cố với Ajax
                console.log("Phản hồi từ server (error): ", xhr.responseText); // Log thêm thông tin từ server
                alert("Có lỗi xảy ra, vui lòng thử lại sau: " + xhr.responseText);
            }
        });
    }
}
function XoaRole(x){
    console.log(x);
    $.ajax({
        type: "GET",
        url: "../admin/XLXoaRole.php",
        data: { RoleID: x },
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (response.status==="success") {
                alert("Xóa thành công");
                
            } else {
                alert("Có lỗi xảy ra, vui lòng thử lại sau: " + response.message);
            }
            location.reload();
        },
    });
}