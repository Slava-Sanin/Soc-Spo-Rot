<?php
session_start();
///////////////////////////////////////////////////////////////////////////////////
$_SESSION["username_and_password_is"] = false;

$_POST["username"] = "  <23h1>5Hel@lo World! <scr%^-_+=\\|&:'*()ipt ></sc.ript> 123  sdf 456</23h1>fgg55  ";
$_POST["password"] = "  <23h1>5Hel@lo World! <scr%^-_+=\\|&:'*()ipt ></sc.ript> 123  sdf 456</23h1>fgg55  ";

//$username = preg_replace('[/^a-zA-Z0-9\s]','', $_POST["username"]);
//$password = preg_replace('[/^a-zA-Z0-9\s]','', $_POST["password"]);

//echo $username . '<br>';
//echo $password . '<br>';
//exit();

echo $_POST["username"] = trim($_POST["username"]);
echo "<br><br>";
echo $_POST["password"] = trim($_POST["password"]);
echo "<br><br>";echo "<br><br>";

echo $_POST["username"] = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
echo "<br><br>";
echo $_POST["password"] = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
echo "<br><br>";echo "<br><br>";

$username = $_POST["username"] = str_replace(' ','',$_POST["username"]);
$password = $_POST["password"] = str_replace(' ','',$_POST["password"]);

echo $username . '<br><br>';
echo $password . '<br><br>';
exit();
