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
    require_once './pages/link.php';
    require_once './pages/sidebar.php';
    require_once './pages/header.php';

    unset($_SESSION['cart_item']);
?>

<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="data-tables">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card card_border p-4 border-primary-top">
                        <h3 class="card__title position-absolute">All Events Info</h3>
                        <div class="table-responsive">
                            <table id="meastroTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Banner</th>
                                        <th>Event Name</th> 
                                        <th>Location</th> 
                                        <th>Event On</th>
                                        <th>Booking Line</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $resd6 = mysqli_query($conn, "SELECT DISTINCT event_master.EventLocation, event_master.BookingStatus, event_master.EM_Id, event_master.EventBanner, 
                                        event_master.StartDate, event_master.EventName, event_master.EventStatus  FROM ticket_allocation
                                        JOIN event_master ON event_master.EM_Id = ticket_allocation.EventId WHERE 
                                        ticket_allocation.AjentId = '$_SESSION[ajm_id]' AND NOT EventStatus = 'New' ORDER BY event_master.EM_Id DESC");
                                        if (mysqli_num_rows($resd6) > 0) {

                                            $count = 1;
                                            while($rowd6 = mysqli_fetch_assoc($resd6)) {
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>"; 
                                                echo "<td> <img src='../admin/".$rowd6['EventBanner']."' class='rounded-circle mr-2' width='40px' alt=''></td>"; 
                                                echo "<td>".$rowd6['EventName']."</td>"; 
                                                echo "<td>".$rowd6['EventLocation']."</td>"; 
                                                echo "<td>".date_format(date_create($rowd6['StartDate']), 'd M, Y') . "</td>"; 
                                                if ($rowd6['BookingStatus']) {
                                                    echo "<td><span class='badge badge-success'>Open</span></td>";
                                                } else {
                                                    echo "<td><span class='badge badge-danger'>Closed</span></td>";
                                                }
                                                echo "<td>"; 
                                                ?>
                                                    <a href="#" data-toggle="modal" data-target="#view<?php echo $rowd6['EM_Id'];?>"><i class='fa fa-eye'></i></a> |
                                                <?php
                                                echo "<a href='manage.php?id=$rowd6[EM_Id]'><i class='fa fa-database'></i></a> | ";

                                                if ($rowd6['EventStatus'] == 'Publish' && $rowd6['BookingStatus'] == true) {

                                                    ?>
                                                    <a href="#" data-toggle="modal" data-target="#sell<?php echo $rowd6['EM_Id'];?>"><i class='fa fa-shopping-cart'></i></a>
                                                    <?php
                                                }
                                            echo "</td>";
                                            echo "</tr>"; 

                                            $count++;

                                            ?>
                                                <div class="modal fade" id="view<?php echo $rowd6['EM_Id'];?>" tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <form method="POST" enctype="multipart/form-data">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo "Your Ticket List";?></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body g-3 row">
                                                                    <div class="col-6"><strong>Ticket Class</strong></div>
                                                                    <div class="col-3"><strong>Total Ticket</strong></div>
                                                                    <div class="col-3"><strong>Unsold</strong></div>

                                                                    <?php

                                                                        $resd7 = mysqli_query($conn, "SELECT category_master.PriceCategoryName, COALESCE(SUM(ticket_allocation.Quantity), 0) AS Quantity, 
                                                                            category_master.PriceCategoryId FROM ticket_allocation JOIN category_master ON 
                                                                            category_master.PriceCategoryId = ticket_allocation.CategoryId WHERE ticket_allocation.EventId = '$rowd6[EM_Id]' AND 
                                                                            ticket_allocation.AjentId = '$_SESSION[ajm_id]' AND category_master.EventId = '$rowd6[EM_Id]' GROUP BY category_master.PriceCategoryName, category_master.PriceCategoryId ");

                                                                        if (mysqli_num_rows($resd7) > 0) {
                                                                                                                            
                                                                            while($rowd7 = mysqli_fetch_assoc($resd7)) {
                                                                                
                                                                                echo "<div class='col-6 mt-2'>$rowd7[PriceCategoryName]</div>";
                                                                                echo "<div class='col-3 mt-2'>$rowd7[Quantity]</div>";

                                                                                $resSold = mysqli_query($conn, "SELECT BasketId FROM sales_master WHERE EventId = '$rowd6[EM_Id]' AND SalesStatus = 'Placed' 
                                                                                    AND IsSoldByAjent = true AND AjentId = '$_SESSION[ajm_id]'");
                                                                                
                                                                                $quantitySold = 0;
                                                                                
                                                                                if (mysqli_num_rows($resSold)>0) {
                                
                                                                                    while ($rowSold = mysqli_fetch_assoc($resSold)) {
                                                                                        
                                                                                        $resSalesData = mysqli_query($conn, "SELECT Quantity FROM sales_data WHERE Status = 1 AND BusketId = '$rowSold[BasketId]' AND EventId = '$rowd6[EM_Id]' AND CategoryId = '$rowd7[PriceCategoryId]'");
                                
                                                                                        if (mysqli_num_rows($resSalesData)>0){
                                                                                            while ($rowSalesData = mysqli_fetch_assoc($resSalesData)) {
                                
                                                                                                $quantitySold += $rowSalesData['Quantity'];
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }

                                                                                echo "<div class='col-3 mt-2'>".($rowd7['Quantity'] - $quantitySold)."</div>";
                                                                            }
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="modal fade" id="sell<?php echo $rowd6['EM_Id'];?>" tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <form method="POST" enctype="multipart/form-data">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo "Sell Your Ticket List";?></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body g-3 row">
                                                                    <div class="col-5"><strong>Ticket Class</strong></div>
                                                                    <div class="col-2"><strong>Total</strong></div>
                                                                    <div class="col-2"><strong>Avail</strong></div>
                                                                    <div class="col-3"><strong>Action</strong></div>

                                                                    <?php

                                                                        $resd7 = mysqli_query($conn, "SELECT category_master.PriceCategoryName, COALESCE(SUM(ticket_allocation.Quantity), 0) AS Quantity, 
                                                                            category_master.PriceCategoryId FROM ticket_allocation JOIN category_master ON 
                                                                            category_master.PriceCategoryId = ticket_allocation.CategoryId WHERE ticket_allocation.EventId = '$rowd6[EM_Id]' AND 
                                                                            ticket_allocation.AjentId = '$_SESSION[ajm_id]' AND category_master.EventId = '$rowd6[EM_Id]' GROUP BY category_master.PriceCategoryName, category_master.PriceCategoryId ");

                                                                        if (mysqli_num_rows($resd7) > 0) {
                                                                                                                            
                                                                            while($rowd7 = mysqli_fetch_assoc($resd7)) {
                                                                                
                                                                                echo "<div class='col-5 mt-2'>$rowd7[PriceCategoryName]</div>";
                                                                                echo "<div class='col-2 mt-2'>$rowd7[Quantity]</div>";

                                                                                $resSold = mysqli_query($conn, "SELECT BasketId FROM sales_master WHERE EventId = '$rowd6[EM_Id]' AND SalesStatus = 'Placed' 
                                                                                    AND IsSoldByAjent = true AND AjentId = '$_SESSION[ajm_id]'");
                                                                                
                                                                                $quantitySold = 0;
                                                                                
                                                                                if (mysqli_num_rows($resSold)>0) {
                                
                                                                                    while ($rowSold = mysqli_fetch_assoc($resSold)) {
                                                                                        
                                                                                        $resSalesData = mysqli_query($conn, "SELECT Quantity FROM sales_data WHERE Status = 1 AND BusketId = '$rowSold[BasketId]' AND EventId = '$rowd6[EM_Id]' AND CategoryId = '$rowd7[PriceCategoryId]'");
                                
                                                                                        if (mysqli_num_rows($resSalesData)>0){
                                                                                            while ($rowSalesData = mysqli_fetch_assoc($resSalesData)) {
                                
                                                                                                $quantitySold += $rowSalesData['Quantity'];
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }

                                                                                $availTick = $rowd7['Quantity'] - $quantitySold;

                                                                                echo "<div class='col-2 mt-2'>".$availTick."</div>";

                                                                                echo "<div class='col-2 mt-2'>";
                                                                                if ($availTick > 0) {

                                                                                    echo "<a href='sell.php?eid=$rowd6[EM_Id]&cid=$rowd7[PriceCategoryId]&ava=$availTick' class='btn btn-primary btn-sm'><small>Sell</small></a>";
                                                                                }
                                                                                echo "</div>";
                                                                            }
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
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