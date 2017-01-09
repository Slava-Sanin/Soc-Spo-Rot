<?php
session_start();

$_SESSION["username_and_password_is"] = false;
$host = $_SERVER['HTTP_HOST'];
header("Location: http://$host/My_Sites/SocSpoRot/");

exit;
?>