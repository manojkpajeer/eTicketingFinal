<?php 
    session_start();

    require_once './config/connection.php';

    require_once './pages/link.php';


    echo "ji";

    echo $_SESSION['CM_Id'];
    require_once './pages/footer.php';
?>