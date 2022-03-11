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
    require_once './pages/sidebar.php';
    require_once './pages/header.php';
?>

<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="data-tables">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card card_border p-4 border-primary-top">
                        <h3 class="card__title position-absolute">View Payment</h3>
                        <div class="table-responsive">
                            <table id="meastroTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Unique Id</th>
                                        <th>Transaction Id</th>
                                        <th>Total Amount</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Paid On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $resd6 = mysqli_query($conn, "SELECT * FROM payment_master ORDER BY RP_Id DESC");
                                        if (mysqli_num_rows($resd6) > 0) {

                                            $count = 1;
                                            while($rowd6 = mysqli_fetch_assoc($resd6)) {
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>"; 
                                                echo "<td>".$rowd6['UniqueId']."</td>"; 
                                                echo "<td>".$rowd6['TransactionId']."</td>"; 
                                                echo "<td>".number_format($rowd6['TotalAmount'], 2)." AED</td>"; 
                                                echo "<td>".$rowd6['PaymentMessage']."</td>"; 
                                                echo "<td>";
                                                if($rowd6['PaymentStatus'] == 'Paid') {

                                                    echo "<span class='badge badge-success'>".$rowd6['PaymentStatus']."</span>";
                                                } else {

                                                    echo "<span class='badge badge-danger'>".$rowd6['PaymentStatus']."</span>";
                                                }

                                                echo "</td>"; 
                                                echo "<td>".date_format(date_create($rowd6['DatePaid']), 'd M, Y') . "</td>"; 
                                                
                                                echo "</tr>"; 

                                                $count++;
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
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