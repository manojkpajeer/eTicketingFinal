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
        
    require_once '../config/connection.php';
    require_once './pages/link.php';
    require_once './pages/sidebar.php';
    require_once './pages/header.php';

    if (isset($_GET['did'])) {
        
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

    if (isset($_POST['update'])) { 

        if (mysqli_query($conn, "UPDATE staff_master SET FullName = '$_POST[name]', StaffStatus = '$_POST[status]',
            StaffPhone = '$_POST[phone]', Address = '$_POST[address]' WHERE ST_Id = '$_POST[sid]'")) {

            echo "<script>alert('Yay, Admin updated successfully..');</script>";     
        } else {

            echo "<script>alert('Oops, Unable to update admin..');</script>";
        }
    }
?>

<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="data-tables">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card card_border p-4 border-primary-top">
                        <h3 class="card__title position-absolute">Manage Admin</h3>
                        <div class="table-responsive">
                            <table id="meastroTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Profile</th>
                                        <th>Full Name</th>
                                        <th>Email Id</th>
                                        <th>Phone</th>
                                        <th>Created On</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $resd6 = mysqli_query($conn, "SELECT * FROM staff_master ORDER BY ST_Id DESC");
                                        if (mysqli_num_rows($resd6) > 0) {

                                            $count = 1;
                                            while($rowd6 = mysqli_fetch_assoc($resd6)) {
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>"; 
                                                echo "<td> <img src='".$rowd6['ProfileImage']."' class='rounded-circle mr-2' width='40px' alt=''></td>"; 
                                                echo "<td>".$rowd6['FullName']."</td>"; 
                                                echo "<td>".$rowd6['EmailId']."</td>"; 
                                                echo "<td>".$rowd6['StaffPhone']."</td>"; 
                                                echo "<td>".date_format(date_create($rowd6['DateCreate']), 'd M, Y') . "</td>"; 
                                                echo "<td>"; 
                                                if ($rowd6['StaffStatus']) {
                                                    echo "<span class='badge badge-success'>Active</span>";
                                                } else {
                                                    echo "<span class='badge badge-danger'>In-Active</span>";
                                                }
                                                echo "</td>";
                                                echo "<td>";
                                                ?>
                                                <a href="#" data-toggle="modal" data-target="#product<?php echo $rowd6['ST_Id'];?>"><i class='fa fa-pencil'></i></a> | 
                                                <a href="manage-staff.php?did=<?php echo $rowd6['ST_Id'];?>" onClick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash"></i></a>
                                                <?php
                                                echo "</td>";
                                                echo "</tr>"; 

                                                $count++;

                                                ?>
                                                    <div class="modal fade" id="product<?php echo $rowd6['ST_Id'];?>" tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <form method="POST" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo "Manage Admin - ".$rowd6['FullName'];?></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body g-3 row">
                                                                        <div class="col-md-6">
                                                                            <label class="form-label">Full Name</label>
                                                                            <input type="text" class="form-control input-style" required name="name" value="<?php echo $rowd6['FullName']; ?>">
                                                                            <div class="invalid-feedback">
                                                                            Please enter a admin name
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="form-label">Phone No</label>
                                                                            <input type="text" class="form-control input-style" required name="phone" pattern="[0-9]{1,10}" maxlength="10" value="<?php echo $rowd6['StaffPhone']; ?>">
                                                                            <div class="invalid-feedback">
                                                                            Please enter valid phone
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 mt-3">
                                                                            <label class="form-label">Address</label>
                                                                            <textarea class="form-control input-style" name="address" required><?php echo $rowd6['Address']; ?></textarea>
                                                                            <div class="invalid-feedback">
                                                                            Please enter address
                                                                            </div>
                                                                        </div>

                                                                        <input type="hidden" name="sid" value="<?php echo $rowd6['ST_Id'];?>">

                                                                        <div class="col-md-6 mt-3">
                                                                            <label for="validationCustom02" class="form-label">Status</label>
                                                                            <select class="form-control input-style" id="validationCustom04" required name="status" title="Please choose status">
                                                                                <option value="">Select</option>
                                                                                <option value="1" <?php if($rowd6['StaffStatus']){echo 'selected';}?>>Active</option>
                                                                                <option value="0" <?php if(!$rowd6['StaffStatus']){echo 'selected';}?>>In-Active</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-success" name="update">Save changes</button>
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


<?php
    require_once './pages/footer.php';
?>