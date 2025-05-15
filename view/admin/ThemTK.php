
<div class='ThemTK' style="text-align: center;">
    <button value='X' class='blue-btn' onclick='Close_ChucNang()()'>Close</button>
    <form >
        <label>Username:</label>
        <input type='text' name='Username' id='Username'><br>
        

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
            echo "<input type='hidden' name='DSUsername' id='DSUsername' value='print_r($DS)'>";
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
        const RoleID = $('#RoleID').val();
        const DSUsername = $('#DSUsername').val();
        console.log(DSUsername);

        if (
        Username === '' ||
        Password === '' ||
        RoleID === '' 
        ) {
            alert('Vui lòng điền đầy đủ thông tin!');
            return;
        }
        //Tên không chứa số và kí tự đặc biệt có quyền chứa số
        const nameRegex = /^[a-z0-9A-Z]+$/;
        console.log(Username)
        if (!nameRegex.test(Username)) {
            alert('Username không chứa kí tự đặc biệt khoản trắng và dấu!');
            return;
        }

        if (DSUsername.includes(Username)) {
            alert('Username đã tồn tại!');
            return;
        }


        $.ajax({
        type: 'POST',
        url: '../../handle/add_account.php',
        data: {
            Username : Username,
            Password : Password,
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