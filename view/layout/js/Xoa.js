function Xoa(x){
    console.log(x);
    $.ajax({
        type: "GET",
        url: "../admin/XLThemSP.php",
        data: { ProductID: x },
        success:
    function() {
                alert("Xóa thành công");
                location.reload();
            }
    });
}