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

    if (isset($_POST['allocate'])) {

        $quantity = $_POST['quantity'];
        $agent = $_POST['agent'];
        $category = $_POST['category'];
        $eventId = $_POST['eid'];

        $resSeats = mysqli_query($conn, "SELECT SeatsNo FROM category_master WHERE PriceCategoryId = '$category' AND EventId = '$eventId'");
        if (mysqli_num_rows($resSeats)>0) {
            $resSeats = mysqli_fetch_assoc($resSeats);
            $TotalSeat = $resSeats['SeatsNo'];
        }

        $resAllocated = mysqli_query($conn, "SELECT COALESCE(SUM(Quantity), 0) AS Quantity FROM ticket_allocation WHERE EventId = '$eventId' AND CategoryId = '$category'");
        if (mysqli_num_rows($resAllocated)>0){
            $resAllocated = mysqli_fetch_assoc($resAllocated);
            $AllocatedSeat = $resAllocated['Quantity'];
        }

        $resSold = mysqli_query($conn, "SELECT COALESCE(SUM(Quantity), 0) AS Quantity FROM sales_data WHERE EventId = '$eventId' AND CategoryId = '$category' AND Status = 1");
        if (mysqli_num_rows($resSold)>0){
            $resSold = mysqli_fetch_assoc($resSold);
            $SoldSeat = $resSold['Quantity'];
        }

        if (((($TotalSeat - $AllocatedSeat) - $SoldSeat) - $quantity) >= 0) {

            $ver1 = mysqli_query($conn, "SELECT Quantity FROM ticket_allocation WHERE AjentId = '$agent' AND EventId = '$eventId' AND CategoryId = '$category'");
            
            if(mysqli_num_rows($ver1)>0){

                $verval1 = mysqli_fetch_assoc($ver1);
                $verQuantity1 = $verval1['Quantity']+$quantity;
                
                if(mysqli_query($conn, "UPDATE ticket_allocation SET Quantity = '$verQuantity1' WHERE AjentId = '$agent' AND EventId = '$eventId' AND CategoryId = '$category'")){
                    
                    echo "<script>alert('Ticket Allocated Successfully..');</script>";
                }
                else{
                    
                    echo "<script>alert('Oops, Unable to process..');</script>";
                }
            }
            else{

                if(mysqli_query($conn, "INSERT INTO ticket_allocation(AjentId, EventId, CategoryId, Quantity)values('$agent', '$eventId', '$category', '$quantity')")){
                    
                    echo "<script>alert('Ticket Allocated Successfully..');</script>";
                }
                else{
                    
                    echo "<script>alert('Oops, Unable to process..');</script>";
                }
            }
        } else {

            echo "<script>alert('Oops, only ".(($TotalSeat - $AllocatedSeat) - $SoldSeat)." seats left..');</script>";
        }
    }
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
                                        <th>Event Name</th>
                                        <th>Event Code</th>
                                        <th>Event On</th>
                                        <th>Booking Line</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $resd6 = mysqli_query($conn, "SELECT * FROM event_master WHERE NOT EventStatus = 'New' ORDER BY EM_Id DESC");
                                        if (mysqli_num_rows($resd6) > 0) {

                                            $count = 1;
                                            while($rowd6 = mysqli_fetch_assoc($resd6)) {
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>"; 
                                                echo "<td>".$rowd6['EventName']."</td>"; 
                                                echo "<td>".$rowd6['EventCode']."</td>"; 
                                                echo "<td>".date_format(date_create($rowd6['StartDate']), 'd M, Y') . "</td>"; 
                                                if ($rowd6['BookingStatus']) {
                                                    echo "<td><span class='badge badge-success'>Open</span></td>";
                                                } else {
                                                    echo "<td><span class='badge badge-danger'>Closed</span></td>";
                                                }

                                                echo "<td> <span class='badge ";
                                                if ($rowd6['EventStatus'] == 'Publish') {
                                                    echo "badge-success";
                                                } else {
                                                    echo "badge-danger";
                                                }
                                                echo "'>".$rowd6['EventStatus']."</span></td>"; 
                                                echo "<td>"; 
                                                if ($rowd6['EventStatus'] == 'Publish' && $rowd6['BookingStatus'] == true) {
                                                
                                                ?>
                                                <a href="#" data-toggle="modal" data-target="#allocate<?php echo $rowd6['EM_Id'];?>"><i class='fa fa-clone'></i></a> | 
                                                <a href="tranfer-ticket.php?eid=<?php echo $rowd6['EM_Id'];?>"><i class='fa fa-exchange'></i></a>
                                                <?php
                                                }
                                                echo "</td>";
                                                echo "</tr>"; 

                                                $count++;

                                                ?>
                                                    <div class="modal fade" id="allocate<?php echo $rowd6['EM_Id'];?>" tabindex="-1" role="dialog"
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
                                                                        <div class="col-6"><small><strong>Category</strong></small></div>
                                                                        <div class="col-3"><small><strong>Total Seat</strong></small></div>
                                                                        <div class="col-3"><small><strong>Available</strong></small></div>
                                                                        <?php
                                                                            $res11 = mysqli_query($conn, "SELECT PriceCategoryId, SeatsNo, PriceCategoryName FROM category_master WHERE EventId = '$rowd6[EM_Id]'");
                                                                            while($row11 = mysqli_fetch_assoc($res11)){
                                                                                
                                                                                $sFinal = $row11['SeatsNo'];
                                                                                echo "<div class='col-6'><small>$row11[PriceCategoryName]</small></div>";
                                                                                echo "<div class='col-3'><small>$sFinal</small></div>";

                                                                                $resAllocated = mysqli_query($conn, "SELECT COALESCE(SUM(Quantity), 0) AS Quantity FROM ticket_allocation WHERE EventId = '$rowd6[EM_Id]' AND CategoryId = '$row11[PriceCategoryId]'");
                                                                                if (mysqli_num_rows($resAllocated)>0){
                                                                                    $resAllocated = mysqli_fetch_assoc($resAllocated);
                                                                                    $aFinal = $sFinal - $resAllocated['Quantity'];
                                                                                }

                                                                                $resSold = mysqli_query($conn, "SELECT COALESCE(SUM(Quantity), 0) AS Quantity FROM sales_data WHERE EventId = '$rowd6[EM_Id]' AND CategoryId = '$row11[PriceCategoryId]' AND Status = 1");
                                                                                if (mysqli_num_rows($resSold)>0){
                                                                                    $resSold = mysqli_fetch_assoc($resSold);
                                                                                    $bFinal = $aFinal - $resSold['Quantity'];
                                                                                }


                                                                                echo "<div class='col-3'><small>$bFinal</small></div>";
                                                                            }
                                                                        ?>
                                                                        <div class="col-md-4 mt-3">
                                                                            <label class="form-label">Select Agent</label>
                                                                            <select class="form-control input-style" required name="agent" title="Please choose agent">
                                                                                
                                                                                <?php
                                                                                    $rs = mysqli_query($conn, "SELECT AJM_Id, FullName FROM ajent_master WHERE AjentStatus = 1");
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
                                                                        <div class="col-md-5 mt-3">
                                                                            <label class="form-label">Ticket Category</label>
                                                                            <select class="form-control input-style" required name="category" title="Please choose category">
                                                                                    <?php
                                                                                        $rs1 = mysqli_query($conn, "SELECT PriceCategoryId, PriceCategoryName FROM category_master WHERE EventId = '$rowd6[EM_Id]'");
                                                                                        if(mysqli_num_rows($rs1)>0){

                                                                                            echo "<option value=''>Select Category</option>";
                                                                                            while($rw1 = mysqli_fetch_assoc($rs1)){
                                                                                                echo "<option value='$rw1[PriceCategoryId]'>$rw1[PriceCategoryName]</option>";
                                                                                            }
                                                                                        }
                                                                                        else{
                                                                                            echo "<option value=''>No category found</option>";
                                                                                        }
                                                                                    ?>
                                                                            </select>
                                                                            <div class="invalid-feedback">
                                                                            Please choose category
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 mt-3">
                                                                            <label class="form-label">Tickets</label>
                                                                            <input type="number" class="form-control input-style" required name="quantity" min="1" title="Enter number of tickets">
                                                                            <div class="invalid-feedback">
                                                                                Enter number of tickets
                                                                            </div>
                                                                        </div>

                                                                        <input type="hidden" name="eid" value="<?php echo $rowd6['EM_Id'];?>">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger btn-style" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-success btn-style" name="allocate">Allocate</button>
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