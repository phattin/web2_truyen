<input type="button" value="X" class="close-btn" onclick="Close_ChucNang()">
<h2 style='text-align:center; margin:30px;'>Thêm nhà cung cấp</h2>
<form id="supplier-add-form" class="product-add-form">
    <div class="form-content" style='display:block'>
        <div class="right-panel">
            <div style="display: none;">
                <label for="supplierID">Mã nhà cung cấp:</label>
                <?php 
                    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/supplierDB.php";
                    echo '<input type="text" id="supplierID" name="supplierID" value="'.supplierDB::getNewSupplierID().'" readonly>';
                ?>
            </div>
            <div>
                <label for="supplierName">Tên nhà cung cấp:</label>
                <input type="text" id="supplierName" name="supplierName">
            </div>
            <div>
                <label for="phone">Số điện thoại:</label>
                <input type="text" id="phone" name="phone">
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
            </div>
            <div>
                <label for="address">Địa chỉ:</label>
                <input type="text" id="address" name="address">
            </div>
        </div>
    </div>
    <div class="product-form-button">
        <button type="button" id="add-supplier-submit-btn" class="add-product-submit-btn blue-btn">Thêm</button>
        <input type="reset" value="Reset" class="reset-btn blue-btn">
    </div>
</form>
<script>
    $("#add-supplier-submit-btn").on("click", function (e) {
        e.preventDefault();

        const supplierID = $("#supplierID").val();
        const supplierName = $("#supplierName").val();
        const phone = $("#phone").val();
        const email = $("#email").val();
        const address = $("#address").val();

        if (!supplierName || !phone || !email || !address) {
            alert("Vui lòng điền đầy đủ thông tin!");
            return;
        }

        $.ajax({
            type: "POST",
            url: "/webbantruyen/handle/addSupplier.php",
            data: {
                supplierID,
                supplierName,
                phone,
                email,
                address
            },
            dataType: "json",
            success: function (response) {
                console.log("response:", response);
                if (response.success) {
                    alert("Thêm nhà cung cấp thành công!");

                    const table = document.querySelector(".product-admin-table");
                    const row = table.insertRow(-1);
                    row.id = "supplier-row-" + supplierID;

                    row.insertCell(0).innerText = supplierID;
                    row.insertCell(1).innerText = supplierName;
                    row.insertCell(2).innerText = phone;
                    row.insertCell(3).innerText = email;
                    row.insertCell(4).innerText = address;

                    const actions = `
                        <i class='fa-regular fa-pen-to-square edit-icon' onclick='suaNCC("${supplierID}")'></i>
                        <i class='fa-regular fa-trash-can delete-icon' onclick='xoaNCC("${supplierID}")'></i>
                    `;
                    const cell = row.insertCell(5);
                    cell.innerHTML = actions;
                    cell.classList.add("function-icon");

                    Close_ChucNang();
                } else {
                    alert("Thêm thất bại: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Lỗi Ajax:", error);
                alert("Lỗi: " + error);
            }
        });
    });

    function Close_ChucNang() {
        document.getElementById("overlay-chucnang").style.display = "none";
        document.getElementById("Function").style.display = "none";
    }
</script>
