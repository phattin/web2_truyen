<?php
include("../model/ThemSuaXoa.php");
if (!$_POST['Username']) {
    echo json_encode(["status" => "error", "message" => "Thiếu Username"]);
    exit;
}
$a= new ThemSuaXoa();
$MHPass= password_hash($_POST['Password'], PASSWORD_DEFAULT);
$sql = "INSERT INTO `account`
(`Username`, `Password`, `RoleID`, `EmployeeID`, `IsDeleted`) VALUES
 ('".$_POST['Username']."','$MHPass','".$_POST['RoleID']."', '".$_POST['EmployeeID']."','0')";
$a->Them($sql);
header('Content-Type: application/json');
echo json_encode(["status" => "success"]);

?>