<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/customerDB.php";

header("Content-Type: application/json");

$customerID = $_POST["customerID"] ?? null;
$action = $_POST["action"] ?? null;

if (!$customerID || !$action || !in_array($action, ["lock", "unlock"])) {
    echo json_encode(["success" => false, "message" => "Dữ liệu không hợp lệ"]);
    exit;
}

$isBlocked = ($action === "lock") ? 1 : 0;

$result = customerDB::setIsBlocked($customerID, $isBlocked);

if ($result) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Không thể cập nhật trạng thái"]);
}