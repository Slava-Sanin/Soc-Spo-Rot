<?php
$str = "  <23h1>5Hel@lo World! <scr%^-_+=\\|&:'*()ipt ></sc.ript> 123  sdf 456</23h1>fgg55  ";
$newstr = filter_var($str, FILTER_SANITIZE_STRING);
echo $newstr;
echo "<br><br>";
$newstr = str_replace(' ','',$newstr);
echo $newstr;
?>