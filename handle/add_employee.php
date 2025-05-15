<?php
include("../model/ThemSuaXoa.php");
include("../model/ID.php");
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
$conn = connectDB::getConnection();

$ID = generateNextID($conn, "employee", "EmployeeID", "E");
$fullname= $_POST["Fullname"];
$birthDay= $_POST["BirthDay"];
$phone =$_POST["Phone"];
$email= $_POST["Email"];
$address= $_POST["Address"];
$salary= (int)$_POST["Salary"];
$genre= $_POST["Gender"];
$startDate= date("Y-m-d");

$a = new ThemSuaXoa();
$sql = "INSERT INTO `employee`
(`EmployeeID`, `Fullname`, `BirthDay`, `Phone`, `Email`, `Address`, `Gender`, `Salary`, `StartDate`, `IsDeleted`) 
VALUES ('$ID','$fullname','$birthDay','$phone','$email','$address','$genre','$salary','$startDate','0')";
$a->Them("$sql");
$conn->close();

echo json_encode(["status" => "success"]);
?>