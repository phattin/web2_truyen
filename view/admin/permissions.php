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
                    <td>" . $row["Username"]."</td>";

                    $sql_options = 'SELECT `RoleName` FROM `role`';
                    $result_options = $conn->query($sql_options);
                    $options = [];
                    // Lặp qua các kết quả và thêm vào mảng
                    while ($row_options = $result_options->fetch_assoc()) {
                        $options[] = $row_options["RoleName"];
                    }
                    // Thêm option mới vào mảng
                    // Bắt đầu thẻ select
                    echo "<td><select name='role'; id='".$row["Username"]."'>";
                    // Lặp qua mảng và tạo các thẻ option
                    foreach ($options as $option) {
                        echo "<option value=\"$option\">$option</option>";
                    }
                    // Kết thúc thẻ select
                    echo '</select>
                        </td>';
                "</tr>";
        }
        $conn->close();
echo "
    </table>
    <input type='button' class='blue-btn SQ' onclick='LuuRole()' style='width:100%' value='Lưu'>
    <script src='../layout/js/permissions.js'></script>
</html>"
/*
    
        */
?>