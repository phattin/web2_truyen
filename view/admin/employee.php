
<?php
echo"
    <input type='button' value='Thêm' class='blue-btn TNV' onclick='ThemNV()' style='width:100%;'>
    <table>
        <tr>
            <th>EmployeeID</th>
            <th>Fullname</th>
            <th>Username</th>
            <th>Status</th>
        </tr>";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
        $conn = connectDB::getConnection();
        $sql_data_acc = 'SELECT * FROM `employee` ';
        $result_acc = $conn->query($sql_data_acc);
        while ($row = $result_acc->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["EmployeeID"] . "</td>
                    <td>" . $row["Fullname"].  "</td>
                    <td>" . $row["Username"] . "</td>
                    <td class='function-icon'>
                        <i class='fa-regular fa-eye detail-icon XemVN' onclick='ChitietNV(\"" . $row["EmployeeID"] . "\") ')'></i>
                        <div class='SNV'><i class='fa-regular fa-pen-to-square edit-icon ' onclick='SuaNV(\"" . $row["EmployeeID"] . "\") ')'></i></div>
                        <div class='XNV'><i class='fa-regular fa-trash-can delete-icon '  onclick='XoaNV(\"".$row["EmployeeID"]."\")'></i></div>
                    </td>
                </tr>";
        }
        $conn->close();
echo "
    </table>"
?>