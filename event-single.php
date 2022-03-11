<?php 
    session_start();

    require_once './config/connection.php';
    require_once './pages/link.php';
    require_once './pages/header.php';
	require_once './api/maestro_util.php';

    $eProducts = mysqli_query($conn, "SELECT * FROM upcoming_event WHERE UE_Id = '$_GET[pid]' "); 
    if (mysqli_num_rows($eProducts) > 0) {
        $eProducts = mysqli_fetch_assoc($eProducts);
    } else {
        echo "<script>alert('Oops, Unable to process..');location.href='index.php';</script>";
    }

	
?>

<section class="w3l-features-photo-7">
	<div class="w3l-features-photo-7_sur">
		<div class="wrapper">
			<div class="w3l-features-photo-7_top">
				<div class="w3l-features-photo-7_top-right">
					<div class="galleryContainer">
						<div class="gallery">
							<input type="radio" name="controls" id="c1" checked><img class="galleryImage" id="i1"
								src="./admin/<?php echo $eProducts['BannerImage']?>" class="img img-responsive" alt="">
						</div>
					</div>
				</div>
				<div class="w3l-features-photo-7_top-left">
					<h4><?php echo $eProducts['EventName'];?></h4>
					<p class="para"><?php echo $eProducts['ShortDescription'];?></p>

					<section class="w3l-content-with-photo-23 mt-3" id="about">
						<div class="cwp23-title">
							<h4>Other Details</h4>
						</div>
						<div class="cwp23-text-cols" style="margin-top: 15px;">
							<div class="column">
								<h5>Event Start</h5>
								<p>d </p>
							</div>
							<div class="column">
								<h5>Event End</h5>
								<p>d </p>
							</div>
							<div class="column mt-2">
								<h5>Location</h5>
								<p><?php echo $eProducts['EventLocation'];?></p>
							</div>
							<div class="column mt-2">
								<h5>Age Limit</h5>
								<p><?php echo $eProducts['AgeLimit'];?></p>
							</div>
							<div class="column mt-2">
								<h5>Organizer</h5>
								<p><?php echo $eProducts['Organizer'];?></p>
							</div>
						</div>
					</section>
				</div>
			</div>
			<div class="des-bottom">
				<h5>Description:-</h5>
				<p> <?php echo $eProducts['Description'];?></p>
			</div>
		</div>
	</div>
</section>

<?php
    require_once './pages/newsletter.php';
    require_once './pages/footer.php';
?>