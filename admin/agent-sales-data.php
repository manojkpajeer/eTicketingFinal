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
    require_once '../api/maestro_util.php';
    require_once './pages/header.php';

    $api = new MaestroUtil();

    $eid = $_GET['id'];
?>

<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="data-tables">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card card_border p-4 border-primary-top">
                        <h3 class="card__title position-absolute">Sales List</h3>
                        <div class="table-responsive">
                            <table id="meastroTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order ID</th>
                                        <th>Agent Name</th>
                                        <th>Total Amount</th>
                                        <th>Order Status</th>
                                        <th>Ordered On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                        $resd6 = mysqli_query($conn, "SELECT sales_master.BasketId, sales_master.OrderId, sales_master.DateCreate, sales_master.SM_Id, 
                                            sales_master.SalesStatus, ajent_master.FullName FROM sales_master JOIN ajent_master ON ajent_master.AJM_Id = sales_master.AjentId 
                                            WHERE sales_master.EventId = '$_GET[id]' AND IsSoldByAjent = true ORDER BY sales_master.SM_Id DESC");
                                        if (mysqli_num_rows($resd6) > 0) {

                                            $count = 1;
                                            while($rowd6 = mysqli_fetch_assoc($resd6)) {

                                                $orderId = $rowd6['OrderId'];
                                                
                                                $grandTotal = 0;

                                                $res2 = mysqli_query($conn, "SELECT Quantity, EventId, CategoryId,TypeId FROM sales_data WHERE Status = 1 AND BusketId = '$rowd6[BasketId]'");

                                                if(mysqli_num_rows($res2)>0){
                                                    
                                                    while($row2 = mysqli_fetch_assoc($res2)){

                                                        $resCate = mysqli_query($conn, "SELECT PriceCategoryName FROM category_master WHERE EventId = '$row2[EventId]' AND PriceCategoryId = '$row2[CategoryId]' ");
                                                        if (mysqli_num_rows($resCate)>0){

                                                            $resCate = mysqli_fetch_assoc($resCate);
                                                        } else {

                                                            echo "<script>alert('Oops, Unable to process..!');location.href='agent-sales.php';</script>";
                                                        }

                                                        $restype = mysqli_query($conn, "SELECT PriceTypeName FROM pricetype_master WHERE EventId = '$row2[EventId]' AND PriceTypeId = '$row2[TypeId]' ");
                                                        if (mysqli_num_rows($restype)>0){

                                                            $restype = mysqli_fetch_assoc($restype);
                                                        } else {

                                                            echo "<script>alert('Oops, Unable to process..!');location.href='agent-sales.php';</script>";
                                                        }

                                                        $resPrice = mysqli_query($conn, "SELECT PriceNet FROM price_master WHERE EventId = '$row2[EventId]' AND PriceCategoryId = '$row2[CategoryId]' AND PriceTypeId = '$row2[TypeId]' ");
                                                        if (mysqli_num_rows($resPrice)>0){

                                                            $resPrice = mysqli_fetch_assoc($resPrice);
                                                            $grandTotal += ($resPrice['PriceNet'] * $row2['Quantity']) ;

                                                        } else {

                                                            echo "<script>alert('Oops, Unable to process..!');location.href='agent-sales.php';</script>";
                                                        }
                                                    }
                                                } else {

                                                    echo "<script>alert('Oops, Unable to process..');location.href='agent-sales.php';</script>";
                                                }                                                
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>"; 
                                                echo "<td>".$rowd6['OrderId']."</td>"; 
                                                echo "<td>".$rowd6['FullName']."</td>"; 
                                                echo "<td>".number_format(($grandTotal/100), 2)." AED</td>"; 
                                                echo "<td>";
                                                if ($rowd6['SalesStatus'] == 'Placed') {

                                                    echo "<span class='badge badge-success'>".$rowd6['SalesStatus']."</span>";
                                                } else {

                                                    echo "<span class='badge badge-danger'>".$rowd6['SalesStatus']."</span>";
                                                }
                                                
                                                echo "</td>"; 
                                                echo "<td>".date_format(date_create($rowd6['DateCreate']), 'd M, Y') . "</td>"; 
                                                echo "<td class='text-center'>"; 

                                                ?>
                                                <a href="view-agent-sales-report.php?id=<?php echo $_GET['id'];?>&oid=<?php echo $orderId;?>"><i class="fa fa-clipboard"></i></a> | 
                                                <a href="view-agent-sales-ticket.php?id=<?php echo $_GET['id'];?>&oid=<?php echo $orderId;?>"><i class="fa fa-ticket"></i></a> | 
                                                <a href="view-agent-sales-barcode.php?id=<?php echo $_GET['id'];?>&oid=<?php echo $orderId;?>"><i class="fa fa-barcode"></i></a>
                                                <?php
                                                
                                                echo "</td>";
                                                echo "</tr>"; 

                                                $count++;
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
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