<?php
    session_start();

//    if (!isset($_SESSION['first_loading']))
//    {
//        $_SESSION['first_loading'] = 1;
//        $_SESSION['error'] = '';
//    }
//    $error = $_SESSION['error'];

    if (isset($_GET['username']) && !empty($_GET['username']))
    {
        $user_login = $_SESSION['user_login'] = $_GET['username'];
        $error = $_SESSION['error'] = '';
    }
    else
        {
            $user_login = $_SESSION['user_login'];
            $error = '';
        }
    if (isset($_GET['token']) && !empty($_GET['token'])) $_SESSION['token'] = $_GET['token'];

    $host = $_SERVER['HTTP_HOST'];

//    echo "_POST ";
//    print_r($_POST);
//    echo '<br>';
//    echo "_GET ";
//    print_r($_GET);
//    echo '<br>';
//    echo '_SESSION ';
//    print_r($_SESSION);

    $user_password = '';
    $confirm_password = '';
    $token = $_SESSION['token'];


if (isset($_POST['Change_password_Submit']))
{

    if (isset($_POST['user_password']) && !empty($_POST['user_password'])) $user_password_is_OK = check_password();
    else
    {
        $user_password_is_OK = 0;
        $error = 'Please, input new password!';
    }

    if ($user_password_is_OK)
    {
        if (isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])) $user_confirm_password_is_OK = check_confirm_password();
        else
        {
            $user_confirm_password_is_OK = 0;
            if ($error == 'Please, input password!') $error = 'Please fill the fields!';
            else $error = 'Please, confirm new password!';
        }

        if ($user_password_is_OK && $user_confirm_password_is_OK) save_new_password_in_db();
    }

}

///////////////////////////// Functions ///////////////////////////////////////////

//////////////////// Filtering blocked chars in password ////////////////////
function my_filter($string, $regex_chars)
{
    global $error;

    for ($i=0; $i<strlen($regex_chars); $i++)
    {
        $char = substr($regex_chars, $i, 1);
        $string = str_replace($char, '', $string);
        //echo $string . '<br>';
    }
    //if ($string != $_POST['user_password']) $error = "Simbols like '$regex_chars' is not allowed!";
    return $string;
}
///////////////////////////////////////////////////////////////////////////////////
function check_password()
{
    global $error;
    global $user_password;

    $first_input_password = $_POST['user_password'];
    $_POST['user_password'] = str_replace('"', '', $_POST['user_password']);
    $blocked_chars = "\ '@#~`!%&|.,+?(){}[]^$:;*<>=/";
    $user_password = $_POST['user_password'] = my_filter($_POST['user_password'], $blocked_chars);

    if ($first_input_password == $user_password)
    {
        return 1;
    }
    else
    {
//        $error = $_SESSION['error'] = "Chars and simbols like $blocked_chars is not allowed!";
        $error = "Chars and simbols like $blocked_chars is not allowed!";
        return 0;
    }
}
////////////////////////////////////////////////////////////////////////////////////
function check_confirm_password()
{
    global $error;
    global $user_password;
    global $confirm_password;

    $first_input_password = $_POST['confirm_password'];
    $_POST['confirm_password'] = str_replace('"', '', $_POST['confirm_password']);
    $blocked_chars = "\ '@#~`!%&|.,+?(){}[]^$:;*<>=/";
    $confirm_password = $_POST['confirm_password'] = my_filter($_POST['confirm_password'], $blocked_chars);

    if ($first_input_password == $confirm_password)
    {
        if ($user_password == $confirm_password) return 1;
        else
        {
            $error = "Password is not confirmed!";
            return 0;
        }
    }
    else
    {
//        $error = $_SESSION['error'] = "Chars and simbols like $blocked_chars is not allowed!";
        $error = "Chars and simbols like $blocked_chars is not allowed!";
        return 0;
    }
}
///////////////////////////////////////////////////////////////////////////////////
function save_new_password_in_db()
    {
        global $error;
        global $user_password;
        global $token;

        // Save the new password of user into DB
        require_once('../mysqli_connect.php');
        $query = "SELECT * FROM users WHERE token = '$token'";
        $response = @mysqli_query($dbc, $query);
        //mysqli_close($dbc);
        if (!$response)
        {
            echo "Couldn't issue database query<br />";
            echo mysqli_error($dbc);
            //return 0;
        }
        elseif ($response->num_rows)
            {
                // if i am here - token is exist
                $query = "UPDATE users SET password = MD5('$user_password') WHERE token = '$token'";
                $response = @mysqli_query($dbc, $query);

                $error = "<span style='color: #299629'>Password successfully changed!</span>";
                //$_SESSION['error'] = "<span style='color: #299629'>Password successfully changed!</span>";
            }
            else
            {
                $error = "Token is not exist!";
            }

        mysqli_close($dbc);
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<html dir="ltr" lang="en-US">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Changing password</title>
    <link rel="stylesheet" type="text/css" href="../CSS/register.css" />
    <link rel="stylesheet" type="text/css" href="../CSS/header.css" />
    <link media="only screen and (max-device-width: 480px)" href="../CSS/iphone.css" type="text/css" rel="stylesheet" />
</head>

<body id="Change_password" >

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
                <h2 id="register" style="text-align: center;">Changing password</h2>
            </div>
        </div>

        <div class="wrapper">

            <div class="col-12">

                <form id="Change_password_Form" method="post" action="changepass.php">
                    <p style="text-align: center; padding-top: 5px;">(For <?= $user_login ?>)</p>

                    <table class="form-table form-table-register">

                        <tr class="form-field">
                            <th scope="row">
                                <label for="user_password">New password:</label>
                            </th>
                            <td>
                                <input name="user_password" id="user_password" type="password" size="45" maxlength="50" value="" /> Required
                            </td>
                        </tr>

                        <tr class="form-field">
                            <th scope="row">
                                <label for="confirm_password">Confirm Password:</label>
                            </th>
                            <td>
                                <input name="confirm_password" id="confirm_password" type="password" size="45" maxlength="50" value="" /> Required
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"></th>
                            <td>
                                <div class="g-recaptcha" data-sitekey="6Ld6gcoSAAAAAEkCxPeS-_sqEokNIHwNCOtx17xo"></div>
                            </td>
                        </tr>
                    </table>

                    <p class="submit"><input type="submit" class="button" name="Change_password_Submit" value="OK" /> </p>
                </form>

            </div>

        </div>

    </div>

    <br class="clear" />

</body>
</html>
