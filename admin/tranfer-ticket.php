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
    require_once './pages/link.php';
    require_once './pages/sidebar.php';
    require_once './pages/header.php';

    if (isset($_POST['transfer'])) {

        $quantity = $_POST['quantity'];
        $available = $_POST['available'];

        if ($quantity > $available) {
             
            echo "<script>alert('Oops, only ".$available." tickets available..');</script>";
        } else {

            $allocationId = $_POST['allo_id'];
            $total = $_POST['total'] - $quantity;

            if (mysqli_query($conn, "UPDATE ticket_allocation SET Quantity = '$total' WHERE TA_Id = '$allocationId'")) {

                $resTransfer = mysqli_query($conn, "SELECT TA_Id, Quantity FROM ticket_allocation WHERE AjentId = '$_POST[agent]' AND EventId = '$_GET[eid]' AND CategoryId = '$_POST[cat_id]'");
                
                if(mysqli_num_rows($resTransfer)>0){

                    $resTransfer = mysqli_fetch_assoc($resTransfer);
                    $updateTicket = $resTransfer['Quantity'] + $quantity;

                    if (mysqli_query($conn, "UPDATE ticket_allocation SET Quantity = '$updateTicket' WHERE AjentId = '$_POST[agent]' AND EventId = '$_GET[eid]' AND CategoryId = '$_POST[cat_id]'")) {

                        echo "<script>alert('Yay, Ticket Transfered Successfully..');</script>";
                    } else {

                        echo "<script>alert('Oops, Unable to process..');</script>";
                    }

                } else {

                    if (mysqli_query($conn, "INSERT INTO ticket_allocation (AjentId, EventId, CategoryId, Quantity) VALUES ('$_POST[agent]', '$_GET[eid]', '$_POST[cat_id]', '$quantity')")) {

                        echo "<script>alert('Yay, Ticket Transfered Successfully..');</script>";
                    } else {

                        echo "<script>alert('Oops, Unable to process..');</script>";
                    }
                }

            } else {

                echo "<script>alert('Oops, Unable to process..');</script>";
                // echo mysqli_error($conn);
            }
        }

        
    }
?>

<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="data-tables">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card card_border p-4 border-primary-top">
                        <h3 class="card__title position-absolute">Ticket Allocation</h3>
                        <div class="table-responsive">
                            <table id="meastroTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ajent Name</th>
                                        <th>Ticket Class</th>
                                        <th>Total Ticket</th>
                                        <th>Unsold Ticket</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $resd6 = mysqli_query($conn, "SELECT ticket_allocation.TA_Id, ajent_master.FullName, ajent_master.AJM_Id, category_master.PriceCategoryName, ticket_allocation.Quantity, category_master.PriceCategoryId FROM ticket_allocation JOIN category_master ON category_master.PriceCategoryId = ticket_allocation.CategoryId JOIN ajent_master ON ajent_master.AJM_Id = ticket_allocation.AjentId WHERE ticket_allocation.EventId = '$_GET[eid]' AND category_master.EventId = '$_GET[eid]'");
                                        if (mysqli_num_rows($resd6) > 0) {

                                            $count = 1;
                                            while($rowd6 = mysqli_fetch_assoc($resd6)) {
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>"; 
                                                echo "<td>".$rowd6['FullName']."</td>"; 
                                                echo "<td>".$rowd6['PriceCategoryName']."</td>"; 
                                                echo "<td>".$rowd6['Quantity']."</td>"; 

                                                $resSold = mysqli_query($conn, "SELECT BasketId FROM sales_master WHERE EventId = '$_GET[eid]' AND SalesStatus = 'Placed' AND IsSoldByAjent = true AND AjentId = '$rowd6[AJM_Id]'");
                                                
                                                $quantitySold = 0;
                                                if (mysqli_num_rows($resSold)>0) {

                                                    while ($rowSold = mysqli_fetch_assoc($resSold)) {
                                                        
                                                        $resSalesData = mysqli_query($conn, "SELECT Quantity FROM sales_data WHERE Status = 1 AND BusketId = '$rowSold[BasketId]' AND EventId = '$_GET[eid]' AND CategoryId = '$rowd6[PriceCategoryId]'");

                                                        if (mysqli_num_rows($resSalesData)>0){
                                                            while ($rowSalesData = mysqli_fetch_assoc($resSalesData)) {

                                                                $quantitySold += $rowSalesData['Quantity'];
                                                            }
                                                        }
                                                    }
                                                }
                                                   
                                                echo "<td>".($rowd6['Quantity'] - $quantitySold)."</td>"; 
                                                
                                                echo "<td>";
                                                ?>
                                                <a href="#" data-toggle="modal" data-target="#allocate<?php echo $rowd6['TA_Id'];?>"><i class='fa fa-exchange'></i></a>
                                                <?php
                                                echo "</td>";
                                                echo "</tr>"; 

                                                $count++;

                                                ?>
                                                    <div class="modal fade" id="allocate<?php echo $rowd6['TA_Id'];?>" tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <form method="POST" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo "Ticket Allocation";?></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body g-3 row">
                                                                        <div class="col-6"><small><strong>Ticket Class</strong></small></div>
                                                                        <div class="col-3"><small><strong>Total Ticket</strong></small></div>
                                                                        <div class="col-3"><small><strong>Unsold</strong></small></div>

                                                                        <div class="col-6"><small><?php echo $rowd6['PriceCategoryName'];?></small></div>
                                                                        <div class="col-3"><small><?php echo $rowd6['Quantity'];?></small></div>
                                                                        <div class="col-3"><small><?php echo ($rowd6['Quantity'] - $quantitySold);?></small></div>

                                                                        <div class="col-md-8 mt-4">
                                                                            <label class="form-label">Select Agent</label>
                                                                            <select class="form-control input-style" required name="agent" title="Please choose agent">
                                                                                <?php
                                                                                    $rs = mysqli_query($conn, "SELECT AJM_Id, FullName FROM ajent_master WHERE AjentStatus = 1 AND NOT AJM_Id = '$rowd6[AJM_Id]' ");
                                                                                    if(mysqli_num_rows($rs)>0){

                                                                                        echo "<option value=''>Select Agent</option>";

                                                                                        while($rw = mysqli_fetch_assoc($rs)){
                                                                                            echo "<option value='$rw[AJM_Id]'>$rw[FullName]</option>";
                                                                                        }
                                                                                    }
                                                                                    else{
                                                                                        echo "<option value=''>No Agent found</option>";
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                            <div class="invalid-feedback">
                                                                            Please choose agent
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4 mt-4">
                                                                            <label class="form-label">No. of Tickets</label>
                                                                            <input type="number" class="form-control input-style" required name="quantity" min="1" title="Enter number of tickets">
                                                                            <div class="invalid-feedback">
                                                                                Enter number of tickets
                                                                            </div>
                                                                        </div>

                                                                        <input type="hidden" name="allo_id" value="<?php echo $rowd6['TA_Id'];?>">
                                                                        <input type="hidden" name="cat_id" value="<?php echo $rowd6['PriceCategoryId'];?>">
                                                                        <input type="hidden" name="available" value="<?php echo ($rowd6['Quantity'] - $quantitySold);?>">
                                                                        <input type="hidden" name="total" value="<?php echo $rowd6['Quantity'];?>">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger btn-style" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-success btn-style" name="transfer">Transfer</button>
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