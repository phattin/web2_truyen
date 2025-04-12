document.addEventListener("DOMContentLoaded", function () {
  //Xử lý khi click vào checkbox
  document.querySelectorAll(".cbCart-item").forEach((button) => {
    button.addEventListener("click", function () {
      // Gọi hàm tính tổng tiền mỗi lần click
      calculateTotalPrice();

      checkCBitem();
    });
  });
  // Xử lý tăng số lượng
  document.querySelectorAll(".btn-increase").forEach((button) => {
    button.addEventListener("click", function () {
      const productId = this.getAttribute("data-id");
      updateQuantity(productId, 1, button);
    });
  });

  // Xử lý giảm số lượng
  document.querySelectorAll(".btn-decrease").forEach((button) => {
    button.addEventListener("click", function () {
      const productId = this.getAttribute("data-id");
      updateQuantity(productId, -1, button);
    });
  });

  // Xử lý nhập số lượng trực tiếp
  document.querySelectorAll(".quantity-input").forEach((input) => {
    // Lưu giá trị cũ khi input được focus
    input.addEventListener("focus", function () {
      this.setAttribute("data-old-value", this.value);
    });
    input.addEventListener("change", function () {
      console.log('đã thay đổi')
      const productId = this.getAttribute("data-id");
      const newQuantity = parseInt(this.value);
      const oldQuantity = parseInt(this.getAttribute("data-old-value")) || 1;

      if (newQuantity < 1 || !Number.isInteger(newQuantity)) {
        alert("Số lượng phải là số nguyên và lớn hơn hoặc bằng 1.");
        this.value = oldQuantity; // Đặt lại giá trị tối thiểu
        calculateTotalPrice();
        return;
      }

      updateQuantityDirectly(productId, newQuantity, input);
    });
  });

  // Xử lý xóa sản phẩm
  document.querySelectorAll(".btn-delete").forEach((button) => {
    button.addEventListener("click", function () {
      const productId = this.getAttribute("data-id");
      deleteProduct(productId, button);
    });
  });

    // Hàm cập nhật số lượng (tăng/giảm)
    function updateQuantity(productId, change, element) {
      $.ajax({
        url: "view/layout/page/cart_update_2.php",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify({ id: productId, change: change }),
        success: function (data) {
          if (data.success) {
            console.log(data)
            const parentDiv = element.closest('tr');
            //Cập nhật số lượng
            parentDiv.querySelector('.quantity-input').value = data.newQuantity;
            //Cập nhật giá tiền
            parentDiv.querySelector('.totalPrice-cart').innerText = data.productPrice.toLocaleString("vi-VN") + " VND"
            //Cập nhật tổng tiền
            calculateTotalPrice();
          } else {
            alert(data.message || "Lỗi khi cập nhật số lượng.");
          }
        },
        error: function (xhr, status, error) {
          console.error("AJAX Error:");
          console.error("Status:", status);
          console.error("Error:", error);
          console.error("Response Text:", xhr.responseText);
        },
      });
    }

  // Hàm cập nhật số lượng trực tiếp
  function updateQuantityDirectly(productId, newQuantity, element) {
    $.ajax({
      url: "view/layout/page/cart_update_direct.php",
      method: "POST",
      contentType: "application/json",
      data: JSON.stringify({ id: productId, quantity: newQuantity }),
      success: function (data) {
        if (data.success) {
          console.log(data)
          const parentDiv = element.closest('tr');
          //Cập nhật số lượng
          parentDiv.querySelector('.quantity-input').value = data.newQuantity;
          //Cập nhật giá tiền
          parentDiv.querySelector('.totalPrice-cart').innerText = data.productPrice.toLocaleString("vi-VN") + " VND"
          //Cập nhật tổng tiền
          calculateTotalPrice();
        } else {
          alert(data.message || "Có lỗi xảy ra khi cập nhật số lượng.");
        }
      },
      error: function (error) {
        console.error("Lỗi:", error);
      }
    });
  }

  // Hàm xóa sản phẩm
  function deleteProduct(productId, element) {
    $.ajax({
      url: "view/layout/page/cart_delete.php",
      method: "POST",
      contentType: "application/json",
      data: JSON.stringify({ id: productId }),
      success: function (data) {
        if (data.success) {
          element.closest('tr').remove();
          calculateTotalPrice();
          checkCBitem();
        } else {
          alert(data.message || "Có lỗi xảy ra khi xóa sản phẩm.");
        }
      },
      error: function (error) {
        console.error("Lỗi:", error);
      }
    });
  }

  //Hàm cập nhật tổng tiền 
  function calculateTotalPrice() {
    const cartTable = document.querySelector('#cart-table');
    const allCheckBox = cartTable.querySelectorAll('.cbCart-item');
    const totalPriceElement = document.querySelector('.totalAllPrice-cart');
  
    let total = 0;
  
    allCheckBox.forEach((checkbox) => {
      if (checkbox.checked) {
        const row = checkbox.closest('tr'); // lấy dòng chứa checkbox
        const priceText = row.querySelector('.totalPrice-cart').innerText;
        const price = parseInt(priceText.replace(/\./g, "").replace(" VND", ""));
        total += price;
      }
    });
  
    totalPriceElement.innerText = total.toLocaleString("vi-VN") + " VND";
  }


  document.querySelector(".cbCart-all").addEventListener("click", function () {
    const cbAll = document.querySelector(".cbCart-all");
    const cbList = document.querySelectorAll(".cbCart-item");
    if (cbAll.checked)
      cbList.forEach((cb) => (cb.checked = true));
    else
      cbList.forEach((cb) => (cb.checked = false));
    calculateTotalPrice();
  });

  //Hàm kiểm tra checkbox con để check checkbox all
  function checkCBitem() {
    // Kiểm tra nếu tất cả đều được chọn thì check All
    const allCheckboxes = document.querySelectorAll(".cbCart-item");
    const allChecked = Array.from(allCheckboxes).every(cb => cb.checked);
    
    document.querySelector('.cbCart-all').checked = allChecked;
  }

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

