<?php 
    session_start();

    require_once './config/connection.php';
    require_once './pages/link.php';
    require_once './pages/header.php';

    if(!isset($_SESSION['is_customer_login'])) {

        echo "<script>location.href='login.php';</script>";
    } else {
        if(!$_SESSION['is_customer_login']){

            echo "<script>location.href='login.php';</script>";
        }
    }
?>

<section class="w3l-price-2">
    <div class="price-main">
      <div class="wrapper">
            <div class="section-title align-center text-center">
                       <h4>Your Orders</h4>
                   </div>
            <div class="pricing-style-w3ls">
              <div class="pricing-chart">    
                  
                <?php
                    $resSales = mysqli_query($conn, "SELECT * FROM sales_master WHERE CustomerId = '$_SESSION[cm_id]' AND SalesStatus = 'Placed' ORDER BY SM_Id DESC");
                    if (mysqli_num_rows($resSales) > 0) {

                        while($rowSales = mysqli_fetch_assoc($resSales)) {

                            // $resTotal = mysqli_query($conn, "SELECT * FROM sales_data WHERE BusketId = '$rowSales[BasketId]' AND Status = 1");
                            // if (mysqli_num_rows($resTotal) > 0) {

                            // }
                            ?>
                            <div class="price-box btn-layout bt6">
                                <div class="grid grid-column-2">
                                    <div class="column1">
                                        <div class="job-info">
                                            <h5><?php echo date_format(date_create($rowSales['DateCreate']), 'F d, Y') ; ?> </h5>
                                            <h6 class="pricehead">
                                                <a href="">
                                                    <?php 
                                                        $resevename = mysqli_query($conn, "SELECT EventName FROM event_master WHERE EM_Id = '$rowSales[EventId]'");
                                                        if (mysqli_num_rows($resevename) > 0) {
                                                            $resevename = mysqli_fetch_assoc($resevename);
                                                            echo $resevename['EventName'];
                                                        } 
                                                    ?>
                                                </a>
                                            </h6>  
                                            <p class="mt-2"><strong><?php echo '#' . $rowSales['OrderId']; ?></strong></p>                                          
                                        </div>
                                    </div>

                                    <div class="column2">
                                    </div>
                                            
                                    <div class="column3 text-right">
                                        <a href="view-ticket2.php?oid=<?php echo $rowSales['OrderId'];?>" class="actionbg">Ticket</a>
                                        <a href="view-invoice.php?oid=<?php echo $rowSales['OrderId'];?>" class="actionbg mt-3">Invoice</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }

                    } else {
                        echo "No purchase found..";
                    }
                ?>
            </div>
        </div>
    </div>
</section>

<?php
    require_once './pages/newsletter.php';
    require_once './pages/footer.php';
?>