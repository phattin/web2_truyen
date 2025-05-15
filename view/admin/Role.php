<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
$conn = connectDB::getConnection();
$sql_data_acc = 'SELECT * FROM `role`';
$result_acc = $conn->query($sql_data_acc);

echo "
    <input type='button' value='Thêm' class='blue-btn TQ' onclick='ThemRole()' style='width:100%;'>
    <table>
        <tr>
            <th>ROLE ID</th>
            <th>Tên ROLE</th>
            <th>Chức năng</th>
        </tr>";

while ($row = $result_acc->fetch_assoc()) {
    echo "<tr >
            <td>" . $row["RoleID"] . "</td>
            <td>" . $row["RoleName"] . "</td>
            <td class='function-icon'>
                <i class='fa-regular fa-eye detail-icon XemQ' onclick='ChitietRole(\"" . $row["RoleID"] . "\") ')'></i>
                <div class='SSP'><i class='fa-regular fa-pen-to-square edit-icon ' onclick='SuaRole(\"" . $row["RoleID"] . "\") ')'></i></div>
                <div class='XSP'><i class='fa-regular fa-trash-can delete-icon '  onclick='XoaRole(\"".$row["RoleID"]."\")'></i></div>
            </td>
          </tr>";
}

echo "</table>";

$conn->close();
?>
