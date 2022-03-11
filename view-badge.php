<?php 
    session_start();

    require_once './config/connection.php';
    require_once './pages/link.php';
    require_once './pages/header.php';   
?>

<section class="w3l-features-photo-7 my-5">
	<div class="w3l-features-photo-7_sur">
        <div class="section-title align-center text-center">
            <h4>Choose Your Badge</h4>
        </div>
        <div class="container row">
            <div class="col-6">
                <div class="card text-white bg-primary">
                    <div class="card-body text-center py-5">
                        <a href="print-badge.php?id=<?php echo $_GET['id'];?>" class="h3 text-light">Badge 1</a>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card text-white bg-danger">
                    <div class="card-body text-center py-5">
                    <a href="print-badge2.php?id=<?php echo $_GET['id'];?>" class="h3 text-light">Badge 2</a>
                    </div>
                </div>
            </div>
        </div>
	</div>
</section>

<?php
    require_once './pages/newsletter.php';
    require_once './pages/footer.php';
?>