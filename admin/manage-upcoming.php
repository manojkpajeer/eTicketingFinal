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

    if (isset($_GET['did'])) {
        
        if (mysqli_query($conn, "DELETE FROM upcoming_event WHERE UE_Id = '$_GET[did]'")){

            echo "<script>alert('Yay, Event deleted successfully..');location.href='manage-upcoming.php';</script>";     
        } else {

            echo "<script>alert('Oops, Unable to delete event.');</script>";
        }
    }

    if (isset($_POST['update'])) { 

        if (!empty($_FILES['event_banner']['name'])) {
            
            $imagePath = "upcoming-image/" .time(). "." . pathinfo($_FILES['event_banner']['name'], PATHINFO_EXTENSION);

            if (move_uploaded_file($_FILES['event_banner']['tmp_name'], $imagePath)) {

                if (mysqli_query($conn, "UPDATE upcoming_event SET EventName = '$_POST[event_name]', StartDate = '$_POST[start_date]',
                StartTime = '$_POST[start_time]', EndDate = '$_POST[end_date]', EndTime = '$_POST[end_time]', 
                EventLocation = '$_POST[location]', AgeLimit = '$_POST[age_limit]', Organizer = '$_POST[organizer]', 
                BannerImage  = '$imagePath', ShortDescription = '$_POST[short_desc]', 
                Description = '$_POST[description]', EventStatus = '$_POST[status]' WHERE UE_Id = '$_POST[uEventId]'")) {

                    echo "<script>alert('Yay, Upcoming Event updated successfully..');</script>";     
                } else {

                    echo "<script>alert('Oops, Unable to update event..');</script>";
                }
            
            } else { 

                echo "<script>alert('Oops, Unable to update event..');</script>";
            }
        } else {

            if (mysqli_query($conn, "UPDATE upcoming_event SET EventName = '$_POST[event_name]', StartDate = '$_POST[start_date]',
                StartTime = '$_POST[start_time]', EndDate = '$_POST[end_date]', EndTime = '$_POST[end_time]', EventLocation = '$_POST[location]',
                 AgeLimit = '$_POST[age_limit]', Organizer = '$_POST[organizer]', ShortDescription = '$_POST[short_desc]', 
                Description = '$_POST[description]', EventStatus = '$_POST[status]' WHERE UE_Id = '$_POST[uEventId]'")) {

                echo "<script>alert('Yay, Upcoming Event updated successfully..');</script>";     
            } else {

                echo "<script>alert('Oops, Unable to update event..');</script>";
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
                        <h3 class="card__title position-absolute">Manage Up-Coming Events</h3>
                        <div class="table-responsive">
                            <table id="meastroTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Banner</th>
                                        <th>Event Name</th>
                                        <th>Event On</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $resd6 = mysqli_query($conn, "SELECT * FROM upcoming_event ORDER BY UE_Id DESC");
                                        if (mysqli_num_rows($resd6) > 0) {

                                            $count = 1;
                                            while($rowd6 = mysqli_fetch_assoc($resd6)) {
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>"; 
                                                echo "<td> <img src='".$rowd6['BannerImage']."' class='rounded-circle mr-2' width='40px' alt=''></td>"; 
                                                echo "<td>".$rowd6['EventName']."</td>"; 
                                                echo "<td>".date_format(date_create($rowd6['StartDate']), 'd M, Y') . "</td>"; 
                                                echo "<td>".$rowd6['EventLocation']."</td>"; 
                                                echo "<td>"; 
                                                if ($rowd6['EventStatus']) {
                                                    echo "<span class='badge badge-success'>Active</span>";
                                                } else {
                                                    echo "<span class='badge badge-danger'>In-Active</span>";
                                                }
                                                echo "</td>";
                                                echo "<td>";
                                                ?>
                                                <a href="#" data-toggle="modal" data-target="#product<?php echo $rowd6['UE_Id'];?>"><i class='fa fa-pencil'></i></a> | 
                                                <a href="manage-upcoming.php?did=<?php echo $rowd6['UE_Id'];?>" onClick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash"></i></a>
                                                <?php
                                                echo "</td>";
                                                echo "</tr>"; 

                                                $count++;

                                                ?>
                                                    <div class="modal fade" id="product<?php echo $rowd6['UE_Id'];?>" tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                                                                            <input type="text" class="form-control input-style" id="i1" value="<?php echo $rowd6['EventName'];?>" required name="event_name" title="Please enter a event name">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="i3" class="form-label">Banner Image</label>
                                                                            <input type="file" class="form-control input-style" id="i3" name="event_banner" accept="image/*" title="Please choose banner image">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="i8" class="form-label">Location</label>
                                                                            <input type="text" class="form-control input-style" id="i8" value="<?php echo $rowd6['EventLocation'];?>" required name="location" title="Please enter a location">
                                                                        </div>
                                                                        <div class="col-md-4 mt-3">
                                                                            <label for="i4" class="form-label">Event Start Date</label>
                                                                            <input type="date" class="form-control input-style" id="i4" value="<?php echo $rowd6['StartDate'];?>" required name="start_date" title="Please select event start date">
                                                                        </div>
                                                                        <div class="col-md-4 mt-3">
                                                                            <label for="i5" class="form-label">Event Start Time</label>
                                                                            <input type="time" class="form-control input-style" id="i5" value="<?php echo $rowd6['StartTime'];?>" required name="start_time" title="Please select event start time">
                                                                        </div>
                                                                        <div class="col-md-4 mt-3">
                                                                            <label for="i6" class="form-label">Event End Date</label>
                                                                            <input type="date" class="form-control input-style" id="i6" value="<?php echo $rowd6['EndDate'];?>" required name="end_date" title="Please select event end date">
                                                                        </div>
                                                                        <div class="col-md-4 mt-3">
                                                                            <label for="i7" class="form-label">Event End Time</label>
                                                                            <input type="time" class="form-control input-style" id="i7" value="<?php echo $rowd6['EndTime'];?>" required name="end_time" title="Please select event end time">
                                                                        </div>
                                                                        
                                                                        <div class="col-md-4 mt-3">
                                                                            <label for="i10" class="form-label">Age Limit</label>
                                                                            <input type="text" class="form-control input-style" id="i10" value="<?php echo $rowd6['AgeLimit'];?>" required name="age_limit" title="Please enter age limit">
                                                                        </div>
                                                                        <div class="col-md-4 mt-3">
                                                                            <label for="i11" class="form-label">Organizer Name</label>
                                                                            <input type="text" class="form-control input-style" id="i11" value="<?php echo $rowd6['Organizer'];?>" required name="organizer" title="Please enter organizer name">
                                                                        </div>
                                                                        
                                                                        <div class="col-md-6 mt-3">
                                                                            <label for="i17" class="form-label">Short Description</label>
                                                                            <textarea class="form-control input-style" id="i17" name="short_desc" required title="Please enter short description"><?php echo $rowd6['ShortDescription'];?></textarea>
                                                                        </div>

                                                                        <div class="col-md-6 mt-3">
                                                                            <label for="i18" class="form-label">Description</label>
                                                                            <textarea class="form-control input-style" id="i18" name="description" title="Please enter description" required ><?php echo $rowd6['Description'];?></textarea>
                                                                        </div>

                                                                        <input type="hidden" name="uEventId" value="<?php echo $rowd6['UE_Id'];?>">

                                                                        <div class="col-md-4">
                                                                            <label for="validationCustom02" class="form-label">Status</label>
                                                                            <select class="form-control input-style" id="validationCustom04" required name="status" title="Please choose status">
                                                                                <option value="">Select</option>
                                                                                <option value="1" <?php if($rowd6['EventStatus']){echo 'selected';}?>>Active</option>
                                                                                <option value="0" <?php if(!$rowd6['EventStatus']){echo 'selected';}?>>In-Active</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-success" name="update">Save changes</button>
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