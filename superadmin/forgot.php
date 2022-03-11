<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    $mail = new PHPMailer(true);

    session_start();

    if(isset($_SESSION['is_admin_login'])){
        if($_SESSION['is_admin_login']){
            header('Location: home.php');
        }
    }

    require_once '../config/connection.php';

    if (isset($_POST['reset'])) {
        $email = $_POST['email'];

        $res = mysqli_query($conn, "SELECT login_master.UserPassword, admin_master.FullName  FROM login_master JOIN admin_master ON admin_master.AdminEmail = login_master.UserEmail WHERE login_master.UserEmail = '$email' AND admin_master.AdminStatus = 1");
        if (mysqli_num_rows($res)>0) {

            $row = mysqli_fetch_assoc($res); 
            $customerName = $row['FullName'];

            try {                   
                $mail->isSMTP();                                           
                $mail->Host       = 'smtp.zoho.com';                    
                $mail->SMTPAuth   = true;                                  
                $mail->Username   = 'support@dxbtickets.com';                    
                $mail->Password   = 'Sujipri@28';                               
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
                $mail->Port       = 465;                                  
            
                $mail->setFrom('support@dxbtickets.com', "DXB Tickets");
                $mail->addAddress($email, $customerName);
                
                // $mail->addAttachment('mailer-image/image.jpg', 'recovery.jpg');  
            
                $mail->IsHTML(true);
                $mail->Subject = "Password reset email - DXB Tickets";
                $mail->Body = 'hi ' . $customerName . "<br>We received a request to reset the password for your account.<br> Your password is <strong>" . $row['UserPassword'] . "</strong><br>We recomend that you keep your password safe and do not share with anyone. <br>Thank You<br><strong>Team DXB Tickets</strong>";
            
                if ($mail->send()) {
                    echo "<script>alert('Yay, We sent an email to recover your password..');location.href='index.php';</script>";
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
    
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Maestro Events</title>

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-liberty.css">

    <!-- google fonts -->
    <link href="//fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Site Icon -->
    <link rel="icon" href="assets/images/tab_image.png">
</head>

<body class="sidebar-menu-collapsed">
    <div class="container-fluid" style="background-color: white;">
        <div class="row">
            <div class="col-4">
                <div class="card-body mx-md-4 pt-4 mt-5">
                    <div class="text-center">
                        <h3 class="text-primary number text-center mt-5">WELCOME</h3>
                    </div>
                    <form method="post" class="needs-validation mt-5" novalidate>
                        <div class="form-group">
                            <label class="input__label">Email ID</label>
                            <input type="email" class="form-control input-style" placeholder="Enter Email ID" name="email" required>
                            <div class="invalid-feedback">
                                Please enter valid email id.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-lg" name="reset">Reset</button>
                        <p class="signup mt-4">Remember your password? <a href="index.php" class="signuplink">Login</a></p>
                    </form>
                </div>
            </div>
            <div class="col-8">
                <img src="assets/images/login_image.png" alt="Meastro Events" class="w-100 vh-100" style="object-fill: cover; object-position: left;">
            </div>
        </div>
    </div>
    <script>
        (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')

        Array.prototype.slice.call(forms)
            .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
            })
        })()
    </script>
</body>
</html>
