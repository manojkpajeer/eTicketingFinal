<?php 
    session_start();

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    require_once './config/connection.php';
    require_once './pages/link.php';
    require_once './pages/header.php';   
    
    if(isset($_POST['add'])){

        $uniquid = rand(1000, 9999).time();
        $flag = true;

        if(isset($_POST['name'])){

            $countq = count($_POST['name']);

            $insertCategoryMaster = "INSERT INTO price_category(Price, CategoryName, Capacity, UniqueId) VALUES";
            for($i=0;$i<$countq;$i++){
                if ($i > 0) {
                    $insertCategoryMaster .= ',';
                }
                $insertCategoryMaster .= "('".$_POST['price'][$i]."', '".$_POST['name'][$i]."', '".$_POST['capacity'][$i]."', '$uniquid')";
            }

            if (!mysqli_query($conn, $insertCategoryMaster)) {
                $flag = false;
            }            
        }
        
        if ($flag) {
            if(empty($_POST['amount'])){
                $amounts = 0;
            } else {
                $amounts = $_POST['amount'];
            }
            if(mysqli_query($conn, "INSERT INTO event_request(OrganizerName, Phone, Email, EventName, EventDate, 
                StartTime, EndTime, EventVenue, EventProfile, Attendees, Badges, Amount, Celebrity, Fund, EventType, DateCreate, Registration, UniqueId) VALUES 
                ('$_POST[organizer_name]', '$_POST[phone]', '$_POST[email]', '$_POST[event_name]', '$_POST[event_date]', '$_POST[start_time]', 
                '$_POST[end_time]', '$_POST[event_venue]', '$_POST[event_profile]', '$_POST[attendees]', '$_POST[badges]', '$amounts', 
                '$_POST[celebrity]', '$_POST[fund]', '$_POST[event_type]', NOW(), '$_POST[registration]',  '$uniquid')")){

                sendEmail($_POST['organizer_name'], $_POST['email']);
                sendEmailToAdmin(mysqli_insert_id($conn), $conn);
                
                echo "<script>alert('Yay, Event submitted successfully..');</script>";
            }
            else{

                echo "<script>alert('Oops, Unable to submit event..');</script>";
                // echo mysqli_error($conn);
            }
        } else {

            echo "<script>alert('Oops, Unable to submit event..');</script>";
            // echo mysqli_error($conn);
        }
    }

    function sendEmailToAdmin($id, $conn){

        $message = "Oops, no data found. Kindly visit our website and login as super-admin";

        $resData = mysqli_query($conn, "SELECT * FROM event_request WHERE ER_Id = '$id'");
        if(mysqli_num_rows($resData)>0){

            $resData = mysqli_fetch_assoc($resData);

            $message = "<strong>Organizer Name : </strong>" . $resData['OrganizerName'] . "<br>";
            $message .= "<strong>Phone : </strong>" . $resData['Phone'] . "<br>";
            $message .= "<strong>Email Id : </strong>" . $resData['Email'] . "<br>";
            $message .= "<strong>Event Name : </strong>" . $resData['EventName'] . "<br>";
            $message .= "<strong>Event Date : </strong>" . $resData['EventDate'] . "<br>";
            $message .= "<strong>Start Time : </strong>" . $resData['StartTime'] . "<br>";
            $message .= "<strong>End Time : </strong>" . $resData['EndTime'] . "<br>";
            $message .= "<strong>Event Venue : </strong>" . $resData['EventVenue'] . "<br>";
            $message .= "<strong>Event Profile : </strong>" . $resData['EventProfile'] . "<br>";
            $message .= "<strong>Attendees : </strong>" . $resData['Attendees'] . "<br>";
            $message .= "<strong>Ticketed? : </strong>" . $resData['Badges'] . "<br>";
            $message .= "<strong>Amount : </strong>" . number_format($resData['Amount'], 2) . "<br>";
            $message .= "<strong>Does the event contain celebrity or VIP? : </strong>" . $resData['Celebrity'] . "<br>";
            $message .= "<strong>Does your event contain fund raising? : </strong>" . $resData['Fund'] . "<br>";
            $message .= "<strong>Event Type : </strong>" . $resData['EventType'] . "<br>";
            $message .= "<strong>Registration / Badges? : </strong>" . $resData['Registration'] . "<br><br>";

            $resCat = mysqli_query($conn, "SELECT * FROM price_category WHERE UniqueId = '$resData[UniqueId]'");
            if(mysqli_num_rows($resCat)>0){

                $message .= "<strong>Event Categories: </strong><br>";
                while($rowCat = mysqli_fetch_assoc($resCat)){

                    $message .= "<strong>Price</strong> ".number_format($rowCat['Price'], 2) . "\t<strong>Category Name</strong> ".$rowCat['CategoryName'] . "\t<strong>Capacity</strong> ".$rowCat['Capacity'] ."<br>";
                }
            }
        }

        $mail = new PHPMailer(true);

        try {                   
            $mail->isSMTP();                                           
            $mail->Host       = 'smtp.zoho.com';                    
            $mail->SMTPAuth   = true;                                  
            $mail->Username   = 'support@dxbtickets.com';                    
            $mail->Password   = 'Sujith104';                               
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
            $mail->Port       = 465;                                  
        
            $mail->setFrom('support@dxbtickets.com', "DXB Tickets");
            $mail->addAddress("info@dxbtickets.com", "Admin");
        
            $mail->IsHTML(true);
            $mail->Subject = "Event Create request from DXB Tickets customer";
            $mail->Body = "hi Admin<br>We have recieved a event creation request<br>".$message."<br><br>Team DXB Tickets</strong>";
        
            $mail->send();
        } catch (Exception $e) {
            
        }
    }

    function sendEmail($name, $email){
        $mail = new PHPMailer(true);

        try {                   
            $mail->isSMTP();                                           
            $mail->Host       = 'smtp.zoho.com';                    
            $mail->SMTPAuth   = true;                                  
            $mail->Username   = 'support@dxbtickets.com';                    
            $mail->Password   = 'Sujith104';                               
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
            $mail->Port       = 465;                                  
        
            $mail->setFrom('support@dxbtickets.com', "DXB Tickets");
            $mail->addAddress($email, $name);
        
            $mail->IsHTML(true);
            $mail->Subject = "Greetings from DXB Tickets";
            $mail->Body = "hi ". $name . "<br>Thank you for contacting us<br>We'll be in touch very soon<br><br>
                Thank You again<br><strong>Team DXB Tickets</strong>";
        
            $mail->send();
        } catch (Exception $e) {
            
        }
    }
?>
<style>
    :root{
    --color_0: #000;
    --color_1: #fff;
    --color_2: #cd9c50;
    --color_3: #c4801c;
}
    .form-bg{
    margin:0 auto;padding:50px;
}
form{
    font-family: 'Roboto', sans-serif;
}
.form-horizontal .header{
    background: linear-gradient(135deg,var(--color_2),var(--color_3),var(--color_2),var(--color_3));
    padding: 30px 25px;
    font-size: 30px;
    color: #fff;
    text-align: center;
    text-transform: uppercase;
    border-radius: 3px 3px 0 0;
}
.form-horizontal .heading{
    font-size: 16px;
    color: #FF0000;
    margin: 10px 0 20px 0;
    text-transform: capitalize;
}
.form-horizontal .form-content{
    padding: 25px;
    background: #fff;
}
</style>
<section class="w3l-price-2">
    <div class="price-main">
        <div class="wrapper">
            <div class="row">
                <div class="col-lg-2 col-sm-12 col-md-1"></div>
                <div class="col-lg-8 col-sm-12 col-md-10">
                    <form class="form-horizontal needs-validation border shadow" novalidate method="post">
                        <div class="header">Create Your Event</div>
                        <div class="form-content row mx-2">
                            <h4 class="heading">* indicates a required field.</h4>

                            <div class="col-md-6">
                                <small>Organizer Name <span class="text-danger">*</span></small>
                                <input type="text" class="form-control form-control-sm" style="border: 1px solid #cd9c50;" name="organizer_name" maxlength="100" required>
                                <div class="invalid-feedback">
                                    <small>Enter valid organizer name</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <small>Contact Number <span class="text-danger">*</span></small>
                                <input type="text" class="form-control form-control-sm" required name="phone" style="border: 1px solid #cd9c50;" pattern="[0-9]{6,15}" maxlength="15">
                                <div class="invalid-feedback">
                                    <small>Enter valid contact number</small>
                                </div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <small>Email ID <span class="text-danger">*</span></small>
                                <input type="email" class="form-control form-control-sm" required name="email" style="border: 1px solid #cd9c50;" maxlength="99">
                                <div class="invalid-feedback">
                                    <small>Enter valid email id</small>
                                </div>
                            </div>      

                            <div class="col-md-6 mt-3">
                                <small>Event Name <span class="text-danger">*</span></small>
                                <input type="text" class="form-control form-control-sm" name="event_name" style="border: 1px solid #cd9c50;" maxlength="150" required>
                                <div class="invalid-feedback">
                                   <small> Enter valid event name</small>
                                </div>
                            </div>

                            <div class="col-md-4 mt-3">
                                <small>Event Date <span class="text-danger">*</span></small>
                                <input type="date" min="<?php echo date("Y-m-d");?>" class="form-control form-control-sm" style="border: 1px solid #cd9c50;" name="event_date" required value="<?php echo date("Y-m-d"); ?>"/>
                                <div class="invalid-feedback">
                                    <small>Select event start date</small>
                                </div>
                            </div>

                            <div class="col-md-4 mt-3">
                                <small>Start Time <span class="text-danger">*</span></small>
                                <input type="time" class="form-control form-control-sm" required style="border: 1px solid #cd9c50;" name="start_time">
                                <div class="invalid-feedback">
                                    <small>Select start time</small>
                                </div>
                            </div>

                            <div class="col-md-4 mt-3">
                                <small>End Time <span class="text-danger">*</span></small>
                                <input type="time" class="form-control form-control-sm" required style="border: 1px solid #cd9c50;" name="end_time">
                                <div class="invalid-feedback">
                                    <small>Select end time</small>
                                </div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <small>Event Venue <span class="text-danger">*</span></small>
                                <input type="text" class="form-control form-control-sm" name="event_venue" style="border: 1px solid #cd9c50;" maxlength="150" required>
                                <div class="invalid-feedback">
                                    <small>Enter valid event venue</small>
                                </div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <small>Max. Number of attendees <span class="text-danger">*</span></small>
                                <input type="number" class="form-control form-control-sm" name="attendees" style="border: 1px solid #cd9c50;" min="1" required step="0">
                                <div class="invalid-feedback">
                                    <small>Enter number of attendees</small>
                                </div>
                            </div>

                            <div class="col-md-8 mt-3">
                                <small>Event Profile (Minimum 60 character)<span class="text-danger">*</span></small>
                                <textarea class="form-control form-control-sm" name="event_profile" required style="border: 1px solid #cd9c50;" minlength="60"></textarea>
                                <div class="invalid-feedback">
                                    <small>Please enter event profile </small>
                                </div>
                            </div>

                            <div class="col-md-4 mt-3">
                                <small>Ticketed<span class="text-danger">*</span></small>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="validationFormCheck2" style="border: 1px solid #cd9c50;" name="badges" required value="Yes" checked onclick="tsclick()">
                                    <small for="validationFormCheck2">&nbsp;&nbsp;Yes</small>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="validationFormCheck3" style="border: 1px solid #cd9c50;" name="badges" required value="No" onclick="tnoclick()">
                                    <small for="validationFormCheck3">&nbsp;&nbsp;No</small>
                                    <div class="invalid-feedback"><small>Please make a selection</small></div>
                                </div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <small>Registration / Badges<span class="text-danger">*</span></small>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="validationFormCheck2s" style="border: 1px solid #cd9c50;" name="registration" required value="Yes" onclick="bsclick()">
                                    <small for="validationFormCheck2s">&nbsp;&nbsp;Yes</small>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="validationFormCheck3s" style="border: 1px solid #cd9c50;" name="registration" required value="No" checked onclick="bnoclick()">
                                    <small for="validationFormCheck3s">&nbsp;&nbsp;No</small>
                                    <div class="invalid-feedback"><small>Please make a selection</small></div>
                                </div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <small>Estimated Total Amount of Sold Tickets in AED <span class="text-danger">*</span></small>
                                <input type="number" class="form-control form-control-sm" name="amount" style="border: 1px solid #cd9c50;" id="amount">
                                <div class="invalid-feedback">
                                    <small>Enter total amount</small>
                                </div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <label class="form-label">Does the event contain celebrity or VIP? <span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="validationFormCheck22" style="border: 1px solid #cd9c50;" name="celebrity" required value="Yes" checked>
                                    <small for="validationFormCheck22">&nbsp;&nbsp;Yes</small>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="validationFormCheck32" style="border: 1px solid #cd9c50;" name="celebrity" required value="No">
                                    <small for="validationFormCheck32">&nbsp;&nbsp;No</small>
                                    <div class="invalid-feedback"><small>Please make a selection</small></div>
                                </div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <small>Does your event contain fund raising? <span class="text-danger">*</span></small>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="validationFormCheck21" style="border: 1px solid #cd9c50;" name="fund" required value="Yes" checked>
                                    <small for="validationFormCheck21">&nbsp;&nbsp;Yes</small>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="validationFormCheck31" style="border: 1px solid #cd9c50;" name="fund" required value="No">
                                    <small for="validationFormCheck31">&nbsp;&nbsp;No</small>
                                    <div class="invalid-feedback"><small>Please make a selection</small></div>
                                </div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <small>Event Type <span class="text-danger">*</span></small>
                                <select class="form-control form-control-sm" required style="border: 1px solid #cd9c50;" name="event_type">
                                    <option value="">Select</option>
                                    <option value="Entertainment" selected>Entertainment</option>
                                    <option value="Business">Business</option>
                                </select>
                                <div class="invalid-feedback">
                                    <small>Please choose event type</small>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function () {
                                var rowIdx = 1;

                                $('#badd').on('click', function () {
                                    $('#tbody').append(`<tr id="R${++rowIdx}">
                                <td class="pl-1 pr-0"><input  style="border: 1px solid #cd9c50;"  required class="form-control form-control-sm" name="price[]" placeholder="Enter Price" type="number" min="1"></td>
                                <td class="pl-1 pr-0"><input  style="border: 1px solid #cd9c50;;" required class="form-control form-control-sm" name="name[]" placeholder="Enter Category Name" type="text"></td>
                                <td class="pl-1 pr-0"><input  style="border: 1px solid #cd9c50;" required class="form-control form-control-sm" name="capacity[]" placeholder="Enter Capacity" type="number" min="1"></td>
                                <td><small> <span class="badge rounded-pill bg-danger badge-md bremove mx-2"><i class="fa fa-minus"></i></span></small></td>
                                </tr>`);
                                });
                            
                                // jQuery button click event to remove a row.
                                $('#tbody').on('click', '.bremove', function () {
                                    if(rowIdx>0){  
                                    // Getting all the rows next to the row
                                    // containing the clicked button
                                    var child = $(this).closest('tr').nextAll();
                            
                                    // Iterating across all the rows 
                                    // obtained to change the index
                                    child.each(function () {
                            
                                    // Getting <tr> id.
                                    var id = $(this).attr('id');
                            
                                    // Getting the <p> inside the .row-index class.
                                    var idx = $(this).children('.row-index').children('p');
                            
                                    // Gets the row number from <tr> id.
                                    var dig = parseInt(id.substring(1));
                            
                                    // Modifying row index.
                                    idx.html(`Row ${dig - 1}`);
                            
                                    // Modifying row id.
                                    $(this).attr('id', `R${dig - 1}`);
                                    });
                            
                                    // Removing the current row.
                                    $(this).closest('tr').remove();
                                    rowIdx--;
                                }
                                });
                                });
                            </script>

                            <div class="col-md-12">
                                <div class="row mt-5">
                                    <h6><strong>Event Category</strong></h6>
                                    <div class="table-responsive ">
                                        <table class="table table-borderless table-sm">
                                            <thead>
                                                <tr>
                                                <th scope="col"><small>Ticket Price</small></th>
                                                <th scope="col"><small>Category Name</small></th>
                                                <th scope="col"><small>Capacity</small></th>
                                                <th scope="col"><small><span class="badge rounded-pill bg-danger badge-md m-2" id="badd" style="cursor: pointer;">Add</span></small></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12 mt-3">
                                <button class="btn" type="submit" name="add" style="background-color:#cd9c50;border: none;color: white;padding: 12px 25px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-2 col-sm-12 col-md-1"></div>
            </div>
        </div>
    </div>
</section>

<script>
    function tsclick() {
        $("#amount").prop('readonly', false);
        $("#validationFormCheck3s").prop('checked', true);
    }

    function tnoclick() {
        
        $("#amount").prop('readonly', true);
        $("#amount").val('0');
        $("#validationFormCheck2s").prop('checked', true);
    }

    function bsclick() {

        $("#amount").prop('readonly', true);
        $("#amount").val('0');
        $("#validationFormCheck3").prop('checked', true);
    }

    function bnoclick() {

        $("#amount").prop('readonly', false);
        $("#validationFormCheck2").prop('checked', true);
    }
</script>
<?php
    require_once './pages/footer.php';
?>