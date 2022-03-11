<?php 
    session_start();

    require_once './config/connection.php';
    require_once './pages/link.php';
    require_once './pages/header.php';

    if(!isset($_SESSION['is_customer_login'])) {

        echo "<script>location.href='login.php';</script>";
    } else {
        if(!$_SESSION['is_customer_login']){

            echo "<script>location.href='login.php';</script>";
        }
    }
?>

 
<section class="w3l-features-photo-7 my-5">
	<div class="w3l-features-photo-7_sur">
        <div class="container row">
            <div class="col-6">
                <div class="card text-white bg-primary">
                    <div class="card-body text-center py-5">
                        <a href="view-invoice.php?oid=<?php echo $_GET['oid'];?>" class="h3 text-light">View Invoice</a>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card text-white bg-danger">
                    <div class="card-body text-center py-5">
                    <a href="view-ticket.php?oid=<?php echo $_GET['oid'];?>" class="h3 text-light">View Ticket</a>
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
