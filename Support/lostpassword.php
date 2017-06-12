<?php
session_start();

//echo "_POST ";
//print_r($_POST);
//echo '<br>';
//echo '_SESSION ';
//print_r($_SESSION);

require "mail_functions.php";

$host = $_SERVER['HTTP_HOST'];
$token = '';
$linked_user_email = '';

if (isset($_SESSION['error']))
{
    $error = $_SESSION['error'];
    $_SESSION['error'] = '';
}
else $error = '';

if (isset($_SESSION['user_login']))
{
    $user_login = $_SESSION['user_login'];
//        $_SESSION['user_login'] = '';
}
else $user_login = '';

if (isset($_SESSION['user_email']))
{
    $user_email = $_SESSION['user_email'];
//        $_SESSION['user_email'] = '';
}
else $user_email = '';

if (isset($_POST['lostpassword_Submit']))
{

    if (isset($_POST['user_login']) && !empty($_POST['user_login'])) $user_login_is_OK = check_user_login();
    else
    {
        $user_login_is_OK = 0;
        $error = 'Please, input Username!';
    }

    if ($user_login_is_OK)
    {
        if (isset($_POST['user_email']) && !empty($_POST['user_email'])) $user_email_is_OK = check_user_email();
        else
        {
            $user_email_is_OK = 0;
            if ($error == 'Please, input Username!') $error = 'Please input Username and Email!';
            else $error = 'Please, input Email!';
        }

        if ($user_login_is_OK && $user_email_is_OK)
        {
            //  send_the_mail(); // working on localhost
            //  send_the_PHPMailer_mail(); // working over smtp
            // send_MailSmtpClass();  // used for sending over reserved smtp address
            //smtpmail($user_login, $linked_user_email, 'Password recovering', 'HTML или обычный текст письма');

            $message = 'Please choose your new password for loging in into Soc-Spo-Rot.com! <br> <a href="http://'.$host.'/Support/changepass.php?username='.$user_login.'&token='.$token.'">Change the password</a>';

            if (send_the_PHPMailer_mail($user_login, $linked_user_email, 'Password recovering', $message))
                $error = $_SESSION['error'] = "<span style='color: #299629;'>The link for password changing was sended to your email!</span>";
            elseif
                (send_MailSmtpClass($user_login, $linked_user_email, 'Password recovering', $message))
                $error = $_SESSION['error'] = "<span style='color: #299629;'>The link for password changing was sended to your email! 2</span>";
        }

    }

}

///////////////////////////// Functions ///////////////////////////////////////////

//////////////////// Filtering blocked chars in login or email ////////////////////
function my_filter($string, $regex_chars)
{
    global $error;
    for ($i=0; $i<strlen($regex_chars); $i++)
    {
        $char = substr($regex_chars, $i, 1);
        $string = str_replace($char, '', $string);
        //echo $string . '<br>';
    }
    if ($string != $_POST['user_email']) $error = 'Please check the email again!';
    return $string;
}
///////////////////////////////////////////////////////////////////////////////////
function check_user_login()
{
    global $linked_user_email;
    global $error;
    global $user_login;
    global $token;

    $first_input_login = $_POST["user_login"];
    $_POST["user_login"] = str_replace('"', '', $_POST["user_login"]);
    $blocked_chars = "\ '@#~`!%&|.,+?(){}[]^$:;*<>=/";
    $user_login = $_POST["user_login"] = my_filter($_POST["user_login"], $blocked_chars);

    if ($first_input_login == $user_login)
    {
            // check if the username is exist in DB
            require_once('../mysqli_connect.php');
            $query = "SELECT * FROM users WHERE username = '$user_login' ";
            $response = @mysqli_query($dbc, $query);
            mysqli_close($dbc);
            if (!$response)
            {
                echo "Couldn't issue database query<br />";
                echo mysqli_error($dbc);
                return 0;
            }
            elseif ($response->num_rows)
            {
                while($row = mysqli_fetch_array($response))
                {
                    $linked_user_email = $row['email'];
                    $token = $row['token'];
                }
                return 1;
            }
            else
            {
                $error = $_SESSION['error'] = "The username $user_login is not exist!";
                return 0;
            }
    }
    else
    {
        $error = $_SESSION['error'] = "Chars and simbols like $blocked_chars is not allowed!";
        return 0;
    }
}
///////////////////////////////////////////////////////////////////////////////////
function check_user_email()
{
    global $error;
    global $linked_user_email;
    global $user_login;
    global $user_email;

    $first_input_email = $_POST["user_email"];
    $_POST["user_email"] = str_replace('"', '', $_POST["user_email"]);
    $blocked_chars = "\\ '#~`!%&|,+?(){}[]^$:;*<>=/";
    $user_email = $_POST["user_email"] = my_filter($_POST["user_email"], $blocked_chars);

    if ($first_input_email == $user_email)
    {
        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL))
        {
            $error = $_SESSION['error'] = "Invalid email format!";
            return 0;
        }
        else
        {
            // check if the inputed email is linked to inputed username
            if ($linked_user_email != $user_email)
            {
                $error = $_SESSION['error'] = "There is no username $user_login with email $user_email!";
                //$error = $_SESSION['error'] = "The user with this email is not exist!";
                return 0;
            }
            else return 1;
        }
    }
    else
    {
        $error = $_SESSION['error'] = "Chars and simbols like $blocked_chars is not allowed!";
        return 0;
    }
}
///////////////////////////////////////////////////////////////////////////////////
?>

<!--///////////////////////////////////////// Lost password page ////////////////////////////////////////////////////-->

<html dir="ltr" lang="en-US">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lost Password</title>
    <link rel="stylesheet" type="text/css" href="../CSS/register.css" />
    <link rel="stylesheet" type="text/css" href="../CSS/header.css">
    <link media="only screen and (max-device-width: 480px)" href="../CSS/iphone.css" type="text/css" rel="stylesheet" />
</head>

<body id="Lostpassword" >

    <div class="wrapper">

        <div class="header">
            <?php include '../logo.php' ?>
        </div>

        <div id="headline">
            <div class="wrapper">
                <p style="text-align: center; color: red; font-style: italic; line-height: 28px; font-size: large"> <?= $error ?></p>
            </div>
        </div>

        <div id="pagebody" class="forumlist">

            <div class="wrapper topictitle">
                <div class="col-12">
                    <h2 id="register" style="text-align: center;">Lost password recovering</h2>
                </div>
            </div>

            <div class="wrapper">

                <div class="col-12">

                    <form method="post" action="lostpassword.php">
                        <p style="text-align: center; padding-top: 5px;">(Please enter your username and email. You will receive a link to create a new password via email.)</p>

                        <table class="form-table form-table-register">

                            <tr class="required">
                                <th scope="row" style="padding-top: 0px;padding-bottom: 19px;">Username:</th>
                                <td>
                                    <input name="user_login" type="text" id="user_login" size="50" maxlength="50" value="<?= $user_login ?>" required /> Required <br>
                                    <em class="user-login-hint">Only letters, numbers, simbols '-' and '_' are allowed.</em>
                                </td>
                            </tr>

                            <tr class="form-field form-required required">
                                <th scope="row">
                                    <label for="user_email">Email:</label>
                                </th>
                                <td>
                                    <input name="user_email" id="user_email" type="text" size="50" maxlength="50" value="<?= $user_email ?>" required /> Required
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <div class="g-recaptcha" data-sitekey="6Ld6gcoSAAAAAEkCxPeS-_sqEokNIHwNCOtx17xo"></div>
                                </td>
                            </tr>
                        </table>

                        <p class="submit">
                            <input type="submit" class="button" name="lostpassword_Submit" value="Get new password" />
                            <a href="../"><input type="button" name="cancel" value="Cancel" style="margin-left: 35px;"></a>
                        </p>
                    </form>
                </div>
            </div>
        </div>

        <br class="clear" />

    </div>
</body>
</html>
