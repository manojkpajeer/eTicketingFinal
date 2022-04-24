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
    
    if(isset($_POST['add'])){

        $path_banner = "upcoming-image/" .time() . "." . pathinfo($_FILES['event_banner']['name'], PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES['event_banner']['tmp_name'], "../superadmin/".$path_banner)) {
            
            if(mysqli_query($conn, "INSERT INTO upcoming_event(EventName, StartDate, StartTime, EndDate, EndTime, 
                EventLocation, AgeLimit, Organizer, EventStatus, DateCreate, BannerImage, ShortDescription, 
                Description) VALUES ('$_POST[event_name]', '$_POST[start_date]', '$_POST[start_time]', '$_POST[end_date]', 
                '$_POST[end_time]', '$_POST[location]', 
                '$_POST[age_limit]', '$_POST[organizer]', 1, NOW(), '$path_banner', '$_POST[short_desc]', 
                '$_POST[description]')")){

                echo "<script>alert('Yay, Upcoming Event added..');</script>";     
            }
            else{

                echo "<script>alert('Oops, Unable to add event..');</script>";
                // echo mysqli_error($conn);
            }
        }
    }
?>

<!-- main content start -->
<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="row">
            <div class="col-xl-12 pr-xl-12">
                <div class="card card_border border-primary-top">
                <div class="card-header chart-grid__header float-left">Create Upcoming Event</div>
                    <div class="card-body">
                    <form method="post" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                        <div class="col-md-4">
                            <label for="i1" class="form-label">Event Name</label>
                            <input type="text" class="form-control input-style" id="i1" required name="event_name">
                            <div class="invalid-feedback">
                            Please enter a event name
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="i3" class="form-label">Banner Image</label>
                            <input type="file" class="form-control input-style" id="i3" required name="event_banner" accept="image/*">
                            <div class="invalid-feedback">
                            Please choose banner image
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="i8" class="form-label">Location</label>
                            <input type="text" class="form-control input-style" id="i8" required name="location">
                            <div class="invalid-feedback">
                            Please enter a location
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <label for="i4" class="form-label">Event Start Date</label>
                            <input type="date" class="form-control input-style" id="i4" required min="<?php echo date('Y-m-d'); ?>" name="start_date">
                            <div class="invalid-feedback">
                            Please select event start date
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <label for="i5" class="form-label">Event Start Time</label>
                            <input type="time" class="form-control input-style" id="i5" required name="start_time">
                            <div class="invalid-feedback">
                            Please select event start time
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <label for="i6" class="form-label">Event End Date</label>
                            <input type="date" class="form-control input-style" id="i6" required min="<?php echo date('Y-m-d'); ?>" name="end_date">
                            <div class="invalid-feedback">
                            Please select event end date
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <label for="i7" class="form-label">Event End Time</label>
                            <input type="time" class="form-control input-style" id="i7" required name="end_time">
                            <div class="invalid-feedback">
                            Please select event end time
                            </div>
                        </div>
                        
                        <div class="col-md-2 mt-4">
                            <label for="i10" class="form-label">Age Limit</label>
                            <input type="text" class="form-control input-style" id="i10" required name="age_limit">
                            <div class="invalid-feedback">
                            Please enter age limit
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <label for="i11" class="form-label">Organizer Name</label>
                            <input type="text" class="form-control input-style" id="i11" required name="organizer">
                            <div class="invalid-feedback">
                            Please enter organizer name
                            </div>
                        </div>
                        
                        <div class="col-md-3 mt-4">
                            <label for="i17" class="form-label">Short Description</label>
                            <textarea class="form-control input-style" id="i17" name="short_desc" required></textarea>
                            <div class="invalid-feedback">
                            Please enter short description
                            </div>
                        </div>

                        <div class="col-md-4 mt-4">
                            <label for="i18" class="form-label">Description</label>
                            <textarea class="form-control input-style" id="i18" name="description" required></textarea>
                            <div class="invalid-feedback">
                            Please enter description
                            </div>
                        </div>

                        <hr class="col-md-11">
                        <div class="col-12">
                            <button class="btn btn-primary btn-style" type="submit" name="add">Submit</button>
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