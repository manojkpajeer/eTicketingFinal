<?php 
    session_start();

    include './config/connection.php';
    require_once './pages/link.php';
	require_once './api/maestro_util.php';

    $eProducts = mysqli_query($conn, "SELECT * FROM event_master WHERE EM_Id = '$_GET[source]' "); 
    if (mysqli_num_rows($eProducts) > 0) {
        $eProducts = mysqli_fetch_assoc($eProducts);
    } else {
        echo "<script>alert('Oops, Unable to process..');location.href='index.php';</script>";
    }

	if (isset($_GET['delete_cart_item'])) {
        $cart_types = $_GET['cart_types'];
        $cart_categorys = $_GET['cart_categorys'];
        $cartEventIds = $eProducts['EM_Id'];
        
		$items = $cartEventIds . $cart_categorys . $cart_types;
        unset($_SESSION['cart_item'][$items]);

        echo "<script>location.href='bookings.php?source=".$_GET['source']."';</script>";
      }

    if (isset($_POST['add_to_cart'])) {

       	$cart_quantity = $_POST['cart_quantity'];
        $cart_type = $_POST['cart_type'];
        $cart_category = $_POST['cart_category'];
        $cartEventId = $eProducts['EM_Id'];

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
 
	if (isset($_POST['checkOut'])) {

		$resDateCheck = mysqli_query($conn, "SELECT * FROM event_master WHERE EventStatus = 'Publish' AND EM_Id = '$_GET[source]' AND BookingStatus = true");

		if(mysqli_num_rows($resDateCheck) > 0) {

			$api = new MaestroUtil();

			if(isset($_SESSION['is_customer_login'])){
	
				if($_SESSION['is_customer_login']){
					
					$cart_quantitya = $_POST['cart_quantityc'];
					$cart_typea = $_POST['cart_typec'];
					$cart_categorya = $_POST['cart_categoryc'];
					$cartEventIda = $eProducts['EM_Id'];
					$customerID = $_SESSION['cm_id'];

					$quantity_sold = 0;
        			$quantity_avail = 0;

					$resComp = mysqli_query($conn, "SELECT PriceCategoryId FROM category_master WHERE EventId = '$cartEventIda' AND PriceCategoryName LIKE 'comp%'");
					if (mysqli_num_rows($resComp)>0){

						$resComp = mysqli_fetch_assoc($resComp);
						$compId = $resComp['PriceCategoryId'];

						$resCatTotal = mysqli_query($conn, "SELECT COALESCE(SUM(SeatsNo), 0) AS SeatsNo FROM category_master WHERE EventId = '$cartEventIda' AND NOT PriceCategoryId = '$compId'");
						if (mysqli_num_rows($resCatTotal)>0){
							
							$resCatTotal = mysqli_fetch_assoc($resCatTotal);
							$quantity_avail +=  $resCatTotal['SeatsNo'];
						}

						$res_sold = mysqli_query($conn, "SELECT COALESCE(SUM(sales_data.Quantity), 0) AS Quantity FROM sales_master JOIN sales_data ON 
						sales_master.BasketId = sales_data.BusketId WHERE sales_data.EventId = '$cartEventIda' AND sales_data.Status = TRUE AND 
						sales_master.EventId = '$cartEventIda' AND sales_master.SalesStatus = 'Placed' AND sales_master.IsSoldByAjent = FALSE AND NOT sales_data.CategoryId = '$compId'");
						if(mysqli_num_rows($res_sold)>0){

							$res_sold = mysqli_fetch_assoc($res_sold);
							$quantity_sold +=  $res_sold['Quantity'];
						}

						$res_aj_sold = mysqli_query($conn, "SELECT COALESCE(SUM(Quantity), 0) AS Quantity FROM ticket_allocation WHERE EventId = '$cartEventIda' AND NOT CategoryId = '$compId'");
						if(mysqli_num_rows($res_aj_sold)>0){
							
							$res_aj_sold = mysqli_fetch_assoc($res_aj_sold);
							$quantity_sold +=  $res_aj_sold['Quantity'];
						}
					} else {

						$resCatTotal = mysqli_query($conn, "SELECT COALESCE(SUM(SeatsNo), 0) AS SeatsNo FROM category_master WHERE EventId = '$cartEventIda'");
						if (mysqli_num_rows($resCatTotal)>0){
							
							$resCatTotal = mysqli_fetch_assoc($resCatTotal);
							$quantity_avail +=  $resCatTotal['SeatsNo'];
						}

						$res_sold = mysqli_query($conn, "SELECT COALESCE(SUM(sales_data.Quantity), 0) AS Quantity FROM sales_master JOIN sales_data ON 
						sales_master.BasketId = sales_data.BusketId WHERE sales_data.EventId = '$cartEventIda' AND sales_data.Status = TRUE AND 
						sales_master.EventId = '$cartEventIda' AND sales_master.SalesStatus = 'Placed' AND sales_master.IsSoldByAjent = FALSE");
						if(mysqli_num_rows($res_sold)>0){

							$res_sold = mysqli_fetch_assoc($res_sold);
							$quantity_sold +=  $res_sold['Quantity'];
						}

						$res_aj_sold = mysqli_query($conn, "SELECT COALESCE(SUM(Quantity), 0) AS Quantity FROM ticket_allocation WHERE EventId = '$cartEventIda'");
						if(mysqli_num_rows($res_aj_sold)>0){
							
							$res_aj_sold = mysqli_fetch_assoc($res_aj_sold);
							$quantity_sold +=  $res_aj_sold['Quantity'];
						}
					}

					if ((($quantity_avail - $quantity_sold) - $cart_quantitya) >= 0) {

						$basketID = rand(111111, 999999);
						// $basketID = $api->createBasketSingle ($cartEventIda, $cart_categorya, $cart_typea, $cart_quantitya);

						if (empty($basketID)) {
							
							echo "<script>alert('Oops, Unable to process..');</script>";
						} else {
							
							if (mysqli_query($conn, "INSERT INTO sales_data (CategoryId, TypeId, Quantity, EventId, Status, BusketId, DateCreate) VALUES ('$cart_categorya', '$cart_typea', '$cart_quantitya', '$cartEventIda', 0, '$basketID', NOW()) ")) {
		
								echo "<script>location.href='make-payment.php?bsk=$basketID&pid=$_GET[source]';</script>";
							} else {
								echo "<script>alert('Oops, Unable to process..');</script>";
							}
							
						}
					} else {
			
						echo "<script>alert('Oops, Tickets not available..');</script>";
					}

				} else {
					echo "<script>location.href='login.php';</script>";
				}
			} else {
				echo "<script>location.href='login.php';</script>";
			}
		} else {

			echo "<script>alert('Oops, Booking line closed..');</script>";
		}
	}

	
    require_once './pages/header.php';

?>

<!-- <section class="w3l-inner-banner-main">
    <div class="about-inner">
        <div class="wrapper">
            <ul class="breadcrumbs-custom-path">
                <h3>Event Details</h3>
                <li><a href="index.html">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a></li>
                <li class="active">Event</li>
            </ul>
        </div>
    </div>
</section> -->

<script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
<script src="https://js.stripe.com/v3/"></script>

<section class="w3l-features-photo-7">
	<div class="w3l-features-photo-7_sur">
		<div class="wrapper">
			<div class="w3l-features-photo-7_top">
				<div class="w3l-features-photo-7_top-right">
					<div class="galleryContainer">
						<div class="gallery">
							<input type="radio" name="controls" id="c1" checked><img class="galleryImage" id="i1"
								src="<?php if (empty($eProducts['Image2'])) { echo './superadmin/event-image/product-preview.png'; } else { echo './superadmin/' . $eProducts['Image1']; }?>" class="img img-responsive" alt="">
							<input type="radio" name="controls" id="c2"><img class="galleryImage" id="i2"
								src="<?php if (empty($eProducts['Image2'])) { echo './superadmin/event-image/product-preview.png'; } else { echo './superadmin/' . $eProducts['Image2']; }?>" class="img img-responsive" alt="">
							<input type="radio" name="controls" id="c3"><img class="galleryImage" id="i3"
								src="<?php if (empty($eProducts['Image2'])) { echo './superadmin/event-image/product-preview.png'; } else { echo './superadmin/' . $eProducts['Image3']; }?>" class="img img-responsive" alt="">
							<input type="radio" name="controls" id="c4"><img class="galleryImage" id="i4"
								src="<?php if (empty($eProducts['Image2'])) { echo './superadmin/event-image/product-preview.png'; } else { echo './superadmin/' . $eProducts['Image4']; }?>" class="img img-responsive" alt="">
						</div>
						<div class="thumbnails">
							<label class="thumbnailImage " for="c1"><img src="<?php if (empty($eProducts['Image2'])) { echo './superadmin/event-image/product-preview.png'; } else { echo './superadmin/' . $eProducts['Image1']; }?>"
									class="img img-responsive" alt=""></label>
							<label class="thumbnailImage" for="c2"><img src="<?php if (empty($eProducts['Image2'])) { echo './superadmin/event-image/product-preview.png'; } else { echo './superadmin/' . $eProducts['Image2']; }?>"
									class="img img-responsive" alt=""></label>
							<label class="thumbnailImage" for="c3"><img src="<?php if (empty($eProducts['Image3'])) { echo './superadmin/event-image/product-preview.png'; } else { echo './superadmin/' . $eProducts['Image3']; }?>"
									class="img img-responsive" alt=""></label>
							<label class="thumbnailImage" for="c4"><img src="<?php if (empty($eProducts['Image4'])) { echo './superadmin/event-image/product-preview.png'; } else { echo './superadmin/' . $eProducts['Image4']; }?>"
									class="img img-responsive" alt=""></label>
						</div>
					</div>
				</div>
				<div class="w3l-features-photo-7_top-left">
					<h4><?php echo $eProducts['EventName'];?></h4>
				
					<p class="coasts"><small>Start From</small>
						<span class="item_price">
						<?php 
							$resCartPrice = mysqli_query($conn, "SELECT MIN(PriceNet) as totPrice FROM price_master WHERE EventId = '$eProducts[EM_Id]' AND PriceNet > 0");
							if (mysqli_num_rows($resCartPrice)>0){

								$resCartPrice = mysqli_fetch_assoc($resCartPrice);
								$cPrice = $resCartPrice['totPrice']/100;
								if ($cPrice > 0) {

									echo number_format($cPrice, 2)." AED";
								}
							}
						?>
						</span>
						
					</p>
					<p class="para"><?php echo $eProducts['ShortDescription'];?></p>

					<section class="w3l-content-with-photo-23 mt-3" id="about">
						<div class="cwp23-title">
							<h4>Other Details</h4>
						</div>
						<div class="cwp23-text-cols" style="margin-top: 15px;">
							<div class="column">
								<h5>Event Start</h5>
								<p><?php echo date_format(date_create($eProducts['StartDate']), 'M d Y') .", ". date_format(date_create($eProducts['StartTime']), 'h i A'); ?></p>
							</div>
							<div class="column">
								<h5>Event End</h5>
								<p><?php echo date_format(date_create($eProducts['EndDate']), 'M d Y') .", ". date_format(date_create($eProducts['EndTime']), 'h i A'); ?></p>
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

					<div class="inline-cont mt-4">
						<a href="#" class="btn button-ecom1 p-0" data-bs-toggle="modal" data-bs-target="#buynow">Buy Now</a>
						<a href="#" class="btn button-ecom p-0" data-bs-toggle="modal" data-bs-target="#product">Add to Cart</a>
					</div>
				</div>
			</div>
			<div class="des-bottom">
				<div class="row">
					<div class="col-lg-6 col-sm-12 col-md-12">
						<h5>Description:-</h5>
						<p> <?php echo $eProducts['Description'];?></p>
					</div>
					<div class="col-lg-6 col-sm-12 col-md-12">
						<h5 class="">Location:-</h5>
						<iframe src="<?php echo $eProducts['LocationMap'];?>" width="100%" height="300" frameborder="0" style="border: 0px;" allowfullscreen=""></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade" id="product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
								<h5 style="color: black;"><?php echo $eProducts['EventName'];?></h5>
							</div>
							<div class="col-4 text-right">
								<h6 style="color: black;"><?php echo date_format(date_create($eProducts['StartDate']), 'M-d'); ?></h6>
							</div>
						</div>

						<div class="row mt-2" style="border-radius: 5px; border-width:1px; border-color:#cd9c50;border-style: solid;">
							<div class="col-8 text-left"><small><strong>Category</strong></small></div>
							<div class="col-4 text-right"><small><strong>Price</strong></small></div>
							<?php
								$resCatData = mysqli_query($conn, "SELECT PriceCategoryName, PriceCategoryId FROM category_master WHERE EventId = '$eProducts[EM_Id]' AND NOT PriceCategoryName LIKE 'Compl%'");
								while($rowCatData = mysqli_fetch_assoc($resCatData)) {

									$resTypeDate = mysqli_query($conn, "SELECT price_master.PriceNet, pricetype_master.PriceTypeId, pricetype_master.PriceTypeName FROM price_master JOIN pricetype_master ON price_master.PriceTypeId = pricetype_master.PriceTypeId WHERE price_master.EventId = '$eProducts[EM_Id]' AND pricetype_master.EventId = '$eProducts[EM_Id]' AND price_master.PriceCategoryId='$rowCatData[PriceCategoryId]' AND NOT pricetype_master.PriceTypeName ='COMP'");
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
							<div class="col-4">Category</div>
							<div class="col-8">
								<select id="categoryId" name="cart_category" class="form-select" aria-label="Category" required onchange="getTypeData('<?php echo $eProducts['EM_Id'];?>')">
									<option value="">Choose..</option>
									<?php
										$resCat = mysqli_query($conn, "SELECT PriceCategoryName, PriceCategoryId FROM category_master WHERE EventId = '$eProducts[EM_Id]' AND NOT PriceCategoryName LIKE 'Compl%'");
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
							<div class="col-4"  id="typeText"></div>
							<div class="col-8">
								<select hidden class="form-select" name="cart_type" aria-label="Price Type" id="typeId" required onchange="getTypePrice('<?php echo $eProducts['EM_Id'];?>')">
								</select>
							</div>
						</div>

						<div class="row mt-4">
							<div class="col-4">Quantity</div>
							<div class="col-8">
								<select id="ticketQuantity" name="cart_quantity" class="form-select" aria-label="Default select example" required onchange="getQuantityPrice('<?php echo $eProducts['EM_Id'];?>')">
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
						<h5><strong>Total: <span id="cartTotal">0.00 AED</span></strong></h5>
					</div>
					<div class="col-4">
						<button type="submit" name="add_to_cart" class="btn btn-sm" style="background-color: #4CAF50;border: none;color:white;">Apply</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="buynow" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<form method="POST" name="buyticket">
				<div class="modal-header">
					<h5 class="modal-title" style="color: black;" id="exampleModalLabel">Confirm Your Ticket</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-8 text-left">
								<h5 style="color: black;"><?php echo $eProducts['EventName'];?></h5>
							</div>
							<div class="col-4 text-right">
								<h6 style="color: black;"><?php echo date_format(date_create($eProducts['StartDate']), 'M-d'); ?></h6>
							</div>
						</div>

						<div class="row mt-2" style="border-radius: 5px; border-width:1px; border-color:#cd9c50;border-style: solid;">
							<div class="col-8 text-left"><small><strong>Category</strong></small></div>
							<div class="col-4 text-right"><small><strong>Price</strong></small></div>
							<?php
								$resCatData = mysqli_query($conn, "SELECT PriceCategoryName, PriceCategoryId FROM category_master WHERE EventId = '$eProducts[EM_Id]' AND NOT PriceCategoryName LIKE 'Compl%'");
								while($rowCatData = mysqli_fetch_assoc($resCatData)) {

									$resTypeDate = mysqli_query($conn, "SELECT price_master.PriceNet, pricetype_master.PriceTypeId, pricetype_master.PriceTypeName FROM price_master JOIN pricetype_master ON price_master.PriceTypeId = pricetype_master.PriceTypeId WHERE price_master.EventId = '$eProducts[EM_Id]' AND pricetype_master.EventId = '$eProducts[EM_Id]' AND price_master.PriceCategoryId='$rowCatData[PriceCategoryId]' AND NOT pricetype_master.PriceTypeName ='COMP'");
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
							<div class="col-4">Category</div>
							<div class="col-8">
								<select id="categoryIds" name="cart_categoryc" class="form-select" aria-label="Category" required onchange="getTypeDatas('<?php echo $eProducts['EM_Id'];?>')">
									<option value="">Choose..</option>
									<?php
										$resCat = mysqli_query($conn, "SELECT PriceCategoryName, PriceCategoryId FROM category_master WHERE EventId = '$eProducts[EM_Id]' AND NOT PriceCategoryName LIKE 'Compl%'");
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
							<div class="col-4"  id="typeTexts"></div>
							<div class="col-8">
								<select hidden class="form-select" name="cart_typec" aria-label="Price Type" id="typeIds" required onchange="getTypePrices('<?php echo $eProducts['EM_Id'];?>')">
								</select>
							</div>
						</div>

						<div class="row mt-4">
							<div class="col-4">Quantity</div>
							<div class="col-8">
								<select id="ticketQuantitys" name="cart_quantityc" class="form-select" aria-label="Default select example" required onchange="getQuantityPrices('<?php echo $eProducts['EM_Id'];?>')">
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
						<h5><strong>Total: <span id="cartTotals">0.00 AED</span></strong></h5>
					</div>
					<div class="col-4">
						<button type="submit" name="checkOut" class="btn btn-sm px-4 py-2" style="background-color: #4CAF50;border: none;color:white;">Proceed</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

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
                                                        <a href="bookings.php?source=<?php echo $_GET['source'];?>&delete_cart_item&cart_categorys=<?php echo $categoryID;?>&cart_types=<?php echo $typeID;?>&cartEventIds=<?php echo $eventID;?>" class="cd-cart__delete-item text-danger">Delete</a>

                                                        <div class="cd-cart__quantity">
                                                            <label for="cd-product-productId">Qty</label>
                                                            <span class="cd-cart__select"><?php echo $ticketQuantity; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                            <?php

                                        } else {
                                            echo "<script>location.href='bookings.php?source='".$_GET['source']."';</script>";
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
    require_once './pages/upcoming-events.php';
    require_once './pages/newsletter.php';
    require_once './pages/footer.php';
?>
