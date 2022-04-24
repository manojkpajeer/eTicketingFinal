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
        
        if (mysqli_query($conn, "DELETE FROM badge_master WHERE BD_Id = '$_GET[did]'")){

            echo "<script>alert('Yay, Badge deleted successfully..');location.href='manage-badge.php?eid=$_GET[eid]&ecode=$_GET[ecode]';</script>";     
        } else {

            echo "<script>alert('Oops, Unable to delete badge.');</script>";
        }
    }

    if (isset($_POST['update'])) { 

        $resBarcode = mysqli_query($conn, "SELECT barcode_master.Barcode FROM sales_master JOIN barcode_master ON 
        sales_master.OrderId = barcode_master.OrderId JOIN customer_master ON 
        customer_master.CM_Id = sales_master.CustomerId WHERE barcode_master.PerformanceCode = '$_GET[ecode]' 
        AND sales_master.EventId='$_GET[eid]' AND customer_master.CustomerStatus = 1
        AND customer_master.FirstName = '$_POST[first_name]' AND customer_master.LastName = '$_POST[last_name]' AND 
        customer_master.CustomerPhone = '$_POST[phone]' ORDER BY sales_master.SM_Id ");

        if (mysqli_num_rows($resBarcode) > 0) {

            $resBarcode = mysqli_fetch_assoc($resBarcode);

            if (mysqli_query($conn, "UPDATE badge_master SET FirstName = '$_POST[first_name]', LastName = '$_POST[last_name]', 
                EmailId = '$_POST[email]', PhoneNo = '$_POST[phone]', Nationality = '$_POST[nationality]', Country = '$_POST[country]', 
                BarcodeNo = '$resBarcode[Barcode]', BadgeStatus = '$_POST[status]', CompanyName = '$_POST[company]', 
                Designation = '$_POST[designation]', TotalAmount = '$_POST[amount]', TicketId = '$_POST[ticketchoose]' WHERE BD_Id = '$_POST[badge_id]'")) {
  
                echo "<script>alert('Yay, Badge updated successfully..');</script>";
            }
            else{

                echo "<script>alert('Oops, Unable to updated badge..');</script>";
            }
        } else {

            $resBarcode2 = mysqli_query($conn, "SELECT barcode_master.Barcode FROM sales_master JOIN barcode_master ON 
            sales_master.OrderId = barcode_master.OrderId JOIN agent_customer ON 
            agent_customer.AC_Id = sales_master.CustomerId WHERE barcode_master.PerformanceCode = '$_GET[ecode]' 
            AND sales_master.EventId='$_GET[eid]' AND agent_customer.CustomerStatus = 1
            AND agent_customer.FirstName = '$_POST[first_name]' AND agent_customer.LastName = '$_POST[last_name]' AND 
            agent_customer.CustomerPhone = '$_POST[phone]' ORDER BY sales_master.SM_Id ");

            if (mysqli_num_rows($resBarcode2) > 0) {

                $resBarcode2 = mysqli_fetch_assoc($resBarcode2);

                if (mysqli_query($conn, "UPDATE badge_master SET FirstName = '$_POST[first_name]', LastName = '$_POST[last_name]', 
                    EmailId = '$_POST[email]', PhoneNo = '$_POST[phone]', Nationality = '$_POST[nationality]', Country = '$_POST[country]', 
                    BarcodeNo = '$resBarcode[Barcode]', BadgeStatus = '$_POST[status]', CompanyName = '$_POST[company]', 
                    Designation = '$_POST[designation]', TotalAmount = '$_POST[amount]', TicketId = '$_POST[ticketchoose]' WHERE BD_Id = '$_POST[badge_id]'")) {
    
                    echo "<script>alert('Yay, Badge updated successfully..');</script>";
                }
                else{

                    echo "<script>alert('Oops, Unable to updated badge..');</script>";
                }
            } else {

                echo "<script>alert('Oops, No barcode found for this user..');</script>";
            }
        }
    }
?>

<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="data-tables">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card card_border p-4 border-primary-top">
                        <h3 class="card__title position-absolute">Manage Badge</h3>
                        <div class="table-responsive">
                            <table id="meastroTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>PhoneNo</th>
                                        <th>Email</th>
                                        <th>Company</th>
                                        <th>Designation</th>
                                        <th>Created On</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $resd6 = mysqli_query($conn, "SELECT * FROM badge_master WHERE EventId = '$_GET[eid]' ORDER BY BD_Id DESC");
                                        if (mysqli_num_rows($resd6) > 0) {

                                            $count = 1;
                                            while($rowd6 = mysqli_fetch_assoc($resd6)) {
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>"; 
                                                echo "<td>".$rowd6['FirstName']." ".$rowd6['LastName']."</td>"; 
                                                echo "<td>".$rowd6['PhoneNo']."</td>"; 
                                                echo "<td>".$rowd6['EmailId']."</td>"; 
                                                echo "<td>".$rowd6['CompanyName']."</td>"; 
                                                echo "<td>".$rowd6['Designation']."</td>"; 
                                                echo "<td>".date_format(date_create($rowd6['DateCreate']), 'd M, Y') . "</td>"; 
                                                echo "<td>"; 
                                                if ($rowd6['BadgeStatus']) {
                                                    echo "<span class='badge badge-success'>Active</span>";
                                                } else {
                                                    echo "<span class='badge badge-danger'>In-Active</span>";
                                                }
                                                echo "</td>";
                                                echo "<td>";
                                                ?>
                                                <a href="#" data-toggle="modal" data-target="#product<?php echo $rowd6['BD_Id'];?>"><i class='fa fa-pencil'></i></a> | 
                                                <a href="manage-badge.php?eid=<?php echo $_GET['eid'];?>&did=<?php echo $rowd6['BD_Id'];?>" onClick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash"></i></a> | 
                                                <a href="print-badge.php?pid=<?php echo $rowd6['BD_Id'];?>&eid=<?php echo $_GET['eid'];?>&ecode=<?php echo $_GET['ecode'];?>"><i class="fa fa-print"></i></a> | 
                                                <a href="print-badge-designation.php?pid=<?php echo $rowd6['BD_Id'];?>&eid=<?php echo $_GET['eid'];?>&ecode=<?php echo $_GET['ecode'];?>"><i class="fa fa-clipboard"></i></a> |
                                                <a href="print-barcode.php?bid=<?php echo $rowd6['BarcodeNo'];?>&eid=<?php echo $_GET['eid'];?>&ecode=<?php echo $_GET['ecode'];?>"><i class="fa fa-barcode"></i></a> | 
                                                <a href="print-qrcode.php?bid=<?php echo $rowd6['BarcodeNo'];?>&eid=<?php echo $_GET['eid'];?>&ecode=<?php echo $_GET['ecode'];?>"><i class="fa fa-qrcode"></i></a>
                                                <?php
                                                echo "</td>";
                                                echo "</tr>"; 

                                                $count++;

                                                ?>
                                                    <div class="modal fade" id="product<?php echo $rowd6['BD_Id'];?>" tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <form method="POST" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle">Manage Badge</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body g-3 row">
                                                                        <div class="col-md-4">
                                                                            <label  class="form-label">First Name</label>
                                                                            <input type="text" class="form-control input-style" value="<?php echo $rowd6['FirstName'];?>" required name="first_name" pattern="[A-Za-z]{1,49}" maxlength="49">
                                                                            <div class="invalid-feedback">
                                                                                Enter valid first name
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label class="form-label">Last Name</label>
                                                                            <input type="text" class="form-control input-style" value="<?php echo $rowd6['LastName'];?>" required name="last_name" pattern="[A-Za-z]{1,49}" maxlength="49">
                                                                            <div class="invalid-feedback">
                                                                                Enter valid last name
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <label  class="form-label">Email ID</label>
                                                                            <input type="email" class="form-control input-style" value="<?php echo $rowd6['EmailId'];?>" required name="email" maxlength="99">
                                                                            <div class="invalid-feedback">
                                                                            Enter valid email id
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4 mt-3">
                                                                            <label  class="form-label">Nationality</label>
                                                                            <select name="nationality" class="form-control input-style" required>
                                                                                <option value="">Choose..</option>
                                                                                <option value="AF" <?php if ($rowd6['Nationality'] == 'AF') { echo 'selected';}?>>Afghan</option>
                                                                                <option value="AL" <?php if ($rowd6['Nationality'] == 'AL') { echo 'selected';}?>>Albanian</option>
                                                                                <option value="DZ" <?php if ($rowd6['Nationality'] == 'DZ') { echo 'selected';}?>>Algerian</option>
                                                                                <option value="AS" <?php if ($rowd6['Nationality'] == 'AS') { echo 'selected';}?>>American</option>
                                                                                <option value="AO" <?php if ($rowd6['Nationality'] == 'AO') { echo 'selected';}?>>Angolan</option>
                                                                                <option value="AI" <?php if ($rowd6['Nationality'] == 'AI') { echo 'selected';}?>>Anguilla</option>
                                                                                <option value="AQ" <?php if ($rowd6['Nationality'] == 'AQ') { echo 'selected';}?>>Antarctica</option>
                                                                                <option value="AG" <?php if ($rowd6['Nationality'] == 'AG') { echo 'selected';}?>>Antiguans</option>
                                                                                <option value="AD" <?php if ($rowd6['Nationality'] == 'AD') { echo 'selected';}?>>Andorran</option>
                                                                                <option value="AR" <?php if ($rowd6['Nationality'] == 'AR') { echo 'selected';}?>>Argentinean</option>
                                                                                <option value="AM" <?php if ($rowd6['Nationality'] == 'AM') { echo 'selected';}?>>Armenian</option>
                                                                                <option value="AW" <?php if ($rowd6['Nationality'] == 'AW') { echo 'selected';}?>>Aruba</option>
                                                                                <option value="AU" <?php if ($rowd6['Nationality'] == 'AU') { echo 'selected';}?>>Australian</option>
                                                                                <option value="AT" <?php if ($rowd6['Nationality'] == 'AT') { echo 'selected';}?>>Austrian</option>
                                                                                <option value="AZ" <?php if ($rowd6['Nationality'] == 'AZ') { echo 'selected';}?>>Azerbaijani</option>
                                                                                <option value="BS" <?php if ($rowd6['Nationality'] == 'BS') { echo 'selected';}?>>Bahamian</option>
                                                                                <option value="BH" <?php if ($rowd6['Nationality'] == 'BH') { echo 'selected';}?>>Bahraini</option>
                                                                                <option value="BD" <?php if ($rowd6['Nationality'] == 'BD') { echo 'selected';}?>>Bangladeshi</option>
                                                                                <option value="BB" <?php if ($rowd6['Nationality'] == 'BB') { echo 'selected';}?>>Barbadian</option>
                                                                                <option value="BY" <?php if ($rowd6['Nationality'] == 'BY') { echo 'selected';}?>>Belarusian</option>
                                                                                <option value="BE" <?php if ($rowd6['Nationality'] == 'BE') { echo 'selected';}?>>Belgian</option>
                                                                                <option value="BZ" <?php if ($rowd6['Nationality'] == 'BZ') { echo 'selected';}?>>Belizean</option>
                                                                                <option value="BJ" <?php if ($rowd6['Nationality'] == 'BJ') { echo 'selected';}?>>Beninese</option>
                                                                                <option value="BM" <?php if ($rowd6['Nationality'] == 'BM') { echo 'selected';}?>>Bermuda</option>
                                                                                <option value="BT" <?php if ($rowd6['Nationality'] == 'BT') { echo 'selected';}?>>Bhutanese</option>
                                                                                <option value="BO" <?php if ($rowd6['Nationality'] == 'BO') { echo 'selected';}?>>Bolivian</option>
                                                                                <option value="BA" <?php if ($rowd6['Nationality'] == 'BA') { echo 'selected';}?>>Bosnian</option>
                                                                                <option value="BW" <?php if ($rowd6['Nationality'] == 'BW') { echo 'selected';}?>>Botswana</option>
                                                                                <option value="BV" <?php if ($rowd6['Nationality'] == 'BV') { echo 'selected';}?>>Bouvet Island</option>
                                                                                <option value="BR" <?php if ($rowd6['Nationality'] == 'BR') { echo 'selected';}?>>Brazilian</option>
                                                                                <option value="IO" <?php if ($rowd6['Nationality'] == 'IO') { echo 'selected';}?>>British</option>
                                                                                <option value="BN" <?php if ($rowd6['Nationality'] == 'BN') { echo 'selected';}?>>Bruneian</option>
                                                                                <option value="BG" <?php if ($rowd6['Nationality'] == 'BG') { echo 'selected';}?>>Bulgarian</option>
                                                                                <option value="BF" <?php if ($rowd6['Nationality'] == 'BF') { echo 'selected';}?>>Burkinabe</option>
                                                                                <option value="BI" <?php if ($rowd6['Nationality'] == 'BI') { echo 'selected';}?>>Burundian</option>
                                                                                <option value="KH" <?php if ($rowd6['Nationality'] == 'KH') { echo 'selected';}?>>Cambodian</option>
                                                                                <option value="CM" <?php if ($rowd6['Nationality'] == 'CM') { echo 'selected';}?>>Cameroonian</option>
                                                                                <option value="CA" <?php if ($rowd6['Nationality'] == 'CA') { echo 'selected';}?>>Canadian</option>
                                                                                <option value="CV" <?php if ($rowd6['Nationality'] == 'CV') { echo 'selected';}?>>Cape Verdean</option>
                                                                                <option value="KY" <?php if ($rowd6['Nationality'] == 'KY') { echo 'selected';}?>>Cayman Islands</option>
                                                                                <option value="CF" <?php if ($rowd6['Nationality'] == 'CF') { echo 'selected';}?>>Central African</option>
                                                                                <option value="TD" <?php if ($rowd6['Nationality'] == 'TD') { echo 'selected';}?>>Chadian</option>
                                                                                <option value="CL" <?php if ($rowd6['Nationality'] == 'CL') { echo 'selected';}?>>Chilean</option>
                                                                                <option value="CN" <?php if ($rowd6['Nationality'] == 'CN') { echo 'selected';}?>>Chinese</option>
                                                                                <option value="CX" <?php if ($rowd6['Nationality'] == 'CX') { echo 'selected';}?>>Christmas Island</option>
                                                                                <option value="CC" <?php if ($rowd6['Nationality'] == 'CC') { echo 'selected';}?>>Cocos (Keeling) Islands</option>
                                                                                <option value="CO" <?php if ($rowd6['Nationality'] == 'CO') { echo 'selected';}?>>Colombian</option>
                                                                                <option value="KM" <?php if ($rowd6['Nationality'] == 'KM') { echo 'selected';}?>>Comoran</option>
                                                                                <option value="CG" <?php if ($rowd6['Nationality'] == 'CG') { echo 'selected';}?>>Congolese</option>
                                                                                <option value="CD" <?php if ($rowd6['Nationality'] == 'CD') { echo 'selected';}?>>Congo, the Democratic Republic of the</option>
                                                                                <option value="CK" <?php if ($rowd6['Nationality'] == 'CK') { echo 'selected';}?>>Cook Islands</option>
                                                                                <option value="CR" <?php if ($rowd6['Nationality'] == 'CR') { echo 'selected';}?>>Costa Rican</option>
                                                                                <option value="CI" <?php if ($rowd6['Nationality'] == 'CI') { echo 'selected';}?>>Cote d'Ivoire</option>
                                                                                <option value="HR" <?php if ($rowd6['Nationality'] == 'HR') { echo 'selected';}?>>Croatian</option>
                                                                                <option value="CU" <?php if ($rowd6['Nationality'] == 'CU') { echo 'selected';}?>>Cuban</option>
                                                                                <option value="CY" <?php if ($rowd6['Nationality'] == 'CY') { echo 'selected';}?>>Cypriot</option>
                                                                                <option value="CZ" <?php if ($rowd6['Nationality'] == 'CZ') { echo 'selected';}?>>Czech</option>
                                                                                <option value="DK" <?php if ($rowd6['Nationality'] == 'DK') { echo 'selected';}?>>Danish</option>
                                                                                <option value="DJ" <?php if ($rowd6['Nationality'] == 'DJ') { echo 'selected';}?>>Djibouti</option>
                                                                                <option value="DM" <?php if ($rowd6['Nationality'] == 'DM') { echo 'selected';}?>>Dominican</option>
                                                                                <option value="DO" <?php if ($rowd6['Nationality'] == 'DO') { echo 'selected';}?>>Dutch</option>
                                                                                <option value="TP" <?php if ($rowd6['Nationality'] == 'TP') { echo 'selected';}?>>East Timorese</option>
                                                                                <option value="EC" <?php if ($rowd6['Nationality'] == 'EC') { echo 'selected';}?>>Ecuadorean</option>
                                                                                <option value="EG" <?php if ($rowd6['Nationality'] == 'EG') { echo 'selected';}?>>Egyptian</option>
                                                                                <option value="SV" <?php if ($rowd6['Nationality'] == 'SV') { echo 'selected';}?>>El Salvador</option>
                                                                                <option value="GQ" <?php if ($rowd6['Nationality'] == 'GQ') { echo 'selected';}?>>Equatorial Guinean</option>
                                                                                <option value="ER" <?php if ($rowd6['Nationality'] == 'ER') { echo 'selected';}?>>Eritrean</option>
                                                                                <option value="EE" <?php if ($rowd6['Nationality'] == 'EE') { echo 'selected';}?>>Estonian</option>
                                                                                <option value="ET" <?php if ($rowd6['Nationality'] == 'ET') { echo 'selected';}?>>Ethiopian</option>
                                                                                <option value="FK" <?php if ($rowd6['Nationality'] == 'FK') { echo 'selected';}?>>Falkland Islands (Malvinas)</option>
                                                                                <option value="FO" <?php if ($rowd6['Nationality'] == 'FO') { echo 'selected';}?>>Faroe Islands</option>
                                                                                <option value="FJ" <?php if ($rowd6['Nationality'] == 'FJ') { echo 'selected';}?>>Fijian</option>
                                                                                <option value="FI" <?php if ($rowd6['Nationality'] == 'FI') { echo 'selected';}?>>Finland</option>
                                                                                <option value="FR" <?php if ($rowd6['Nationality'] == 'FR') { echo 'selected';}?>>France</option>
                                                                                <option value="FX" <?php if ($rowd6['Nationality'] == 'FX') { echo 'selected';}?>>France, Metropolitan</option>
                                                                                <option value="GF" <?php if ($rowd6['Nationality'] == 'GF') { echo 'selected';}?>>French Guiana</option>
                                                                                <option value="PF" <?php if ($rowd6['Nationality'] == 'PF') { echo 'selected';}?>>French Polynesia</option>
                                                                                <option value="TF" <?php if ($rowd6['Nationality'] == 'TF') { echo 'selected';}?>>French Southern Territories</option>
                                                                                <option value="GA" <?php if ($rowd6['Nationality'] == 'GA') { echo 'selected';}?>>Gabonese</option>
                                                                                <option value="GM" <?php if ($rowd6['Nationality'] == 'GM') { echo 'selected';}?>>Gambian</option>
                                                                                <option value="GE" <?php if ($rowd6['Nationality'] == 'GE') { echo 'selected';}?>>Georgian</option>
                                                                                <option value="DE" <?php if ($rowd6['Nationality'] == 'DE') { echo 'selected';}?>>German</option>
                                                                                <option value="GH" <?php if ($rowd6['Nationality'] == 'GH') { echo 'selected';}?>>Ghanaian</option>
                                                                                <option value="GI" <?php if ($rowd6['Nationality'] == 'GI') { echo 'selected';}?>>Gibraltar</option>
                                                                                <option value="GR" <?php if ($rowd6['Nationality'] == 'GR') { echo 'selected';}?>>Greek</option>
                                                                                <option value="GL" <?php if ($rowd6['Nationality'] == 'GL') { echo 'selected';}?>>Greenland</option>
                                                                                <option value="GD" <?php if ($rowd6['Nationality'] == 'GD') { echo 'selected';}?>>Grenadian</option>
                                                                                <option value="GP" <?php if ($rowd6['Nationality'] == 'GP') { echo 'selected';}?>>Guadeloupe</option>
                                                                                <option value="GU" <?php if ($rowd6['Nationality'] == 'GU') { echo 'selected';}?>>Guam</option>
                                                                                <option value="GT" <?php if ($rowd6['Nationality'] == 'GT') { echo 'selected';}?>>Guatemalan</option>
                                                                                <option value="GN" <?php if ($rowd6['Nationality'] == 'GN') { echo 'selected';}?>>Guinean</option>
                                                                                <option value="GW" <?php if ($rowd6['Nationality'] == 'GW') { echo 'selected';}?>>Guinea-Bissauan</option>
                                                                                <option value="GY" <?php if ($rowd6['Nationality'] == 'GY') { echo 'selected';}?>>Guyanese</option>
                                                                                <option value="HT" <?php if ($rowd6['Nationality'] == 'HI') { echo 'selected';}?>>Haitian</option>
                                                                                <option value="HM" <?php if ($rowd6['Nationality'] == 'HM') { echo 'selected';}?>>Heard and Mc Donald Islands</option>
                                                                                <option value="VA" <?php if ($rowd6['Nationality'] == 'VA') { echo 'selected';}?>>Holy See (Vatican City State)</option>
                                                                                <option value="HN" <?php if ($rowd6['Nationality'] == 'HN') { echo 'selected';}?>>Honduran</option>
                                                                                <option value="HK" <?php if ($rowd6['Nationality'] == 'HK') { echo 'selected';}?>>Hong Kong</option>
                                                                                <option value="HU" <?php if ($rowd6['Nationality'] == 'HU') { echo 'selected';}?>>Hungarian</option>
                                                                                <option value="IS" <?php if ($rowd6['Nationality'] == 'IS') { echo 'selected';}?>>Icelander</option>
                                                                                <option value="IN" <?php if ($rowd6['Nationality'] == 'IN') { echo 'selected';}?>>Indian</option>
                                                                                <option value="ID" <?php if ($rowd6['Nationality'] == 'ID') { echo 'selected';}?>>Indonesian</option>
                                                                                <option value="IR" <?php if ($rowd6['Nationality'] == 'IR') { echo 'selected';}?>>Iranian</option>
                                                                                <option value="IQ" <?php if ($rowd6['Nationality'] == 'IQ') { echo 'selected';}?>>Iraqi</option>
                                                                                <option value="IE" <?php if ($rowd6['Nationality'] == 'IE') { echo 'selected';}?>>Irish</option>
                                                                                <option value="IL" <?php if ($rowd6['Nationality'] == 'IL') { echo 'selected';}?>>Israeli</option>
                                                                                <option value="IT" <?php if ($rowd6['Nationality'] == 'IT') { echo 'selected';}?>>Italian</option>
                                                                                <option value="JM" <?php if ($rowd6['Nationality'] == 'JM') { echo 'selected';}?>>Jamaican</option>
                                                                                <option value="JP" <?php if ($rowd6['Nationality'] == 'JP') { echo 'selected';}?>>Japanese</option>
                                                                                <option value="JO" <?php if ($rowd6['Nationality'] == 'JO') { echo 'selected';}?>>Jordanian</option>
                                                                                <option value="KZ" <?php if ($rowd6['Nationality'] == 'KZ') { echo 'selected';}?>>Kazakhstani</option>
                                                                                <option value="KE" <?php if ($rowd6['Nationality'] == 'KE') { echo 'selected';}?>>Kenyan</option>
                                                                                <option value="KI" <?php if ($rowd6['Nationality'] == 'KI') { echo 'selected';}?>>Kiribati</option>
                                                                                <option value="KP" <?php if ($rowd6['Nationality'] == 'KP') { echo 'selected';}?>>Korea, Democratic People's Republic of</option>
                                                                                <option value="KR" <?php if ($rowd6['Nationality'] == 'KR') { echo 'selected';}?>>Korea, Republic of</option>
                                                                                <option value="KW" <?php if ($rowd6['Nationality'] == 'KW') { echo 'selected';}?>>Kuwaiti</option>
                                                                                <option value="KG" <?php if ($rowd6['Nationality'] == 'KG') { echo 'selected';}?>>Kyrgyzstan</option>
                                                                                <option value="LA" <?php if ($rowd6['Nationality'] == 'LA') { echo 'selected';}?>>Lao People's Democratic Republic</option>
                                                                                <option value="LV" <?php if ($rowd6['Nationality'] == 'LV') { echo 'selected';}?>>Latvian</option>
                                                                                <option value="LB" <?php if ($rowd6['Nationality'] == 'LB') { echo 'selected';}?>>Lebanese</option>
                                                                                <option value="LS" <?php if ($rowd6['Nationality'] == 'LS') { echo 'selected';}?>>Lesotho</option>
                                                                                <option value="LR" <?php if ($rowd6['Nationality'] == 'LR') { echo 'selected';}?>>Liberian</option>
                                                                                <option value="LY" <?php if ($rowd6['Nationality'] == 'LY') { echo 'selected';}?>>Libyan Arab Jamahiriya</option>
                                                                                <option value="LI" <?php if ($rowd6['Nationality'] == 'LI') { echo 'selected';}?>>Liechtensteiner</option>
                                                                                <option value="LT" <?php if ($rowd6['Nationality'] == 'LT') { echo 'selected';}?>>Lithuanian</option>
                                                                                <option value="LU" <?php if ($rowd6['Nationality'] == 'LU') { echo 'selected';}?>>Luxembourger</option>
                                                                                <option value="MO" <?php if ($rowd6['Nationality'] == 'MO') { echo 'selected';}?>>Macau</option>
                                                                                <option value="MK" <?php if ($rowd6['Nationality'] == 'MK') { echo 'selected';}?>>Macedonia, The Former Yugoslav Republic of</option>
                                                                                <option value="MG" <?php if ($rowd6['Nationality'] == 'MG') { echo 'selected';}?>>Madagascar</option>
                                                                                <option value="MW" <?php if ($rowd6['Nationality'] == 'MW') { echo 'selected';}?>>Malawian</option>
                                                                                <option value="MY" <?php if ($rowd6['Nationality'] == 'MY') { echo 'selected';}?>>Malaysian</option>
                                                                                <option value="MV" <?php if ($rowd6['Nationality'] == 'MV') { echo 'selected';}?>>Maldivan</option>
                                                                                <option value="ML" <?php if ($rowd6['Nationality'] == 'ML') { echo 'selected';}?>>Malian</option>
                                                                                <option value="MT" <?php if ($rowd6['Nationality'] == 'MT') { echo 'selected';}?>>Maltese</option>
                                                                                <option value="MH" <?php if ($rowd6['Nationality'] == 'MH') { echo 'selected';}?>>Marshallese</option>
                                                                                <option value="MQ" <?php if ($rowd6['Nationality'] == 'MQ') { echo 'selected';}?>>Martinique</option>
                                                                                <option value="MR" <?php if ($rowd6['Nationality'] == 'MR') { echo 'selected';}?>>Mauritanian</option>
                                                                                <option value="MU" <?php if ($rowd6['Nationality'] == 'MU') { echo 'selected';}?>>Mauritian</option>
                                                                                <option value="YT" <?php if ($rowd6['Nationality'] == 'YT') { echo 'selected';}?>>Mayotte</option>
                                                                                <option value="MX" <?php if ($rowd6['Nationality'] == 'MX') { echo 'selected';}?>>Mexican</option>
                                                                                <option value="FM" <?php if ($rowd6['Nationality'] == 'FM') { echo 'selected';}?>>Micronesia, Federated States of</option>
                                                                                <option value="MD" <?php if ($rowd6['Nationality'] == 'MD') { echo 'selected';}?>>Moldova, Republic of</option>
                                                                                <option value="MC" <?php if ($rowd6['Nationality'] == 'MC') { echo 'selected';}?>>Monacan</option>
                                                                                <option value="MN" <?php if ($rowd6['Nationality'] == 'MN') { echo 'selected';}?>>Mongolian</option>
                                                                                <option value="MS" <?php if ($rowd6['Nationality'] == 'MS') { echo 'selected';}?>>Montserrat</option>
                                                                                <option value="MA" <?php if ($rowd6['Nationality'] == 'MA') { echo 'selected';}?>>Moroccan</option>
                                                                                <option value="MZ" <?php if ($rowd6['Nationality'] == 'MZ') { echo 'selected';}?>>Mozambican</option>
                                                                                <option value="MM" <?php if ($rowd6['Nationality'] == 'MM') { echo 'selected';}?>>Myanmar</option>
                                                                                <option value="NA" <?php if ($rowd6['Nationality'] == 'NA') { echo 'selected';}?>>Namibian</option>
                                                                                <option value="NR" <?php if ($rowd6['Nationality'] == 'NR') { echo 'selected';}?>>Nauruan</option>
                                                                                <option value="NP" <?php if ($rowd6['Nationality'] == 'NP') { echo 'selected';}?>>Nepalese</option>
                                                                                <option value="NL" <?php if ($rowd6['Nationality'] == 'NL') { echo 'selected';}?>>Netherlands</option>
                                                                                <option value="AN" <?php if ($rowd6['Nationality'] == 'AN') { echo 'selected';}?>>Netherlands Antilles</option>
                                                                                <option value="NC" <?php if ($rowd6['Nationality'] == 'NC') { echo 'selected';}?>>New Caledonia</option>
                                                                                <option value="NZ" <?php if ($rowd6['Nationality'] == 'NZ') { echo 'selected';}?>>New Zealander</option>
                                                                                <option value="NI" <?php if ($rowd6['Nationality'] == 'NI') { echo 'selected';}?>>Nicaraguan</option>
                                                                                <option value="NE" <?php if ($rowd6['Nationality'] == 'NE') { echo 'selected';}?>>Niger</option>
                                                                                <option value="NG" <?php if ($rowd6['Nationality'] == 'NG') { echo 'selected';}?>>Nigerien</option>
                                                                                <option value="NU" <?php if ($rowd6['Nationality'] == 'NU') { echo 'selected';}?>>Niue</option>
                                                                                <option value="NF" <?php if ($rowd6['Nationality'] == 'NF') { echo 'selected';}?>>Norfolk Island</option>
                                                                                <option value="MP" <?php if ($rowd6['Nationality'] == 'MP') { echo 'selected';}?>>Northern Mariana Islands</option>
                                                                                <option value="NO" <?php if ($rowd6['Nationality'] == 'NO') { echo 'selected';}?>>Norwegian</option>
                                                                                <option value="OM" <?php if ($rowd6['Nationality'] == 'OM') { echo 'selected';}?>>Omani</option>
                                                                                <option value="PK" <?php if ($rowd6['Nationality'] == 'PK') { echo 'selected';}?>>Pakistani</option>
                                                                                <option value="PW" <?php if ($rowd6['Nationality'] == 'PW') { echo 'selected';}?>>Palauan</option>
                                                                                <option value="PA" <?php if ($rowd6['Nationality'] == 'PA') { echo 'selected';}?>>Panamanian</option>
                                                                                <option value="PG" <?php if ($rowd6['Nationality'] == 'PG') { echo 'selected';}?>>Papua New Guinean</option>
                                                                                <option value="PY" <?php if ($rowd6['Nationality'] == 'PY') { echo 'selected';}?>>Paraguayan</option>
                                                                                <option value="PE" <?php if ($rowd6['Nationality'] == 'PE') { echo 'selected';}?>>Peruvian</option>
                                                                                <option value="PH" <?php if ($rowd6['Nationality'] == 'PH') { echo 'selected';}?>>Philippines</option>
                                                                                <option value="PN" <?php if ($rowd6['Nationality'] == 'PN') { echo 'selected';}?>>Pitcairn</option>
                                                                                <option value="PL" <?php if ($rowd6['Nationality'] == 'PL') { echo 'selected';}?>>Poland</option>
                                                                                <option value="PT" <?php if ($rowd6['Nationality'] == 'PT') { echo 'selected';}?>>Portuguese</option>
                                                                                <option value="PR" <?php if ($rowd6['Nationality'] == 'PR') { echo 'selected';}?>>Puerto Rico</option>
                                                                                <option value="QA" <?php if ($rowd6['Nationality'] == 'QA') { echo 'selected';}?>>Qatari</option>
                                                                                <option value="RE" <?php if ($rowd6['Nationality'] == 'RE') { echo 'selected';}?>>Reunion</option>
                                                                                <option value="RO" <?php if ($rowd6['Nationality'] == 'RO') { echo 'selected';}?>>Romanian</option>
                                                                                <option value="RU" <?php if ($rowd6['Nationality'] == 'RU') { echo 'selected';}?>>Russian Federation</option>
                                                                                <option value="RW" <?php if ($rowd6['Nationality'] == 'RW') { echo 'selected';}?>>Rwandan</option>
                                                                                <option value="KN" <?php if ($rowd6['Nationality'] == 'KN') { echo 'selected';}?>>Saint Kitts and Nevis</option> 
                                                                                <option value="LC" <?php if ($rowd6['Nationality'] == 'LC') { echo 'selected';}?>>Saint Lucian</option>
                                                                                <option value="VC" <?php if ($rowd6['Nationality'] == 'VC') { echo 'selected';}?>>Saint Vincent and the Grenadines</option>
                                                                                <option value="WS" <?php if ($rowd6['Nationality'] == 'WS') { echo 'selected';}?>>Samoan</option>
                                                                                <option value="SM" <?php if ($rowd6['Nationality'] == 'SM') { echo 'selected';}?>>San Marinese</option>
                                                                                <option value="ST" <?php if ($rowd6['Nationality'] == 'ST') { echo 'selected';}?>>Sao Tome and Principe</option> 
                                                                                <option value="SA" <?php if ($rowd6['Nationality'] == 'SA') { echo 'selected';}?>>Saudi</option>
                                                                                <option value="SN" <?php if ($rowd6['Nationality'] == 'SN') { echo 'selected';}?>>Senegal</option>
                                                                                <option value="SC" <?php if ($rowd6['Nationality'] == 'SC') { echo 'selected';}?>>Seychelles</option>
                                                                                <option value="SL" <?php if ($rowd6['Nationality'] == 'SL') { echo 'selected';}?>>Sierra Leone</option>
                                                                                <option value="SG" <?php if ($rowd6['Nationality'] == 'SG') { echo 'selected';}?>>Singapore</option>
                                                                                <option value="SK" <?php if ($rowd6['Nationality'] == 'SK') { echo 'selected';}?>>Slovakia (Slovak Republic)</option>
                                                                                <option value="SI" <?php if ($rowd6['Nationality'] == 'SI') { echo 'selected';}?>>Slovenia</option>
                                                                                <option value="SB" <?php if ($rowd6['Nationality'] == 'SB') { echo 'selected';}?>>Solomon Islands</option>
                                                                                <option value="SO" <?php if ($rowd6['Nationality'] == 'SO') { echo 'selected';}?>>Somalia</option>
                                                                                <option value="ZA" <?php if ($rowd6['Nationality'] == 'ZA') { echo 'selected';}?>>South Africa</option>
                                                                                <option value="GS" <?php if ($rowd6['Nationality'] == 'GS') { echo 'selected';}?>>South Georgia and the South Sandwich Islands</option>
                                                                                <option value="ES" <?php if ($rowd6['Nationality'] == 'ES') { echo 'selected';}?>>Spain</option>
                                                                                <option value="LK" <?php if ($rowd6['Nationality'] == 'LK') { echo 'selected';}?>>Sri Lanka</option>
                                                                                <option value="SH" <?php if ($rowd6['Nationality'] == 'SH') { echo 'selected';}?>>St. Helena</option>
                                                                                <option value="PM" <?php if ($rowd6['Nationality'] == 'PM') { echo 'selected';}?>>St. Pierre and Miquelon</option>
                                                                                <option value="SD" <?php if ($rowd6['Nationality'] == 'SD') { echo 'selected';}?>>Sudan</option>
                                                                                <option value="SR" <?php if ($rowd6['Nationality'] == 'SR') { echo 'selected';}?>>Suriname</option>
                                                                                <option value="SJ" <?php if ($rowd6['Nationality'] == 'SJ') { echo 'selected';}?>>Svalbard and Jan Mayen Islands</option>
                                                                                <option value="SZ" <?php if ($rowd6['Nationality'] == 'SZ') { echo 'selected';}?>>Swaziland</option>
                                                                                <option value="SE" <?php if ($rowd6['Nationality'] == 'SE') { echo 'selected';}?>>Sweden</option>
                                                                                <option value="CH" <?php if ($rowd6['Nationality'] == 'CH') { echo 'selected';}?>>Switzerland</option>
                                                                                <option value="SY" <?php if ($rowd6['Nationality'] == 'SY') { echo 'selected';}?>>Syrian Arab Republic</option>
                                                                                <option value="TW" <?php if ($rowd6['Nationality'] == 'TW') { echo 'selected';}?>>Taiwan, Province of China</option>
                                                                                <option value="TJ" <?php if ($rowd6['Nationality'] == 'TJ') { echo 'selected';}?>>Tajikistan</option>
                                                                                <option value="TZ" <?php if ($rowd6['Nationality'] == 'TZ') { echo 'selected';}?>>Tanzania, United Republic of</option>
                                                                                <option value="TH" <?php if ($rowd6['Nationality'] == 'TH') { echo 'selected';}?>>Thailand</option>
                                                                                <option value="TG" <?php if ($rowd6['Nationality'] == 'TG') { echo 'selected';}?>>Togo</option>
                                                                                <option value="TK" <?php if ($rowd6['Nationality'] == 'TK') { echo 'selected';}?>>Tokelau</option>
                                                                                <option value="TO" <?php if ($rowd6['Nationality'] == 'TO') { echo 'selected';}?>>Tonga</option>
                                                                                <option value="TT" <?php if ($rowd6['Nationality'] == 'TT') { echo 'selected';}?>>Trinidad and Tobago</option>
                                                                                <option value="TN" <?php if ($rowd6['Nationality'] == 'TN') { echo 'selected';}?>>Tunisia</option>
                                                                                <option value="TR" <?php if ($rowd6['Nationality'] == 'TR') { echo 'selected';}?>>Turkey</option>
                                                                                <option value="TM" <?php if ($rowd6['Nationality'] == 'TM') { echo 'selected';}?>>Turkmenistan</option>
                                                                                <option value="TC" <?php if ($rowd6['Nationality'] == 'TC') { echo 'selected';}?>>Turks and Caicos Islands</option>
                                                                                <option value="TV" <?php if ($rowd6['Nationality'] == 'TV') { echo 'selected';}?>>Tuvalu</option>
                                                                                <option value="UG" <?php if ($rowd6['Nationality'] == 'UG') { echo 'selected';}?>>Uganda</option>
                                                                                <option value="UA" <?php if ($rowd6['Nationality'] == 'UA') { echo 'selected';}?>>Ukraine</option>
                                                                                <option value="AE" <?php if ($rowd6['Nationality'] == 'AE') { echo 'selected';}?>>United Arab Emirates</option>
                                                                                <option value="GB" <?php if ($rowd6['Nationality'] == 'GB') { echo 'selected';}?>>United Kingdom</option>
                                                                                <option value="US" <?php if ($rowd6['Nationality'] == 'US') { echo 'selected';}?>>United States</option>
                                                                                <option value="UM" <?php if ($rowd6['Nationality'] == 'UM') { echo 'selected';}?>>United States Minor Outlying Islands</option>
                                                                                <option value="UY" <?php if ($rowd6['Nationality'] == 'UY') { echo 'selected';}?>>Uruguayan</option>
                                                                                <option value="UZ" <?php if ($rowd6['Nationality'] == 'UZ') { echo 'selected';}?>>Uzbekistani</option>
                                                                                <option value="VU" <?php if ($rowd6['Nationality'] == 'VU') { echo 'selected';}?>>Vanuatu</option>
                                                                                <option value="VE" <?php if ($rowd6['Nationality'] == 'VE') { echo 'selected';}?>>Venezuelan</option>
                                                                                <option value="VN" <?php if ($rowd6['Nationality'] == 'VN') { echo 'selected';}?>>Viet Nam</option>
                                                                                <option value="VG" <?php if ($rowd6['Nationality'] == 'VG') { echo 'selected';}?>>Virgin Islands (British)</option>
                                                                                <option value="VI" <?php if ($rowd6['Nationality'] == 'VI') { echo 'selected';}?>>Virgin Islands (U.S.)</option>
                                                                                <option value="WF" <?php if ($rowd6['Nationality'] == 'WF') { echo 'selected';}?>>Wallis and Futuna Islands</option>
                                                                                <option value="EH" <?php if ($rowd6['Nationality'] == 'EH') { echo 'selected';}?>>Western Sahara</option>
                                                                                <option value="YE" <?php if ($rowd6['Nationality'] == 'YE') { echo 'selected';}?>>Yemenite</option>
                                                                                <option value="YU" <?php if ($rowd6['Nationality'] == 'YU') { echo 'selected';}?>>Yugoslavia</option>
                                                                                <option value="ZM" <?php if ($rowd6['Nationality'] == 'ZM') { echo 'selected';}?>>Zambian</option>
                                                                                <option value="ZW" <?php if ($rowd6['Nationality'] == 'ZW') { echo 'selected';}?>>Zimbabwean</option>
                                                                            </select>
                                                                            <div class="invalid-feedback">
                                                                            Select nationality
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 mt-3">
                                                                            <label class="form-label">Country</label>
                                                                            <select name="country" class="form-control input-style" required>
                                                                                <option value="">Choose..</option>
                                                                                <option value="AF" <?php if ($rowd6['Country'] == 'AF') { echo 'selected';}?>>Afghanistan</option>
                                                                                <option value="AL" <?php if ($rowd6['Country'] == 'AL') { echo 'selected';}?>>Albania</option>
                                                                                <option value="DZ" <?php if ($rowd6['Country'] == 'DZ') { echo 'selected';}?>>Algeria</option>
                                                                                <option value="AS" <?php if ($rowd6['Country'] == 'AS') { echo 'selected';}?>>American Samoa</option>
                                                                                <option value="AD" <?php if ($rowd6['Country'] == 'AD') { echo 'selected';}?>>Andorra</option>
                                                                                <option value="AO" <?php if ($rowd6['Country'] == 'AO') { echo 'selected';}?>>Angola</option>
                                                                                <option value="AI" <?php if ($rowd6['Country'] == 'AI') { echo 'selected';}?>>Anguilla</option>
                                                                                <option value="AQ" <?php if ($rowd6['Country'] == 'AQ') { echo 'selected';}?>>Antarctica</option>
                                                                                <option value="AG" <?php if ($rowd6['Country'] == 'AG') { echo 'selected';}?>>Antigua and Barbuda</option>
                                                                                <option value="AR" <?php if ($rowd6['Country'] == 'AR') { echo 'selected';}?>>Argentina</option>
                                                                                <option value="AM" <?php if ($rowd6['Country'] == 'AM') { echo 'selected';}?>>Armenia</option>
                                                                                <option value="AW" <?php if ($rowd6['Country'] == 'AW') { echo 'selected';}?>>Aruba</option>
                                                                                <option value="AU" <?php if ($rowd6['Country'] == 'AU') { echo 'selected';}?>>Australia</option>
                                                                                <option value="AT" <?php if ($rowd6['Country'] == 'AT') { echo 'selected';}?>>Austria</option>
                                                                                <option value="AZ" <?php if ($rowd6['Country'] == 'AZ') { echo 'selected';}?>>Azerbaijan</option>
                                                                                <option value="BS" <?php if ($rowd6['Country'] == 'BS') { echo 'selected';}?>>Bahamas</option>
                                                                                <option value="BH" <?php if ($rowd6['Country'] == 'BH') { echo 'selected';}?>>Bahrain</option>
                                                                                <option value="BD" <?php if ($rowd6['Country'] == 'BD') { echo 'selected';}?>>Bangladesh</option>
                                                                                <option value="BB" <?php if ($rowd6['Country'] == 'BB') { echo 'selected';}?>>Barbados</option>
                                                                                <option value="BY" <?php if ($rowd6['Country'] == 'BE') { echo 'selected';}?>>Belarus</option>
                                                                                <option value="BE" <?php if ($rowd6['Country'] == 'ZW') { echo 'selected';}?>>Belgium</option>
                                                                                <option value="BZ" <?php if ($rowd6['Country'] == 'BZ') { echo 'selected';}?>>Belize</option>
                                                                                <option value="BJ" <?php if ($rowd6['Country'] == 'BJ') { echo 'selected';}?>>Benin</option>
                                                                                <option value="BM" <?php if ($rowd6['Country'] == 'BM') { echo 'selected';}?>>Bermuda</option>
                                                                                <option value="BT" <?php if ($rowd6['Country'] == 'BT') { echo 'selected';}?>>Bhutan</option>
                                                                                <option value="BO" <?php if ($rowd6['Country'] == 'BO') { echo 'selected';}?>>Bolivia</option>
                                                                                <option value="BW" <?php if ($rowd6['Country'] == 'BW') { echo 'selected';}?>>Botswana</option>
                                                                                <option value="BV" <?php if ($rowd6['Country'] == 'BV') { echo 'selected';}?>>Bouvet Island</option>
                                                                                <option value="BR" <?php if ($rowd6['Country'] == 'BR') { echo 'selected';}?>>Brazil</option>
                                                                                <option value="BN" <?php if ($rowd6['Country'] == 'BN') { echo 'selected';}?>>Brunei Darussalam</option>
                                                                                <option value="BG" <?php if ($rowd6['Country'] == 'BG') { echo 'selected';}?>>Bulgaria</option>
                                                                                <option value="BF" <?php if ($rowd6['Country'] == 'BF') { echo 'selected';}?>>Burkina Faso</option>
                                                                                <option value="BI" <?php if ($rowd6['Country'] == 'BI') { echo 'selected';}?>>Burundi</option>
                                                                                <option value="KH" <?php if ($rowd6['Country'] == 'KH') { echo 'selected';}?>>Cambodia</option>
                                                                                <option value="CM" <?php if ($rowd6['Country'] == 'CM') { echo 'selected';}?>>Cameroon</option>
                                                                                <option value="CA" <?php if ($rowd6['Country'] == 'CA') { echo 'selected';}?>>Canada</option>
                                                                                <option value="CV" <?php if ($rowd6['Country'] == 'CV') { echo 'selected';}?>>Cape Verde</option>
                                                                                <option value="KY" <?php if ($rowd6['Country'] == 'KY') { echo 'selected';}?>>Cayman Islands</option>
                                                                                <option value="CF" <?php if ($rowd6['Country'] == 'CF') { echo 'selected';}?>>Central African Republic</option>
                                                                                <option value="TD" <?php if ($rowd6['Country'] == 'TD') { echo 'selected';}?>>Chad</option>
                                                                                <option value="CL" <?php if ($rowd6['Country'] == 'CL') { echo 'selected';}?>>Chile</option>
                                                                                <option value="CN" <?php if ($rowd6['Country'] == 'CN') { echo 'selected';}?>>China</option>
                                                                                <option value="CX" <?php if ($rowd6['Country'] == 'CX') { echo 'selected';}?>>Christmas Island</option>
                                                                                <option value="CC" <?php if ($rowd6['Country'] == 'CC') { echo 'selected';}?>>Cocos (Keeling) Islands</option>
                                                                                <option value="CO" <?php if ($rowd6['Country'] == 'CO') { echo 'selected';}?>>Colombia</option>
                                                                                <option value="KM" <?php if ($rowd6['Country'] == 'KM') { echo 'selected';}?>>Comoros</option>
                                                                                <option value="CG" <?php if ($rowd6['Country'] == 'CG') { echo 'selected';}?>>Congo</option>
                                                                                <option value="CK" <?php if ($rowd6['Country'] == 'CK') { echo 'selected';}?>>Cook Islands</option>
                                                                                <option value="CR" <?php if ($rowd6['Country'] == 'CR') { echo 'selected';}?>>Costa Rica</option>
                                                                                <option value="CI" <?php if ($rowd6['Country'] == 'CI') { echo 'selected';}?>>Cote d'Ivoire</option>
                                                                                <option value="HR" <?php if ($rowd6['Country'] == 'HR') { echo 'selected';}?>>Croatia (Hrvatska)</option>
                                                                                <option value="CU" <?php if ($rowd6['Country'] == 'CU') { echo 'selected';}?>>Cuba</option>
                                                                                <option value="CY" <?php if ($rowd6['Country'] == 'CY') { echo 'selected';}?>>Cyprus</option>
                                                                                <option value="CZ" <?php if ($rowd6['Country'] == 'CZ') { echo 'selected';}?>>Czech Republic</option>
                                                                                <option value="DK" <?php if ($rowd6['Country'] == 'DK') { echo 'selected';}?>>Denmark</option>
                                                                                <option value="DJ" <?php if ($rowd6['Country'] == 'DJ') { echo 'selected';}?>>Djibouti</option>
                                                                                <option value="DM" <?php if ($rowd6['Country'] == 'DM') { echo 'selected';}?>>Dominica</option>
                                                                                <option value="DO" <?php if ($rowd6['Country'] == 'DO') { echo 'selected';}?>>Dominican Republic</option>
                                                                                <option value="TP" <?php if ($rowd6['Country'] == 'TP') { echo 'selected';}?>>East Timor</option>
                                                                                <option value="EC" <?php if ($rowd6['Country'] == 'EC') { echo 'selected';}?>>Ecuador</option>
                                                                                <option value="EG" <?php if ($rowd6['Country'] == 'EG') { echo 'selected';}?>>Egypt</option>
                                                                                <option value="SV" <?php if ($rowd6['Country'] == 'SV') { echo 'selected';}?>>El Salvador</option>
                                                                                <option value="GQ" <?php if ($rowd6['Country'] == 'GQ') { echo 'selected';}?>>Equatorial Guinea</option>
                                                                                <option value="ER" <?php if ($rowd6['Country'] == 'ER') { echo 'selected';}?>>Eritrea</option>
                                                                                <option value="EE" <?php if ($rowd6['Country'] == 'EE') { echo 'selected';}?>>Estonia</option>
                                                                                <option value="ET" <?php if ($rowd6['Country'] == 'ET') { echo 'selected';}?>>Ethiopia</option>
                                                                                <option value="FK" <?php if ($rowd6['Country'] == 'FK') { echo 'selected';}?>>Falkland Islands (Malvinas)</option>
                                                                                <option value="FO" <?php if ($rowd6['Country'] == 'FO') { echo 'selected';}?>>Faroe Islands</option>
                                                                                <option value="FJ" <?php if ($rowd6['Country'] == 'FJ') { echo 'selected';}?>>Fiji</option>
                                                                                <option value="FI" <?php if ($rowd6['Country'] == 'FI') { echo 'selected';}?>>Finland</option>
                                                                                <option value="FR" <?php if ($rowd6['Country'] == 'FR') { echo 'selected';}?>>France</option>
                                                                                <option value="FX" <?php if ($rowd6['Country'] == 'FX') { echo 'selected';}?>>France, Metropolitan</option>
                                                                                <option value="GF" <?php if ($rowd6['Country'] == 'GF') { echo 'selected';}?>>French Guiana</option>
                                                                                <option value="PF" <?php if ($rowd6['Country'] == 'PF') { echo 'selected';}?>>French Polynesia</option>
                                                                                <option value="TF" <?php if ($rowd6['Country'] == 'TF') { echo 'selected';}?>>French Southern Territories</option>
                                                                                <option value="GA" <?php if ($rowd6['Country'] == 'GA') { echo 'selected';}?>>Gabon</option>
                                                                                <option value="GM" <?php if ($rowd6['Country'] == 'GM') { echo 'selected';}?>>Gambia</option>
                                                                                <option value="GE" <?php if ($rowd6['Country'] == 'GE') { echo 'selected';}?>>Georgia</option>
                                                                                <option value="DE" <?php if ($rowd6['Country'] == 'DE') { echo 'selected';}?>>Germany</option>
                                                                                <option value="GH" <?php if ($rowd6['Country'] == 'GH') { echo 'selected';}?>>Ghana</option>
                                                                                <option value="GI" <?php if ($rowd6['Country'] == 'GI') { echo 'selected';}?>>Gibraltar</option>
                                                                                <option value="GR" <?php if ($rowd6['Country'] == 'GR') { echo 'selected';}?>>Greece</option>
                                                                                <option value="GL" <?php if ($rowd6['Country'] == 'GL') { echo 'selected';}?>>Greenland</option>
                                                                                <option value="GD" <?php if ($rowd6['Country'] == 'GD') { echo 'selected';}?>>Grenada</option>
                                                                                <option value="GP" <?php if ($rowd6['Country'] == 'GP') { echo 'selected';}?>>Guadeloupe</option>
                                                                                <option value="GU" <?php if ($rowd6['Country'] == 'GU') { echo 'selected';}?>>Guam</option>
                                                                                <option value="GT" <?php if ($rowd6['Country'] == 'GT') { echo 'selected';}?>>Guatemala</option>
                                                                                <option value="GN" <?php if ($rowd6['Country'] == 'GN') { echo 'selected';}?>>Guinea</option>
                                                                                <option value="GW" <?php if ($rowd6['Country'] == 'GW') { echo 'selected';}?>>Guinea-Bissau</option>
                                                                                <option value="GY" <?php if ($rowd6['Country'] == 'GY') { echo 'selected';}?>>Guyana</option>
                                                                                <option value="HT" <?php if ($rowd6['Country'] == 'HT') { echo 'selected';}?>>Haiti</option>
                                                                                <option value="HN" <?php if ($rowd6['Country'] == 'HN') { echo 'selected';}?>>Honduras</option>
                                                                                <option value="HK" <?php if ($rowd6['Country'] == 'HK') { echo 'selected';}?>>Hong Kong</option>
                                                                                <option value="HU" <?php if ($rowd6['Country'] == 'HU') { echo 'selected';}?>>Hungary</option>
                                                                                <option value="IS" <?php if ($rowd6['Country'] == 'IS') { echo 'selected';}?>>Iceland</option>
                                                                                <option value="IN" <?php if ($rowd6['Country'] == 'IN') { echo 'selected';}?>>India</option>
                                                                                <option value="ID" <?php if ($rowd6['Country'] == 'ID') { echo 'selected';}?>>Indonesia</option>
                                                                                <option value="IR" <?php if ($rowd6['Country'] == 'IR') { echo 'selected';}?>>Iran (Islamic Republic of)</option>
                                                                                <option value="IQ" <?php if ($rowd6['Country'] == 'IQ') { echo 'selected';}?>>Iraq</option>
                                                                                <option value="IE" <?php if ($rowd6['Country'] == 'IE') { echo 'selected';}?>>Ireland</option>
                                                                                <option value="IL" <?php if ($rowd6['Country'] == 'IL') { echo 'selected';}?>>Israel</option>
                                                                                <option value="IT" <?php if ($rowd6['Country'] == 'IT') { echo 'selected';}?>>Italy</option>
                                                                                <option value="JM" <?php if ($rowd6['Country'] == 'JM') { echo 'selected';}?>>Jamaica</option>
                                                                                <option value="JP" <?php if ($rowd6['Country'] == 'JP') { echo 'selected';}?>>Japan</option>
                                                                                <option value="JO" <?php if ($rowd6['Country'] == 'JO') { echo 'selected';}?>>Jordan</option>
                                                                                <option value="KZ" <?php if ($rowd6['Country'] == 'KZ') { echo 'selected';}?>>Kazakhstan</option>
                                                                                <option value="KE" <?php if ($rowd6['Country'] == 'KE') { echo 'selected';}?>>Kenya</option>
                                                                                <option value="KI" <?php if ($rowd6['Country'] == 'KI') { echo 'selected';}?>>Kiribati</option>
                                                                                <option value="KR" <?php if ($rowd6['Country'] == 'KR') { echo 'selected';}?>>Korea, Republic of</option>
                                                                                <option value="KW" <?php if ($rowd6['Country'] == 'KW') { echo 'selected';}?>>Kuwait</option>
                                                                                <option value="KG" <?php if ($rowd6['Country'] == 'KG') { echo 'selected';}?>>Kyrgyzstan</option>
                                                                                <option value="LV" <?php if ($rowd6['Country'] == 'LV') { echo 'selected';}?>>Latvia</option>
                                                                                <option value="LB" <?php if ($rowd6['Country'] == 'LB') { echo 'selected';}?>>Lebanon</option>
                                                                                <option value="LS" <?php if ($rowd6['Country'] == 'LS') { echo 'selected';}?>>Lesotho</option>
                                                                                <option value="LR" <?php if ($rowd6['Country'] == 'LR') { echo 'selected';}?>>Liberia</option>
                                                                                <option value="LY" <?php if ($rowd6['Country'] == 'LY') { echo 'selected';}?>>Libyan Arab Jamahiriya</option>
                                                                                <option value="LI" <?php if ($rowd6['Country'] == 'LI') { echo 'selected';}?>>Liechtenstein</option>
                                                                                <option value="LT" <?php if ($rowd6['Country'] == 'LT') { echo 'selected';}?>>Lithuania</option>
                                                                                <option value="LU" <?php if ($rowd6['Country'] == 'LU') { echo 'selected';}?>>Luxembourg</option>
                                                                                <option value="MO" <?php if ($rowd6['Country'] == 'MO') { echo 'selected';}?>>Macau</option>
                                                                                <option value="MG" <?php if ($rowd6['Country'] == 'MG') { echo 'selected';}?>>Madagascar</option>
                                                                                <option value="MW" <?php if ($rowd6['Country'] == 'MW') { echo 'selected';}?>>Malawi</option>
                                                                                <option value="MY" <?php if ($rowd6['Country'] == 'MY') { echo 'selected';}?>>Malaysia</option>
                                                                                <option value="MV" <?php if ($rowd6['Country'] == 'MV') { echo 'selected';}?>>Maldives</option>
                                                                                <option value="ML" <?php if ($rowd6['Country'] == 'ML') { echo 'selected';}?>>Mali</option>
                                                                                <option value="MT" <?php if ($rowd6['Country'] == 'ML') { echo 'selected';}?>>Malta</option>
                                                                                <option value="MH" <?php if ($rowd6['Country'] == 'MT') { echo 'selected';}?>>Marshall Islands</option>
                                                                                <option value="MQ" <?php if ($rowd6['Country'] == 'MQ') { echo 'selected';}?>>Martinique</option>
                                                                                <option value="MR" <?php if ($rowd6['Country'] == 'MR') { echo 'selected';}?>>Mauritania</option>
                                                                                <option value="MU" <?php if ($rowd6['Country'] == 'MU') { echo 'selected';}?>>Mauritius</option>
                                                                                <option value="YT" <?php if ($rowd6['Country'] == 'YT') { echo 'selected';}?>>Mayotte</option>
                                                                                <option value="MX" <?php if ($rowd6['Country'] == 'MX') { echo 'selected';}?>>Mexico</option>
                                                                                <option value="FM" <?php if ($rowd6['Country'] == 'FM') { echo 'selected';}?>>Micronesia, Federated States of</option>
                                                                                <option value="MD" <?php if ($rowd6['Country'] == 'MD') { echo 'selected';}?>>Moldova, Republic of</option>
                                                                                <option value="MC" <?php if ($rowd6['Country'] == 'MC') { echo 'selected';}?>>Monaco</option>
                                                                                <option value="MN" <?php if ($rowd6['Country'] == 'MN') { echo 'selected';}?>>Mongolia</option>
                                                                                <option value="MS" <?php if ($rowd6['Country'] == 'MS') { echo 'selected';}?>>Montserrat</option>
                                                                                <option value="MA" <?php if ($rowd6['Country'] == 'MA') { echo 'selected';}?>>Morocco</option>
                                                                                <option value="MZ" <?php if ($rowd6['Country'] == 'MZ') { echo 'selected';}?>>Mozambique</option>
                                                                                <option value="MM" <?php if ($rowd6['Country'] == 'MM') { echo 'selected';}?>>Myanmar</option>
                                                                                <option value="NA" <?php if ($rowd6['Country'] == 'NA') { echo 'selected';}?>>Namibia</option>
                                                                                <option value="NR" <?php if ($rowd6['Country'] == 'NR') { echo 'selected';}?>>Nauru</option>
                                                                                <option value="NP" <?php if ($rowd6['Country'] == 'NP') { echo 'selected';}?>>Nepal</option>
                                                                                <option value="NL" <?php if ($rowd6['Country'] == 'NL') { echo 'selected';}?>>Netherlands</option>
                                                                                <option value="AN" <?php if ($rowd6['Country'] == 'AN') { echo 'selected';}?>>Netherlands Antilles</option>
                                                                                <option value="NC" <?php if ($rowd6['Country'] == 'NC') { echo 'selected';}?>>New Caledonia</option>
                                                                                <option value="NZ" <?php if ($rowd6['Country'] == 'NZ') { echo 'selected';}?>>New Zealand</option>
                                                                                <option value="NI" <?php if ($rowd6['Country'] == 'NI') { echo 'selected';}?>>Nicaragua</option>
                                                                                <option value="NE" <?php if ($rowd6['Country'] == 'NE') { echo 'selected';}?>>Niger</option>
                                                                                <option value="NG" <?php if ($rowd6['Country'] == 'NG') { echo 'selected';}?>>Nigeria</option>
                                                                                <option value="NU" <?php if ($rowd6['Country'] == 'NU') { echo 'selected';}?>>Niue</option>
                                                                                <option value="NF" <?php if ($rowd6['Country'] == 'NF') { echo 'selected';}?>>Norfolk Island</option>
                                                                                <option value="MP" <?php if ($rowd6['Country'] == 'MP') { echo 'selected';}?>>Northern Mariana Islands</option>
                                                                                <option value="NO" <?php if ($rowd6['Country'] == 'NO') { echo 'selected';}?>>Norway</option>
                                                                                <option value="OM" <?php if ($rowd6['Country'] == 'OM') { echo 'selected';}?>>Oman</option>
                                                                                <option value="PK" <?php if ($rowd6['Country'] == 'PK') { echo 'selected';}?>>Pakistan</option>
                                                                                <option value="PW" <?php if ($rowd6['Country'] == 'PW') { echo 'selected';}?>>Palau</option>
                                                                                <option value="PA" <?php if ($rowd6['Country'] == 'PA') { echo 'selected';}?>>Panama</option>
                                                                                <option value="PG" <?php if ($rowd6['Country'] == 'PG') { echo 'selected';}?>>Papua New Guinea</option>
                                                                                <option value="PY" <?php if ($rowd6['Country'] == 'PY') { echo 'selected';}?>>Paraguay</option>
                                                                                <option value="PE" <?php if ($rowd6['Country'] == 'PE') { echo 'selected';}?>>Peru</option>
                                                                                <option value="PH" <?php if ($rowd6['Country'] == 'PH') { echo 'selected';}?>>Philippines</option>
                                                                                <option value="PN" <?php if ($rowd6['Country'] == 'PN') { echo 'selected';}?>>Pitcairn</option>
                                                                                <option value="PL" <?php if ($rowd6['Country'] == 'PL') { echo 'selected';}?>>Poland</option>
                                                                                <option value="PT" <?php if ($rowd6['Country'] == 'PT') { echo 'selected';}?>>Portugal</option>
                                                                                <option value="PR" <?php if ($rowd6['Country'] == 'PR') { echo 'selected';}?>>Puerto Rico</option>
                                                                                <option value="QA" <?php if ($rowd6['Country'] == 'QA') { echo 'selected';}?>>Qatar</option>
                                                                                <option value="RE" <?php if ($rowd6['Country'] == 'RE') { echo 'selected';}?>>Reunion</option>
                                                                                <option value="RO" <?php if ($rowd6['Country'] == 'RO') { echo 'selected';}?>>Romania</option>
                                                                                <option value="RU" <?php if ($rowd6['Country'] == 'RU') { echo 'selected';}?>>Russian Federation</option>
                                                                                <option value="RW" <?php if ($rowd6['Country'] == 'RW') { echo 'selected';}?>>Rwanda</option>
                                                                                <option value="KN" <?php if ($rowd6['Country'] == 'KN') { echo 'selected';}?>>Saint Kitts and Nevis</option> 
                                                                                <option value="LC" <?php if ($rowd6['Country'] == 'LC') { echo 'selected';}?>>Saint LUCIA</option>
                                                                                <option value="VC" <?php if ($rowd6['Country'] == 'VC') { echo 'selected';}?>>Saint Vincent and the Grenadines</option>
                                                                                <option value="WS" <?php if ($rowd6['Country'] == 'WS') { echo 'selected';}?>>Samoa</option>
                                                                                <option value="SM" <?php if ($rowd6['Country'] == 'SM') { echo 'selected';}?>>San Marino</option>
                                                                                <option value="ST" <?php if ($rowd6['Country'] == 'ST') { echo 'selected';}?>>Sao Tome and Principe</option> 
                                                                                <option value="SA" <?php if ($rowd6['Country'] == 'SA') { echo 'selected';}?>>Saudi Arabia</option>
                                                                                <option value="SN" <?php if ($rowd6['Country'] == 'SN') { echo 'selected';}?>>Senegal</option>
                                                                                <option value="SC" <?php if ($rowd6['Country'] == 'SC') { echo 'selected';}?>>Seychelles</option>
                                                                                <option value="SL" <?php if ($rowd6['Country'] == 'SL') { echo 'selected';}?>>Sierra Leone</option>
                                                                                <option value="SG" <?php if ($rowd6['Country'] == 'SG') { echo 'selected';}?>>Singapore</option>
                                                                                <option value="SK" <?php if ($rowd6['Country'] == 'SK') { echo 'selected';}?>>Slovakia (Slovak Republic)</option>
                                                                                <option value="SI" <?php if ($rowd6['Country'] == 'SI') { echo 'selected';}?>>Slovenia</option>
                                                                                <option value="SB" <?php if ($rowd6['Country'] == 'SB') { echo 'selected';}?>>Solomon Islands</option>
                                                                                <option value="SO" <?php if ($rowd6['Country'] == 'SO') { echo 'selected';}?>>Somalia</option>
                                                                                <option value="ZA" <?php if ($rowd6['Country'] == 'ZA') { echo 'selected';}?>>South Africa</option>
                                                                                <option value="ES" <?php if ($rowd6['Country'] == 'ES') { echo 'selected';}?>>Spain</option>
                                                                                <option value="LK" <?php if ($rowd6['Country'] == 'LK') { echo 'selected';}?>>Sri Lanka</option>
                                                                                <option value="SH" <?php if ($rowd6['Country'] == 'SH') { echo 'selected';}?>>St. Helena</option>
                                                                                <option value="PM" <?php if ($rowd6['Country'] == 'PM') { echo 'selected';}?>>St. Pierre and Miquelon</option>
                                                                                <option value="SD" <?php if ($rowd6['Country'] == 'SD') { echo 'selected';}?>>Sudan</option>
                                                                                <option value="SR" <?php if ($rowd6['Country'] == 'SR') { echo 'selected';}?>>Suriname</option>
                                                                                <option value="SJ" <?php if ($rowd6['Country'] == 'SJ') { echo 'selected';}?>>Svalbard and Jan Mayen Islands</option>
                                                                                <option value="SZ" <?php if ($rowd6['Country'] == 'SZ') { echo 'selected';}?>>Swaziland</option>
                                                                                <option value="SE" <?php if ($rowd6['Country'] == 'SE') { echo 'selected';}?>>Sweden</option>
                                                                                <option value="CH" <?php if ($rowd6['Country'] == 'CH') { echo 'selected';}?>>Switzerland</option>
                                                                                <option value="SY" <?php if ($rowd6['Country'] == 'SY') { echo 'selected';}?>>Syrian Arab Republic</option>
                                                                                <option value="TW" <?php if ($rowd6['Country'] == 'TW') { echo 'selected';}?>>Taiwan, Province of China</option>
                                                                                <option value="TJ" <?php if ($rowd6['Country'] == 'TJ') { echo 'selected';}?>>Tajikistan</option>
                                                                                <option value="TZ" <?php if ($rowd6['Country'] == 'TZ') { echo 'selected';}?>>Tanzania, United Republic of</option>
                                                                                <option value="TH" <?php if ($rowd6['Country'] == 'TH') { echo 'selected';}?>>Thailand</option>
                                                                                <option value="TG" <?php if ($rowd6['Country'] == 'TG') { echo 'selected';}?>>Togo</option>
                                                                                <option value="TK" <?php if ($rowd6['Country'] == 'TK') { echo 'selected';}?>>Tokelau</option>
                                                                                <option value="TO" <?php if ($rowd6['Country'] == 'TO') { echo 'selected';}?>>Tonga</option>
                                                                                <option value="TT" <?php if ($rowd6['Country'] == 'TT') { echo 'selected';}?>>Trinidad and Tobago</option>
                                                                                <option value="TN" <?php if ($rowd6['Country'] == 'TN') { echo 'selected';}?>>Tunisia</option>
                                                                                <option value="TR" <?php if ($rowd6['Country'] == 'TR') { echo 'selected';}?>>Turkey</option>
                                                                                <option value="TM" <?php if ($rowd6['Country'] == 'TM') { echo 'selected';}?>>Turkmenistan</option>
                                                                                <option value="TC" <?php if ($rowd6['Country'] == 'TC') { echo 'selected';}?>>Turks and Caicos Islands</option>
                                                                                <option value="TV" <?php if ($rowd6['Country'] == 'TV') { echo 'selected';}?>>Tuvalu</option>
                                                                                <option value="UG" <?php if ($rowd6['Country'] == 'UG') { echo 'selected';}?>>Uganda</option>
                                                                                <option value="UA" <?php if ($rowd6['Country'] == 'UA') { echo 'selected';}?>>Ukraine</option>
                                                                                <option value="AE" <?php if ($rowd6['Country'] == 'AE') { echo 'selected';}?>>United Arab Emirates</option>
                                                                                <option value="GB" <?php if ($rowd6['Country'] == 'GB') { echo 'selected';}?>>United Kingdom</option>
                                                                                <option value="US" <?php if ($rowd6['Country'] == 'US') { echo 'selected';}?>>United States</option>
                                                                                <option value="UM" <?php if ($rowd6['Country'] == 'UM') { echo 'selected';}?>>United States Minor Outlying Islands</option>
                                                                                <option value="UY" <?php if ($rowd6['Country'] == 'UY') { echo 'selected';}?>>Uruguay</option>
                                                                                <option value="UZ" <?php if ($rowd6['Country'] == 'UZ') { echo 'selected';}?>>Uzbekistan</option>
                                                                                <option value="VU" <?php if ($rowd6['Country'] == 'VU') { echo 'selected';}?>>Vanuatu</option>
                                                                                <option value="VE" <?php if ($rowd6['Country'] == 'VE') { echo 'selected';}?>>Venezuela</option>
                                                                                <option value="VN" <?php if ($rowd6['Country'] == 'VN') { echo 'selected';}?>>Viet Nam</option>
                                                                                <option value="VG" <?php if ($rowd6['Country'] == 'VG') { echo 'selected';}?>>Virgin Islands (British)</option>
                                                                                <option value="VI" <?php if ($rowd6['Country'] == 'VI') { echo 'selected';}?>>Virgin Islands (U.S.)</option>
                                                                                <option value="WF" <?php if ($rowd6['Country'] == 'WF') { echo 'selected';}?>>Wallis and Futuna Islands</option>
                                                                                <option value="EH" <?php if ($rowd6['Country'] == 'EH') { echo 'selected';}?>>Western Sahara</option>
                                                                                <option value="YE" <?php if ($rowd6['Country'] == 'YE') { echo 'selected';}?>>Yemen</option>
                                                                                <option value="YU" <?php if ($rowd6['Country'] == 'YU') { echo 'selected';}?>>Yugoslavia</option>
                                                                                <option value="ZM" <?php if ($rowd6['Country'] == 'ZM') { echo 'selected';}?>>Zambia</option>
                                                                                <option value="ZW" <?php if ($rowd6['Country'] == 'ZW') { echo 'selected';}?>>Zimbabwe</option>
                                                                            </select>
                                                                            <div class="invalid-feedback">
                                                                            Please select country
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4 mt-3">
                                                                            <label class="form-label">Company Name</label>
                                                                            <input type="text" class="form-control input-style" name="company" required value="<?php echo $rowd6['CompanyName'];?>">
                                                                            <div class="invalid-feedback">
                                                                            Enter company name 
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4 mt-3">
                                                                            <label class="form-label">Designation</label>
                                                                            <input type="text" class="form-control input-style" name="designation" required value="<?php echo $rowd6['Designation'];?>">
                                                                            <div class="invalid-feedback">
                                                                            Enter designation 
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4 mt-3">
                                                                            <label class="form-label">Contact Number</label>
                                                                            <input type="text" class="form-control input-style" required name="phone" pattern="[0-9]{1,10}" maxlength="10" value="<?php echo $rowd6['PhoneNo'];?>">
                                                                            <div class="invalid-feedback">
                                                                            Enter valid contact number
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4 mt-3">
                                                                            <label class="form-label">Amount</label>
                                                                            <input type="number" class="form-control input-style" required name="amount" value="<?php echo $rowd6['TotalAmount'];?>">
                                                                            <div class="invalid-feedback">
                                                                            Enter total amount
                                                                            </div>
                                                                        </div>

                                                                        <input type="hidden" name="badge_id" value="<?php echo $rowd6['BD_Id'];?>">

                                                                        <div class="col-md-4 mt-3">
                                                                            <label class="form-label">Ticket</label>
                                                                            <select name="ticketchoose" class="form-control input-style" required>
                                                                                <?php
                                                                                    $resTicket = mysqli_query($conn, "SELECT * FROM ticket_master WHERE Status = 1");
                                                                                    if(mysqli_num_rows($resTicket) > 0) {

                                                                                        while($rowTicket =  mysqli_fetch_assoc($resTicket)){

                                                                                            if($rowTicket['TT_Id'] == $rowd6['TicketId']) {

                                                                                                echo "<option value='$rowTicket[TT_Id]' selected>$rowTicket[Ticket]</option>";
                                                                                            } else {

                                                                                                echo "<option value='$rowTicket[TT_Id]'>$rowTicket[Ticket]</option>";
                                                                                            }
                                                                                        }
                                                                                    } else {
                                                                                        echo "<option value=''>Choose..</option>";
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                            <div class="invalid-feedback">
                                                                            Please select country
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4 mt-3">
                                                                            <label for="validationCustom02" class="form-label">Status</label>
                                                                            <select class="form-control input-style" id="validationCustom04" required name="status" title="Please choose status">
                                                                                <option value="">Select</option>
                                                                                <option value="1" <?php if($rowd6['BadgeStatus']){echo 'selected';}?>>Active</option>
                                                                                <option value="0" <?php if(!$rowd6['BadgeStatus']){echo 'selected';}?>>In-Active</option>
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
        <a href='print-badge-all.php?eid=<?php echo $_GET['eid']; ?>&ecode=<?php echo $_GET['ecode']; ?>' class="btn btn-danger" style="position:fixed;bottom:40px;right:40px;border-radius:50px;text-align:center;"><i class="fa fa-print"></i></a>
    </div>
</div>


<?php
    require_once './pages/footer.php';
?>