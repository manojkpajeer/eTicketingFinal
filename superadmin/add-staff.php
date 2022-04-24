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

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';
        
    require_once '../config/connection.php';
    require_once './pages/link.php';
    require_once './pages/sidebar.php';
    require_once './pages/header.php';
    
    if(isset($_POST['add'])){

        if(mysqli_query($conn, "INSERT INTO staff_master(FullName, EmailId, StaffStatus, DateCreate, StaffPhone, Address, ProfileImage) 
            VALUES ('$_POST[name]', '$_POST[email]', 1, NOW(), '$_POST[phone]', '$_POST[address]', 'assets/images/profileimg.jpg')")){

            $password = "PSW" . rand(1000, 9999);

            if (mysqli_query($conn, "INSERT INTO login_master (UserEmail, UserPassword, UserRole) VALUES ('$_POST[email]', '$password', 'Staff')")) {
                                        
                sendEmail($_POST['name'], $_POST['email'], $password);

            } else {
                
                echo "<script>alert('Oops, Unable to add admin..');</script>";
            }    
        }
        else{

            echo "<script>alert('Oops, Unable to add admin..');</script>";
        }
    }

    function sendEmail($name, $email, $password) {
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
            
            // $mail->addAttachment('mailer-image/staff-creation.jpg', 'recovery.jpg');
        
            $mail->IsHTML(true);
            $mail->Subject = "Admin Creation - DXB Tickets";
            $mail->Body = 'hi ' . $name . "<br>We received a saff creation request.<br> Your password is <strong>" . $password . "</strong><br>We recomend that you keep your password safe and do not share with anyone. <br>Thank You<br><strong>Team DXB Tickets</strong>";
        
            if ($mail->send()) {

                echo "<script>alert('Yay, Admin created successfully..');</script>";
            } else {
                
                echo "<script>alert('Oops, Admin Created successfully but unable to send an email..');</script>";
            }
        } catch (Exception $e) {
            
            echo "<script>alert('Oops, Admin Created successfully but unable to send an email..');</script>";
        }
    }
?>

<!-- main content start -->
<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="row">
            <div class="col-xl-12 pr-xl-12">
                <div class="card card_border border-primary-top">
                <div class="card-header chart-grid__header float-left">Add Admin</div>
                    <div class="card-body">
                    <form method="post" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                        <div class="col-md-4">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control input-style" required name="name">
                            <div class="invalid-feedback">
                            Please enter a admin name
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email ID</label>
                            <input type="email" class="form-control input-style" required name="email">
                            <div class="invalid-feedback">
                            Please enter valid email id
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Phone No</label>
                            <input type="text" class="form-control input-style" required name="phone" pattern="[0-9]{1,10}" maxlength="10">
                            <div class="invalid-feedback">
                            Please enter valid phone
                            </div>
                        </div>

                        <div class="col-md-6 mt-4">
                            <label class="form-label">Address</label>
                            <textarea class="form-control input-style" name="address" required></textarea>
                            <div class="invalid-feedback">
                            Please enter address
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