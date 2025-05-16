<?php
session_start();
session_unset();
session_destroy();
header("Location: /webbantruyen/view/admin/index.php");
exit();
?>
