// CheckRole.js


function HiddenAll() {
    $("#QLTK").css("display", "none");
    $("#QLSP").css("display", "none");
    $("#QLHD").css("display", "none");
    $("#TSP").css("display", "none");
    $("#SSP").css("display", "none");
    $("#XSP").css("display", "none");
}


function ShowTK() {
    $("#QLTK").css("display", "block");
}
function ShowSP() {
    $("#QLSP").css("display", "block");
}
function ShowHD() {
    $("#QLHD").css("display", "block");
}


function ShowTSP() {
    $("#TSP").css("display", "block");
}
function ShowSSP() {
    $("#SSP").css("display", "block");
}
function showXSP(){
    $("#XSP").css("display", "block");
}

function ShowTTK() {
    $("#XTK").css("display", "block");
}
function ShowSTK() {
    $("#STK").css("display", "block");
}
function ShowXTK() {
    $("#XTK").css("display", "block");
}

function ShowTHD() {
    $("#THD").css("display", "block");
}
function ShowSHD() {
    $("#SHD").css("display", "block");
}
function ShowXHD() {
    $("#XHD").css("display", "block");
}

function CheckRole(RoleID) {
    $.ajax({
        type: "GET",
        url: "../../model/checkRole.php",
        data: { checkRole: RoleID },
        dataType: "json",
        success: function (response) {
        if($row["FunctionID"] == "F001"){
            ShowTK();
            if($row["Option"] == "Thêm"){
                ShowTTK();
            }
            if($row["Option"] == "Sửa"){
                ShowSTK();
            }
            if($row["Option"] == "Xóa"){
                ShowXTK();
            }
        }
        if($row["FunctionID"] == "F002"){
            ShowSP();
            if($row["Option"] == "Thêm"){
                ShowTSP();
            }
            if($row["Option"] == "Sửa"){
                ShowSSP();
            }
            if($row["Option"] == "Xóa"){
                showXSP();   
            }
        }
        if($row["FunctionID"] == "F003"){
            ShowHD();
            if($row["Option"] == "Thêm"){
                ShowTHD();
            }  
            if($row["Option"] == "Sửa"){
                ShowSHD();
            }
            if($row["Option"] == "Xóa"){
                ShowXHD();
            }
        }
        }
    });        
}
CheckRole("R1");