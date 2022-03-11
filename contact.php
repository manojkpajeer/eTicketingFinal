<?php 
    session_start();

    require_once './config/connection.php';
    require_once './pages/link.php';
    require_once './pages/header.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    if (isset($_POST['submit'])) {
        $name = $_POST['cname'];
        $email = $_POST['cemail'];
        $subject = $_POST['csubject'];
        $message = $_POST['cmessage'];

        if (mysqli_query($conn, "INSERT INTO contact_master (CustomerName, CustomerEmail, Subject, Message, Status, DateCreate) VALUES ('$name', '$email', '$subject', '$message', 1, NOW()) ")) {

            sendEmail($name, $email);
            sendEmailToAdmin($name, $email,$subject, $message);

            echo "<script>alert('Yay, Your form submitted successfully..');</script>";
        } else {

            echo "<script>alert('Oops, Unable to process..');</script>";
        }
    }

    function sendEmail($name, $email){
        $mail = new PHPMailer(true);

        try {                   
            $mail->isSMTP();                                           
            $mail->Host       = 'smtp.zoho.com';                    
            $mail->SMTPAuth   = true;                                  
            $mail->Username   = 'support@dxbtickets.com';                    
            $mail->Password   = 'Sujipri@28';                               
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

    function sendEmailToAdmin($name, $email, $subject, $message){
        $mail = new PHPMailer(true);

        try {                   
            $mail->isSMTP();                                           
            $mail->Host       = 'smtp.zoho.com';                    
            $mail->SMTPAuth   = true;                                  
            $mail->Username   = 'support@dxbtickets.com';                    
            $mail->Password   = 'Sujipri@28';                               
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
            $mail->Port       = 465;                                  
        
            $mail->setFrom('support@dxbtickets.com', "DXB Tickets");
            $mail->addAddress("info@dxbtickets.com", "Admin");
        
            $mail->IsHTML(true);
            $mail->Subject = "Query from DXB Tickets customer";
            $mail->Body = "hi admin<br>We have recieved a query request from DXB customers<br>
                            Name : ".$name."<br>Email Id : ".$email."<br>Subject : ".$subject."<br>Message : ".$message."<br><br>Team DXB Tickets</strong>";
        
            $mail->send();
        } catch (Exception $e) {
            
        }
    }
?>


<section class="w3l-contacts-9-main" id="contact">
    <div class="contacts-9">
        <div class="wrapper">
            <div class="section-title align-center text-center">    
                <h4>Conatct Us For Info</h4>
            </div>
                <div class="top-map">
                <div class="cont-details">
                    <h4>Maestro Events</h4>
                      <div class="cont-top">
                          <div class="cont-left">
                              <span class="fa fa-phone"></span>
                          </div>
                          <div class="cont-right">
                              <h6>Phone Us</h6>
                              <p><a href="tel:+97-155-120-0104">+(97) 155-120-0104</a></p>
                              
                        </div>
                      </div>
                      <div class="cont-top">
                            <div class="cont-left">
                                <span class="fa fa-clock-o"></span>
                            </div>
                            <div class="cont-right">
                                <h6>Email Us</h6>
                                <p><a href="mailto:example-mail@support.com" class="mail">info@maestroevents.ae</a></p>
                          </div>
                        </div>
                        <div class="cont-top">
                                <div class="cont-left">
                                    <span class="fa fa-map-marker"></span>
                                </div>
                                <div class="cont-right">
                                   <h6>Address</h6>
                                    <p>Office M-02, DNI Building
                                    Above RAK Bank, Sheikh Zayed Road
                                    Post Box 7687, Dubai, U.A.E</p>
                              </div>
                            </div>

                            
                    </div>
                    <div class="map-content-9">
                        <form method="post">
                            <div class="twice-two">
                                <input type="text" name="cname" id="w3lName"  placeholder="Name" required="">
                                <input type="email" name="cemail" id="w3lSender" placeholder="Email" required="">
                            </div>
                            <div class="twice"> 
                                <input type="text" name="csubject" id="w3lName"  placeholder="Subject" required="">
                            </div>
                            <textarea name="cmessage" id="w3lMessage" placeholder="Message" required=""></textarea>
                            <button type="submit" name="submit">Send Message</button>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</section>


<?php
    require_once './pages/newsletter.php';
    require_once './pages/footer.php';
?>