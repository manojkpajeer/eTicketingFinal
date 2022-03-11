<?php 
    session_start();

    require_once './config/connection.php';
    require_once './pages/link.php';
    require_once './pages/header.php';

    $resSales = mysqli_query($conn, "SELECT * FROM sales_master WHERE SM_Id = '$_GET[oid]'");
    if (mysqli_num_rows($resSales) > 0) {

        $resSales = mysqli_fetch_assoc($resSales);
    } else {

        echo "<script>alert('Oops, Unable to process..');location.href='accounts.php';</script>";
    }
?>

<?php
    require_once './pages/newsletter.php';
    require_once './pages/footer.php';
?>