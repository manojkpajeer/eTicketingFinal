<?php
    session_start();

    $_SESSION['cm_id'] = "";
    unset($_SESSION['cm_id']);

    $_SESSION['user_role'] = "";
    unset($_SESSION['user_role']);

    $_SESSION['user_email'] = "";
    unset($_SESSION['user_email']);

    $_SESSION['is_customer_login'] = "";
    unset($_SESSION['is_customer_login']);

    $_SESSION['customer_id'] = "";
    unset($_SESSION['customer_id']);

    $_SESSION['account_no'] = "";
    unset($_SESSION['account_no']);

    header("Location: ../index.php");
?>