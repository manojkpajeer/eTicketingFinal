<?php
  $fullName = "";
  $emailId = "";
  $profileImage = "assets/images/profileimg.jpg";
  $resprofile = mysqli_query($conn, "SELECT ProfileImage, FullName, EmailId FROM staff_master WHERE ST_Id = '$_SESSION[st_id]'");
  if (mysqli_num_rows($resprofile) > 0) {
    $resprofile = mysqli_fetch_assoc($resprofile);
    $fullName = $resprofile['FullName'];
    $profileImage = $resprofile['ProfileImage'];
    $emailId = $resprofile['EmailId'];
  }
?>

<!-- header-starts -->
<div class="header sticky-header">
    <!-- notification menu start -->
    <div class="menu-right">
      <div class="navbar user-panel-top">
        <div class="user-dropdown-details d-flex">
          <div class="profile_details">
            <ul>
              <li class="dropdown profile_details_drop">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenu3" aria-haspopup="true"
                  aria-expanded="false">
                  <div class="profile_img">
                    <img src="<?php echo $profileImage;?>" class='rounded-circle' alt='Profile Image' />
                    <div class="user-active">
                      <span></span>
                    </div>
                  </div>
                </a>
                <ul class="dropdown-menu drp-mnu" aria-labelledby="dropdownMenu3">
                  <li class="user-info">
                    <h5 class='user-name'><?php echo $fullName; ?></h5>
                    <span class='status ml-2'><?php echo $emailId; ?></span>
                  </li>
                  <li> <a href="profile.php"><i class="lnr lnr-user"></i>My Profile</a> </li>
                  <li> <a href="account.php"><i class="lnr lnr-book"></i>My Account</a> </li>
                  <li> <a href="settings.php"><i class="lnr lnr-cog"></i>Setting</a> </li>
                  <li class="logout"> <a href="pages/logout.php"><i class="fa fa-power-off"></i> Sign Out</a> </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- //header-ends -->