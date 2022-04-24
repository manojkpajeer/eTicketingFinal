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
    
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Maestro Events</title>
    <!-- Site Icon -->
    <link rel="icon" href="assets/images/tab_image.png">
    <style>
         * {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important; 
        }
        @page { size: letter portrait;
        margin: 0; }
    </style>
  </head>
  <body onload="window.print();">
  <script>
        window.onafterprint = function(event) {
            location.href="queries.php";
        };
  </script>
      <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12 mb-4">
                <table class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Email Id</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $resd6 = mysqli_query($conn, "SELECT * FROM contact_master ORDER BY CM_Id DESC");
                        if (mysqli_num_rows($resd6) > 0) {

                            $count = 1;
                            while($rowd6 = mysqli_fetch_assoc($resd6)) {
                                
                                echo "<tr>"; 
                                echo "<th>".$count."</th>"; 
                                echo "<td>".$rowd6['CustomerName']."</td>"; 
                                echo "<td>".$rowd6['CustomerEmail']."</td>"; 
                                echo "<td>".$rowd6['Subject']."</td>"; 
                                echo "<td>".$rowd6['Message']."</td>"; 
                                echo "<td>".date_format(date_create($rowd6['DateCreate']), 'd M, Y') . "</td>";
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>