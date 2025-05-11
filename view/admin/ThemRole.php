<!DOCTYPE html>
<html lang="vi">
     <div class="Them" style="position: relative;">
        <button value="X" class="blue-btn" onclick="Close_ChucNang()">Close</button>
        <form action="XLThemRole.php" method="POST">
            <table>
                <tr>
                    <td><p>RoleName:</p><input type="text" name="RoleName"></td>
                </tr>
            </table>
            <p>Chức năng:</p>
            <table>
                    <tr>
                        <th>Tên chức năng </th>
                        <th>Thêm </th>
                        <th>Sửa </th>
                        <th>Xóa </th>
                    </tr>
                    <tr>
                        <th>Quản lý tài khoản</th>
                        <td><input type='checkbox' name='TTK' value='Thêm'></input></td>
                        <td><input type='checkbox' name='STK' value='Sửa'></input></td>
                        <td><input type='checkbox' name='XTK' value='Xóa'></input></td>
                    </tr>
                    <tr>
                        <th>Quản lý sản phẩm</th>
                        <td><input type='checkbox' name='TSP' value='Thêm'></input></td>
                        <td><input type='checkbox' name='SSP' value='Sửa'></input></td>
                        <td><input type='checkbox' name='XSP' value='Xóa'></input></td>
                    </tr>
                    <tr>
                        <th>Quản lý hóa đơn</th>
                        <td><input type='checkbox' name='THD' value='Thêm'></input></td>
                        <td><input type='checkbox' name='SHD' value='Sửa'></input></td>
                        <td><input type='checkbox' name='XHD' value='Xóa'></input></td>
                    </tr> 
                </table>
            <input type="submit" name="submit" value="Thêm" class="blue-btn">
            <input type="reset" name="reset" value="Nhập lại" class="blue-btn">
        </form>
    </div>
</html>

