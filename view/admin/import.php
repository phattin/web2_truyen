<style>
.status-blue {
    background-color: #cce5ff;
    color: #004085;
    font-weight: bold;
}

.status-green {
    background-color: #d4edda;
    color: #155724;
    font-weight: bold;
}

.status-red {
    background-color: #f8d7da;
    color: #721c24;
    font-weight: bold;
}
</style>

<?php
echo"
    <input type='button' value='Nhập hàng' class='blue-btn' onclick='themHDN()' style='width:100%;'>
    <table class='product-admin-table'>
        <tr>
            <th>Mã hóa đơn nhập</th>
            <th>Tên nhân viên</th>
            <th>Tên nhà cung cấp</th>
            <th>Ngày nhập</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/importDB.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/employeeDB.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/supplierDB.php";
        $imports = importDB::getAllImports();
        foreach ($imports as $import) {
            $class = "";
            if ($import["Status"] == "Đã đặt") $class = "status-blue";
            elseif ($import["Status"] == "Đã nhận") $class = "status-green";
            elseif ($import["Status"] == "Đã hủy") $class = "status-red";
            echo "<tr id='import-row-".$import["ImportID"]."'>
                    <td>" . $import["ImportID"] . "</td>
                    <td>" . employeeDB::getEmployeeByID($import["EmployeeID"])["Fullname"] . "</td>
                    <td>" . supplierDB::getSupplierByID($import["SupplierID"])["SupplierName"] . "</td>
                    <td>" . $import["Date"] . "</td>
                    <td>" . $import["TotalPrice"] . "</td>
                    <td>";
                    $disabled = ($import["Status"] == "Đã nhận" || $import["Status"] == "Đã hủy") ? "disabled" : "";

                    echo "<select class='$class' id='status-".$import["ImportID"]."' $disabled onchange='updateStatus(`".$import["ImportID"]."`)'>
                            <option value='Đã đặt' ".($import["Status"] == 'Đã đặt' ? 'selected' : '').">Đã đặt</option>
                            <option value='Đã nhận' ".($import["Status"] == 'Đã nhận' ? 'selected' : '').">Đã nhận</option>
                            <option value='Đã hủy' ".($import["Status"] == 'Đã hủy' ? 'selected' : '').">Đã hủy</option>
                        </select>
                    </td>
                    <td class='function-icon'>
                        <i class='fa-regular fa-eye detail-icon' onclick='ChitietHDN(`".$import["ImportID"]."`)'></i>
                    </td>
                </tr>";
        }
echo "
    </table>
    ";

?>
<script>
function updateStatus(importID) {
    const select = document.getElementById("status-" + importID);
    if (select.disabled) return; // không xử lý nếu bị disable

    const newStatus = select.value;

    $.ajax({
        url: "/webbantruyen/handle/editImport.php",
        method: "POST",
        data: {
            action: "updateStatus",
            importID: importID,
            status: newStatus
        },
        success: function(res) {
            if (res.trim() === "success") {
                alert("Cập nhật trạng thái thành công!");

                if (newStatus === "Đã nhận" || newStatus === "Đã hủy") {
                    select.disabled = true; // khóa select luôn
                }

                select.className = "";
                if (newStatus === "Đã đặt") select.classList.add("status-blue");
                else if (newStatus === "Đã nhận") select.classList.add("status-green");
                else if (newStatus === "Đã hủy") select.classList.add("status-red");
            } else {
                console.log("Cập nhật thất bại: " + res);
            }
        },
        error: function(xhr) {
            console.log("Lỗi AJAX: " + xhr.responseText);
        }
    });
}
</script>