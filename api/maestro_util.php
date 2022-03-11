<?php

class MaestroUtil {
    
    private static $API_BASE_URL = "https://api.etixdubai.com/";
    private static $CLIENT_ID = "885007b640da4492bfd1cad70892bcc5";
    private static $CLIENT_SECRET = "4f13902fb677491fbfb8a96beadd4ae9";
    private static $SELLER_CODE = "AMAES1";

    public $conn = null;

    function __construct() {
        // $this->conn = mysqli_connect('localhost', 'EcommerceUser', 'r39LkPP)MAVyyk&}', 'eticketing');
        $this->conn = mysqli_connect('localhost', 'root', '', 'eticketing');
    }
    
    public function getAuthToken() {
        $accessToken = null;

        $rest = mysqli_query($this->conn, "SELECT TokenNo, Expiry, CreatedTime FROM token_master ORDER BY TM_Id DESC LIMIT 1");
        if (mysqli_num_rows($rest)>0) {

            $rowt = mysqli_fetch_assoc($rest);
            $date = $rowt['CreatedTime'];
            $sec = ($rowt['Expiry'])-300;
            $expire = strtotime($date. ' + '.$sec.' second');

            if($expire>time()){
                $accessToken = $rowt['TokenNo'];
            }
        }

        if (empty($accessToken)) {
            $headers = [
                "Accept: application/vnd.softix.api-v1.0+json",
                "Accept-Language: en_US"
            ];

            $data = http_build_query(array(
                "grant_type" => "client_credentials"
            )); 

            $ch = curl_init();

            curl_setopt_array($ch, array(
                CURLOPT_URL => MaestroUtil::$API_BASE_URL . "oauth2/accesstoken",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 0, 
                CURLOPT_POST => true,  
                CURLOPT_POSTFIELDS => $data, 
                CURLOPT_USERPWD => MaestroUtil::$CLIENT_ID . ":" . MaestroUtil::$CLIENT_SECRET
            ));

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            $serverOutput = curl_exec($ch);
            $error = curl_errno($ch);

            curl_close($ch);

            if ($serverOutput) {
                $serverOutput = json_decode($serverOutput, true);

                if(isset($serverOutput['access_token']) && isset($serverOutput['expires_in'])){
                    $accessToken = $serverOutput['access_token'];
                    $expiresIn = $serverOutput['expires_in'];

                    $sql = "INSERT INTO token_master(TokenNo, Expiry, CreatedTime)
                        VALUES('$accessToken', '$expiresIn', NOW())";

                    mysqli_query($this->conn, $sql);
                }
            } 
        } 

        return $accessToken;
    }  
    
        public function createNewCustomer(
                                            $saluation,
                                            $first_name, 
                                            $last_name, 
                                            $email, 
                                            $phone, 
                                            $nationality, 
                                            $dateofbirth, 
                                            $area_code, 
                                            $international_code, 
                                            $address_line1, 
                                            $address_line2,
                                            $city,
                                            $state,
                                            $country,
                                            $password
                                        ) {
            $accessToken = $this->getAuthToken();

            if(empty($accessToken)){
                
                return false;
            }else{
                $url = MaestroUtil::$API_BASE_URL . "customers?sellerCode=" . MaestroUtil::$SELLER_CODE;

                $requestBody = array(
                    "salutation"=>$saluation,
                    "nationality"=>$nationality,
                    "firstname"=>$first_name, 
                    "lastname"=>$last_name,
                    "dateofbirth"=>$dateofbirth,
                    "email"=>$email,
                    "addressline1"=>$address_line1,
                    "addressline2"=>$address_line2,
                    "city"=>$city,
                    "state"=>$state,
                    "countrycode"=>$country,
                    "internationalcode"=>$international_code,
                    "areacode"=>$area_code,
                    "phonenumber"=>$phone
                );
                
                $ch = curl_init();

                $headers = [
                    "Content-Type: application/json",
                    "Authorization: Bearer " . $accessToken
                ];

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $serverOutput = curl_exec($ch);
                $error = curl_errno($ch);

                curl_close($ch);

                error_log($error);
                
                if ($serverOutput) {
                    $serverOutput = json_decode($serverOutput, true);
                    if (isset($serverOutput['ID']) && isset($serverOutput['Account'])) {

                        $customerId = $serverOutput['ID'];
                        $accountNumber = $serverOutput['Account'];

                        if (mysqli_query($this->conn, "INSERT INTO customer_master (Saluation, FirstName, LastName, CustomerEmail, CustomerPhone, Nationality, DateOfBirth, AreaCode, InternationalCode, AddressLine1, AddressLine2, CustomerCity, CustomerState, CustomerCountry, CustomerStatus, DateCreate, CustomerId, AccountNo) VALUES ('$saluation', '$first_name', '$last_name', '$email', '$phone', '$nationality', '$dateofbirth', '$area_code', '$international_code', '$address_line1', '$address_line2', '$city', '$state', '$country', 1, NOW(), '$customerId', '$accountNumber' )")) {

                            if (mysqli_query($this->conn, "INSERT INTO login_master (UserEmail, UserPassword, UserRole) VALUES ('$email', '$password', 'Customer')")) {
                                
                                return true;
                            } else {
                                
                                return false;
                            }
                        } else {
                            
                            return false;
                        }
                    } else {
                        
                        return false;
                    }

                } else {
                    
                    return false;
                }
            }
        }   


    public function createAgentCustomer(
        $saluation,
        $first_name, 
        $last_name, 
        $email, 
        $phone, 
        $nationality, 
        $dateofbirth, 
        $area_code, 
        $international_code, 
        $address_line1, 
        $address_line2,
        $city,
        $state,
        $country,
        $bketId,
        $totalPrice,
        $evid,
        $ajid
    ) {
        
        $accessToken = $this->getAuthToken();

        if(empty($accessToken)){

            return true;
        }else{

            $url = MaestroUtil::$API_BASE_URL . "customers?sellerCode=" . MaestroUtil::$SELLER_CODE;

            $requestBody = array(
            "salutation"=>$saluation,
            "nationality"=>$nationality,
            "firstname"=>$first_name, 
            "lastname"=>$last_name,
            "dateofbirth"=>$dateofbirth,
            "email"=>$email,
            "addressline1"=>$address_line1,
            "addressline2"=>$address_line2,
            "city"=>$city,
            "state"=>$state,
            "countrycode"=>$country,
            "internationalcode"=>$international_code,
            "areacode"=>$area_code,
            "phonenumber"=>$phone
            );

            $ch = curl_init();

            $headers = [
            "Content-Type: application/json",
            "Authorization: Bearer " . $accessToken
            ];

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $serverOutput = curl_exec($ch);
            $error = curl_errno($ch);

            curl_close($ch);

            error_log($error);

            if ($serverOutput) {

                $serverOutput = json_decode($serverOutput, true);
                if (isset($serverOutput['ID']) && isset($serverOutput['Account'])) {

                    $customerId = $serverOutput['ID'];
                    $accountNumber = $serverOutput['Account'];

                    if (mysqli_query($this->conn, "INSERT INTO agent_customer (Saluation, FirstName, LastName, CustomerEmail, CustomerPhone, Nationality, DateOfBirth, AreaCode, InternationalCode, AddressLine1, AddressLine2, CustomerCity, CustomerState, CustomerCountry, CustomerStatus, DateCreate, CustomerId, AccountNo) VALUES ('$saluation', '$first_name', '$last_name', '$email', '$phone', '$nationality', '$dateofbirth', '$area_code', '$international_code', '$address_line1', '$address_line2', '$city', '$state', '$country', 1, NOW(), '$customerId', '$accountNumber' )")) {

                        $last_id = mysqli_insert_id($this->conn);
                        $this->purchaseagent($bketId, $customerId, $totalPrice, $accountNumber, $last_id, $evid, $ajid);
                    } else {
                        
                        echo "<script>alert('Oops, Unable to process your request..');location.href='../agent/home.php';</script>";
                    }
                } else {

                    echo "<script>alert('Oops, Unable to process your request..');location.href='../agent/home.php';</script>";
                }

            } else {
                
                echo "<script>alert('Oops, Unable to process your request..');location.href='../agent/home.php';</script>";
            }
        }
    }  


    public function purchaseagent ($basketID, $customerId, $totalAmount, $accountNumber, $cid, $eventId, $agentId) {

        $accessToken = $this->getAuthToken();

        if(empty($accessToken)){

            echo "<script>alert('Oops, Unable to process your request..');location.href='../agent/home.php';</script>";
        } else{

            $url = MaestroUtil::$API_BASE_URL . "Baskets/${basketId}/purchase";

            $requestBody = array(
                "Seller" => MaestroUtil::$SELLER_CODE,
                "customer" => array(
                    "ID" => $customerId,
                    "Account" => $accountNumber,
                    "AFile" => "tel"
                ),
                "Payments" => array(
                    array(
                        "Amount" => $totalAmount,
                        "MeansOfPayment" => "EXTERNAL"
                    )
                )
            );

            $ch = curl_init();

            $headers = [
                "Content-Type: application/json",
                "Authorization: Bearer " . $accessToken
            ];

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $serverOutput = curl_exec($ch);
            // $error = curl_errno($ch);

            curl_close($ch);
            
            if ($serverOutput) {

                $serverOutput = json_decode($serverOutput, true);

                if (isset($serverOutput['OrderId'])) {

                    if (mysqli_query($this->conn, "INSERT INTO sales_master (CustomerId, PaymentId, BasketId, OrderId, DateCreate, 
                        SalesStatus, EventId, IsSoldByAjent, AjentId) VALUES ('$cid', 0, '$basketID', '$serverOutput[OrderId]', NOW(), 
                        'Placed', '$eventId', 1, '$agentId') ")) {
								
                        if (mysqli_query($this->conn, "UPDATE sales_data SET Status = 1 WHERE BusketId = '$basketID'")) {
                            
                            $this->barCodeagent($serverOutput['OrderId']);
                        } else {
                            
                            echo "<script>alert('Oops, Contact admin. Your Order ID : ".$serverOutput['OrderId']."');location.href='../agent/home.php';</script>";
                        }
                    }else {

                        echo "<script>alert('Oops, Contact admin. Your Order ID : ".$serverOutput['OrderId']."');location.href='../agent/home.php';</script>";
                    }
                } else {

                    echo "<script>alert('Oops, Unable to process your request..');location.href='../agent/home.php';</script>";
                }

            } else {
                
                echo "<script>alert('Oops, Unable to process your request..');location.href='../agent/home.php';</script>";
            }
        }

    }

    public function barCodeagent($orderId) {
        $accessToken = $this->getAuthToken();

        if(empty($accessToken)){
            
            echo "<script>alert('Oops, Contact admin. Your Order ID : ".$orderId."');location.href='../agent/home.php';</script>";
        }else{
            
            $url = MaestroUtil::$API_BASE_URL . "orders/${orderId}?sellerCode=" . MaestroUtil::$SELLER_CODE;

            $ch = curl_init();

            $headers = [
                "Content-Type: application/json",
                "Authorization: Bearer " . $accessToken
            ];

            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true, // return the transfer as a string of the return value
                CURLOPT_TIMEOUT => 0,   // The maximum number of seconds to allow cURL functions to execute.
                CURLOPT_POST => false   // This line must place before CURLOPT_POSTFIELDS
            ));

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $serverOutput = curl_exec($ch);
            // $error = curl_errno($ch);

            curl_close($ch);  
            
            if ($serverOutput) {

                $serverOutput = json_decode($serverOutput, true);

                if (isset($serverOutput['OrderItems'])) {

                    $OrderItems = $serverOutput['OrderItems'];  // array

                    // $OrderLineItems = array();

                    foreach ($OrderItems as $item) {
                        $OrderLineItems = $item['OrderLineItems'];
                    }

                    $insertBarCode = "INSERT INTO barcode_master(OrderId, PriceCategoryCode, PriceTypeCode, PerformanceCode, PriceTypeName, Barcode, DateCreate) VALUES";

                    $i = 0;

                    foreach ($OrderLineItems as $oderItem) {

                        if ($i > 0) {
                            $insertBarCode .= ",";
                        }

                        $insertBarCode .= "('$orderId', '$oderItem[PriceCategoryCode]', '$oderItem[PriceTypeCode]', '$oderItem[PerformanceCode]', '$oderItem[PriceTypeName]', '$oderItem[Barcode]', 'NOW()')"; 

                        $i++;
                    }

                    $isBarcodeInserted = mysqli_query($this->conn, $insertBarCode); 

                    if ($isBarcodeInserted) {
                        
                        echo "<script>alert('Yay, Your order placed successfully..');location.href='../agent/home.php';</script>";
                    } else {

                        echo "<script>alert('Oops, Contact admin. Your Order ID : ".$orderId."');location.href='../agent/home.php';</script>";
                    }

                } else {
                    echo "<script>alert('Oops, Contact admin. Your Order ID : ".$orderId."');location.href='../agent/home.php';</script>";
                }

            } else {
                
                echo "<script>alert('Oops, Contact admin. Your Order ID : ".$orderId."');location.href='../agent/home.php';</script>";
            }
        }
    }


    
    public function getPriceDetails($eventId, $eventCode) {

        $accessToken = $this->getAuthToken();

        if(empty($accessToken)){
            echo "<script>alert('Oops, Unable to generate AccessToken..');location.href='../admin/add-event.php';</script>";
        } else {
            $url = MaestroUtil::$API_BASE_URL . "performances/$eventCode/prices?channel=W&sellerCode=" . MaestroUtil::$SELLER_CODE;

            $ch = curl_init();

            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true, 
                CURLOPT_TIMEOUT => 0,   
                CURLOPT_POST => false,  
            ));

            $headers = [
                "Content-Type: application/json",
                "Authorization: Bearer " . $accessToken
            ];

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $serverOutput = curl_exec($ch);
            // $error = curl_errno($ch);

            curl_close($ch);

            if ($serverOutput) {
                
                $serverOutput = json_decode($serverOutput, true);

                if (isset($serverOutput['PriceCategories']) && isset($serverOutput['PriceTypes']) && isset($serverOutput['TicketPrices'])) {
                    
                    $priceCategories = $serverOutput['PriceCategories'];   //category array

                    $insertCategoryMaster = "INSERT INTO category_master(PriceCategoryId, PriceCategoryCode, PriceCategoryName, DateCreated, EventId) VALUES";
    
                    $i = 0;
        
                    foreach ($priceCategories as $value) {
        
                        if ($i > 0) {
                            $insertCategoryMaster .= ',';
                        }
        
                        $insertCategoryMaster .= "('$value[PriceCategoryId]', '$value[PriceCategoryCode]', '$value[PriceCategoryName]', NOW(), '$eventId')";
        
                        $i++;
                    }
                    
                    $isInsertedCategoryMaster = mysqli_query($this->conn, $insertCategoryMaster);
        
                    $priceTypes = $serverOutput['PriceTypes'];   //pricetype array
                    
                    $insertPriceTypeMaster = "INSERT INTO pricetype_master(PriceTypeId, PriceTypeCode, PriceTypeName, PriceTypeDescription, DateCreated, EventId) VALUES";
        
                    $i = 0;
        
                    foreach ($priceTypes as $value) {
        
                        if ($i > 0) {
                            $insertPriceTypeMaster .= ',';
                        }
        
                        $insertPriceTypeMaster .= "('$value[PriceTypeId]', '$value[PriceTypeCode]', '$value[PriceTypeName]', '$value[PriceTypeDescription]', NOW(), '$eventId')";
        
                        $i++;
                    }
                    
                    $isPriceTypeMasterInserted = mysqli_query($this->conn, $insertPriceTypeMaster);
        
                    $ticketPrices = $serverOutput['TicketPrices'];  // ticket prices object
        
                    $insertPriceMaster = "INSERT INTO price_master(PriceId, PriceCategoryId, PriceCategoryCode, PriceTypeId, PriceTypeCode, PriceNet, DateCreate, EventId) VALUES";
        
                    $i = 0;
        
                    if ($ticketPrices) {
                        $prices = $ticketPrices['Prices'];  // prices array
                        
                        foreach($prices as $value){
        
                            if ($i > 0) {
                                $insertPriceMaster .= ",";
                            }
        
                            $insertPriceMaster .= "('$value[PriceId]', '$value[PriceCategoryId]', '$value[PriceCategoryCode]', '$value[PriceTypeId]', '$value[PriceTypeCode]','$value[PriceNet]',NOW(), '$eventId')";
        
                            $i++;
                        }
                    }
                    
                    $isPriceMasterInserted = mysqli_query($this->conn, $insertPriceMaster);

        
                    if ($isInsertedCategoryMaster && $isPriceTypeMasterInserted && $isPriceMasterInserted) {

                        echo "<script>location.href='../admin/event-next.php?eid=". $eventId ."';</script>";
                    } else {

                        echo "<script>alert('Oops, Unable store an event data..');location.href='../admin/add-event.php';</script>";
                    }
                } else{

                    $message = $this->getErrorMessage($serverOutput);
                    echo "<script>alert('Oops, Unable to process, ".$message."');location.href='../admin/add-event.php';</script>";
                } 
                    
            } else {

                echo "<script>alert('Oops, We did not get a response from the server..');location.href='events.php';</script>";
            }
        }
    }

    public function createBasketSingle ($eventId, $categoryId, $typeId, $quantity){

        $basketID = null;
        $accessToken = $this->getAuthToken();

        if(empty($accessToken)){

            return $basketID;
        } else{
            $resBasket = mysqli_query($this->conn, "SELECT event_master.EventCode, pricetype_master.PriceTypeCode FROM pricetype_master JOIN event_master ON pricetype_master.EventId = event_master.EM_Id WHERE event_master.EM_Id = '$eventId' AND pricetype_master.EventId = '$eventId' AND pricetype_master.PriceTypeId = '$typeId'");

            if (mysqli_num_rows($resBasket) > 0) {

                $resBasket = mysqli_fetch_assoc($resBasket);

                $url = MaestroUtil::$API_BASE_URL . "baskets";

                $requestBody = array(
                    "Channel" => "5",
                    "Seller" => MaestroUtil::$SELLER_CODE,
                    "Performancecode" => $resBasket['EventCode'],
                    "Area" => (int) $categoryId,
                    "autoReduce" => false,
                    "holdcode" => "",
                    "Demand" => array(
                        array(
                            "PriceTypeCode" => $resBasket['PriceTypeCode'],
                            "Quantity" => (int) $quantity,
                            "Admits" => (int) $quantity,
                            "offerCode" => "",
                            "qualifierCode" => "",
                            "entitlement" => "",
                            "Customer" => (object) null
                        )
                    ),
                    "Fees" => array(
                        array(
                            "Type" => "5",
                            "Code" => "W"
                        )
                    )
                );

                $ch = curl_init();

                $headers = [
                    "Content-Type: application/json",
                    "Authorization: Bearer " . $accessToken
                ];

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $serverOutput = curl_exec($ch);
                $error = curl_errno($ch);

                curl_close($ch);
            
                error_log($error);
                
                if ($serverOutput) {

                // error_log($serverOutput);

                    $serverOutput = json_decode($serverOutput, true);

                    if (isset($serverOutput['Id'])) {

                        return $serverOutput['Id'];
                        
                    } else {

                        return $basketID;
                    }

                } else {

                    return $basketID;
                }

            } else {
                
                return $basketID;
            }
        }
    }

    public function createBasketArray ($cartData){

        $basketID = null;
        $eventCode = null;
        $accessToken = $this->getAuthToken();

        if(empty($accessToken)){

            return $basketID;
        } else{

            $demand = array();

            foreach($cartData as $item) {

                $resBasket = mysqli_query($this->conn, "SELECT PriceTypeCode FROM pricetype_master WHERE EventId = '$item[cartEventId]' AND PriceTypeId = '$item[cart_type]'");

                if (mysqli_num_rows($resBasket) > 0) {

                    $resBasket = mysqli_fetch_assoc($resBasket);

                    array_push($demand, array(
                        "PriceTypeCode" => $resBasket['PriceTypeCode'],
                        "Quantity" => (int) $item['cart_quantity'],
                        "Admits" => (int) $item['cart_quantity'],
                        "offerCode" => "",
                        "qualifierCode" => "",
                        "entitlement" => "",
                        "Customer" => (object) null
                    ));

                } else {
                    return $basketID;
                }
            }

            $resEcode = mysqli_query($this->conn, "SELECT EventCode FROM event_master WHERE EM_Id = '$item[cartEventId]'");

            if (mysqli_num_rows($resEcode) > 0) {

                $resEcode = mysqli_fetch_assoc($resEcode);
                $eventCode = $resEcode['EventCode'];

            } else {
                return $basketID;
            }

            $url = MaestroUtil::$API_BASE_URL . "baskets";

            $requestBody = array(
                "Channel" => "5",
                "Seller" => MaestroUtil::$SELLER_CODE,
                "Performancecode" => $eventCode,
                "Area" => (int) $item['cart_category'],
                "autoReduce" => false,
                "holdcode" => "",
                "Demand" => $demand,
                "Fees" => array(
                    array(
                        "Type" => "5",
                        "Code" => "W"
                    )
                )
            );

            $ch = curl_init();

            $headers = [
                "Content-Type: application/json",
                "Authorization: Bearer " . $accessToken
            ];

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $serverOutput = curl_exec($ch);
            $error = curl_errno($ch);

            curl_close($ch);
        
            error_log($error);
            
            if ($serverOutput) {

            // error_log($serverOutput);

                $serverOutput = json_decode($serverOutput, true);

                if (isset($serverOutput['Id'])) {

                    return $serverOutput['Id'];
                    
                } else {

                    return $basketID;
                }

            } else {

                return $basketID;
            }

        }
    }

    public function purchaseTicket ($customerId, $basketID, $totalAmount) {
        $orderID = null;

        $accessToken = $this->getAuthToken();

        if(empty($accessToken)){

            return $orderID;
        } else{
        
            $resCustomer = mysqli_query($this->conn, "SELECT CustomerId, AccountNo FROM customer_master WHERE CM_Id = '$customerId'");

            if (mysqli_num_rows($resCustomer) > 0) {

                $resCustomer = mysqli_fetch_assoc($resCustomer);

                $url = MaestroUtil::$API_BASE_URL . "Baskets/${basketId}/purchase";

                $requestBody = array(
                    "Seller" => MaestroUtil::$SELLER_CODE,
                    "customer" => array(
                        "ID" => $resCustomer['CustomerId'],
                        "Account" => $resCustomer['AccountNo'],
                        "AFile" => "tel"
                    ),
                    "Payments" => array(
                        array(
                            "Amount" => $totalAmount,
                            "MeansOfPayment" => "EXTERNAL"
                        )
                    )
                );

                $ch = curl_init();

                $headers = [
                    "Content-Type: application/json",
                    "Authorization: Bearer " . $accessToken
                ];

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $serverOutput = curl_exec($ch);
                // $error = curl_errno($ch);

                curl_close($ch);
                
                if ($serverOutput) {

                    $serverOutput = json_decode($serverOutput, true);

                    if (isset($serverOutput['OrderId'])) {

                        return $serverOutput['OrderId'];
                    } else {

                        return $orderID;
                    }

                } else {
                    
                    return $orderID;
                }

            } else  {

                return $orderID;
            }
        }

    }

    public function editCustomer(
        $saluation,
        $first_name, 
        $last_name, 
        $email, 
        $phone, 
        $nationality, 
        $dateofbirth, 
        $area_code, 
        $international_code, 
        $address_line1, 
        $address_line2,
        $city,
        $state,
        $country,
        $customer_id
    ) {
        $accessToken = $this->getAuthToken();

        if(empty($accessToken)){

            return false;
        }else{

            $url = MaestroUtil::$API_BASE_URL . "customers/${customer_id}?sellerCode=" . MaestroUtil::$SELLER_CODE;

            $requestBody = array(
                "salutation"=>$saluation,
                "nationality"=>$nationality,
                "firstname"=>$first_name,
                "lastname"=>$last_name,
                "dateofbirth"=>$dateofbirth,
                "email"=>$email,
                "addressline1"=>$address_line1,
                "addressline2"=>$address_line2,
                "city"=>$city,
                "state"=>$state,
                "countrycode"=>$country,
                "internationalcode"=>$international_code,
                "areacode"=>$area_code,
                "phonenumber"=>$phone
            );
            
            $ch = curl_init();

            $headers = [
                "Content-Type: application/json",
                "Authorization: Bearer " . $accessToken
            ];    

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 0);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $serverOutput = curl_exec($ch);
            
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($serverOutput) {
                
                return false;
            } else {
                if($httpcode==204){
                    
                    return true;
                }
                else{
                    
                    return false;
                }
            }
        }
    }

    public function barCode($orderId) {
        $accessToken = $this->getAuthToken();

        if(empty($accessToken)){
            
            return false;
        }else{
            
            $url = MaestroUtil::$API_BASE_URL . "orders/${orderId}?sellerCode=" . MaestroUtil::$SELLER_CODE;

            $ch = curl_init();

            $headers = [
                "Content-Type: application/json",
                "Authorization: Bearer " . $accessToken
            ];

            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true, // return the transfer as a string of the return value
                CURLOPT_TIMEOUT => 0,   // The maximum number of seconds to allow cURL functions to execute.
                CURLOPT_POST => false   // This line must place before CURLOPT_POSTFIELDS
            ));

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $serverOutput = curl_exec($ch);
            // $error = curl_errno($ch);

            curl_close($ch);  
            
            if ($serverOutput) {

                $serverOutput = json_decode($serverOutput, true);

                if (isset($serverOutput['OrderItems'])) {

                    $OrderItems = $serverOutput['OrderItems'];  // array

                    // $OrderLineItems = array();

                    foreach ($OrderItems as $item) {
                        $OrderLineItems = $item['OrderLineItems'];
                    }

                    $insertBarCode = "INSERT INTO barcode_master(OrderId, PriceCategoryCode, PriceTypeCode, PerformanceCode, PriceTypeName, Barcode, DateCreate) VALUES";

                    $i = 0;

                    foreach ($OrderLineItems as $oderItem) {

                        if ($i > 0) {
                            $insertBarCode .= ",";
                        }

                        $insertBarCode .= "('$orderId', '$oderItem[PriceCategoryCode]', '$oderItem[PriceTypeCode]', '$oderItem[PerformanceCode]', '$oderItem[PriceTypeName]', '$oderItem[Barcode]', 'NOW()')"; 

                        $i++;
                    }

                    $isBarcodeInserted = mysqli_query($this->conn, $insertBarCode); 

                    if ($isBarcodeInserted) {
                        
                        return true;
                    } else {

                        return false;
                    }

                } else {
                    // $message = $this->getErrorMessage($serverOutput);
                    // echo "<script>alert('Oops, Unable to process, ".$message."');location.href='agent-dashboard.php';</script>";
                    return false;
                }

            } else {
                
                return false;
            }
        }
    }

    public function returnTicket($orderId, $amount) {
        $accessToken = $this->getAuthToken();

        if(empty($accessToken)){
            
            return false;
        }else{
            $url = MaestroUtil::$API_BASE_URL . "orders/${orderId}/reverse";

            $requestBody = array(
                "Seller" => MaestroUtil::$SELLER_CODE,
                "refunds" => array(
                    array(
                        "Amount" => $amount,
                        "MeansOfPayment" => "EXTERNAL"
                    )
                )
            );

            $ch = curl_init();

            $headers = [
                "Content-Type: application/json",
                "Authorization: Bearer " . $accessToken
            ];

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $serverOutput = curl_exec($ch);
            
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            $httpcode;

            if ($serverOutput) {
                // $message = $this->getErrorMessage($serverOutput);
                // echo "<script>alert('".$message."');</script>";
                return false;
            } else {
                if($httpcode==204){
                    
                    return true;
                }
                else if($httpcode==400){
                    //400 bad request //already ticket returned or half return not posible
                    return false;
                }
                else{
                    
                    return false;
                }
            }
        }
    }

    public function getErrorMessage($serverOutput) {
        
        if (empty($serverOutput)) {
            return "Unable to process your request";
        }

        if (isset($serverOutput['Message'])) {
            return $serverOutput['Message'];
        }

        return "Unable to process your request";
    }
}