<?php
session_start();
/////////////////////////////
//echo '<pre>';
//echo "_POST ";
//print_r($_POST);
//echo "_SESSION ";
//print_r($_SESSION);
//die();
/////////////////////////////

$token = $_SESSION['token'];

if (isset($_POST['reset']))
{
    $_SESSION['error'] = '';
    $_SESSION['new_user_login'] = $_SESSION['user_login'];
    $_SESSION['new_user_password'] = $_SESSION['user_password'];
    $_SESSION['new_user_email'] = $_SESSION['user_email'];
    $_SESSION['new_user_fname'] = $_SESSION['user_fname'];
    $_SESSION['new_user_lname'] = $_SESSION['user_lname'];
    $_SESSION['new_user_country'] = $_SESSION['user_country'];

    header("Location: edit_profile.php");
    exit();
}

if (isset($_POST['Save_Submit']))
{
    $_POST['user_login'] = str_replace('"', '', $_POST['user_login']);
    $_POST['user_password'] = str_replace('"', '', $_POST['user_password']);
    $_POST['confirm_password'] = str_replace('"', '', $_POST['confirm_password']);
    $_POST["user_email"] = str_replace('"', '', $_POST["user_email"]);
    $_POST["user_fname"] = str_replace('"', '', $_POST["user_fname"]);
    $_POST["user_lname"] = str_replace('"', '', $_POST["user_lname"]);
    $_POST["user_country"] = str_replace('"', '', $_POST["user_country"]);

    $blocked_chars = "\ '@#~`!%&|.,+?(){}[]^$:;*<>=/";
    $user_login = $_POST["user_login"] = my_filter($_POST["user_login"],$blocked_chars);
    $user_password = $_POST["user_password"] = my_filter($_POST["user_password"],$blocked_chars);
    $confirm_password = $_POST["confirm_password"] = my_filter($_POST["confirm_password"],$blocked_chars);
    $user_fname = $_POST["user_fname"] = my_filter($_POST["user_fname"],$blocked_chars);
    $user_lname = $_POST["user_lname"] = my_filter($_POST["user_lname"],$blocked_chars);
    $user_country = $_POST["user_country"] = my_filter($_POST["user_country"],$blocked_chars);

    $blocked_chars = "\ '#~`!%&|,+?(){}[]^$:;*<>=/";
    $user_email = $_POST["user_email"] = my_filter($_POST["user_email"],$blocked_chars);

    $_SESSION['new_user_login'] = $_SESSION['user_login'];
    $_SESSION['new_user_password'] = $user_password;
    $_SESSION['new_user_email'] = $user_email;
    $_SESSION['new_user_fname'] = $user_fname;
    $_SESSION['new_user_lname'] = $user_lname;
    $_SESSION['new_user_country'] = $user_country;

    if(!empty($_POST['user_login']) && !empty($_POST['user_password']) && !empty($_POST['confirm_password']) && !empty($_POST['user_email']) )
    {
        if($_POST['user_password'] == $_POST['confirm_password'])
        {
            if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Invalid email format!";
            }
            else {
                    require_once('../mysqli_connect.php');

                    if ($user_login != $_SESSION['user_login'])
                    {
                        if (check_new_user_login())
                        {
                            user_to_db();
                            $_SESSION['new_user_login'] = $user_login;
                        }
                    }
                    else user_to_db();

                    mysqli_close($dbc);
                 }
        }
        else $_SESSION['error'] = "Password is not confirmed!";
    }
    else $_SESSION['error'] = "Please, fill all required fields!";
}

header("Location: edit_profile.php");
exit();
///////////////////////////////////////////////////////////////////////////////////


//////////////////// Filtering blocked chars in login or email ////////////////////
function my_filter($string, $regex_chars)
{
    for ($i=0; $i<strlen($regex_chars); $i++)
    {
        $char = substr($regex_chars, $i, 1);
        $string = str_replace($char, '', $string);
    }
    return $string;
}
///////////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////////
function check_new_user_login()
{
    global $dbc;
    global $user_login;
//////////////// Checking if no such user with such username ////////////////
    $query = "SELECT * FROM users WHERE username = '$user_login' AND token != '" . $_SESSION['token'] . "'";

    $response = @mysqli_query($dbc, $query);

    if ($response->num_rows)
    {
        $_SESSION['error'] = "This username is already taken!";
        return 0;
    }

    return 1;
}
///////////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////////
//                         Update new data of user's profile in database
///////////////////////////////////////////////////////////////////////////////////
function user_to_db()
{
    global $dbc;
    global $token;
    global $user_login;
    global $user_password;
    global $user_email;
    global $user_fname;
    global $user_lname; // = !empty($_POST['user_lname']) ? $_POST['user_lname'] : '';
    global $user_country; // = !empty($_POST['user_country']) ? $_POST['user_country'] : '';

/////////////// Update profile data /////////////////
    $new_token = md5(uniqid($user_login, true));
    $query = "UPDATE users SET username = '$user_login', password = MD5('$user_password'), email = '$user_email', FirstName = '$user_fname', FamilyName = '$user_lname', country = '$user_country', token = '$new_token' WHERE token = '$token'";
    $response = @mysqli_query($dbc, $query);

    if ($response)
    {
        $_SESSION['error'] = "<span style='color: #299629'>Your profile is updated!</span>";
        $_SESSION['token'] = $new_token;
    }
    else
    {
        echo "Couldn't issue database query"."<br/>";
        $_SESSION['error'] = mysqli_error($dbc);
    }
/////////////////////////////////////////////////////

}
//////////////////////////////////////////////////////////////////////////////////
?>