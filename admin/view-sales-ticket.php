<?php 
    session_start();
            
    if(!isset($_SESSION['is_admin_login'])){
        header('Location: ./pages/logout.php');
    }
    else{
        if(!$_SESSION['is_admin_login']){
            header('Location: ./pages/logout.php');
        }
    }
    
    require_once '../config/connection.php';
    require 'vendor-barcode/autoload.php';
    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();

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
                location.href="<?php echo 'sales-data.php?id='.$_GET['id'];?>";
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

                        echo "<script>alert('Oops, Unable to process..');location.href='sales-data.php?id=".$_GET['id'].";</script>";
                    }

                    $resCat = mysqli_query($conn, "SELECT PriceCategoryName FROM category_master WHERE PriceCategoryId = '$rowBar[PriceCategoryCode]' AND EventId = '$resEve[EM_Id]'");
                    if(mysqli_num_rows($resCat)>0){

                        $resCat = mysqli_fetch_assoc($resCat);
                    } else {

                        echo "<script>alert('Oops, Unable to process..');location.href='sales-data.php?id=".$_GET['id'].";</script>";
                    }

                    ?>
                        <div class="row mt-2 p-2">
                            <div class="col-4" style="font-size: 12px;">
                                <span><strong><?php echo $resEve['EventName'];?></strong> </span><br>
                                <span>Category </span><br>
                                <span><strong><?php echo $resCat['PriceCategoryName'];?></strong></span><br>
                                <span>
                                DTCM : <?php echo $rowBar['Barcode'];?>
                                <br><br><br>
                                <?php 
                                    echo $generator->getBarcode($rowBar['Barcode'], $generator::TYPE_CODE_128);
                                    echo "<small>$rowBar[Barcode]</small>";
                                ?>
                                </span>
                            </div>

                            <div class="col-4" style="font-size: 15px;">
                                <span><strong><?php echo $resEve['EventName'];?></strong></span><br>
                                <span>Category </span><br>
                                <span><strong><?php echo $resCat['PriceCategoryName'];?></strong></span><br>
                                <span>
                                Category : <?php echo $resCat['PriceCategoryName'];?><br>
                                Location : <?php echo $resEve['EventLocation'];?><br>
                                Age Limit : <?php echo $resEve['AgeLimit'];
                                ?>
                                </span>
                            </div>

                            <div class="col-4 mt-2 pt-5" style="font-size: 15px;">
                                <span>Gates Open </span><br>
                                <span><strong><?php echo date('h:i A', strtotime($resEve['StartDate'])); echo ", "; echo date('M d, Y', strtotime($resEve['StartDate']));?>,</strong></span>
                                <br><br>
                                <?php 
                                    echo $generator->getBarcode($rowBar['Barcode'], $generator::TYPE_CODE_128);
                                    echo "<small>$rowBar[Barcode]</small>";
                                ?>
                                </h6>
                            </div>
                        </div>
                        <hr>
                    <?php

                }
            } else {
        
                echo "<script>alert('Oops, Unable to process..');location.href='sales-data.php?id=".$_GET['id'].";</script>";
            }
        ?>
      </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
