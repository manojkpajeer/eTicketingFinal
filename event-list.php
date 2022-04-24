<?php 
    session_start();

    require_once './config/connection.php';
    require_once './pages/link.php';
    require_once './pages/header.php';
?>

<section class="w3l-inner-banner-main">
    <div class="about-inner">
        <div class="wrapper">
            
            <ul class="breadcrumbs-custom-path">
                <h3>Events Details</h3>
            </ul>
        </div>
    </div>
</section>

<section class="w3l-blog-main-61">
    <div class="grids-layout">
        <div class="wrapper">
            <div class="gallery-25-content">
                <div class="d-grid grid-columns">
					
                <?php
                        $eProducts = mysqli_query($conn, "SELECT * FROM event_master WHERE EventStatus = 'Publish'  AND BookingStatus = true"); 
                        if (mysqli_num_rows($eProducts) > 0) {

                            while ($eResult = mysqli_fetch_assoc($eProducts)) {

                                //check no of seats available, if available then display event

                                ?>
					<div class="blg-tp">
						<div class="column nine-blog">
							<div class="box13">
								<a href="bookings.php?source=<?php echo $eResult['EM_Id'];?>"><img class="side-img" src="<?php echo './superadmin/' . $eResult['Image1'];?>" alt="" /></a>
							</div>
						</div>
						<div class="column two ten-blog">
							<div class="box13"><small>Start From</small>
								<h4 style="font-size: 22px;">
                                    <?php 
                                        $resCartPrice = mysqli_query($conn, "SELECT MIN(PriceNet) as totPrice FROM price_master WHERE EventId = '$eResult[EM_Id]' AND PriceNet > 0");
                                        if (mysqli_num_rows($resCartPrice)>0){

                                            $resCartPrice = mysqli_fetch_assoc($resCartPrice);
                                            $cPrice = $resCartPrice['totPrice']/100;
                                            if ($cPrice > 0) {

                                                echo number_format($cPrice, 2)." AED";
                                            }
                                        }
                                    ?>
                                </h4>
								<h3><a href="bookings.php?source=<?php echo $eResult['EM_Id'];?>"><?php echo $eResult['EventName']; ?></a></h3>
								<ul class="admin-list">
									<li><a href="#"><span class="fa fa-calendar" aria-hidden="true"></span><?php echo date_format(date_create($eResult['StartDate']), 'M d, Y'); ?></a></li>
								</ul>
								<p><?php echo $eResult['ShortDescription']; ?>.</p>
										<div class="button"><a href="bookings.php?source=<?php echo $eResult['EM_Id'];?>" class="actionbg btn">View More <span
											class="fa fa-long-arrow-right" aria-hidden="true"></span></a></div>
                            </div>
						</div>
					</div>

                    <?php
                            }

                        } else {
                            echo "<p>No active event found..</p>";
                        }
                    ?>
	
				</div>
					
				</div>
	
			</div>
		</div>
		</div>
		<!-- //grids -->
	</section>

<?php
    require_once './pages/newsletter.php';
    require_once './pages/footer.php';
?>