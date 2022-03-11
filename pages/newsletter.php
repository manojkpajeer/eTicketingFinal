<?php
    if (isset($_POST['newsLetter'])) {
        $emailNews = $_POST['emailIDS'];

        $resNews = mysqli_query($conn, "SELECT EmailID FROM news_letter WHERE EmailID = '$emailNews'");
        if (mysqli_num_rows($resNews) > 0) {

            echo "<script>alert('Oops, You are already subscribed..');</script>";
        } else {

            if (mysqli_query($conn, "INSERT INTO news_letter (EmailID, Status, DateCreate) VALUES ('$emailNews', 1, NOW())")) {
                echo "<script>alert('Yay, You have subscribed successfully..');</script>";
            } else {
                echo "<script>alert('Oops, Unable to process..');</script>";
            }
        }
        
    }
?>
<section class="w3l-forms-9 border-top" id="newsletter">
    <div class="main-w3 bg-light" style="
    background-position: center !important;
    background-repeat: no-repeat !important;
    background-size: cover !important;">
        <div class="wrapper">
            <div class="grids-forms">
                <div class="main-midd">
                    <h4 class="title-head text-dark">Upcoming Events And Special Offers</h4>
                    <p class="text-dark">Get Newsletters</p>
                </div>
                <div class="main-midd-2">
                    <form method="post" class="rightside-form">
                        <input type="email" name="emailIDS" placeholder="Enter your email" style="border: 1px solid #cd9c50;">
                        <button class="btn" type="submit" name="newsLetter" >Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>