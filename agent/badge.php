<?php
    session_start();
        
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    if(!isset($_SESSION['is_ajent_login'])){
        header('Location: ./pages/logout.php');
    }
    else{
        if(!$_SESSION['is_ajent_login']){
            header('Location: ./pages/logout.php');
        }
    }
        
    require_once '../config/connection.php';
    require_once './pages/link.php';
    require_once './pages/sidebar.php';
    require_once './pages/header.php';

    if(isset($_POST['submit'])){

        $resBarcode = mysqli_query($conn, "SELECT barcode_master.Barcode FROM sales_master JOIN barcode_master ON 
            sales_master.OrderId = barcode_master.OrderId JOIN customer_master ON 
            customer_master.CM_Id = sales_master.CustomerId WHERE barcode_master.PerformanceCode = '$_POST[ecode]' 
            AND sales_master.EventId='$_POST[eid]' AND customer_master.CustomerStatus = 1
            AND customer_master.FirstName = '$_POST[first_name]' AND customer_master.LastName = '$_POST[last_name]' AND 
            customer_master.CustomerPhone = '$_POST[phone]' ORDER BY sales_master.SM_Id ");

        if (mysqli_num_rows($resBarcode) > 0) {

            $resBarcode = mysqli_fetch_assoc($resBarcode);
            
            $RegistrationNumber = rand(10000000, 99999999);

            if(mysqli_query($conn, "INSERT INTO badge_master(EventId, FirstName, LastName, EmailId, PhoneNo, 
            Nationality, Country, BarcodeNo, BadgeStatus, DateCreate, CompanyName, Designation, TotalAmount, TicketId, RegistrationNumber) VALUES ('$_POST[eid]',
            '$_POST[first_name]', '$_POST[last_name]', '$_POST[email]', '$_POST[phone]', '$_POST[nationality]', 
            '$_POST[country]', '$resBarcode[Barcode]', 1, NOW(), '$_POST[company]', '$_POST[designation]', '0' , '$_POST[ticketchoose]', '$RegistrationNumber')")){
  
                // echo "<script>alert('Yay, Badge added successfully..');</script>";
                sendEmail($_POST['first_name'], $_POST['last_name'], $_POST['email'], $RegistrationNumber);
            }
            else{

                echo "<script>alert('Oops, Unable to add badge..');</script>";
            }

        } else {

            $resBarcode2 = mysqli_query($conn, "SELECT barcode_master.Barcode FROM sales_master JOIN barcode_master ON 
            sales_master.OrderId = barcode_master.OrderId JOIN agent_customer ON 
            agent_customer.AC_Id = sales_master.CustomerId WHERE barcode_master.PerformanceCode = '$_POST[ecode]' 
            AND sales_master.EventId='$_POST[eid]' AND agent_customer.CustomerStatus = 1
            AND agent_customer.FirstName = '$_POST[first_name]' AND agent_customer.LastName = '$_POST[last_name]' AND 
            agent_customer.CustomerPhone = '$_POST[phone]' ORDER BY sales_master.SM_Id ");

            if (mysqli_num_rows($resBarcode2) > 0) {

                $resBarcode2 = mysqli_fetch_assoc($resBarcode2);
                
                $RegistrationNumber = rand(10000000, 99999999);

                if(mysqli_query($conn, "INSERT INTO badge_master(EventId, FirstName, LastName, EmailId, PhoneNo, 
                Nationality, Country, BarcodeNo, BadgeStatus, DateCreate, CompanyName, Designation, TotalAmount, TicketId, RegistrationNumber) VALUES ('$_POST[eid]',
                '$_POST[first_name]', '$_POST[last_name]', '$_POST[email]', '$_POST[phone]', '$_POST[nationality]', 
                '$_POST[country]', '$resBarcode2[Barcode]', 1, NOW(), '$_POST[company]', '$_POST[designation]', '0' , '$_POST[ticketchoose]', '$RegistrationNumber')")){
    
                    // echo "<script>alert('Yay, Badge added successfully..');</script>";
                    sendEmail($_POST['first_name'], $_POST['last_name'], $_POST['email'], $RegistrationNumber);
                }
                else{

                    echo "<script>alert('Oops, Unable to add badge..');</script>";
                }

            } else {

                echo "<script>alert('Oops, No barcode found for this user..');</script>";
            }
        }     
        
    }

    function sendEmail($fname, $lname, $uemail, $regno){

        try {  
            
            $mail = new PHPMailer(true);

            $mail->isSMTP();                                           
            $mail->Host       = 'smtp.zoho.com';                    
            $mail->SMTPAuth   = true;                                  
            $mail->Username   = 'support@dxbtickets.com';                    
            $mail->Password   = 'Sujipri@28';                               
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
            $mail->Port       = 465;                                  
        
            $mail->setFrom('support@dxbtickets.com', "DXB Tickets");
            $mail->addAddress($uemail, $fname." ".$lname);
            
            // $mail->addAttachment('mailer-image/image.jpg', 'recovery.jpg');  
        
            $mail->IsHTML(true);
            $mail->Subject = "Badge creation email - DXB Tickets";
            $mail->Body = 'hi ' . $fname." ".$lname . "<br>We received a badge creation request.<br> Your Registration Number is : <strong>" . $regno . "</strong><br><br>Thank You<br><strong>Team DXB Tickets</strong>";
        
            if ($mail->send()) {
                echo "<script>alert('Yay, Badge added successfully..');</script>";
            } else {
                echo "<script>alert('Yay, Badge added successfully..');</script>";
            }
        } catch (Exception $e) {
            echo "<script>alert('Yay, Badge added successfully..');</script>";
        }
    }
?>

<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="data-tables">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card card_border p-4 border-primary-top">
                        <h3 class="card__title position-absolute">Manage Badge - Event List</h3>
                        <div class="table-responsive">
                            <table id="meastroTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Event Name</th>
                                        <th>Event Code</th>
                                        <th>Event On</th>
                                        <th>Location</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $resd6 = mysqli_query($conn, "SELECT DISTINCT event_master.*  FROM ticket_allocation
                                        JOIN event_master ON event_master.EM_Id = ticket_allocation.EventId WHERE 
                                        ticket_allocation.AjentId = '$_SESSION[ajm_id]' AND NOT EventStatus = 'New' ORDER BY event_master.EM_Id DESC");
                                        if (mysqli_num_rows($resd6) > 0) {

                                            $count = 1;
                                            while($rowd6 = mysqli_fetch_assoc($resd6)) {
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>"; 
                                                echo "<td>".$rowd6['EventName']."</td>"; 
                                                echo "<td>".$rowd6['EventCode']."</td>"; 
                                                echo "<td>".date_format(date_create($rowd6['StartDate']), 'd M, Y') . "</td>"; 
                                                echo "<td>".$rowd6['EventLocation']."</td>";
                                                echo "<td>"; 
                                                ?>
                                                <a href="#" data-toggle="modal" data-target="#add<?php echo $rowd6['EM_Id'];?>"><i class='fa fa-plus-circle'></i></a> | 
                                                <?php
                                                echo "<a href='manage-badge.php?eid=$rowd6[EM_Id]&ecode=$rowd6[EventCode]'><i class='fa fa-eye'></i></a> |";
                                                $copyData = $_SERVER['SERVER_NAME'] . "/bdgdxb.php?pref=".$rowd6['EM_Id'];
                                                $eid = $rowd6['EM_Id'];
                                                ?>
                                                <a href="../badge.php?pref=<?php echo $rowd6['EM_Id']?>"><i class='fa fa-link'></i></span>
                                                <?php
                                                echo "</td>";
                                                echo "</tr>"; 

                                                $count++;

                                                ?>
                                                    <div class="modal fade" id="add<?php echo $rowd6['EM_Id'];?>" tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <form method="POST" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo "Add Badge";?></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body g-3 row">
                                                                        <div class="col-md-4">
                                                                            <label class="form-label">First Name</label>
                                                                            <input type="text" title="Enter valid first name" class="form-control input-style" name="first_name" pattern="[A-Za-z]{1,49}" maxlength="49" required>
                                                                            <div class="invalid-feedback">
                                                                                Enter valid first name
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <label  class="form-label">Last Name </label>
                                                                            <input type="text" title="Enter valid last name" class="form-control input-style" required name="last_name" pattern="[A-Za-z]{1,49}" maxlength="49">
                                                                            <div class="invalid-feedback">
                                                                                Enter valid last name
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <label class="form-label">Email ID </label>
                                                                            <input type="email" title="Enter valid email id" class="form-control input-style" required name="email" maxlength="99">
                                                                            <div class="invalid-feedback">
                                                                            Enter valid email id
                                                                            </div>
                                                                        </div>      

                                                                        <div class="col-md-4 mt-3">
                                                                            <label class="form-label">Nationality </label>
                                                                            <select name="nationality" class="form-control input-style" required title="Choose nationality">
                                                                                <option value="">Choose..</option>
                                                                                <option value="AF">Afghan</option>
                                                                                <option value="AL">Albanian</option>
                                                                                <option value="DZ">Algerian</option>
                                                                                <option value="AS">American</option>
                                                                                <option value="AD">Andorran</option>
                                                                                <option value="AO">Angolan</option>
                                                                                <option value="AI">Anguilla</option>
                                                                                <option value="AQ">Antarctica</option>
                                                                                <option value="AG">Antiguans</option>
                                                                                <option value="AR">Argentinean</option>
                                                                                <option value="AM">Armenian</option>
                                                                                <option value="AW">Aruba</option>
                                                                                <option value="AU">Australian</option>
                                                                                <option value="AT">Austrian</option>
                                                                                <option value="AZ">Azerbaijani</option>

                                                                                <option value="BS">Bahamian</option>
                                                                                <option value="BH">Bahraini</option>
                                                                                <option value="BD">Bangladeshi</option>
                                                                                <option value="BB">Barbadian</option>
                                                                                <option value="BY">Belarusian</option>
                                                                                <option value="BE">Belgian</option>
                                                                                <option value="BZ">Belizean</option>
                                                                                <option value="BJ">Beninese</option>
                                                                                <option value="BM">Bermuda</option>
                                                                                <option value="BT">Bhutanese</option>
                                                                                <option value="BO">Bolivian</option>
                                                                                <option value="BA">Bosnian</option>
                                                                                <option value="BW">Botswana</option>
                                                                                <option value="BV">Bouvet Island</option>
                                                                                <option value="BR">Brazilian</option>
                                                                                <option value="IO">British</option>
                                                                                <option value="BN">Bruneian</option>
                                                                                <option value="BG">Bulgarian</option>
                                                                                <option value="BF">Burkinabe</option>
                                                                                <option value="BI">Burundian</option>
                                                                                <option value="KH">Cambodian</option>
                                                                                <option value="CM">Cameroonian</option>
                                                                                <option value="CA">Canadian</option>
                                                                                <option value="CV">Cape Verdean</option>
                                                                                <option value="KY">Cayman Islands</option>
                                                                                <option value="CF">Central African</option>
                                                                                <option value="TD">Chadian</option>
                                                                                <option value="CL">Chilean</option>
                                                                                <option value="CN">Chinese</option>
                                                                                <option value="CX">Christmas Island</option>
                                                                                <option value="CO">Colombian</option>
                                                                                <option value="KM">Comoran</option>
                                                                                <option value="CG">Congolese</option>
                                                                                <option value="CK">Cook Islands</option>
                                                                                <option value="CR">Costa Rican</option>
                                                                                <option value="CI">Cote d'Ivoire</option>
                                                                                <option value="HR">Croatian</option>
                                                                                <option value="CU">Cuban</option>
                                                                                <option value="CY">Cypriot</option>
                                                                                <option value="CZ">Czech</option>
                                                                                <option value="DK">Danish</option>
                                                                                <option value="DJ">Djibouti</option>
                                                                                <option value="DM">Dominican</option>
                                                                                <option value="DO">Dutch</option>
                                                                                <option value="TP">East Timorese</option>
                                                                                <option value="EC">Ecuadorean</option>
                                                                                <option value="EG">Egyptian</option>
                                                                                <option value="SV">El Salvador</option>
                                                                                <option value="GQ">Equatorial Guinean</option>
                                                                                <option value="ER">Eritrean</option>
                                                                                <option value="EE">Estonian</option>
                                                                                <option value="ET">Ethiopian</option>
                                                                                <option value="FO">Faroe Islands</option>
                                                                                <option value="FJ">Fijian</option>
                                                                                <option value="FI">Finland</option>
                                                                                <option value="FR">France</option>
                                                                                <option value="FX">France, Metropolitan</option>
                                                                                <option value="GF">French Guiana</option>
                                                                                <option value="PF">French Polynesia</option>
                                                                                <option value="GA">Gabonese</option>
                                                                                <option value="GM">Gambian</option>
                                                                                <option value="GE">Georgian</option>
                                                                                <option value="DE">German</option>
                                                                                <option value="GH">Ghanaian</option>
                                                                                <option value="GI">Gibraltar</option>
                                                                                <option value="GR">Greek</option>
                                                                                <option value="GL">Greenland</option>
                                                                                <option value="GD">Grenadian</option>
                                                                                <option value="GP">Guadeloupe</option>
                                                                                <option value="GU">Guam</option>
                                                                                <option value="GT">Guatemalan</option>
                                                                                <option value="GN">Guinean</option>
                                                                                <option value="GW">Guinea-Bissauan</option>
                                                                                <option value="GY">Guyanese</option>
                                                                                <option value="HT">Haitian</option>
                                                                                <option value="HN">Honduran</option>
                                                                                <option value="HK">Hong Kong</option>
                                                                                <option value="HU">Hungarian</option>
                                                                                <option value="IS">Icelander</option>
                                                                                <option value="IN">Indian</option>
                                                                                <option value="ID">Indonesian</option>
                                                                                <option value="IR">Iranian</option>
                                                                                <option value="IQ">Iraqi</option>
                                                                                <option value="IE">Irish</option>
                                                                                <option value="IL">Israeli</option>
                                                                                <option value="IT">Italian</option>
                                                                                <option value="JM">Jamaican</option>
                                                                                <option value="JP">Japanese</option>
                                                                                <option value="JO">Jordanian</option>
                                                                                <option value="KZ">Kazakhstani</option>
                                                                                <option value="KE">Kenyan</option>
                                                                                <option value="KI">Kiribati</option>
                                                                                <option value="KR">Korea, Republic of</option>
                                                                                <option value="KW">Kuwaiti</option>
                                                                                <option value="KG">Kyrgyzstan</option>
                                                                                <option value="LV">Latvian</option>
                                                                                <option value="LB">Lebanese</option>
                                                                                <option value="LS">Lesotho</option>
                                                                                <option value="LR">Liberian</option>
                                                                                <option value="LY">Libyan Arab Jamahiriya</option>
                                                                                <option value="LI">Liechtensteiner</option>
                                                                                <option value="LT">Lithuanian</option>
                                                                                <option value="LU">Luxembourger</option>
                                                                                <option value="MO">Macau</option>
                                                                                <option value="MG">Madagascar</option>
                                                                                <option value="MW">Malawian</option>
                                                                                <option value="MY">Malaysian</option>
                                                                                <option value="MV">Maldivan</option>
                                                                                <option value="ML">Malian</option>
                                                                                <option value="MT">Maltese</option>
                                                                                <option value="MH">Marshallese</option>
                                                                                <option value="MQ">Martinique</option>
                                                                                <option value="MR">Mauritanian</option>
                                                                                <option value="MU">Mauritian</option>
                                                                                <option value="YT">Mayotte</option>
                                                                                <option value="MX">Mexican</option>
                                                                                <option value="MD">Moldova, Republic of</option>
                                                                                <option value="MC">Monacan</option>
                                                                                <option value="MN">Mongolian</option>
                                                                                <option value="MS">Montserrat</option>
                                                                                <option value="MA">Moroccan</option>
                                                                                <option value="MZ">Mozambican</option>
                                                                                <option value="MM">Myanmar</option>
                                                                                <option value="NA">Namibian</option>
                                                                                <option value="NR">Nauruan</option>
                                                                                <option value="NP">Nepalese</option>
                                                                                <option value="NL">Netherlands</option>
                                                                                <option value="AN">Netherlands Antilles</option>
                                                                                <option value="NC">New Caledonia</option>
                                                                                <option value="NZ">New Zealander</option>
                                                                                <option value="NI">Nicaraguan</option>
                                                                                <option value="NE">Niger</option>
                                                                                <option value="NG">Nigerien</option>
                                                                                <option value="NU">Niue</option>
                                                                                <option value="NF">Norfolk Island</option>
                                                                                <option value="MP">Northern Mariana Islands</option>
                                                                                <option value="NO">Norwegian</option>
                                                                                <option value="OM">Omani</option>
                                                                                <option value="PK">Pakistani</option>
                                                                                <option value="PW">Palauan</option>
                                                                                <option value="PA">Panamanian</option>
                                                                                <option value="PG">Papua New Guinean</option>
                                                                                <option value="PY">Paraguayan</option>
                                                                                <option value="PE">Peruvian</option>
                                                                                <option value="PH">Philippines</option>
                                                                                <option value="PN">Pitcairn</option>
                                                                                <option value="PL">Poland</option>
                                                                                <option value="PT">Portuguese</option>
                                                                                <option value="PR">Puerto Rico</option>
                                                                                <option value="QA">Qatari</option>
                                                                                <option value="RE">Reunion</option>
                                                                                <option value="RO">Romanian</option>
                                                                                <option value="RU">Russian Federation</option>
                                                                                <option value="RW">Rwandan</option>
                                                                                <option value="KN">Saint Kitts and Nevis</option> 
                                                                                <option value="LC">Saint Lucian</option>
                                                                                <option value="VC">Saint Vincent and the Grenadines</option>
                                                                                <option value="WS">Samoan</option>
                                                                                <option value="SM">San Marinese</option>
                                                                                <option value="ST">Sao Tome and Principe</option> 
                                                                                <option value="SA">Saudi</option>
                                                                                <option value="SN">Senegal</option>
                                                                                <option value="SC">Seychelles</option>
                                                                                <option value="SL">Sierra Leone</option>
                                                                                <option value="SG">Singapore</option>
                                                                                <option value="SK">Slovakia (Slovak Republic)</option>
                                                                                <option value="SI">Slovenia</option>
                                                                                <option value="SB">Solomon Islands</option>
                                                                                <option value="SO">Somalia</option>
                                                                                <option value="ZA">South Africa</option>
                                                                                <option value="GS">South Georgia and the South Sandwich Islands</option>
                                                                                <option value="ES">Spain</option>
                                                                                <option value="LK">Sri Lanka</option>
                                                                                <option value="SH">St. Helena</option>
                                                                                <option value="PM">St. Pierre and Miquelon</option>
                                                                                <option value="SD">Sudan</option>
                                                                                <option value="SR">Suriname</option>
                                                                                <option value="SJ">Svalbard and Jan Mayen Islands</option>
                                                                                <option value="SZ">Swaziland</option>
                                                                                <option value="SE">Sweden</option>
                                                                                <option value="CH">Switzerland</option>
                                                                                <option value="SY">Syrian Arab Republic</option>
                                                                                <option value="TW">Taiwan, Province of China</option>
                                                                                <option value="TJ">Tajikistan</option>
                                                                                <option value="TZ">Tanzania, United Republic of</option>
                                                                                <option value="TH">Thailand</option>
                                                                                <option value="TG">Togo</option>
                                                                                <option value="TK">Tokelau</option>
                                                                                <option value="TO">Tonga</option>
                                                                                <option value="TT">Trinidad and Tobago</option>
                                                                                <option value="TN">Tunisia</option>
                                                                                <option value="TR">Turkey</option>
                                                                                <option value="TM">Turkmenistan</option>
                                                                                <option value="TC">Turks and Caicos Islands</option>
                                                                                <option value="TV">Tuvalu</option>
                                                                                <option value="UG">Uganda</option>
                                                                                <option value="UA">Ukraine</option>
                                                                                <option value="AE" selected>United Arab Emirates</option>
                                                                                <option value="GB">United Kingdom</option>
                                                                                <option value="US">United States</option>
                                                                                <option value="UY">Uruguayan</option>
                                                                                <option value="UZ">Uzbekistani</option>
                                                                                <option value="VU">Vanuatu</option>
                                                                                <option value="VE">Venezuelan</option>
                                                                                <option value="VN">Viet Nam</option>
                                                                                <option value="VG">Virgin Islands (British)</option>
                                                                                <option value="VI">Virgin Islands (U.S)</option>
                                                                                <option value="WF">Wallis and Futuna Islands</option>
                                                                                <option value="EH">Western Sahara</option>
                                                                                <option value="YE">Yemenite</option>
                                                                                <option value="YU">Yugoslavia</option>
                                                                                <option value="ZM">Zambian</option>
                                                                                <option value="ZW">Zimbabwean</option>
                                                                            </select>
                                                                            <div class="invalid-feedback">
                                                                            Select nationality
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4 mt-3">
                                                                            <label class="form-label">Country of residence</label>
                                                                            <select name="country" class="form-control input-style" required title="Choose country">
                                                                                <option value="">Choose..</option>
                                                                                <option value="AF">Afghanistan</option>
                                                                                <option value="AL">Albania</option>
                                                                                <option value="DZ">Algeria</option>
                                                                                <option value="AS">American Samoa</option>
                                                                                <option value="AD">Andorra</option>
                                                                                <option value="AO">Angola</option>
                                                                                <option value="AI">Anguilla</option>
                                                                                <option value="AQ">Antarctica</option>
                                                                                <option value="AG">Antigua and Barbuda</option>
                                                                                <option value="AR">Argentina</option>
                                                                                <option value="AM">Armenia</option>
                                                                                <option value="AW">Aruba</option>
                                                                                <option value="AU">Australia</option>
                                                                                <option value="AT">Austria</option>
                                                                                <option value="AZ">Azerbaijan</option>
                                                                                <option value="BS">Bahamas</option>
                                                                                <option value="BH">Bahrain</option>
                                                                                <option value="BD">Bangladesh</option>
                                                                                <option value="BB">Barbados</option>
                                                                                <option value="BY">Belarus</option>
                                                                                <option value="BE">Belgium</option>
                                                                                <option value="BZ">Belize</option>
                                                                                <option value="BJ">Benin</option>
                                                                                <option value="BM">Bermuda</option>
                                                                                <option value="BT">Bhutan</option>
                                                                                <option value="BO">Bolivia</option>
                                                                                <option value="BW">Botswana</option>
                                                                                <option value="BV">Bouvet Island</option>
                                                                                <option value="BR">Brazil</option>
                                                                                <option value="BN">Brunei Darussalam</option>
                                                                                <option value="BG">Bulgaria</option>
                                                                                <option value="BF">Burkina Faso</option>
                                                                                <option value="BI">Burundi</option>
                                                                                <option value="KH">Cambodia</option>
                                                                                <option value="CM">Cameroon</option>
                                                                                <option value="CA">Canada</option>
                                                                                <option value="CV">Cape Verde</option>
                                                                                <option value="KY">Cayman Islands</option>
                                                                                <option value="CF">Central African Republic</option>
                                                                                <option value="TD">Chad</option>
                                                                                <option value="CL">Chile</option>
                                                                                <option value="CN">China</option>
                                                                                <option value="CX">Christmas Island</option>
                                                                                <option value="CC">Cocos (Keeling) Islands</option>
                                                                                <option value="CO">Colombia</option>
                                                                                <option value="KM">Comoros</option>
                                                                                <option value="CG">Congo</option>
                                                                                <option value="CK">Cook Islands</option>
                                                                                <option value="CR">Costa Rica</option>
                                                                                <option value="CI">Cote d'Ivoire</option>
                                                                                <option value="HR">Croatia (Hrvatska)</option>
                                                                                <option value="CU">Cuba</option>
                                                                                <option value="CY">Cyprus</option>
                                                                                <option value="CZ">Czech Republic</option>
                                                                                <option value="DK">Denmark</option>
                                                                                <option value="DJ">Djibouti</option>
                                                                                <option value="DM">Dominica</option>
                                                                                <option value="DO">Dominican Republic</option>
                                                                                <option value="TP">East Timor</option>
                                                                                <option value="EC">Ecuador</option>
                                                                                <option value="EG">Egypt</option>
                                                                                <option value="SV">El Salvador</option>
                                                                                <option value="GQ">Equatorial Guinea</option>
                                                                                <option value="ER">Eritrea</option>
                                                                                <option value="EE">Estonia</option>
                                                                                <option value="ET">Ethiopia</option>
                                                                                <option value="FK">Falkland Islands (Malvinas)</option>
                                                                                <option value="FO">Faroe Islands</option>
                                                                                <option value="FJ">Fiji</option>
                                                                                <option value="FI">Finland</option>
                                                                                <option value="FR">France</option>
                                                                                <option value="FX">France, Metropolitan</option>
                                                                                <option value="GF">French Guiana</option>
                                                                                <option value="PF">French Polynesia</option>
                                                                                <option value="TF">French Southern Territories</option>
                                                                                <option value="GA">Gabon</option>
                                                                                <option value="GM">Gambia</option>
                                                                                <option value="GE">Georgia</option>
                                                                                <option value="DE">Germany</option>
                                                                                <option value="GH">Ghana</option>
                                                                                <option value="GI">Gibraltar</option>
                                                                                <option value="GR">Greece</option>
                                                                                <option value="GL">Greenland</option>
                                                                                <option value="GD">Grenada</option>
                                                                                <option value="GP">Guadeloupe</option>
                                                                                <option value="GU">Guam</option>
                                                                                <option value="GT">Guatemala</option>
                                                                                <option value="GN">Guinea</option>
                                                                                <option value="GW">Guinea-Bissau</option>
                                                                                <option value="GY">Guyana</option>
                                                                                <option value="HT">Haiti</option>
                                                                                <option value="HN">Honduras</option>
                                                                                <option value="HK">Hong Kong</option>
                                                                                <option value="HU">Hungary</option>
                                                                                <option value="IS">Iceland</option>
                                                                                <option value="IN">India</option>
                                                                                <option value="ID">Indonesia</option>
                                                                                <option value="IR">Iran (Islamic Republic of)</option>
                                                                                <option value="IQ">Iraq</option>
                                                                                <option value="IE">Ireland</option>
                                                                                <option value="IL">Israel</option>
                                                                                <option value="IT">Italy</option>
                                                                                <option value="JM">Jamaica</option>
                                                                                <option value="JP">Japan</option>
                                                                                <option value="JO">Jordan</option>
                                                                                <option value="KZ">Kazakhstan</option>
                                                                                <option value="KE">Kenya</option>
                                                                                <option value="KI">Kiribati</option>
                                                                                <option value="KR">Korea, Republic of</option>
                                                                                <option value="KW">Kuwait</option>
                                                                                <option value="KG">Kyrgyzstan</option>
                                                                                <option value="LV">Latvia</option>
                                                                                <option value="LB">Lebanon</option>
                                                                                <option value="LS">Lesotho</option>
                                                                                <option value="LR">Liberia</option>
                                                                                <option value="LY">Libyan Arab Jamahiriya</option>
                                                                                <option value="LI">Liechtenstein</option>
                                                                                <option value="LT">Lithuania</option>
                                                                                <option value="LU">Luxembourg</option>
                                                                                <option value="MO">Macau</option>
                                                                                <option value="MG">Madagascar</option>
                                                                                <option value="MW">Malawi</option>
                                                                                <option value="MY">Malaysia</option>
                                                                                <option value="MV">Maldives</option>
                                                                                <option value="ML">Mali</option>
                                                                                <option value="MT">Malta</option>
                                                                                <option value="MH">Marshall Islands</option>
                                                                                <option value="MQ">Martinique</option>
                                                                                <option value="MR">Mauritania</option>
                                                                                <option value="MU">Mauritius</option>
                                                                                <option value="YT">Mayotte</option>
                                                                                <option value="MX">Mexico</option>
                                                                                <option value="FM">Micronesia, Federated States of</option>
                                                                                <option value="MD">Moldova, Republic of</option>
                                                                                <option value="MC">Monaco</option>
                                                                                <option value="MN">Mongolia</option>
                                                                                <option value="MS">Montserrat</option>
                                                                                <option value="MA">Morocco</option>
                                                                                <option value="MZ">Mozambique</option>
                                                                                <option value="MM">Myanmar</option>
                                                                                <option value="NA">Namibia</option>
                                                                                <option value="NR">Nauru</option>
                                                                                <option value="NP">Nepal</option>
                                                                                <option value="NL">Netherlands</option>
                                                                                <option value="AN">Netherlands Antilles</option>
                                                                                <option value="NC">New Caledonia</option>
                                                                                <option value="NZ">New Zealand</option>
                                                                                <option value="NI">Nicaragua</option>
                                                                                <option value="NE">Niger</option>
                                                                                <option value="NG">Nigeria</option>
                                                                                <option value="NU">Niue</option>
                                                                                <option value="NF">Norfolk Island</option>
                                                                                <option value="MP">Northern Mariana Islands</option>
                                                                                <option value="NO">Norway</option>
                                                                                <option value="OM">Oman</option>
                                                                                <option value="PK">Pakistan</option>
                                                                                <option value="PW">Palau</option>
                                                                                <option value="PA">Panama</option>
                                                                                <option value="PG">Papua New Guinea</option>
                                                                                <option value="PY">Paraguay</option>
                                                                                <option value="PE">Peru</option>
                                                                                <option value="PH">Philippines</option>
                                                                                <option value="PN">Pitcairn</option>
                                                                                <option value="PL">Poland</option>
                                                                                <option value="PT">Portugal</option>
                                                                                <option value="PR">Puerto Rico</option>
                                                                                <option value="QA">Qatar</option>
                                                                                <option value="RE">Reunion</option>
                                                                                <option value="RO">Romania</option>
                                                                                <option value="RU">Russian Federation</option>
                                                                                <option value="RW">Rwanda</option>
                                                                                <option value="KN">Saint Kitts and Nevis</option> 
                                                                                <option value="LC">Saint LUCIA</option>
                                                                                <option value="VC">Saint Vincent and the Grenadines</option>
                                                                                <option value="WS">Samoa</option>
                                                                                <option value="SM">San Marino</option>
                                                                                <option value="ST">Sao Tome and Principe</option> 
                                                                                <option value="SA">Saudi Arabia</option>
                                                                                <option value="SN">Senegal</option>
                                                                                <option value="SC">Seychelles</option>
                                                                                <option value="SL">Sierra Leone</option>
                                                                                <option value="SG">Singapore</option>
                                                                                <option value="SK">Slovakia (Slovak Republic)</option>
                                                                                <option value="SI">Slovenia</option>
                                                                                <option value="SB">Solomon Islands</option>
                                                                                <option value="SO">Somalia</option>
                                                                                <option value="ZA">South Africa</option>
                                                                                <option value="ES">Spain</option>
                                                                                <option value="LK">Sri Lanka</option>
                                                                                <option value="SH">St. Helena</option>
                                                                                <option value="PM">St. Pierre and Miquelon</option>
                                                                                <option value="SD">Sudan</option>
                                                                                <option value="SR">Suriname</option>
                                                                                <option value="SJ">Svalbard and Jan Mayen Islands</option>
                                                                                <option value="SZ">Swaziland</option>
                                                                                <option value="SE">Sweden</option>
                                                                                <option value="CH">Switzerland</option>
                                                                                <option value="SY">Syrian Arab Republic</option>
                                                                                <option value="TW">Taiwan, Province of China</option>
                                                                                <option value="TJ">Tajikistan</option>
                                                                                <option value="TZ">Tanzania, United Republic of</option>
                                                                                <option value="TH">Thailand</option>
                                                                                <option value="TG">Togo</option>
                                                                                <option value="TK">Tokelau</option>
                                                                                <option value="TO">Tonga</option>
                                                                                <option value="TT">Trinidad and Tobago</option>
                                                                                <option value="TN">Tunisia</option>
                                                                                <option value="TR">Turkey</option>
                                                                                <option value="TM">Turkmenistan</option>
                                                                                <option value="TC">Turks and Caicos Islands</option>
                                                                                <option value="TV">Tuvalu</option>
                                                                                <option value="UG">Uganda</option>
                                                                                <option value="UA">Ukraine</option>
                                                                                <option value="AE" selected>United Arab Emirates</option>
                                                                                <option value="GB">United Kingdom</option>
                                                                                <option value="US">United States</option>
                                                                                <option value="UM">United States Minor Outlying Islands</option>
                                                                                <option value="UY">Uruguay</option>
                                                                                <option value="UZ">Uzbekistan</option>
                                                                                <option value="VU">Vanuatu</option>
                                                                                <option value="VE">Venezuela</option>
                                                                                <option value="VN">Viet Nam</option>
                                                                                <option value="VG">Virgin Islands (British)</option>
                                                                                <option value="VI">Virgin Islands (U.S.)</option>
                                                                                <option value="WF">Wallis and Futuna Islands</option>
                                                                                <option value="EH">Western Sahara</option>
                                                                                <option value="YE">Yemen</option>
                                                                                <option value="YU">Yugoslavia</option>
                                                                                <option value="ZM">Zambia</option>
                                                                                <option value="ZW">Zimbabwe</option>
                                                                            </select>
                                                                            <div class="invalid-feedback">
                                                                            Please select country
                                                                            </div>
                                                                        </div>
                                                                            
                                                                        <div class="col-md-4 mt-3">
                                                                            <label class="form-label">Company/Institution</label>
                                                                            <input type="text" class="form-control input-style" name="company" required title="Enter company name ">
                                                                            <div class="invalid-feedback">
                                                                            Enter company name 
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4 mt-3">
                                                                            <label class="form-label">Job Title</label>
                                                                            <input type="text" class="form-control input-style" name="designation" required title="Enter job title ">
                                                                            <div class="invalid-feedback">
                                                                            Enter job title 
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="col-md-4 mt-3">
                                                                            <label class="form-label">Contact Number</label>
                                                                            <input type="text" class="form-control input-style" title="Enter valid contact number" required name="phone" pattern="[0-9]{1,10}" maxlength="10">
                                                                            <div class="invalid-feedback">
                                                                            Enter valid contact number
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4 mt-3">
                                                                            <label class="form-label">Ticket</label>
                                                                            <select name="ticketchoose" class="form-control input-style" required>
                                                                                <?php
                                                                                    $resTicket = mysqli_query($conn, "SELECT * FROM ticket_master");
                                                                                    if(mysqli_num_rows($resTicket) > 0) {

                                                                                        while($rowTicket =  mysqli_fetch_assoc($resTicket)){

                                                                                            echo "<option value='$rowTicket[TT_Id]'>$rowTicket[Ticket]</option>";
                                                                                        }
                                                                                    } else {
                                                                                        echo "<option value=''>Choose..</option>";
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                            <div class="invalid-feedback">
                                                                            Please select country
                                                                            </div>
                                                                        </div>

                                                                        <input type="hidden" name="eid" value="<?php echo $rowd6['EM_Id'];?>">
                                                                        <input type="hidden" name="ecode" value="<?php echo $rowd6['EventCode'];?>">

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-success" name="submit">Submit</button>
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

<script>
//     function copyLink(data, data1) {
        
//   navigator.clipboard.writeText('sss');
//   alert("Successfully copied the text")

//         navigator.clipboard.writeText('newClip').then(function() {
            
//             alert('pa')
//         }, function() {
            
//             alert('hi')
//         });

// alert('js')

        // alert(data1)
        // navigator.clipboard.writeText(data);
        
        // document.getElementById("linktext"+data1).innerHTML = "Copied";

        // setTimeout(function(){
        //     document.getElementById("linktext"+data1).innerHTML = "";
        // }, 3000);
    // }
</script>

<?php
    require_once './pages/footer.php';
?>