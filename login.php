
<form class="login" method="post" action="check_login.php">
    <p>
        <label>Username		<input class="text" name="username" type="text" id="username" size="15" maxlength="50" required value="" >
        </label>
        <label>Password		<input class="text" name="password" type="password" id="password" size="15" required maxlength="50" >
        </label>
        <input name="re" type="hidden" value="">
        <input type="submit" class="button-secondary" name="Submit" id="submit" value="Log in" onclick="check_login_input();">
        <span>(<a href="Support/lostpassword.php">forgot?</a>) or  <a href="Support/register.php">&nbsp;Register</a></span>
    </p>
</form>

<script type="text/javascript">

    function check_login_input()
    {
        var blocked_chars = "\ '@#~`!%&|.,+?(){}[]^$:;*<>=/";
        var first_username = $("#username").val();
        var first_password = $("#password").val();

        var username = my_filter(first_username, blocked_chars);
        var password = my_filter(first_password, blocked_chars);

        console.log("first_username: ",first_username);
        console.log("first_password: ",first_password);
        console.log("username: ",username);
        console.log("password: ",password);

        if ((first_username == username) && (first_password == password)) return true;
        else {
                //$("#submit").click(function(event){ event.preventDefault(); event.stopPropagation(); });
                event.preventDefault(); event.stopPropagation();
                return false;
             }
    }

    //////////////////// Filtering blocked chars in login ////////////////////
    function my_filter(string, regex_chars)
    {
        for (var i=0; i<regex_chars.length; i++)
        {
            let char = regex_chars[i];
            string = string.replace(char, '');
            console.log(string);
        }
        return string;
    }

</script>