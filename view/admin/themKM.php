<input type="button" value="X" class="close-btn" onclick="Close_ChucNang()">
<h2 style='text-align:center; margin:30px;'>Thêm khuyến mãi</h2>
<form id="product-add-form" class="product-add-form">
    <div class="form-content" style='display:block'>
        <div class="right-panel">
            <div style="display: none;">
                <label for="promotionID">Mã khuyến mãi:</label>
                <?php 
                    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/promotionDB.php";
                    echo '<input type="text" id="promotionID" name="promotionID" value="'.promotionDB::getNewPromotionID().'" readonly>';
                ?>
            </div>
            <div>
                <label for="promotionName">Tên khuyến mãi:</label>
                <input type="text" id="promotionName" name="promotionName">
            </div>
            <div>
                <label for="discount">Giá trị giảm (%):</label>
                <input type="number" id="discount" name="discount" min="1" max="100">
            </div>
            <div>
                <label for="startDate">Ngày bắt đầu:</label>
                <input type="date" id="startDate" name="startDate">
            </div>
            <div>
                <label for="endDate">Ngày kết thúc:</label>
                <input type="date" id="endDate" name="endDate">
            </div>
        </div>
    </div>
    <div class="product-form-button">
        <button type="button" id="add-promotion-submit-btn" class="add-product-submit-btn blue-btn">Thêm</button>
        <input type="reset" value ="Reset" class="reset-btn blue-btn">
    </div>
</form>

<script>
    $("#add-promotion-submit-btn").on("click", function (e) {
        e.preventDefault();
        const promotionID = $("#promotionID").val();
        const promotionName = $("#promotionName").val();
        const discount = $("#discount").val();
        const startDate = formatDate($("#startDate").val());
        const endDate = formatDate($("#endDate").val());

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
            url: "/webbantruyen/handle/addPromotion.php",
            data: {
                promotionID,
                promotionName,
                discount,
                startDate,
                endDate
            },
            dataType: "json",
            success: function (response) {
                console.log("response:", response);
                if (response.success) {
                    alert("Thêm khuyến mãi thành công!");

                    const table = document.querySelector(".product-admin-table");
                    const row = table.insertRow(-1);
                    row.id = "promotion-row-" + promotionID;

                    row.insertCell(0).innerText = promotionID;
                    row.insertCell(1).innerText = promotionName;
                    row.insertCell(2).innerText = discount;
                    row.insertCell(3).innerText = startDate;
                    row.insertCell(4).innerText = endDate;

                    const actions = `
                        <i class='fa-regular fa-pen-to-square edit-icon' onclick='suaKM("${promotionID}")'></i>
                        <i class='fa-regular fa-trash-can delete-icon' onclick='xoaKM("${promotionID}")'></i>
                    `;
                    const cell = row.insertCell(5);
                    cell.innerHTML = actions;
                    cell.classList.add("function-icon");
                    Close_ChucNang();
                } else {
                    alert("Thêm khuyến mãi thất bại: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Lỗi Ajax:", error);
                console.log("Phản hồi từ server:", xhr.responseText); // Xem lỗi thật
                alert("Lỗi: " + error);
            }
        });
    });

    function Close_ChucNang() {
        document.getElementById("overlay-chucnang").style.display = "none";
        document.getElementById("Function").style.display = "none";
    }

    function formatDate(dateStr) {
        const date = new Date(dateStr);
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Tháng từ 0-11
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
</script>
