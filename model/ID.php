<?php
function generateNextID($conn, $table, $column, $prefix) {
    $sql = "SELECT `$column` FROM `$table`";
    $result = mysqli_query($conn, $sql);

    $ids = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {
            if (preg_match("/$prefix(\d+)/", $row[$column], $matches)) {
                $ids[] = intval($matches[1]);
            }
        }

        $max = max($ids);
        $next = $max + 1;
    } else {
        $next = 1;
    }

    return $prefix . str_pad($next, 3, "0", STR_PAD_LEFT);
}
?>