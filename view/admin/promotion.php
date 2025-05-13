<?php
echo"
    <input type='button' value='Thêm' class='blue-btn' onclick='themKM()' style='width:100%;'>
    <table class='product-admin-table'>
        <tr>
            <th>Mã khuyến mãi</th>
            <th>Tên khuyến mãi</th>
            <th>Giá trị giảm(%)</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Thao tác</th>
        </tr>";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/webbantruyen/model/promotionDB.php";
        $promotions = promotionDB::getAllPromotion();
        foreach ($promotions as $promotion) {
            if($promotion["PromotionID"] !== "PR000")
                echo "<tr id='promotion-row-".$promotion["PromotionID"]."'>
                        <td>" . $promotion["PromotionID"] . "</td>
                        <td>" . $promotion["PromotionName"] . "</td>
                        <td>" . $promotion["Discount"] . "</td>
                        <td>" . $promotion["StartDate"] . "</td>
                        <td>" . $promotion["EndDate"] . "</td>
                        <td class='function-icon'>
                            <i class='fa-regular fa-pen-to-square edit-icon' onclick='suaKM(`".$promotion["PromotionID"]."`)'></i>
                            <i class='fa-regular fa-trash-can delete-icon' onclick='xoaKM(`".$promotion["PromotionID"]."`)'></i>
                        </td>
                    </tr>";
        }
echo "
    </table>
    "
?>