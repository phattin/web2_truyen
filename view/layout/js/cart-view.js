document.addEventListener("DOMContentLoaded", function () {
    // Xử lý tăng số lượng
    document.querySelectorAll(".btn-increase").forEach(button => {
        button.addEventListener("click", function () {
            const productId = this.getAttribute("data-id");
            updateQuantity(productId, 1);
        });
    });

    // Xử lý giảm số lượng
    document.querySelectorAll(".btn-decrease").forEach(button => {
        button.addEventListener("click", function () {
            const productId = this.getAttribute("data-id");
            updateQuantity(productId, -1);
        });
    });

    // Xử lý nhập số lượng trực tiếp
    document.querySelectorAll(".quantity-input").forEach(input => {
        input.addEventListener("change", function () {
            const productId = this.getAttribute("data-id");
            const newQuantity = parseInt(this.value);

            if (newQuantity < 1 || isNaN(newQuantity)) {
                alert("Số lượng phải lớn hơn hoặc bằng 1.");
                this.value = 1; // Đặt lại giá trị tối thiểu
                return;
            }

            updateQuantityDirectly(productId, newQuantity);
        });
    });

    // Xử lý xóa sản phẩm
    document.querySelectorAll(".btn-delete").forEach(button => {
        button.addEventListener("click", function () {
            const productId = this.getAttribute("data-id");
            deleteProduct(productId);
        });
    });

    // Hàm cập nhật số lượng (tăng/giảm)
    function updateQuantity(productId, change) {
        fetch("view/layout/page/cart_update_2.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id: productId, change: change })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Reload lại trang để cập nhật giỏ hàng
            } else {
                alert(data.message || "Có lỗi xảy ra khi cập nhật số lượng.");
            }
        })
        .catch(error => console.error("Lỗi:", error));
    }

    // Hàm cập nhật số lượng trực tiếp
    function updateQuantityDirectly(productId, newQuantity) {
        fetch("view/layout/page/cart_update_direct.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id: productId, quantity: newQuantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Reload lại trang để cập nhật giỏ hàng
            } else {
                alert(data.message || "Có lỗi xảy ra khi cập nhật số lượng.");
            }
        })
        .catch(error => console.error("Lỗi:", error));
    }

    // Hàm xóa sản phẩm
    function deleteProduct(productId) {
        fetch("view/layout/page/cart_delete.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id: productId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Reload lại trang để cập nhật giỏ hàng
            } else {
                alert(data.message || "Có lỗi xảy ra khi xóa sản phẩm.");
            }
        })
        .catch(error => console.error("Lỗi:", error));
    }
});