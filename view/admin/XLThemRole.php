<?php
include("../../model/ThemSuaXoa.php");
include("../../model/ID.php");
include("../../model/connectDB.php");
$a = new connectDB();
$conn = $a->getConnection();

$NewRoleID = generateNextID($conn, 'role', 'RoleID', 'R');

if (isset($_POST['submit'])) {
    $thong_tin = $_POST;
    $a = new ThemSuaXoa();
    
    // Thêm Role mới vào bảng role
    $sql = "INSERT INTO `role`(`RoleID`, `RoleName`) VALUES ('".$NewRoleID."','".$thong_tin['RoleName']."')";
    $a->Them($sql);
    
    // Thêm các chức năng mới vào bảng function_detail
    if(isset($thong_tin['TTK'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F001','".$thong_tin['TTK']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['STK'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F001','".$thong_tin['STK']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['XTK'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F001','".$thong_tin['XTK']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['TSP'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F002','".$thong_tin['TSP']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['SSP'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F002','".$thong_tin['SSP']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['XSP'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F002','".$thong_tin['XSP']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['THD'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F003','".$thong_tin['THD']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['SHD'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F003','".$thong_tin['SHD']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['XHD'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F003','".$thong_tin['XHD']."')";
        $a->Them($sql);
    }
    echo "<script>alert('ĐÃ THÊM ROLE MỚI!!!!');</script>";
    header("Location: ../admin/");
}
?>