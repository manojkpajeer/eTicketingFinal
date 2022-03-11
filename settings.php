<?php 
    session_start();

    require_once './config/connection.php';
    require_once './pages/link.php';
    require_once './pages/header.php';

    if(!isset($_SESSION['is_customer_login'])) {

        echo "<script>location.href='login.php';</script>";
    } else {
        if(!$_SESSION['is_customer_login']){

            echo "<script>location.href='login.php';</script>";
        }
    }

    if (isset($_POST['submit'])) {
        $opassword = $_POST['opassword'];
        $npassword = $_POST['npassword'];
        $cpassword = $_POST['cpassword'];
        
        if ($npassword == $cpassword) {

            $resPassword = mysqli_query($conn, "SELECT UserPassword FROM login_master WHERE UserEmail = '$_SESSION[user_email]' AND UserRole = 'Customer'");

            if (mysqli_num_rows($resPassword) > 0) {

                $resPassword = mysqli_fetch_assoc($resPassword);

                if ($opassword == $resPassword['UserPassword']) {

                    if (mysqli_query($conn, "UPDATE login_master SET UserPassword = '$npassword' WHERE UserEmail = '$_SESSION[user_email]' AND UserRole = 'Customer'")) {

                        echo "<script>alert('Yay, Password updated successfully..');</script>";
                    } else {

                        echo "<script>alert('Oops, Unable to update password..');</script>";
                    }
                } else {

                    echo "<script>alert('Oops, Invalid current password..');</script>";
                }
            } else {

                echo "<script>alert('Oops, Unable to process..');</script>";
            }
        } else {

            echo "<script>alert('Oops, Password mis-match..');</script>";
        }
    }
?>

<section class="w3l-forms-23" style="background: url(assets/images/banner-3.jpg) no-repeat center fixed;">
    <div id="forms23-block">
        <div class="wrapper">
            <div class="d-grid forms23-grids">
                <div class="form23">
                    <h6>Change Your Password</h6>
                    <form action="" method="POST" class="row needs-validation" novalidate>
                        <label class="form-label text-light">Current Password</label>
                        <input type="password" class="form-control input-style" name="opassword" required maxlength="24" pattern=".{6,}">
                        <div class="invalid-feedback">
                            6 or more characters
                        </div>

                        <label class="form-label mt-3 text-light">New Password</label>
                        <input type="password" class="form-control input-style" name="npassword" required maxlength="24" pattern=".{6,}">
                        <div class="invalid-feedback">
                            6 or more characters
                        </div>

                        <label class="form-label mt-3  text-light">Confirm Password</label>
                        <input type="password" class="form-control input-style" name="cpassword" required maxlength="24" pattern=".{6,}">
                        <div class="invalid-feedback">
                            6 or more characters
                        </div>

                        <button class="actionbg button-cover-9 mt-4" name="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
       
    </div>
</section>

<?php
    require_once './pages/footer.php';
?>