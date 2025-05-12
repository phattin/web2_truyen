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
                
            }
            if($row["Option"] == "Sửa"){
                
            }
            if($row["Option"] == "Xóa"){
                
            }
        }
        if($row["FunctionID"] == "F002"){
            ShowSP();
            if($row["Option"] == "Thêm"){
                
            }
            if($row["Option"] == "Sửa"){
                
            }
            if($row["Option"] == "Xóa"){
                
            }
        }
        if($row["FunctionID"] == "F003"){
            ShowHD();
            if($row["Option"] == "Thêm"){
                
            }  
            if($row["Option"] == "Sửa"){
                
            }
            if($row["Option"] == "Xóa"){
                
            }
        }
        }
    });        
}