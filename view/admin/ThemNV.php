<!DOCTYPE html>
<html lang="vi">
     <div class="Them" style="position: relative;">
        <button value="X" class="blue-btn" onclick="closeChucNang()">Close</button>
        <form action="XLThemSP.php" method="get">
            <p>Fullname:</p><input type="text" name="Fullname">
            <p>Username:</p><input type="text" name="Username">
            <p>BirthDay:</p><input type="date" name="BirthDay">
            <p>Phone:</p><input type="text" name="Phone">
            <p>Email:</p><input type="text" name="Email">
            <p>Address:</p><input type="text" name="Address">
            <p>Gender:</p><input type="text" name="Gender">
            <p>Salary:</p><input type="text" name="Salary">
            <p>StartDate:</p><input type="date" name="StartDate">
            <p>Status:</p><select name="status" > 
                                <option value="Hiện">Hiện</option>
                                <option value="Ẩn">Ẩn</option>
                            </select><br>
            <input type="submit" name="submit" value="Thêm" class="blue-btn">
            <input type="reset" name="reset" value="Nhập lại" class="blue-btn">
        </form>
    </div>
</html>