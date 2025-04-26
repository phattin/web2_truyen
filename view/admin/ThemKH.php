<!DOCTYPE html>
<html lang="vi">
    
    <div class="Them" style="position: relative;">
        <button value="X" class="blue-btn" onclick="closeChucNang()">Close</button>
        <form action="XLThemSP.php" method="get">
            <p>Fullname:</p><input type="text" name="Fullname">
            <p>Username:</p><input type="text" name="Username">
            <p>Email:</p><input type="text" name="Email">
            <p>Address:</p><input type="text" name="Address">
            <p>Phone:</p><input type="text" name="Phone">
            <p>TotalSpending:</p><input type="text" name="TotalSpending">
            <p>Status:</p><select name="Status" > 
                                <option value="Hiện">Hiện</option>
                                <option value="Ẩn">Ẩn</option>
                            </select><br>
            <input type="submit" name="submit" value="Thêm" class="blue-btn">
            <input type="reset" name="reset" value="Nhập lại" class="blue-btn">
        </form>
    </div>
</html>
