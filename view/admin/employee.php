<?php
echo"
    <table>
        <tr>
            <th>Tên</th>
            <th>Mật khẩu</th>
            <th>Role</th>
            <th>Status</th>
        </tr>";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
        $conn = connectDB::getConnection();
        $sql_data_acc = 'SELECT * FROM `role` INNER JOIN account ON role.RoleID=account.RoleID
                        WHERE role.RoleID="R1" OR role.RoleID="R2" ';
        $result_acc = $conn->query($sql_data_acc);
        while ($row = $result_acc->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["Username"] . "</td>
                    <td>" . $row["Password"].  "</td>
                    <td>" . $row["RoleName"] . "</td>
                    <td>" . $row["Status"].  "</td>
                </tr>";
        }
        $conn->close();
echo "
    </table>"
?>