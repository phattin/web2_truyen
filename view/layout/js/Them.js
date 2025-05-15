// Them San Pham
function ThemSP(){
    $("#overlay-chucnang").css("display","block");
    $("#Function").css("display","block");
    $("#Function").load("/webbantruyen/view/admin/ThemSP.php");
}
// Them Hóa đơn nhập
function themHDN(){
    $("#overlay-chucnang").css("display","block");
    $("#Function").css("display","block");
    $("#Function").load("/webbantruyen/view/admin/themHDN.php");
}

// Them khuyến mãi
function themKM(){
    $("#overlay-chucnang").css("display","block");
    $("#Function").css("display","block");
    $("#Function").load("/webbantruyen/view/admin/themKM.php");
}

// Them Tai Khoan
function ThemTK(){
    $("#overlay-chucnang").css("display","block");
    $("#Function").load("/webbantruyen/view/admin/ThemTK.php");
}   


// Them Nhan Vien
function ThemNV(){
    $("#overlay-chucnang").css("display","block");
    $("#Function").load("/webbantruyen/view/admin/ThemNV.php");
}   


// Them Khach Hang
function ThemKH(){
    $("#Function").css("display","block");
    $("#ChiTiet").css("display","none");
    $("#Function").load("/webbantruyen/view/admin/ThemKH.php");
}

// Thêm Role
function ThemRole(){
    $("#overlay-chucnang").css("display","block");
    $("#Function").load("/webbantruyen/view/admin/ThemRole.php");
}