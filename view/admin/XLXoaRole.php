<?php
$RoleID = $_GET["RoleID"];
        $sql = "DELETE FROM `role` WHERE RoleID='$RoleID'";
        $a = new ThemSuaXoa();
        $a->Xoa($sql);
        header("Location: /webbantruyen/view/admin/");
?>