<?php
session_start();

//    echo "_POST ";
//    print_r($_POST);
//    echo '<br>';
//    echo '_SESSION ';
//    print_r($_SESSION);

if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    $_SESSION['error'] = '';
}
else $error = '';

if (!isset($_SESSION['new_user_login'])) {
    $user_login = $_SESSION['new_user_login'] = $_SESSION['user_login'];
}
else $user_login = $_SESSION['new_user_login'];

if (!isset($_SESSION['new_user_password'])) {
    $user_password = $_SESSION['new_user_password'] = $_SESSION['user_password'];
}
else $user_password = $_SESSION['new_user_password'];

if (!isset($_SESSION['new_user_email'])) {
    $user_email = $_SESSION['new_user_email'] = $_SESSION['user_email'];
}
else $user_email = $_SESSION['new_user_email'];

if (!isset($_SESSION['new_user_fname'])) {
    $user_fname = $_SESSION['new_user_fname'] = $_SESSION['user_fname'];
}
else $user_fname = $_SESSION['new_user_fname'];

if (!isset($_SESSION['new_user_lname'])) {
    $user_lname = $_SESSION['new_user_lname'] = $_SESSION['user_lname'];
}
else $user_lname = $_SESSION['new_user_lname'];

if (!isset($_SESSION['new_user_country'])) {
    $user_country = $_SESSION['new_user_country'] = $_SESSION['user_country'];
}
else $user_country = $_SESSION['new_user_country'];

?>

<html dir="ltr" lang="en-US">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Editing</title>
    <link rel="stylesheet" type="text/css" href="../CSS/register.css" />
    <link rel="stylesheet" type="text/css" href="../CSS/header.css" />
    <link media="only screen and (max-device-width: 480px)" href="../CSS/iphone.css" type="text/css" rel="stylesheet" />
</head>

<body id="Profile_Editing" >

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
                <h2 id="register" style="text-align: center;">Profile editing</h2>
            </div>
        </div>

        <div class="wrapper">

            <div class="col-12">

                <form id="EditForm" method="post" action="check_edit_profile.php">
<!--                    <p style="text-align: center; padding-top: 5px;">(Your activation link will be emailed to the address you provide.)</p>-->

                    <table class="form-table form-table-register">

                        <tr class="required">
                            <th scope="row" style="padding-top: 0px;padding-bottom: 19px;">Username:</th>
                            <td>
                                <input name="user_login" type="text" id="user_login" size="45" maxlength="50" value="<?= $user_login ?>" required /> Required <br>
                                <em class="user-login-hint">Only letters, numbers, simbols '-' and '_' are allowed.</em>
                            </td>
                        </tr>

                        <tr class="form-field">
                            <th scope="row">
                                <label for="user_password">Password:</label>
                            </th>
                            <td>
                                <input name="user_password" id="user_password" type="password" size="45" maxlength="50" value="<?= $user_password ?>" required /> Required
                            </td>
                        </tr>

                        <tr class="form-field">
                            <th scope="row">
                                <label for="confirm_password">Confirm Password:</label>
                            </th>
                            <td>
                                <input name="confirm_password" id="confirm_password" type="password" size="45" maxlength="50" value="" required /> Required
                            </td>
                        </tr>

                        <tr class="form-field form-required required">
                            <th scope="row">
                                <label for="user_email">Email:</label>
                            </th>
                            <td>
                                <input name="user_email" id="user_email" type="text" size="45" maxlength="50" value="<?= $user_email ?>" required /> Required
                            </td>
                        </tr>

                        <tr class="form-field">
                            <th scope="row">
                                <label for="user_fname">First Name:</label>
                            </th>
                            <td>
                                <input name="user_fname" id="user_fname" type="text" size="45" maxlength="50" value="<?= $user_fname ?>" />
                            </td>
                        </tr>

                        <tr class="form-field">
                            <th scope="row">
                                <label for="user_lname">Family Name:</label>
                            </th>
                            <td>
                                <input name="user_lname" id="user_lname" type="text" size="45" maxlength="50" value="<?= $user_lname ?>" />
                            </td>
                        </tr>

                        <tr class="form-field">
                            <th scope="row">
                                <label for="user_country">Your Country:</label>
                            </th>
                            <td>
                                <input name="user_country" id="user_country" type="text" size="45" maxlength="50" value="<?= $user_country ?>" />
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
                        <input type="submit" class="button" name="Save_Submit" value="Save" >
                        <input type="reset" name="reset" value="Reset" style="margin-left: 35px;">
                        <a href="../"><input type="button" name="cancel" value="Cancel" style="margin-left: 35px;"></a>
                        <!--                   <input type="button" onclick="ResetAll();" value="Reset" style="margin-left: 35px;">-->
                    </p>
                </form>

            </div>

        </div>

    </div>

    <br class="clear" />

</body>
</html>
