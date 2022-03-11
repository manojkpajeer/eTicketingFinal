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

    $resReport = mysqli_query($conn, "SELECT * FROM event_master WHERE EM_Id = '$_GET[id]'");
    if(mysqli_num_rows($resReport) > 0 ){

        $resReport = mysqli_fetch_assoc($resReport);
    } else {
        
        echo "<script>alert('Oops, unable to process...');location.href='events.php';</script>";
    }
?>

<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="row">
            <div class="col-xl-12 pr-xl-12">
                <div class="card card_border border-primary-top">
                <div class="card-header chart-grid__header float-left">Event Details <a class="btn btn-outline-primary float-right btn-sm" href="events.php">Back</a></div>
                    <div class="card-body">
                        <div class="card borderd p-3 m-3">
                            <div class="row">
                                <div class="col-4"><p>Event Name: <strong> <?php echo $resReport['EventName'];?></strong></p><p class="mt-3">Location: <strong> <?php echo $resReport['EventLocation'];?></strong></p></div>
                                <div class="col-4"><p>Start Date & Time: <strong> <?php echo date('M d, Y', strtotime($resReport['StartDate']));?>, <?php echo date('H:i', strtotime($resReport['StartTime']));?></strong></p><p class="mt-3">End Date & Time: <strong> <?php echo date('M d, Y', strtotime($resReport['EndDate']));?>, <?php echo date('H:i', strtotime($resReport['EndTime']));?></strong></p></div>
                                <div class="col-4"><p># of Tickets: <strong> <?php echo $resReport['TotalSeats'];?></strong></p><p class="mt-3">Organiser: <strong> <?php echo $resReport['Organizer'];?></strong></p></div>
                            </div>
                        </div>
                        
                        <div class="table-responsive p-3">
                            <table id="meastroTable" class="display" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                <th>Ticket Class</th>
                                <th>Total Tickets</th>
                            </tr>
                        </thead>
                        <tbody id="searchTable">
                            <?php
                                $res1 = mysqli_query($conn, "select SeatsNo, PriceCategoryName from category_master where EventId = '$resReport[EM_Id]'");
                                if(mysqli_num_rows($res1)>0){
                                    while($row1 = mysqli_fetch_assoc($res1)){
                                        echo "<tr><td>$row1[PriceCategoryName]</td><td>$row1[SeatsNo]</td></tr>";
                                    }
                                }
                                else{
                                    echo "<tr><td colspan='4'>No record found..!</td>";
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