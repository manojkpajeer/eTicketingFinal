
<?php
    $resUpcoming = mysqli_query($conn, "SELECT UE_Id, BannerImage, StartDate, EndDate, EventName, ShortDescription FROM upcoming_event WHERE EventStatus = 1 ORDER BY UE_Id DESC LIMIT 6");
    if (mysqli_num_rows($resUpcoming) > 0) {
?>
    <section class="w3l-price-2">
        <div class="price-main">
            <div class="wrapper">
                <div class="section-title align-center text-center">
                        <h4>Up Coming Events</h4>
                </div>
                <div class="pricing-style-w3ls">
                    <div class="pricing-chart">   
                    <?php
                        while($rowUpcoming = mysqli_fetch_assoc($resUpcoming)) {
                            ?>
                            <div class="price-box btn-layout bt6">
                                <div class="grid grid-column-2">
                                    <div class="column2">
                                        <img src="<?php echo './superadmin/' . $rowUpcoming['BannerImage']; ?>" alt="" class="img-responsive">
                                    </div>
                                    <div class="column1">
                                        <div class="job-info">
                                            <h6 class="pricehead"><a href="event-single.php?pid=<?php echo $rowUpcoming['UE_Id'];?>"><?php echo $rowUpcoming['EventName'];?></a></h6>
                                            <h5><?php echo date_format(date_create($rowUpcoming['StartDate']), 'F d, Y') . " - " . date_format(date_create($rowUpcoming['EndDate']), 'F d, Y'); ?> </h5>
                                            <p><?php echo $rowUpcoming['ShortDescription'];?></p>
                                            
                                        </div>
                                    </div>
                                            
                                    <div class="column3 text-right">
                                        <a href="event-single.php?pid=<?php echo $rowUpcoming['UE_Id'];?>" class="actionbg">Read More</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php
    }
    ?>