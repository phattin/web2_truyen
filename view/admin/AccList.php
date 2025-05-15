<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/connectDB.php";
$conn = connectDB::getConnection();
$sql_data='SELECT Username FROM `account`;';
$result_sql=$conn->query( $sql_data );
$data =[];
while($row=$result_sql->fetch_assoc()){
    $data[] = $row["Username"];
};
$ds = implode(',', $data);
header('Content-Type: application/json');
echo json_encode($ds);
?>
