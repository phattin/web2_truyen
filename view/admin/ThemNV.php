
<div class='ThemNV'>
    <button value='X' class='blue-btn' onclick='closeChucNang()'>Close</button>
    <form>
        <label>Fullname:</label>
        <input type='text' name='Fullname' id='Fullname'>

        <label>BirthDay:</label>
        <input type='date' name='BirthDay' id='BirthDay'>

        <label>Phone:</label>
        <input type='text' name='Phone' id="Phone">

        <label>Email:</label>
        <input type='email' name='Email' id="Email">

        <label>Address:</label>
        <input type='text' name='Address' id="Address">

        <div class='gender-group'>
            <label>Gender:</label>
            <input type='radio' name='Gender' id="GenderNu" value='NỮ'>Nữ
            <input type='radio' name='Gender' id="GenderNam" value='NAM' >Nam
        </div>

        <label>Salary:</label>
        <input type='text' name='Salary' id="Salary" >


        <input type='submit' id='ThemNVSubmit' name='submit' value='Thêm' class='blue-btn'>
        <input type='reset' name='reset' value='Nhập lại' class='blue-btn'>
    </form>
</div>

<script>
    $('#ThemNVSubmit').on('click', function (e) {
        e.preventDefault();
        const Fullname = $('#Fullname').val();
        const BirthDay = $('#BirthDay').val();
        const Phone = $('#Phone').val();
        const Email = $('#Email').val();
        const Address = $('#Address').val();
        const Salary = $('#Salary').val();
        let Gender = '';
        if(($('#GenderNu').prop('checked'))){
            Gender = $('#GenderNu').val();
        }else if($('#GenderNam').prop('checked')){
            Gender = $('#GenderNam').val();
        }
        if (
        Fullname === '' ||
        BirthDay === '' ||
        Phone === '' ||
        Email === '' ||
        Address === '' ||
        Salary === ''  ||
        Gender === '' ||
        (!$('#GenderNu').prop('checked') && !$('#GenderNam').prop('checked'))
        ) {
            alert('Vui lòng điền đầy đủ thông tin!');
            return;
        }
        //Tên không chứa số và kí tự đặc biệt có quyền chứa số
        const nameRegex = /^[a-zA-ZÀ-ỹ0-9\s]+$/;
        console.log(Fullname)
        if (!nameRegex.test(Fullname)) {
            alert('Tên không chứa kí tự đặc biệt!');
            return;
        }

        const phoneRegex = /^0\d{9}$/;
        if (!phoneRegex.test(Phone)) {
            alert('SĐT không hợp lệ!');
            return;
        }

        const emailRegex = /^[^\n@]+@[^\n@]+\.(com)+$/;
        if (!emailRegex.test(Email)) {
            alert('Email không hợp lệ!');
            return;
        }


        $.ajax({
        type: 'POST',
        url: '../../handle/add_employee.php',
        data: {
            Fullname : Fullname,
            BirthDay : BirthDay,
            Phone : Phone,
            Email : Email,
            Address : Address,
            Salary : Salary,
            Gender : Gender,
        },
        dataType:"json",
        success:function (response) {
        console.log(response);
        if (response.status==="success") {
            alert("Thêm thông tin nhân viên thành công");
            
        } else {
            alert("Có lỗi xảy ra, vui lòng thử lại sau: " + response.message);
        }
        location.reload();
    },
        })
    })
</script>