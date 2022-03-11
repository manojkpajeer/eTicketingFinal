<?php
    session_start();
        
    if(!isset($_SESSION['is_ajent_login'])){
        header('Location: ./pages/logout.php');
    }
    else{
        if(!$_SESSION['is_ajent_login']){
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
                location.href="<?php echo 'manage.php?id='.$_GET['id'];?>";
            };
    </script>
        <div class="container-fluid">
            <div class="row p-3">
        <?php
            $resBar = mysqli_query($conn, "SELECT Barcode FROM barcode_master WHERE OrderId = '$_GET[oid]'");
            if(mysqli_num_rows($resBar)>0){
        
                while ($rowBar = mysqli_fetch_assoc($resBar)) {
                    ?>
                        <div class="col-4 my-2">
                            <?php 
                                echo $generator->getBarcode($rowBar['Barcode'], $generator::TYPE_CODE_128);
                                echo "<small style='font-size:10px;'>$rowBar[Barcode]</small>";
                            ?>
                        </div>
                    <?php

                }
            } else {
        
                echo "<script>alert('Oops, Unable to process..');location.href='manage.php?id=".$_GET['id'].";</script>";
            }
        ?>
      </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
