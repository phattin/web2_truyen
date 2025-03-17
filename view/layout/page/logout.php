<?php
session_start();
session_unset();
session_destroy();
header("Location: /webbantruyen/index.php?trangChu");
exit();
?>
