
<div class='ThemTK ThemNV' style="text-align: center;">
    <button value='X' class='blue-btn' onclick='Close_ChucNang()'>Close</button>
    <form >
        <label>Username:</label>
        <input type='text' name='Username' id='Username'><br>
        
        <label>Employee:</label>
        <select name="EmployeeID" id="EmployeeID">
            <?php
            require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
            $conn = connectDB::getConnection();
            $sql = "  SELECT employee.EmployeeID,employee.Fullname
                    FROM `employee`
                    LEFT JOIN `account` ON employee.EmployeeID = account.EmployeeID
                    WHERE account.EmployeeID IS NULL;";
            $result = $conn->query($sql);
            while ($row=$result->fetch_assoc()){
                echo "<option name='EmployeeID' value='".$row["EmployeeID"]."'>".$row["EmployeeID"]."(".$row["Fullname"].")</option>";
            }
            ?>
        </select>

        <label>Password:</label>
        <input type='password' name='Password' id="Password"><br>

        <label>RoleID:</label>
        <select name='RoleID' id='RoleID'>
    
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
        $conn = connectDB::getConnection();
        $sql_data_acc = 'SELECT RoleID FROM `role` ';
        $result_acc = $conn->query($sql_data_acc);
        while ($row = $result_acc->fetch_assoc()) {
            echo "<option name='RoleID' value='".$row["RoleID"]."'>".$row["RoleID"]." </option>";
        }
        $conn->close();
        ?>
        </select><br>
        <?php
            require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
            $conn = connectDB::getConnection();
            $sql_data_acc = 'SELECT Username FROM `account` ';
            $result_acc = $conn->query($sql_data_acc);
            $data =[];
            while ($row = $result_acc->fetch_assoc()) {
                $data[] = $row["Username"];
            }
            $conn->close();
        
            $DS = implode(',', $data);
            echo "<input type='hidden' name='DSUsername' id='DSUsername' value='$DS'>";
        ?>

        <input type='submit' id='ThemTKSubmit' name='submit' value='Thêm' class='blue-btn'>
        <input type='reset' name='reset' value='Nhập lại' class='blue-btn'>
    </form>
</div>


<script>
    $('#ThemTKSubmit').on('click', function (e) {
        e.preventDefault();

        const Username = $('#Username').val();
        const Password = $('#Password').val();
        const EmployeeID = $('#EmployeeID').val();
        const RoleID = $('#RoleID').val();
        const DSUsername = $('#DSUsername').val();
        console.log(DSUsername);

        if (
        Username === '' ||
        Password === '' ||
        RoleID === '' ||
        EmployeeID === null
        ) {
            alert('Vui lòng điền đầy đủ thông tin!');
            return;
        }
        //Tên không chứa số và kí tự đặc biệt có quyền chứa số
        const nameRegex = /^[a-z0-9A-Z]+$/;
        console.log(RoleID)
        if (!nameRegex.test(Username)) {
            alert('Username không chứa kí tự đặc biệt khoản trắng và dấu!');
            return;
        }

        if (Password.length < 6) {
            alert("Mật khẩu phải có ít nhất 6 ký tự!");
            return;
        }

        let DSname = [];
        DSname = DSUsername.split(",");
        DSname.forEach(element => {
            if (Username === element) {
                alert('Username đã tồn tại!');
                return;
            }
        });



        $.ajax({
        type: 'POST',
        url: '../../handle/add_account.php',
        data: {
            Username : Username,
            Password : Password,
            EmployeeID : EmployeeID,
            RoleID : RoleID,
        },
        dataType:"json",
        success:function (response) {
        console.log(response);
        if (response.status==="success") {
            alert("Thêm thông tin tài khoản thành công");
            
        } else {
            alert("Có lỗi xảy ra, vui lòng thử lại sau: " + response.message);
        }
        location.reload();
    },
        })
    })
</script>