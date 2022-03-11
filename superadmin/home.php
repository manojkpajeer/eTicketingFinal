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
?>

<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="welcome-msg pt-3 pb-4">
            <h1>Hi <span class="text-primary"><?php echo $fullName; ?></span>, Welcome back</h1>
        </div>

        <div class="statistics">
            <div class="row">
                <div class="col-xl-6 pr-xl-2">
                    <div class="row">
                        <div class="col-sm-6 pr-sm-2 statistics-grid">
                            <div class="card card_border border-primary-top p-4">
                                <i class="lnr lnr-users" style="color: blue;"> </i>
                                <h3 class="text-primary number">
                                    <?php
                                        $resd1 = mysqli_query($conn, "SELECT CM_Id FROM customer_master WHERE CustomerStatus = 1");
                                        echo mysqli_num_rows($resd1);
                                    ?>
                                </h3>
                                <p class="stat-text">Active Customers</p>
                            </div>
                        </div>
                        <div class="col-sm-6 pl-sm-2 statistics-grid">
                            <div class="card card_border border-primary-top p-4">
                                <i class="lnr lnr-user" style="color: grey;"> </i>
                                <h3 class="text-secondary number">
                                    <?php
                                        $resd2 = mysqli_query($conn, "SELECT AJM_Id FROM ajent_master WHERE AjentStatus = 1");
                                        echo mysqli_num_rows($resd2);
                                    ?>
                                </h3>
                                <p class="stat-text">Active Agents</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 pl-xl-2">
                    <div class="row">
                        <div class="col-sm-6 pr-sm-2 statistics-grid">
                            <div class="card card_border border-primary-top p-4">
                                <i class="lnr lnr-calendar-full" style="color: green;"> </i>
                                <h3 class="text-success number">
                                    <?php
                                        $resd3 = mysqli_query($conn, "SELECT EM_Id FROM event_master WHERE EventStatus = 'Publish' AND BookingStatus = true");
                                        echo mysqli_num_rows($resd3);
                                    ?>
                                </h3>
                                <p class="stat-text">Active Events</p>
                            </div>
                        </div>
                        <div class="col-sm-6 pl-sm-2 statistics-grid">
                            <div class="card card_border border-primary-top p-4">
                                <i class="lnr lnr-cart" style="color: red;"> </i>
                                <h3 class="text-danger number">
                                    <?php
                                        $resd4 = mysqli_query($conn, "SELECT SM_Id FROM sales_master WHERE SalesStatus = 1 AND DATE(DateCreate) = CURDATE() ");
                                        echo mysqli_num_rows($resd4);
                                    ?>
                                </h3>
                                <p class="stat-text">Today's Sales</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="chart">
            <div class="row">
                <div class="col-lg-6 pl-lg-2 chart-grid">
                    <div class="card text-center card_border">
                        <div class="card-header chart-grid__header">
                        Ticket Sold
                        </div>
                        <div class="card-body">
                            <div id="container">
                                <canvas id="linechart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 pr-lg-2 chart-grid">
                    <div class="card text-center card_border">
                        <div class="card-header chart-grid__header">
                        <?php
                            $resPie = mysqli_query($conn, "SELECT EventName FROM event_master WHERE EventStatus = 'Publish' AND BookingStatus = 1 ORDER BY EM_Id DESC LIMIT 1");
                            if (mysqli_num_rows($resPie)>0){
                                $resPie = mysqli_fetch_assoc($resPie);
                                echo $resPie['EventName'];
                            }
                        ?>
                        </div>
                        <div class="card-body">
                            <div id="canvas-holder">
                                <canvas id="piechart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="data-tables">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card card_border p-4">
                        <h3 class="card__title mb-3">Recent Events</h3>
                        <div class="table-responsive">
                            <table class="table-sm" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Banner</th>
                                        <th>Event Name</th>
                                        <th>Event On</th>
                                        <th>Location</th>
                                        <th>Booking Line</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                            $resd5 = mysqli_query($conn, "SELECT BookingStatus, EM_Id, EventStatus, EventName, EventCode, StartDate, EventLocation, EventBanner FROM event_master WHERE NOT EventStatus = 'New' ORDER BY EM_Id DESC LIMIT 5");
                                            if (mysqli_num_rows($resd5) > 0) {

                                                $count = 1;
                                                while($rowd5 = mysqli_fetch_assoc($resd5)) {
                                                    
                                                    echo "<tr>"; 
                                                    echo "<th>".$count."</th>"; 
                                                    echo "<td> <img src='".$rowd5['EventBanner']."' class='rounded-circle mr-2' width='40px' alt=''></td>"; 
                                                    echo "<td>".$rowd5['EventName']."</td>"; 
                                                    echo "<td>".date_format(date_create($rowd5['StartDate']), 'd M, Y') . "</td>"; 
                                                    echo "<td>".$rowd5['EventLocation']."</td>"; 
                                                    if ($rowd5['BookingStatus']) {
                                                        echo "<td><span class='badge badge-success'>Open</span></td>";
                                                    } else {
                                                        echo "<td><span class='badge badge-success'>Closed</span></td>";
                                                    }
                                                    echo "<td> <span class='badge ";
                                                    if ($rowd5['EventStatus'] == 'Publish') {
                                                        echo "badge-success";
                                                    } else {
                                                        echo "badge-danger";
                                                    }
                                                    echo "'>".$rowd5['EventStatus']."</span></td>"; 
                                                    
                                                    echo "</tr>"; 

                                                    $count++;
                                                }
                                            }
                                        ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="data-tables">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card card_border p-4">
                        <h3 class="card__title mb-3">Up Coming Events</h3>
                        <div class="table-responsive">
                            <table class="table-sm" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Banner</th>
                                        <th>Event Name</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                            $resd6 = mysqli_query($conn, "SELECT EventStatus, EventName, StartDate, BannerImage FROM upcoming_event ORDER BY UE_Id DESC LIMIT 5");
                                            if (mysqli_num_rows($resd6) > 0) {

                                                $count = 1;
                                                while($rowd6 = mysqli_fetch_assoc($resd6)) {
                                                    
                                                    echo "<tr>"; 
                                                    echo "<th>".$count."</th>"; 
                                                    echo "<td> <img src='".$rowd6['BannerImage']."' class='rounded-circle mr-2' width='40px' alt=''></td>"; 
                                                    echo "<td>".$rowd6['EventName']."</td>"; 
                                                    echo "<td>".date_format(date_create($rowd6['StartDate']), 'd M, Y') . "</td>"; 
                                                    echo "<td>";
                                                    if ($rowd6['EventStatus']) {
                                                        echo "<span class='badge badge-success'>Active</span>";
                                                    } else {
                                                        echo "<span class='badge badge-danger'>In-Active</span>";
                                                    }
                                                    echo "</td>"; 
                                                    echo "</tr>"; 

                                                    $count++;
                                                }
                                            }
                                        ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card card_border p-4">
                        <h3 class="card__title mb-3">Top Performing Agents</h3>
                        <div class="table-responsive">
                            <table class="table-sm" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Profile</th>
                                        <th>Agent Name</th>
                                        <th>Agent Code</th>
                                        <th>Ticket Sold</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $resd7 = mysqli_query($conn, "SELECT ajent_master.AjentProfile, ajent_master.FullName, ajent_master.AjentCode, COALESCE(SUM(sales_data.Quantity), 0) AS Quantity FROM sales_data JOIN sales_master ON sales_master.BasketId = sales_data.BusketId JOIN ajent_master ON ajent_master.AJM_Id = sales_master.AjentId WHERE sales_master.IsSoldByAjent = TRUE AND sales_master.SalesStatus = 'Placed' AND sales_data.Status = TRUE AND ajent_master.AjentStatus = TRUE GROUP BY ajent_master.AjentProfile, ajent_master.FullName, ajent_master.AjentCode ORDER BY MAX(Quantity) LIMIT 5");
                                        if (mysqli_num_rows($resd7) > 0) {

                                            $count = 1;
                                            while($rowd7 = mysqli_fetch_assoc($resd7)) {
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>"; 
                                                echo "<td> <img src='".$rowd7['AjentProfile']."' class='rounded-circle mr-2' width='40px' alt=''></td>"; 
                                                echo "<td>".$rowd7['FullName']."</td>"; 
                                                echo "<td>".$rowd7['AjentCode']."</td>"; 
                                                echo "<td><span class='badge-success'>".$rowd7['Quantity']."</span></td>"; 
                                                echo "</tr>"; 

                                                $count++;
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