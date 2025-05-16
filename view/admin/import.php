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
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/roleDB.php";

$isLoggedIn = isset($_SESSION['username']) && isset($_SESSION['role']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
$role = $isLoggedIn ? $_SESSION['role'] : '';
$functionDetail = roleDB::getAllFunctionDetailByRoleID($role);
// Phân quyền F003 - quản lý hóa đơn nhập
$canAdd = $canView = $canEdit = false;

foreach ($functionDetail as $function) {
    if ($function["FunctionID"] === "F003") {
        if ($function["Option"] === "Thêm") $canAdd = true;
        if ($function["Option"] === "Xem")  $canView = true;
        if ($function["Option"] === "Sửa")  $canEdit = true;
    }
}

if ($canAdd) {
    echo "<input type='button' value='Nhập hàng' class='blue-btn THDN' onclick='themHDN()' style='width:100%;'>";
}

if ($canView) {
    echo "<table class='product-admin-table'>
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

        $selectDisabled = (!$canEdit || $import["Status"] == "Đã nhận" || $import["Status"] == "Đã hủy") ? "disabled" : "";

        echo "<tr id='import-row-".$import["ImportID"]."'>
                <td>" . htmlspecialchars($import["ImportID"]) . "</td>
                <td>" . htmlspecialchars(employeeDB::getEmployeeByID($import["EmployeeID"])["Fullname"]) . "</td>
                <td>" . htmlspecialchars(supplierDB::getSupplierByID($import["SupplierID"])["SupplierName"]) . "</td>
                <td>" . htmlspecialchars($import["Date"]) . "</td>
                <td>" . htmlspecialchars($import["TotalPrice"]) . "</td>
                <td>
                    <select class='$class' id='status-".$import["ImportID"]."' $selectDisabled onchange='updateStatus(`".$import["ImportID"]."`)'>
                        <option value='Đã đặt' ".($import["Status"] == 'Đã đặt' ? 'selected' : '').">Đã đặt</option>
                        <option value='Đã nhận' ".($import["Status"] == 'Đã nhận' ? 'selected' : '').">Đã nhận</option>
                        <option value='Đã hủy' ".($import["Status"] == 'Đã hủy' ? 'selected' : '').">Đã hủy</option>
                    </select>
                </td>
                <td class='function-icon'>";

        if ($canView) {
            echo "<i class='fa-regular fa-eye detail-icon XemHDN' onclick='ChitietHDN(`".$import["ImportID"]."`)'></i>";
        }

        echo "</td></tr>";
    }

    echo "</table>";
}
?>

<script>
function updateStatus(importID) {
    const select = document.getElementById("status-" + importID);
    if (select.disabled) return;

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
                    select.disabled = true;
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
