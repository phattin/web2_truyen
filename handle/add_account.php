<?php
include("../model/ThemSuaXoa.php");
if (!$_POST['Username']) {
    echo json_encode(["status" => "error", "message" => "Thiếu ID"]);
    exit;
}
$a= new ThemSuaXoa();
$MHPass= password_hash($_POST['Password'], PASSWORD_DEFAULT);
$sql = "INSERT INTO `account`
(`Username`, `Password`, `RoleID`, `IsDeleted`) VALUES
 ('".$_POST['Username']."','$MHPass','".$_POST['RoleID']."','0')";
$a->Them($sql);
header('Content-Type: application/json');
echo json_encode(["status" => "success"]);

?>