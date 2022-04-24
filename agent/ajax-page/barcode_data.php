<?php
    include '../../config/connection.php';
    
    if (!empty($_POST['event_id'])) {

        if (!empty($_POST['barcode_no'])) {

            $resbar = mysqli_query($conn, "SELECT BM_Id FROM barcode_master WHERE Barcode = '$_POST[barcode_no]' AND PerformanceCode = '$_POST[event_id]' ");
            if (mysqli_num_rows($resbar) > 0) {

                $resqty = mysqli_query($conn, "SELECT InTime FROM scanner_master WHERE Barcode = '$_POST[barcode_no]' AND PerformanceCode = '$_POST[event_id]' ");
                if (mysqli_num_rows($resqty) > 0) {
                    
                    if(mysqli_query($conn, "UPDATE scanner_master SET OutTime = NOW() WHERE Barcode = '$_POST[barcode_no]' AND PerformanceCode = '$_POST[event_id]'")) {
                        
                        $data['status_code'] = 1;
                        $data['message'] = 'Out';
                    } else {

                        $data['status_code'] = 0;
                        $data['message'] = 'Oops, Unable to add barcode..';
                    }
                } else {
                    
                    if(mysqli_query($conn, "INSERT INTO scanner_master (PerformanceCode, Barcode, InTime) VALUES('$_POST[event_id]', '$_POST[barcode_no]', NOW())")) {
                        
                        $data['status_code'] = 1;
                        $data['message'] = 'In';
                    } else {
                        $data['status_code'] = 0;
                        $data['message'] = 'Oops, Unable to add barcode..';
                    }
                }
            } else {
                $data['status_code'] = 0;
                $data['message'] = 'Oops, Barcode does not exist for this event..';
            }
        } else {
            $data['status_code'] = 0;
            $data['message'] = 'Oops, Barcode should not be empty..';
        }
    } else {
        $data['status_code'] = -1;
        $data['message'] = 'Oops, Unable to process yor requestss..';
    }
    echo json_encode($data);
?>