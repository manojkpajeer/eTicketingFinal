<?php 
    session_start();

    require_once './config/connection.php';

    if(!isset($_SESSION['is_customer_login'])) {

        echo "<script>location.href='login.php';</script>";
    } else {
        if(!$_SESSION['is_customer_login']){

            echo "<script>location.href='login.php';</script>";
        }
    }

    $resOrderData = mysqli_query($conn, "SELECT PaymentId, BasketId, DateCreate, OrderId, CustomerId FROM sales_master WHERE OrderId = '$_GET[oid]'");
    if(mysqli_num_rows($resOrderData)>0){

        $resOrderData = mysqli_fetch_assoc($resOrderData);
    } else {

        echo "<script>alert('Oops, Unable to process..');location.href='index.php';</script>";
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
    <section class="w3l-features-photo-7">
        <div class="w3l-features-photo-7_sur">
            <div class="wrapper">
                <div class="pcoded-content">
                    <div class="card">
                        <div class="card-block">
                            <div id="page-wrapper">
                                <div class="container-fluid">
                                    <div class="row" id="printableArea">
                                        <div class="col-sm-12">
                                            <div class="panel panel-default invoice" id="invoice">
                                                <div class="panel-body p-3">
                                                    <div class="row">
                                                        <div class="col-sm-12 text-center my-4">
                                                            <h4 class="marginright">DXB Tickets - Invoice</h4>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row mt-4">
                                                        <div class="col-4">
                                                <?php
                                                    $rescust = mysqli_query($conn, "SELECT Saluation, FirstName, LastName, CustomerPhone, CustomerEmail, AddressLine1,AddressLine2, CustomerState, CustomerCountry FROM customer_master WHERE CM_Id = '$resOrderData[CustomerId]'");
                                                    if (mysqli_num_rows($rescust) > 0) {
                                                        $rescust  = mysqli_fetch_assoc($rescust);
                                                    } else {
                                                        echo "<script>alert('Oops, Unable to process your request..!');location.href='index.php';</script>";
                                                    }
                                                ?>
                                                <p class="h6 w-75"><strong><?php echo $rescust['Saluation']." ".$rescust['FirstName']." ".$rescust['LastName'];?></strong></p>
                                                <p class="h6 mt-2">Phone: <?php echo $rescust['CustomerPhone'];?></p>
                                                <p class="h6 mt-1">Email ID: <?php echo $rescust['CustomerEmail'];?></p>
                                                <p class="h6 mt-1 pr-3">Address: <?php echo $rescust['AddressLine1'] ." ". $rescust['AddressLine2'];?></p>
                                                <p class="h6 mt-1 pr-3"><?php echo $rescust['CustomerState'] .", ". $rescust['CustomerCountry'];?></p>
                                            </div>

                                            <div class="col-4">
                                                <p class="h6">Order ID: <strong>#<?php echo $resOrderData['OrderId'];?></strong></p>
                                                <p class="h6 mt-1">Date: <?php echo date('d M, Y', strtotime($resOrderData['DateCreate']));?></p>
                                                <p class="h6 mt-1">Time: <?php echo date('h-i-s A', strtotime($resOrderData['DateCreate']));?></p><br>
                                                <?php
                                                    $respay = mysqli_query($conn, "SELECT * FROM payment_master WHERE RP_Id = '$resOrderData[PaymentId]'");
                                                    if (mysqli_num_rows($respay) > 0) {
                                                        $respay  = mysqli_fetch_assoc($respay);
                                                    } else {
                                                        echo "<script>alert('Oops, Unable to process your request..!');location.href='index.php';</script>";
                                                    }
                                                ?>
                                                
                                                <p class="h6 mt-1">Payment ID: <strong>#<?php echo $respay['TransactionId'];?></strong></p>
                                                <p class="h6 mt-1">Paid Date: <?php echo date('d M, Y', strtotime($respay['DatePaid']));?></p>
                                                <p class="h6 mt-1">Paid Time: <?php echo date('h-i-s A', strtotime($respay['DatePaid']));?></p>
                                            </div>

                                            <div class="col-4">
                                                <p class="h6"><b>DXB Tickets</b></p>
                                                <p class="h6 mt-1">Office M-02, DNI Building, </p>
                                                <p class="h6 mt-1">Above RAK Bank, Sheikh Zayed Road,</p>
                                                <p class="h6 mt-1">Post Box 7687, Dubai, UAE</p>
                                                <p class="h6 mt-1">Phone: +(97) 155-120-0104</p>
                                            </div>

                                        </div>
                                        <div class="row table-row mt-3 mr-3">
                                            <table class="table table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width:5%">Sl.No</th>
                                                        <th style="width:35%">Item Description</th>
                                                        <th class="text-right" style="width:12%">Quantity</th>
                                                        <th class="text-right" style="width:12%">Price</th>
                                                        <th class="text-right" style="width:12%">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $grandTotal = 0;
                                                    $res2 = mysqli_query($conn, "SELECT * FROM sales_data WHERE Status = 1 AND BusketId = '$resOrderData[BasketId]'");
                                                    if(mysqli_num_rows($res2)>0){
                                                        $count = 1;
                                                        while($row2 = mysqli_fetch_assoc($res2)){
                                                        ?>
                                                            <tr>
                                                                <td class="text-center"><?php echo $count; ?></td>
                                                                <td>
                                                                    <?php 
                                                                        $resCate = mysqli_query($conn, "SELECT PriceCategoryName FROM category_master WHERE EventId = '$row2[EventId]' AND PriceCategoryId = '$row2[CategoryId]' ");
                                                                        if (mysqli_num_rows($resCate)>0){
                                                                            $resCate = mysqli_fetch_assoc($resCate);
                                                                            echo $resCate['PriceCategoryName'];
                                                                        } else {

                                                                            echo "<script>alert('Oops, Unable to process..!');location.href='index.php';</script>";
                                                                        }

                                                                        $restype = mysqli_query($conn, "SELECT PriceTypeName FROM pricetype_master WHERE EventId = '$row2[EventId]' AND PriceTypeId = '$row2[TypeId]' ");
                                                                        if (mysqli_num_rows($restype)>0){
                                                                            $restype = mysqli_fetch_assoc($restype);
                                                                            echo " (".$restype['PriceTypeName'] .")";
                                                                        } else {

                                                                            echo "<script>alert('Oops, Unable to process..!');location.href='index.php';</script>";
                                                                        }
                                                                    ?>
                                                                </td>
                                                                <td class="text-right"><?php echo $row2['Quantity']; ?></td>
                                                                <?php
                                                                    $resPrice = mysqli_query($conn, "SELECT PriceNet FROM price_master WHERE EventId = '$row2[EventId]' AND PriceCategoryId = '$row2[CategoryId]' AND PriceTypeId = '$row2[TypeId]' ");
                                                                    if (mysqli_num_rows($resPrice)>0){
                                                                        $resPrice = mysqli_fetch_assoc($resPrice);
                                                                    } else {

                                                                        echo "<script>alert('Oops, Unable to process..!');location.href='index.php';</script>";
                                                                    }
                                                                    $grandTotal += ($resPrice['PriceNet']/100) * $row2['Quantity'] ;
                                                                ?>
                                                                <td class="text-right"><?php echo number_format(($resPrice['PriceNet']/100), 2)." AED"; ?></td>
                                                                <td class="text-right"><?php echo number_format((($resPrice['PriceNet']/100) * $row2['Quantity']), 2)." AED"; ?></td>
                                                            </tr>
                                                        <?php
                                                            $count++;
                                                        }
                                                    }
                                                    else{
                                                        echo "<script>alert('Oops, Unable to process..!');location.href='index.php';</script>";
                                                    }
                                                ?>			    
                                            </tbody>
                                        </table>
                                    </div>

                                    
                                    <div class="row text-right mt-3">
                                        <div class="col-6"></div>
                                        <div class="col-6 h5"><b>Grand Total: <span class="pl-3"><?php echo number_format($grandTotal, 2)." AED";?></span></b></div>
                                    </div>
                                <div class="row mt-3">
                                    <div class="col-4"></div>
                                    <div class="col-4">*******THANK YOU*******</div>
                                    <div class="col-4"></div>
                                </div>

                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>


            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
