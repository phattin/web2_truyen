document.addEventListener("DOMContentLoaded", function () {
    const cartIcon = document.getElementById("cart-icon");
    const isLoggedIn = !!document.querySelector(".user-menu"); // Kiểm tra user đăng nhập
    let cartCount = 0; // Biến đếm sản phẩm trong giỏ

    // Lấy số lượng sản phẩm trong giỏ hàng từ session khi load trang
    fetch("/webbantruyen/view/layout/page/get_cart_count.php")
        .then(response => response.json())
        .then(data => {
            if (data.cart_count !== undefined) {
                cartCount = data.cart_count;
                updateCartCount();
            }
        })
        .catch(error => console.error("Lỗi khi lấy số lượng giỏ hàng:", error));

    // Xử lý sự kiện khi bấm "Thêm vào giỏ hàng"
    document.querySelectorAll(".btn-add-to-cart").forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định

            if (!isLoggedIn) {
                alert("Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng!");
                window.location.href = "index.php?page=login";
                return;
            }

            // Lấy thông tin sản phẩm từ form
            const productItem = this.closest(".product-item");
            const form = this.closest("form");
            const formData = new FormData(form);

            // Gửi dữ liệu đến server bằng fetch
            fetch("view/layout/page/cart.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    cartCount = data.cart_count;
                    updateCartCount();

                    // Hiệu ứng rung cho cart-icon
                    cartIcon.classList.add("shake");
                    setTimeout(() => {
                        cartIcon.classList.remove("shake");
                    }, 500);

                    // Hiệu ứng hình ảnh bay vào giỏ hàng
                    showFlyEffect(productItem);
                } else {
                    alert(data.message || "Có lỗi xảy ra khi thêm vào giỏ hàng.");
                }
            })
            .catch(error => {
                console.error("Lỗi:", error);
                alert("Không thể thêm sản phẩm vào giỏ hàng. Vui lòng thử lại.");
            });
        });
    });

    // Hàm cập nhật số lượng sản phẩm trên icon giỏ hàng
    function updateCartCount() {
        if (!cartIcon) return; // Nếu không tìm thấy phần tử, thoát luôn tránh lỗi

        let cartBadge = cartIcon.querySelector(".cart-count");
        if (!cartBadge) {
            cartBadge = document.createElement("span");
            cartBadge.classList.add("cart-count");
            cartIcon.appendChild(cartBadge);
        }
        cartBadge.textContent = cartCount;
    }

    // Hiệu ứng hình ảnh bay vào giỏ hàng
    function showFlyEffect(productItem) {
        const productImage = productItem.querySelector("img");
        if (productImage && cartIcon) {
            const flyImage = productImage.cloneNode(true);
            const rect = productImage.getBoundingClientRect();

            flyImage.style.position = "fixed";
            flyImage.style.top = `${rect.top}px`;
            flyImage.style.left = `${rect.left}px`;
            flyImage.style.width = `${rect.width}px`;
            flyImage.style.height = `${rect.height}px`;
            flyImage.style.transition = "all 1s ease-in-out";
            flyImage.style.zIndex = "9999";

            document.body.appendChild(flyImage);

            const cartRect = cartIcon.getBoundingClientRect();

            setTimeout(() => {
                flyImage.style.top = `${cartRect.top}px`;
                flyImage.style.left = `${cartRect.left}px`;
                flyImage.style.width = "30px";
                flyImage.style.height = "30px";
                flyImage.style.opacity = "0.5";
            }, 100);

            flyImage.addEventListener("transitionend", () => {
                flyImage.remove();
            });
        }
    }
});
