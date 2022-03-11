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

    $image_path = "assets/images/profileimg.jpg";
    $resimg = mysqli_query($conn, "SELECT ProfileImage FROM admin_master WHERE AM_Id = ' " . $_SESSION['am_id'] . " '");
    if (mysqli_num_rows($resimg) > 0) {
        $resimg = mysqli_fetch_assoc($resimg);

        if(!empty($resimg['ProfileImage'])) {
            $image_path = $resimg['ProfileImage'];
        }
    }

    if(isset($_POST['update'])){
        $path = "profile-image/" . time() . "." . pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $path)) {
            if (mysqli_query($conn, "UPDATE admin_master SET ProfileImage = '$path' WHERE AM_Id = ' " . $_SESSION['am_id'] . " ' ")) {
                echo "<script>alert('Yay, Profile updated successfully..');location.href='profile.php';</script>";
            } else {
                echo "<script>alert('Oops, Unable to process your request..');</script>";
            }
        } else {
            echo "<script>alert('Oops, Unable to upload files on server..');</script>";
        }     
    }
?>

<!-- main content start -->
<div class="main-content">
        <div class="container-fluid content-top-gap">
            <div class="row">
                <div class="col-xl-12 pr-xl-12">
                    <div class="card card_border border-primary-top">
                        <div class="card-header chart-grid__header">Update Your Profile</div>
                        <div class="card-body">
                            <form method="post" class="g-3 needs-validation row px-3" novalidate enctype="multipart/form-data">
                                <div class="col-3" >
                                    <img id='previewImg' class='img rounded' src='<?php echo $profileImage; ?>' alt='Admin Image' height='200' width='200'/>    
                                </div>    
                                <div class="col-md-4 mt-4">
                                    <label for="validationCustom02" class="form-label">Change Image</label>
                                    <input type="file" class="form-control input-style" id="validationCustom02" name="profile_image" required onchange="previewFile(this);" accept="image/*">
                                    <div class="invalid-feedback">
                                    Please select an image 
                                    </div>
                                </div>  
                                <div class="col-3 mt-5">
                                    <button type="submit" class="btn btn-primary btn-style" name="update" id="validationCustom023">Update</button>
                                </div>                 
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function previewFile(input){
        var file = $("input[type=file]").get(0).files[0];
 
        if(file){
            var reader = new FileReader();
 
            reader.onload = function(){
                $("#previewImg").attr("src", reader.result);
            }
 
            reader.readAsDataURL(file);
        }
    }
</script>

<?php
    require_once './pages/footer.php';
?>