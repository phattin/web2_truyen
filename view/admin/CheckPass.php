<?php
$PasswordOld = $_POST['PasswordOld'];
$hashPass = $_POST['hashPass'];

if (password_verify($PasswordOld, $hashPass)) {
    echo json_encode(true);
} else {
    echo json_encode(false);
}
?>