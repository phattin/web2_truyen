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
                                            (parseInt(product.ImportPrice) *
                                              parseFloat(product.ROS)) /
                                              1000
                                          ) * 1000
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
                                                (parseInt(product.ImportPrice) *
                                                  parseFloat(product.ROS)) /
                                                  1000
                                              ) * 1000
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
                                            (parseInt(product.ImportPrice) *
                                              parseFloat(product.ROS)) /
                                              1000
                                          ) * 1000
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
                                                (parseInt(product.ImportPrice) *
                                                  parseFloat(product.ROS)) /
                                                  1000
                                              ) * 1000
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
                                            (parseInt(product.ImportPrice) *
                                              parseFloat(product.ROS)) /
                                              1000
                                          ) * 1000
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
                                                (parseInt(product.ImportPrice) *
                                                  parseFloat(product.ROS)) /
                                                  1000
                                              ) * 1000
                                            ).toLocaleString("vi-VN")}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="button" class="btn-add-to-cart" data-id="${
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

    const minPrice = $("#min-price").val();
    const maxPrice = $("#max-price").val();

    if (parseInt(minPrice) > parseInt(maxPrice)) {
      alert("Vui lòng nhập khoảng giá hợp lệ.");
      return;
    }

    // Lấy các thể loại đã chọn
    const selectedGenres = [];
    $(".dropdown-filter-list input[type='checkbox']:checked").each(function () {
      selectedGenres.push($(this).attr("id"));
    });

    // Lấy trạng thái của truyện mới và truyện hot
    const isNew = $("#new-filter").prop("checked");
    const isHot = $("#hot-filter").prop("checked");

    // Tạo dữ liệu để gửi đến máy chủ
    const filterData = {
      min_price: minPrice,
      max_price: maxPrice,
      genres: selectedGenres,
      is_new: isNew,
      is_hot: isHot,
      act: "filter", // Hoặc một hành động khác để xử lý lọc ở máy chủ
    };

    console.log("Dữ liệu lọc:", filterData);

    $.ajax({
      type: "POST",
      url: "/webbantruyen/handle/filter.php",
      data: filterData,
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
                                              (parseInt(product.ImportPrice) *
                                                parseFloat(product.ROS)) /
                                                1000
                                            ) * 1000
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
                                                  (parseInt(
                                                    product.ImportPrice
                                                  ) *
                                                    parseFloat(product.ROS)) /
                                                    1000
                                                ) * 1000
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
                                                (parseInt(product.ImportPrice) *
                                                  parseFloat(product.ROS)) /
                                                  1000
                                              ) * 1000
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
                                                    (parseInt(
                                                      product.ImportPrice
                                                    ) *
                                                      parseFloat(product.ROS)) /
                                                      1000
                                                  ) * 1000
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
});
