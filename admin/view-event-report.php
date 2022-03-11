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

    $resReport = mysqli_query($conn, "SELECT * FROM event_master WHERE EM_Id = '$_GET[id]'");
    if(mysqli_num_rows($resReport) > 0 ){

        $resReport = mysqli_fetch_assoc($resReport);
    } else {
        
        echo "<script>alert('Oops, unable to process...');location.href='event-report.php';</script>";
    }
?>


<!doctype html>
<html lang="en">
    <head>
        <!-- Site Icon -->
        <link rel="icon" href="assets/images/tab_image.png">

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
            @page { 
            margin: 0; }
        </style>
        <title>Maestro Events</title>
    </head>
  <body style="font-size: 16px;" onload="window.print();">
  <script>
        window.onafterprint = function(event) {
            location.href="event-report.php";
        };
  </script>

    <div class="container">
        <div class="row my-5">
            <div class="col-12">
                <table class="table table-bordered">
                    <tr>
                        <th class="bg-danger py-1 text-light" colspan="4"><h6><?php echo $resReport['EventCode']; ?> | <?php echo $resReport['EventName']; ?> | DATP16 | <?php echo date('d-m-Y', strtotime($resReport['StartDate']));?> <?php echo date('H:i', strtotime($resReport['StartTime']));?></h6></th>
                    </tr>
                    <tr>
                        <th class="bg-danger py-3 text-light" colspan="4"></th>
                    </tr>
                    <tr class="bg-secondary">
                        <th class="h6">Category</th>
                        <th class="h6" style="text-align:right">Cat. Price</th>
                        <th class="h6" style="text-align:right">Sold</th>
                        <th class="h6" style="text-align:right">Total</th>
                    </tr>
                    <?php
                        $totalquantity = 0;
                        $totalamount = 0;
                        $rescat = mysqli_query($conn, "SELECT category_master.PriceCategoryName, category_master.PriceCategoryId, pricetype_master.PriceTypeName, pricetype_master.PriceTypeId, pricetype_master.PriceTypeName, pricetype_master.PriceTypeCode, price_master.PriceNet FROM price_master JOIN pricetype_master ON price_master.PriceTypeId = pricetype_master.PriceTypeId JOIN category_master ON category_master.PriceCategoryId = price_master.PriceCategoryId WHERE price_master.EventId = '$resReport[EM_Id]' AND category_master.EventId = '$resReport[EM_Id]' AND pricetype_master.EventId = '$resReport[EM_Id]' ORDER BY category_master.PriceCategoryId DESC");
                        if(mysqli_num_rows($rescat)>0){
                            while($rowcat = mysqli_fetch_assoc($rescat)){ 
                                echo "<tr class='bg-light'><td>" . $rowcat['PriceCategoryName'] . "<br>(S" . $rowcat['PriceTypeName'] . "|PCAT=" . $rowcat['PriceCategoryId']. "|Price type@ " . $rowcat['PriceTypeCode'] . ")</td><td style='text-align:right'>" . number_format($rowcat['PriceNet']/100, 2) . " AED</td><td style='text-align:right'>";
                                $res1 = mysqli_query($conn, "SELECT COALESCE(SUM(Quantity), 0) AS Quantity FROM sales_data WHERE CategoryId = '$rowcat[PriceCategoryId]' AND EventId = '$resReport[EM_Id]' AND Status = true");
                                $quantitysold = 0;
                                if (mysqli_num_rows($res1)>0) {
                                    $row1 = mysqli_fetch_assoc($res1);
                                    $quantitysold = $row1['Quantity'];
                                    $totalquantity = $totalquantity  + $row1['Quantity'];
                                }
                                $totalamount = $totalamount + (($quantitysold * $rowcat['PriceNet'])/100);
                                echo $quantitysold . "</td> <td style='text-align:right'>".number_format((($quantitysold * $rowcat['PriceNet'])/100), 2)." AED</td></tr>";
                            }
                        }
                    ?>
                    <tr class="bg-secondary text-light ">
                        <th class="h6">Subtotal</th>
                        <th class="h6" style="text-align:right"></th>
                        <th class="h6" style="text-align:right"><?php echo $totalquantity; ?></th>
                        <th class="h6" style="text-align:right"><?php echo number_format($totalamount, 2); ?> AED</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>


      </div>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>