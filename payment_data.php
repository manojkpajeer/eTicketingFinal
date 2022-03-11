<?php

	session_start();
	if(!isset($_SESSION['is_customer_login'])) {

		echo "<script>location.href='login.php';</script>";
	} else {
		if(!$_SESSION['is_customer_login']){

			echo "<script>location.href='login.php';</script>";
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>DXB Tickets </title>
	<link rel="icon" href="assets/images/tab_image.png">
</head>
<body>
    <?php
        if(isset($_GET['msg'])){

            if(!empty($_GET['oid'])) {

                echo $_GET['msg'];
                echo "<a href='view-invoice.php?oid=$_GET[oid]' style='background-color: #008CBA;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>View Invoice</a> ";
                echo " <a href='view-ticket2.php?oid=$_GET[oid]' style='background-color: #f44336;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>View Ticket</a>";
                echo "<br><br><a href='index.php'>Back to Home Page</a>";
            } else {
                
                echo $_GET['msg'];
            }
        } else {
            echo "<br><br><a href='index.php'>Back to Home Page</a>";
        }
    ?>
</body>
</html>