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

    if (isset($_SESSION['user_fname'])) {
        $user_fname = $_SESSION['user_fname'];
//        $_SESSION['user_fname'] = '';
    }
    else $user_fname = '';

    if (isset($_SESSION['user_lname'])) {
        $user_lname = $_SESSION['user_lname'];
//        $_SESSION['user_lname'] = '';
    }
    else $user_lname = '';

    if (isset($_SESSION['user_country'])) {
        $user_country = $_SESSION['user_country'];
//        $_SESSION['user_country'] = '';
    }
    else $user_country = '';

?>

<html dir="ltr" lang="en-US">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Registration</title>
<link rel="stylesheet" href="register.css" />
<link media="only screen and (max-device-width: 480px)" href="iphone.css" type="text/css" rel="stylesheet" />
</head>

<body id="Registration" >
	<div id="reg-header">
		<div class="wrapper">
			<div style="display: inline-flex"><img style="margin: 5px 7px 5px 5px;" src="../G4W/images/spot.png"><h1><a style="line-height: 41px;" href="../">Soc-Spo-Rot</a> - Logical Games for WEB</h1></div>


			<div id="headline">
			<div class="wrapper">
                <p style="text-align: center; color: red; font-style: italic; line-height: 28px; font-size: large"> <?= $error ?></p>
<!--				<form class="login" method="post" action="https://wordpress.org/support/bb-login.php">-->
<!---->
<!--					<p><label><span class="hide-if-placeholder">Username or Email Address</span>-->
<!--					<input class="text" name="user_login" type="text" id="user_login" placeholder="username or email" size="13" maxlength="40" value="" />-->
<!--  					</label>-->
<!---->
<!--					<label><span class="hide-if-placeholder">Password</span>-->
<!--					<input class="text" name="password" type="password" id="password" placeholder="password" size="13" maxlength="100" />-->
<!--					</label>-->
<!---->
<!--					<input name="remember" type="checkbox" id="remember" title="Remember me" value="1" tabindex="3" />-->
<!--					<input name="re" type="hidden" value="" />-->
<!--					<input type="submit" class="button-secondary" name="Submit" id="submit" value="Log in" />-->
<!--					(<a href="https://wordpress.org/support/bb-login.php">forgot?</a>)	<a class="button" href="https://wordpress.org/support/register.php">Register</a></p>-->
<!--				</form>-->

<!--<script type="text/javascript">-->
<!---->
<!--(function() {-->
<!--if ( document.getElementsByClassName && document.getElementById( 'user_login' ).placeholder ) {-->
<!--	var hideThese = document.getElementsByClassName( 'hide-if-placeholder' )-->
<!--	for ( var i = 0; i < hideThese.length; i++ ) {-->
<!--		hideThese[i].style.display = 'none';-->
<!--	}-->
<!--}-->
<!--})();-->
<!---->
<!--</script>-->
			</div>
			</div>


<div id="pagebody" class="forumlist">

	<div class="wrapper topictitle">
		<div class="col-12">
			<h2 id="register" style="text-align: center;">Registration</h2>
		</div>
	</div>

	<div class="wrapper">

		<div class="col-12">

			<form method="post" action="check_register.php">
				<p style="text-align: center; padding-top: 5px;">(Your password will be emailed to the address you provide.)</p>

				<table class="form-table form-table-register">

					<tr class="required">
					<th scope="row">Username</th>
						<td>
							<input name="user_login" type="text" id="user_login" size="50" maxlength="50" value="<?= $user_login ?>" /> Required <br>
							<em class="user-login-hint">Only lower case letters (a-z) and numbers (0-9) are allowed.</em>
						</td>
					</tr>

					<tr class="form-field">
						<th scope="row">
							<label for="user_password">Password</label>
						</th>
						<td>
							<input name="user_password" id="user_password" type="password" size="50" maxlength="50" value="" /> Required
						</td>
					</tr>

					<tr class="form-field">
						<th scope="row">
							<label for="confirm_password">Confirm Password</label>
						</th>
						<td>
							<input name="confirm_password" id="confirm_password" type="password" size="50" maxlength="50" value="" /> Required
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
					
					<tr class="form-field">
						<th scope="row">
							<label for="user_fname">First Name</label>
						</th>
						<td>
							<input name="user_fname" id="user_fname" type="text" size="50" maxlength="50" value="<?= $user_fname ?>" />
						</td>
					</tr>
					
					<tr class="form-field">
						<th scope="row">
							<label for="user_lname">Family Name</label>
						</th>
						<td>
							<input name="user_lname" id="user_lname" type="text" size="50" maxlength="50" value="<?= $user_lname ?>" />
						</td>
					</tr>
					
					<tr class="form-field">
						<th scope="row">
							<label for="user_country">Your Country</label>
						</th>
						<td>
							<input name="user_country" id="user_country" type="text" size="50" maxlength="50" value="<?= $user_country ?>" />
						</td>
					</tr>
					

					
					<tr>
						<th scope="row"></th>
						<td>
							<div class="g-recaptcha" data-sitekey="6Ld6gcoSAAAAAEkCxPeS-_sqEokNIHwNCOtx17xo"></div>
						</td>
					</tr>
				</table>

				<p class="submit"><input type="submit" class="button" name="Register_Submit" value="Register" /></p>
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
