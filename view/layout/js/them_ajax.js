$(document).ready(function () {
    console.log("Document ready: ", $("#add-product-submit-btn"));
    $(document).on("click", "#add-product-submit-btn", function (e) {
        console.log("add-product-submit-btn clicked");
        e.preventDefault();
        const productID = $("#productID").val();
        const productName = $("#productName").val();
        const productImg = document.getElementById("image-upload").files[0]?.name || "";
        const author = $("#author").val();
        const publisher = $("#publisher").val();
        const description = $("#description").val();
        const quantity = $("#stock").val();
        const importPrice = $("#importPrice").val();
        const ros = $("#ros").val();
        const supplierID = $("#supplier").val();

        if (
        productName === "" ||
        author === "" ||
        publisher === "" ||
        description === ""
        ) {
        alert("Vui lòng điền đầy đủ thông tin!");
        return;
        }
        //Tên không chứa số và kí tự đặc biệt có quyền chứa số
        const nameRegex = /^[a-zA-Z0-9\s]+$/;
        if (!nameRegex.test(productName)) {
            alert("Tên sản phẩm không chứa kí tự đặc biệt!");
            return;
        }
        //Tác giả và NXB không chứa số và kí tự đặc biệt và số
        const fullnameRegex = /^[a-zA-Z\s]+$/;
        if (!fullnameRegex.test(author)) {
            alert("Tên tác giả không hợp lệ!");
            return;
        }
        if (!fullnameRegex.test(publisher)) {
            alert("Tên NXB không hợp lệ!");
            return;
        }


        $.ajax({
        type: "POST",
        url: "/webbantruyen/handle/addProduct.php",
        data: {
            productID,
            productName,
            productImg,
            author,
            publisher,
            description,
            quantity,
            importPrice,
            ros,
            supplierID,
        },
        dataType: "json",
        success: function (response) {
            console.log("response:", response);
            if (response.success) {
            alert("Thêm sản phẩm thành công!");
            const table = document.getElementById("productTable");
            const row = table.insertRow(-1);

            row.insertCell(0).innerText = productID;
            row.insertCell(1).innerText = productName;
            row.insertCell(2).innerText = author;
            row.insertCell(3).innerText = quantity;

            const actions = `
                <i class='fa-regular fa-eye detail-icon' onclick='ChitietSP("${productID}")'></i>
                <i class='fa-regular fa-pen-to-square edit-icon' onclick='editSP("${productID}")'></i>
                <i class='fa-regular fa-trash-can delete-icon' onclick='deleteSP("${productID}")'></i>
            `;
            row.insertCell(4).innerHTML = actions;
            } else {
            alert("Thêm sản phẩm thất bại: " + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Lỗi Ajax:", error);
            console.log("Phản hồi từ Server:", xhr.responseText);
            alert("Lỗi: " + error);
        },
        });
    });
});