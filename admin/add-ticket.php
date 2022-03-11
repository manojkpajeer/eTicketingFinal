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
    
    if(isset($_POST['add'])){

        if(mysqli_query($conn, "INSERT INTO ticket_master(Ticket, Status, DateCreate) VALUES 
            ('$_POST[event_name]',  1, NOW())")){

            echo "<script>alert('Yay, Ticket type added..');</script>";     
        }
        else{

            echo "<script>alert('Oops, Unable to add ticket type..');</script>";
            // echo mysqli_error($conn);
        }
    }
?>

<!-- main content start -->
<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="row">
            <div class="col-xl-12 pr-xl-12">
                <div class="card card_border border-primary-top">
                <div class="card-header chart-grid__header float-left">Create Ticket Type</div>
                    <div class="card-body">
                    <form method="post" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                        <div class="col-md-4">
                            <label for="i1" class="form-label">Type Name</label>
                            <input type="text" class="form-control input-style" id="i1" required name="event_name">
                            <div class="invalid-feedback">
                            Please enter a type name
                            </div>
                        </div>
                        <hr class="col-md-11">
                        <div class="col-12">
                            <button class="btn btn-primary btn-style" type="submit" name="add">Submit</button>
                        </div>
                        </form>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    require_once './pages/footer.php';
?>