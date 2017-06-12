<?php
session_start();
///////////////////////////
//echo '<pre>';
//echo "_POST ";
//print_r($_POST);
//echo "_SESSION ";
//print_r($_SESSION);
//die();
///////////////////////////

require "mail_functions.php";

$host = $_SERVER['HTTP_HOST'];
$token = '';

if (isset($_POST['reset']))
{
    $_SESSION['error'] = '';
    $_SESSION['user_login'] = '';
    $_SESSION['user_email'] = '';
    $_SESSION['user_fname'] = '';
    $_SESSION['user_lname'] = '';
    $_SESSION['user_country'] = '';

    header("Location: register.php");
    exit();
}

if (isset($_POST['Register_Submit']))
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

///////////////////////////
//    echo '<pre>';
//    echo "_POST ";
//    print_r($_POST);
//    echo "_SESSION ";
//    print_r($_SESSION);
//    die();
///////////////////////////
//echo $username . '<br>';
//echo $password . '<br>';
//exit();

    if(!empty($_POST['user_login']) && !empty($_POST['user_password']) && !empty($_POST['confirm_password']) && !empty($_POST['user_email']) )
    {
        if($_POST['user_password'] == $_POST['confirm_password'])
        {
            if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Invalid email format!";
            }
            else user_to_db();
        }
        else $_SESSION['error'] = "Password is not confirmed!";
    }
    else $_SESSION['error'] = "Please, fill all required fields!";
}

$_SESSION['user_login'] = $_POST['user_login'];
$_SESSION['user_email'] = $_POST['user_email'];
$_SESSION['user_fname'] = $_POST['user_fname'];
$_SESSION['user_lname'] = $_POST['user_lname'];
$_SESSION['user_country'] = $_POST['user_country'];

header("Location: register.php");
exit();


//////////////////// Filtering blocked chars in login or email ////////////////////
function my_filter($string, $regex_chars)
{
    for ($i=0; $i<strlen($regex_chars); $i++)
    {
        $char = substr($regex_chars, $i, 1);
        $string = str_replace($char, '', $string);
        //echo $string . '<br>';
    }
    return $string;
}
///////////////////////////////////////////////////////////////////////////////////


//////////////////////////////// Sending the token to user ////////////////////////
function send_the_activation_link_mail()
{
    global $error;
    global $user_email;
    global $host;
    global $token;
    global $user_login;

    //$headers = 'From: '.$linked_user_email . "\r\n" .'Content-type: text/plain; charset="windows-1251"' . "\r\n";
    $headers = 'From: '. '-f'.$user_email . "\r\n" ."MIME-Version: 1.0" . "\r\n" .'Content-type: text/html; charset="utf-8"' . "\r\n";

    $message = 'Please follow the link to activate your Soc-Spo-Rot.com account and loging in. <br> <a href="http://'.$host.'/Support/activate.php?username='.$user_login.'&token='.$token.'">Activate your account</a>';

    $title = 'Soc-Spo-Rot.com account activation';

    //$result = mail($user_email, $title, $mess, $headers);     // sends mail on localhost

    $result = send_the_PHPMailer_mail($user_login, $user_email, 'Soc-Spo-Rot.com account activation', $message);
    if ($result)
    {
        //     echo 'все путем';
        $_SESSION['error'] = "<span style='color: #299629'>The link for your account activation was sended to your email!</span>";
    }
    else
    {
        //     echo 'что-то не так';    send again over another server
        if (send_MailSmtpClass($user_login, $user_email, 'Soc-Spo-Rot.com account activation', $message))
            $_SESSION['error'] = "<span style='color: #299629'>The link for your account activation was sended to your email!</span>";
        else
            $_SESSION['error'] = "<span>Can't send link for your account activation. There is some problem with emailing!</span>";
    }
}
///////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////
//                         Insert new user into database
/////////////////////////////////////////////////////////////////////////////
function user_to_db()
{
    global $host;
    global $token;
    $user_login = $_POST['user_login'];
    $user_password = $_POST['user_password'];
    $user_email = $_POST['user_email'];
    $user_fname = !empty($_POST['user_fname']) ? $_POST['user_fname'] : '';
    $user_lname = !empty($_POST['user_lname']) ? $_POST['user_lname'] : '';
    $user_country = !empty($_POST['user_country']) ? $_POST['user_country'] : '';

    require_once('../mysqli_connect.php');

    //$query = "INSERT INTO users (first_name, last_name, email, login, password, user_id) VALUES (?, ?, ?, ?, ?, NULL)";

//////////////// Checking if no such user with such username ////////////////
    $query = "SELECT * FROM users WHERE username = '$user_login'";
    //echo $query;
    $response = @mysqli_query($dbc, $query);

    if ($response->num_rows)
    {
        $_SESSION['error'] = "There is already a user with that username. Please choose another username!";
        mysqli_close($dbc);
        return;
    }
/////////////// Insert new user to database /////////////////
    $token = md5(uniqid($user_login, true));
    $query = "INSERT INTO users (username, password, email, FirstName, FamilyName, country, registration_date, token) VALUES ('$user_login', MD5('$user_password'), '$user_email', '$user_fname', '$user_lname', '$user_country', CURRENT_DATE, '$token' )";
    $response = @mysqli_query($dbc, $query);

    // If the query executed properly proceed
    if ($response)
    {
        // mysqli_fetch_array will return a row of data from the query
        // until no further data is available
        //while($row = mysqli_fetch_array($response))
        //{
            // if i am here - username and password is founded
         //   $_SESSION["username_and_password_is"] = true;
        //}

        //echo "Пользователь зарегистрирован.";
//        $_SESSION['error'] = "<span style='color: #299629'>User $user_login is now registered. Welcome member!</span>";
//        $_SESSION['error'] = "<span style='color: #299629'>The link for your account activation was sended to your email!</span>";
        //mysqli_close($dbc);
        send_the_activation_link_mail();
        //header("Location: register.php");
        //header("Location: ../");
        //exit();
    }
    else
        {
            echo "Couldn't issue database query"."<br/>";
            $_SESSION['error'] = mysqli_error($dbc);
        }

// Close connection to the database
    mysqli_close($dbc);

    ///////////////////////////////////////////////////////////////////////////////////
}

?>