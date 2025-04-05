document.addEventListener("DOMContentLoaded", function () {
  // Xử lý tăng số lượng
  document.querySelectorAll(".btn-increase").forEach((button) => {
    button.addEventListener("click", function () {
      const productId = this.getAttribute("data-id");
      updateQuantity(productId, 1);
    });
  });

  // Xử lý giảm số lượng
  document.querySelectorAll(".btn-decrease").forEach((button) => {
    button.addEventListener("click", function () {
      const productId = this.getAttribute("data-id");
      updateQuantity(productId, -1);
    });
  });

  // Xử lý nhập số lượng trực tiếp
  document.querySelectorAll(".quantity-input").forEach((input) => {
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
  document.querySelectorAll(".btn-delete").forEach((button) => {
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
      body: JSON.stringify({ id: productId, change: change }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          location.reload(); // Reload lại trang để cập nhật giỏ hàng
        } else {
          alert(data.message || "Có lỗi xảy ra khi cập nhật số lượng.");
        }
      })
      .catch((error) => console.error("Lỗi:", error));
  }

  // Hàm cập nhật số lượng trực tiếp
  function updateQuantityDirectly(productId, newQuantity) {
    fetch("view/layout/page/cart_update_direct.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id: productId, quantity: newQuantity }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          location.reload(); // Reload lại trang để cập nhật giỏ hàng
        } else {
          alert(data.message || "Có lỗi xảy ra khi cập nhật số lượng.");
        }
      })
      .catch((error) => console.error("Lỗi:", error));
  }

  // Hàm xóa sản phẩm
  function deleteProduct(productId) {
    fetch("view/layout/page/cart_delete.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id: productId }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          location.reload(); // Reload lại trang để cập nhật giỏ hàng
        } else {
          alert(data.message || "Có lỗi xảy ra khi xóa sản phẩm.");
        }
      })
      .catch((error) => console.error("Lỗi:", error));
  }

  document.querySelector(".cbCart-all").addEventListener("click", function () {
    const cbAll = document.querySelector(".cbCart-all");
    const cbList = document.querySelectorAll(".cbCart-item");
    if (cbAll.checked)
      cbList.forEach((cb) => (cb.checked = true));
    else
      cbList.forEach((cb) => (cb.checked = false));
  });

  //Ham thanh toan
    // Lắng nghe sự kiện click vào nút thanh toán
    document.querySelector(".btn-checkout").addEventListener("click", function (event) {
        var selectedProducts = [];

        // Lấy tất cả các checkbox đã được chọn
        document.querySelectorAll(".cbCart-item:checked").forEach(function (checkbox) {
            var parentDiv = checkbox.parentElement.parentElement; // Lấy div cha của checkbox
            var product = {
                id: parentDiv.querySelector(".idProduct-cart").innerText,
                name: parentDiv.querySelector(".nameProduct-cart").innerText,
                price: parentDiv.querySelector(".priceProduct-cart").innerText,
                quantity: parentDiv.querySelector(".quantity-input").value,
                totalPrice: parentDiv.querySelector(".totalPrice-cart").innerText
            };
            selectedProducts.push(product);
        });
        console.log(selectedProducts); // Kiểm tra dữ liệu đã lấy được
        console.log(document.querySelector(".totalAllPrice-cart").innerText);

        // Kiểm tra xem người dùng có chọn sản phẩm hay không
        if (selectedProducts.length === 0) {
            alert("Vui lòng chọn ít nhất một sản phẩm để thanh toán.");
            return;
        }

        // Tạo form động để gửi dữ liệu
        var form = document.createElement("form");
        form.method = "POST";
        form.action = "/webbantruyen/view/layout/page/checkout.php";

        // Tạo các input ẩn để chứa dữ liệu
        var productsInput = document.createElement("input");
        productsInput.type = "hidden";
        productsInput.name = "productsCheckout";
        productsInput.value = JSON.stringify(selectedProducts);  // Chuyển mảng thành chuỗi JSON

        var totalPriceInput = document.createElement("input");
        totalPriceInput.type = "hidden";
        totalPriceInput.name = "totalAllPrice";
        totalPriceInput.value = document.querySelector(".totalAllPrice-cart").innerText;

        // Thêm các input vào form
        form.appendChild(productsInput);
        form.appendChild(totalPriceInput);

        // Thêm form vào body và gửi form
        document.body.appendChild(form);
        form.submit();  // Gửi form đến trang checkout.php
    });
});

