<input type="button" value="X" class="close-btn" onclick="Close_ChucNang()">
<h2 style='text-align:center; margin:30px;'>Thêm nhân viên</h2>
<form id="employee-add-form" class="product-add-form">
    <div class="form-content" style='display:block'>
        <div class="right-panel">
            <div style="display: none;">
                <label for="employeeID">Mã nhân viên:</label>
                <?php 
                    require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/employeeDB.php";
                    echo '<input type="text" id="employeeID" name="employeeID" value="'.employeeDB::getNewEmployeeID().'" readonly>';
                ?>
            </div>
            <div>
                <label for="fullname">Họ tên:</label>
                <input type="text" id="fullname" name="fullname">
            </div>
            <div>
                <label for="gender">Giới tính:</label>
                <select id="gender" name="gender">
                    <option value="">--Chọn giới tính--</option>
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                </select>
            </div>
            <div>
                <label for="birthDay">Ngày sinh:</label>
                <input type="date" id="birthDay" name="birthDay">
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
            <div>
                <label for="salary">Lương:</label>
                <input type="number" id="salary" name="salary" min="0">
            </div>
            <div>
                <label for="startDate">Ngày vào làm:</label>
                <input type="date" id="startDate" name="startDate">
            </div>
        </div>
    </div>
    <div class="product-form-button">
        <button type="button" id="add-employee-submit-btn" class="add-product-submit-btn blue-btn">Thêm</button>
        <input type="reset" value="Reset" class="reset-btn blue-btn">
    </div>
</form>

<script>
    $("#add-employee-submit-btn").on("click", function (e) {
        e.preventDefault();

        const employeeID = $("#employeeID").val();
        const fullname = $("#fullname").val();
        const gender = $("#gender").val();
        const birthDay = formatDate($("#birthDay").val());
        const phone = $("#phone").val();
        const email = $("#email").val();
        const address = $("#address").val();
        const salary = $("#salary").val();
        const startDate = formatDate($("#startDate").val());

        if (!fullname || !gender || !birthDay || !phone || !email || !address || !salary || !startDate) {
            alert("Vui lòng điền đầy đủ thông tin!");
            return;
        }

        if (salary < 0) {
            alert("Lương phải lớn hơn hoặc bằng 0!");
            return;
        }

        $.ajax({
            type: "POST",
            url: "/webbantruyen/handle/addEmployee.php",
            data: {
                employeeID,
                fullname,
                gender,
                birthDay,
                phone,
                email,
                address,
                salary,
                startDate
            },
            dataType: "json",
            success: function (response) {
                console.log("response:", response);
                if (response.success) {
                    alert("Thêm nhân viên thành công!");

                    const table = document.querySelector(".product-admin-table");
                    const row = table.insertRow(-1);
                    row.id = "employee-row-" + employeeID;

                    row.insertCell(0).innerText = employeeID;
                    row.insertCell(1).innerText = fullname;
                    row.insertCell(2).innerText = gender;
                    row.insertCell(3).innerText = birthDay;
                    row.insertCell(4).innerText = phone;
                    row.insertCell(5).innerText = email;
                    row.insertCell(6).innerText = address;
                    row.insertCell(7).innerText = salary;
                    row.insertCell(8).innerText = startDate;

                    const actions = `
                        <i class='fa-regular fa-pen-to-square edit-icon' onclick='suaNV("${employeeID}")'></i>
                        <i class='fa-regular fa-trash-can delete-icon' onclick='xoaNV("${employeeID}")'></i>
                    `;
                    const cell = row.insertCell(9);
                    cell.innerHTML = actions;
                    cell.classList.add("function-icon");

                    Close_ChucNang();
                } else {
                    alert("Thêm nhân viên thất bại: " + response.message);
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

    function formatDate(dateStr) {
        const date = new Date(dateStr);
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
</script>
