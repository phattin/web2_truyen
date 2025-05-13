// CheckRole.js


function HiddenAll() {
    
    $(".QLTK").css("display", "none");
    $(".QLSP").css("display", "none");
    $(".QLHD").css("display", "none");
    $(".TSP").css("display", "none");
    $(".SSP").css("display", "none");
    $(".XSP").css("display", "none");
    $(".TTK").css("display", "none");
    $(".STK").css("display", "none");
    $(".XTK").css("display", "none");
    $(".THD").css("display", "none");
    $(".SHD").css("display", "none");
    $(".XHD").css("display", "none");
}


function ShowTK() {
    $(".QLTK").css("display", "block");
}
function ShowSP() {
    $(".QLSP").css("display", "block");
}
function ShowHD() {
    $(".QLHD").css("display", "block");
}


function ShowTSP() {
    $(".TSP").css("display", "block");
}
function ShowSSP() {
    $(".SSP").css("display", "block");
}
function showXSP(){
    $(".XSP").css("display", "block");
}

function ShowTTK() {
    $(".XTK").css("display", "block");
}
function ShowSTK() {
    $(".STK").css("display", "block");
}
function ShowXTK() {
    $(".XTK").css("display", "block");
}

function ShowTHD() {
    $(".THD").css("display", "block");
}
function ShowSHD() {
    $(".SHD").css("display", "block");
}
function ShowXHD() {
    $(".XHD").css("display", "block");
}

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
                    ShowHD();
                    if(response["Option"] === "Thêm"){
                        ShowTHD();
                    }  
                    if(response["Option"] === "Sửa"){
                        ShowSHD();
                    }
                    if(response["Option"] === "Xóa"){
                        ShowXHD();
                    }
                }

            });            
        }
    });        
}
