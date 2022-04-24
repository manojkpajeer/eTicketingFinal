<?php

	use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';
	include './config/connection.php';

	session_start();

	$customerId = $_SESSION['cm_id'];

	function sendEmail($msg, $conn, $cid) {

		$rescust = mysqli_query($conn, "SELECT Saluation, FirstName, LastName, CustomerEmail FROM customer_master WHERE CM_Id = '$cid' ");
		if(mysqli_num_rows($rescust)>0){

			$rescust = mysqli_fetch_assoc($rescust);

			$name = $rescust['Saluation'] . "" . $rescust['FirstName'] . " " .$rescust['LastName'];

			$mail = new PHPMailer(true);

			try {                   
				$mail->isSMTP();                                           
				$mail->Host       = 'smtp.zoho.com';                    
				$mail->SMTPAuth   = true;                                  
				$mail->Username   = 'support@dxbtickets.com';                    
				$mail->Password   = 'Sujith104';                               
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
				$mail->Port       = 465;                                  
			
				$mail->setFrom('support@dxbtickets.com', "DXB Tickets");
				$mail->addAddress($rescust['CustomerEmail'], $name);
			
				$mail->IsHTML(true);
				$mail->Subject = "Your order placed successfully";
				$mail->Body = "hi ". $name . "Your order has been placed successfully.<br>".$msg."<br><br>
					Thank You again<br><strong>Team DXB Tickets</strong>";
			
				if ($mail->send()) {

					echo "<script>alert('Yay, Your order has been placed successfully..');</script>";
				} else {
					
					echo "<script>alert('Yay, Your order has been placed successfully..');</script>";
				}
			} catch (Exception $e) {
				
				echo "<script>alert('Yay, Your order has been placed successfully..');</script>";
			}
		}
	}

	if(isset($_SESSION['is_customer_login'])){

		if($_SESSION['is_customer_login']){

			require_once './api/maestro_util.php';

			$api = new MaestroUtil();

			if ((!empty($_GET['uid'])) && (!empty($_GET['bsk'])) && (!empty($_GET['pid']))) {

				if(isset($_SESSION['uid'])) {

					if($_SESSION['uid'] == $_GET['uid']) {
						
						unset($_SESSION['uid']);
						
						$resGetData = mysqli_query($conn, "SELECT * FROM payment_master WHERE UniqueId = '$_GET[uid]' AND PaymentStatus = 'Initiated'");

						if (mysqli_num_rows($resGetData)>0) {

							$resGetData = mysqli_fetch_assoc($resGetData);
							
							if(mysqli_query($conn, "UPDATE payment_master SET PaymentStatus = 'Paid' WHERE RP_Id = '$resGetData[RP_Id]'")) {

								$orderID = rand(1111, 9999);
								// $orderID = $api->purchaseTicket($customerID, $_GET['bsk'], $resGetData['TotalAmount']);

								if(empty($orderID)) {

									$message = "<h3>Oops, Unable to process your request..</h3><br>";
									$message .= "<div>Date : ".date_format(date_create($resGetData['DatePaid']), 'M d, Y')."</div><br>";
									$message .= "<div><strong>Transaction ID : ".$resGetData['TransactionId']."</strong></div><br>";
									$message .= "<div><strong>Payment ID : ".$_GET['uid']."</strong></div><br>";
									$message .= "<div>Total Amount : ".number_format($resGetData['TotalAmount'], 2)." AED</div><br>";
									$message .= "<div>Transaction Status : ".$resGetData['PaymentMessage']."</div><br>";
									$message .= "<a href='contact.php'>Contact Us</a><br>Call +(97) 155-120-0104<br>Email info@maestroevents.ae<br><br><a href='index.php'>Back to Home Page</a>";
								
									header("Location: payment_data.php?msg=$message"); 
								} else {
								
									if (mysqli_query($conn, "INSERT INTO sales_master (CustomerId, PaymentId, BasketId, OrderId, DateCreate, 
										SalesStatus, EventId, IsSoldByAjent, AjentId) VALUES ('$customerId', '$resGetData[RP_Id]', '$_GET[bsk]', 
										'$orderID', NOW(), 'Placed', '$_GET[pid]', 0, 0) ")) {
								
										if (mysqli_query($conn, "UPDATE sales_data SET Status = 1 WHERE BusketId = '$_GET[bsk]'")) {
								
											// if ($api->barCode($orderID)) {
											if (1+1 == 2) {
												
												$message = "<h3>Yay, Your booking completed successfully..</h3><br>";
												$message .= "<div>Date : ".date_format(date_create($resGetData['DatePaid']), 'M d, Y')."</div><br>";
												$message .= "<div><strong>Transaction ID : ".$resGetData['TransactionId']."</strong></div><br>";
												$message .= "<div><strong>Payment ID : ".$_GET['uid']."</strong></div><br>";
												$message .= "<div><strong>Order ID : ".$orderID."</strong></div><br>";
												$message .= "<div>Total Amount : ".number_format($resGetData['TotalAmount'], 2)." AED</div><br>";
												$message .= "<div>Transaction Status : ".$resGetData['PaymentMessage']."</div><br>";
												$message .= "<a href='contact.php'>Contact Us</a><br>Call +(97) 155-120-0104<br>Email info@maestroevents.ae<br><br>";
											
												sendEmail($message, $conn, $customerId);

												header("Location: payment_data.php?msg=$message&oid=$orderID"); 
											} else {
								
												$message = "<h3>Oops, Unable to process your request..</h3><br>";
												$message .= "<div>Date : ".date_format(date_create($resGetData['DatePaid']), 'M d, Y')."</div><br>";
												$message .= "<div><strong>Transaction ID : ".$resGetData['TransactionId']."</strong></div><br>";
												$message .= "<div><strong>Payment ID : ".$_GET['uid']."</strong></div><br>";
												$message .= "<div><strong>Order ID : ".$orderID."</strong></div><br>";
												$message .= "<div>Total Amount : ".number_format($resGetData['TotalAmount'], 2)." AED</div><br>";
												$message .= "<div>Transaction Status : ".$resGetData['PaymentMessage']."</div><br>";
												$message .= "<a href='contact.php'>Contact Us</a><br>Call +(97) 155-120-0104<br>Email info@maestroevents.ae<br><br><a href='index.php'>Back to Home Page</a>";
											
												header("Location: payment_data.php?msg=$message"); 
											}
										} else {

											$message = "<h3>Oops, Unable to process your request..</h3><br>";
											$message .= "<div>Date : ".date_format(date_create($resGetData['DatePaid']), 'M d, Y')."</div><br>";
											$message .= "<div><strong>Transaction ID : ".$resGetData['TransactionId']."</strong></div><br>";
											$message .= "<div><strong>Payment ID : ".$_GET['uid']."</strong></div><br>";
											$message .= "<div><strong>Order ID : ".$orderID."</strong></div><br>";
											$message .= "<div>Total Amount : ".number_format($resGetData['TotalAmount'], 2)." AED</div><br>";
											$message .= "<div>Transaction Status : ".$resGetData['PaymentMessage']."</div><br>";
											$message .= "<a href='contact.php'>Contact Us</a><br>Call +(97) 155-120-0104<br>Email info@maestroevents.ae<br><br><a href='index.php'>Back to Home Page</a>";
										
											header("Location: payment_data.php?msg=$message"); 
										}
									} else {

										$message = "<h3>Oops, Unable to process your request..</h3><br>";
										$message .= "<div>Date : ".date_format(date_create($resGetData['DatePaid']), 'M d, Y')."</div><br>";
										$message .= "<div><strong>Transaction ID : ".$resGetData['TransactionId']."</strong></div><br>";
										$message .= "<div><strong>Payment ID : ".$_GET['uid']."</strong></div><br>";
										$message .= "<div><strong>Order ID : ".$orderID."</strong></div><br>";
										$message .= "<div>Total Amount : ".number_format($resGetData['TotalAmount'], 2)." AED</div><br>";
										$message .= "<div>Transaction Status : ".$resGetData['PaymentMessage']."</div><br>";
										$message .= "<a href='contact.php'>Contact Us</a><br>Call +(97) 155-120-0104<br>Email info@maestroevents.ae<br><br><a href='index.php'>Back to Home Page</a>";
									
										header("Location: payment_data.php?msg=$message"); 
									}
								}
							} else {

								$message = "<h3>Oops, Unable to process your request..</h3><br>";
								$message .= "<div>Date : ".date_format(date_create($resGetData['DatePaid']), 'M d, Y')."</div><br>";
								$message .= "<div><strong>Transaction ID : ".$resGetData['TransactionId']."</strong></div><br>";
								$message .= "<div><strong>Payment ID : ".$_GET['uid']."</strong></div><br>";
								$message .= "<div>Total Amount : ".number_format($resGetData['TotalAmount'], 2)." AED</div><br>";
								$message .= "<div>Transaction Status : ".$resGetData['PaymentMessage']."</div><br>";
								$message .= "<a href='contact.php'>Contact Us</a><br>Call +(97) 155-120-0104<br>Email info@maestroevents.ae<br><br><a href='index.php'>Back to Home Page</a>";
								
								header("Location: payment_data.php?msg=$message"); 
							}
						}else {

							$message = "<h3>Oops, Unable to process..</h3><h5>Your Payment ID : ".$_GET['uid']."</h5><a href='contact.php'>Contact Us</a><br>Call +(97) 155-120-0104<br>Email info@maestroevents.ae<br><br><a href='index.php'>Back to Home Page</a>";
							header("Location: payment_data.php?msg=$message"); 
						}
					} else {
						
						$message = "<h3>Oops, Unable to process..</h3><br><a href='index.php'>Back to Home Page</a>";
						header("Location: payment_data.php?msg=$message"); 
					}
				} else {
					
					$message = "<h3>Oops, Unable to process..</h3><br><a href='index.php'>Back to Home Page</a>";
					header("Location: payment_data.php?msg=$message"); 
				}
			} else {
				
				$message = "<h3>Oops, Unable to process..</h3><br><a href='index.php'>Back to Home Page</a>";
				header("Location: payment_data.php?msg=$message"); 
			}
		} else {

			$message = "<h3>Oops, Unable to process..</h3><br><a href='index.php'>Back to Home Page</a>";
			header("Location: payment_data.php?msg=$message"); 
		}
	} else {

		$message = "<h3>Oops, Unable to process..</h3><br><a href='index.php'>Back to Home Page</a>";
		header("Location: payment_data.php?msg=$message");  
	}
?>

