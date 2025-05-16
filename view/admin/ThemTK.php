<input type="button" value="X" class="close-btn" onclick="Close_ChucNang()">
<h2 style='text-align:center; margin:30px;'>Thêm tài khoản</h2>
<form id="account-add-form" class="product-add-form">
    <div class="form-content" style='display:block'>
        <div class="right-panel">
            <div>
                <label for="username">Tên đăng nhập:</label>
                <input type="text" id="username" name="username">
            </div>
            <div>
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password">
            </div>
            <div>
                <label for="employeeID">Nhân viên:</label>
                <select id="employeeID" name="employeeID">
                    <option value="">--Chọn nhân viên--</option>
                    <?php
                        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/employeeDB.php";
                        $employees = employeeDB::getAllEmployeeNoAccount();
                        foreach ($employees as $emp) {
                            echo "<option value='{$emp["EmployeeID"]}'>{$emp["EmployeeID"]} - {$emp["Fullname"]}</option>";
                        }
                    ?>
                </select>
            </div>
            <div>
                <label for="roleID">Chức vụ:</label>
                <select id="roleID" name="roleID">
                    <option value="">--Chọn vai trò--</option>
                    <?php
                        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/roleDB.php";
                        $roles = roleDB::getAllRole();
                        foreach ($roles as $role) {
                            echo "<option value='{$role["RoleID"]}'>{$role["RoleName"]}</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="product-form-button">
        <button type="button" id="add-account-submit-btn" class="add-product-submit-btn blue-btn">Thêm</button>
        <input type="reset" value="Reset" class="reset-btn blue-btn">
    </div>
</form>

<script>
    $("#add-account-submit-btn").on("click", function (e) {
        e.preventDefault();

        const username = $("#username").val().trim();
        const password = $("#password").val().trim();
        const employeeID = $("#employeeID").val();
        const roleID = $("#roleID").val();

        if (!username || !password || !employeeID || !roleID) {
            alert("Vui lòng điền đầy đủ thông tin!");
            return;
        }

        $.ajax({
            type: "POST",
            url: "/webbantruyen/handle/addAccount.php",
            data: {
                username,
                password,
                employeeID,
                roleID
            },
            dataType: "json",
            success: function (response) {
                console.log("response:", response);
                if (response.success) {
                    alert("Thêm tài khoản thành công!");

                    const table = document.querySelector(".product-admin-table");
                    const row = table.insertRow(-1);
                    row.id = "account-row-" + username;

                    row.insertCell(0).innerText = username;
                    row.insertCell(1).innerText = employeeID;
                    row.insertCell(2).innerText = roleID;

                    const actions = `
                        <i class='fa-regular fa-pen-to-square edit-icon' onclick='suaAccount("${username}")'></i>
                        <i class='fa-regular fa-trash-can delete-icon' onclick='xoaAccount("${username}")'></i>
                    `;
                    const cell = row.insertCell(3);
                    cell.innerHTML = actions;
                    cell.classList.add("function-icon");

                    Close_ChucNang();
                } else {
                    alert("Thêm tài khoản thất bại: " + response.message);
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
