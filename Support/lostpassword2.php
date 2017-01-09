<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Lost password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="register.css" />
<!--    <link rel="stylesheet" href="lostpassword2.css" />-->
<!--    <link media="only screen and (max-device-width: 480px)" href="iphone.css" type="text/css" rel="stylesheet" />-->
</head>

<!--<h1><a href="../" title="Soc-Spo-Rot.com" tabindex="-1">Soc-Spo-Rot.com Login</a></h1>-->

<body id="lostpassword">
<!--#f1f1f1-->
    <div class="wrapper">

    <!--    <div style="display: inline-flex"><img style="margin: 5px 7px 5px 5px;" src="../G4W/images/spot.png"><h1><a style="line-height: 41px;" href="../">Soc-Spo-Rot</a> - Logical Games for WEB</h1></div>-->

        <div class="logo"><img src="../G4W/images/spot.png"><h1><a href="../">Soc-Spo-Rot</a> - Logical Games for WEB</h1></div>
        <div id="headline"></div>
        <form name="lostpasswordform" id="lostpasswordform" action="/wp-login.php?action=lostpassword" method="post">
            <p class="intro">Please enter your username or email address.<br> You will receive a link to create a new password via email.</p>
            <p>
                <label for="user_login">Username or Email		<input name="user_login" id="user_login" value="" size="20" type="text"></label>
            </p>
            <input name="redirect_to" value="/checkemail/" type="hidden">
            <p class="submit">
                <input name="lostpasswordform-submit" id="lostpasswordform-submit" class="button" value="Get new password" type="submit">
            </p>
        </form>
        <p id="nav">
            <a href="/">← Back to login</a>
        </p>

    </div>

</body>

</html>
