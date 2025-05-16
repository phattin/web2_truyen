<?php
include("../model/ThemSuaXoa.php");

$a = new ThemSuaXoa();
$data = json_decode(file_get_contents("php://input"), true);
$roleID = $data['RoleID'] ?? null;
$permissions = $data['Permissions'] ?? [];

if (!$roleID || !is_array($permissions)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ']);
    exit;
}

// Xóa quyền cũ
$sql = 'DELETE FROM `function_detail` WHERE RoleID = "'.$roleID.'";';
$a->Xoa($sql);

// Bản đồ Function
$functionMap = [
    'TK' => 'F001',
    'SP' => 'F002',
    'HDN' => 'F003',
    'HD' => 'F004',
    'NV' => 'F005',
    'KH' => 'F006',
    'Q' => 'F007',
    'CL' => 'F008',
    'KM' => 'F009',
    'NCC' => 'F010',
    'S' => 'F011',
];

$addedFunctions = [];

foreach ($permissions as $perm) {
    if (preg_match('/^(Xem|T|S|X)([A-Z]+)$/', $perm, $matches)) {
        $optionCode = $matches[1]; // Xem, T, S, X
        $funcKey = $matches[2];    // TK, SP, ...

        // Đổi tên option tương ứng
        switch ($optionCode) {
            case 'T':
                $optionText = 'Thêm';
                break;
            case 'S':
                $optionText = 'Sửa';
                break;
            case 'X':
                $optionText = 'Xóa';
                break;
            case 'Xem':
                $optionText = 'Xem';
                break;
            default:
                $optionText = null;
        }

        if ($optionText && isset($functionMap[$funcKey])) {
            $functionID = $functionMap[$funcKey];

            $sql = "INSERT INTO `function_detail`(`RoleID`, `FunctionID`, `Option`) 
                    VALUES ('$roleID', '$functionID', '$optionText')";
            $a->Them($sql);

            $addedFunctions[] = "$perm => $functionID ($optionText)";
        }
    }
}

header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'message' => 'Đã thay đổi chức năng',
    'added' => $addedFunctions,
    'permissions' => $permissions
]);
exit;
?>