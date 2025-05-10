<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";

echo "
    <input type='button' value='Thêm' class='blue-btn' onclick='ThemRole()' style='width:100%;'>
    <table>
        <tr>
            <th>ROLE ID</th>
            <th>Tên ROLE</th>
        </tr>
";

$conn = connectDB::getConnection();
$sql_data_acc = 'SELECT * FROM `role`';
$result_acc = $conn->query($sql_data_acc);
while ($row = $result_acc->fetch_assoc()) {
    echo "<tr onclick='ChitietRole()'>
            <td>" . $row["RoleID"] . "</td>
            <td>" . $row["RoleName"] . "</td>
        </tr>";
}
$conn->close();

echo "</table>";
?>
