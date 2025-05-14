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
                            </div>
                        </div>
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
function Close_ChucNang(){
    $("#overlay-chucnang").css("display","none");
    $("#overlay-chitiet").css("display","none");
}
function Close_Chitiet(){
    $("#overlay-chucnang").css("display","none");
    $("#overlay-chitiet").css("display","none");
}

function SuaRole(x){
    console.log(x);
     $("#overlay-chucnang").css("display", "block");
    $("#Function").css("display", "block");
    var RoleID = x;
    $.ajax({
        type: "POST",
        url: "../admin/form.php",
        data: { roleID: RoleID },
        dataType: "json",
        success: function(response) {
            console.log({response});
            $("#overlay-chitiet").css("display","block");   
            $("#Function").html(
                `
                <h2>Chỉnh sửa quyền ${response[0].RoleName} </h2>
                <input type="button" value="X" class="blue-btn" onclick="Close_ChucNang()">
                <form action="../admin/SuaRole.php" method="POST">
                <input type="hidden" name="RoleID" value="${response[0].RoleID}">
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
                        <td><input type='checkbox' name='XHDN' value='Xóa'></input></td>
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
                        <td><input type='checkbox' name='TKH' value='Thêm'></input></td>
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
                        <td></td>
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
                <input type="submit" value="Xác Nhận Sửa" class="blue-btn SQ">
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