<?php 
    session_start();

    require_once './config/connection.php';

    require_once './pages/link.php';

    if (isset($_GET['delete_cart_item'])) {
        $cart_types = $_GET['cart_types'];
        $cart_categorys = $_GET['cart_categorys'];
        $cartEventIds = $_GET['cartEventIds'];
        
        $items = $cartEventIds . $cart_categorys . $cart_types;
        unset($_SESSION['cart_item'][$items]);

        echo "<script>location.href='index.php';</script>";
      }

    if (isset($_POST['add_to_cart'])) {
        $cart_quantity = $_POST['cart_quantity'];
        $cart_type = $_POST['cart_type'];
        $cart_category = $_POST['cart_category'];
        $cartEventId = $_POST['cartEventId'];

        $item = $cartEventId . $cart_category . $cart_type;

        $itemArray = array(
            $item => array(
                'item' => $item, 
                'cart_quantity' => $cart_quantity, 
                'cart_type' => $cart_type, 
                'cart_category' => $cart_category, 
                'cartEventId' => $cartEventId
            )
        );

        if (empty($_SESSION["cart_item"])) {

            $_SESSION["cart_item"] = $itemArray;
        } else {

            if (in_array($item, array_keys($_SESSION["cart_item"]))) {

                foreach ($_SESSION["cart_item"] as $k => $v) {

                    if($item == $k) {

                        if(empty($_SESSION["cart_item"][$k]["cart_quantity"])) {

                            $_SESSION["cart_item"][$k]["cart_quantity"] = 0;
                        }

                        if (($_SESSION["cart_item"][$k]["cart_quantity"] + $cart_quantity) <= 10 ) {

                            $_SESSION["cart_item"][$k]["cart_quantity"] += $cart_quantity;
                        } else {

                            echo "<script>alert('Oops, You can buy maximum 10 tickets..');</script>";
                        }
                    }
                }
            } else {
                foreach($_SESSION['cart_item'] as $itemc){

					if ($cartEventId == $itemc['cartEventId'] && $cart_category == $itemc['cart_category']) {
	
						$_SESSION["cart_item"] += $itemArray;
					} else {

						echo "<script>alert('You have chosen a different ticket. We will clear the existing ticket...');</script>";
						unset($_SESSION["cart_item"]);
						$_SESSION["cart_item"] = $itemArray;
					}
				}
            }
        }
    }

    function ticketAvailable($con, $eid) {
        $quantity = 0;
        $quantity_avail = 0;

        $resComp = mysqli_query($con, "SELECT PriceCategoryId FROM category_master WHERE EventId = '$eid' AND PriceCategoryName LIKE 'comp%'");
        if (mysqli_num_rows($resComp)>0){

            $resComp = mysqli_fetch_assoc($resComp);
            $compId = $resComp['PriceCategoryId'];

            $resCatTotal = mysqli_query($con, "SELECT COALESCE(SUM(SeatsNo), 0) AS SeatsNo FROM category_master WHERE EventId = '$eid' AND NOT PriceCategoryId = '$compId'");
            if (mysqli_num_rows($resCatTotal)>0){
                
                $resCatTotal = mysqli_fetch_assoc($resCatTotal);
                $quantity_avail +=  $resCatTotal['SeatsNo'];
            }

            $res_sold = mysqli_query($con, "SELECT COALESCE(SUM(sales_data.Quantity), 0) AS Quantity FROM sales_master JOIN sales_data ON 
            sales_master.BasketId = sales_data.BusketId WHERE sales_data.EventId = '$eid' AND sales_data.Status = TRUE AND 
            sales_master.EventId = '$eid' AND sales_master.SalesStatus = 'Placed' AND sales_master.IsSoldByAjent = FALSE AND NOT sales_data.CategoryId = '$compId'");
            if(mysqli_num_rows($res_sold)>0){

                $res_sold = mysqli_fetch_assoc($res_sold);
                $quantity +=  $res_sold['Quantity'];
            }

            $res_aj_sold = mysqli_query($con, "SELECT COALESCE(SUM(Quantity), 0) AS Quantity FROM ticket_allocation WHERE EventId = '$eid' AND NOT CategoryId = '$compId'");
            if(mysqli_num_rows($res_aj_sold)>0){
                
                $res_aj_sold = mysqli_fetch_assoc($res_aj_sold);
                $quantity +=  $res_aj_sold['Quantity'];
            }
        } else {

            $resCatTotal = mysqli_query($con, "SELECT COALESCE(SUM(SeatsNo), 0) AS SeatsNo FROM category_master WHERE EventId = '$eid'");
            if (mysqli_num_rows($resCatTotal)>0){
                
                $resCatTotal = mysqli_fetch_assoc($resCatTotal);
                $quantity_avail +=  $resCatTotal['SeatsNo'];
            }

            $res_sold = mysqli_query($con, "SELECT COALESCE(SUM(sales_data.Quantity), 0) AS Quantity FROM sales_master JOIN sales_data ON 
            sales_master.BasketId = sales_data.BusketId WHERE sales_data.EventId = '$eid' AND sales_data.Status = TRUE AND 
            sales_master.EventId = '$eid' AND sales_master.SalesStatus = 'Placed' AND sales_master.IsSoldByAjent = FALSE");
            if(mysqli_num_rows($res_sold)>0){

                $res_sold = mysqli_fetch_assoc($res_sold);
                $quantity +=  $res_sold['Quantity'];
            }

            $res_aj_sold = mysqli_query($con, "SELECT COALESCE(SUM(Quantity), 0) AS Quantity FROM ticket_allocation WHERE EventId = '$eid'");
            if(mysqli_num_rows($res_aj_sold)>0){
                
                $res_aj_sold = mysqli_fetch_assoc($res_aj_sold);
                $quantity +=  $res_aj_sold['Quantity'];
            }
        }

        if (($quantity_avail - $quantity) > 0) {

            return true;
        } else {

            return false;
        }
    }

    
    require_once './pages/header.php';
    require_once './pages/slider.php';
?>


            <?php
                $eProducts = mysqli_query($conn, "SELECT * FROM event_master WHERE EventStatus = 'Publish' AND BookingStatus = true"); 
                if (mysqli_num_rows($eProducts) > 0) {
                    ?>
                    <div class="w3l-products-1">
                        <div id="products1-block" class="text-center">
                            <div class="wrapper">
                                <div class="section-title align-center text-center">
                                    <h4 style="font-style: ProximaNovaRegular;" >Find The Perfect Event For You</h4>
                                </div>
                                <div class="d-grid grid-col-3">

                                <?php
                                while ($eResult = mysqli_fetch_assoc($eProducts)) {
                                ?>

                                    <div class="product card h-100">
                                        <a href="bookings.php?source=<?php echo $eResult['EM_Id'];?>"><img src="<?php if (empty($eResult['Image1'])) { echo './superadmin/event-image/product-preview.png'; } else { echo './superadmin/' . $eResult['Image1']; }?>" class="img-responsive" alt="" style="height: 275px;"></a>
                                        <div class="info-bg">
                                            
                                            <ul class="d-flex">
                                                <li><h5><a href="bookings.php?source=<?php echo $eResult['EM_Id'];?>"><?php echo $eResult['EventName']; ?></a></h5></li>
                                                <li class="margin-effe"><?php echo date_format(date_create($eResult['StartDate']), 'M-d'); ?></li>
                                            </ul>
                                            
                                            <small style="margin-top: 9px;"><i class="fa fa-map-marker"> </i> <?php echo $eResult['EventLocation']; ?></small>

                                            <ul class="d-flex" style="margin-top: 9px;">
                                                <li><small>Start From </small>
                                                <span style="font-size: 18px;color:#c4801c;">
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
                                                </span>
                                                </li>
                                                <?php
                                                    if (ticketAvailable($conn, $eResult['EM_Id'])){
                                                        ?>
                                                        <li class="margin-effe"><a href="#" data-bs-toggle="modal" data-bs-target="#product<?php echo $eResult['EM_Id'];?>"><span class="fa fa-shopping-cart"></span></a></li>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <li class="margin-effe"><small class="text-danger">Sold Out</small></li>
                                                        <?php
                                                    }
                                                ?>
                                                
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="product<?php echo $eResult['EM_Id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form method="POST">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" style="color: black;" id="exampleModalLabel">Confirm Your Ticket</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                            <div class="row">
                                                                <div class="col-8 text-left">
                                                                    <h5 style="color: black;"><?php echo $eResult['EventName'];?></h5>
                                                                </div>
                                                                <div class="col-4 text-right">
                                                                    <h6 style="color: black;"><?php echo date_format(date_create($eResult['StartDate']), 'M-d'); ?></h6>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-2" style="border-radius: 5px; border-width:1px; border-color:#cd9c50;border-style: solid;">
                                                                <div class="col-8 text-left"><small><strong>Category</strong></small></div>
                                                                <div class="col-4 text-right"><small><strong>Price</strong></small></div>
                                                                <?php
                                                                    $resCatData = mysqli_query($conn, "SELECT PriceCategoryName, PriceCategoryId FROM category_master WHERE EventId = '$eResult[EM_Id]' AND NOT PriceCategoryName LIKE 'comp%'");
                                                                    while($rowCatData = mysqli_fetch_assoc($resCatData)) {

                                                                        $resTypeDate = mysqli_query($conn, "SELECT price_master.PriceNet, pricetype_master.PriceTypeId, pricetype_master.PriceTypeName FROM price_master JOIN pricetype_master ON price_master.PriceTypeId = pricetype_master.PriceTypeId WHERE price_master.EventId = '$eResult[EM_Id]' AND pricetype_master.EventId = '$eResult[EM_Id]' AND price_master.PriceCategoryId='$rowCatData[PriceCategoryId]' AND NOT pricetype_master.PriceTypeName ='COMP'");
                                                                        while ($rowTypeData = mysqli_fetch_assoc($resTypeDate)) {

                                                                            if (mysqli_num_rows($resTypeDate) > 0) {
                                                                                if (mysqli_num_rows($resTypeDate)>1){
                                                                                    
                                                                                    $mPrice = number_format(($rowTypeData['PriceNet']/100), 2)." AED";

                                                                                    echo "<div class='col-8 text-left'><small>$rowCatData[PriceCategoryName] ($rowTypeData[PriceTypeName])</small></div>
                                                                                    <div class='col-4 text-right'><small>$mPrice</small></div>";

                                                                                } else {
                                                                                    $mPrice = number_format(($rowTypeData['PriceNet']/100), 2)." AED";

                                                                                    echo "<div class='col-8 text-left'><small>$rowCatData[PriceCategoryName]</small></div>
                                                                                    <div class='col-4 text-right'><small>$mPrice</small></div>";
                                                                                }
                                                                            }
                                                                        }                                                                  
                                                                    }
                                                                ?>
                                                            </div>

                                                            <div class="row mt-4">
                                                                <div class="col-4">Category
                                                                    <input type="hidden" name="cartEventId" value="<?php echo $eResult['EM_Id'];?>"/>
                                                                </div>
                                                                <div class="col-8">
                                                                    <select id="categoryId<?php echo $eResult['EM_Id'];?>" name="cart_category" class="form-select" aria-label="Category" required onchange="getTypeDataProduct('<?php echo $eResult['EM_Id'];?>')">
                                                                        <option value="">Choose..</option>
                                                                        <?php
                                                                            $resCat = mysqli_query($conn, "SELECT PriceCategoryName, PriceCategoryId FROM category_master WHERE EventId = '$eResult[EM_Id]' AND NOT PriceCategoryName LIKE 'Compl%'");
                                                                            if (mysqli_num_rows($resCat) > 0) {
                                                                                while ($rowCat = mysqli_fetch_assoc($resCat)) {
                                                                                    echo "<option value='".$rowCat['PriceCategoryId']."'> " . $rowCat['PriceCategoryName'] . "</option>";
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-4">
                                                                <div class="col-4" id="typeText<?php echo $eResult['EM_Id'];?>"></div>
                                                                <div class="col-8">
                                                                    <select hidden class="form-select" name="cart_type" aria-label="Price Type" id="typeId<?php echo $eResult['EM_Id'];?>" required onchange="getTypePriceProduct('<?php echo $eResult['EM_Id'];?>')">
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-4">
                                                                <div class="col-4">Quantity</div>
                                                                <div class="col-8">
                                                                    <select id="ticketQuantity<?php echo $eResult['EM_Id'];?>" name="cart_quantity" class="form-select" aria-label="Default select example" required onchange="getQuantityPriceproduct('<?php echo $eResult['EM_Id'];?>')">
                                                                        <option value="">Choose..</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                        <option value="6">6</option>
                                                                        <option value="7">7</option>
                                                                        <option value="8">8</option>
                                                                        <option value="9">9</option>
                                                                        <option value="10">10</option>
                                                                    </select>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row p-3">
                                                        <div class="col-8">
                                                            <h5><strong>Total: <span id="cartTotal<?php echo $eResult['EM_Id'];?>">0.00 AED</span></strong></h5>
                                                        </div>
                                                        <div class="col-4">
                                                            <button type="submit" name="add_to_cart" class="btn btn-sm" style="background-color: #4CAF50;border: none;color:white;">Apply</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                            
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php

                }

    require_once './pages/upcoming-events.php';

    $resVission = mysqli_query($conn, "SELECT Status FROM vission_master WHERE Status = 1");

    if(mysqli_num_rows($resVission)>0){

        ?>

            <style>
                .img_trn:hover {
                    transform: scale(1.2);
                }
            </style>

            <div class="row bg-light">
                <div class="col-lg-6 col-md-12 col-sm-12 text-center text-light" style="
                    padding-right: 6% !important;
                    padding-bottom: 3% !important;
                    padding-left: 6% !important;
                    background-image: url(assets/images/bg-banner.jpg) !important;
                    background-position: center !important;
                    background-repeat: no-repeat !important;
                    background-size: cover !important;">

                    <img src="assets/images/mission.png" style="display: inline-block;
                        padding-top: 35px;
                        font-size: 60px;
                        width: 1em;
                        max-width: 100%;
                        -moz-box-sizing: content-box!important;
                        -webkit-box-sizing: content-box!important;
                        box-sizing: content-box!important;">

                    <h3 style="font-size: 22px;
                        line-height: 32px;
                        margin: 10px 0 10px;
                        color:#ffffff;">Mission</h3>
                                                    
                    <p style="margin-bottom: 10px;    
                        font-family: inherit!important;
                        font-weight: inherit!important;
                        font-size: inherit!important;
                        font-style: inherit!important;
                        color: inherit!important;
                        line-height: inherit!important;
                        font-size: 15px !important;
                        line-height: 26px !important;">
                        To take each client's event to the next level by considering their requirements and ensuring the quality of our services.</p>

                    <img src="assets/images/vision.png" style="display: inline-block;
                        padding-top: 35px;
                        font-size: 60px;
                        width: 1em;
                        max-width: 100%;
                        -moz-box-sizing: content-box!important;
                        -webkit-box-sizing: content-box!important;
                        box-sizing: content-box!important;">

                    <h3 style="font-size: 22px;
                        line-height: 32px;
                        margin: 10px 0 10px;
                        color:#ffffff;">Vision</h3>
                                                    
                    <p style="margin-bottom: 10px;    
                        font-family: inherit!important;
                        font-weight: inherit!important;
                        font-size: inherit!important;
                        font-style: inherit!important;
                        color: inherit!important;
                        line-height: inherit!important;
                        font-size: 15px !important;
                        line-height: 26px !important;">
                        To be successful in our operating business industry, locally and internationally, while simultaneously being environmentally, socially and ethically responsible.</p>

                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <h3 style="font-weight:normal;
                        text-align:center;
                        color:#000000;
                        margin-bottom:10px;
                        font-family: Poppins;
                        font-size: 32px;
                        line-height: 42px;
                        margin-top:35px;">OUR SERVICES</h3>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12 text-center mt-4">
                            <div style="font-size: 100px;
                                border-style: dashed;
                                border-color: #333333;
                                border-width: 1px;
                                padding: 0px;
                                display: inline-block;
                                border-radius: 100%!important;
                                width: 100px!important;
                                height: 100px!important;">

                                <img class="img_trn" src="./assets/images/corporate.jpg" style="border-radius: 100%!important;
                                    width: 99px!important;
                                    height: 98px!important;
                                    box-shadow: none!important;
                                    display: block;
                                    font-size: inherit;
                                    transition: transform .2s linear;">
                                
                            </div>
                            
                            <h3 style="font-size: 17px;
                                font-weight:bold;
                                color: #333;
                                margin: 10px 0 10px;
                                line-height: 25px;">Corporate Events</h3>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 text-center mt-4">
                            <div style="font-size: 100px;
                                border-style: dashed;
                                border-color: #333333;
                                border-width: 1px;
                                padding: 0px;
                                display: inline-block;
                                border-radius: 100%!important;
                                width: 100px!important;
                                height: 100px!important;">

                                <img class="img_trn" src="./assets/images/public.jpg" style="border-radius: 100%!important;
                                    width: 99px!important;
                                    height: 98px!important;
                                    box-shadow: none!important;
                                    display: block;
                                    font-size: inherit;
                                    transition: transform .2s linear;">
                            </div>

                            <h3 style="font-size: 17px;
                                font-weight:bold;
                                color: #333;
                                margin: 10px 0 10px;
                                line-height: 25px;">Public Events</h3>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 text-center mt-4">
                            <div style="font-size: 100px;
                                border-style: dashed;
                                border-color: #333333;
                                border-width: 1px;
                                padding: 0px;
                                display: inline-block;
                                border-radius: 100%!important;
                                width: 100px!important;
                                height: 100px!important;">

                                <img class="img_trn" src="./assets/images/privatee.jpg" style="border-radius: 100%!important;
                                    width: 99px!important;
                                    height: 98px!important;
                                    box-shadow: none!important;
                                    display: block;
                                    font-size: inherit;
                                    transition: transform .2s linear;">
                            </div>

                            <h3 style="font-size: 17px;
                                font-weight:bold;
                                color: #333;
                                margin: 10px 0 10px;
                                line-height: 25px;">Private Events</h3>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 text-center mt-4">
                            <div style="font-size: 100px;
                                border-style: dashed;
                                border-color: #333333;
                                border-width: 1px;
                                padding: 0px;
                                display: inline-block;
                                border-radius: 100%!important;
                                width: 100px!important;
                                height: 100px!important;">

                                <img class="img_trn" src="./assets/images/general.jpg" style="border-radius: 100%!important;
                                    width: 99px!important;
                                    height: 98px!important;
                                    box-shadow: none!important;
                                    display: block;
                                    font-size: inherit;
                                    transition: transform .2s linear;">
                                
                            </div>
                            
                            <h3 style="font-size: 17px;
                                font-weight:bold;
                                color: #333;
                                margin: 10px 0 10px;
                                line-height: 25px;">General Services</h3>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 text-center mt-4">
                            <div style="font-size: 100px;
                                border-style: dashed;
                                border-color: #333333;
                                border-width: 1px;
                                padding: 0px;
                                display: inline-block;
                                border-radius: 100%!important;
                                width: 100px!important;
                                height: 100px!important;">

                                <img class="img_trn" src="./assets/images/tickt.jpg" style="border-radius: 100%!important;
                                    width: 99px!important;
                                    height: 98px!important;
                                    box-shadow: none!important;
                                    display: block;
                                    font-size: inherit;
                                    transition: transform .2s linear;">
                                
                            </div>
                            
                            <h3 style="font-size: 17px;
                                font-weight:bold;
                                color: #333;
                                margin: 10px 0 10px;
                                line-height: 25px;">Event Ticket Printing Services</h3>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 text-center mt-4">
                            <div style="font-size: 100px;
                                border-style: dashed;
                                border-color: #333333;
                                border-width: 1px;
                                padding: 0px;
                                display: inline-block;
                                border-radius: 100%!important;
                                width: 100px!important;
                                height: 100px!important;">

                                <img class="img_trn" src="./assets/images/epermit.jpg" style="border-radius: 100%!important;
                                    width: 99px!important;
                                    height: 98px!important;
                                    box-shadow: none!important;
                                    display: block;
                                    font-size: inherit;
                                    transition: transform .2s linear;">
                                
                            </div>
                            
                            <h3 style="font-size: 17px;
                                font-weight:bold;
                                color: #333;
                                margin: 10px 0 10px;
                                line-height: 25px;">E-Permit Application Services</h3>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
    require_once './pages/newsletter.php';
?>

<div class="cd-cart js-cd-cart">
	<a href="#" class="cd-cart__trigger text-replace">
		<ul class="cd-cart__count">
			<li><?php if (isset($_SESSION['cart_item'])) {echo sizeof($_SESSION['cart_item']);} else {echo "0";}?></li>
			<li></li>
		</ul>
	</a>

	<div class="cd-cart__content">
		<div class="cd-cart__layout">
			<header class="cd-cart__header">
				<h2>Your Cart</h2>
			</header>

            <?php 
                $cart_count=0;
                $total_price = 0;

                if (isset($_SESSION['cart_item'])) {
                    $cart_count = sizeof($_SESSION['cart_item']);
                }
                if ($cart_count > 0) {
                    ?>
                        <div class="cd-cart__body">
                            <ul>

                                <?php
                                    foreach ($_SESSION['cart_item'] as $item) {
                                        $categoryID = $item['cart_category'];
                                        $typeID = $item['cart_type'];
                                        $eventID = $item['cartEventId'];
                                        $ticketQuantity = $item['cart_quantity'];

                                        $resCartItem = mysqli_query($conn, "SELECT event_master.EventName, event_master.EM_Id, category_master.PriceCategoryName, pricetype_master.PriceTypeName, price_master.PriceNet  FROM price_master JOIN pricetype_master ON price_master.PriceTypeId = pricetype_master.PriceTypeId JOIN category_master ON category_master.PriceCategoryId = price_master.PriceCategoryId JOIN event_master ON event_master.EM_Id = price_master.EventId WHERE price_master.EventId = '$eventID' AND price_master.PriceCategoryId = '$categoryID' AND price_master.PriceTypeId = '$typeID' AND pricetype_master.EventId = '$eventID' AND event_master.EM_Id = '$eventID' AND category_master.EventId = '$eventID'");

                                        if (mysqli_num_rows($resCartItem) > 0) {
                                            $resCartItem = mysqli_fetch_assoc($resCartItem);
                                            $itemPrice = ($resCartItem['PriceNet'] /100) * $ticketQuantity ;
                                            $total_price += $itemPrice;
                                            ?>
                                            <li class="cd-cart__product">
                                                <div class="cd-cart__details">
                                                    <h3 class="truncate"><a href="bookings.php?source=<?php echo $resCartItem['EM_Id'];?>"><?php echo $resCartItem['EventName'];?></a></h3>

                                                    <span class="cd-cart__price"><?php echo number_format($itemPrice, 2) . " AED";?></span>
                                                    
                                                    <div class="col-12"><small><?php echo $resCartItem['PriceCategoryName'] . " : " . $resCartItem['PriceTypeName'] ;?></small></div>
                                                    
                                                    <div class="cd-cart__actions">
                                                        <a href="index.php?delete_cart_item&cart_categorys=<?php echo $categoryID;?>&cart_types=<?php echo $typeID;?>&cartEventIds=<?php echo $eventID;?>" class="cd-cart__delete-item text-danger">Delete</a>

                                                        <div class="cd-cart__quantity">
                                                            <label for="cd-product-productId">Qty</label>
                                                            <span class="cd-cart__select"><?php echo $ticketQuantity; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                            <?php

                                        } else {
                                            echo "<script>location.href='index.php';</script>";
                                        }
                                    }
                                ?>
                            </ul>
                        </div>

                        <footer class="cd-cart__footer">
                            <a href="my-cart.php" class="cd-cart__checkout">
                                <em>Checkout - <span><?php echo number_format($total_price, 2)?></span>
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><g fill="none" stroke="currentColor"><line stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x1="3" y1="12" x2="21" y2="12"/><polyline stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="15,6 21,12 15,18 "/></g></svg>
                                </em>
                            </a>
                        </footer>
                    <?php
                } else {
                    echo "<div class='cd-cart__body'><ul><li>No items in your cart..</li></ul></div>";
                }
            ?>
			
			
		</div>
	</div>
</div>

<?php
    require_once './pages/footer.php';
?>