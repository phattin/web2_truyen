<?php
echo"
<html>
    <table id='table_role'>
        <tr>
            <th>Tên</th>
            <th>Role</th>
        </tr>";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
        $conn = connectDB::getConnection();
        $sql_data_acc = 'SELECT * FROM `role` INNER JOIN account ON role.RoleID=account.RoleID ';
        $result_acc = $conn->query($sql_data_acc);
        while ($row = $result_acc->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["Username"]."</td>
                    <td><select name='role'; id='".$row["Username"]."';>
                        <option value='Nhân viên'> Nhân viên </option>
                        <option value='Khách hàng'> khách hàng </option>
                        <option value='Admin'> Admin </option>
                    </select></td>
                </tr>";
        }
        $conn->close();
echo "
    </table>
    <input type='button' class='blue-btn' onclick='LuuRole()' style='width=100%'>Lưu</input>
    <script src='../layout/js/permissions.js'></script>
</html>"
/*
    
        */
?>