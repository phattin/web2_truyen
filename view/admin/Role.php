<?php
echo"<table>
        <tr>
            <th>ROLE ID</th>
            <th>Tên ROLE</th>
        </tr>".
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
            $conn = connectDB::getConnection();
            $sql_data_acc = 'SELECT * FROM `role`';
            $result_acc = $conn->query($sql_data_acc);
            while ($row = $result_acc->fetch_assoc()) {
                echo "<tr onclick='ChitietRole()'>
                        <td>" . $row["RoleID"] . "</td>
                        <td>" . $row["RoleName"] . "</td>
                    </tr>";
            }
            $conn->close();"
    </table>

"



/*
echo "
    <table>
        <tr>
            <th>Tên chức năng </th>
            <th>Thêm </th>
            <th>Sửa </th>
            <th>Xóa </th>
        </tr>
        <tr>
            <th>Quản lý tài khoản</th>
            <td><input type='checkbox' name='Quản lý tài khoản' value='Thêm'></td>
            <td><input type='checkbox' name='Quản lý tài khoản' value='Sửa'></td>
            <td><input type='checkbox' name='Quản lý tài khoản' value='Xóa'></td>
        </tr>
        <tr>
            <th>Quản lý sản phẩm</th>
            <td><input type='checkbox' name='Quản lý sản phẩm' value='Thêm'></td>
            <td><input type='checkbox' name='Quản lý sản phẩm' value='Sửa'></td>
            <td><input type='checkbox' name='Quản lý sản phẩm' value='Xóa'></td>
        </tr>
        <tr>
            <th>Quản lý hóa đơn</th>
            <td><input type='checkbox' name='Quản lý hóa đơn' value='Thêm'></td>
            <td><input type='checkbox' name='Quản lý hóa đơn' value='Sửa'></td>
            <td><input type='checkbox' name='Quản lý hóa đơn' value='Xóa'></td>
        </tr>
    </table>"
*/
?>