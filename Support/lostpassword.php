<?php
session_start();

//echo "_POST ";
//print_r($_POST);
//echo '<br>';
//echo '_SESSION ';
//print_r($_SESSION);


if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    $_SESSION['error'] = '';
}
else $error = '';

if (isset($_SESSION['user_login'])) {
    $user_login = $_SESSION['user_login'];
//        $_SESSION['user_login'] = '';
}
else $user_login = '';

if (isset($_SESSION['user_email'])) {
    $user_email = $_SESSION['user_email'];
//        $_SESSION['user_email'] = '';
}
else $user_email = '';


if (isset($_POST['user_email']) AND !empty($_POST['user_email'])) {
//    mb_send_mail($_POST['user_email'],'Passwor recovering','Please choose your new password for loging in in soc-spo-rot.com!','soc-spo-rot@gmail.com');
    mail($_POST['user_email'],'Passwor recovering','Please choose your new password for loging in in soc-spo-rot.com!','soc-spo-rot@gmail.com');
}



?>

<html dir="ltr" lang="en-US">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>
    <link rel="stylesheet" href="register.css" />
    <link media="only screen and (max-device-width: 480px)" href="iphone.css" type="text/css" rel="stylesheet" />
</head>

<body id="Lostpassword" >
<div id="reg-header">
    <div class="wrapper">
        <div style="display: inline-flex"><img style="margin: 5px 7px 5px 5px;" src="../G4W/images/spot.png"><h1><a style="line-height: 41px;" href="../">Soc-Spo-Rot</a> - Logical Games for WEB</h1></div>


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
                        <p style="text-align: center; padding-top: 5px;">(Please enter your username or email address. You will receive a link to create a new password via email)</p>

                        <table class="form-table form-table-register">

                            <tr class="required">
                                <th scope="row">Username</th>
                                <td>
                                    <input name="user_login" type="text" id="user_login" size="50" maxlength="50" value="<?= $user_login ?>" /> Required <br>
                                    <em class="user-login-hint">Only lower case letters (a-z) and numbers (0-9) are allowed.</em>
                                </td>
                            </tr>

                            <tr class="form-field form-required required">
                                <th scope="row">
                                    <label for="user_email">Email</label>
                                </th>
                                <td>
                                    <input name="user_email" id="user_email" type="text" size="50" maxlength="50" value="<?= $user_email ?>" /> Required
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <div class="g-recaptcha" data-sitekey="6Ld6gcoSAAAAAEkCxPeS-_sqEokNIHwNCOtx17xo"></div>
                                </td>
                            </tr>
                        </table>

                        <p class="submit"><input type="submit" class="button" name="lostpassword_Submit" value="Get new password" /></p>
                    </form>
                </div>
            </div>
        </div>

        <br class="clear" />



        <script type="text/javascript">
            var _qevents = _qevents || [];
            (function() {
                var elem = document.createElement('script');
                elem.src = (document.location.protocol == "https:" ? "https://secure" : "http://edge") + ".quantserve.com/quant.js";
                elem.async = true;
                elem.type = "text/javascript";
                var scpt = document.getElementsByTagName('script')[0];
                scpt.parentNode.insertBefore(elem, scpt);
            })();
        </script>

        <script type="text/javascript">_qevents.push( { qacct:"p-18-mFEk4J448M"} );</script>

        <noscript><img src="//pixel.quantserve.com/pixel/p-18-mFEk4J448M.gif" style="display: none;" border="0" height="1" width="1" alt=""/></noscript>

        <!-- 2 queries, 0.039 seconds -->
        <script type="text/javascript" src="//gravatar.com/js/gprofiles.js"></script>

        <script type="text/javascript">
            (function($){
                $(document).ready(function() {

                });
            })(jQuery);
        </script>

</body>
</html>
