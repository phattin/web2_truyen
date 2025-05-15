<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
$conn = connectDB::getConnection();
$sql = "SELECT employee.EmployeeID, employee.Fullname
        FROM employee
        LEFT JOIN account ON employee.EmployeeID = account.EmployeeID
        WHERE account.EmployeeID IS NULL;";
$result = $conn->query($sql);
$options = "";
while ($row = $result->fetch_assoc()) {
    $options .= "<option value='" . $row["EmployeeID"] . "'>" . $row["EmployeeID"] . " (" . $row["Fullname"] . ")</option>";
}
echo $options;
?>
