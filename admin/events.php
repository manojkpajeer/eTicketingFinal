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

    if(isset($_POST['update'])){

        $event_id = $_POST['event_id'];
        $path_banner = $_POST['banner_image'];
        $image1 = $_POST['image1'];
        $image2 = $_POST['image2'];
        $image3 = $_POST['image3'];
    
        if (!empty($_FILES['event_banner']['name'])) {

            $path = "event-image/" .time() . rand(1000, 9999) . "." . pathinfo($_FILES['event_banner']['name'], PATHINFO_EXTENSION);
            if (move_uploaded_file($_FILES['event_banner']['tmp_name'], $path)) {
            
                $path_banner = $path;
            }
        }

        if (!empty($_FILES['image1']['name'])) {

            $path1 = "event-image/" .time() . rand(1000, 9999) . "." . pathinfo($_FILES['image1']['name'], PATHINFO_EXTENSION);
            if (move_uploaded_file($_FILES['image1']['tmp_name'], $path1)) {
            
                $image1 = $path1;
            }
        }

        if (!empty($_FILES['image2']['name'])) {

            $path2 = "event-image/" .time() . rand(1000, 9999) . "." . pathinfo($_FILES['image2']['name'], PATHINFO_EXTENSION);
            if (move_uploaded_file($_FILES['image2']['tmp_name'], $path2)) {
            
                $image2 = $path2;
            }
        }

        if (!empty($_FILES['image3']['name'])) {

            $path3 = "event-image/" .time() . rand(1000, 9999) . "." . pathinfo($_FILES['image3']['name'], PATHINFO_EXTENSION);
            if (move_uploaded_file($_FILES['image3']['tmp_name'], $path3)) {
            
                $image3 = $path3;
            }
        }

        $eventOn = $_POST['start_date']." ".$_POST['start_time'];
        
        if (mysqli_query($conn, "UPDATE event_master SET EventName = '$_POST[event_name]', StartDate = '$_POST[start_date]',
        StartTime = '$_POST[start_time]', EndDate = '$_POST[end_date]', EndTime = '$_POST[end_time]', 
        EventLocation = '$_POST[location]', AgeLimit = '$_POST[age_limit]', Organizer = '$_POST[organizer]', 
        PrintedBy = '$_POST[printed_by]', EventStatus = '$_POST[status]', EventBanner = '$path_banner', 
        ShortDescription = '$_POST[short_desc]', Description = '$_POST[description]', Image1 = '$image1',
        Image2 = '$image2', Image3 = '$image3', EventOn = '$eventOn', BookingStatus = '$_POST[bookingstatus]', 
        SliderStatus = '$_POST[sliderstatus]', LocationMap = '$_POST[map]' WHERE EM_Id = '$event_id'")) {

            echo "<script>alert('Yay, Event updated successfully..');location.href='events.php';</script>";
        } else {

            echo "<script>alert('Oops, Unable to update..');</script>";
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
                                        <th>Banner</th>
                                        <th>Event Name</th>
                                        <th>Event Code</th>
                                        <th>Event On</th>
                                        <th>Seats</th>
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
                                                echo "<td> <img src='".$rowd6['EventBanner']."' class='rounded-circle mr-2' width='40px' alt=''></td>"; 
                                                echo "<td>".$rowd6['EventName']."</td>"; 
                                                echo "<td>".$rowd6['EventCode']."</td>"; 
                                                echo "<td>".date_format(date_create($rowd6['StartDate']), 'd M, Y') . "</td>"; 
                                                echo "<td>".$rowd6['TotalSeats']."</td>"; 
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
                                                if ($rowd6['EventStatus'] == 'Publish') {
                                                    ?>
                                                    <a href="#" data-toggle="modal" data-target="#view<?php echo $rowd6['EM_Id'];?>"><i class='fa fa-eye'></i></a> | 
                                                    <a href="#" data-toggle="modal" data-target="#edit<?php echo $rowd6['EM_Id'];?>"><i class='fa fa-pencil'></i></a>
                                                    <?php
                                                } else if ($rowd6['EventStatus'] == 'Delete') {
                                                    ?>
                                                    <a href="#" data-toggle="modal" data-target="#view<?php echo $rowd6['EM_Id'];?>"><i class='fa fa-eye'></i></a>
                                                    <?php
                                                }
                                                echo "</td>";
                                                echo "</tr>"; 

                                                $count++;
                                                ?>
                                                    <div class="modal fade" id="view<?php echo $rowd6['EM_Id'];?>" tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo "Event Details";?></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="card borderd p-3 m-3">  
                                                                        <div class="row">
                                                                            <div class="col-4"><p>Event Name: <strong> <?php echo $rowd6['EventName'];?></strong></p><p class="mt-3">Location: <strong> <?php echo $rowd6['EventLocation'];?></strong></p></div>
                                                                            <div class="col-4"><p>Start Date & Time: <strong> <?php echo date('M d, Y', strtotime($rowd6['StartDate']));?>, <?php echo date('H:i', strtotime($rowd6['StartTime']));?></strong></p><p class="mt-3">End Date & Time: <strong> <?php echo date('M d, Y', strtotime($rowd6['EndDate']));?>, <?php echo date('H:i', strtotime($rowd6['EndTime']));?></strong></p></div>
                                                                            <div class="col-4"><p># of Tickets: <strong> <?php echo $rowd6['TotalSeats'];?></strong></p><p class="mt-3">Organiser: <strong> <?php echo $rowd6['Organizer'];?></strong></p></div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row px-5 py-3">
                                                                        <div class="col-1"><strong>#</strong></div>
                                                                        <div class="col-6 text-left"><strong>Ticket Class</strong></div>
                                                                        <div class="col-5 text-left"><strong>Total Tickets</strong></div>
                                                                        <?php
                                                                            $res1 = mysqli_query($conn, "select SeatsNo, PriceCategoryName from category_master where EventId = '$rowd6[EM_Id]'");
                                                                            if(mysqli_num_rows($res1)>0){
                                                                                $count = 1;
                                                                                while($row1 = mysqli_fetch_assoc($res1)){
                                                                                    
                                                                                    echo "<div class='col-1 mt-2'>$count</div>";
                                                                                    echo "<div class='col-6 text-left mt-2'>$row1[PriceCategoryName]</div>";
                                                                                    echo "<div class='col-5 text-left mt-2'>$row1[SeatsNo]</div>";

                                                                                    $count++;
                                                                                }
                                                                            }
                                                                            else{
                                                                                echo "<div class='col-12 mt-3'>No record found..!</div>";
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="edit<?php echo $rowd6['EM_Id'];?>" tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <form method="POST" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo "Manage Event - ".$rowd6['EventName'];?></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body g-3 row">
                                                                        <div class="col-md-4">
                                                                            <label for="i1" class="form-label">Event Name</label>
                                                                            <input type="text" title="Please enter a event name" class="form-control input-style" id="i1" required name="event_name" value="<?php echo $rowd6['EventName'];?>">
                                                                            <div class="invalid-feedback">
                                                                            Please enter a event name
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="i2" class="form-label">Event Code <small class="text-danger"> (Read Only)</small></label>
                                                                            <input type="text" title="Please enter a event code" class="form-control input-style" id="i2" readonly name="event_code" value="<?php echo $rowd6['EventCode'];?>">
                                                                            <div class="invalid-feedback">
                                                                            Please enter a event code
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="i3" class="form-label">Banner Image</label>
                                                                            <input type="file" class="form-control input-style" id="i3" name="event_banner" accept="image/*">
                                                                            <div class="invalid-feedback">
                                                                            Please choose banner image
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <input type="hidden" name="event_id" value="<?php echo $rowd6['EM_Id'];?>">
                                                                        <input type="hidden" name="banner_image" value="<?php echo $rowd6['EventBanner'];?>">
                                                                        <input type="hidden" name="image1" value="<?php echo $rowd6['Image1'];?>">
                                                                        <input type="hidden" name="image2" value="<?php echo $rowd6['Image2'];?>">
                                                                        <input type="hidden" name="image3" value="<?php echo $rowd6['Image3'];?>">

                                                                        <div class="col-md-3 mt-4">
                                                                            <label for="i4" class="form-label">Event Start Date</label>
                                                                            <input type="date" title="Please select event start date" class="form-control input-style" id="i4" required name="start_date" value="<?php echo $rowd6['StartDate'];?>">
                                                                            <div class="invalid-feedback">
                                                                            Please select event start date
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 mt-4">
                                                                            <label for="i5" class="form-label">Event Start Time</label>
                                                                            <input type="time" title="Please select event start time" class="form-control input-style" id="i5" required name="start_time" value="<?php echo $rowd6['StartTime'];?>">
                                                                            <div class="invalid-feedback">
                                                                            Please select event start time
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 mt-4">
                                                                            <label for="i6" class="form-label">Event End Date</label>
                                                                            <input type="date" title="Please select event end date" class="form-control input-style" id="i6" required name="end_date" value="<?php echo $rowd6['EndDate'];?>">
                                                                            <div class="invalid-feedback">
                                                                            Please select event end date
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 mt-4">
                                                                            <label for="i7" class="form-label">Event End Time</label>
                                                                            <input type="time" title="Please select event end time" class="form-control input-style" id="i7" required name="end_time" value="<?php echo $rowd6['EndTime'];?>">
                                                                            <div class="invalid-feedback">
                                                                            Please select event end time
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 mt-4">
                                                                            <label for="i8" class="form-label">Location</label>
                                                                            <input type="text" title="Please enter a location" class="form-control input-style" id="i8" required name="location" value="<?php echo $rowd6['EventLocation'];?>">
                                                                            <div class="invalid-feedback">
                                                                            Please enter a location
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 mt-4">
                                                                            <label for="i8a" class="form-label">Location Map</label>
                                                                            <input type="text" title="Please enter a location map" class="form-control input-style" id="i8a" required name="map" value="<?php echo $rowd6['LocationMap'];?>">
                                                                            <div class="invalid-feedback">
                                                                            Please enter a location map
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 mt-4">
                                                                            <label for="i9" class="form-label">Seats <small class="text-danger"> (Read Only)</small></label>
                                                                            <input type="number" class="form-control input-style" id="i9" readonly name="seats" value="<?php echo $rowd6['TotalSeats'];?>">
                                                                            <div class="invalid-feedback">
                                                                            Please enter number of seats
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 mt-4">
                                                                            <label for="i10" class="form-label">Age Limit</label>
                                                                            <input type="text" title="Please enter age limit" class="form-control input-style" id="i10" required name="age_limit" value="<?php echo $rowd6['AgeLimit'];?>">
                                                                            <div class="invalid-feedback">
                                                                            Please enter age limit
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 mt-4">
                                                                            <label for="i11" class="form-label">Organizer Name</label>
                                                                            <input type="text" title="Please enter organizer name" class="form-control input-style" id="i11" required name="organizer" value="<?php echo $rowd6['Organizer'];?>">
                                                                            <div class="invalid-feedback">
                                                                            Please enter organizer name
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 mt-4">
                                                                            <label for="i12" class="form-label">Printed By</label>
                                                                            <input type="text" title="Please enter printed by" class="form-control input-style" id="i12" required name="printed_by" value="<?php echo $rowd6['PrintedBy'];?>">
                                                                            <div class="invalid-feedback">
                                                                            Please enter printed by
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 mt-4">
                                                                            <label for="i14" class="form-label">Image1</label>
                                                                            <input type="file" class="form-control input-style" id="i14" name="image1" accept="image/*">
                                                                            <div class="invalid-feedback">
                                                                            Please choose image
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 mt-4">
                                                                            <label for="i15" class="form-label">Image2</label>
                                                                            <input type="file" class="form-control input-style" id="i15" name="image2" accept="image/*">
                                                                            <div class="invalid-feedback">
                                                                            Please choose image
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 mt-4">
                                                                            <label for="i16" class="form-label">Image3</label>
                                                                            <input type="file" class="form-control input-style" id="i16"  name="image3" accept="image/*">
                                                                            <div class="invalid-feedback">
                                                                            Please choose image
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 mt-4">
                                                                            <label for="i17" class="form-label">Short Description</label>
                                                                            <textarea class="form-control input-style" id="i17" name="short_desc" ><?php echo $rowd6['ShortDescription'];?></textarea>
                                                                            <div class="invalid-feedback">
                                                                            Please enter short description
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-5 mt-4">
                                                                            <label for="i18" class="form-label">Description</label>
                                                                            <textarea title="Please enter description" class="form-control input-style" id="i18" name="description" required><?php echo $rowd6['Description'];?></textarea>
                                                                            <div class="invalid-feedback">
                                                                            Please enter description
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3 mt-4">
                                                                            <label for="validationCustom02" class="form-label">Event Status</label>
                                                                            <select class="form-control input-style" id="validationCustom04" required name="status" title="Please choose event status">
                                                                                <option value="">Select</option>
                                                                                <option value="Publish" <?php if($rowd6['EventStatus']=='Publish'){echo 'selected';}?>>Publish</option>
                                                                                <option value="Delete" <?php if($rowd6['EventStatus']=='Delete'){echo 'selected';}?>>Delete</option>
                                                                            </select>
                                                                            <div class="invalid-feedback">
                                                                            Please choose status
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3 mt-4">
                                                                            <label for="validationCustom02" class="form-label">Booking Status</label>
                                                                            <select class="form-control input-style" id="validationCustom04" required name="bookingstatus" title="Please choose booking status">
                                                                                <option value="">Select</option>
                                                                                <option value="1" <?php if($rowd6['BookingStatus']){echo 'selected';}?>>Open</option>
                                                                                <option value="0" <?php if(!$rowd6['BookingStatus']){echo 'selected';}?>>Closed</option>
                                                                            </select>
                                                                            <div class="invalid-feedback">
                                                                            Please choose status
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3 mt-4">
                                                                            <label for="validationCustom02" class="form-label">Slider Status</label>
                                                                            <select class="form-control input-style" id="validationCustom04" required name="sliderstatus" title="Please choose slider status">
                                                                                <option value="">Select</option>
                                                                                <option value="1" <?php if($rowd6['SliderStatus']){echo 'selected';}?>>Yes</option>
                                                                                <option value="0" <?php if(!$rowd6['SliderStatus']){echo 'selected';}?>>No</option>
                                                                            </select>
                                                                            <div class="invalid-feedback">
                                                                            Please choose status
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-success" name="update">Update</button>
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