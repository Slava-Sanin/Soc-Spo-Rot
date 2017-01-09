<?php
session_start();

echo '<pre>';
echo "_POST ";
print_r($_POST);
echo "_SESSION ";
print_r($_SESSION);

$username = '';
$password = '';

if(isset($_POST['Register_Submit']))
{
    $_POST['user_login'] = trim($_POST['user_login']);
    $_POST['user_password'] = trim($_POST['user_password']);
    $_POST['confirm_password'] = trim($_POST['confirm_password']);
    $_POST['user_email'] = trim($_POST['user_email']);

    if(!empty($_POST['user_login']) && !empty($_POST['user_password']) && !empty($_POST['confirm_password']) && !empty($_POST['user_email']) )
    {
        if($_POST['user_password'] == $_POST['confirm_password'])
        {
            user_to_db();
        }
        else $_SESSION['error'] = "Password is not confirmed!";
    }
}

$_SESSION['user_login'] = $_POST['user_login'];
$_SESSION['user_email'] = $_POST['user_email'];
$_SESSION['user_fname'] = $_POST['user_fname'];
$_SESSION['user_lname'] = $_POST['user_lname'];
$_SESSION['user_country'] = $_POST['user_country'];

$host = $_SERVER['HTTP_HOST'];
header("Location: http://$host/My_Sites/SocSpoRot/Support/register.php");
exit();

/////////////////////////////////////////////////////////////////////////////
//                         insert new user into database
/////////////////////////////////////////////////////////////////////////////
function user_to_db()
{
    $user_login = $_POST['user_login'];
    $user_password = $_POST['user_password'];
    $user_email = $_POST['user_email'];
    $user_fname = !empty($_POST['user_fname']) ? $_POST['user_fname'] : '';
    $user_lname = !empty($_POST['user_lname']) ? $_POST['user_lname'] : '';
    $user_country = !empty($_POST['user_country']) ? $_POST['user_country'] : '';

    require_once('../mysqli_connect.php');

    //$query = "INSERT INTO users (first_name, last_name, email, login, password, user_id) VALUES (?, ?, ?, ?, ?, NULL)";

//////////////// Checking if no sach user with sach email ////////////////
    $query = "SELECT * FROM users WHERE username = '$user_login'";
    echo $query;
    $response = @mysqli_query($dbc, $query);

    if ($response->num_rows)
    {
        $_SESSION['error'] = "There is already a user with that name. Please choose another name!";

        echo 'count = ' . $response->num_rows;

        echo '<table align="left" cellspacing="5" cellpadding="8">                
                <tr>
                    <td align="left"><b>Username</b></td>
                    <td align="left"><b>Password</b></td>
                </tr>';

        // mysqli_fetch_array will return a row of data from the query
        // until no further data is available
        while($row = mysqli_fetch_array($response)){
            // if i am here - username and password is founded

            echo '<tr><td align="left">' .
                $row['user_login'] . '</td><td align="left">' .
                $row['user_password'] . '</td><td align="left">';
            echo '</tr>';
        }
        echo '</table>';

        mysqli_close($dbc);
        //header("Location: http://localhost:9090/My_Sites/SocSpoRot/Support/register.php");
        //exit();
        return;
    }
/////////////// insert new user to database ///////////////// new DateTime()
    $query = "INSERT INTO users (username, password, email, FirstName, FamilyName, country, registration_date) VALUES ('$user_login', MD5('$user_password'), '$user_email', '$user_fname', '$user_lname', '$user_country', CURRENT_DATE )";
    $response = @mysqli_query($dbc, $query);

    // If the query executed properly proceed
    if ($response){

        echo '<table align="left" cellspacing="5" cellpadding="8">                
                <tr>
                    <td align="left"><b>Username</b></td>
                    <td align="left"><b>Password</b></td>
                </tr>';

        // mysqli_fetch_array will return a row of data from the query
        // until no further data is available
        while($row = mysqli_fetch_array($response)){
            // if i am here - username and password is founded
            $_SESSION["username_and_password_is"] = true;
            echo '<tr><td align="left">' .
                $row['user_login'] . '</td><td align="left">' .
                $row['user_password'] . '</td><td align="left">';
            echo '</tr>';
        }
        echo '</table>';
        //echo "Пользователь зарегистрирован.";
        $_SESSION['error'] = "Welcome member!";
        mysqli_close($dbc);
        $host = $_SERVER['HTTP_HOST'];
        header("Location: http://$host/My_Sites/SocSpoRot/");
        exit();

    } else {

        echo "Couldn't issue database query"."<br/>";

        $_SESSION['error'] = mysqli_error($dbc);

    }

// Close connection to the database
    mysqli_close($dbc);

    ///////////////////////////////////////////////////////////////////////////////////

//    header("Location: http://localhost:9090/My_Sites/SocSpoRot/Support/register.php");
//    exit();
}

?>