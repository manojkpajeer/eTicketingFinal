<?php 
    session_start();

    require_once './config/connection.php';
    require_once './pages/link.php';
    require_once './pages/header.php';   
?>

<section class="w3l-teams-17">
     <div id="teams17-block">
        <div class="wrapper">
          
            <div class="team-1">
                    <div class="left-single-team row mt-3">
                    <h4>Event List</h4> 
                            <h3 class="mb-3">Select events to create badge</h3>
                            <?php
                                $resEvent = mysqli_query($conn, "SELECT StartDate, EventName, EM_Id, ShortDescription, EventCode FROM event_master WHERE EventStatus = 'Publish' LIMIT 25");
                                if (mysqli_num_rows($resEvent) > 0) {

                                    while($rowEvnt = mysqli_fetch_assoc($resEvent)){
                                    ?>
                                        <a href="add-badge.php?eid=<?php echo $rowEvnt['EM_Id'];?>&ecode=<?php echo $rowEvnt['EventCode'];?>" class="right-single-team-top col-6 border p-3 shadow m-2">
                                            <div class="right-single-team-top-lft">
                                                <h5><?php echo date_format(date_create($rowEvnt['StartDate']), "d");?></h5><span class="text-dark"><?php echo date_format(date_create($rowEvnt['StartDate']), "M");?></span><h6><small><?php echo date_format(date_create($rowEvnt['StartDate']), "Y");?></small></h6>
                                            </div>
                                            <div class="right-single-team-top-rgt">
                                                <h6><?php echo $rowEvnt['EventName'];?></h6>
                                                <p><?php echo $rowEvnt['ShortDescription'];?></p>
                                            </div>
                                        </a>
                                    <?php
                                    }
                                } else {

                                    echo "<h6 class='text-center'>No events found..</h6>";
                                }
                            ?>
                            
                     </div>
                    
                </div>
        </div>
        </div>
     </div>
    </section>

<?php
    require_once './pages/newsletter.php';
    require_once './pages/footer.php';
?>