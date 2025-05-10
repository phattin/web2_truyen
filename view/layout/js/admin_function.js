// Them San Pham
function ThemSP(){
    $("#overlay-chucnang").css("display","block");
    $("#Function").css("display","block");
    $("#Function").load("/webbantruyen/view/admin/ThemSP.php");
}
function editSP(product_id){
    
    $.ajax({
        type: "POST",
        url: "/webbantruyen/view/admin/form.php",
        data: { product_id: product_id },
        dataType: "json",
        success: function(response) {
            console.log({response});
            $("#overlay-chucnang").css("display","block");
            $("#Function").css("display","block");
            $("#ChucNang").html(
                `
                <input type="button" value="X" class="close-btn" onclick="Close_ChucNang()">
                <h2 style='text-align:center; margin:30px;'>Sửa sản phẩm</h2>
                <form id="product-add-form" class="product-add-form">
                    <div class="form-content">
                        <div class="left-panel">
                            <div class="image-upload-container">
                                <label for="image-upload">Hình ảnh sản phẩm:</label>
                                <input type="file" id="image-upload" name="productImage" accept="image/*">
                                <img id="preview" src="#" alt="Xem trước" style="display:none;">
                            </div>
                        </div>
                
                        <div class="right-panel">
                            <div >
                                <label for="productID">Mã sản phẩm:</label>
                                <?php 
                                    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/productDB.php";
                                    echo '<input type="text" id="productID" name="productID" readonly>'
                                ?>
                            </div>
                            <div>
                                <label for="productName">Tên truyện:</label>
                                <input type="text" id="productName" name="productName">
                            </div>
                            <div>
                                <label for="author">Tác giả:</label>
                                <input type="text" id="author" name="author">
                            </div>
                            <div>
                                <label for="publisher">NXB:</label>
                                <input type="text" id="publisher" name="publisher">
                            </div>
                            <div style="display: none;">
                                <label for="stock">Kho:</label>
                                <input type="number" id="stock" name="stock" value="0" readonly>
                            </div>
                            <div style="display: none;">
                                <label for="price">Giá nhập:</label>
                                <input type="number" id="importPrice" value="0" name="price" readonly>
                            </div>
                            <div style="display: none;">
                                <label for="ros">ROS:</label>
                                <input type="number" step="0.01" id="ros" value="0" name="ros" readonly>
                            </div>
                            <div>
                                <label for="description">Mô tả:</label>
                                <input type="text" id="description" name="description">
                            </div>
                            <div>
                                <label for="supplier">Nhà cung cấp:</label>
                                <select id="supplier" name="supplier">
                                    <?php
                                    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/supplierDB.php";
                                    $suppliers = supplierDB::getAllSupplier();
                                    foreach ($suppliers as $supplier) {
                                        echo "<option value='" . $supplier["SupplierID"] . "'>" . $supplier["SupplierName"] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="product-form-button">
                        <button type="button" id="add-product-submit-btn" class="add-product-submit-btn blue-btn">Thêm</button>
                        <input type="reset" value ="Reset" class="reset-btn blue-btn">
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
                            const table = document.querySelector(".product-admin-table");
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
                </script>
                `  
            );        
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

// Them Nhan Vien
function ThemNV(){
    $("#Function").css("display","block");
    $("#ChiTiet").css("display","none");
    $("#Function").load("/webbantruyen/view/admin/ThemNV.php");
}   


// Them Khach Hang
function ThemKH(){
    $("#Function").css("display","block");
    $("#ChiTiet").css("display","none");
    $("#Function").load("/webbantruyen/view/admin/ThemKH.php");
}


// Them ROLE
function ThemRole(){
     $("#overlay-chucnang").css("display","block");
    $("#Function").css("display","block");
    $("#Function").load("/webbantruyen/view/admin/ThemRole.php");
}