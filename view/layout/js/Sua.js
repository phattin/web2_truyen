function editSP(product_id){
    $("#overlay-chucnang").css("display","block");
    $("#Function").css("display","block");
    $.ajax({
        type: "POST",
        url: "/webbantruyen/view/admin/form.php",
        data: { product_id: product_id },
        dataType: "json",
        success: function(response) {
            console.log({response});
            let htmlContent = `
                <input type="button" value="X" class="close-btn" onclick="Close_ChucNang()">
                <h2 style='text-align:center; margin:30px;'>Sửa sản phẩm</h2>
                <form id="product-add-form" class="product-add-form">
                    <div class="form-content">
                        <div class="left-panel">
                            <div class="image-upload-container">
                                <label for="image-upload">Hình ảnh sản phẩm:</label>
                                <input type="file" id="image-upload" style="color:white" name="productImage" accept="image/*">
                                <img id="preview" src="/webbantruyen/view/layout/images/${response.productImg}" alt="Xem trước" ">
                            </div>
                        </div>
                
                        <div class="right-panel">
                            <div style="display:none">
                                <label for="productID">Mã sản phẩm:</label>
                                <input type="text" value="${response.productID}" id="productID" name="productID" readonly>
                            </div>
                            <div>
                                <label for="productName">Tên truyện:</label>
                                <input type="text" value="${response.productName}" id="productName" name="productName">
                            </div>
                            <div>
                                <label for="author">Tác giả:</label>
                                <input type="text" value="${response.author}" id="author" name="author">
                            </div>
                            <div>
                                <label for="publisher">NXB:</label>
                                <input type="text" value="${response.publisher}" id="publisher" name="publisher">
                            </div>
                            <div style="display: none;">
                                <label for="stock">Kho:</label>
                                <input type="number" value="${response.quantity}" id="stock" name="stock" readonly>
                            </div>
                            <div style="display: none;">
                                <label for="price">Giá nhập:</label>
                                <input type="number" value="${response.importPrice}" id="importPrice" name="price" readonly>
                            </div>
                            <div style="display: none;">
                                <label for="ros">ROS:</label>
                                <input type="number" step="0.01" id="ros" value="${response.ros}" name="ros" readonly>
                            </div>
                            <div>
                                <label for="description">Mô tả:</label>
                                <input type="text" value="${response.description}" id="description" name="description">
                            </div>
                            <div>
                                <label for="supplier">Nhà cung cấp:</label>
                                <select id="supplier" name="supplier">`;
                                    response.allSupplier.forEach(supplier => {
                                    const selected = supplier.SupplierID === response.supplierID ? "selected" : "";
                                    htmlContent += `<option value="${supplier.SupplierID}" ${selected}>${supplier.SupplierName}</option>`;
                                });
                htmlContent +=`</select>
                            </div>`
                htmlContent +=`<div>
                                <label for="category">Nhà cung cấp:</label>
                                <select id="category" name="category">`;
                                    response.allCategory.forEach(category => {
                                    const selected = category.CategoryID === response.categoryID ? "selected" : "";
                                    htmlContent += `<option value="${category.CategoryID}" ${selected}>${category.CategoryName}</option>`;
                                });
                htmlContent +=`</select>
                            </div>`
            htmlContent +=`</div>
                    </div>
                    <div class="product-form-button">
                        <button type="button" id="add-product-submit-btn" class="add-product-submit-btn blue-btn">Sửa</button>
                    </div>
                </form>

                <script>
                    function attachEventHandlers() {
                        const imageUpload = document.getElementById('image-upload');
                        const preview = document.getElementById('preview');

                        if (imageUpload) {
                            imageUpload.addEventListener('change', function () {
                                const file = this.files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function () {
                                        preview.style.display = 'block';
                                        preview.src = reader.result;
                                    }
                                    reader.readAsDataURL(file);
                                } else {
                                    preview.style.display = 'none';
                                    preview.src = '#';
                                }
                            });
                        }
                    }
                    attachEventHandlers();
                    $("#add-product-submit-btn").on("click", function (e) {
                        e.preventDefault();
                        const productID = $("#productID").val();
                        const productName = $("#productName").val();
                        const productImg = document.getElementById("image-upload").files[0]?.name || "${response.productImg}";
                        const categoryID = $("#category").val();
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
                        // Tên sản phẩm có thể chứa chữ cái (chữ cái tiếng Việt và không tiếng Việt), số, dấu cách, dấu chấm, dấu gạch nối
                        const nameRegex = /^[a-zA-Z0-9\\s\\u00C0-\\u1EF9\\u0100-\\u017F\\.\\-]+$/;
                        console.log("Product Name:", productName); // Debugging: in ra tên sản phẩm
                        if (!nameRegex.test(productName)) {
                            alert("Tên sản phẩm không chứa kí tự đặc biệt!");
                            return;
                        }

                        // Tên tác giả và NXB không chứa số và chỉ chứa chữ cái, dấu cách và các dấu tiếng Việt
                        const fullnameRegex = /^[a-zA-Z\\s\\u00C0-\\u1EF9\\.\\-\\s]+$/;
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
                        url: "/webbantruyen/handle/editProduct.php",
                        data: {
                            productID,
                            productName,
                            productImg,
                            categoryID,
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
                            alert("Sửa sản phẩm thành công!");      
                            // Cập nhật dòng tương ứng trong bảng
                            const row = document.querySelector('#product-row-${response.productID}');
                            if (row) {
                                row.children[1].textContent = productName;
                                row.children[2].textContent = author;  
                                row.children[3].textContent = quantity;
                            }
                            Close_ChucNang();
                            } else {
                            alert("Sửa sản phẩm thất bại: " + response.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error("Lỗi Ajax:", error);
                            console.log("Phản hồi từ Server:", xhr.responseText);
                            alert("Lỗi: " + error);
                        },
                        });
                    });
                </script>
                `  
            
        $("#Function").html(htmlContent);  
        }
    });
}

function suaKM(promotionID) {
    $("#overlay-chucnang").css("display", "block");
    $("#Function").css("display", "block");

    $.ajax({
        type: "POST",
        url: "/webbantruyen/view/admin/form.php", // file trả về dữ liệu khuyến mãi
        data: { promotion_id: promotionID },
        dataType: "json",
        success: function(response) {
            console.log({ response });

            let htmlContent = `
                <input type="button" value="X" class="close-btn" onclick="Close_ChucNang()">
                <h2 style='text-align:center; margin:30px;'>Sửa khuyến mãi</h2>
                <form id="promotion-edit-form" class="product-add-form">
                    <div class="form-content" style="display:block">
                        <div class="right-panel">
                            <div style="display: none;">
                                <label for="promotionID">Mã khuyến mãi:</label>
                                <input type="text" id="promotionID" name="promotionID" value="${response.promotionID}" readonly>
                            </div>
                            <div>
                                <label for="promotionName">Tên khuyến mãi:</label>
                                <input type="text" id="promotionName" name="promotionName" value="${response.promotionName}">
                            </div>
                            <div>
                                <label for="discount">Giá trị giảm (%):</label>
                                <input type="number" id="discount" name="discount" min="1" max="100" value="${response.discount}">
                            </div>
                            <div>
                                <label for="startDate">Ngày bắt đầu:</label>
                                <input type="date" id="startDate" name="startDate" value="${response.startDate}">
                            </div>
                            <div>
                                <label for="endDate">Ngày kết thúc:</label>
                                <input type="date" id="endDate" name="endDate" value="${response.endDate}">
                            </div>
                        </div>
                    </div>
                    <div class="product-form-button">
                        <button type="button" id="edit-promotion-submit-btn" class="add-product-submit-btn blue-btn">Sửa</button>
                        <input type="reset" value="Reset" class="reset-btn blue-btn">
                    </div>
                </form>

                <script>
                    $("#edit-promotion-submit-btn").on("click", function (e) {
                        e.preventDefault();
                        const promotionID = $("#promotionID").val();
                        const promotionName = $("#promotionName").val();
                        const discount = $("#discount").val();
                        const startDate = $("#startDate").val();
                        const endDate = $("#endDate").val();

                        if (!promotionName || !discount || !startDate || !endDate) {
                            alert("Vui lòng điền đầy đủ thông tin!");
                            return;
                        }

                        if (discount <= 0 || discount > 100) {
                            alert("Giá trị giảm phải nằm trong khoảng 1-100!");
                            return;
                        }

                        if (new Date(startDate) > new Date(endDate)) {
                            alert("Ngày kết thúc phải sau hoặc bằng ngày bắt đầu!");
                            return;
                        }

                        $.ajax({
                            type: "POST",
                            url: "/webbantruyen/handle/editPromotion.php",
                            data: {
                                promotionID,
                                promotionName,
                                discount,
                                startDate,
                                endDate
                            },
                            dataType: "json",
                            success: function (response) {
                                if (response.success) {
                                    alert("Sửa khuyến mãi thành công!");

                                    const row = document.querySelector("#promotion-row-" + promotionID);
                                    if (row) {
                                        row.children[1].textContent = promotionName;
                                        row.children[2].textContent = discount;
                                        row.children[3].textContent = startDate;
                                        row.children[4].textContent = endDate;
                                    }

                                    Close_ChucNang();
                                } else {
                                    alert("Sửa thất bại: " + response.message);
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error("Lỗi Ajax:", error);
                                alert("Lỗi: " + error);
                            }
                        });
                    });
                </script>
            `;

            $("#Function").html(htmlContent);
        },
        error: function(xhr, status, error) {
            console.error("Lỗi Ajax khi lấy dữ liệu:", error);
            alert("Không thể lấy thông tin khuyến mãi!");
        }
    });
}


function SuaRole(x){
    console.log(x);
    var RoleID = x;
    $.ajax({
        type: "POST",
        url: "../admin/form.php",
        data: { roleID: RoleID },
        dataType: "json",
        success: function(response) {
            console.log({response});
            $("#overlay-chucnang").css("display", "block");
            $("#Function").html(
                `
                <h2>Chỉnh sửa quyền ${response[0].RoleName} </h2>
                <input type="button" value="X" class="blue-btn" onclick="Close_ChucNang()">
                <form id="role-form" class="product-add-form">
                <input type="hidden" id="RoleID" name="RoleID" value="${response[0].RoleID}">
                <table>
                    <tr>
                        <th>Tên chức năng </th>
                        <th>Xem </th>
                        <th>Thêm </th>
                        <th>Sửa </th>
                        <th>Xóa </th>
                    </tr>
                    <tr>
                        <th>Quản lý tài khoản</th>
                        <td><input type='checkbox' name='XemTK' value='Xem'></input></td>
                        <td><input type='checkbox' name='TTK' value='Thêm'></input></td>
                        <td><input type='checkbox' name='STK' value='Sửa'></input></td>
                        <td><input type='checkbox' name='XTK' value='Xóa'></input></td>
                    </tr>
                    <tr>
                        <th>Quản lý sản phẩm</th>
                        <td><input type='checkbox' name='XemSP' value='Xem'></input></td>
                        <td><input type='checkbox' name='TSP' value='Thêm'></input></td>
                        <td><input type='checkbox' name='SSP' value='Sửa'></input></td>
                        <td><input type='checkbox' name='XSP' value='Xóa'></input></td>
                    </tr>
                    <tr>
                        <th>Quản lý hóa đơn nhập</th>
                        <td><input type='checkbox' name='XemHDN' value='Xem'></input></td>
                        <td><input type='checkbox' name='THDN' value='Thêm'></input></td>   
                        <td><input type='checkbox' name='SHDN' value='Sửa'></input></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Quản lý hóa đơn bán  </th>
                        <td><input type='checkbox' name='IHD' value='Xem'></input></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Quản lý nhân viên</th>
                        <td><input type='checkbox' name='XemNV' value='Xem'></input></td>
                        <td><input type='checkbox' name='TNV' value='Thêm'></input></td>
                        <td><input type='checkbox' name='SNV' value='Sửa'></input></td>
                        <td><input type='checkbox' name='XNV' value='Xóa'></input></td>
                    </tr>
                    <tr>
                        <th>Quản lý khách hàng</th>
                        <td><input type='checkbox' name='XemKH' value='Xem'></input></td>
                        <td></td>
                        <td><input type='checkbox' name='SKH' value='Sửa'></input></td>
                        <td><input type='checkbox' name='XKH' value='Xóa'></input></td>
                    <tr>
                        <th>Quản lý Quyền</th>
                        <td><input type='checkbox' name='XemRole' value='Xem'></input></td>
                        <td><input type='checkbox' name='TQ' value='Thêm'></input></td>
                        <td><input type='checkbox' name='SQ' value='Sửa'></input></td>
                        <td><input type='checkbox' name='XQ' value='Xóa'></input></td>
                    <tr>
                        <th>Quản lý chủng loại</th>
                        <td><input type='checkbox' name='XemCL' value='Xem'></input></td>
                        <td><input type='checkbox' name='TCL' value='Thêm'></input></td>
                        <td><input type='checkbox' name='SCL' value='Sửa'></input></td>
                        <td><input type='checkbox' name='XCL' value='Xóa'></input></td>
                    </tr>
                    <tr>
                        <th>Quản lý khuyến mãi</th>
                        <td><input type='checkbox' name='XemKM' value='Xem'></input></td>
                        <td><input type='checkbox' name='TKM' value='Thêm'></input></td>
                        <td><input type='checkbox' name='SKM' value='Sửa'></input></td>
                        <td><input type='checkbox' name='XKM' value='Xóa'></input></td>
                    </tr>
                    <tr>
                        <th>Quản lý nhà cung cấp</th>
                        <td><input type='checkbox' name='XemNCC' value='Xem'></input></td>
                        <td><input type='checkbox' name='TNCC' value='Thêm'></input></td>
                        <td><input type='checkbox' name='SNCC' value='Sửa'></input></td>
                        <td><input type='checkbox' name='XNCC' value='Xóa'></input></td>
                    </tr>
                    <tr>
                         <th>statistical</th>
                        <td><input type='checkbox' name='XemS' value='Xem'></input></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <input type="button" value="Xác Nhận Sửa" class="blue-btn SQ" onclick="SubmitEditRole()">
                </form>
                `  
            );        
            response.forEach(element => {
            if(element.FunctionID == "F001"){
                if(element.Option == "Xem"){
                    $("input[name='XemTK'][value='Xem']").prop("checked", true);
                }
                if(element.Option == "Thêm"){
                    $("input[name='TTK'][value='Thêm']").prop("checked", true);
                }
                if(element.Option == "Sửa"){
                    $("input[name='STK'][value='Sửa']").prop("checked", true);
                }
                if(element.Option == "Xóa"){
                    $("input[name='XTK'][value='Xóa']").prop("checked", true);
                }
            }
            if(element.FunctionID == "F002"){
                if(element.Option == "Xem"){
                    $("input[name='XemSP'][value='Xem']").prop("checked", true);
                }
                if(element.Option == "Thêm"){
                    $("input[name='TSP'][value='Thêm']").prop("checked", true);
                }
                if(element.Option == "Sửa"){
                    $("input[name='SSP'][value='Sửa']").prop("checked", true);
                }
                if(element.Option == "Xóa"){
                    $("input[name='XSP'][value='Xóa']").prop("checked", true);
                }
            }
            if(element.FunctionID == "F003"){
                if(element.Option == "Xem"){
                    $("input[name='XemHDN'][value='Xem']").prop("checked", true);
                }
                if(element.Option == "Thêm"){
                    $("input[name='THDN'][value='Thêm']").prop("checked", true);
                }
                if(element.Option == "Sửa"){
                    $("input[name='SHDN'][value='Sửa']").prop("checked", true);
                }
                if(element.Option == "Xóa"){
                    $("input[name='XHDN'][value='Xóa']").prop("checked", true);
                }
            }
            if(element.FunctionID == "F004"){
                if(element.Option == "Xem"){
                    $("input[name='IHD'][value='Xem']").prop("checked", true);
                }
            }
            if(element.FunctionID == "F005"){
                if(element.Option == "Xem"){
                    $("input[name='XemNV'][value='Xem']").prop("checked", true);
                }
                if(element.Option == "Thêm"){
                    $("input[name='TNV'][value='Thêm']").prop("checked", true);
                }
                if(element.Option == "Sửa"){
                    $("input[name='SNV'][value='Sửa']").prop("checked", true);
                }
                if(element.Option == "Xóa"){
                    $("input[name='XNV'][value='Xóa']").prop("checked", true);
                }
            }
            if(element.FunctionID == "F006"){
                if(element.Option == "Xem"){
                    $("input[name='XemKH'][value='Xem']").prop("checked", true);
                }
                if(element.Option == "Thêm"){
                    $("input[name='TKH'][value='Thêm']").prop("checked", true);
                }
                if(element.Option == "Sửa"){
                    $("input[name='SKH'][value='Sửa']").prop("checked", true);
                }
                if(element.Option == "Xóa"){
                    $("input[name='XKH'][value='Xóa']").prop("checked", true);
                }
            }
            if(element.FunctionID == "F007"){
                if(element.Option == "Xem"){
                    $("input[name='XemRole'][value='Xem']").prop("checked", true);
                }
                if(element.Option == "Thêm"){
                    $("input[name='TQ'][value='Thêm']").prop("checked", true);
                }
                if(element.Option == "Sửa"){
                    $("input[name='SQ'][value='Sửa']").prop("checked", true);
                }
                if(element.Option == "Xóa"){
                    $("input[name='XQ'][value='Xóa']").prop("checked", true);
                }
            }
            if(element.FunctionID == "F008"){
                if(element.Option == "Xem"){
                    $("input[name='XemCL'][value='Xem']").prop("checked", true);
                }
                if(element.Option == "Thêm"){
                    $("input[name='TCL'][value='Thêm']").prop("checked", true);
                }
                if(element.Option == "Sửa"){
                    $("input[name='SCL'][value='Sửa']").prop("checked", true);
                }
                if(element.Option == "Xóa"){
                    $("input[name='XCL'][value='Xóa']").prop("checked", true);
                }
            }
            if(element.FunctionID == "F009"){
                if(element.Option == "Xem"){
                    $("input[name='XemKM'][value='Xem']").prop("checked", true);
                }
                if(element.Option == "Thêm"){
                    $("input[name='TKM'][value='Thêm']").prop("checked", true);
                }
                if(element.Option == "Sửa"){
                    $("input[name='SKM'][value='Sửa']").prop("checked", true);
                }
                if(element.Option == "Xóa"){
                    $("input[name='XKM'][value='Xóa']").prop("checked", true);
                }
            }
            if(element.FunctionID == "F010"){
                if(element.Option == "Xem"){
                    $("input[name='XemNCC'][value='Xem']").prop("checked", true);
                }
                if(element.Option == "Thêm"){
                    $("input[name='TNCC'][value='Thêm']").prop("checked", true);
                }
                if(element.Option == "Sửa"){
                    $("input[name='SNCC'][value='Sửa']").prop("checked", true);
                }
                if(element.Option == "Xóa"){
                    $("input[name='XNCC'][value='Xóa']").prop("checked", true);
                }
            }
            if(element.FunctionID == "F011"){
                if(element.Option == "Xem"){
                    $("input[name='XemS'][value='Xem']").prop("checked", true);
                }
            }
            });
            
        }
    });
}

// Hàm xử lý khi người dùng nhấn "Xác Nhận Sửa"
function SubmitEditRole() {
    var RoleID = $("#RoleID").val();
    var permissions = [];

    $("#role-form input[type='checkbox']:checked").each(function () {
        var funcID = $(this).attr("name");
        permissions.push(funcID);
    });

    console.log(permissions);

    $.ajax({
        type: "POST",
        url: "/webbantruyen/handle/edit_role.php",
        data: JSON.stringify({
            RoleID: RoleID,
            Permissions: permissions
        }),
        contentType: "application/json",   // <-- Quan trọng
        dataType: "json",
        success: function (res) {
            console.log(res);
            alert(res.message);
            Close_ChucNang();
        },
        error: function (xhr) {
            console.log(xhr.responseText);
            alert("Lỗi: " + xhr.statusText);
        }
    });
}

function suaKH(customerID) {
    $("#overlay-chucnang").css("display", "block");
    $("#Function").css("display", "block");

    $.ajax({
        type: "POST",
        url: "/webbantruyen/view/admin/form.php", // file trả về dữ liệu khách hàng
        data: { customer_id: customerID },
        dataType: "json",
        success: function(response) {
            console.log({ response });

            let htmlContent = `
                <input type="button" value="X" class="close-btn" onclick="Close_ChucNang()">
                <h2 style='text-align:center; margin:30px;'>Sửa thông tin khách hàng</h2>
                <form id="customer-edit-form" class="product-add-form">
                    <div class="form-content" style="display:block">
                        <div class="right-panel">
                            <div style="display: none;">
                                <label for="customerID">Mã khách hàng:</label>
                                <input type="text" id="customerID" name="customerID" value="${response.customerID}" readonly>
                            </div>
                            <div>
                                <label for="fullname">Họ tên:</label>
                                <input type="text" id="fullname" name="fullname" value="${response.fullname}">
                            </div>
                            <div>
                                <label for="username">Tên đăng nhập:</label>
                                <input type="text" id="username" name="username" value="${response.username}" readonly>
                            </div>
                            <div>
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" value="${response.email}">
                            </div>
                            <div>
                                <label for="address">Địa chỉ:</label>
                                <input type="text" id="address" name="address" value="${response.address}">
                            </div>
                            <div>
                                <label for="phone">SĐT:</label>
                                <input type="text" id="phone" name="phone" value="${response.phone}">
                            </div>
                        </div>
                    </div>
                    <div class="product-form-button">
                        <button type="button" id="edit-customer-submit-btn" class="add-product-submit-btn blue-btn">Sửa</button>
                        <input type="reset" value="Reset" class="reset-btn blue-btn">
                    </div>
                </form>

                <script>
                    $("#edit-customer-submit-btn").on("click", function (e) {
                        e.preventDefault();
                        const customerID = $("#customerID").val();
                        const fullname = $("#fullname").val();
                        const email = $("#email").val();
                        const address = $("#address").val();
                        const phone = $("#phone").val();

                        if (!fullname || !email || !address || !phone) {
                            alert("Vui lòng điền đầy đủ thông tin!");
                            return;
                        }

                        $.ajax({
                            type: "POST",
                            url: "/webbantruyen/handle/editCustomer.php",
                            data: {
                                customerID,
                                fullname,
                                email,
                                address,
                                phone
                            },
                            dataType: "json",
                            success: function (response) {
                                if (response.success) {
                                    alert("Cập nhật thông tin khách hàng thành công!");

                                    const row = document.querySelector("#customer-row-" + customerID);
                                    if (row) {
                                        row.children[1].textContent = fullname;
                                        row.children[3].textContent = email;
                                        row.children[4].textContent = address;
                                        row.children[5].textContent = phone;
                                    }

                                    Close_ChucNang();
                                } else {
                                    alert("Sửa thất bại: " + response.message);
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error("Lỗi Ajax:", error);
                                alert("Lỗi: " + error);
                            }
                        });
                    });
                </script>
            `;

            $("#Function").html(htmlContent);
        },
        error: function(xhr, status, error) {
            console.error("Lỗi Ajax khi lấy dữ liệu:", error);
            alert("Không thể lấy thông tin khách hàng!");
        }
    });
}


function SuaTK(x) {
    let UsernameOld;
    let hashPass;

    $.ajax({
        type: "POST",
        url: "../admin/form.php",
        data: { Username: x },
        dataType: "json",
        success: function (response) {
            UsernameOld = response.username;
            hashPass = response.Password;

            $("#overlay-chucnang").css("display", "block");

            $.get("../admin/get-employee-options.php", function (optionsHTML) {
                $("#Function").html(`
                    <div class='ThemNV employee-card'>
                        <button value='X' class='blue-btn' onclick='Close_ChucNang()'>Close</button>
                        <form>
                            <label><strong>Username:</strong></label>
                            <input type="text" name="username" id="Username" value="${response.username}"><br>

                            <label><strong>Password Old:</strong></label>
                            <input type="password" id="PasswordOld"><br>

                            <label><strong>Password New:</strong></label>
                            <input type="password" id="PasswordNew"><br>

                            <label><strong>RoleID:</strong></label>
                            ${response.RoleID}<br>

                            <label><strong>EmployeeID:</strong></label>
                            <select id="EmployeeID">${optionsHTML}</select><br>

                            <label><strong>isDeleted:</strong></label>
                            <select id="isDeleted">
                                <option value='0'>0</option>
                                <option value='1'>1</option>
                            </select><br>

                            <input type='submit' id='ThemTKSubmit' value='Xác nhận sửa' class='blue-btn'>
                            <input type='reset' value='Nhập lại' class='blue-btn'>
                        </form>
                    </div>
                `);

                // Set isDeleted value
                $("#isDeleted").val(response.isDeleted);

                // Load danh sách Username sau khi form đã sẵn sàng
                $.ajax({
                    type: 'POST',
                    url: '../../view/admin/AccList.php',
                    dataType: "json",
                    success: function (DSUsername) {
                        // Gắn sự kiện nút submit sau khi danh sách đã sẵn sàng
                        $('#ThemTKSubmit').on('click', function (e) {
                            e.preventDefault();
                            const UsernameNew = $('#Username').val();
                            const PasswordOld = $('#PasswordOld').val();
                            const PasswordNew = $('#PasswordNew').val();
                            const EmployeeID = $('#EmployeeID').val();
                            const IsDeleted = $('#isDeleted').val();

                            // Kiểm tra dữ liệu nhập
                            if (UsernameNew.trim() === '' || PasswordOld.trim() === '' || PasswordNew.trim() === '') {
                                alert('Vui lòng điền đầy đủ thông tin!');
                                return;
                            }

                            if (PasswordNew.length < 6) {
                                alert("Mật khẩu phải có ít nhất 6 ký tự!");
                                return;
                            }

                            const nameRegex = /^[a-zA-Z0-9]+$/;
                            if (!nameRegex.test(UsernameNew)) {
                                alert('Username không chứa ký tự đặc biệt, khoảng trắng và dấu!');
                                return;
                            }

                            let DSname = [];
                            DSname = DSUsername.split(",");
                            console.log(DSname)
                            DSname.forEach(element => {
                                if (UsernameNew === element && UsernameNew !== UsernameOld) {
                                    alert('Username đã tồn tại!');
                                    return;
                                }
                            });

                            // Gửi yêu cầu kiểm tra mật khẩu cũ
                            $.ajax({
                                type: 'POST',
                                url: '../../view/admin/CheckPass.php',
                                data: {
                                    PasswordOld: PasswordOld,
                                    hashPass: hashPass,
                                },
                                dataType: "json",
                                success: function (isCorrect) {
                                    if (!isCorrect) {
                                        alert('Mật khẩu cũ không đúng!');
                                        return;
                                    }

                                    if (PasswordNew === PasswordOld) {
                                        alert('Mật khẩu mới không được giống mật khẩu cũ!');
                                        return;
                                    }

                                    // Gửi yêu cầu sửa
                                    $.ajax({
                                        type: 'POST',
                                        url: '../../handle/edit_account.php',
                                        data: {
                                            UsernameOld: UsernameOld,
                                            UsernameNew: UsernameNew,
                                            PasswordNew: PasswordNew,
                                            EmployeeID: EmployeeID,
                                            IsDeleted: IsDeleted,
                                        },
                                        dataType: "json",
                                        success: function (res) {
                                            if (res.status === "success") {
                                                alert("Sửa thông tin tài khoản thành công");
                                                location.reload();
                                            } else {
                                                alert("Lỗi: " + res.message);
                                            }
                                        },
                                        error: function () {
                                            alert("Lỗi khi gửi yêu cầu cập nhật!");
                                        }
                                    });
                                },
                                error: function () {
                                    alert("Lỗi khi kiểm tra mật khẩu!");
                                }
                            });
                        });
                    },
                    error: function () {
                        alert("Không thể lấy danh sách tài khoản!");
                    }
                });
            });
        },
        error: function () {
            alert("Không thể lấy dữ liệu người dùng!");
        }
    });
}

function SuaNV(x){
    $.ajax({        
        type: "POST",
        url: "../admin/form.php",
        data: { EmployeeID: x },
        dataType: "json",
        success: function(response) {
            console.log({response});
            $("#overlay-chitiet").css("display","block");   
            $("#ChiTiet").html(
                `
                <div class='ThemNV'>
                    <button value='X' class='blue-btn' onclick='Close_ChucNang()'>Close</button>
                    <form>
                        <label>ID:${response["employeeID"]}</label>

                        <label>Fullname:</label>
                        <input type='text' name='Fullname' id='Fullname' value='${response["fullname"]}'>

                        <label>BirthDay:</label>
                        <input type='date' name='BirthDay' id='BirthDay' value='${response["birthDay"]}'>

                        <label>Phone:</label>
                        <input type='text' name='Phone' id="Phone" value='${response["phone"]}'>

                        <label>Email:</label>
                        <input type='email' name='Email' id="Email" value='${response["email"]}'>

                        <label>Address:</label>
                        <input type='text' name='Address' id="Address" value='${response["address"]}'>

                        <div class='gender-group'>
                            <label>Gender:</label>
                            <input type='radio' name='Gender' id="GenderNu" value='NỮ'>Nữ
                            <input type='radio' name='Gender' id="GenderNam" value='NAM' >Nam
                        </div>

                        <label>Salary:</label>
                        <input type='text' name='Salary' id="Salary" value='${response["salary"]}' >

                        <label>startDate:${response["startDate"]}</label>
                
                        <label>isDeleted</label>
                        <select name='isDeleted' id='isDeleted'>
                        <option value='0'>0</option>
                        <option value='1'>1</option>
                        </select><br>

                        <input type='submit' id='SuaNVSubmit' name='submit' value='Xác Nhận sửa' class='blue-btn'>
                        <input type='reset' name='reset' value='Nhập lại' class='blue-btn'>
                    </form>
                </div>
                `
            );   
            if(response.Gender === "Nữ"){
                $("#GenderNu").prop("checked",true);
            }else if(response.Gender === "Nam"){
                $("#GenderNam").prop("checked",true);
            }
             if(response.isDeleted === "0"){
                $("#isDeleted").val('0');
            }else if(response.isDeleted === "1"){
                $("#isDeleted").val('1');
            }

            $('#SuaNVSubmit').on('click', function (e) {
                        e.preventDefault();
                        const EmployeeID = response.employeeID;
                        const Fullname = $('#Fullname').val();
                        const BirthDay = $('#BirthDay').val();
                        const Phone = $('#Phone').val();
                        const Email = $('#Email').val();
                        const Address = $('#Address').val();
                        const Salary = $('#Salary').val();
                        const IsDeleted = $("#isDeleted").val();
                        let Gender = '';
                        if(($('#GenderNu').prop('checked'))){
                            Gender = $('#GenderNu').val();
                        }else if($('#GenderNam').prop('checked')){
                            Gender = $('#GenderNam').val();
                        }
                        if (
                        Fullname === '' ||
                        BirthDay === '' ||
                        Phone === '' ||
                        Email === '' ||
                        Address === '' ||
                        Salary === ''  ||
                        Gender === '' ||
                        (!$('#GenderNu').prop('checked') && !$('#GenderNam').prop('checked'))
                        ) {
                            alert('Vui lòng điền đầy đủ thông tin!');
                            return;
                        }
                        //Tên không chứa số và kí tự đặc biệt có quyền chứa số
                        const nameRegex = /^[a-zA-ZÀ-ỹ0-9\s]+$/;
                        console.log(Fullname)
                        if (!nameRegex.test(Fullname)) {
                            alert('Tên không chứa kí tự đặc biệt!');
                            return;
                        }

                        const phoneRegex = /^0\d{9}$/;
                        if (!phoneRegex.test(Phone)) {
                            alert('SĐT không hợp lệ!');
                            return;
                        }
                        const emailRegex = /^[^\n@]+@[^\n@]+\.(com)+$/;
                        if (!emailRegex.test(Email)) {
                            alert('Email không hợp lệ!');
                            return;
                        }


                        $.ajax({
                        type: 'POST',
                        url: '../../handle/edit_employee.php',
                        data: {
                            EmployeeID : EmployeeID,
                            Fullname : Fullname,
                            BirthDay : BirthDay,
                            Phone : Phone,
                            Email : Email,
                            Address : Address,
                            Salary : Salary,
                            Gender : Gender,
                            IsDeleted : IsDeleted,
                        },
                        dataType:"json",
                        success:function (response) {
                        console.log(response);
                        if (response.status==="success") {
                            alert("Sửa thông tin nhân viên thành công");
                        } else {
                            alert("Có lỗi xảy ra, vui lòng thử lại sau: " + response.message);
                        }
                        location.reload();
                        },
                        })
                    })
            }     
    
    })

}
