<?php
    include '../../config/connection.php';
    header('Content-Type: application/json');  

    $data = array();

    $data['quantity'] = array();
    $data['day'] = array();

    $res = mysqli_query($conn, "SELECT DAYNAME(DateCreate) AS yourday, COALESCE(SUM(Quantity), 0) AS Quantity FROM sales_data WHERE Status = true AND DateCreate > NOW() - INTERVAL 1 WEEK GROUP BY yourday");
    if(mysqli_num_rows($res)>0){
        while($row = mysqli_fetch_assoc($res)){

            array_push($data['quantity'], $row['Quantity']);
            array_push($data['day'], $row['yourday']);
        }
    }   

    echo json_encode($data);

?>