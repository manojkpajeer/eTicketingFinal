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

    $resacc = mysqli_query($conn, "SELECT * FROM staff_master WHERE ST_Id = $_SESSION[st_id]");
    if(mysqli_num_rows($resacc) > 0) {
        $resacc = mysqli_fetch_assoc($resacc);
    } else {
        echo "<script>alert('Oops, Unable to process..');</scripr>";
    }

    if (isset($_POST['update'])) {
        if (mysqli_query($conn, "UPDATE staff_master SET FullName = '$_POST[full_name]', StaffPhone = '$_POST[phone]', Address = '$_POST[address]' WHERE ST_Id = ' " . $_SESSION['st_id'] . " '")){
            echo "<script>alert('Yay, Account updated successfully..');location.href='account.php';</script>";
        } else {
            echo "<script>alert('Oops, Unable to process your request..');</script>";
        }
    }
?>


<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="row">
            <div class="col-xl-12 pr-xl-12">
                <div class="card card_border border-primary-top">
                    <div class="card-header chart-grid__header">Your Account</div>
                    <div class="card-body">
                        <form method="post" class="g-3 needs-validation row" novalidate>
                            <div class="col-md-5">
                                <label for="validationCustom01" class="form-label">Full Name</label>
                                <input type="text" value="<?php echo $resacc['FullName'];?>" required class="form-control input-style" name="full_name" pattern="[A-Za-z]{1,49}">
                                <div class="invalid-feedback">
                                    Please enter valid name
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label for="validationCustom02" class="form-label">Email ID</label>
                                <input type="email" value="<?php echo $resacc['EmailId'];?>" class="form-control input-style" readonly>
                                <div class="invalid-feedback">
                                Please enter valid email id
                                </div>
                            </div>
                            <div class="col-md-5 mt-4">
                                <label for="validationCustom02" class="form-label">Phone Number</label>
                                <input type="text" value="<?php echo $resacc['StaffPhone'];?>" class="form-control input-style" required name="phone" pattern="[0-9]{1,10}" maxlength="10">
                                <div class="invalid-feedback">
                                Please enter valid phone number
                                </div>
                            </div>
                                
                            <div class="col-md-5 mt-4">
                                <label for="validationCustom02" class="form-label">Address</label>
                                <textarea class="form-control input-style" required name="address"><?php echo $resacc['Address'];?></textarea>
                                <div class="invalid-feedback">
                                Please enter address
                                </div>
                            </div>                                
                                
                            <div class="d-flex align-items-center flex-wrap justify-content-between col-12">
                                <button type="submit" class="btn btn-primary btn-style mt-4" name="update">Update Account</button>
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