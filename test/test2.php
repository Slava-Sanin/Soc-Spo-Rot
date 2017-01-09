<?php


$username = "  <23h1>5Hel@lo World! <scr%^-_+=\\|&:'*()ipt ></sc.ript> 123  sdf 456</23h1>fgg55  ";
// http://htmlweb.ru/php/example/preg.php

if (preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/",$username)) {
    echo "invalid username";
    echo preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/",$username);
    exit;
}