<?php
include("../../model/ThemSuaXoa.php");
$thong_tin =[];
$thong_tin = $_POST;
$a= new ThemSuaXoa();

// Xóa tất cả các chức năng của RoleID trong bảng function_detail
$sql ='DELETE FROM `function_detail` WHERE RoleID = "'.$thong_tin['RoleID'].'";';
$a->Xoa($sql);

// Thêm các chức năng mới vào bảng function_detail
if(isset($thong_tin['TTK'])) {
    $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$thong_tin['RoleID']."','F001','".$thong_tin['TTK']."')";
    $a->Them($sql);
}
if(isset($thong_tin['STK'])) {
    $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$thong_tin['RoleID']."','F001','".$thong_tin['STK']."')";
    $a->Them($sql);
}
if(isset($thong_tin['XTK'])) {
    $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$thong_tin['RoleID']."','F001','".$thong_tin['XTK']."')";
    $a->Them($sql);
}
if(isset($thong_tin['TSP'])) {
    $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$thong_tin['RoleID']."','F002','".$thong_tin['TSP']."')";
    $a->Them($sql);
}
if(isset($thong_tin['SSP'])) {
    $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$thong_tin['RoleID']."','F002','".$thong_tin['SSP']."')";
    $a->Them($sql);
}
if(isset($thong_tin['XSP'])) {
    $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$thong_tin['RoleID']."','F002','".$thong_tin['XSP']."')";
    $a->Them($sql);
}
if(isset($thong_tin['THD'])) {
    $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$thong_tin['RoleID']."','F003','".$thong_tin['THD']."')";
    $a->Them($sql);
}
if(isset($thong_tin['SHD'])) {
    $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$thong_tin['RoleID']."','F003','".$thong_tin['SHD']."')";
    $a->Them($sql);
}
if(isset($thong_tin['XHD'])) {
    $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$thong_tin['RoleID']."','F003','".$thong_tin['XHD']."')";
    $a->Them($sql);
}


echo "<script>alert('ĐÃ THAY ĐỔI CHỨC NĂNG ROLE!!!!');</script>";
header("Location: ../admin/");

?>