<?php 
    session_start();

    if(isset($_SESSION['is_ajent_login'])){
        if($_SESSION['is_ajent_login']){
            header('Location: home.php');
        }
    }

    require_once '../config/connection.php';

    if (isset($_POST['login'])) {
        $password = $_POST['password'];
        $email = $_POST['email'];

        $res = mysqli_query($conn, "SELECT login_master.UserPassword, ajent_master.FullName, ajent_master.AJM_Id FROM login_master JOIN ajent_master ON ajent_master.AjentEmail = login_master.UserEmail WHERE login_master.UserEmail = '$email' AND ajent_master.AjentStatus = 1 AND login_master.UserRole = 'Agent'");
        if (mysqli_num_rows($res)>0) {

            $row = mysqli_fetch_assoc($res);
            if ($password == $row['UserPassword']) {

                $ip_address = $_SERVER['REMOTE_ADDR'];

                if (mysqli_query($conn, "INSERT INTO log_master (UserId, UserRole, IPAddress, CreateDate) 
                    VALUES ('$row[AJM_Id]', 'Agent', '$ip_address', NOW())")) {

                    unset($_SESSION['wrongPassword']);
                    unset($_SESSION['wrongUser']);

                    $_SESSION['ajm_id'] = $row['AJM_Id'];
                    $_SESSION['user_role'] = 'Agent';
                    $_SESSION['user_email'] = $email;
                    $_SESSION['is_ajent_login'] = true;
                    $_SESSION['FullName'] = $row['FullName'];   

                    header('Location: home.php');
                } else {
                        
                    echo "<script>alert('Oops, Unable to process..');</script>";
                }
            }
            else{

                if (isset($_SESSION['wrongPassword']) && isset($_SESSION['wrongUser'])) {

                    if($_SESSION['wrongPassword'] && $_SESSION['wrongUser'] == $email) {

                        if(mysqli_query($conn, "UPDATE ajent_master SET AjentStatus = false WHERE AJM_Id = '$row[AJM_Id]'")){

                            unset($_SESSION['wrongPassword']);
                            unset($_SESSION['wrongUser']);

                            echo "<script>alert('Oops, An invalid credentials, Your account has been De-Activated..');</script>";
                        } else {

                            echo "<script>alert('Oops, Unable to process..');</script>";
                        }
                        
                    } else {

                        $_SESSION['wrongPassword'] = true;
                        $_SESSION['wrongUser'] = $email;

                        echo "<script>alert('Oops, An invalid credentials, 1 attempt remaining..');</script>";
                    }

                } else {

                    $_SESSION['wrongPassword'] = true;
                    $_SESSION['wrongUser'] = $email;

                    echo "<script>alert('Oops, An invalid credentials, 1 attempt remaining..');</script>";
                }            
            }            
        }
        else{
            
            echo "<script>alert('Oops, An email does not exist on inactive..');</script>";
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
                        <h3 class="text-primary number text-center mt-5 pt-5">WELCOME</h3>
                    </div>
                    <form method="post" class="needs-validation mt-5" novalidate>
                        <div class="form-group">
                            <label class="input__label">Email ID</label>
                            <input type="email" class="form-control input-style" placeholder="Enter Email ID" name="email" required>
                            <div class="invalid-feedback">
                                Please enter valid email id.
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="input__label">Password</label>
                            <input type="password" class="form-control input-style" placeholder="Enter Password" name="password" required>
                            <div class="invalid-feedback">
                                Please enter password.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-lg" name="login">Login</button>
                        <p class="signup mt-4">Forgot your password? <a href="forgot.php" class="signuplink">Reset</a></p>
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

   