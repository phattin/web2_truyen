// ChitietSP
function ChitietSP(x){
    var ProductID = x;
    console.log(ProductID);

    $.ajax({
        type: "POST",
        url: "../admin/form.php",
        data: { product_id: ProductID },
        dataType: "json",
        success: function(response) {
            console.log({response});
            $("#ChiTiet").css("display","block");  
            $("#Function").css("display","none"); 
            $("#ChiTiet").html(
                `
                <input type="button" value="X" class="blue-btn" onclick="Close_Chitiet()">
                <div class="form">
                    <div class="image-box"><img src="../layout/images/${response.productImg}";height="100%";width:"90%";></div>
                    <div class="info-box">
                        <p>ProductID:${response.productID}</p>
                        <p>ProductName:${response.productName}</p>
                        <p>ProductImg:${response.productImg}</p>
                        <p>Author:${response.author}</p>
                        <p>Publisher:${response.publisher}</p>
                        <p>Quantity:${response.quantity}</p>
                        <p>ImportPrice:${response.importPrice}</p>
                        <p>ROS:${response.ros}</p>
                        <p>Description:${response.description}</p>
                        <p>SupplierID:${response.supplierID}</p>
                        <p>Status:${response.status}</p>
                    </div>
                </div>
                <input type="button" value="Sửa" class="blue-btn" onclick="Close_Chitiet()">
                <input type="button" value="Xóa" class="blue-btn" onclick="Xoa('${response.productID}'); Close_Chitiet();">
                `  
            );        
        }
    });
}


function Close_Chitiet(){
    $("#ChiTiet").css("display","none");
}
// chitietRole
function ChitietRole(){
    /*var RoleID = x;
    $.ajax({
        type: "POST",
        url: "../admin/form.php",
        data: { role_id: RoleID },
        dataType: "json",
        success: function(response) {
            console.log({response});*/
            $("#ChiTiet").css("display","block");   
            $("#ChiTiet").html(
                `
                <input type="button" value="X" class="blue-btn" onclick="Close_Chitiet()">
                <table>
                    <tr>
                        <th>Tên chức năng </th>
                        <th>Thêm </th>
                        <th>Sửa </th>
                        <th>Xóa </th>
                    </tr>
                    <tr>
                        <th>Quản lý tài khoản</th>
                        <td><input type='checkbox' name='Quản lý tài khoản' value='Thêm'></td>
                        <td><input type='checkbox' name='Quản lý tài khoản' value='Sửa'></td>
                        <td><input type='checkbox' name='Quản lý tài khoản' value='Xóa'></td>
                    </tr>
                    <tr>
                        <th>Quản lý sản phẩm</th>
                        <td><input type='checkbox' name='Quản lý sản phẩm' value='Thêm'></td>
                        <td><input type='checkbox' name='Quản lý sản phẩm' value='Sửa'></td>
                        <td><input type='checkbox' name='Quản lý sản phẩm' value='Xóa'></td>
                    </tr>
                    <tr>
                        <th>Quản lý hóa đơn</th>
                        <td><input type='checkbox' name='Quản lý hóa đơn' value='Thêm'></td>
                        <td><input type='checkbox' name='Quản lý hóa đơn' value='Sửa'></td>
                        <td><input type='checkbox' name='Quản lý hóa đơn' value='Xóa'></td>
                    </tr>
                </table>
                <input type="button" value="Sửa" class="blue-btn" onclick="Close_Chitiet()">
                <input type="button" value="Xóa" class="blue-btn" onclick="Close_Chitiet()">
                `  
            );        
        }
    /*});
}
*/



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
                <input type="button" value="X" class="blue-btn" onclick="Close_Chitiet()">
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
                <input type="button" value="Sửa" class="blue-btn" onclick="Close_Chitiet()">
                <input type="button" value="Xóa" class="blue-btn" onclick="Close_Chitiet()">
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
                <input type="button" value="X" class="blue-btn" onclick="Close_Chitiet()">
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
                <input type="button" value="Sửa" class="blue-btn" onclick="Close_Chitiet()">
                <input type="button" value="Xóa" class="blue-btn" onclick="Close_Chitiet()">
                `  
            );        
        }
    })
}

