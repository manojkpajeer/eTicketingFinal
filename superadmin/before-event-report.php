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
    
    $resReport = mysqli_query($conn, "SELECT * FROM event_master WHERE EM_Id = '$_GET[id]'");
    if(mysqli_num_rows($resReport) > 0 ){

        $resReport = mysqli_fetch_assoc($resReport);
    } else {
        
        echo "<script>alert('Oops, unable to process...');location.href='before-event.php';</script>";
    }
    
?>

<!doctype html>
<html lang="en">
  <head>
      <!-- Site Icon -->
    <link rel="icon" href="./assets/images/tab_image.png">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
         * {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important; 
        }
        @page { size: landscape;
        margin: 0; }
    </style>
    <title>Maestro Events</title>
  </head>
  <body style="text-transform:uppercase;font-size: 12px;" onload="window.print();">
  <script>
        window.onafterprint = function(event) {
            location.href="before-event.php";
        };
  </script>
      <div class="container-flied p-3">
          <div class="row mt-3 py-2" style="border-top: dashed 2px #000;">
              <div class="col-4"><?php echo date('H:i'); ?></div>
              <div class="col-4 text-center">DUBAI ETIX<br>MAP REPORT<br><?php echo $resReport['EventCode'];?></div>
              <div class="col-4 text-end"><?php echo date('d-M-y');?></div>
          </div>
          <div class="row mt-3 py-2">
              <div class="col-4 text-end"><?php echo $resReport['EventCode'].'<br><br>START SALES <br>'.date('H:i', strtotime($resReport['DateCreate'])).'<br>'; echo date('d-M-yy', strtotime($resReport['DateCreate']));; ?></div>
              <div class="col-4 text-center p-2" style="border: dashed 2px #000;"><?php echo $resReport['EventLocation'].'<br>'.$resReport['PrintedBy'].'<br>PRESENTS<br>'.$resReport['EventName'].'<br><br>'; echo date('d-M-yy', strtotime($resReport['StartDate']));?></div>
              <div class="col-4 text-start"><?php echo $resReport['EventCode'].'<br><br>START SALES <br>'.date('H:i', strtotime($resReport['DateCreate'])).'<br>'; echo date('d-M-yy', strtotime($resReport['DateCreate'])); ?></div>
          </div>
          <?php
                $rescat = mysqli_query($conn, "SELECT SeatsNo, PriceCategoryName, PriceCategoryId from category_master where EventId = '$resReport[EM_Id]'");
                if(mysqli_num_rows($rescat)>0){
                    while($resReportcat = mysqli_fetch_assoc($rescat)){
                        ?>
                            <div class="row mt-3 py-2" style="border-top: dashed 2px #000;">
                                <div class="col-4">
                                        <?php echo $resReport['EventCode'].'/'.$resReportcat['PriceCategoryName'];?> &nbsp;&nbsp;&nbsp;<?php echo 'pcat = '.$resReportcat['PriceCategoryId'];?><br>
                                        <?php echo $resReportcat['PriceCategoryName'];?><br>
                                        <?php echo $resReportcat['SeatsNo'];?> avails, &nbsp;&nbsp;&nbsp;&nbsp;0 unavails,<br>
                                        0 HOLDS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0 @ H<br>
                                        0 COMPS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0 @ C<br><br>
                                        <?php
                                            $rs2 = mysqli_query($conn, "select PriceNet, PriceTypeCode from price_master where PriceCategoryId = '$resReportcat[PriceCategoryId]'");
                                            if(mysqli_num_rows($rs2)>0){
                                                while($rw2 = mysqli_fetch_assoc($rs2)){
                                                    ?>
                                                        <div class="float-start mx-2">DH<?php echo number_format(($rw2['PriceNet']/100), 2); ?><br>0 @ <?php echo $rw2['PriceTypeCode'];?></div>
                                                    <?php
                                                }
                                            }
                                        ?><br><br><br>
                                        THIS SECTION IS <?php echo $resReportcat['PriceCategoryName'];?>
                                    </div>
                                <div class="col-4 text-center"><br>0 SOLD &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $resReportcat['SeatsNo'];?> CAP</div>
                                <div class="col-4 text-end">ELEV = 0</div>
                            </div>
                        <?php
                    }
                }

                $rescat2 = mysqli_query($conn, "SELECT SeatsNo, PriceCategoryName, PriceCategoryId FROM category_master where EventId = '$resReport[EM_Id]'");
                if(mysqli_num_rows($rescat2)>0){
                    while($resReportcat2 = mysqli_fetch_assoc($rescat2)){
                        ?>
                            <div class="row mt-3 py-2" style="border-top: dashed 2px #000;">
                                <div class="col-4">
                                        <?php echo 'TOTALS FOR PRICE CATEGORY #'.$resReportcat2['PriceCategoryId']?><br>
                                        <?php echo $resReportcat2['SeatsNo'];?> avails, &nbsp;&nbsp;&nbsp;&nbsp;0 unavails,<br>
                                        0 HOLDS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0 @ H<br>
                                        0 COMPS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0 @ C<br><br>
                                        <?php
                                            $rs = mysqli_query($conn, "select PriceNet, PriceTypeCode from price_master where PriceCategoryId = '$resReportcat2[PriceCategoryId]'");
                                            if(mysqli_num_rows($rs)>0){
                                                while($rw = mysqli_fetch_assoc($rs)){
                                                    ?>
                                                        <div class="float-start mx-2">DH<?php echo number_format(($rw['PriceNet']/100), 2); ?><br>0 @ <?php echo $rw['PriceTypeCode'];?></div>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </div>
                                <div class="col-4 text-center"><br>0 SOLD &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $resReportcat2['SeatsNo'];?> CAP</div>
                                <div class="col-4 text-end"></div>
                            </div>
                        <?php
                    }
                }
          

?>
      </div>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>