<?php
    include("../../model/connectDB.php");
    //function cre_ID(){
    $a = new connectDB(); // Tạo object
    $conn = $a->getConnection(); // Lấy kết nối đúng cách

    $sql = "SELECT `ProductID` FROM `product`";
    $result = mysqli_query($conn, $sql);

    $arg_ID = [];
    $n = 0;

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $arg_ID[$n] = explode('P', $row["ProductID"], 2); // ["", "001"]
            $n++;
        }

        // Sắp xếp theo phần số (nếu có)
        usort($arg_ID, function($a, $b) {
            return intval($b[1]) - intval($a[1]); // từ lớn đến nhỏ
        });

        $newNumber = $arg_ID[0][1] + 1;
        $newIDSP = "P" . str_pad($newNumber, 3, "0", STR_PAD_LEFT); // Ví dụ: 12 => P012
    } else {
        echo "Lỗi truy vấn: " . mysqli_error($conn);
    }
//}

    $a = new connectDB(); // Tạo object
    $conn = $a->getConnection(); // Lấy kết nối đúng cách

    $sql = "SELECT `CustomerID` FROM `customer`";
    $result = mysqli_query($conn, $sql);

    $arg_ID = [];
    $n = 0;

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $arg_ID[$n] = explode('P', $row["CustomerID"], 2); // ["", "001"]
            $n++;
        }

        // Sắp xếp theo phần số (nếu có)
        usort($arg_ID, function($a, $b) {
            return intval($b[1]) - intval($a[1]); // từ lớn đến nhỏ
        });

        $newNumber = $arg_ID[0][1] + 1;
        $newIDKH = "P" . str_pad($newNumber, 3, "0", STR_PAD_LEFT); // Ví dụ: 12 => P012
    } else {
        echo "Lỗi truy vấn: " . mysqli_error($conn);
    }
?>