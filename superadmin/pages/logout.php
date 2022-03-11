<?php
    session_start();

    $_SESSION['am_id'] = "";
    unset($_SESSION['am_id']);

    $_SESSION['user_role'] = "";
    unset($_SESSION['user_role']);

    $_SESSION['user_email'] = "";
    unset($_SESSION['user_email']);

    $_SESSION['is_admin_login'] = "";
    unset($_SESSION['is_admin_login']);

    $_SESSION['FullName'] = "";
    unset($_SESSION['FullName']);

    header("Location: ../index.php");



    
?>