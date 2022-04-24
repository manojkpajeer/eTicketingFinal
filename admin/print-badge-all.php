<?php
    session_start();
            
    if(!isset($_SESSION['is_staff_login'])){
        header('Location: ./pages/logout.php');
    }
    else{
        if(!$_SESSION['is_staff_login']){
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

    <title>Maestro Events</title>
    <!-- Site Icon -->
    <link rel="icon" href="assets/images/tab_image.png">
    <style>
         * {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important; 
        }
        @page { size: letter portrait;
        margin: 0; }
    </style>
  </head>
  <body onload="window.print();">
  <script>
        window.onafterprint = function(event) {
            location.href="manage-badge.php?eid=<?php echo $_GET['eid']; ?>&ecode=<?php echo $_GET['ecode']; ?>";
        };
  </script>
      <div class="container-fluid">
          <div class="row">
            <?php
                $res = mysqli_query($conn, "SELECT * FROM badge_master WHERE EventId = '$_GET[eid]'");
                if(mysqli_num_rows($res)>0){
                    while($row = mysqli_fetch_assoc($res)){
                    ?>
                        <div class="col-4">
                            <div class="card text-center border-0">
                                <div class="card-body text-center" style="margin-left: auto;margin-right: auto;">
                                    <h5 class="card-title my-3"><?php echo $row['FirstName'] . " " . $row['LastName'];?></h5>
                                    <h6 class="card-subtitle mb-3 text-muted"><?php if (empty($row['CompanyName'])){echo $row['Designation'];}else {echo $row['CompanyName'];}?></h6>
                                    <h6 class="text-center" >
                                    <?php 
                                        echo $generator->getBarcode($row['BarcodeNo'], $generator::TYPE_CODE_128);
                                        echo "<small style='font-size:10px;'>$row[BarcodeNo]</small>";
                                    ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    <?php
                    }   
                }
                ?>
          </div>
      </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>