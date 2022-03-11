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

    if (isset($_GET['did'])) {
        
        if (mysqli_query($conn, "DELETE customer_master, login_master FROM customer_master INNER JOIN login_master ON  customer_master.CustomerEmail = login_master.UserEmail WHERE customer_master.CM_Id = '$_GET[did]'")){

            echo "<script>alert('Yay, Customer deleted successfully..');location.href='customer-list.php';</script>";     
        } else {

            echo "<script>alert('Oops, Unable to delete customer.');</script>";
        }
    }

    if (isset($_GET['iid'])) {
        
        if (mysqli_query($conn, "UPDATE customer_master SET CustomerStatus = 0 WHERE CM_Id = '" . $_GET['iid'] . "'")){

            echo "<script>alert('Yay, Customer In-Actived successfully..');location.href='customer-list.php';</script>";     
        } else {

            echo "<script>alert('Oops, Unable to inactive customer.');</script>";
        }
    }

    if (isset($_GET['aid'])) {
        
        if (mysqli_query($conn, "UPDATE customer_master SET CustomerStatus = 1 WHERE CM_Id = '" . $_GET['aid'] . "'")){

            echo "<script>alert('Yay, Customer Actived successfully..');location.href='customer-list.php';</script>";     
        } else {

            echo "<script>alert('Oops, Unable to active customer.');</script>";
        }
    }
?>

<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="data-tables">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card card_border p-4 border-primary-top">
                        <h3 class="card__title position-absolute">Manage Customer</h3>
                        <div class="table-responsive">
                            <table id="meastroTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer ID</th>
                                        <th>Customer Name</th>
                                        <th>Email Id</th>
                                        <th>Phone No</th>
                                        <th>Date Create</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $resd6 = mysqli_query($conn, "SELECT * FROM customer_master ORDER BY CM_Id DESC");
                                        if (mysqli_num_rows($resd6) > 0) {

                                            $count = 1;
                                            while($rowd6 = mysqli_fetch_assoc($resd6)) {
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>"; 
                                                echo "<td>".$rowd6['CustomerId']."</td>"; 
                                                echo "<td>".$rowd6['Saluation']." " .$rowd6['FirstName'] . " " .$rowd6['LastName']. "</td>"; 
                                                echo "<td>".$rowd6['CustomerEmail']."</td>"; 
                                                echo "<td>".$rowd6['CustomerPhone']."</td>"; 
                                                echo "<td>".date_format(date_create($rowd6['DateCreate']), 'd M, Y') . "</td>"; 
                                                echo "<td>"; 
                                                if ($rowd6['CustomerStatus']) {
                                                    echo "<span class='badge badge-success'>Active</span>";
                                                } else {
                                                    echo "<span class='badge badge-danger'>In-Active</span>";
                                                }
                                                echo "</td>"; 
                                                echo "<td>";
                                                ?>
                                                <a href="customer-list.php?did=<?php echo $rowd6['CM_Id'];?>" onClick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash"></i></a>
                                                <?php
                                                if ($rowd6['CustomerStatus']) {

                                                    echo " | <a href='customer-list.php?iid=$rowd6[CM_Id]'><i class='fa fa-user'></i></a></td>";
                                                } else {

                                                    echo " | <a href='customer-list.php?aid=$rowd6[CM_Id]'><i class='fa fa-user'></i></a></td>";
                                                }
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