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

    if (isset($_GET['did'])) {
        
        if (mysqli_query($conn, "DELETE FROM event_request WHERE ER_Id = '$_GET[did]'")){

            echo "<script>alert('Yay, Event deleted successfully..');</script>";     
        } else {

            echo "<script>alert('Oops, Unable to delete event.');</script>";
        }
    }

?>

<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="data-tables">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card card_border p-4 border-primary-top">
                        <h3 class="card__title position-absolute">Manage Events Request</h3>
                        <div class="table-responsive">
                            <table id="meastroTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Organizer Name</th>
                                        <th>Phone Number</th>
                                        <th>Event Name</th>
                                        <th>Event Date</th>
                                        <th>Event Venue</th>
                                        <th>Created On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $resd6 = mysqli_query($conn, "SELECT * FROM event_request ORDER BY ER_Id DESC");
                                        if (mysqli_num_rows($resd6) > 0) {

                                            $count = 1;
                                            while($rowd6 = mysqli_fetch_assoc($resd6)) {
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>"; 
                                                echo "<td>".$rowd6['OrganizerName']."</td>"; 
                                                echo "<td>".$rowd6['Phone']."</td>"; 
                                                echo "<td>".$rowd6['EventName']."</td>"; 
                                                echo "<td>".$rowd6['EventDate']."</td>"; 
                                                echo "<td>".$rowd6['EventVenue']."</td>"; 
                                                echo "<td>".date_format(date_create($rowd6['DateCreate']), 'd M, Y') . "</td>"; 
                                                echo "<td>";
                                                ?>
                                                <a href="#" data-toggle="modal" data-target="#product<?php echo $rowd6['ER_Id'];?>"><i class='fa fa-eye'></i></a> | 
                                                <a href="manage-event-form.php?did=<?php echo $rowd6['ER_Id'];?>" onClick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash"></i></a>
                                                <?php
                                                echo "</td>";
                                                echo "</tr>"; 

                                                $count++;

                                                ?>
                                                    <div class="modal fade" id="product<?php echo $rowd6['ER_Id'];?>" tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <form method="POST" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo "Event Request - ".$rowd6['EventName'];?></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body g-3 row">
                                                                        <div class="col-6 mb-3"><strong>Organizer Name: </strong><?php echo $rowd6['OrganizerName']; ?></div>
                                                                        <div class="col-6 mb-3"><strong>Phone: </strong><?php echo $rowd6['Phone']; ?></div>
                                                                        <div class="col-6 mb-3"><strong>Email: </strong><?php echo $rowd6['Email']; ?></div>
                                                                        <div class="col-6 mb-3"><strong>Event Name: </strong><?php echo $rowd6['EventName']; ?></div>
                                                                        <div class="col-6 mb-3"><strong>Event Date: </strong><?php echo date_format(date_create($rowd6['EventDate']), "d M, Y"); ?></div>
                                                                        <div class="col-6 mb-3"><strong>Start Time: </strong><?php echo date_format(date_create($rowd6['StartTime']), "h i s A"); ?></div>
                                                                        <div class="col-6 mb-3"><strong>End Time: </strong><?php echo date_format(date_create($rowd6['EndTime']), "h i s A"); ?></div>
                                                                        <div class="col-6 mb-3"><strong>Event Venue: </strong><?php echo $rowd6['EventVenue']; ?></div>
                                                                        <div class="col-12 mb-3"><strong>Event Profile: </strong><?php echo $rowd6['EventProfile']; ?></div>
                                                                        <div class="col-6 mb-3"><strong>Number of attendees: </strong><?php echo $rowd6['Attendees']; ?></div>
                                                                        <div class="col-6 mb-3"><strong>Ticketed / Registration / Invitation / Badges: </strong><?php echo $rowd6['Badges']; ?></div>
                                                                        <div class="col-6 mb-3"><strong>Total Amount of Sold Tickets: </strong><?php echo number_format($rowd6['Amount'], 2) . " AED"; ?></div>
                                                                        <div class="col-6 mb-3"><strong>Does the event contain celebrity or VIP?: </strong><?php echo $rowd6['Celebrity']; ?></div>
                                                                        <div class="col-6 mb-3"><strong>Does your event contain fund raising?: </strong><?php echo $rowd6['Fund']; ?></div>
                                                                        <div class="col-6 mb-3"><strong>Event Type: </strong><?php echo $rowd6['EventType']; ?></div>

                                                                        <?php
                                                                            $rescat = mysqli_query($conn, "SELECT * FROM price_category WHERE UniqueId = '$rowd6[UniqueId]'");
                                                                            if (mysqli_num_rows($rescat)>0){
                                                                                ?>
                                                                                <div class="col-12">
                                                                                    <div class="row p-3 m-3">
                                                                                        <div class="col-1 mb-2"><strong>#</strong></div>
                                                                                        <div class="col-5 mb-2"><strong>Category Name</strong></div>
                                                                                        <div class="col-3 mb-2"><strong>Capacity</strong></div>
                                                                                        <div class="col-3 text-right mb-2"><strong>Price</strong></div>

                                                                                        <?php
                                                                                        $counts=1;
                                                                                        while($rowcat = mysqli_fetch_assoc($rescat)){
                                                                                            echo "<div class='col-1'>$counts</div>
                                                                                            <div class='col-5'>$rowcat[CategoryName]</div>
                                                                                            <div class='col-3'>$rowcat[Capacity]</div>
                                                                                            <div class='col-3 text-right'>".number_format($rowcat['Price'], 2)."</div>";
                                                                                            $counts ++;
                                                                                        }
                                                                                        ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
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