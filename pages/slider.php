<?php
$sliderData = " <div class='carousel-item active'>
                    <img src='./assets/images/slider-banner1.jpg' class='d-block w-100'>
                    <div class='carousel-caption' style=' bottom: 0;'>
                        <h3 class='title-cover-9'><strong> WE CATER TO <br>ALL TYPES OF<br>EVENTS</strong></h3>
                        <h6 class='mysubtext'>Let DXB be your one stop solution for<br>all your event needs</h6>
                        <a href='#' class='btnmy2' style='border-radius: 10px; background-color:#cd9c50;color:#ffffff'>CORPORATE EVENTS</a>
                        <a href='#' class='btnmy2' style='border-radius: 10px; background-color:#cd9c50;color:#ffffff'>PUBLIC EVENTS</a>
                        <a href='#' class='btnmy2' style='border-radius: 10px; background-color:#cd9c50;color:#ffffff'>PRIVATE EVENTS</a>
                    </div>
                </div>
                <div class='carousel-item'>
                    <img src='./assets/images/slider-banner2.jpg' class='d-block w-100'>
                    <div class='carousel-caption' style=' bottom: 0;'>
                        <p class='mysubtext2'>Welcome to our world of event rentals</p>
                        <h3 class='title-cover-19'><em><b>Imagine the perfect setup..<br>We will take you there..<b></em></h3><br>
                        <a href='#' class='btnmy2' style='border-radius: 10px; background-color:#cd9c50;color:#ffffff'>GENERAL SERVICES</a>
                        <a href='#' class='btnmy2' style='border-radius: 10px; background-color:#cd9c50;color:#ffffff'>EVENT TICKET PRINTING SERVICE</a>
                        <a href='#' class='btnmy2' style='border-radius: 10px; background-color:#cd9c50;color:#ffffff'>E-PERMIT APPLICATION SERVICES</a>
                    </div>
                </div>";

    $totalEvents = mysqli_query($conn, "SELECT EM_Id, ShortDescription, EventName, StartDate, EventBanner FROM event_master WHERE EventStatus = 'Publish' AND BookingStatus = true AND SliderStatus = true"); 
    if(mysqli_num_rows($totalEvents)>0){
        while($eBanner = mysqli_fetch_assoc($totalEvents)){
            $sliderData .= "<div class='carousel-item'>
                                <img src='./superadmin/$eBanner[EventBanner]' class='d-block w-100'>
                                <div class='carousel-caption'>
                                    <h6 class='tag-cover-9'> <i class='fa fa-calendar'> </i> ". date_format(date_create($eBanner['StartDate']), 'F d, Y')."</h6>
                                    <h3 class='title-cover-9'>$eBanner[EventName]</h3>
                                    <p class='para-cover-9'><span class='d-none d-lg-block mb-4'>$eBanner[ShortDescription]<span></p>
                                    <a href='bookings.php?source=$eBanner[EM_Id]' class='btnmy' style='border-radius: 10px; background-color:#cd9c50;color:#ffffff'>BUY TICKET </a>
                                </div>
                            </div>";
        }
    }
    
    
?>
<section class="w3l-covers-9-main">
    <div class="covers-9">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
            <?php echo $sliderData; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>
