<?php
    session_start();
        
    if(!isset($_SESSION['is_admin_login'])){
        header('Location: ./pages/logout.php');
    }
    else{
        if(!$_SESSION['is_admin_login']){
            header('Location: ./pages/logout.php');
        }
    }
        
    require_once '../config/connection.php';
    require_once './pages/link.php';
    // require_once './pages/sidebar.php';
    // require_once './pages/header.php';

    if(isset($_POST['cEvent'])){

        $resa = mysqli_query($conn, "SELECT TotalSeats FROM event_master WHERE EM_Id = '$_GET[eid]' AND EventStatus = 'New'");
        if(mysqli_num_rows($resa)>0){

            $rowa = mysqli_fetch_assoc($resa);
            $seat = $rowa['TotalSeats'];

            $sum = 0;
            foreach($_POST['eCategory'] as $item){
                $sum+=$item;
            }

            if($sum!=$seat){
                echo "<script>alert('No of seats available ".$seat." and seats distributed count not matching..');</script>";
            }
            else{

                $cSql = "UPDATE category_master SET SeatsNo = (CASE CT_Id ";

                for($i=0;$i<count($_POST['eCategory']);$i++){
                    $cnt = $_POST['eCategory'][$i];
                    $cid = $_POST['eCategoryId'][$i];

                    $cSql .= "WHEN '$cid' THEN '$cnt' ";
                }

                $cSql .= "END) WHERE CT_Id IN (";
                
                for($i=0;$i<count($_POST['eCategory']);$i++){
                    $cid = $_POST['eCategoryId'][$i];

                    if ($i > 0) {
                        $cSql .= ",";
                    }

                    $cSql .= "'$cid'";
                }

                $cSql .= ")";

                if (mysqli_query($conn, $cSql)) {

                    if(mysqli_query($conn, "UPDATE event_master SET EventStatus = 'Publish' where EM_Id = '$_GET[eid]'")){

                        echo "<script>alert('Event Created Successfully..');location.href='events.php';</script>";
                    } else{

                        echo "<script>alert('Oops, Unable to process..');</script>";
                    }
                } else{

                    echo "<script>alert('Oops, Unable to process..');</script>";
                }
            }
        }
        else{

            echo "<script>alert('Unable to process your request..');location.href='add-event.php';</script>";
        }
    }
?>

<form method="post"> 
    <div class="main-content">
        <div class="container-fluid content-top-gap">
            <div class="row">
                <div class="col-xl-12 pr-xl-12">
                    <div class="card card_border border-primary-top">
                    <div class="card-header chart-grid__header float-left">Setup Tickets <span class="text-dark float-right"><button class="btn btn-success ml-3" name="cEvent">Create Event</button></span></div>
                        <div class="card-body">
                            <div class="row bg-primary mx-3 text-light p-2">
                                <div class="col-9">
                                    <span>Ticket Category</span>
                                </div>
                                <div class="col-3">Tickets Count</div>
                            </div>
                            <?php $res = mysqli_query($conn, "SELECT CT_Id, PriceCategoryName, PriceCategoryId FROM category_master WHERE EventId = '$_GET[eid]'");
                            if(mysqli_num_rows($res)>0){
                                while($row = mysqli_fetch_assoc($res)){
                                    ?>
                                    <div class="row m-3">
                                        <div class="col-9">
                                            <i class="fa fa-ticket fa-2x" style="color: gold;"></i> <?php echo $row['PriceCategoryName'];?>
                                            <div class="row col-12">
                                                <div class="table-responsive">
                                                    <table class="table table-hover align-middle table-sm mt-3">
                                                        <thead class="table-light">
                                                            <tr class="table-active">
                                                                <th>Tickets Sub Category</th>
                                                                <th>Ticket Price</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="searchTable">
                                                            <?php
                                                                $res1 = mysqli_query($conn, "SELECT pricetype_master.PriceTypeName, price_master.PriceNet FROM price_master JOIN pricetype_master ON price_master.PriceTypeId = pricetype_master.PriceTypeId WHERE price_master.EventId = '$_GET[eid]' AND pricetype_master.EventId = '$_GET[eid]' AND price_master.PriceCategoryId = '$row[PriceCategoryId]'");
                                                                if(mysqli_num_rows($res1)>0){
                                                                    while($row1 = mysqli_fetch_assoc($res1)){
                                                                        echo "<tr><td>$row1[PriceTypeName]</td><td>$row1[PriceNet]</td></tr>";
                                                                    }
                                                                }
                                                                else{
                                                                    echo "<tr><td colspan='4'>No record found..!</td>";
                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3"><input type="number" class="form-control" name="eCategory[]" required/><input type="hidden" name="eCategoryId[]" value="<?php echo $row['CT_Id'];?>"/></div>
                                    </div>
                                    <hr>
                                    <?php
                                }
                            }
                            else{
                                echo "<script>alert('No Event Data Found..');location.href='add-event.php';</script>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                </form>

<?php
    require_once './pages/footer.php';
?>