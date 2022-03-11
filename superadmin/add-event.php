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
    require_once '../api/maestro_util.php';

    $util = new MaestroUtil();

    if(isset($_POST['add'])){

        $res = mysqli_query($conn, "SELECT EventCode FROM event_master WHERE EventCode = '$_POST[event_code]' AND  EventStatus = 'Publish' ");
        if(mysqli_num_rows($res)>0){

            echo "<script>alert('Oops, Event Code already in use..');</script>";
        }
        else{

            $path_banner = "event-image/" .time() . rand(1000, 9999) . "." . pathinfo($_FILES['event_banner']['name'], PATHINFO_EXTENSION);

            if (move_uploaded_file($_FILES['event_banner']['tmp_name'], $path_banner)) {

                $path_image1 = "event-image/" .time() . rand(1000, 9999) . "." . pathinfo($_FILES['image1']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($_FILES['image1']['tmp_name'], $path_image1);

                $path_image2 = "event-image/" .time() . rand(1000, 9999) . "." . pathinfo($_FILES['image2']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($_FILES['image2']['tmp_name'], $path_image2);

                $path_image3 = "event-image/" .time() . rand(1000, 9999) . "." . pathinfo($_FILES['image3']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($_FILES['image3']['tmp_name'], $path_image3);

                $path_image4 = "event-image/" .time() . rand(1000, 9999) . "." . pathinfo($_FILES['image4']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($_FILES['image4']['tmp_name'], $path_image3);

                $eventOn = $_POST['start_date']." ".$_POST['start_time'];

                if(mysqli_query($conn, "INSERT INTO event_master(CreatedBy, EventName, EventCode, StartDate, StartTime, EndDate, EndTime, 
                EventLocation, TotalSeats, AgeLimit, Organizer, PrintedBy, EventStatus, DateCreate, EventBanner, ShortDescription, 
                Description, Image1, Image2, Image3, Image4, EventOn, BookingStatus, SliderStatus, LocationMap) VALUES ('$_SESSION[FullName]', '$_POST[event_name]', '$_POST[event_code]', 
                '$_POST[start_date]', '$_POST[start_time]', '$_POST[end_date]', '$_POST[end_time]', '$_POST[location]', '$_POST[seats]', 
                '$_POST[age_limit]', '$_POST[organizer]', '$_POST[printed_by]', 'New', NOW(), '$path_banner', '$_POST[short_desc]', 
                '$_POST[description]', '$path_image1', '$path_image2', '$path_image3', '$path_image4', '$eventOn', '$_POST[bookingstatus]', '$_POST[slider_status]', '$_POST[map]')")){

                    $eventId = mysqli_insert_id($conn);

                    $util->getPriceDetails($eventId, $_POST['event_code']);       
                }
                else{

                    echo "<script>alert('Oops, Unable to add event..');</script>";
                }
            }
        }
    }
?>

<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="row">
            <div class="col-xl-12 pr-xl-12">
                <div class="card card_border border-primary-top">
                <div class="card-header chart-grid__header float-left">Create Event</div>
                    <div class="card-body">
                    <form method="POST" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                        <div class="col-md-4">
                            <label for="i1" class="form-label">Event Name</label>
                            <input type="text" class="form-control input-style" id="i1" required name="event_name">
                            <div class="invalid-feedback">
                            Please enter a event name
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="i2" class="form-label">Event Code</label>
                            <input type="text" class="form-control input-style" id="i2" required name="event_code">
                            <div class="invalid-feedback">
                            Please enter a event code
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="i3" class="form-label">Banner Image</label>
                            <input type="file" class="form-control input-style" id="i3" required name="event_banner" accept="image/*">
                            <div class="invalid-feedback">
                            Please choose banner image
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
                        <div class="col-md-4 mt-4">
                            <label for="i8" class="form-label">Location</label>
                            <input type="text" class="form-control input-style" id="i8" required name="location">
                            <div class="invalid-feedback">
                            Please enter a location
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label for="i8a" class="form-label">Location Map</label>
                            <input type="text" class="form-control input-style" id="i8a" required name="map">
                            <div class="invalid-feedback">
                            Please enter a location map
                            </div>
                        </div>
                        <div class="col-md-2 mt-4">
                            <label for="i9" class="form-label">Number of seats</label>
                            <input type="number" class="form-control input-style" id="i9" required name="seats">
                            <div class="invalid-feedback">
                            Enter number of seats
                            </div>
                        </div>
                        <div class="col-md-2 mt-4">
                            <label for="i10" class="form-label">Age Limit</label>
                            <input type="text" class="form-control input-style" id="i10" required name="age_limit">
                            <div class="invalid-feedback">
                            Please enter age limit
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label for="i11" class="form-label">Organizer Name</label>
                            <input type="text" class="form-control input-style" id="i11" required name="organizer">
                            <div class="invalid-feedback">
                            Please enter organizer name
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label for="i12" class="form-label">Printed By</label>
                            <input type="text" class="form-control input-style" id="i12" value="Maestro Events (L.L.C)" required name="printed_by">
                            <div class="invalid-feedback">
                            Please enter printed by
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label for="i14" class="form-label">Image1</label>
                            <input type="file" class="form-control input-style" id="i14" required name="image1" accept="image/*">
                            <div class="invalid-feedback">
                            Please choose image
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label for="i15" class="form-label">Image2</label>
                            <input type="file" class="form-control input-style" id="i15" required name="image2" accept="image/*">
                            <div class="invalid-feedback">
                            Please choose image
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label for="i16" class="form-label">Image3</label>
                            <input type="file" class="form-control input-style" id="i16" required name="image3" accept="image/*">
                            <div class="invalid-feedback">
                            Please choose image
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label for="i17" class="form-label">Image4</label>
                            <input type="file" class="form-control input-style" id="i17" required name="image4" accept="image/*">
                            <div class="invalid-feedback">
                            Please choose image
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label for="i17" class="form-label">Short Description</label>
                            <textarea class="form-control input-style" id="i17" name="short_desc" ></textarea>
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

                        <div class="col-md-4 mt-4">
                            <label class="form-label">Booking Status</label>
                            <select class="form-control input-style" required name="bookingstatus">
                                <option value="">Select</option>
                                <option value="1" selected>Open</option>
                                <option value="0">Closed</option>
                            </select>
                            <div class="invalid-feedback">
                                Please choose booking status
                            </div>
                        </div>

                        <div class="col-md-3 mt-4">
                            <label class="form-label">Slider Status</label>
                            <select class="form-control input-style" required name="slider_status">
                                <option value="">Select</option>
                                <option value="1" selected>Active</option>
                                <option value="0">In Active</option>
                            </select>
                            <div class="invalid-feedback">
                                Please choose slider status
                            </div>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <button class="btn btn-style btn-primary" type="submit" name="add">Next</button>
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