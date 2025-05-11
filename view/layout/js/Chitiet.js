// ChitietSP
function ChitietSP(x){
    var ProductID = x;
    console.log(ProductID);

    $.ajax({
        type: "POST",
        url: "/webbantruyen/view/admin/form.php",
        data: { product_id: ProductID },
        dataType: "json",
        success: function(response) {
            console.log({response});
            $("#overlay-chitiet").css("display","block");  
            $("#Function").css("display","none"); 
            $("#ChiTiet").html(
                `
                <input type="button" value="X" class="close-btn" onclick="Close_ChucNang()">
                <div class="chitiet-box">
                    <div class="image-box"><img src="/webbantruyen/view/layout/images/${response.productImg}";height="100%";width:"90%";></div>
                    <div class="info-box">
                        <p><strong>Mã sản phẩm:</strong> ${response.productID}</p>
                        <p><strong>Tên truyện:</strong> ${response.productName}</p>
                        <p><strong>Tác giả:</strong> ${response.author}</p>
                        <p><strong>NXB:</strong> ${response.publisher}</p>
                        <p><strong>Kho:</strong> ${response.quantity}</p>
                        <p><strong>Giá nhập:</strong> ${response.importPrice}</p>
                        <p><strong>ROS:</strong> ${response.ros}</p>
                        <p><strong>Mô tả:</strong> ${response.description}</p>
                        <p><strong>Mã nhà cung cấp:</strong> ${response.supplierID}</p>
                    </div>
                </div>
                `  
            );        
        }
    });
}

// ChitietSP
function ChitietHDN(importID){
    console.log(importID);
    $.ajax({
        type: "POST",
        url: "/webbantruyen/view/admin/form.php",
        data: { importID: importID },
        dataType: "json",
        success: function(response) {
            console.log({response});
            $("#overlay-chitiet").css("display","block");  
            $("#Function").css("display","none"); 
            $("#ChiTiet").html(
                `
                <input type="button" value="X" class="close-btn" onclick="Close_ChucNang()">
                <div class="chitiet-box">
                    <div class="image-box"><img src="/webbantruyen/view/layout/images/${response.productImg}";height="100%";width:"90%";></div>
                    <div class="info-box">
                        <p><strong>Mã sản phẩm:</strong> ${response.productID}</p>
                        <p><strong>Tên truyện:</strong> ${response.productName}</p>
                        <p><strong>Tác giả:</strong> ${response.author}</p>
                        <p><strong>NXB:</strong> ${response.publisher}</p>
                        <p><strong>Kho:</strong> ${response.quantity}</p>
                        <p><strong>Giá nhập:</strong> ${response.importPrice}</p>
                        <p><strong>ROS:</strong> ${response.ros}</p>
                        <p><strong>Mô tả:</strong> ${response.description}</p>
                        <p><strong>Mã nhà cung cấp:</strong> ${response.supplierID}</p>
                    </div>
                </div>
                `  
            );        
        }
    });
}

ChiTiet
function Close_ChucNang(){
    $("#overlay-chitiet").css("display","none");
}
// chitietRole
function ChitietRole(x){
    console.log(x);
    var RoleID = x;
    $.ajax({
        type: "POST",
        url: "../admin/form.php",
        data: { roleID: RoleID },
        dataType: "json",
        success: function(response) {
            console.log({response});
            $("#overlay-chitiet").css("display","block");   
            $("#ChiTiet").html(
                `
                <h2>Chỉnh sửa quyền ${response[0].RoleName} </h2>
                <input type="button" value="X" class="blue-btn" onclick="Close_ChucNang()">
                <form action="../admin/SuaRole.php" method="POST">
                <input type="hidden" name="RoleID" value="${response[0].RoleID}">
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
                <input type="submit" value="Xác Nhận Sửa" class="blue-btn">
                <input type="button" value="Xóa Role" class="blue-btn" onclick='XoaRole("${response[0].RoleID}")'>
                </form>
                `  
            );        
            response.forEach(element => {
            if(element.FunctionID == "F001"){
                if(element.Option == "Thêm"){
                    $("input[name='TTK'][value='Thêm']").prop("checked", true);
                }
                if(element.Option == "Sửa"){
                    $("input[name='STK'][value='Sửa']").prop("checked", true);
                }
                if(element.Option == "Xóa"){
                    $("input[name='XTK'][value='Xóa']").prop("checked", true);
                }
            }
            if(element.FunctionID == "F002"){
                if(element.Option == "Thêm"){
                    $("input[name='TSP'][value='Thêm']").prop("checked", true);
                }
                if(element.Option == "Sửa"){
                    $("input[name='SSP'][value='Sửa']").prop("checked", true);
                }
                if(element.Option == "Xóa"){
                    $("input[name='XSP'][value='Xóa']").prop("checked", true);
                }
            }
            if(element.FunctionID == "F003"){
                if(element.Option == "Thêm"){
                    $("input[name='THD'][value='Thêm']").prop("checked", true);
                }  
                if(element.Option == "Sửa"){
                    $("input[name='SHD'][value='Sửa']").prop("checked", true);
                }
                if(element.Option == "Xóa"){
                    $("input[name='XHD'][value='Xóa']").prop("checked", true);
                }
            }
            });
            
        }
    });
}


// ChitietNV
function ChitietNV(x){
    var Username = x;
    $.ajax({
        type: "POST",
        url: "../admin/form.php",
        data: { usernameNV: Username },
        dataType: "json",
        success: function(response) {
            console.log({response});
            $("#ChiTiet").css("display","block");   
            $("#ChiTiet").html(
                `
                <input type="button" value="X" class="blue-btn" onclick="Close_ChucNang()">
                <div class="form">
                    <div class="info-box">
                        <p>EmployeeID:${response.employeeID}</p>
                        <p>Fullname:${response.fullname}</p>
                        <p>Username:${response.username}</p>
                        <p>BirthDay:${response.birthDay}</p>
                        <p>Phone:${response.phone}</p>
                        <p>Email:${response.email}</p>
                        <p>Address:${response.address}</p>
                        <p>Gender:${response.Gender}</p>
                        <p>Salary:${response.salary}</p>
                        <p>StartDate:${response.startDate}</p>
                        <p>status:${response.status}</p>
                    </div>
                </div>
                <input type="button" value="Sửa" class="blue-btn" onclick="Close_ChucNang()">
                <input type="button" value="Xóa" class="blue-btn" onclick="Close_ChucNang()">
                `  
            );        
        }
    })
}


// ChitietKH

function ChitietKH(x){
    var Username = x;
    $.ajax({
        type: "POST",
        url: "../admin/form.php",
        data: { usernameKH: Username },
        dataType: "json",
        success: function(response) {
            console.log({response});
            $("#ChiTiet").css("display","block");   
            $("#ChiTiet").html(
                `
                <input type="button" value="X" class="blue-btn" onclick="Close_ChucNang()">
                <div class="form">
                    <div class="info-box">
                        <p>CustomerID:${response.CustomerID}</p>
                        <p>Fullname:${response.Fullname}</p>
                        <p>Username:${response.Username}</p>
                        <p>Phone:${response.Phone}</p>
                        <p>Email:${response.Email}</p>
                        <p>Address:${response.Address}</p>
                        <p>TotalSpending:${response.TotalSpending}</p>
                        <p>status:${response.status}</p>
                    </div>
                </div>
                <input type="button" value="Sửa" class="blue-btn" onclick="Close_ChucNang()">
                <input type="button" value="Xóa" class="blue-btn" onclick="Close_ChucNang()">
                `  
            );        
        }
    })
}

