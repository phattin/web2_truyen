<!DOCTYPE html>
<html>
    <body>
        <form action="XLThemSP.php" method="get">
            <p>ProductName:</p><input type="text" name="ProductName">
            <p>ProductImg:</p><input type="text" name="ProductImg">
            <p>Author:</p><input type="text" name="Author">
            <p>Publisher:</p><input type="text" name="Publisher">
            <p>Quantity:</p><input type="text" name="Quantity">
            <p>ImportPrice:</p><input type="text" name="ImportPrice">
            <p>ROS:</p><input type="text" name="ROS">
            <p>Description:</p><input type="text" name="Description">
            <p>SupplierID:</p><select name="SupplierID" > 
                                <option value="S001">S001</option>
                                <option value="S002">S002</option>
                                <option value="S003">S003</option>
                                <option value="S004">S004</option>
                                <option value="S005">S005</option>
                                <option value="S006">S006</option>
                                <option value="S007">S007</option>
                                <option value="S008">S008</option>
                                <option value="S009">S009</option>
                                <option value="S010">S010</option>
                                </select>
            <p>Status:</p><select name="status" > 
                                <option value="Hiện">Hiện</option>
                                <option value="Ẩn">Ẩn</option>
                            </select>
            <input type="submit" name="submit" value="Thêm">
        </form>
    </body>
</html>
