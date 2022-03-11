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
                <li class="<?php if ($_SERVER['REQUEST_URI'] == '/staff/home.php'){ echo 'active'; }?>"><a href="index.php" ><i class="fa fa-tachometer"></i><span> Dashboard</span></a></li>
                
                <li class="menu-list <?php if ($_SERVER['REQUEST_URI'] == '/staff/add-event.php' || $_SERVER['REQUEST_URI'] == '/staff/events.php' || $_SERVER['REQUEST_URI'] == '/staff/ticket-allocation.php'){ echo 'active'; }?>">
                    <a href="#"><i class="fa fa-calendar"></i>
                        <span>Events <i class="lnr lnr-chevron-right"></i></span>
                    </a>
                    <ul class="sub-menu-list">
                        <li><a href="add-event.php">Add Event</a> </li>
                        <li><a href="events.php">View Events</a> </li>
                        <li><a href="ticket-allocation.php">Ticket Allocation</a></li>
                    </ul>
                </li>

                <li class="<?php if ($_SERVER['REQUEST_URI'] == '/staff/view-barcode.php'){ echo 'active'; }?>"><a href="./view-barcode.php"><i class="fa fa-barcode"></i> <span>Manage Barcode</span></a></li>
                               
                <li class="menu-list <?php if ($_SERVER['REQUEST_URI'] == '/staff/before-event.php' || $_SERVER['REQUEST_URI'] == '/staff/after-event.php' || $_SERVER['REQUEST_URI'] == '/staff/event-report.php'){ echo 'active'; }?>">
                    <a href="#"><i class="fa fa-clipboard"></i>
                        <span>Event Report <i class="lnr lnr-chevron-right"></i></span>
                    </a>
                    <ul class="sub-menu-list">
                        <li><a href="before-event.php">Before Event Report</a> </li>
                        <li><a href="after-event.php">After Event Report 1</a> </li>
                        <li><a href="event-report.php">After Event Report 2</a> </li>
                    </ul>
                </li>

                <li class="<?php if ($_SERVER['REQUEST_URI'] == '/staff/barcode.php'){ echo 'active'; }?>"><a href="./barcode.php"><i class="fa fa-tablet"></i> <span>Manage Scan</span></a></li>
                
                <li class="menu-list <?php if ($_SERVER['REQUEST_URI'] == '/staff/add-ticket.php' || $_SERVER['REQUEST_URI'] == '/staff/manage-ticket.php'){ echo 'active'; }?>">
                    <a href="#"><i class="fa fa-plus"></i>
                        <span>Ticket Type <i class="lnr lnr-chevron-right"></i></span>
                    </a>
                    <ul class="sub-menu-list">
                        <li><a href="add-ticket.php">Add Type</a> </li>
                        <li><a href="manage-ticket.php">Manage Type</a> </li>
                    </ul>
                </li>

                <li class="<?php if ($_SERVER['REQUEST_URI'] == '/staff/badge.php'){ echo 'active'; }?>"><a href="./badge.php"><i class="fa fa-id-badge"></i> <span>Manage Badge</span></a></li>

                <li class="menu-list <?php if ($_SERVER['REQUEST_URI'] == '/staff/add-upcoming.php' || $_SERVER['REQUEST_URI'] == '/staff/manage-upcoming.php'){ echo 'active'; }?>">
                    <a href="#"><i class="fa fa-calendar"></i>
                        <span>Up Coming Event <i class="lnr lnr-chevron-right"></i></span>
                    </a>
                    <ul class="sub-menu-list">
                        <li><a href="add-upcoming.php">Add Event</a> </li>
                        <li><a href="manage-upcoming.php">Manage Event</a> </li>
                    </ul>
                </li>

                <li class="<?php if ($_SERVER['REQUEST_URI'] == '/staff/manage-event-form.php'){ echo 'active'; }?>"><a href="./manage-event-form.php"><i class="fa fa-child"></i> <span>Event Request</span></a></li>
                
                <!-- <li class="menu-list <?php #if ($_SERVER['REQUEST_URI'] == '/staff/profile.php' || $_SERVER['REQUEST_URI'] == '/staff/settings.php' || $_SERVER['REQUEST_URI'] == '/staff/account.php'){ echo 'active'; }?>">
                    <a href="#"><i class="fa fa-cog"></i>
                        <span>Settings <i class="lnr lnr-chevron-right"></i></span>
                    </a>
                    <ul class="sub-menu-list">
                        <li><a href="account.php">Account</a> </li>
                        <li><a href="profile.php">Profile</a> </li>
                        <li><a href="settings.php">Change Password</a> </li>
                    </ul>
                </li> -->

                <li><a href="./pages/logout.php"><i class="fa fa-power-off"></i> <span>Sign Out</span></a></li>
            </ul>
            
            <!-- toggle button start -->
            <a class="toggle-btn fixed">
                <i class="fa fa-angle-double-left menu-collapsed__left"><span>Collapse Sidebar</span></i>
                <i class="fa fa-angle-double-right menu-collapsed__right"></i>
            </a>
            </div>
        </div>
        <!-- //sidebar menu end -->