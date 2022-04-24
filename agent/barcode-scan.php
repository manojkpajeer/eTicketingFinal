<?php
    session_start();
        
    if(!isset($_SESSION['is_ajent_login'])){
        header('Location: ./pages/logout.php');
    }
    else{
        if(!$_SESSION['is_ajent_login']){
            header('Location: ./pages/logout.php');
        }
    }
        
    require_once '../config/connection.php';
    require_once './pages/link.php';
    require_once './pages/sidebar.php';
    require_once './pages/header.php';
?>

<div class="main-content">
    <div class="container-fluid content-top-gap">
        <div class="row">
            <div class="col-xl-12 pr-xl-12">
                <div class="card card_border border-primary-top">
                    <div class="card-header chart-grid__header float-left">Scan Barcode<a class="btn btn-outline-primary float-right btn-sm" href="barcode-report.php?id=<?php echo $_GET['id']?>">View</a></div>
                        <div class="card-body">
                            <form method="post" class="row g-3 needs-validation" novalidate>
                                <div class="col-md-4">
                                    <label for="validationCustom01" class="form-label">Barcode Number</label>
                                    <input type="text" class="form-control input-style" autofocus onblur="myInsertFunction(this.value)" id="barcode_box">
                                </div>

                                <div class="col-2 text-center mt-2" >
                                    <img src="assets/images/bar_scan.png" id="imgContainer" width="50" height="50" style="margin-top:10px;" />
                                </div>

                                <div class="col-md-6 mt-3">
                                    <strong class="text-danger" style="font-size: 21px;" id="text_container"></strong>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function myInsertFunction(barcode){
        $("#imgContainer").attr('src', 'assets/images/bar_scan.png');
        $('#text_container').text('');

        var barcode_no = barcode;
        var event_id = '<?php echo $_GET['id'];?>';
        $.ajax({
            url: './ajax-page/barcode_data.php',
            method: 'POST',
            data: {
                barcode_no: barcode_no,
                event_id: event_id,
            },
            success: function(data) {
                var res = $.parseJSON(data);
                if (res.status_code < 0) {
                    alert(res.message);
                    window.location.href='scan.php';
                } else if (res.status_code == 0) {
                    $('#text_container').text(res.message);
                    $('#barcode_box').focus();
                } else if (res.status_code > 0) {
                    if(res.message == "Out") {
                        $("#imgContainer").attr('src', 'assets/images/user_out.png');
                    } else {
                        $("#imgContainer").attr('src', 'assets/images/user_in.png');
                    }
                    
                }                    
            },
            error: function() {
                alert('Oops, Unable to process..');
                window.location.href='scan.php';
            }
        })
    }
</script>
<?php
    require_once './pages/footer.php';
?>