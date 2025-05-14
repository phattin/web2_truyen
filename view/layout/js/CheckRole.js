// CheckRole.js


function HiddenAll() {
    // Ẩn tất cả các phần tử

    //ẩn sidebar
    $("#QLTK").css("display", "none");
    $("#QLSP").css("display", "none");
    $("#QLHDN").css("display", "none");
    $("#QLHDB").css("display", "none");
    $("#QLNV").css("display", "none");
    $("#QLKH").css("display", "none");
    $(".QLQ").css("display", "none");
    $("#QLCL").css("display", "none");
    $("#QLKM").css("display", "none");
    $("#QLNCC").css("display", "none");
    $("#QLS").css("display", "none");

    //ẩn các chức năng
    $(".XemTK").css("display", "none");
    $(".TTK").css("display", "none");
    $(".STK").css("display", "none");
    $(".XTK").css("display", "none");
    $(".XemSP").css("display", "none");
    $(".TSP").css("display", "none");
    $(".SSP").css("display", "none");
    $(".XSP").css("display", "none");
    $(".XemHDN").css("display", "none");
    $(".THDN").css("display", "none");
    $(".SHDN").css("display", "none");
    $(".XHDN").css("display", "none");
    $(".XemNV").css("display", "none");
    $(".TNV").css("display", "none");
    $(".SNV").css("display", "none");
    $(".XNV").css("display", "none");
    $(".XemKH").css("display", "none");
    $(".TKH").css("display", "none");
    $(".SKH").css("display", "none");
    $(".XKH").css("display", "none");
    $(".XemQ").css("display", "none");
    $(".TQ").css("display", "none");
    $(".SQ").css("display", "none");
    $(".XQ").css("display", "none");
    $(".XemCL").css("display", "none");
    $(".TCL").css("display", "none");
    $(".SCL").css("display", "none");
    $(".XCL").css("display", "none");
    $(".XemKM").css("display", "none");
    $(".TKM").css("display", "none");
    $(".SKM").css("display", "none");
    $(".XKM").css("display", "none");
    $(".XemNCC").css("display", "none");
    $(".TNCC").css("display", "none");
    $(".SNCC").css("display", "none");
    $(".XNCC").css("display", "none");
}

// Sidebar
function ShowTK() {
    $("#QLTK").css("display", "block");
}
function ShowSP() {
    $("#QLSP").css("display", "block");
}
function ShowHDN() {
    $("#QLHDN").css("display", "block");
}
function ShowHDB() {
    $("#QLHDB").css("display", "block");
}
function ShowNV() {
    $("#QLNV").css("display", "block");
}
function ShowKH() {
    $("#QLKH").css("display", "block");
}
function ShowQ() {
    $(".QLQ").css("display", "block");
}
function ShowCL() {
    $("#QLCL").css("display", "block");
}
function ShowKM() {
    $("#QLKM").css("display", "block");
}
function ShowNCC() {
    $("#QLNCC").css("display", "block");
}   
function ShowS() {
    $("#sS").css("display", "block");
}

// Chức năng

// Tài khoản
function ShowXemTK() {
    $(".XemTK").css("display", "block");
}   
function ShowTTK() {
    $(".TTK").css("display", "block");
}
function ShowSTK() {
    $(".STK").css("display", "block");
}
function ShowXTK() {
    $(".XTK").css("display", "block");
}
// Sản phẩm
function ShowXemSP() {
    $(".XemSP").css("display", "block");
}
function ShowTSP() {
    $(".TSP").css("display", "block");
}
function ShowSSP() {
    $(".SSP").css("display", "block");
}
function showXSP() {
    $(".XSP").css("display", "block");
}
// Hóa đơn nhận
function ShowXemHDN() {
    $(".XemHDN").css("display", "block");
}
function ShowTHDN() {
    $(".THDN").css("display", "block");
}
function ShowSHDN() {
    $(".SHDN").css("display", "block");
}
function ShowXHDN() {
    $(".XHDN").css("display", "block");
}
/* Hóa đơn bán
function ShowTHDB() {
    $(".THDB").css("display", "block");
}*/

// Nhân viên
function ShowXemNV() {
    $(".XemNV").css("display", "block");
}
function ShowTNV() {
    $(".TNV").css("display", "block");
}
function ShowSNV() {
    $(".SNV").css("display", "block");
}
function ShowXNV() {
    $(".XNV").css("display", "block");
}
// Khách hàng
function ShowXemKH() {
    $(".XemKH").css("display", "block");
}
function ShowTKH() {
    $(".TKH").css("display", "block");
}
function ShowSKH() {
    $(".SKH").css("display", "block");
}
function ShowXKH() {
    $(".XKH").css("display", "block");
}
// Quyền
function ShowXemQ() {
    $(".XemQ").css("display", "block");
}   
function ShowTQ() {
    $(".TQ").css("display", "block");
}
function ShowSQ() {
    $(".SQ").css("display", "block");
}
function ShowXQ() {
    $(".XQ").css("display", "block");
}
// Chủng loại
function ShowXemCL() {
    $(".XemCL").css("display", "block");
}
function ShowTCL() {
    $(".TCL").css("display", "block");
}
function ShowSCL() {
    $(".SCL").css("display", "block");
}
function ShowXCL() {
    $(".XCL").css("display", "block");
}
// Khuyến mãi
function ShowXemKM() {
    $(".XemKM").css("display", "block");
}
function ShowTKM() {
    $(".TKM").css("display", "block");
}
function ShowSKM() {
    $(".SKM").css("display", "block");
}
function ShowXKM() {
    $(".XKM").css("display", "block");
}
// Nhà cung cấp
function ShowXemNCC() {
    $(".XemNCC").css("display", "block");
}
function ShowTNCC() {
    $(".TNCC").css("display", "block");
}
function ShowSNCC() {
    $(".SNCC").css("display", "block");
}
function ShowXNCC() {
    $(".XNCC").css("display", "block");
}
/*Thống kê
function ShowS() {
    $(".S").css("display", "block");
}*/

    

function CheckRole(RoleID) {
    console.log(RoleID);
    $.ajax({
        type: "GET",
        url: "../../model/checkRole.php",
        data: { RoleID: RoleID },
        dataType: "json",
        success: function (response) {
            console.log(response);
            HiddenAll();
            response.forEach(response => {
                if(response["FunctionID"] === "F001"){
                    ShowTK();
                    if(response["Option"] === "Xem"){
                        ShowXemTK();
                    }
                    if(response["Option"] === "Thêm"){
                        ShowTTK();
                    }
                    if(response["Option"] === "Sửa"){
                        ShowSTK();
                    }
                    if(response["Option"] === "Xóa"){
                        ShowXTK();
                    }
                }
                if(response["FunctionID"] === "F002"){
                    ShowSP();
                    if(response["Option"] === "Xem"){
                        ShowXemSP();
                    }
                    if(response["Option"] === "Thêm"){
                        ShowTSP();
                    }
                    if(response["Option"] === "Sửa"){
                        ShowSSP();
                    }
                    if(response["Option"] === "Xóa"){
                        showXSP();   
                    }
                }
                if(response["FunctionID"] === "F003"){
                    ShowHDN();
                    if(response["Option"] === "Xem"){
                        ShowXemHDN();
                    }
                    if(response["Option"] === "Thêm"){
                        ShowTHDN();
                    }
                    if(response["Option"] === "Sửa"){
                        ShowSHDN();
                    }
                    if(response["Option"] === "Xóa"){
                        ShowXHDN();
                    }
                }
                if(response["FunctionID"] === "F004"){
                    ShowHDB();
                }
                if(response["FunctionID"] === "F005"){
                    ShowNV();
                    if(response["Option"] === "Xem"){
                        ShowXemNV();
                    }
                    if(response["Option"] === "Thêm"){
                        ShowTNV();
                    }
                    if(response["Option"] === "Sửa"){
                        ShowSNV();
                    }
                    if(response["Option"] === "Xóa"){
                        ShowXNV();
                    }
                }
                if(response["FunctionID"] === "F006"){
                    ShowKH();
                    if(response["Option"] === "Xem"){
                        ShowXemKH();
                    }
                    if(response["Option"] === "Thêm"){
                        ShowTKH();
                    }
                    if(response["Option"] === "Sửa"){
                        ShowSKH();
                    }
                    if(response["Option"] === "Xóa"){
                        ShowXKH();
                    }
                }
                if(response["FunctionID"] === "F007"){
                    ShowQ();
                    if(response["Option"] === "Xem"){
                        ShowXemQ();
                    }
                    if(response["Option"] === "Thêm"){
                        ShowTQ();
                    }
                    if(response["Option"] === "Sửa"){
                        ShowSQ();
                    }
                    if(response["Option"] === "Xóa"){
                        ShowXQ();
                    }
                }
                if(response["FunctionID"] === "F008"){
                    ShowCL();
                    if(response["Option"] === "Xem"){
                        ShowXemCL();
                    }
                    if(response["Option"] === "Thêm"){
                        ShowTCL();
                    }
                    if(response["Option"] === "Sửa"){
                        ShowSCL();
                    }
                    if(response["Option"] === "Xóa"){
                        ShowXCL();
                    }
                }
                if(response["FunctionID"] === "F009"){
                    ShowKM();
                    if(response["Option"] === "Xem"){
                        ShowXemKM();
                    }
                    if(response["Option"] === "Thêm"){
                        ShowTKM();
                    }
                    if(response["Option"] === "Sửa"){
                        ShowSKM();
                    }
                    if(response["Option"] === "Xóa"){
                        ShowXKM();
                    }
                }
                if(response["FunctionID"] === "F010"){
                    ShowNCC();
                    if(response["Option"] === "Xem"){
                        ShowXemNCC();
                    }
                    if(response["Option"] === "Thêm"){
                        ShowTNCC();
                    }
                    if(response["Option"] === "Sửa"){
                        ShowSNCC();
                    }
                    if(response["Option"] === "Xóa"){
                        ShowXNCC();
                    }
                }
                if(response["FunctionID"] === "F011"){
                    ShowS();
                }

            });            
        }
    });        
}
