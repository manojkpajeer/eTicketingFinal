<?php
    require_once '../config/connection.php';

    $eventId = $_POST['eventId'];
    $categoryId = $_POST['categoryId'];
    $typeId = $_POST['typeId'];
    $quatityNO = $_POST['quatityNO'];
    $totalPrice = '0.00';

    if (!empty($eventId)) {

        if(!$categoryId) {

            if(!empty($typeId)){

                $resType = mysqli_query($conn, "SELECT PriceNet FROM price_master WHERE PriceCategoryId = '$categoryId' AND PriceTypeId = '$typeId' AND EventId = '$eventId' ");

                if (mysqli_num_rows($resType) > 0){
                    $rowType = mysqli_fetch_assoc($resType);

                    if (!empty($quatityNO)) {
                        
                        $totalPrice = number_format((($rowType['PriceNet'] / 100) * $quatityNO), 2);
                    }
                }
            }
        }
    }
    

    echo $totalPrice;
?>