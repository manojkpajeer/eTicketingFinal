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

    $resEresult = mysqli_query($conn, "SELECT * from event_master where EM_Id = '$_GET[id]'");
    if(mysqli_num_rows($resEresult)>0){
        $resEresult = mysqli_fetch_assoc($resEresult);
    }
    else{
        echo "<script>alert('Oops, Unable to process your request..');location.href='events.php';</script>";
    }

    if(isset($_POST['add'])){

        $path_banner = $resEresult['EventBanner'];
        $image1 = $resEresult['Image1'];
        $image2 = $resEresult['Image2'];
        $image3 = $resEresult['Image3'];
    
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
         Image2 = '$image2', Image3 = '$image3', EventOn = '$eventOn' WHERE EM_Id = '$_GET[id]'")) {

            echo "<script>alert('Yay, Event updated successfully..');location.href='edit-event.php?id=".$_GET['id']."'</script>";
        } else {

            echo "<script>alert('Oops, Unable to update..');</script>";
            // echo mysqli_error($conn);
        }

    }
    
?>

<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="row">
            <div class="col-xl-12 pr-xl-12">
                <div class="card card_border border-primary-top">
                <div class="card-header chart-grid__header float-left">Edit Event <a class="btn btn-outline-primary float-right btn-sm" href="events.php">Back</a></div>
                    <div class="card-body">
                    <form method="post" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                        <div class="col-md-4">
                            <label for="i1" class="form-label">Event Name</label>
                            <input type="text" class="form-control" id="i1" required name="event_name" value="<?php echo $resEresult['EventName'];?>">
                            <div class="invalid-feedback">
                            Please enter a event name
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="i2" class="form-label">Event Code</label>
                            <input type="text" class="form-control" id="i2" readonly name="event_code" value="<?php echo $resEresult['EventCode'];?>">
                            <div class="invalid-feedback">
                            Please enter a event code
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="i3" class="form-label">Banner Image</label>
                            <input type="file" class="form-control" id="i3" name="event_banner" accept="image/*">
                            <div class="invalid-feedback">
                            Please choose banner image
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <label for="i4" class="form-label">Event Start Date</label>
                            <input type="date" class="form-control" id="i4" required name="start_date" value="<?php echo $resEresult['StartDate'];?>">
                            <div class="invalid-feedback">
                            Please select event start date
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <label for="i5" class="form-label">Event Start Time</label>
                            <input type="time" class="form-control" id="i5" required name="start_time" value="<?php echo $resEresult['StartTime'];?>">
                            <div class="invalid-feedback">
                            Please select event start time
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <label for="i6" class="form-label">Event End Date</label>
                            <input type="date" class="form-control" id="i6" required name="end_date" value="<?php echo $resEresult['EndDate'];?>">
                            <div class="invalid-feedback">
                            Please select event end date
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <label for="i7" class="form-label">Event End Time</label>
                            <input type="time" class="form-control" id="i7" required name="end_time" value="<?php echo $resEresult['EndTime'];?>">
                            <div class="invalid-feedback">
                            Please select event end time
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label for="i8" class="form-label">Location</label>
                            <input type="text" class="form-control" id="i8" required name="location" value="<?php echo $resEresult['EventLocation'];?>">
                            <div class="invalid-feedback">
                            Please enter a location
                            </div>
                        </div>
                        <div class="col-md-2 mt-4">
                            <label for="i9" class="form-label">Number of seats</label>
                            <input type="number" class="form-control" id="i9" readonly name="seats" value="<?php echo $resEresult['TotalSeats'];?>">
                            <div class="invalid-feedback">
                            Please enter number of seats
                            </div>
                        </div>
                        <div class="col-md-2 mt-4">
                            <label for="i10" class="form-label">Age Limit</label>
                            <input type="text" class="form-control" id="i10" required name="age_limit" value="<?php echo $resEresult['AgeLimit'];?>">
                            <div class="invalid-feedback">
                            Please enter age limit
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label for="i11" class="form-label">Organizer Name</label>
                            <input type="text" class="form-control" id="i11" required name="organizer" value="<?php echo $resEresult['Organizer'];?>">
                            <div class="invalid-feedback">
                            Please enter organizer name
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <label for="i12" class="form-label">Printed By</label>
                            <input type="text" class="form-control" id="i12" required name="printed_by" value="<?php echo $resEresult['PrintedBy'];?>">
                            <div class="invalid-feedback">
                            Please enter printed by
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <label for="i14" class="form-label">Image1</label>
                            <input type="file" class="form-control" id="i14" name="image1" accept="image/*">
                            <div class="invalid-feedback">
                            Please choose image
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <label for="i15" class="form-label">Image2</label>
                            <input type="file" class="form-control" id="i15" name="image2" accept="image/*">
                            <div class="invalid-feedback">
                            Please choose image
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <label for="i16" class="form-label">Image3</label>
                            <input type="file" class="form-control" id="i16"  name="image3" accept="image/*">
                            <div class="invalid-feedback">
                            Please choose image
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label for="i17" class="form-label">Short Description</label>
                            <textarea class="form-control" id="i17" name="short_desc" ><?php echo $resEresult['ShortDescription'];?></textarea>
                            <div class="invalid-feedback">
                            Please enter short description
                            </div>
                        </div>

                        <div class="col-md-4 mt-4">
                            <label for="i18" class="form-label">Description</label>
                            <textarea class="form-control" id="i18" name="description" required><?php echo $resEresult['Description'];?></textarea>
                            <div class="invalid-feedback">
                            Please enter description
                            </div>
                        </div>

                        <div class="col-md-4 mt-4">
                            <label for="validationCustom02" class="form-label">Status</label>
                            <select class="form-control input-style" id="validationCustom04" required name="status">
                                <option value="">Select</option>
                                <option value="Publish" <?php if($resEresult['EventStatus']=='Publish'){echo 'selected';}?>>Publish</option>
                                <option value="Delete" <?php if($resEresult['EventStatus']=='Delete'){echo 'selected';}?>>Delete</option>
                            </select>
                            <div class="invalid-feedback">
                            Please choose status
                            </div>
                        </div>

                        <hr class="col-md-11">
                        <div class="col-12">
                            <button class="btn btn-primary " type="submit" name="add">Update</button>
                        </div>
                        </form>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
    require_once './pages/footer.php';
?>