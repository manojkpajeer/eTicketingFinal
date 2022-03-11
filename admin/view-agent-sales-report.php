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
    require_once './pages/link.php';
    require_once './pages/sidebar.php';
    require_once './pages/header.php';

    $resOrderData = mysqli_query($conn, "SELECT BasketId, DateCreate, OrderId, AjentId, CustomerId FROM sales_master WHERE OrderId = '$_GET[oid]'");
    if(mysqli_num_rows($resOrderData)>0){

        $resOrderData = mysqli_fetch_assoc($resOrderData);
    } else {

        echo "<script>alert('Oops, Unable to process..');location.href='agent-sales-data.php?id=".$_GET['id'].";</script>";
    }
?>

<div class="main-content">
    <div class="container-fluid content-top-gap">
        <script>
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
        </script>

        <div class="pcoded-content">
            <div class="card">
                <div class="card-block">
                    <div id="page-wrapper">
                        <button class="btn border float-right btn-primary" onclick="printDiv('printableArea')">Print</button>
                        <div class="container-fluid">
                            <div class="row" id="printableArea">
                                <div class="col-sm-12">
                                    <div class="panel panel-default invoice" id="invoice">
                                        <div class="panel-body p-3">
                                            <div class="row">
                                                <div class="col-sm-12 text-center my-2">
                                                    <h4 class="marginright">DXB Tickets - Invoice</h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row mt-4">
                                                <div class="col-4">
                                                    <?php
                                                        $rescust = mysqli_query($conn, "SELECT Saluation, FirstName, LastName, CustomerPhone, CustomerEmail, AddressLine1, AddressLine2, CustomerState, CustomerCountry FROM agent_customer WHERE AC_Id = '$resOrderData[CustomerId]'");
                                                        
                                                        if (mysqli_num_rows($rescust) > 0) {
                                                        
                                                            $rescust  = mysqli_fetch_assoc($rescust);
                                                        } else {
                                                        
                                                            echo "<script>alert('Oops, Unable to process..');location.href='agent-sales-data.php?id=".$_GET['id'].";</script>";
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
                                                <table class="table">
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

                                                                                    echo "<script>alert('Oops, Unable to process..');location.href='agent-sales-data.php?id=".$_GET['id'].";</script>";
                                                                                }

                                                                                $restype = mysqli_query($conn, "SELECT PriceTypeName FROM pricetype_master WHERE EventId = '$row2[EventId]' AND PriceTypeId = '$row2[TypeId]' ");
                                                                                if (mysqli_num_rows($restype)>0){
                                                                                    $restype = mysqli_fetch_assoc($restype);
                                                                                    echo " (".$restype['PriceTypeName'] .")";
                                                                                } else {

                                                                                    echo "<script>alert('Oops, Unable to process..');location.href='agent-sales-data.php?id=".$_GET['id'].";</script>";
                                                                                }
                                                                            ?>
                                                                        </td>
                                                                        <td class="text-right"><?php echo $row2['Quantity']; ?></td>
                                                                        <?php
                                                                            $resPrice = mysqli_query($conn, "SELECT PriceNet FROM price_master WHERE EventId = '$row2[EventId]' AND PriceCategoryId = '$row2[CategoryId]' AND PriceTypeId = '$row2[TypeId]' ");
                                                                            if (mysqli_num_rows($resPrice)>0){

                                                                                $resPrice = mysqli_fetch_assoc($resPrice);
                                                                            } else {

                                                                                echo "<script>alert('Oops, Unable to process..');location.href='agent-sales-data.php?id=".$_GET['id'].";</script>";
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
                                                                
                                                                echo "<script>alert('Oops, Unable to process..');location.href='agent-sales-data.php?id=".$_GET['id'].";</script>";
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
    </div>
</div>


<?php
    require_once './pages/footer.php';
?>
