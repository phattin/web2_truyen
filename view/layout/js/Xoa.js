function deleteSP(id) {
    if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?")) {
        $.ajax({
            url: "/webbantruyen/handle/deleteHandle.php",
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
                console.log("Có lỗi xảy ra, vui lòng thử lại sau: " + xhr.responseText);
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

function xoaNCC(id) {
    if (confirm("Bạn có chắc chắn muốn xóa nhà cung cấp này không?")) {
        $.ajax({
            url: "/webbantruyen/handle/deleteHandle.php",
            type: "POST",
            data: { supplierID: id },
            success: function (response) {
                console.log(response)
                if (response.success) {
                    alert("Xóa nhà cung cấp thành công");
                    // Xóa dòng tương ứng trong bảng
                    const row = document.querySelector(`#supplier-row-${id}`);
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
        type: "POST",
        url: "/webbantruyen/handle/deleteHandle.php",
        data: { roleID: x },
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (response.status==="success") {
                alert("Xóa thành công");
                
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

function xoaNV(ID){
    $.ajax({
    type: "POST",
    url: "../../handle/deleteHandle.php",
    data: { employeeID: ID },
    dataType: "json",
    success: function (response) {
        console.log(response);
        if (response.status==="success") {
            alert("Xóa thành công nhân viên và tài khoản");
            const row = document.querySelector(`#employee-row-${id}`);
            if (row)
                row.remove();
        } else {
            alert(response.message);
        }
    },
    error: function (xhr, status, error) {
                console.error("Lỗi AJAX: ", error);  // Log lỗi khi gặp sự cố với Ajax
                console.log("Phản hồi từ server (error): ", xhr.responseText); // Log thêm thông tin từ server
                alert("Có lỗi xảy ra, vui lòng thử lại sau: " + xhr.responseText);
    }
    });

}

function xoaTK(X){
    $.ajax({
    type: "GET",
    url: "../../handle/delete_account.php",
    data: { Username : X},
    dataType: "json",
    success: function (response) {
        console.log(response);
        if (response.status==="success") {
            alert("Xóa thành công");
            const row = document.querySelector(`#account-row-${id}`);
            if (row)
                row.remove();
        } else {
            alert(response.message);
        }
    },
    });
}