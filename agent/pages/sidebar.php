        <!-- sidebar menu start -->
        <div class="sidebar-menu sticky-sidebar-menu">

            <!-- if logo is image enable this -->
            <div class="logo">
                <a href="index.php">
                    <img src="assets/images/logo_image.png" alt="Meastro Events" title="Meastro Events" class="img-fluid"/>
                </a>
            </div>

            <!-- //image logo -->
            <div class="logo-icon text-center">
                <a href="index.php" title="logo"><img src="assets/images/tab_image.png" alt="logo-icon"> </a>
            </div>

            <div class="sidebar-menu-inner">

            <!-- sidebar nav start -->
            <ul class="nav nav-pills nav-stacked custom-nav">
                <li class="<?php if ($_SERVER['REQUEST_URI'] == '/agent/home.php'){ echo 'active'; }?>"><a href="index.php" ><i class="fa fa-tachometer"></i><span> Dashboard</span></a></li>
                <li class="<?php if ($_SERVER['REQUEST_URI'] == '/agent/scan.php'){ echo 'active'; }?>"><a href="scan.php" ><i class="fa fa-tablet"></i><span> Manage Scan</span></a></li>
                <li class="<?php if ($_SERVER['REQUEST_URI'] == '/agent/badge.php'){ echo 'active'; }?>"><a href="badge.php" ><i class="fa fa-id-badge"></i><span> Manage Badge</span></a></li>
                <li class="menu-list <?php if ($_SERVER['REQUEST_URI'] == '/agent/profile.php' || $_SERVER['REQUEST_URI'] == '/agent/settings.php' || $_SERVER['REQUEST_URI'] == '/agent/account.php'){ echo 'active'; }?>">
                    <a href="#"><i class="fa fa-cog"></i>
                        <span>Settings <i class="lnr lnr-chevron-right"></i></span>
                    </a>
                    <ul class="sub-menu-list">
                        <li><a href="account.php">Account</a> </li>
                        <li><a href="profile.php">Profile</a> </li>
                        <li><a href="settings.php">Change Password</a> </li>
                    </ul>
                </li>
                <li><a href="./pages/logout.php"><i class="fa fa-power-off"></i> <span>Sign Out</span></a></li>
            </ul>
            
            <!-- toggle button start -->
            <a class="toggle-btn">
                <i class="fa fa-angle-double-left menu-collapsed__left"><span>Collapse Sidebar</span></i>
                <i class="fa fa-angle-double-right menu-collapsed__right"></i>
            </a>
            </div>
        </div>
        <!-- //sidebar menu end -->