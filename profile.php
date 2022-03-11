<?php 
    session_start();

    require_once './config/connection.php';
    require_once './api/maestro_util.php';
    require_once './pages/link.php';
    require_once './pages/header.php';

    if(!isset($_SESSION['is_customer_login'])) {

        echo "<script>location.href='login.php';</script>";
    } else {
        if(!$_SESSION['is_customer_login']){

            echo "<script>location.href='login.php';</script>";
        }
    }


    $resCustomer = mysqli_query($conn, "SELECT * FROM customer_master WHERE CM_Id = $_SESSION[cm_id]");

    if (mysqli_num_rows($resCustomer) > 0) {

        $resCustomer = mysqli_fetch_assoc($resCustomer);
    } else {

        echo "<script>alert('Oops, Unable to process..');location.href='index.php';</script>";
    }

    if (isset($_POST['update'])) {
        $api = new MaestroUtil();
        $resreg = mysqli_query($conn, "SELECT CM_Id FROM customer_master WHERE NOT CM_Id = '$_SESSION[cm_id]' AND (CustomerEmail = '$_POST[email]' OR CustomerPhone = '$_POST[phone]')");
        if (mysqli_num_rows($resreg) > 0) {

            echo "<script>alert('Oops, Email ID or Phone Number already in use..');</script>";
        } else {

            $api->editCustomer(
                $_POST['saluation'],
                $_POST['first_name'],
                $_POST['last_name'],
                $_POST['email'],
                $_POST['phone'],
                $_POST['nationality'],
                $_POST['dateofbirth'],
                "",
                $_POST['international_code'],
                $_POST['address_line1'],
                $_POST['address_line2'],
                $_POST['city'],
                $_POST['state'],
                $resCustomer['CustomerCountry'],
                $resCustomer['CustomerId']
            );

            if ($api) {

                if (mysqli_query($conn, "UPDATE customer_master SET Saluation = '$_POST[saluation]', FirstName = '$_POST[first_name]', LastName = '$_POST[last_name]', CustomerEmail  ='$_POST[email]', CustomerPhone = '$_POST[phone]', Nationality = '$_POST[nationality]', DateOfBirth = '$_POST[dateofbirth]', InternationalCode = '$_POST[international_code]', AddressLine1 = '$_POST[address_line1]', AddressLine2 = '$_POST[address_line2]', CustomerCity = '$_POST[city]', CustomerState = '$_POST[state]' WHERE CM_Id = '$_SESSION[cm_id]' ")){
                    
                    echo "<script>alert('Yay, Profile updated successfully..');location.href='profile.php';</script>";
                } else {
                    
                    echo "<script>alert('Oops, Unable to update your profile..');location.href='profile.php';</script>";
                }
            }
        }
    }

?>

<section class="w3l-forms-23" style="background: url(assets/images/banner-3.jpg) no-repeat center fixed;">
    <div id="forms23-block">
        <div class="wrapper">
            <div class="d-grid forms23-2grids">
                <div class="form23">
                    <h6>Update your profile</h6>
                    <small class="text-danger">* indicates a required field.</small>
                    <form action="" method="POST" class="row g-3 needs-validation" novalidate>
                        <div class="col-md-4">
                            <label for="validationCustom01" class="form-label text-light">Saluation</label>
                            <select class="form-control input-style" id="validationCustom01" name="saluation" required>
                                <option value="">Select</option>
                                <option value="Mr" <?php if ($resCustomer['Saluation'] == 'Mr') { echo 'selected';}?>>Mr</option>
                                <option value="Miss" <?php if ($resCustomer['Saluation'] == 'Miss') { echo 'selected';}?>>Miss</option>
                            </select>
                            <div class="invalid-feedback">
                            Choose saluation
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label  class="form-label text-light">First Name</label>
                            <input type="text" class="form-control input-style" value="<?php echo $resCustomer['FirstName'];?>" name="first_name" pattern="[A-Za-z]{1,49}" maxlength="49">
                            <div class="invalid-feedback">
                                Enter valid first name
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustom01" class="form-label text-light">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-style" value="<?php echo $resCustomer['LastName'];?>" required name="last_name" pattern="[A-Za-z]{1,49}" maxlength="49">
                            <div class="invalid-feedback">
                                Enter valid last name
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label  class="form-label text-light">Email ID <span class="text-danger">*</span></label>
                            <input type="email" class="form-control input-style" value="<?php echo $resCustomer['CustomerEmail'];?>" required name="email" maxlength="99">
                            <div class="invalid-feedback">
                            Enter valid email id
                            </div>
                        </div>
                        
                        <div class="col-md-4 mt-3">
                            <label  class="form-label text-light">International Code</label>
                            <input type="text" class="form-control input-style" value="<?php echo $resCustomer['InternationalCode'];?>" name="international_code" maxlength="10">
                            <div class="invalid-feedback">
                            Please enter valid international code 
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label  class="form-label text-light">Phone (max 10 digit)<span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-style" value="<?php echo $resCustomer['CustomerPhone'];?>" required name="phone" pattern="[0-9]{1,10}" maxlength="10">
                            <div class="invalid-feedback">
                            Enter valid phone
                            </div>
                        </div>
                                
                        <div class="col-md-4 mt-3">
                            <label  class="form-label text-light">Nationality <span class="text-danger">*</span></label>
                            <select name="nationality" class="form-control input-style" required>
                                <option value="">Choose..</option>
                                <option value="AF" <?php if ($resCustomer['Nationality'] == 'AF') { echo 'selected';}?>>Afghan</option>
                                <option value="AL" <?php if ($resCustomer['Nationality'] == 'AL') { echo 'selected';}?>>Albanian</option>
                                <option value="DZ" <?php if ($resCustomer['Nationality'] == 'DZ') { echo 'selected';}?>>Algerian</option>
                                <option value="AS" <?php if ($resCustomer['Nationality'] == 'AS') { echo 'selected';}?>>American</option>
                                <option value="AO" <?php if ($resCustomer['Nationality'] == 'AO') { echo 'selected';}?>>Angolan</option>
                                <option value="AI" <?php if ($resCustomer['Nationality'] == 'AI') { echo 'selected';}?>>Anguilla</option>
                                <option value="AQ" <?php if ($resCustomer['Nationality'] == 'AQ') { echo 'selected';}?>>Antarctica</option>
                                <option value="AG" <?php if ($resCustomer['Nationality'] == 'AG') { echo 'selected';}?>>Antiguans</option>
                                <option value="AD" <?php if ($resCustomer['Nationality'] == 'AD') { echo 'selected';}?>>Andorran</option>
                                <option value="AR" <?php if ($resCustomer['Nationality'] == 'AR') { echo 'selected';}?>>Argentinean</option>
                                <option value="AM" <?php if ($resCustomer['Nationality'] == 'AM') { echo 'selected';}?>>Armenian</option>
                                <option value="AW" <?php if ($resCustomer['Nationality'] == 'AW') { echo 'selected';}?>>Aruba</option>
                                <option value="AU" <?php if ($resCustomer['Nationality'] == 'AU') { echo 'selected';}?>>Australian</option>
                                <option value="AT" <?php if ($resCustomer['Nationality'] == 'AT') { echo 'selected';}?>>Austrian</option>
                                <option value="AZ" <?php if ($resCustomer['Nationality'] == 'AZ') { echo 'selected';}?>>Azerbaijani</option>
                                <option value="BS" <?php if ($resCustomer['Nationality'] == 'BS') { echo 'selected';}?>>Bahamian</option>
                                <option value="BH" <?php if ($resCustomer['Nationality'] == 'BH') { echo 'selected';}?>>Bahraini</option>
                                <option value="BD" <?php if ($resCustomer['Nationality'] == 'BD') { echo 'selected';}?>>Bangladeshi</option>
                                <option value="BB" <?php if ($resCustomer['Nationality'] == 'BB') { echo 'selected';}?>>Barbadian</option>
                                <option value="BY" <?php if ($resCustomer['Nationality'] == 'BY') { echo 'selected';}?>>Belarusian</option>
                                <option value="BE" <?php if ($resCustomer['Nationality'] == 'BE') { echo 'selected';}?>>Belgian</option>
                                <option value="BZ" <?php if ($resCustomer['Nationality'] == 'BZ') { echo 'selected';}?>>Belizean</option>
                                <option value="BJ" <?php if ($resCustomer['Nationality'] == 'BJ') { echo 'selected';}?>>Beninese</option>
                                <option value="BM" <?php if ($resCustomer['Nationality'] == 'BM') { echo 'selected';}?>>Bermuda</option>
                                <option value="BT" <?php if ($resCustomer['Nationality'] == 'BT') { echo 'selected';}?>>Bhutanese</option>
                                <option value="BO" <?php if ($resCustomer['Nationality'] == 'BO') { echo 'selected';}?>>Bolivian</option>
                                <option value="BA" <?php if ($resCustomer['Nationality'] == 'BA') { echo 'selected';}?>>Bosnian</option>
                                <option value="BW" <?php if ($resCustomer['Nationality'] == 'BW') { echo 'selected';}?>>Botswana</option>
                                <option value="BV" <?php if ($resCustomer['Nationality'] == 'BV') { echo 'selected';}?>>Bouvet Island</option>
                                <option value="BR" <?php if ($resCustomer['Nationality'] == 'BR') { echo 'selected';}?>>Brazilian</option>
                                <option value="IO" <?php if ($resCustomer['Nationality'] == 'IO') { echo 'selected';}?>>British</option>
                                <option value="BN" <?php if ($resCustomer['Nationality'] == 'BN') { echo 'selected';}?>>Bruneian</option>
                                <option value="BG" <?php if ($resCustomer['Nationality'] == 'BG') { echo 'selected';}?>>Bulgarian</option>
                                <option value="BF" <?php if ($resCustomer['Nationality'] == 'BF') { echo 'selected';}?>>Burkinabe</option>
                                <option value="BI" <?php if ($resCustomer['Nationality'] == 'BI') { echo 'selected';}?>>Burundian</option>
                                <option value="KH" <?php if ($resCustomer['Nationality'] == 'KH') { echo 'selected';}?>>Cambodian</option>
                                <option value="CM" <?php if ($resCustomer['Nationality'] == 'CM') { echo 'selected';}?>>Cameroonian</option>
                                <option value="CA" <?php if ($resCustomer['Nationality'] == 'CA') { echo 'selected';}?>>Canadian</option>
                                <option value="CV" <?php if ($resCustomer['Nationality'] == 'CV') { echo 'selected';}?>>Cape Verdean</option>
                                <option value="KY" <?php if ($resCustomer['Nationality'] == 'KY') { echo 'selected';}?>>Cayman Islands</option>
                                <option value="CF" <?php if ($resCustomer['Nationality'] == 'CF') { echo 'selected';}?>>Central African</option>
                                <option value="TD" <?php if ($resCustomer['Nationality'] == 'TD') { echo 'selected';}?>>Chadian</option>
                                <option value="CL" <?php if ($resCustomer['Nationality'] == 'CL') { echo 'selected';}?>>Chilean</option>
                                <option value="CN" <?php if ($resCustomer['Nationality'] == 'CN') { echo 'selected';}?>>Chinese</option>
                                <option value="CX" <?php if ($resCustomer['Nationality'] == 'CX') { echo 'selected';}?>>Christmas Island</option>
                                <option value="CC" <?php if ($resCustomer['Nationality'] == 'CC') { echo 'selected';}?>>Cocos (Keeling) Islands</option>
                                <option value="CO" <?php if ($resCustomer['Nationality'] == 'CO') { echo 'selected';}?>>Colombian</option>
                                <option value="KM" <?php if ($resCustomer['Nationality'] == 'KM') { echo 'selected';}?>>Comoran</option>
                                <option value="CG" <?php if ($resCustomer['Nationality'] == 'CG') { echo 'selected';}?>>Congolese</option>
                                <option value="CD" <?php if ($resCustomer['Nationality'] == 'CD') { echo 'selected';}?>>Congo, the Democratic Republic of the</option>
                                <option value="CK" <?php if ($resCustomer['Nationality'] == 'CK') { echo 'selected';}?>>Cook Islands</option>
                                <option value="CR" <?php if ($resCustomer['Nationality'] == 'CR') { echo 'selected';}?>>Costa Rican</option>
                                <option value="CI" <?php if ($resCustomer['Nationality'] == 'CI') { echo 'selected';}?>>Cote d'Ivoire</option>
                                <option value="HR" <?php if ($resCustomer['Nationality'] == 'HR') { echo 'selected';}?>>Croatian</option>
                                <option value="CU" <?php if ($resCustomer['Nationality'] == 'CU') { echo 'selected';}?>>Cuban</option>
                                <option value="CY" <?php if ($resCustomer['Nationality'] == 'CY') { echo 'selected';}?>>Cypriot</option>
                                <option value="CZ" <?php if ($resCustomer['Nationality'] == 'CZ') { echo 'selected';}?>>Czech</option>
                                <option value="DK" <?php if ($resCustomer['Nationality'] == 'DK') { echo 'selected';}?>>Danish</option>
                                <option value="DJ" <?php if ($resCustomer['Nationality'] == 'DJ') { echo 'selected';}?>>Djibouti</option>
                                <option value="DM" <?php if ($resCustomer['Nationality'] == 'DM') { echo 'selected';}?>>Dominican</option>
                                <option value="DO" <?php if ($resCustomer['Nationality'] == 'DO') { echo 'selected';}?>>Dutch</option>
                                <option value="TP" <?php if ($resCustomer['Nationality'] == 'TP') { echo 'selected';}?>>East Timorese</option>
                                <option value="EC" <?php if ($resCustomer['Nationality'] == 'EC') { echo 'selected';}?>>Ecuadorean</option>
                                <option value="EG" <?php if ($resCustomer['Nationality'] == 'EG') { echo 'selected';}?>>Egyptian</option>
                                <option value="SV" <?php if ($resCustomer['Nationality'] == 'SV') { echo 'selected';}?>>El Salvador</option>
                                <option value="GQ" <?php if ($resCustomer['Nationality'] == 'GQ') { echo 'selected';}?>>Equatorial Guinean</option>
                                <option value="ER" <?php if ($resCustomer['Nationality'] == 'ER') { echo 'selected';}?>>Eritrean</option>
                                <option value="EE" <?php if ($resCustomer['Nationality'] == 'EE') { echo 'selected';}?>>Estonian</option>
                                <option value="ET" <?php if ($resCustomer['Nationality'] == 'ET') { echo 'selected';}?>>Ethiopian</option>
                                <option value="FK" <?php if ($resCustomer['Nationality'] == 'FK') { echo 'selected';}?>>Falkland Islands (Malvinas)</option>
                                <option value="FO" <?php if ($resCustomer['Nationality'] == 'FO') { echo 'selected';}?>>Faroe Islands</option>
                                <option value="FJ" <?php if ($resCustomer['Nationality'] == 'FJ') { echo 'selected';}?>>Fijian</option>
                                <option value="FI" <?php if ($resCustomer['Nationality'] == 'FI') { echo 'selected';}?>>Finland</option>
                                <option value="FR" <?php if ($resCustomer['Nationality'] == 'FR') { echo 'selected';}?>>France</option>
                                <option value="FX" <?php if ($resCustomer['Nationality'] == 'FX') { echo 'selected';}?>>France, Metropolitan</option>
                                <option value="GF" <?php if ($resCustomer['Nationality'] == 'GF') { echo 'selected';}?>>French Guiana</option>
                                <option value="PF" <?php if ($resCustomer['Nationality'] == 'PF') { echo 'selected';}?>>French Polynesia</option>
                                <option value="TF" <?php if ($resCustomer['Nationality'] == 'TF') { echo 'selected';}?>>French Southern Territories</option>
                                <option value="GA" <?php if ($resCustomer['Nationality'] == 'GA') { echo 'selected';}?>>Gabonese</option>
                                <option value="GM" <?php if ($resCustomer['Nationality'] == 'GM') { echo 'selected';}?>>Gambian</option>
                                <option value="GE" <?php if ($resCustomer['Nationality'] == 'GE') { echo 'selected';}?>>Georgian</option>
                                <option value="DE" <?php if ($resCustomer['Nationality'] == 'DE') { echo 'selected';}?>>German</option>
                                <option value="GH" <?php if ($resCustomer['Nationality'] == 'GH') { echo 'selected';}?>>Ghanaian</option>
                                <option value="GI" <?php if ($resCustomer['Nationality'] == 'GI') { echo 'selected';}?>>Gibraltar</option>
                                <option value="GR" <?php if ($resCustomer['Nationality'] == 'GR') { echo 'selected';}?>>Greek</option>
                                <option value="GL" <?php if ($resCustomer['Nationality'] == 'GL') { echo 'selected';}?>>Greenland</option>
                                <option value="GD" <?php if ($resCustomer['Nationality'] == 'GD') { echo 'selected';}?>>Grenadian</option>
                                <option value="GP" <?php if ($resCustomer['Nationality'] == 'GP') { echo 'selected';}?>>Guadeloupe</option>
                                <option value="GU" <?php if ($resCustomer['Nationality'] == 'GU') { echo 'selected';}?>>Guam</option>
                                <option value="GT" <?php if ($resCustomer['Nationality'] == 'GT') { echo 'selected';}?>>Guatemalan</option>
                                <option value="GN" <?php if ($resCustomer['Nationality'] == 'GN') { echo 'selected';}?>>Guinean</option>
                                <option value="GW" <?php if ($resCustomer['Nationality'] == 'GW') { echo 'selected';}?>>Guinea-Bissauan</option>
                                <option value="GY" <?php if ($resCustomer['Nationality'] == 'GY') { echo 'selected';}?>>Guyanese</option>
                                <option value="HT" <?php if ($resCustomer['Nationality'] == 'HI') { echo 'selected';}?>>Haitian</option>
                                <option value="HM" <?php if ($resCustomer['Nationality'] == 'HM') { echo 'selected';}?>>Heard and Mc Donald Islands</option>
                                <option value="VA" <?php if ($resCustomer['Nationality'] == 'VA') { echo 'selected';}?>>Holy See (Vatican City State)</option>
                                <option value="HN" <?php if ($resCustomer['Nationality'] == 'HN') { echo 'selected';}?>>Honduran</option>
                                <option value="HK" <?php if ($resCustomer['Nationality'] == 'HK') { echo 'selected';}?>>Hong Kong</option>
                                <option value="HU" <?php if ($resCustomer['Nationality'] == 'HU') { echo 'selected';}?>>Hungarian</option>
                                <option value="IS" <?php if ($resCustomer['Nationality'] == 'IS') { echo 'selected';}?>>Icelander</option>
                                <option value="IN" <?php if ($resCustomer['Nationality'] == 'IN') { echo 'selected';}?>>Indian</option>
                                <option value="ID" <?php if ($resCustomer['Nationality'] == 'ID') { echo 'selected';}?>>Indonesian</option>
                                <option value="IR" <?php if ($resCustomer['Nationality'] == 'IR') { echo 'selected';}?>>Iranian</option>
                                <option value="IQ" <?php if ($resCustomer['Nationality'] == 'IQ') { echo 'selected';}?>>Iraqi</option>
                                <option value="IE" <?php if ($resCustomer['Nationality'] == 'IE') { echo 'selected';}?>>Irish</option>
                                <option value="IL" <?php if ($resCustomer['Nationality'] == 'IL') { echo 'selected';}?>>Israeli</option>
                                <option value="IT" <?php if ($resCustomer['Nationality'] == 'IT') { echo 'selected';}?>>Italian</option>
                                <option value="JM" <?php if ($resCustomer['Nationality'] == 'JM') { echo 'selected';}?>>Jamaican</option>
                                <option value="JP" <?php if ($resCustomer['Nationality'] == 'JP') { echo 'selected';}?>>Japanese</option>
                                <option value="JO" <?php if ($resCustomer['Nationality'] == 'JO') { echo 'selected';}?>>Jordanian</option>
                                <option value="KZ" <?php if ($resCustomer['Nationality'] == 'KZ') { echo 'selected';}?>>Kazakhstani</option>
                                <option value="KE" <?php if ($resCustomer['Nationality'] == 'KE') { echo 'selected';}?>>Kenyan</option>
                                <option value="KI" <?php if ($resCustomer['Nationality'] == 'KI') { echo 'selected';}?>>Kiribati</option>
                                <option value="KP" <?php if ($resCustomer['Nationality'] == 'KP') { echo 'selected';}?>>Korea, Democratic People's Republic of</option>
                                <option value="KR" <?php if ($resCustomer['Nationality'] == 'KR') { echo 'selected';}?>>Korea, Republic of</option>
                                <option value="KW" <?php if ($resCustomer['Nationality'] == 'KW') { echo 'selected';}?>>Kuwaiti</option>
                                <option value="KG" <?php if ($resCustomer['Nationality'] == 'KG') { echo 'selected';}?>>Kyrgyzstan</option>
                                <option value="LA" <?php if ($resCustomer['Nationality'] == 'LA') { echo 'selected';}?>>Lao People's Democratic Republic</option>
                                <option value="LV" <?php if ($resCustomer['Nationality'] == 'LV') { echo 'selected';}?>>Latvian</option>
                                <option value="LB" <?php if ($resCustomer['Nationality'] == 'LB') { echo 'selected';}?>>Lebanese</option>
                                <option value="LS" <?php if ($resCustomer['Nationality'] == 'LS') { echo 'selected';}?>>Lesotho</option>
                                <option value="LR" <?php if ($resCustomer['Nationality'] == 'LR') { echo 'selected';}?>>Liberian</option>
                                <option value="LY" <?php if ($resCustomer['Nationality'] == 'LY') { echo 'selected';}?>>Libyan Arab Jamahiriya</option>
                                <option value="LI" <?php if ($resCustomer['Nationality'] == 'LI') { echo 'selected';}?>>Liechtensteiner</option>
                                <option value="LT" <?php if ($resCustomer['Nationality'] == 'LT') { echo 'selected';}?>>Lithuanian</option>
                                <option value="LU" <?php if ($resCustomer['Nationality'] == 'LU') { echo 'selected';}?>>Luxembourger</option>
                                <option value="MO" <?php if ($resCustomer['Nationality'] == 'MO') { echo 'selected';}?>>Macau</option>
                                <option value="MK" <?php if ($resCustomer['Nationality'] == 'MK') { echo 'selected';}?>>Macedonia, The Former Yugoslav Republic of</option>
                                <option value="MG" <?php if ($resCustomer['Nationality'] == 'MG') { echo 'selected';}?>>Madagascar</option>
                                <option value="MW" <?php if ($resCustomer['Nationality'] == 'MW') { echo 'selected';}?>>Malawian</option>
                                <option value="MY" <?php if ($resCustomer['Nationality'] == 'MY') { echo 'selected';}?>>Malaysian</option>
                                <option value="MV" <?php if ($resCustomer['Nationality'] == 'MV') { echo 'selected';}?>>Maldivan</option>
                                <option value="ML" <?php if ($resCustomer['Nationality'] == 'ML') { echo 'selected';}?>>Malian</option>
                                <option value="MT" <?php if ($resCustomer['Nationality'] == 'MT') { echo 'selected';}?>>Maltese</option>
                                <option value="MH" <?php if ($resCustomer['Nationality'] == 'MH') { echo 'selected';}?>>Marshallese</option>
                                <option value="MQ" <?php if ($resCustomer['Nationality'] == 'MQ') { echo 'selected';}?>>Martinique</option>
                                <option value="MR" <?php if ($resCustomer['Nationality'] == 'MR') { echo 'selected';}?>>Mauritanian</option>
                                <option value="MU" <?php if ($resCustomer['Nationality'] == 'MU') { echo 'selected';}?>>Mauritian</option>
                                <option value="YT" <?php if ($resCustomer['Nationality'] == 'YT') { echo 'selected';}?>>Mayotte</option>
                                <option value="MX" <?php if ($resCustomer['Nationality'] == 'MX') { echo 'selected';}?>>Mexican</option>
                                <option value="FM" <?php if ($resCustomer['Nationality'] == 'FM') { echo 'selected';}?>>Micronesia, Federated States of</option>
                                <option value="MD" <?php if ($resCustomer['Nationality'] == 'MD') { echo 'selected';}?>>Moldova, Republic of</option>
                                <option value="MC" <?php if ($resCustomer['Nationality'] == 'MC') { echo 'selected';}?>>Monacan</option>
                                <option value="MN" <?php if ($resCustomer['Nationality'] == 'MN') { echo 'selected';}?>>Mongolian</option>
                                <option value="MS" <?php if ($resCustomer['Nationality'] == 'MS') { echo 'selected';}?>>Montserrat</option>
                                <option value="MA" <?php if ($resCustomer['Nationality'] == 'MA') { echo 'selected';}?>>Moroccan</option>
                                <option value="MZ" <?php if ($resCustomer['Nationality'] == 'MZ') { echo 'selected';}?>>Mozambican</option>
                                <option value="MM" <?php if ($resCustomer['Nationality'] == 'MM') { echo 'selected';}?>>Myanmar</option>
                                <option value="NA" <?php if ($resCustomer['Nationality'] == 'NA') { echo 'selected';}?>>Namibian</option>
                                <option value="NR" <?php if ($resCustomer['Nationality'] == 'NR') { echo 'selected';}?>>Nauruan</option>
                                <option value="NP" <?php if ($resCustomer['Nationality'] == 'NP') { echo 'selected';}?>>Nepalese</option>
                                <option value="NL" <?php if ($resCustomer['Nationality'] == 'NL') { echo 'selected';}?>>Netherlands</option>
                                <option value="AN" <?php if ($resCustomer['Nationality'] == 'AN') { echo 'selected';}?>>Netherlands Antilles</option>
                                <option value="NC" <?php if ($resCustomer['Nationality'] == 'NC') { echo 'selected';}?>>New Caledonia</option>
                                <option value="NZ" <?php if ($resCustomer['Nationality'] == 'NZ') { echo 'selected';}?>>New Zealander</option>
                                <option value="NI" <?php if ($resCustomer['Nationality'] == 'NI') { echo 'selected';}?>>Nicaraguan</option>
                                <option value="NE" <?php if ($resCustomer['Nationality'] == 'NE') { echo 'selected';}?>>Niger</option>
                                <option value="NG" <?php if ($resCustomer['Nationality'] == 'NG') { echo 'selected';}?>>Nigerien</option>
                                <option value="NU" <?php if ($resCustomer['Nationality'] == 'NU') { echo 'selected';}?>>Niue</option>
                                <option value="NF" <?php if ($resCustomer['Nationality'] == 'NF') { echo 'selected';}?>>Norfolk Island</option>
                                <option value="MP" <?php if ($resCustomer['Nationality'] == 'MP') { echo 'selected';}?>>Northern Mariana Islands</option>
                                <option value="NO" <?php if ($resCustomer['Nationality'] == 'NO') { echo 'selected';}?>>Norwegian</option>
                                <option value="OM" <?php if ($resCustomer['Nationality'] == 'OM') { echo 'selected';}?>>Omani</option>
                                <option value="PK" <?php if ($resCustomer['Nationality'] == 'PK') { echo 'selected';}?>>Pakistani</option>
                                <option value="PW" <?php if ($resCustomer['Nationality'] == 'PW') { echo 'selected';}?>>Palauan</option>
                                <option value="PA" <?php if ($resCustomer['Nationality'] == 'PA') { echo 'selected';}?>>Panamanian</option>
                                <option value="PG" <?php if ($resCustomer['Nationality'] == 'PG') { echo 'selected';}?>>Papua New Guinean</option>
                                <option value="PY" <?php if ($resCustomer['Nationality'] == 'PY') { echo 'selected';}?>>Paraguayan</option>
                                <option value="PE" <?php if ($resCustomer['Nationality'] == 'PE') { echo 'selected';}?>>Peruvian</option>
                                <option value="PH" <?php if ($resCustomer['Nationality'] == 'PH') { echo 'selected';}?>>Philippines</option>
                                <option value="PN" <?php if ($resCustomer['Nationality'] == 'PN') { echo 'selected';}?>>Pitcairn</option>
                                <option value="PL" <?php if ($resCustomer['Nationality'] == 'PL') { echo 'selected';}?>>Poland</option>
                                <option value="PT" <?php if ($resCustomer['Nationality'] == 'PT') { echo 'selected';}?>>Portuguese</option>
                                <option value="PR" <?php if ($resCustomer['Nationality'] == 'PR') { echo 'selected';}?>>Puerto Rico</option>
                                <option value="QA" <?php if ($resCustomer['Nationality'] == 'QA') { echo 'selected';}?>>Qatari</option>
                                <option value="RE" <?php if ($resCustomer['Nationality'] == 'RE') { echo 'selected';}?>>Reunion</option>
                                <option value="RO" <?php if ($resCustomer['Nationality'] == 'RO') { echo 'selected';}?>>Romanian</option>
                                <option value="RU" <?php if ($resCustomer['Nationality'] == 'RU') { echo 'selected';}?>>Russian Federation</option>
                                <option value="RW" <?php if ($resCustomer['Nationality'] == 'RW') { echo 'selected';}?>>Rwandan</option>
                                <option value="KN" <?php if ($resCustomer['Nationality'] == 'KN') { echo 'selected';}?>>Saint Kitts and Nevis</option> 
                                <option value="LC" <?php if ($resCustomer['Nationality'] == 'LC') { echo 'selected';}?>>Saint Lucian</option>
                                <option value="VC" <?php if ($resCustomer['Nationality'] == 'VC') { echo 'selected';}?>>Saint Vincent and the Grenadines</option>
                                <option value="WS" <?php if ($resCustomer['Nationality'] == 'WS') { echo 'selected';}?>>Samoan</option>
                                <option value="SM" <?php if ($resCustomer['Nationality'] == 'SM') { echo 'selected';}?>>San Marinese</option>
                                <option value="ST" <?php if ($resCustomer['Nationality'] == 'ST') { echo 'selected';}?>>Sao Tome and Principe</option> 
                                <option value="SA" <?php if ($resCustomer['Nationality'] == 'SA') { echo 'selected';}?>>Saudi</option>
                                <option value="SN" <?php if ($resCustomer['Nationality'] == 'SN') { echo 'selected';}?>>Senegal</option>
                                <option value="SC" <?php if ($resCustomer['Nationality'] == 'SC') { echo 'selected';}?>>Seychelles</option>
                                <option value="SL" <?php if ($resCustomer['Nationality'] == 'SL') { echo 'selected';}?>>Sierra Leone</option>
                                <option value="SG" <?php if ($resCustomer['Nationality'] == 'SG') { echo 'selected';}?>>Singapore</option>
                                <option value="SK" <?php if ($resCustomer['Nationality'] == 'SK') { echo 'selected';}?>>Slovakia (Slovak Republic)</option>
                                <option value="SI" <?php if ($resCustomer['Nationality'] == 'SI') { echo 'selected';}?>>Slovenia</option>
                                <option value="SB" <?php if ($resCustomer['Nationality'] == 'SB') { echo 'selected';}?>>Solomon Islands</option>
                                <option value="SO" <?php if ($resCustomer['Nationality'] == 'SO') { echo 'selected';}?>>Somalia</option>
                                <option value="ZA" <?php if ($resCustomer['Nationality'] == 'ZA') { echo 'selected';}?>>South Africa</option>
                                <option value="GS" <?php if ($resCustomer['Nationality'] == 'GS') { echo 'selected';}?>>South Georgia and the South Sandwich Islands</option>
                                <option value="ES" <?php if ($resCustomer['Nationality'] == 'ES') { echo 'selected';}?>>Spain</option>
                                <option value="LK" <?php if ($resCustomer['Nationality'] == 'LK') { echo 'selected';}?>>Sri Lanka</option>
                                <option value="SH" <?php if ($resCustomer['Nationality'] == 'SH') { echo 'selected';}?>>St. Helena</option>
                                <option value="PM" <?php if ($resCustomer['Nationality'] == 'PM') { echo 'selected';}?>>St. Pierre and Miquelon</option>
                                <option value="SD" <?php if ($resCustomer['Nationality'] == 'SD') { echo 'selected';}?>>Sudan</option>
                                <option value="SR" <?php if ($resCustomer['Nationality'] == 'SR') { echo 'selected';}?>>Suriname</option>
                                <option value="SJ" <?php if ($resCustomer['Nationality'] == 'SJ') { echo 'selected';}?>>Svalbard and Jan Mayen Islands</option>
                                <option value="SZ" <?php if ($resCustomer['Nationality'] == 'SZ') { echo 'selected';}?>>Swaziland</option>
                                <option value="SE" <?php if ($resCustomer['Nationality'] == 'SE') { echo 'selected';}?>>Sweden</option>
                                <option value="CH" <?php if ($resCustomer['Nationality'] == 'CH') { echo 'selected';}?>>Switzerland</option>
                                <option value="SY" <?php if ($resCustomer['Nationality'] == 'SY') { echo 'selected';}?>>Syrian Arab Republic</option>
                                <option value="TW" <?php if ($resCustomer['Nationality'] == 'TW') { echo 'selected';}?>>Taiwan, Province of China</option>
                                <option value="TJ" <?php if ($resCustomer['Nationality'] == 'TJ') { echo 'selected';}?>>Tajikistan</option>
                                <option value="TZ" <?php if ($resCustomer['Nationality'] == 'TZ') { echo 'selected';}?>>Tanzania, United Republic of</option>
                                <option value="TH" <?php if ($resCustomer['Nationality'] == 'TH') { echo 'selected';}?>>Thailand</option>
                                <option value="TG" <?php if ($resCustomer['Nationality'] == 'TG') { echo 'selected';}?>>Togo</option>
                                <option value="TK" <?php if ($resCustomer['Nationality'] == 'TK') { echo 'selected';}?>>Tokelau</option>
                                <option value="TO" <?php if ($resCustomer['Nationality'] == 'TO') { echo 'selected';}?>>Tonga</option>
                                <option value="TT" <?php if ($resCustomer['Nationality'] == 'TT') { echo 'selected';}?>>Trinidad and Tobago</option>
                                <option value="TN" <?php if ($resCustomer['Nationality'] == 'TN') { echo 'selected';}?>>Tunisia</option>
                                <option value="TR" <?php if ($resCustomer['Nationality'] == 'TR') { echo 'selected';}?>>Turkey</option>
                                <option value="TM" <?php if ($resCustomer['Nationality'] == 'TM') { echo 'selected';}?>>Turkmenistan</option>
                                <option value="TC" <?php if ($resCustomer['Nationality'] == 'TC') { echo 'selected';}?>>Turks and Caicos Islands</option>
                                <option value="TV" <?php if ($resCustomer['Nationality'] == 'TV') { echo 'selected';}?>>Tuvalu</option>
                                <option value="UG" <?php if ($resCustomer['Nationality'] == 'UG') { echo 'selected';}?>>Uganda</option>
                                <option value="UA" <?php if ($resCustomer['Nationality'] == 'UA') { echo 'selected';}?>>Ukraine</option>
                                <option value="AE" <?php if ($resCustomer['Nationality'] == 'AE') { echo 'selected';}?>>United Arab Emirates</option>
                                <option value="GB" <?php if ($resCustomer['Nationality'] == 'GB') { echo 'selected';}?>>United Kingdom</option>
                                <option value="US" <?php if ($resCustomer['Nationality'] == 'US') { echo 'selected';}?>>United States</option>
                                <option value="UM" <?php if ($resCustomer['Nationality'] == 'UM') { echo 'selected';}?>>United States Minor Outlying Islands</option>
                                <option value="UY" <?php if ($resCustomer['Nationality'] == 'UY') { echo 'selected';}?>>Uruguayan</option>
                                <option value="UZ" <?php if ($resCustomer['Nationality'] == 'UZ') { echo 'selected';}?>>Uzbekistani</option>
                                <option value="VU" <?php if ($resCustomer['Nationality'] == 'VU') { echo 'selected';}?>>Vanuatu</option>
                                <option value="VE" <?php if ($resCustomer['Nationality'] == 'VE') { echo 'selected';}?>>Venezuelan</option>
                                <option value="VN" <?php if ($resCustomer['Nationality'] == 'VN') { echo 'selected';}?>>Viet Nam</option>
                                <option value="VG" <?php if ($resCustomer['Nationality'] == 'VG') { echo 'selected';}?>>Virgin Islands (British)</option>
                                <option value="VI" <?php if ($resCustomer['Nationality'] == 'VI') { echo 'selected';}?>>Virgin Islands (U.S.)</option>
                                <option value="WF" <?php if ($resCustomer['Nationality'] == 'WF') { echo 'selected';}?>>Wallis and Futuna Islands</option>
                                <option value="EH" <?php if ($resCustomer['Nationality'] == 'EH') { echo 'selected';}?>>Western Sahara</option>
                                <option value="YE" <?php if ($resCustomer['Nationality'] == 'YE') { echo 'selected';}?>>Yemenite</option>
                                <option value="YU" <?php if ($resCustomer['Nationality'] == 'YU') { echo 'selected';}?>>Yugoslavia</option>
                                <option value="ZM" <?php if ($resCustomer['Nationality'] == 'ZM') { echo 'selected';}?>>Zambian</option>
                                <option value="ZW" <?php if ($resCustomer['Nationality'] == 'ZW') { echo 'selected';}?>>Zimbabwean</option>
                            </select>
                            <div class="invalid-feedback">
                            Select nationality
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label  class="form-label text-light">Date Of birth <span class="text-danger">*</span></label>
                            <input type="date" class="form-control input-style" value="<?php echo $resCustomer['DateOfBirth'];?>" name="dateofbirth" max="<?php echo date('Y-m-d', strtotime("-18 year", time())); ?>" required>
                            <div class="invalid-feedback">
                            Choose birth date
                            </div>
                        </div>
                        
                        <div class="col-md-4 mt-3">
                            <label  class="form-label text-light">Address Line 1</label>
                            <input type="text" class="form-control input-style" value="<?php echo $resCustomer['AddressLine1'];?>" name="address_line1" maxlength="245">
                            <div class="invalid-feedback">
                            Please enter address line1
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label  class="form-label text-light">Address Line 2</label>
                            <input type="text" class="form-control input-style" value="<?php echo $resCustomer['AddressLine2'];?>" name="address_line2" maxlength="245">
                            <div class="invalid-feedback">
                            Please enter address line2
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label  class="form-label text-light">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-style" value="<?php echo $resCustomer['CustomerCity'];?>" name="city" required maxlength="49">
                            <div class="invalid-feedback">
                            Please enter city
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label  class="form-label text-light">State <span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-style" value="<?php echo $resCustomer['CustomerState'];?>" name="state" required maxlength="49">
                            <div class="invalid-feedback">
                            Please enter state
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label text-light">Country <small class="text-danger text-sm">(Read Only)</small></label>
                            <input type="text" class="form-control input-style" value="<?php echo $resCustomer['CustomerCountry'];?>" readonly>
                        </div>
                        <div class="col-md-12 mt-3">
                            <button type="submit" name="update" class="mt-3">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    require_once './pages/footer.php';
?>