<!DOCTYPE html>
<html lang="vi">
     <div class="Them" style="position: relative;">
        <button value="X" class="blue-btn" onclick="Close_ChucNang()">Close</button>
        <form action="../../handle/add_role.php" method="POST">
            <table>
                <tr>
                    <td><p>RoleName:</p><input type="text" name="RoleName"></td>
                </tr>
            </table>
            <p>Chức năng:</p>
            <table>
                <tr>
                    <th>Tên chức năng </th>
                    <th>Xem </th>
                    <th>Thêm </th>
                    <th>Sửa </th>
                    <th>Xóa </th>
                </tr>
                <tr>
                    <th>Quản lý tài khoản</th>
                    <td><input type='checkbox' name='XemTK' value='Xem'></input></td>
                    <td><input type='checkbox' name='TTK' value='Thêm'></input></td>
                    <td><input type='checkbox' name='STK' value='Sửa'></input></td>
                    <td><input type='checkbox' name='XTK' value='Xóa'></input></td>
                </tr>
                <tr>
                    <th>Quản lý sản phẩm</th>
                    <td><input type='checkbox' name='XemSP' value='Xem'></input></td>
                    <td><input type='checkbox' name='TSP' value='Thêm'></input></td>
                    <td><input type='checkbox' name='SSP' value='Sửa'></input></td>
                    <td><input type='checkbox' name='XSP' value='Xóa'></input></td>
                </tr>
                <tr>
                    <th>Quản lý hóa đơn nhập</th>
                    <td><input type='checkbox' name='XemHDN' value='Xem'></input></td>
                    <td><input type='checkbox' name='THDN' value='Thêm'></input></td>   
                    <td><input type='checkbox' name='SHDN' value='Sửa'></input></td>
                    <td><input type='checkbox' name='XHDN' value='Xóa'></input></td>
                </tr>
                <tr>
                    <th>Quản lý hóa đơn bán  </th>
                        <td><input type='checkbox' name='IHD' value='Xem'></input></td>
                        <td></td>
                        <td></td>
                        <td></td>
                </tr>
                <tr>
                    <th>Quản lý nhân viên</th>
                    <td><input type='checkbox' name='XemNV' value='Xem'></input></td>
                    <td><input type='checkbox' name='TNV' value='Thêm'></input></td>
                    <td><input type='checkbox' name='SNV' value='Sửa'></input></td>
                    <td><input type='checkbox' name='XNV' value='Xóa'></input></td>
                </tr>
                <tr>
                    <th>Quản lý khách hàng</th>
                    <td><input type='checkbox' name='XemKH' value='Xem'></input></td>
                    <td><input type='checkbox' name='TKH' value='Thêm'></input></td>
                    <td><input type='checkbox' name='SKH' value='Sửa'></input></td>
                    <td><input type='checkbox' name='XKH' value='Xóa'></input></td>
                <tr>
                    <th>Quản lý Quyền</th>
                    <td><input type='checkbox' name='XemRole' value='Xem'></input></td>
                    <td><input type='checkbox' name='TQ' value='Thêm'></input></td>
                    <td><input type='checkbox' name='SQ' value='Sửa'></input></td>
                    <td><input type='checkbox' name='XQ' value='Xóa'></input></td>
                <tr>
                    <th>Quản lý chủng loại</th>
                    <td><input type='checkbox' name='XemCL' value='Xem'></input></td>
                    <td><input type='checkbox' name='TCL' value='Thêm'></input></td>
                    <td><input type='checkbox' name='SCL' value='Sửa'></input></td>
                    <td><input type='checkbox' name='XCL' value='Xóa'></input></td>
                </tr>
                <tr>
                    <th>Quản lý khuyến mãi</th>
                    <td><input type='checkbox' name='XemKM' value='Xem'></input></td>
                    <td><input type='checkbox' name='TKM' value='Thêm'></input></td>
                    <td><input type='checkbox' name='SKM' value='Sửa'></input></td>
                    <td><input type='checkbox' name='XKM' value='Xóa'></input></td>
                </tr>
                <tr>
                    <th>Quản lý nhà cung cấp</th>
                    <td><input type='checkbox' name='XemNCC' value='Xem'></input></td>
                    <td><input type='checkbox' name='TNCC' value='Thêm'></input></td>
                    <td><input type='checkbox' name='SNCC' value='Sửa'></input></td>
                    <td><input type='checkbox' name='XNCC' value='Xóa'></input></td>
                </tr>
                <tr>
                    <th>statistical</th>
                        <td><input type='checkbox' name='XemS' value='Xem'></input></td>
                        <td></td>
                        <td></td>
                        <td></td>
                </tr>
            </table>
            <input type="submit" name="submit" value="Thêm" class="blue-btn">
            <input type="reset" name="reset" value="Nhập lại" class="blue-btn">
        </form>
    </div>
</html>

