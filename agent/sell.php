<?php
    session_start();
        
    if(!isset($_SESSION['is_ajent_login'])){

        header('Location: ./pages/logout.php');
    }
    else{

        if(!$_SESSION['is_ajent_login']){
            
            header('Location: ./pages/logout.php');
        }
    }
        
    require_once '../config/connection.php';
    require_once './pages/link.php';
    require_once './pages/sidebar.php';
    require_once './pages/header.php';
    require_once '../api/maestro_util.php';

    if(isset($_POST['add'])){

        $eventId = $_GET['eid'];
        $priceTypeId = $_POST['type'];
        $categoryId = $_GET['cid'];
        $quantity = $_POST['quantity'];

        $item = $eventId . $categoryId . $priceTypeId;

        $itemArray = array(
            $item => array(
                'item' => $item, 
                'quantity' => $quantity, 
                'priceTypeId' => $priceTypeId, 
                'categoryId' => $categoryId, 
                'eventId' => $eventId
            )
        );

        if (empty($_SESSION["cart_item"])) {

            if ($_GET['ava'] >= $quantity) {

                $_SESSION["cart_item"] = $itemArray;
            } else {

                echo "<script>alert('Oops, Only ".$_GET['ava']." ticket left..');</script>";
            }
        } else {

            $quantityCheck = 0;
            foreach($_SESSION['cart_item'] as $items){
            
                $quantityCheck += $items['quantity'];
            }
        
            if ($_GET['ava'] >= ($quantity + $quantityCheck)) {

                if (in_array($item, array_keys($_SESSION["cart_item"]))) {

                    foreach ($_SESSION["cart_item"] as $k => $v) {
    
                        if($item == $k) {
    
                            if(empty($_SESSION["cart_item"][$k]["quantity"])) {
    
                                $_SESSION["cart_item"][$k]["quantity"] = 0;
                            }
                            $_SESSION["cart_item"][$k]["quantity"] += $quantity;
                        }
                    }
                } else {
                    
                    foreach($_SESSION['cart_item'] as $item){
    
                        if ($eventId == $item['eventId'] && $categoryId == $item['categoryId']) {
        
                            $_SESSION["cart_item"] += $itemArray;
                        } else {
                            echo "<script>alert('Oops, Unable to process...');location.href='manage.php';</script>";
                            unset($_SESSION["cart_item"]);
                        }
                    }
                }
            } else {

                echo "<script>alert('Oops, Ticket not available..');</script>";
            }
            
        }
    }

    if(isset($_POST['next'])){

        $api = new MaestroUtil();

        $basketID = rand(1000, 9999);
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

                $insertSalesData .= "('$item[categoryId]', '$item[priceTypeId]', '$item[quantity]', '$item[eventId]', 0, '$basketID', NOW())";

                $i++;
            }

            if (mysqli_query($conn, $insertSalesData)) {

                $total_prices = 0;
                foreach($_SESSION["cart_item"] as $item) {

                    $resTotalAmount = mysqli_query($conn, "SELECT PriceNet FROM price_master WHERE PriceCategoryId = '$item[categoryId]' AND PriceTypeId = '$item[priceTypeId]' AND EventId = '$item[eventId]' ");

                    if (mysqli_num_rows($resTotalAmount) > 0) {
                    
                        $resTotalAmount = mysqli_fetch_assoc($resTotalAmount);
                        $total_prices += $resTotalAmount['PriceNet'] * $item['quantity'];
                    }
                } 

                unset($_SESSION['cart_item']);

                echo "<script>location.href='sell-next.php?eid=$_GET[eid]&bsk=$basketID&tot=$total_prices';</script>";
            } else {
               
                echo "<script>alert('Oops, Unable to process..');</script>";
            }
        }
        
    }
?>

<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="row">
            <div class="col-xl-12 pr-xl-12">
                <div class="card card_border border-primary-top">
                    <div class="card-header chart-grid__header">Sell Ticket</div>
                        <div class="card-body">
                            <div class="row px-3">
                                <form method="post" class="row needs-validation" novalidate>
                                    <div class="col-6">
                                        <label for="validationCustom02" class="form-label">Ticket Type</label>
                                        <select class="form-control input-style" id="validationCustom04" required name="type">
                                            <?php
                                                $rs2 = mysqli_query($conn, "SELECT pricetype_master.PriceTypeId, pricetype_master.PriceTypeName FROM
                                                    pricetype_master WHERE EventId = '$_GET[eid]'");
                                                if(mysqli_num_rows($rs2)>0){

                                                    echo "<option value=''>Select Type</option>";

                                                    while($rw2 = mysqli_fetch_assoc($rs2)){

                                                        echo "<option value='$rw2[PriceTypeId]'>$rw2[PriceTypeName]</option>";
                                                    }
                                                }
                                                else{
                                                    echo "<option value=''>No type found</option>";
                                                }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback">
                                        Please choose ticket type
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label for="validationCustom01" class="form-label">Number of Tickets</label>
                                        <input type="number" class="form-control input-style" min="1" id="validationCustom01" required name="quantity">
                                        <div class="invalid-feedback">
                                            Enter number of tickets
                                        </div>
                                    </div>
                                    <div class="col-2 mt-4">
                                        <button class="btn btn-outline-primary btn-style" type="submit" name="add"><i class="fa fa-plus"></i></button>
                                    </div>
                                </form>
                            </div>
                            
                            <?php 
                                if(!empty($_SESSION['cart_item'])){
                            ?>

                            <div class="row px-3 pt-4">
                                <div class="col-3"><strong>Category</strong></div>
                                <div class="col-3"><strong>Type</strong></div>
                                <div class="col-2"><strong>No of Tickets</strong></div>
                                <div class="col-2 text-right"><strong>Ticket Price</strong></div>
                                <div class="col-2 text-right"><strong>Total Price</strong></div>
                            </div>
                            <hr>
                            <div class="row ml-3">
                            <?php		
                                foreach ($_SESSION["cart_item"] as $item){
                                    
                                    $mres = mysqli_query($conn, "SELECT PriceCategoryName FROM category_master WHERE PriceCategoryId = '$item[categoryId]' AND EventId = '$_GET[eid]'");
                                    if (mysqli_num_rows($mres)>0) {

                                        $mres = mysqli_fetch_assoc($mres);
                                    } else {

                                        echo "<script>alert('Oops, Unable to process..');</script>";
                                    }
                                    
                                    $mres1 = mysqli_query($conn, "SELECT PriceTypeName FROM pricetype_master WHERE PriceTypeId = '$item[priceTypeId]' AND EventId = '$_GET[eid]'");
                                    if (mysqli_num_rows($mres1)>0) {

                                        $mres1 = mysqli_fetch_assoc($mres1);
                                    } else {

                                        echo "<script>alert('Oops, Unable to process..');</script>";
                                    }

                                    $mres2 = mysqli_query($conn, "SELECT PriceNet FROM price_master WHERE PriceTypeId = '$item[priceTypeId]' AND PriceCategoryId = '$item[categoryId]' AND EventId = '$_GET[eid]'");
                                    if (mysqli_num_rows($mres2)>0) {

                                        $mres2 = mysqli_fetch_assoc($mres2);
                                    } else {

                                        echo "<script>alert('Oops, Unable to process..');</script>";
                                    }

                                    ?>
                                        <div class="col-3 mb-2"><?php echo $mres["PriceCategoryName"]; ?></div>
                                        <div class="col-3 mb-2"><?php echo $mres1["PriceTypeName"]; ?></div>
                                        <div class="col-2 mb-2"><?php echo $item["quantity"]; ?></div>
                                        <div class="col-2 mb-2 text-right"><?php echo number_format(($mres2["PriceNet"]/100), 2); ?></div>
                                        <div class="col-2 mb-2 text-right"><?php echo number_format(($mres2["PriceNet"]/100), 2); ?></div>
                                    <?php
                                    }
                                ?>

                                <form name="form2" method="post">
                                <div class="col-12 mt-3">
                                    <button name="next" class="btn btn-primary" >Next</button>
                                </div>
                                </form>
                            </div>
                            
                            <?php 
                                }
                            ?>
                        </div>

                            </form>

                            <?php if(!empty($_SESSION['cart'])){?>
                            <div class="row mt-4 ml-3">
                                <div class="col-3"><strong>Category</strong></div>
                                <div class="col-2"><strong>Type</strong></div>
                                <div class="col-2"><strong>No of Tickets</strong></div>
                                <div class="col-2"><strong>Ticket Price</strong></div>
                                <div class="col-2"><strong>Total Price</strong></div>
                            </div>
                            <hr style="margin-right: 150px;" class="ml-3">
                            <div class="row ml-3">
                            <?php		
                                foreach ($_SESSION["cart"] as $item){
                                    $mres = mysqli_query($conn, "SELECT PriceCategoryName FROM category_master WHERE PriceCategoryId = '$item[category]'");
                                    $mrow = mysqli_fetch_assoc($mres);
                                    $mres1 = mysqli_query($conn, "SELECT PriceTypeName FROM pricetype_master WHERE PriceTypeId = '$item[type]'");
                                    $mrow1 = mysqli_fetch_assoc($mres1);
                                    ?>
                                        <div class="col-3 mb-2"><?php echo $mrow["PriceCategoryName"]; ?></div>
                                        <div class="col-2 mb-2"><?php echo $mrow1["PriceTypeName"]; ?></div>
                                        <div class="col-2 mb-2"><?php echo $item["quantity"]; ?></div>
                                        <div class="col-2 mb-2"><?php echo number_format(($item["price"]/100), 2); ?></div>
                                        <div class="col-2 mb-2"><?php echo number_format(($item["total"]/100), 2); ?></div>
                                    <?php
                                    }
                                ?>
                                <form name="form2" method="post">
                                <div class="col-12 mt-3">
                                    <button name="next" class="btn btn-primary" >Next</button>
                                </div>
                                </form>
                            </div>
                            
                            <?php }?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    require_once './pages/footer.php';
?>