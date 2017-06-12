<html>
<body>

<?php
$mailTo = '<email-1,email-2>';

echo $mailTo;
echo '<br>';

$mailTo = ltrim($mailTo, '<');
echo $mailTo;
echo '<br>';

$mailTo = rtrim($mailTo, '>');
echo $mailTo;
echo '<br>';

$email_to_array = explode(',', $mailTo);

foreach($email_to_array as $key => $email)
{

    echo $email;
    echo "<br>";

}

?>

</body>
</html>