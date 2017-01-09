<?php
session_start();
///////////////////////////////////////////////////////////////////////////////////
$_SESSION["username_and_password_is"] = false;

//$_POST["username"] = "  <23h1>5Hel@lo World! <scr%^-_+=\\|&:'*()ipt ></sc.ript> 123  sdf 456</23h1>fgg55  ";
//$_POST["password"] = "  <23h1>5Hel@lo World! <scr%^-_+=\\|&:'*()ipt ></sc.ript> 123  sdf 456</23h1>fgg55  ";

//echo $_POST["username"] = trim($_POST["username"]);
//echo "<br><br>";
//echo $_POST["password"] = trim($_POST["password"]);
//echo "<br><br>";echo "<br><br>";

//$username = $_POST["username"] = str_replace("'",'',$_POST["username"]);

//echo $_POST["username"] = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
//echo "<br><br>";
//echo $_POST["password"] = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
//echo "<br><br>";echo "<br><br>";

//$username = $_POST["username"] = str_replace(' ','',$_POST["username"]);
//$password = $_POST["password"] = str_replace(' ','',$_POST["password"]);

$blocked_chars = "\ '@#~`!%&|.,+?(){}[]^$:;*<>=/";
$username = $_POST["username"] = my_filter($_POST["username"],$blocked_chars);
$password = $_POST["password"] = my_filter($_POST["password"],$blocked_chars);

//echo $username . '<br>';
//echo $password . '<br>';
//exit();
//////////////////// Filtering blocked chars in login or email ////////////////////
function my_filter($string, $regex_chars)
{
    for ($i=0; $i<strlen($regex_chars); $i++)
    {
        $char = substr($regex_chars, $i, 1);
        $string = str_replace($char, '', $string);
        echo $string . '<br>';
    }
   return $string;
}
///////////////////////////////////////////////////////////////////////////////////

require('get_user_info.php');

///////////////////////////////////////////////////////////////////////////////////
echo "<br><br>";
echo "<p style='clear: both; margin-top: 50px'>";
echo "SELECT username, password FROM users WHERE username = '$username' AND password = MD5('$password')";
echo "</p>";
// Create a query for the database
$query = "SELECT username, password FROM users WHERE username = '$username' AND password = MD5('$password')";

// Get a response from the database by sending the connection
// and the query
$response = @mysqli_query($dbc, $query);

// If the query executed properly proceed
if($response){

    echo '<table align="left" cellspacing="5" cellpadding="8">                
                <tr>
                    <td align="left"><b>Username</b></td>
                    <td align="left"><b>Password</b></td>
                </tr>';

    // mysqli_fetch_array will return a row of data from the query
    // until no further data is available
    while($row = mysqli_fetch_array($response)){
    // if i am here - username and password is founded
        $_SESSION["username_and_password_is"] = true;
        echo '<tr><td align="left">' .
            $row['username'] . '</td><td align="left">' .
            $row['password'] . '</td><td align="left">';
        echo '</tr>';
    }

    echo '</table>';

    $query = "UPDATE users SET last_visit = CURRENT_DATE WHERE username = '$username'";
    $response = @mysqli_query($dbc, $query);

} else {

    echo "Couldn't issue database query"."<br />";

    echo mysqli_error($dbc);

}

// Close connection to the database
mysqli_close($dbc);

///////////////////////////////////////////////////////////////////////////////////

//header("Location: http://localhost:9090/My_Sites/SocSpoRot/");

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
//$extra = 'mypage.php';
//header("Location: http://$host$uri/$extra");
header("Location: http://$host$uri/");

exit;

?>

