
<!--<form class="login" method="post" action="https://wordpress.org/support/bb-login.php">-->
<!--    <p>-->
<!--        <label>Username		<input class="text" name="user_login" type="text" id="user_login" size="13" maxlength="25" value="">-->
<!--        </label>-->
<!--        <label>Password		<input class="text" name="password" type="password" id="password" size="13" maxlength="25">-->
<!--        </label>-->
<!--        <input name="re" type="hidden" value="">-->
<!--        <input type="submit" class="button-secondary" name="Submit" id="submit" value="Log in">-->
<!--        (<a href="https://wordpress.org/support/bb-login.php">forgot?</a>) or <a href="https://wordpress.org/support/register.php">Register</a>-->
<!--    </p>-->
<!--</form>-->



<form class="login" method="post" action="check_login.php">
    <p>
        <label>Username		<input class="text" name="username" type="text" id="username" size="15" maxlength="50" value="">
        </label>
        <label>Password		<input class="text" name="password" type="password" id="password" size="15" maxlength="50">
        </label>
        <input name="re" type="hidden" value="">
        <input type="submit" class="button-secondary" name="Submit" id="submit" value="Log in">
        (<a href="Support/lostpassword.php">forgot?</a>) or <a href="Support/register.php">Register</a>
    </p>
</form>