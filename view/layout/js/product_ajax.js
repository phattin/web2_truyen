$(document).ready(function () {
  
  //Click navbar
  $(".menu-item").on("click", function (event) {
    event.preventDefault();
    var page = $(this).data("page");
    console.log("page: " + page);

    $.ajax({
      type: "GET",
      url: "/webbantruyen/handle/switch_navbar.php?act=" + page,
      dataType: "json",
      success: function (response) {
        console.log("response:", response);
        htmlContent = `<div class="product-grid">`;
        response.data.forEach(function (product) {
          htmlContent += `<div class="product-item">
                                        <a href="index.php?page=product_detail&id=${
                                          product.ProductID
                                        }">
                                            <img src="view/layout/images/${
                                              product.ProductImg
                                            }" alt="${product.ProductName}">
                                        </a>
                                        <h3>${product.ProductName}</h3>
                                        <p class="price">${(
                                          Math.round(
                                                (parseFloat(product.ImportPrice) *
                                                  ( 1 + parseFloat(product.ROS) ) 
                                              ) )
                                        ).toLocaleString("vi-VN")} VNĐ</p>
                                        
                                        <!-- Form gửi dữ liệu sản phẩm đến cart.php -->
                                        <form action="view/layout/page/cart.php" method="POST">
                                            <input type="hidden" name="id" value="${
                                              product.ProductID
                                            }">
                                            <input type="hidden" name="name" value="${
                                              product.ProductName
                                            }">
                                            <input type="hidden" name="price" value="${(
                                              Math.round(
                                                (parseFloat(product.ImportPrice) *
                                                  ( 1 + parseFloat(product.ROS) ) 
                                              ) )
                                            ).toLocaleString("vi-VN")}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="button" class="btn-add-to-cart"  onclick="addToCart(this)" data-id="${
                                              product.ProductID
                                            }">Thêm vào giỏ hàng</button>
                                        </form>
                                    </div>`;
        });
        htmlContent += `</div>`;
        //Phan trang
        var total_pages = response.total_pages;
        if (total_pages != 1) {
          htmlContent += `<div class="pagination"><ul>`;
          for (i = 1; i <= total_pages; i++) {
            if (i != 1)
              var s =
                '<li class="btn-pagination" data-page="' +
                page +
                '" data-page_number="' +
                i +
                '">' +
                i +
                "</li>";
            else
              var s =
                '<li class="btn-pagination active" data-page="' +
                page +
                '" data-page_number="' +
                i +
                '">' +
                i +
                "</li>";
            htmlContent += s;
          }
          if (total_pages > 1 && response.current_page < total_pages)
            htmlContent +=
            '<li class="btn-pagination" data-page="${page}" data-page_number="2">&gt;</li>';
          htmlContent += `</ul></div>`;
        }
        // Duyệt qua từng sản phẩm trong response và tạo HTML cho chúng
        $("main.container").html(htmlContent);
        history.pushState({ page: page }, "", "?act=" + page);
      },
      error: function (xhr, status, error) {
        console.error("Lỗi Ajax:", error);
        console.log("Phản hồi từ Server:", xhr.responseText); // Xem nội dung server trả về
        alert("Lỗi: " + error);
      },
    });
  });

  //Click vào thể loại
  $(".menu-list-genre").on("click", function (event) {
    event.preventDefault();
    var page = $(this).data("page");
    var id = $(this).data("genre");
    page += "&genre=" + id;
    console.log("page: " + page);
    console.log("genreID: " + id);

    $.ajax({
      type: "GET",
      url: "/webbantruyen/handle/switch_navbar.php?act=" + page,
      dataType: "json",
      success: function (response) {
        console.log("response:", response);
        htmlContent = `<div class="product-grid">`;
        response.data.forEach(function (product) {
          htmlContent += `<div class="product-item">
                                        <a href="index.php?page=product_detail&id=${
                                          product.ProductID
                                        }">
                                            <img src="view/layout/images/${
                                              product.ProductImg
                                            }" alt="${product.ProductName}">
                                        </a>
                                        <h3>${product.ProductName}</h3>
                                        <p class="price">${(
                                          Math.round(
                                                (parseFloat(product.ImportPrice) *
                                                  ( 1 + parseFloat(product.ROS) ) 
                                              ) )
                                        ).toLocaleString("vi-VN")} VNĐ</p>
                                        
                                        <!-- Form gửi dữ liệu sản phẩm đến cart.php -->
                                        <form action="view/layout/page/cart.php" method="POST">
                                            <input type="hidden" name="id" value="${
                                              product.ProductID
                                            }">
                                            <input type="hidden" name="name" value="${
                                              product.ProductName
                                            }">
                                            <input type="hidden" name="price" value="${(
                                              Math.round(
                                                (parseFloat(product.ImportPrice) *
                                                  ( 1 + parseFloat(product.ROS) ) 
                                              ) )
                                            ).toLocaleString("vi-VN")}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="button" class="btn-add-to-cart"  onclick="addToCart(this)" data-id="${
                                              product.ProductID
                                            }">Thêm vào giỏ hàng</button>
                                        </form>
                                    </div>`;
        });
        htmlContent += `</div>`;
        //Phan trang
        var total_pages = response.total_pages;
        if (total_pages != 1) {
          htmlContent += `<div class="pagination"><ul>`;
          for (i = 1; i <= total_pages; i++) {
            if (i != 1)
              var s =
                '<li class="btn-pagination" data-page="' +
                page +
                '" data-page_number="' +
                i +
                '">' +
                i +
                "</li>";
            else
              var s =
                '<li class="btn-pagination active" data-page="' +
                page +
                '" data-page_number="' +
                i +
                '">' +
                i +
                "</li>";
            htmlContent += s;
          }
          if (total_pages > 1 && response.current_page < total_pages)
            htmlContent +=
            '<li class="btn-pagination" data-page="${page}" data-page_number="2">&gt;</li>';
          htmlContent += `</ul></div>`;
        }
        // Duyệt qua từng sản phẩm trong response và tạo HTML cho chúng
        $("main.container").html(htmlContent);
        history.pushState({ page: page }, "", "?act=" + page);
      },
      error: function (xhr, status, error) {
        console.error("Lỗi Ajax:", error);
        console.log("Phản hồi từ Server:", xhr.responseText); // Xem nội dung server trả về
        alert("Lỗi: " + error);
      },
    });
  });

  //Click vào chủng loại
  $(".menu-list-category").on("click", function (event) {
    event.preventDefault();
    var page = $(this).data("page");
    var id = $(this).data("category");
    page += "&category=" + id;
    console.log("page: " + page);
    console.log("categoryID: " + id);

    $.ajax({
      type: "GET",
      url: "/webbantruyen/handle/switch_navbar.php?act=" + page,
      dataType: "json",
      success: function (response) {
        console.log("response:", response);
        htmlContent = `<div class="product-grid">`;
        response.data.forEach(function (product) {
          htmlContent += `<div class="product-item">
                                        <a href="index.php?page=product_detail&id=${
                                          product.ProductID
                                        }">
                                            <img src="view/layout/images/${
                                              product.ProductImg
                                            }" alt="${product.ProductName}">
                                        </a>
                                        <h3>${product.ProductName}</h3>
                                        <p class="price">${(
                                          Math.round(
                                                (parseFloat(product.ImportPrice) *
                                                  ( 1 + parseFloat(product.ROS) ) 
                                              ) )
                                        ).toLocaleString("vi-VN")} VNĐ</p>
                                        
                                        <!-- Form gửi dữ liệu sản phẩm đến cart.php -->
                                        <form action="view/layout/page/cart.php" method="POST">
                                            <input type="hidden" name="id" value="${
                                              product.ProductID
                                            }">
                                            <input type="hidden" name="name" value="${
                                              product.ProductName
                                            }">
                                            <input type="hidden" name="price" value="${(
                                              Math.round(
                                                (parseFloat(product.ImportPrice) *
                                                  ( 1 + parseFloat(product.ROS) ) 
                                              ) )
                                            ).toLocaleString("vi-VN")}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="button" class="btn-add-to-cart"  onclick="addToCart(this)" data-id="${
                                              product.ProductID
                                            }">Thêm vào giỏ hàng</button>
                                        </form>
                                    </div>`;
        });
        htmlContent += `</div>`;
        //Phan trang
        var total_pages = response.total_pages;
        if (total_pages != 1) {
          htmlContent += `<div class="pagination"><ul>`;
          for (i = 1; i <= total_pages; i++) {
            if (i != 1)
              var s =
                '<li class="btn-pagination" data-page="' +
                page +
                '" data-page_number="' +
                i +
                '">' +
                i +
                "</li>";
            else
              var s =
                '<li class="btn-pagination active" data-page="' +
                page +
                '" data-page_number="' +
                i +
                '">' +
                i +
                "</li>";
            htmlContent += s;
          }
          if (total_pages > 1 && response.current_page < total_pages)
            htmlContent +=
            '<li class="btn-pagination" data-page="${page}" data-page_number="2">&gt;</li>';
          htmlContent += `</ul></div>`;
        }
        // Duyệt qua từng sản phẩm trong response và tạo HTML cho chúng
        $("main.container").html(htmlContent);
        history.pushState({ page: page }, "", "?act=" + page);
      },
      error: function (xhr, status, error) {
        console.error("Lỗi Ajax:", error);
        console.log("Phản hồi từ Server:", xhr.responseText); // Xem nội dung server trả về
        alert("Lỗi: " + error);
      },
    });
  });

  //Phân trang
  $(document).on("click", ".btn-pagination", function (event) {
    event.preventDefault();
    var page = $(this).data("page");
    var page_number = parseInt($(this).data("page_number"));
    var id = $(this).data("genre");
    if (page == "genre") {
      page += "?genre=" + id;
    }
    console.log("page: " + page);
    console.log("page_number: " + page_number);
    console.log("id: " + id);

    $.ajax({
      type: "GET",
      url:
        "/webbantruyen/handle/switch_navbar.php?act=" +
        page +
        "&page_number=" +
        page_number,
      dataType: "json",
      success: function (response) {
        console.log("response:", response);
        htmlContent = `<div class="product-grid">`;
        if(response.data == null || response.data == [])
          htmlContent += "<h3>Không tìm thấy sản phẩm nào</h3>"
        response.data.forEach(function (product) {
          htmlContent += `<div class="product-item">
                                        <a href="index.php?page=product_detail&id=${
                                          product.ProductID
                                        }">
                                            <img src="view/layout/images/${
                                              product.ProductImg
                                            }" alt="${product.ProductName}">
                                        </a>
                                        <h3>${product.ProductName}</h3>
                                        <p class="price">${(
                                          Math.round(
                                                (parseFloat(product.ImportPrice) *
                                                  ( 1 + parseFloat(product.ROS) ) 
                                              ) )
                                        ).toLocaleString("vi-VN")} VNĐ</p>
                                        
                                        <!-- Form gửi dữ liệu sản phẩm đến cart.php -->
                                        <form action="view/layout/page/cart.php" method="POST">
                                            <input type="hidden" name="id" value="${
                                              product.ProductID
                                            }">
                                            <input type="hidden" name="name" value="${
                                              product.ProductName
                                            }">
                                            <input type="hidden" name="price" value="${(
                                              Math.round(
                                                (parseFloat(product.ImportPrice) *
                                                  ( 1 + parseFloat(product.ROS) ) 
                                              ) )
                                            ).toLocaleString("vi-VN")}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="button" class="btn-add-to-cart"  onclick="addToCart(this)" data-id="${
                                              product.ProductID
                                            }">Thêm vào giỏ hàng</button>
                                        </form>
                                    </div>`;
        });
        var total_pages = parseInt(response.total_pages);
        if (total_pages != 1) {
          htmlContent += `</div>`;
          //Phan trang
          htmlContent += `<div class="pagination"><ul>`;

          // Nút Prev nếu không phải trang đầu
          if (page_number > 1)
            htmlContent += `<li class="btn-pagination" data-page="${page}" data-page_number="${
              page_number - 1
            }">&lt;</li>`;

          // Các số trang
          for (let i = 1; i <= total_pages; i++) {
            if (i !== page_number)
              htmlContent += `<li class="btn-pagination" data-page="${page}" data-page_number="${i}">${i}</li>`;
            else
              htmlContent += `<li class="btn-pagination active" data-page="${page}" data-page_number="${i}">${i}</li>`;
          }

          // Nút Next nếu không phải trang cuối
          if (page_number < total_pages)
            if (total_pages > 1 && response.current_page < total_pages)
              htmlContent += `<li class="btn-pagination" data-page="${page}" data-page_number="${
                page_number + 1
              }">&gt;</li>`;
          htmlContent += `</ul></div>`;
        }
        // Duyệt qua từng sản phẩm trong response và tạo HTML cho chúng
        $("main.container").html(htmlContent);

        history.pushState(
          { page: page, page_number: page_number },
          "",
          "?act=" + page + "&page_number=" + page_number
        );
      },
      error: function (xhr, status, error) {
        console.error("Lỗi Ajax:", error);
        console.log("Phản hồi từ Server:", xhr.responseText); // Xem nội dung server trả về
        alert("Lỗi: " + error);
      },
    });
  });

  // Lọc nhiều (Sự kiện click nút Lọc)
  $(document).on("click", ".filter-button", function (event) {
    event.preventDefault();
    const page = "home";

    const minPrice = parseInt($("#min-price").val()) || null;
    const maxPrice = parseInt($("#max-price").val()) || null;

    if (minPrice && maxPrice && minPrice > maxPrice) {
      alert("Vui lòng nhập khoảng giá hợp lệ.");
      return;
    }

    // Lấy từ khóa tìm kiếm tên truyện
    const searchKeyword = $("#filter-search").val().trim();

    // Lấy các chủng loại đã chọn
    const selectedCategories = $(".filter-list-category input:checked").map(function () {
      return this.id;
    }).get();

    const filterData = {
      search: searchKeyword,
      min_price: minPrice,
      max_price: maxPrice,
      categories: selectedCategories,
      act: "filter"
    };

    console.log("Dữ liệu lọc:", filterData);

    $.ajax({
      type: "POST",
      url: "/webbantruyen/handle/filter.php",
      data: filterData,
      dataType: "json",
      success: function (response) {
        console.log(response);
        let htmlContent = `<div class="product-grid">`;
        response.data.forEach(function (product) {
          const price = Math.round(parseFloat(product.ImportPrice) * (1 + parseFloat(product.ROS)));
          htmlContent += `
            <div class="product-item">
              <a href="index.php?page=product_detail&id=${product.ProductID}">
                <img src="view/layout/images/${product.ProductImg}" alt="${product.ProductName}">
              </a>
              <h3>${product.ProductName}</h3>
              <p class="price">${price.toLocaleString("vi-VN")} VNĐ</p>
              <form action="view/layout/page/cart.php" method="POST">
                <input type="hidden" name="id" value="${product.ProductID}">
                <input type="hidden" name="name" value="${product.ProductName}">
                <input type="hidden" name="price" value="${price}">
                <input type="hidden" name="quantity" value="1">
                <button type="button" class="btn-add-to-cart" data-id="${product.ProductID}">Thêm vào giỏ hàng</button>
              </form>
            </div>`;
        });
        htmlContent += `</div>`;

        // Phân trang
        if (response.total_pages && response.total_pages > 1) {
          htmlContent += `<div class="pagination"><ul>`;
          for (let i = 1; i <= response.total_pages; i++) {
            htmlContent += `<li class="btn-pagination ${i === 1 ? "active" : ""}" data-page="${page}" data-page_number="${i}">${i}</li>`;
          }
          htmlContent += `</ul></div>`;
        }

        $("main.container").html(htmlContent);
        history.pushState({ page: page }, "", "?act=" + page);
      },
      error: function (xhr, status, error) {
        console.error("Lỗi Ajax:", error);
        console.log("Phản hồi từ Server:", xhr.responseText);
        alert("Lỗi: " + error);
      },
    });
  });

  

  //Hàm tìm kiếm
  $(document).on("keyup", "#find-product", function (event) {
    var page = 'home';
    var keyword = $(this).val();
    console.log("keyword: " + keyword);
    $.ajax({
        type: "POST",
        url: "/webbantruyen/handle/searchProduct.php",
        data: { keyword: keyword },
        dataType: "json",
        success: function (response) {
          console.log("response:", response);
          htmlContent = `<div class="product-grid">`;
          response.data.forEach(function (product) {
            htmlContent += `<div class="product-item">
                                            <a href="index.php?page=product_detail&id=${
                                              product.ProductID
                                            }">
                                                <img src="view/layout/images/${
                                                  product.ProductImg
                                                }" alt="${product.ProductName}">
                                            </a>
                                            <h3>${product.ProductName}</h3>
                                            <p class="price">${(
                                              Math.round(
                                                (parseFloat(product.ImportPrice) *
                                                  ( 1 + parseFloat(product.ROS) ) 
                                              ) )
                                            ).toLocaleString("vi-VN")} VNĐ</p>
                                            
                                            <!-- Form gửi dữ liệu sản phẩm đến cart.php -->
                                            <form action="view/layout/page/cart.php" method="POST">
                                                <input type="hidden" name="id" value="${
                                                  product.ProductID
                                                }">
                                                <input type="hidden" name="name" value="${
                                                  product.ProductName
                                                }">
                                                <input type="hidden" name="price" value="${(
                                                  Math.round(
                                                (parseFloat(product.ImportPrice) *
                                                  ( 1 + parseFloat(product.ROS) ) 
                                              ) )
                                                ).toLocaleString("vi-VN")}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="button" class="btn-add-to-cart" data-id="${
                                                  product.ProductID
                                                }">Thêm vào giỏ hàng</button>
                                            </form>
                                        </div>`;
          });
          htmlContent += `</div>`;
          //Phan trang
          var total_pages = response.total_pages;
          if (total_pages != 1) {
            htmlContent += `<div class="pagination"><ul>`;
            for (i = 1; i <= total_pages; i++) {
              if (i != 1)
                var s =
                  '<li class="btn-pagination" data-page="' +
                  page +
                  '" data-page_number="' +
                  i +
                  '">' +
                  i +
                  "</li>";
              else
                var s =
                  '<li class="btn-pagination active" data-page="' +
                  page +
                  '" data-page_number="' +
                  i +
                  '">' +
                  i +
                  "</li>";
              htmlContent += s;
            }
            if (total_pages > 1 && response.current_page < total_pages)
              htmlContent +=
              '<li class="btn-pagination" data-page="${page}" data-page_number="2">&gt;</li>';
            htmlContent += `</ul></div>`;
          }
          // Duyệt qua từng sản phẩm trong response và tạo HTML cho chúng
          $("main.container").html(htmlContent);
          history.pushState({ page: page }, "", "?act=" + page);
        },
        error: function (xhr, status, error) {
          console.error("Lỗi Ajax:", error);
          console.log("Phản hồi từ Server:", xhr.responseText); // Xem nội dung server trả về
          alert("Lỗi: " + error);
        },
      });
  });
  const isLoggedIn = !!document.querySelector(".user-menu"); // Kiểm tra user đăng nhập
  function addToCart(button) {
            if (!isLoggedIn) {
                alert("Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng!");
                window.location.href = "index.php?page=login";
                return;
            }

            const productItem = button.closest(".product-item");
            const form = button.closest("form");
            const formData = new FormData(form);

            fetch("view/layout/page/cart.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    cartCount = data.cart_count;
                    updateCartCount();

                    cartIcon.classList.add("shake");
                    setTimeout(() => {
                        cartIcon.classList.remove("shake");
                    }, 500);

                    showFlyEffect(productItem);
                } else {
                    alert(data.message || "Có lỗi xảy ra khi thêm vào giỏ hàng.");
                }
            })
            .catch(error => {
                console.error("Lỗi:", error);
                alert("Không thể thêm sản phẩm vào giỏ hàng. Vui lòng thử lại.");
            });
  }
});
