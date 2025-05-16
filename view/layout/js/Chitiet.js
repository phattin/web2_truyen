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
                <input type="button" value="X" class="close-btn" onclick="Close_Chitiet()">
                <div class="chitiet-box">
                    <div class="image-box"><img src="/webbantruyen/view/layout/images/${response.productImg}";height="100%";width:"90%";></div>
                    <div class="info-box">
                        <p><strong>Mã sản phẩm:</strong> ${response.productID}</p>
                        <p><strong>Tên truyện:</strong> ${response.productName}</p>
                        <p><strong>Chủng loại:</strong> ${response.categoryName}</p>
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
            let detailContent = "";
            response.importDetails.forEach(function(detail) {
                detailContent += `<tr>
                    <td>${detail.ProductID}</td>
                    <td>${detail.ProductName}</td>
                    <td>${detail.Quantity}</td>
                    <td>${detail.Price}</td>
                    <td>${detail.TotalPrice}</td>
                </tr>`;
            });
            $("#ChiTiet").html(
                `
                <input type="button" value="X" class="close-btn" onclick="Close_Chitiet()">
                <h2 style='text-align:center; margin:30px;'>Chi tiết hóa đơn nhập</h2>
                <div class="chitiet-box" style="display:block">
                    <div class="info-box" style="width:100%">
                        <table class='product-admin-table'>
                            <tr>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>`
                            + detailContent +
                        `</table>
                    </div>
                </div>
                `  
            );        
        }
    });
}

function Close_Chitiet(){
    $("#overlay-chucnang").css("display","none");    
    $("#overlay-chitiet").css("display","none");
}
function Close_Chitiet(){
    $("#overlay-chucnang").css("display","none");    
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
                <input type="button" value="X" class="blue-btn" onclick="Close_Chitiet()">
                <form action="../admin/SuaRole.php" method="POST">
                <input type="hidden" name="RoleID" value="${response[0].RoleID}">
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
                        <td></td>
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
                </form>
                `  
            );        
            response.forEach(element => {
            if(element.FunctionID == "F001"){
                if(element.Option == "Xem"){
                    $("input[name='XemTK'][value='Xem']").prop("checked", true);
                }
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
                if(element.Option == "Xem"){
                    $("input[name='XemSP'][value='Xem']").prop("checked", true);
                }
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
                if(element.Option == "Xem"){
                    $("input[name='XemHDN'][value='Xem']").prop("checked", true);
                }
                if(element.Option == "Thêm"){
                    $("input[name='THDN'][value='Thêm']").prop("checked", true);
                }
                if(element.Option == "Sửa"){
                    $("input[name='SHDN'][value='Sửa']").prop("checked", true);
                }
                if(element.Option == "Xóa"){
                    $("input[name='XHDN'][value='Xóa']").prop("checked", true);
                }
            }
            if(element.FunctionID == "F004"){
                if(element.Option == "Xem"){
                    $("input[name='IHD'][value='Xem']").prop("checked", true);
                }
            }
            if(element.FunctionID == "F005"){
                if(element.Option == "Xem"){
                    $("input[name='XemNV'][value='Xem']").prop("checked", true);
                }
                if(element.Option == "Thêm"){
                    $("input[name='TNV'][value='Thêm']").prop("checked", true);
                }
                if(element.Option == "Sửa"){
                    $("input[name='SNV'][value='Sửa']").prop("checked", true);
                }
                if(element.Option == "Xóa"){
                    $("input[name='XNV'][value='Xóa']").prop("checked", true);
                }
            }
            if(element.FunctionID == "F006"){
                if(element.Option == "Xem"){
                    $("input[name='XemKH'][value='Xem']").prop("checked", true);
                }
                if(element.Option == "Thêm"){
                    $("input[name='TKH'][value='Thêm']").prop("checked", true);
                }
                if(element.Option == "Sửa"){
                    $("input[name='SKH'][value='Sửa']").prop("checked", true);
                }
                if(element.Option == "Xóa"){
                    $("input[name='XKH'][value='Xóa']").prop("checked", true);
                }
            }
            if(element.FunctionID == "F007"){
                if(element.Option == "Xem"){
                    $("input[name='XemRole'][value='Xem']").prop("checked", true);
                }
                if(element.Option == "Thêm"){
                    $("input[name='TQ'][value='Thêm']").prop("checked", true);
                }
                if(element.Option == "Sửa"){
                    $("input[name='SQ'][value='Sửa']").prop("checked", true);
                }
                if(element.Option == "Xóa"){
                    $("input[name='XQ'][value='Xóa']").prop("checked", true);
                }
            }
            if(element.FunctionID == "F008"){
                if(element.Option == "Xem"){
                    $("input[name='XemCL'][value='Xem']").prop("checked", true);
                }
                if(element.Option == "Thêm"){
                    $("input[name='TCL'][value='Thêm']").prop("checked", true);
                }
                if(element.Option == "Sửa"){
                    $("input[name='SCL'][value='Sửa']").prop("checked", true);
                }
                if(element.Option == "Xóa"){
                    $("input[name='XCL'][value='Xóa']").prop("checked", true);
                }
            }
            if(element.FunctionID == "F009"){
                if(element.Option == "Xem"){
                    $("input[name='XemKM'][value='Xem']").prop("checked", true);
                }
                if(element.Option == "Thêm"){
                    $("input[name='TKM'][value='Thêm']").prop("checked", true);
                }
                if(element.Option == "Sửa"){
                    $("input[name='SKM'][value='Sửa']").prop("checked", true);
                }
                if(element.Option == "Xóa"){
                    $("input[name='XKM'][value='Xóa']").prop("checked", true);
                }
            }
            if(element.FunctionID == "F010"){
                if(element.Option == "Xem"){
                    $("input[name='XemNCC'][value='Xem']").prop("checked", true);
                }
                if(element.Option == "Thêm"){
                    $("input[name='TNCC'][value='Thêm']").prop("checked", true);
                }
                if(element.Option == "Sửa"){
                    $("input[name='SNCC'][value='Sửa']").prop("checked", true);
                }
                if(element.Option == "Xóa"){
                    $("input[name='XNCC'][value='Xóa']").prop("checked", true);
                }
            }
            if(element.FunctionID == "F011"){
                if(element.Option == "Xem"){
                    $("input[name='XemS'][value='Xem']").prop("checked", true);
                }
            }
            $("input[name='XemTK'][value='Xem']").prop("disabled", true);
            $("input[name='TTK'][value='Thêm']").prop("disabled", true);
            $("input[name='STK'][value='Sửa']").prop("disabled", true);  
            $("input[name='XTK'][value='Xóa']").prop("disabled", true);
            $("input[name='XemSP'][value='Xem']").prop("disabled", true);
            $("input[name='TSP'][value='Thêm']").prop("disabled", true);
            $("input[name='SSP'][value='Sửa']").prop("disabled", true);
            $("input[name='XSP'][value='Xóa']").prop("disabled", true);
            $("input[name='XemHDN'][value='Xem']").prop("disabled", true);
            $("input[name='THDN'][value='Thêm']").prop("disabled", true);
            $("input[name='SHDN'][value='Sửa']").prop("disabled", true);
            $("input[name='XHDN'][value='Xóa']").prop("disabled", true);
            $("input[name='IHD'][value='Xem']").prop("disabled", true);
            $("input[name='XemNV'][value='Xem']").prop("disabled", true);
            $("input[name='TNV'][value='Thêm']").prop("disabled", true);
            $("input[name='SNV'][value='Sửa']").prop("disabled", true);
            $("input[name='XNV'][value='Xóa']").prop("disabled", true);
            $("input[name='XemKH'][value='Xem']").prop("disabled", true);
            $("input[name='TKH'][value='Thêm']").prop("disabled", true);
            $("input[name='SKH'][value='Sửa']").prop("disabled", true);
            $("input[name='XKH'][value='Xóa']").prop("disabled", true);
            $("input[name='XemRole'][value='Xem']").prop("disabled", true);
            $("input[name='TQ'][value='Thêm']").prop("disabled", true);
            $("input[name='SQ'][value='Sửa']").prop("disabled", true);
            $("input[name='XQ'][value='Xóa']").prop("disabled", true);
            $("input[name='XemCL'][value='Xem']").prop("disabled", true);
            $("input[name='TCL'][value='Thêm']").prop("disabled", true);
            $("input[name='SCL'][value='Sửa']").prop("disabled", true);
            $("input[name='XCL'][value='Xóa']").prop("disabled", true);
            $("input[name='XemKM'][value='Xem']").prop("disabled", true);
            $("input[name='TKM'][value='Thêm']").prop("disabled", true);
            $("input[name='SKM'][value='Sửa']").prop("disabled", true);
            $("input[name='XKM'][value='Xóa']").prop("disabled", true);
            $("input[name='XemNCC'][value='Xem']").prop("disabled", true);
            $("input[name='TNCC'][value='Thêm']").prop("disabled", true);
            $("input[name='SNCC'][value='Sửa']").prop("disabled", true);
            $("input[name='XNCC'][value='Xóa']").prop("disabled", true);
            $("input[name='XemS'][value='Xem']").prop("disabled", true);           
            });
            
        }
    });
}



// ChitietNV
function ChitietNV(x){
    console.log(x);
    $.ajax({        
        type: "POST",
        url: "../admin/form.php",
        data: { EmployeeID: x },
        dataType: "json",
        success: function(response) {
            $("#overlay-chitiet").css("display","block");   
            $("#ChiTiet").html(
                `
                <input type="button" value="X" class="blue-btn" onclick="Close_Chitiet()">
                <div class="employee-card">
                   
                        <p><strong>EmployeeID:</strong>${response.employeeID}</p>
                        <p><strong>Fullname:</strong>${response.fullname}</p>
                        <p><strong>BirthDay:</strong>${response.birthDay}</p>
                        <p><strong>Phone:</strong>${response.phone}</p>
                        <p><strong>Email:</strong>${response.email}</p>
                        <p><strong>Address:</strong>${response.address}</p>
                        <p><strong>Gender:</strong>${response.Gender}</p>
                        <p><strong>Salary:</strong>${response.salary}</p>
                        <p><strong>StartDate:</strong>${response.startDate}</p>
                        <p><strong>isDeleted:</strong>${response.isDeleted}</p>
                    
                </div>
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
                        <p><strong>CustomerID:</strong>${response.CustomerID}</p>
                        <p><strong>Fullname:</strong>${response.Fullname}</p>
                        <p><strong>Username:</strong>${response.Username}</p>
                        <p><strong>Phone:</strong>${response.Phone}</p>
                        <p><strong>Email:</strong>${response.Email}</p>
                        <p><strong>Address:</strong>${response.Address}</p>
                        <p><strong>TotalSpending:</strong>${response.TotalSpending}</p>
                        <p><strong>status:</strong>${response.status}</p>
                    </div>
                </div>
                <input type="button" value="Sửa" class="blue-btn" onclick="Close_Chitiet()">
                <input type="button" value="Xóa" class="blue-btn" onclick="Close_Chitiet()">
                `  
            );        
        }
    })
}

// chi tiet TK

function ChitietTK(x){

     $.ajax({        
        type: "POST",
        url: "../admin/form.php",
        data: { Username: x },
        dataType: "json",
        success: function(response) {
            console.log({response});
            $("#overlay-chitiet").css("display","block");   
            $("#ChiTiet").html(
                `
                <input type="button" value="X" class="blue-btn" onclick="Close_Chitiet()">
                <div class="employee-card">
                
                        <p><strong>Username:</strong>${response.username}</p>
                        <p><strong>Password:</strong>*************</p>
                        <p><strong>RoleID:</strong>${response.RoleID}</p>
                        <p><strong>EmployeeID:</strong>${response.EmployeeID}</p>
                        <p><strong>isDeleted:</strong>${response.isDeleted}</p>
                    
                </div>
                `  
            );        
        }
    })

}