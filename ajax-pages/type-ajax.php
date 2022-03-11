<?php
    require_once '../config/connection.php';

    $eventId = $_POST['eventId'];
    $categoryId = $_POST['categoryId'];
    $datas = "";

    if (!empty($eventId)) {

        if (!empty($categoryId)) {

            $resType = mysqli_query($conn, "SELECT pricetype_master.PriceTypeId, pricetype_master.PriceTypeName FROM price_master JOIN pricetype_master ON price_master.PriceTypeId = pricetype_master.PriceTypeId WHERE price_master.EventId = '$eventId' AND pricetype_master.EventId = '$eventId' AND price_master.PriceCategoryId='$categoryId' AND NOT pricetype_master.PriceTypeName ='COMP'");

            if (mysqli_num_rows($resType) > 0){
                
                if (mysqli_num_rows($resType) == 1) {

                    $resType = mysqli_fetch_assoc($resType);

                    $datas = "<option value='".$resType['PriceTypeId']."'>".$resType['PriceTypeName']."</option>";
                } else {

                    $datas .= "<option value=''>Choose..</option>";
                    while ($rowType = mysqli_fetch_assoc($resType)) {
                    
                        $datas .= "<option value='".$rowType['PriceTypeId']."'>".$rowType['PriceTypeName']."</option>";        
                    }
                }
            }
        }
    }

    echo $datas;
?>