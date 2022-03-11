<?php
    session_start();
        
    if(!isset($_SESSION['is_staff_login'])){
        header('Location: ./pages/logout.php');
    }
    else{
        if(!$_SESSION['is_staff_login']){
            header('Location: ./pages/logout.php');
        }
    }
        
    require_once '../config/connection.php';
    require_once './pages/link.php';
    require_once './pages/sidebar.php';
    require_once './pages/header.php';

    if (isset($_GET['did'])) {
        
        if (mysqli_query($conn, "DELETE FROM ticket_master WHERE TT_Id = '$_GET[did]'")){

            echo "<script>alert('Yay, Ticket type deleted successfully..');location.href='manage-ticket.php';</script>";     
        } else {

            echo "<script>alert('Oops, Unable to delete ticket type.');</script>";
        }
    }

    if (isset($_POST['update'])) { 

        if (mysqli_query($conn, "UPDATE ticket_master SET Ticket = '$_POST[event_name]', Status = '$_POST[status]' WHERE TT_Id = '$_POST[uEventId]'")) {

            echo "<script>alert('Yay, Ticket type updated successfully..');</script>";     
        } else {

            echo "<script>alert('Oops, Unable to update ticket type..');</script>";
        }
    }
?>

<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="data-tables">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card card_border p-4 border-primary-top">
                        <h3 class="card__title position-absolute">Manage Ticket Type</h3>
                        <div class="table-responsive">
                            <table id="meastroTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Type Name</th>
                                        <th>Status</th>
                                        <th>Created On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $resd6 = mysqli_query($conn, "SELECT * FROM ticket_master ORDER BY TT_Id DESC");
                                        if (mysqli_num_rows($resd6) > 0) {

                                            $count = 1;
                                            while($rowd6 = mysqli_fetch_assoc($resd6)) {
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>"; 
                                                echo "<td>".$rowd6['Ticket']."</td>"; 
                                                echo "<td>"; 
                                                if ($rowd6['Status']) {
                                                    echo "<span class='badge badge-success'>Active</span>";
                                                } else {
                                                    echo "<span class='badge badge-danger'>In-Active</span>";
                                                }
                                                echo "</td>";
                                                echo "<td>".date_format(date_create($rowd6['DateCreate']), 'd M, Y') . "</td>"; 
                                                echo "<td>";
                                                ?>
                                                <a href="#" data-toggle="modal" data-target="#product<?php echo $rowd6['TT_Id'];?>"><i class='fa fa-pencil'></i></a> | 
                                                <a href="manage-ticket.php?did=<?php echo $rowd6['TT_Id'];?>" onClick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash"></i></a>
                                                <?php
                                                echo "</td>";
                                                echo "</tr>"; 

                                                $count++;

                                                ?>
                                                    <div class="modal fade" id="product<?php echo $rowd6['TT_Id'];?>" tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <form method="POST" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo "Manage Event - ".$rowd6['Ticket'];?></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body g-3 row">
                                                                        <div class="col-md-6">
                                                                            <label for="i1" class="form-label">Event Name</label>
                                                                            <input type="text" class="form-control input-style" id="i1" value="<?php echo $rowd6['Ticket'];?>" required name="event_name" title="Please enter a ticket type">
                                                                        </div>

                                                                        <input type="hidden" name="uEventId" value="<?php echo $rowd6['TT_Id'];?>">

                                                                        <div class="col-md-6">
                                                                            <label for="validationCustom02" class="form-label">Status</label>
                                                                            <select class="form-control input-style" id="validationCustom04" required name="status" title="Please choose status">
                                                                                <option value="">Select</option>
                                                                                <option value="1" <?php if($rowd6['Status']){echo 'selected';}?>>Active</option>
                                                                                <option value="0" <?php if(!$rowd6['Status']){echo 'selected';}?>>In-Active</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-success" name="update">Save changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                
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