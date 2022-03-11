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
                        <h3 class="card__title position-absolute">Login List</h3>
                        <div class="table-responsive">
                            <table id="meastroTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User Name</th>
                                        <th>Role</th>
                                        <th>IP Address</th>
                                        <th>Logged On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $resd6 = mysqli_query($conn, "SELECT * FROM log_master ORDER BY LO_id DESC");
                                        if (mysqli_num_rows($resd6) > 0) {

                                            $count = 1;
                                            while($rowd6 = mysqli_fetch_assoc($resd6)) {
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>"; 
                                                if ($rowd6['UserRole'] == 'Admin') {

                                                    $resUser = mysqli_query($conn, "SELECT FullName FROM admin_master WHERE AM_Id = '$rowd6[UserId]'");
                                                    if (mysqli_num_rows($resUser) > 0) {

                                                        $resUser = mysqli_fetch_assoc($resUser);
                                                        
                                                        echo "<td>".$resUser['FullName']."</td>"; 
                                                    } else {

                                                        echo "<td></td>"; 
                                                    }
                                                } else if ($rowd6['UserRole'] == 'Ajent') {
                                                    
                                                    $resUser = mysqli_query($conn, "SELECT FullName FROM ajent_master WHERE AJM_Id = '$rowd6[UserId]'");
                                                    if (mysqli_num_rows($resUser) > 0) {

                                                        $resUser = mysqli_fetch_assoc($resUser);
                                                        
                                                        echo "<td>".$resUser['FullName']."</td>"; 
                                                    } else {

                                                        echo "<td></td>"; 
                                                    }
                                                } else if ($rowd6['UserRole'] == 'Staff') {
                                                    
                                                    $resUser = mysqli_query($conn, "SELECT FullName FROM staff_master WHERE ST_Id = '$rowd6[UserId]'");
                                                    if (mysqli_num_rows($resUser) > 0) {

                                                        $resUser = mysqli_fetch_assoc($resUser);
                                                        
                                                        echo "<td>".$resUser['FullName']."</td>"; 
                                                    } else {

                                                        echo "<td></td>"; 
                                                    }
                                                } else if ($rowd6['UserRole'] == 'Customer') {
                                                    
                                                    $resUser = mysqli_query($conn, "SELECT Saluation, FirstName, LastName FROM customer_master WHERE CM_Id = '$rowd6[UserId]'");
                                                    if (mysqli_num_rows($resUser) > 0) {

                                                        $resUser = mysqli_fetch_assoc($resUser);
                                                        
                                                        echo "<td>".$resUser['Saluation']." ".$resUser['FirstName']." ".$resUser['LastName']."</td>"; 
                                                    } else {

                                                        echo "<td></td>"; 
                                                    }
                                                }
                                                
                                                echo "<td>".$rowd6['UserRole']."</td>"; 
                                                echo "<td>".$rowd6['IPAddress']."</td>"; 
                                                echo "<td>".date_format(date_create($rowd6['CreateDate']), 'd M, Y') . "</td>"; 
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