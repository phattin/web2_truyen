<?php
echo"
    <input type='button' value='Thêm' class='blue-btn' onclick='ThemSP()' style='width:100%;'>
    <table>
        <tr>
            <th>Tên</th>
            <th>ID</th>
            <th>Tác giả</th>
            <th>Số lượng</th>
        </tr>";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
        $conn = connectDB::getConnection();
        $sql_data_acc = 'SELECT ProductName,ProductID,Author,Quantity FROM product';
        $result_acc = $conn->query($sql_data_acc);
        while ($row = $result_acc->fetch_assoc()) {
            echo "<tr onclick='ChitietSP(`".$row["ProductID"]."`)'>
                    <td>" . $row["ProductName"] . "</td>
                    <td>" . $row["ProductID"] . "</td>
                    <td>" . $row["Author"] . "</td>
                    <td>" . $row["Quantity"] . "</td>
                </tr>";
        }
        $conn->close();
echo "
    </table>
    "
?>