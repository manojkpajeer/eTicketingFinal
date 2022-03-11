<?php 
    session_start();

    require_once './config/connection.php';
    require_once './pages/link.php';
    require_once './pages/header.php';
	require_once './api/maestro_util.php';

    $cart_count = 0;
    if (isset($_SESSION['cart_item'])) {
        $cart_count = sizeof($_SESSION['cart_item']);
    }

    if (isset($_POST['add_quantity'])) {
      foreach ($_SESSION["cart_item"] as $k => $v) {

        if($_POST['add_quantity'] == $k) {

            if(empty($_SESSION["cart_item"][$k]["cart_quantity"])) {

                $_SESSION["cart_item"][$k]["cart_quantity"] = 1;
            }
            if ($_SESSION["cart_item"][$k]["cart_quantity"] < 10) {
                $_SESSION["cart_item"][$k]["cart_quantity"] += 1;
            }
        }
      }
    }

    if (isset($_POST['remove_quantity'])) {
      foreach ($_SESSION["cart_item"] as $k => $v) {

        if($_POST['remove_quantity'] == $k) {

            if(empty($_SESSION["cart_item"][$k]["cart_quantity"])) {

                $_SESSION["cart_item"][$k]["cart_quantity"] = 0;
            }
            else if ($_SESSION["cart_item"][$k]["cart_quantity"] > 1) {
              $_SESSION["cart_item"][$k]["cart_quantity"] -= 1;
            }
        }
      }
    }

    if (isset($_POST['checkoutCart'])) {

		$api = new MaestroUtil();

		if(isset($_SESSION['is_customer_login'])){

            if($_SESSION['is_customer_login']){
                
				$customerID = $_SESSION['customer_id'];
				$total_prices = 0;
                $isAvail = true;
                $eventIDm = "0";
                
				foreach($_SESSION["cart_item"] as $item) {
                
                    $quantity_sold = 0;
        			$quantity_avail = 0;
                    $eventIDm = $item['cartEventId'];

                    $resComp = mysqli_query($conn, "SELECT PriceCategoryId FROM category_master WHERE EventId = '$item[cartEventId]' AND PriceCategoryName LIKE 'comp%'");
                    if (mysqli_num_rows($resComp)>0){

                        $resComp = mysqli_fetch_assoc($resComp);
                        $compId = $resComp['PriceCategoryId'];

                        $resCatTotal = mysqli_query($conn, "SELECT COALESCE(SUM(SeatsNo), 0) AS SeatsNo FROM category_master WHERE EventId = '$item[cartEventId]' AND NOT PriceCategoryId = '$compId'");
                        if (mysqli_num_rows($resCatTotal)>0){
                            
                            $resCatTotal = mysqli_fetch_assoc($resCatTotal);
                            $quantity_avail +=  $resCatTotal['SeatsNo'];
                        }

                        $res_sold = mysqli_query($conn, "SELECT COALESCE(SUM(sales_data.Quantity), 0) AS Quantity FROM sales_master JOIN sales_data ON 
                        sales_master.BasketId = sales_data.BusketId WHERE sales_data.EventId = '$item[cartEventId]' AND sales_data.Status = TRUE AND 
                        sales_master.EventId = '$item[cartEventId]' AND sales_master.SalesStatus = 'Placed' AND sales_master.IsSoldByAjent = FALSE AND NOT sales_data.CategoryId = '$compId'");
                        if(mysqli_num_rows($res_sold)>0){

                            $res_sold = mysqli_fetch_assoc($res_sold);
                            $quantity_sold +=  $res_sold['Quantity'];
                        }

                        $res_aj_sold = mysqli_query($conn, "SELECT COALESCE(SUM(Quantity), 0) AS Quantity FROM ticket_allocation WHERE EventId = '$item[cartEventId]' AND NOT CategoryId = '$compId'");
                        if(mysqli_num_rows($res_aj_sold)>0){
                            
                            $res_aj_sold = mysqli_fetch_assoc($res_aj_sold);
                            $quantity_sold +=  $res_aj_sold['Quantity'];
                        }
                    } else {

                        $resCatTotal = mysqli_query($conn, "SELECT COALESCE(SUM(SeatsNo), 0) AS SeatsNo FROM category_master WHERE EventId = '$item[cartEventId]'");
                        if (mysqli_num_rows($resCatTotal)>0){
                            
                            $resCatTotal = mysqli_fetch_assoc($resCatTotal);
                            $quantity_avail +=  $resCatTotal['SeatsNo'];
                        }

                        $res_sold = mysqli_query($conn, "SELECT COALESCE(SUM(sales_data.Quantity), 0) AS Quantity FROM sales_master JOIN sales_data ON 
                        sales_master.BasketId = sales_data.BusketId WHERE sales_data.EventId = '$item[cartEventId]' AND sales_data.Status = TRUE AND 
                        sales_master.EventId = '$item[cartEventId]' AND sales_master.SalesStatus = 'Placed' AND sales_master.IsSoldByAjent = FALSE");
                        if(mysqli_num_rows($res_sold)>0){

                            $res_sold = mysqli_fetch_assoc($res_sold);
                            $quantity_sold +=  $res_sold['Quantity'];
                        }

                        $res_aj_sold = mysqli_query($conn, "SELECT COALESCE(SUM(Quantity), 0) AS Quantity FROM ticket_allocation WHERE EventId = '$item[cartEventId]'");
                        if(mysqli_num_rows($res_aj_sold)>0){
                            
                            $res_aj_sold = mysqli_fetch_assoc($res_aj_sold);
                            $quantity_sold +=  $res_aj_sold['Quantity'];
                        }
                    }

                    if ((($quantity_avail - $quantity_sold) - $item['cart_quantity']) < 0) {

                        $isAvail = false;
                    }
                }
                

                if ($isAvail) {

                    $basketID = rand(111111, 999999);
                    // $basketID = $api->createBasketArray ($_SESSION["cart_item"]);

                    if (empty($basketID)) {
                        echo "<script>alert('Oops, Unable to process..');</script>";
                    } else {

                        $insertSalesData = "INSERT INTO sales_data (CategoryId, TypeId, Quantity, EventId, Status, BusketId, DateCreate) VALUES ";
                        $i = 0;

                        foreach($_SESSION["cart_item"] as $item) {
                            $eventids = $item['cartEventId'];

                            if ($i > 0) {
                                $insertSalesData .= ", ";
                            }

                            $insertSalesData .= "('$item[cart_category]', '$item[cart_type]', '$item[cart_quantity]', '$item[cartEventId]', 0, '$basketID', NOW())";

                            $i++;
                        }
                        
                        if (mysqli_query($conn, $insertSalesData)) {

                            unset($_SESSION["cart_item"]);
                            echo "<script>location.href='make-payment.php?bsk=$basketID&pid=$eventIDm';</script>";
                        } else {
                            echo "<script>alert('Oops, Unable to process..');</script>";
                        }
                    } 
                } else {

                    echo "<script>alert('Oops, Tickets not available..');</script>";
                }
            } else {
                echo "<script>alert('Oops, Kindly login to proceed..');location.href='login.php';</script>";
            }
        } else {
            echo "<script>alert('Oops, Kindly login to proceed..');location.href='login.php';</script>";
        }
    }
    
?>



<section class="w3l-ecom-cart">
    <div class="covers-main">
        <div class="wrapper">
            <h2 class="my-3">Your Cart</h2>

            <?php 
                $cart_count=0;
                $total_price = 0;

                if (isset($_SESSION['cart_item'])) {
                    $cart_count = sizeof($_SESSION['cart_item']);
                }
                if ($cart_count > 0) {
                    ?>

                    <form method="POST">    
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>#</th>
                                        <th>Ticket Details</th>
                                        <th class="text-left">Quantity</th>
                                        <th class='text-center'>Price</th>
                                        <th class='text-center'>Total</th>
                                    </tr>
                                    <?php
                                        $count = 1;

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
                                                
                                                echo "<tr>";
                                                echo "<td>$count</td>";
                                                echo "<td><a style='color:#c4801c' href='product-single.php?pid=$resCartItem[EM_Id]'>$resCartItem[EventName]</a><p>$resCartItem[PriceCategoryName] : $resCartItem[PriceTypeName]</p></td>";
                                                echo "<td class='text-center'>"; 
                                                ?>
                                                <div class="text-center">
                                                <button class="btn btn-primary p-1 float-start" style="height: 30px;" name="add_quantity" value="<?php echo $item['item'];?>">+</button>
                                                <input class="float-start" style="width:36%;height: 30px;border-style:solid;border-color:#c4801c;border-width:1px" name="quantity" value="<?php echo $ticketQuantity; ?>" type="number" readonly min="1">
                                                <button class="btn btn-primary p-1 float-start" style="height: 30px;" name="remove_quantity" value="<?php echo $item['item'];?>">-</button>
                                                </div>
                                                
                                                <?php
                                                echo "</td>";
                                                echo "<td class='text-right'>".number_format($itemPrice, 2) . " AED</td>";
                                                
                                                echo "<td class='text-right'>".number_format(($itemPrice * $ticketQuantity), 2) . " AED</td>";
                                                echo "</tr>";
                                                
                                                $count++;

                                            } else {
                                                echo "<script>location.href='product-single.php?pid='".$_GET['pid']."	';</script>";
                                            }
                                        }
                                    ?>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-9 col-sm-12 col-md-8">
                            </div>
                            <div class="col-lg-3 col-sm-12 col-md-4">
                                <div class="top-content">
                                    <div class="totals">
                                        <div class="totals-item totals-item-total h5">
                                            <label>To Pay</label>
                                            <div class="totals-value" id="cart-total"><?php echo number_format($total_price, 2) . " AED"; ?></div>
                                        </div>
                                        <button class="btn button-eff checkout" name="checkoutCart" value="<?php echo $total_price;?>">Checkout</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php
                } else {
                    echo "<h3>No items in your cart..</h3>";
                }
            ?>
        </div>
    </div>
</section>

<?php
    require_once './pages/newsletter.php';
    require_once './pages/footer.php';
?>