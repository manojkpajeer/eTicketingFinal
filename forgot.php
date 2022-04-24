<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    $mail = new PHPMailer(true);

    session_start();

    if(isset($_SESSION['is_customer_login'])){
        if($_SESSION['is_customer_login']){
            header('Location: index.php');
        }
    }

    require_once './config/connection.php';

    if (isset($_POST['reset'])) {
        $email = $_POST['email'];

        $res = mysqli_query($conn, "SELECT login_master.UserPassword, customer_master.Saluation, customer_master.FirstName, customer_master.LastName  FROM login_master JOIN customer_master ON customer_master.CustomerEmail = login_master.UserEmail WHERE login_master.UserEmail = '$email' AND customer_master.CustomerStatus = 1");
        if (mysqli_num_rows($res)>0) {

            $row = mysqli_fetch_assoc($res); 
            $customerName = $row['Saluation'] . ". " . $row['FirstName'] . " " .$row['LastName'];

            try {                   
                $mail->isSMTP();                                           
                $mail->Host       = 'smtp.zoho.com';                    
                $mail->SMTPAuth   = true;                                  
                $mail->Username   = 'support@dxbtickets.com';                    
                $mail->Password   = 'Sujith104';                               
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
                $mail->Port       = 465;                                  
            
                $mail->setFrom('support@dxbtickets.com', "DXB Tickets");
                $mail->addAddress($email, $customerName);
                
                // $mail->addAttachment('mailer-image/image.jpg', 'recovery.jpg');
            
                $mail->IsHTML(true);
                $mail->Subject = "Password reset email - Maestro Events";
                $mail->Body = 'hi ' . $customerName . "<br>We received a request to reset the passowrd for your account.<br> Your password is <strong>" . $row['UserPassword'] . "</strong><br>We recomend that you keep your password safe and do not share with anyone. <br>Thank You<br><strong>Team DXB Tickets</strong>";
            
                if ($mail->send()) {
                    echo "<script>alert('Yay, We sent an email to recover your password..');location.href='login.php';</script>";
                } else {
                    echo "<script>alert('Oops, Unable to process your request ..');</script>";
                }
            } catch (Exception $e) {
                echo "<script>alert('Oops, Unable to process your request..');</script>";
            }
        }
        else{
            echo "<script>alert('Oops, Email does not exist on inactive..');</script>";
        }
    }
    
    require_once './pages/link.php';
?>

<!-- Forms23 block -->
<section class="w3l-forms-23" style="background: url(assets/images/banner-3.jpg) no-repeat center fixed;">
    <div id="forms23-block">            
        <div class="wrapper">
            <div class="d-grid forms23-grids">    
                <div class="logo1 mb-3">
                    <a class="brand-logo" href="index.php">
                        <img src="./assets/images/dxblogo2.png" alt="logo" title="logo" class="img-fluid" style="width: 70%;" />
                    </a>
                </div>   
                <div class="form23">
                    <h6>Forgot your password?</h6>
                        <form action="" method="POST" class="g-3 row needs-validation" novalidate>
                            <div class="col-12">
                                <input type="email" placeholder="Email ID" class="form-control" required name="email" maxlength="245">
                                <div class="invalid-feedback">
                                Please enter valid email id
                                </div>
                                
                                <button type="submit" name="reset" class="mt-3">Submit</button>
                            </div>
                    </form>
                    <h5>Remember your password? <a href="login.php" class="text-info">Login now</a></h5>
                </div>
            </div>
        </div>
       
    </div>
</section>
<!-- Forms23 block -->

<?php
    require_once './pages/footer.php';
?>