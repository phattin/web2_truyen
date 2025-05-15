
<?php
echo"
    <input type='button' value='Thêm' class='blue-btn TTK' onclick='ThemTK()' style='width:100%;'>
    <table>
        <tr>
            <th>Username</th>
            <th>RoleID</th>
            <th>IsDeleted</th>
            <th>Chức Năng</th>
        </tr>";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
        $conn = connectDB::getConnection();
        $sql_data_acc = 'SELECT * FROM `account` ';
        $result_acc = $conn->query($sql_data_acc);
        while ($row = $result_acc->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["Username"] . "</td>
                    <td>" . $row["RoleID"].  "</td>
                    <td>" . $row["IsDeleted"] . "</td>
                    <td class='function-icon'>
                        <i class='fa-regular fa-eye detail-icon XemTK' onclick='ChitietTK(\"" . $row["Username"] . "\") ')'></i>
                        <div class='STK'><i class='fa-regular fa-pen-to-square edit-icon ' onclick='SuaTK(\"" . $row["Username"] . "\") ')'></i></div>
                        <div class='XTK'><i class='fa-regular fa-trash-can delete-icon '  onclick='XoaTK(\"".$row["Username"]."\")'></i></div>
                    </td>
                </tr>";
        }
        $conn->close();
echo "
    </table>"
?>