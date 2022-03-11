<?php
    session_start();
        
    if(!isset($_SESSION['is_staff_login'])){
        header('Location: ./pages/logout.php');
    }
    else{
        if(!$_SESSION['is_staff_login']){
            header('Location: ./pages/logout.php');
        }
    }
        
    require_once '../config/connection.php';
    require_once './pages/link.php';
    require_once './pages/sidebar.php';
    require_once './pages/header.php';

    if(isset($_POST['update'])){
        if($_POST['npassword']!=$_POST['cpassword']){
            echo "<script>alert('Oops, The password confirmation does not match..');</script>";
        }
        else{
            $opass = $_POST['opassword'];
            $npass = $_POST['npassword'];

            $res1 = mysqli_query($conn, "SELECT LM_Id FROM login_master WHERE UserEmail = '$_SESSION[user_email]' AND UserPassword = '$opass' AND UserRole = 'Staff'");
            if(mysqli_num_rows($res1)>0){
                $row1 = mysqli_fetch_assoc($res1);
                if(mysqli_query($conn, "UPDATE login_master SET UserPassword = '$npass' WHERE LM_Id = ' " . $row1['LM_Id'] ."'")){
                    echo "<script>alert('Yay, Your password updated successfully..');</script>";
                }
                else{
                    echo "<script>alert('Oops, Unable to process your request..');</script>";
                }
            }
            else{
                echo "<script>alert('Oops, An invalid current password..');</script>";
            }
        }
        
    } 
?>


<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="row">
            <div class="col-xl-12 pr-xl-12">
                <div class="card card_border border-primary-top">
                    <div class="card-header chart-grid__header">Change Password</div>
                    <div class="card-body">
                        <form method="post" class="g-3 needs-validation" novalidate>
                            <div class="form-group w-50">
                                <label for="exampleInputPassword1" class="form-label">Current Password</label>
                                <input type="password" class="form-control input-style" id="exampleInputPassword1" required name="opassword" pattern=".{6,}">
                                <div class="invalid-feedback">
                                    Old password must be 6 or more characters
                                </div>
                            </div>
                            <div class="form-group w-50">
                                <label for="exampleInputPassword1" class="form-label">New Password</label>
                                <input type="password" class="form-control input-style" id="newPassword" required name="npassword" pattern=".{6,}">
                                <div class="invalid-feedback">
                                    New password must be 6 or more characters
                                </div>
                            </div>
                            <div class="form-group w-50">
                                <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control input-style" id="confirmPassword" required name="cpassword" pattern=".{6,}">
                                <div class="invalid-feedback">
                                    Confirm password must be 6 or more characters
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2 btn-style" name="update">Save</button>
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