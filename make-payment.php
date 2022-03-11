<?php

    session_start();

    if(isset($_SESSION['is_customer_login'])){
	
        if($_SESSION['is_customer_login']){

            include './config/connection.php';

            $total_prices = 0;
            $uid = "DXB".time()."TC";
            $basket = $_GET['bsk'];
            $eventId = $_GET['pid'];
            $customerId = $_SESSION['cm_id'];

            $_SESSION['uid'] = $uid;

            $resBask = mysqli_query($conn, "SELECT * FROM sales_data WHERE BusketId = '$_GET[bsk]'");
            if(mysqli_num_rows($resBask) > 0) {

                while($rowBask = mysqli_fetch_assoc($resBask)) {

                    $resTotalAmount = mysqli_query($conn, "SELECT PriceNet FROM price_master WHERE PriceCategoryId = '$rowBask[CategoryId]' AND PriceTypeId = '$rowBask[TypeId]' AND EventId = '$rowBask[EventId]' ");
                    
                    if (mysqli_num_rows($resTotalAmount) > 0){

                        $resTotalAmount = mysqli_fetch_assoc($resTotalAmount);
                        $total_prices += ($resTotalAmount['PriceNet'] /100 ) * $rowBask['Quantity'];
                    }
                }

                if($total_prices > 0) {

                    require 'vendor-stripe/autoload.php';
                    
                    \Stripe\Stripe::setApiKey('sk_test_51KIFHNE3F7vPybCTVyppq2ZymUNHr760GhUqGyFinRrfQmkPxY0XD7gR79voOleTVa5KWrPXsMvAfbyttaFTjaqG00RBwavmUf');

                    header('Content-Type: application/json');

                    $SUCCESS_DOMAIN = "https://www.dxbtickets.com/payment-success.php?uid=".$uid."&bsk=".$basket."&pid=".$eventId;
                    $FAIL_DOMAIN = "https://www.dxbtickets.com/payment-failed.php?uid=".$uid;

                    $checkout_session = \Stripe\Checkout\Session::create([
                    'line_items' => [[
                        
                        'price_data' => [
                            'currency' => 'aed',
                            'product_data' => [
                                'name' => $uid
                            ],
                            'unit_amount' => $total_prices * 100
                        ],
                        'quantity' => 1,
                    ]],
                    'mode' => 'payment',
                        'success_url' => $SUCCESS_DOMAIN,
                        'cancel_url' => $FAIL_DOMAIN,
                    ]);

                    $intent = \Stripe\PaymentIntent::retrieve($checkout_session->payment_intent);
                    
                    $transactionID = $intent->id;
                    $paidAmount = $intent->amount;
                    $paidAmount = ($paidAmount/100);
                    $paidCurrency = $intent->currency;
                    $paymentStatus = $intent->status;

                    mysqli_query($conn, "INSERT INTO payment_master (UniqueId, TransactionId, PaidCurrency, PaymentStatus, DatePaid, TotalAmount, 
                        CustomerId, PaymentMessage) VALUES ('$uid', '$transactionID', '$paidCurrency', 'Initiated', NOW(), 
                        '$paidAmount', '$customerId', '$paymentStatus')");
                    
                    header("HTTP/1.1 303 See Other");
                    header("Location: " . $checkout_session->url);
                    

                } else {

                    echo "<script>alert('Oops, Unable to process..');location.href='product-single.php?pid=$_GET[pid]';</script>";
                }
                
            } else {
                
                echo "<script>alert('Oops, Unable to process..');location.href='product-single.php?pid=$_GET[pid]';</script>";
            }
        }else {

            echo "<script>alert('Oops, Unable to process..');location.href='product-single.php?pid=$_GET[pid]';</script>";
        }
    } else {

        echo "<script>alert('Oops, Unable to process..');location.href='product-single.php?pid=$_GET[pid]';</script>";
    }
?>