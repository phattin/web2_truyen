$(document).ready(function () {
    $(".btn-checkout").on("click", function (event) {
        var selectedProducts = [];
        $(".cbCart-item:checked").each(function () {
            // Lấy thẻ cha
            var parentDiv = this.parentElement.parentElement;
            var product = {
                id: parentDiv.querySelector(".idProduct-cart").innerText,
                name: parentDiv.querySelector(".nameProduct-cart").innerText,
                price: parentDiv.querySelector(".priceProduct-cart").innerText,
                quantity: parentDiv.querySelector(".quantity-input").value,
                totalPrice: parentDiv.querySelector(".totalPrice-cart").innerText
            }
            selectedProducts.push(product);
        });
        if (selectedProducts.length === 0) {
            alert("Vui lòng chọn ít nhất một sản phẩm để thanh toán.");
            return;
        }
        
        $.ajax({
            type: "POST",
            url: "/webbantruyen/view/layout/page/checkout.php",
            data: { 
                productsCheckout: selectedProducts,
                totalAllPrice: document.querySelector(".totalAllPrice-cart").value
             },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    alert("Thanh toán thành công!");
                } else {
                    alert(response.message || "Có lỗi xảy ra khi thanh toán.");
                }
            },
            error: function (xhr, status, error) {
                console.error("Lỗi Ajax:", error);
                console.log("Phản hồi từ Server:", xhr.responseText); // Xem nội dung server trả về
                alert("Lỗi: " + error);
            }
        });
    });
});