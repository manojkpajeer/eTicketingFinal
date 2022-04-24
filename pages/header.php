<!-- Headers-4 block -->
<section class="w3l-header-4">
    <header id="headers4-block">
        <div class="wrapper">
            <div class="d-grid nav-mobile-block header-align">
                <div class="logo">
                    <a class="brand-logo" href="index.php">
                        <img src="./assets/images/dxbtlogo.png" alt="DXB Tciket" title="DXB Tciket" style="background-color: #0c0a0d;" />
                    </a>
                </div>
                <input type="checkbox" id="nav" />
                <label class="nav" for="nav"></label>
                <nav>
                    <label for="drop" class="toggle">Menu</label>
                    <input type="checkbox" id="drop">
                    <ul class="menu">
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == ''){echo 'active';}?>"><a href="index.php" style="color: #ffffff;">Home</a></li>
                        
                            
                        <?php
                            $headerEvents = mysqli_query($conn, "SELECT EM_Id, EventName FROM event_master WHERE EventStatus = 'Publish' AND BookingStatus = true LIMIT 10"); 
                            if (mysqli_num_rows($headerEvents) > 0) {
                                ?>
                                <li>
                                    <label for="drop-3" class="toggle toogle-3">Events <span class="angle-dropdown"
                                            aria-hidden="true"></span>
                                    </label>
                                    <a href="event-list.php" style="color: #ffffff;">Events <span class="angle-dropdown" aria-hidden="true"></span></a>
                                    <input type="checkbox" id="drop-3">
                                    <ul>
                                
                                    <?php
                                    while ($eventData = mysqli_fetch_assoc($headerEvents)) {
                                        ?>
                                            <li style="width: 250px;"><a href="bookings.php?source=<?php echo $eventData['EM_Id'];?>" class="drop-text"><?php echo $eventData['EventName'];?></a></li>
                                        <?php
                                    }
                                    ?>
                                
                                    </ul>
                                </li>

                            <?php
                            }
                        ?>

                        <?php
                            if (isset($_SESSION['is_customer_login'])) {

                                if ($_SESSION['is_customer_login']) {
                                    ?>
                                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/profile.php' || $_SERVER['REQUEST_URI'] == '/settings.php' || $_SERVER['REQUEST_URI'] == '/accounts.php'){echo 'active';}?>">
                                            <label for="drop-4" class="toggle toogle-4">Account <span class="angle-dropdown"
                                                    aria-hidden="true"></span>
                                            </label>
                                            <a href="#" style="color: #ffffff;">Account <span class="angle-dropdown" aria-hidden="true"></span></a>
                                            <input type="checkbox" id="drop-4">

                                            <ul>
                                                <li><a href="profile.php" class="drop-text">Profile</a></li>
                                                <li><a href="settings.php" class="drop-text">Settings</a></li>
                                                <li><a href="accounts.php" class="drop-text">Orders</a></li>
                                            </ul>
                                        </li>
                                    <?php
                                }
                            }
                        ?>
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/create-event.php'){echo 'active';}?>"><a href="create-event.php" style="color: #ffffff;">Create Event</a></li>
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/about.php'){echo 'active';}?>"><a href="about.php" style="color: #ffffff;">About Us</a></li>
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/contact.php'){echo 'active';}?>"><a href="contact.php" style="color: #ffffff;">Contact Us</a></li>

                        <?php
                        if(isset($_SESSION['is_customer_login'])){
                            if($_SESSION['is_customer_login']){
                                ?>
                                <li><a href="./pages/logout.php" style="color: #ffffff;">Logout</a></li>
                                <?php
                            } else {
                                ?>
                                <li class="<?php if($_SERVER['REQUEST_URI'] == '/login.php'){echo 'active';}?>"><a href="login.php" style="color: #ffffff;">Login</a></li>
                                <?php
                            }
                        } else {
                            ?>
                            <li class="<?php if($_SERVER['REQUEST_URI'] == '/login.php'){echo 'active';}?>"><a href="login.php" style="color: #ffffff;">Login</a></li>
                            <?php
                        }
                       ?>
                    </ul>
                </nav>
                <div class="button">
                    <a href="my-cart.php" style="color:#fff;font-size:24px;"><i class="fa fa-shopping-cart"><span style="border-radius: 9px;font-size: 12px;background: #c4801c;color: #fff;padding: 2px 4px;vertical-align: top;margin-left: -6px; "><?php if (isset($_SESSION['cart_item'])) {echo sizeof($_SESSION['cart_item']);} else {echo "0";}?></span></i></a>
                    
                </div>
            </div>
        </div>
    </header>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script>
        $('#drop').change(function () {
        if ($('#drop').is(":checked")) {
        $('body').css('overflow', 'hidden');
        } else {
        $('body').css('overflow', 'auto');
        }
        });
        </script>
</section>
<!-- Headers-4 block -->