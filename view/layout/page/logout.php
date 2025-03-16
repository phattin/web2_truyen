<?php
session_start();
session_unset();
session_destroy();
header("Location: /WEB2/index.php?trangChu");
exit();
?>
