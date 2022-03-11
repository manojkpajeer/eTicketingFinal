<?php 
    session_start();

    if(isset($_SESSION['is_customer_login'])){

        if($_SESSION['is_customer_login']){
            
            header('Location: index.php');
        }
    }

    require_once './config/connection.php';

    if (isset($_POST['login'])) {
        $password = $_POST['password'];
        $email = $_POST['email'];

        $res = mysqli_query($conn, "SELECT login_master.UserPassword, customer_master.CM_Id, customer_master.CustomerId, customer_master.AccountNo FROM login_master JOIN customer_master ON customer_master.CustomerEmail = login_master.UserEmail WHERE login_master.UserEmail = '$email' AND customer_master.CustomerStatus = 1 AND login_master.UserRole = 'Customer'");
        if (mysqli_num_rows($res)>0) {

            $row = mysqli_fetch_assoc($res);
            if ($password == $row['UserPassword']) {

                $ip_address = $_SERVER['REMOTE_ADDR'];

                if (mysqli_query($conn, "INSERT INTO log_master (UserId, UserRole, IPAddress, CreateDate) 
                    VALUES ('$row[CM_Id]', 'Customer', '$ip_address', NOW())")) {

                    $_SESSION['cm_id'] = $row['CM_Id'];
                    $_SESSION['user_role'] = 'Customer';
                    $_SESSION['user_email'] = $email;
                    $_SESSION['is_customer_login'] = true;
                    $_SESSION['customer_id'] = $row['CustomerId'];
                    $_SESSION['account_no'] = $row['AccountNo'];

                    header('Location: index.php');
                } else {
                    
                    echo "<script>alert('Oops, Unable to process..');</script>";
                }
            }
            else{
                echo "<script>alert('Oops, An invalid password you entered..');</script>";            
            }            
        }
        else{
            echo "<script>alert('Oops, An email does not exist on inactive..');</script>";
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
                    <h6>Log into your account</h6>
                    <form action="" method="POST" class="g-3 row needs-validation" novalidate>
                        <div class="col-12">
                            <input type="email" placeholder="Email ID" class="form-control" required name="email" maxlength="245">
                            <div class="invalid-feedback">
                            Please enter valid email id
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="password" placeholder="Password" class="form-control" required name="password" maxlength="25">
                            <div class="invalid-feedback">
                            Please enter valid password
                            </div>
                        </div>
                        <div class="col-12">
                            <h5>Forgot your password? <a href="forgot.php" class="text-info"> Reset</a></h5>
                            <button type="submit" name="login">Login</button>
                        </div>
                        <div class="col-12 text-right">
                            <h5>Not a member yet? <a href="signup.php" class="text-info"> Register now</a></h5>
                        </div>
                    </form>
                </div>
            </div>
        </div>
       
    </div>
</section>
<!-- Forms23 block -->

<?php
    require_once './pages/footer.php';
?>