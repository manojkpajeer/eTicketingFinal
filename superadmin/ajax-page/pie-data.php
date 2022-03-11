<?php
include '../../config/connection.php';
header('Content-Type: application/json');

$data_points = array();

$res = mysqli_query($conn, "SELECT EM_Id FROM event_master WHERE EventStatus = 'Publish' AND BookingStatus = true ORDER BY EM_Id DESC LIMIT 1");
$row = mysqli_fetch_assoc($res);
    
$result = mysqli_query($conn, "SELECT PriceCategoryName, SeatsNo FROM category_master WHERE EventId = '$row[EM_Id]'");

$data = array();

while($rows = mysqli_fetch_array($result))
{        
    $data[] = array(
        'category' => $rows['PriceCategoryName'],
        'seats' => $rows['SeatsNo']
    );       
}

echo json_encode($data);

?>