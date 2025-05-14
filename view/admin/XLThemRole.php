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
    if(isset($thong_tin['XemTK'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F001','".$thong_tin['XemTK']."')";
        $a->Them($sql);
    }
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
    if(isset($thong_tin['XemSP'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F002','".$thong_tin['XemSP']."')";
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
    if(isset($thong_tin['XemHDN'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F003','".$thong_tin['XemHDN']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['THDN'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F003','".$thong_tin['THDN']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['SHDN'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F003','".$thong_tin['SHDN']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['XHDN'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F003','".$thong_tin['XHDN']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['IHD'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F004','".$thong_tin['IHD']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['XemNV'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F005','".$thong_tin['XemNV']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['TNV'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F005','".$thong_tin['TNV']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['SNV'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F005','".$thong_tin['SNV']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['XNV'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F005','".$thong_tin['XNV']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['XemKH'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F006','".$thong_tin['XemKH']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['TKH'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F006','".$thong_tin['TKH']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['SKH'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F006','".$thong_tin['SKH']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['XKH'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F006','".$thong_tin['XKH']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['XemRole'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F007','".$thong_tin['XemRole']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['TQ'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F007','".$thong_tin['TQ']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['SQ'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F007','".$thong_tin['SQ']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['XQ'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F007','".$thong_tin['XQ']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['XemCL'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F008','".$thong_tin['XemCL']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['TCL'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F008','".$thong_tin['TCL']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['SCL'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F008','".$thong_tin['SCL']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['XCL'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F008','".$thong_tin['XCL']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['XemKM'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F009','".$thong_tin['XemKM']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['TKM'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F009','".$thong_tin['TKM']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['SKM'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F009','".$thong_tin['SKM']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['XKM'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F009','".$thong_tin['XKM']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['XemNCC'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F010','".$thong_tin['XemNCC']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['TNCC'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F010','".$thong_tin['TNCC']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['SNCC'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F010','".$thong_tin['SNCC']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['XNCC'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F010','".$thong_tin['XNCC']."')";
        $a->Them($sql);
    }
    if(isset($thong_tin['XemS'])) {
        $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) VALUES ('".$NewRoleID."','F011','".$thong_tin['XemS']."')";
        $a->Them($sql);
    }


    echo "<script>alert('ĐÃ THÊM ROLE MỚI!!!!');</script>";
    header("Location: ../admin/");
}
?>