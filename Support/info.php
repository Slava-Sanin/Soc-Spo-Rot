<?php
    session_start();
///////////////////////////
//echo '<pre>';
//echo "_POST ";
//print_r($_POST);
//echo "<br>";
//echo "_SESSION ";
//print_r($_SESSION);
//die();
///////////////////////////
$error = '';
$blocked_chars = "\ '@#~`!%&|.,+?(){}[]^$:;*<>=/";
$username = '';
$password = '';
//////////////////////////
if (isset($_POST['username'])) $username = $_POST["username"] = my_filter($_POST["username"],$blocked_chars);
if (isset($_POST['password'])) $password = $_POST["password"] = my_filter($_POST["password"],$blocked_chars);
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
?>

<!--///////////////////////////////////////// Lost password page ////////////////////////////////////////////////////-->

    <html dir="ltr" lang="en-US">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Info page</title>
<!--        <link rel="stylesheet" type="text/css" href="../CSS/socsporot.css">-->
        <link rel="stylesheet" type="text/css" href="../CSS/login.css">
<!--        <link rel="stylesheet" type="text/css" href="../CSS/register.css" />-->
        <link rel="stylesheet" type="text/css" href="../CSS/header.css">
<!--        <link media="only screen and (max-device-width: 480px)" href="../CSS/iphone.css" type="text/css" rel="stylesheet" />-->
    </head>

    <body id="info_page">

        <div class="wrapper">

            <div class="header">
                <?php include '../logo.php' ?>
            </div>

            <form class="login" method="post" action="#">
                <p>
                    <label>Username		<input class="text" name="username" type="text" id="username" size="15" maxlength="50" value="" >
                    </label>
                    <label>Password		<input class="text" name="password" type="password" id="password" size="15" maxlength="50" >
                    </label>
                    <input name="re" type="hidden" value="">
                    <input type="submit" class="button-secondary" name="Submit" id="submit" value="Log in">
                </p>
            </form>

            <div id="headline">
                <div class="wrapper">
                    <p style="text-align: center; color: red; font-style: italic; line-height: 28px; font-size: large"> <?= $error ?></p>
                </div>
            </div>

            <div id="pagebody" class="forumlist">

                <div class="wrapper topictitle">
                    <div class="col-12">
                        <h2 id="register" style="text-align: center;">Info page</h2>
                    </div>
                </div>



                <div class="wrapper">

                    <?php
                    if ($username == "demo" && $password == "demo")
                    {
                        require_once('../mysqli_connect.php');
                        $query = "SELECT * FROM users";
                        $response = @mysqli_query($dbc, $query);
                        if($response)
                        {

//                echo '<table align="left" cellspacing="5" cellpadding="8">
//                            <tr>
//                                <td align="left"><b>Username</b></td>
//                                <td align="left"><b>Password</b></td>
//                            </tr>';
//
//                // mysqli_fetch_array will return a row of data from the query
//                // until no further data is available
//                while($row = mysqli_fetch_array($response)){
//
//                echo '<tr><td align="left">' .
//                $row['username'] . '</td><td align="left">' .
//                $row['password'] . '</td><td align="left">';
//                echo '</tr>';
//                }
//
//                echo '</table>' . '<br />';
                            $num_rows = mysqli_num_rows($response);
                            echo "Counter: " . $num_rows;

                        }
                        else
                            {

                                echo "Couldn't issue database query<br />";
                                echo mysqli_error($dbc);
                            }

                        mysqli_close($dbc);
                    }
                    ?>

                </div>
            </div>

            <br class="clear" />

        </div>

    </body>
    </html>


