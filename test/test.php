<?php

$_POST["username"] = "  <23h1>5Hel@lo World! <scr%^-_+=\\|&:'*()ipt ></sc.ript> 123  sdf 456</23h1>fgg55  ";
$_POST["password"] = "  <23h1>5Hel@lo World! <scr%^-_+=\\|&:'*()ipt ></sc.ript> 123  sdf 456</23h1>fgg55  ";

//$username = preg_trim( $_POST["username"], "[^a-zA-Z0-9]" );
//$password = preg_trim( $_POST["password"], "[^a-zA-Z0-9]" );

function preg_trim( $string, $pattern ) {
    $pattern = array( "/^" . $pattern . "*/", "/" . $pattern . "*$/" );

    echo "<pre>";
    print_r ($pattern);
    echo "</pre>";

    var_dump($pattern);

    return preg_replace( $pattern, "", $string );
}


$hello = "   ...%20Hello, world!-/\/1234";
echo preg_trim( $hello, "/[a-zA-Z]/" );
//print_r( preg_grep( "/[a-zA-Z]/", $hello ) );
echo '<br><br>';


////////////////////////////////////////////////////////////////////
$data = array(0, 1, 2, 'three', 4, 5, 'six', 7, 8, 'nine', 10);
$mod1 = preg_grep("/4|5|6/", $data);
$mod2 = preg_grep("/[0-9]/", $data, PREG_GREP_INVERT);
print_r($mod1);
echo "<br><br>";
print_r($mod2);
////////////////////////////////////////////////////////////////////

//echo $username;
//echo "/n";
//echo $password;

?>