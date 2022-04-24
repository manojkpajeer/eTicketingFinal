<?php 
    session_start();

    require_once './config/connection.php';
    require 'vendor-barcode/autoload.php';
    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    
    if(!isset($_SESSION['is_customer_login'])) {

        echo "<script>location.href='login.php';</script>";
    } else {
        if(!$_SESSION['is_customer_login']){

            echo "<script>location.href='login.php';</script>";
        }
    }

?>

 
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>DXB Tickets</title>
    <!-- Site Icon -->
    <link rel="icon" href="assets/images/tab_image.png">
    <style>
         * {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important; 
        }
        @page { size: landscape;
        margin: 0; }
    </style>
</head>
<body onload="window.print();">
    <script>
            window.onafterprint = function(event) {
                location.href="accounts.php";
            };
    </script>
        <div class="container-fluid">
        <?php
            $resBar = mysqli_query($conn, "SELECT PerformanceCode, PriceCategoryCode, Barcode FROM barcode_master WHERE OrderId = '$_GET[oid]'");
            if(mysqli_num_rows($resBar)>0){
        
                while ($rowBar = mysqli_fetch_assoc($resBar)) {

                    $resEve = mysqli_query($conn, "SELECT EventName, EventLocation, AgeLimit, StartDate, EM_Id FROM event_master WHERE EventCode = '$rowBar[PerformanceCode]' AND EventStatus = 'Publish'");
                    if(mysqli_num_rows($resEve)>0){

                        $resEve = mysqli_fetch_assoc($resEve);
                    } else {

                        echo "<script>alert('Oops, Unable to process..');location.href='orders.php?oid=".$_GET['oid'].";</script>";
                    }

                    $resCat = mysqli_query($conn, "SELECT PriceCategoryName FROM category_master WHERE PriceCategoryId = '$rowBar[PriceCategoryCode]' AND EventId = '$resEve[EM_Id]'");
                    if(mysqli_num_rows($resCat)>0){

                        $resCat = mysqli_fetch_assoc($resCat);
                    } else {

                        echo "<script>alert('Oops, Unable to process..');location.href='orders.php?oid=".$_GET['oid'].";</script>";
                    }

                    ?>
                        <div class="row mt-2 p-2">
                            <div class="col-4 row" style="font-size: 12px;">
                                <div class="col-8">
                                    <span><strong><?php echo $resEve['EventName'];?></strong> </span><br>
                                    <span>Category </span><br>
                                    <span><strong><?php echo $resCat['PriceCategoryName'];?></strong></span><br>
                                    <span>
                                    DTCM : <?php echo $rowBar['Barcode'];?>
                                    </span>
                                    <br><br><br>
                                </div>
                                <div class="col-4 text-center">
                                    <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo $rowBar['Barcode'];?>&choe=UTF-8" title="DXB Tickets" height="80" width="80"/>
                                </div>
                                <span>
                                <?php 
                                    echo $generator->getBarcode($rowBar['Barcode'], $generator::TYPE_CODE_128);
                                    echo "<small class='mt-1'>$rowBar[Barcode]</small>";
                                ?>
                                </span>
                            </div>

                            <div class="col-4" style="font-size: 15px;">
                                <span><strong><?php echo $resEve['EventName'];?></strong></span><br>
                                <span>Category </span><br>
                                <span><strong><?php echo $resCat['PriceCategoryName'];?></strong></span><br>
                                <span>
                                Category : <?php echo $resCat['PriceCategoryName'];?><br>
                                Location : <?php echo $resEve['EventLocation'];?>
                                </span>
                            </div>

                            <div class="col-4 mt-2" style="font-size: 15px;">
                                <span>Gates Open </span><br>
                                <span><strong><?php echo date('h:i A', strtotime($resEve['StartDate'])); echo ", "; echo date('M d, Y', strtotime($resEve['StartDate']));?>,</strong></span>
                                <br><br>
                                <?php 
                                    echo $generator->getBarcode($rowBar['Barcode'], $generator::TYPE_CODE_128);
                                    echo "<small class='mt-2'>$rowBar[Barcode]</small>";
                                ?>
                                </h6>
                            </div>
                        </div>
                        <hr>
                    <?php

                }
            } else {
        
                echo "<script>alert('Oops, Unable to process..');location.href='orders.php?oid=".$_GET['oid'].";</script>";
            }
        ?>
      </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
