<?php

    session_start();

//    $_SESSION['user_login'] = '';
//    $_SESSION['user_email'] = '';
//    $_SESSION["username_and_password_is"] = false;

    session_unset();
    session_destroy();

    header("Location: index.php");

?>