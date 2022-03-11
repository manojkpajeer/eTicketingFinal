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
                        <h3 class="card__title position-absolute">Barcode Report</h3>
                        <div class="table-responsive">
                            <table id="meastroTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Event Name</th>
                                        <th>Barcode</th>
                                        <th>In Time</th>
                                        <th>Out Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $resd6 = mysqli_query($conn, "SELECT event_master.EventName, scanner_master.Barcode, scanner_master.InTime, scanner_master.OutTime FROM scanner_master JOIN event_master ON scanner_master.PerformanceCode = event_master.EventCode WHERE event_master.EventCode = '$_GET[id]' AND scanner_master.PerformanceCode = '$_GET[id]' AND NOT event_master.EventStatus = 'New'");
                                        if (mysqli_num_rows($resd6) > 0) {

                                            $count = 1;
                                            while($rowd6 = mysqli_fetch_assoc($resd6)) {
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>"; 
                                                echo "<td>".$rowd6['EventName']."</td>"; 
                                                echo "<td>".$rowd6['Barcode']."</td>"; 
                                                echo "<td>".date_format(date_create($rowd6['InTime']), 'd M, Y') . "</td>"; 
                                                echo "<td>".date_format(date_create($rowd6['OutTime']), 'd M, Y') . "</td>"; 
                                                
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