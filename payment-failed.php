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
<html lang="en-US">
<head>
<title>DXB Tickets - Stripe Payment</title>
<link rel="icon" href="assets/images/tab_image.png">
<meta charset="utf-8">
</head>
<body class="App">
  <h1>Your transaction was canceled!</h1>

	<?php
		include './config/connection.php';

		if(isset($_GET['uid'])) {

			unset($_SESSION['uid']);
			
			$resGetData = mysqli_query($conn, "SELECT * FROM payment_master WHERE UniqueId = '$_GET[uid]'");

			if (mysqli_num_rows($resGetData)>0) {

				$resGetData = mysqli_fetch_assoc($resGetData);

				echo "<div>Date : ".date_format(date_create($resGetData['DatePaid']), 'M d, Y')."</div><br>";
				echo "<div><strong>Transaction ID : ".$resGetData['TransactionId']."</strong></div><br>";
				echo "<div>Total Amount : ".number_format($resGetData['TotalAmount'], 2)." AED</div><br>";
				echo "<div>Transaction Status : ".$resGetData['PaymentMessage']."</div><br>";
			}
		}
	?>
	<div></div>
	<div class="wrapper">
		<a href="index.php" class="btn-link">Back to Home Page</a>
	</div>
</body>
</html>