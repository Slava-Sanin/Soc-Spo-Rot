<?php

    $user_login = $_GET['username'];
    $token = $_GET['token'];
    $host = $_SERVER['HTTP_HOST'];

    require_once('../mysqli_connect.php');

    $query = "SELECT * FROM  users WHERE username = '$user_login' AND token = '$token'";
    $response = @mysqli_query($dbc, $query);
    if ($response->num_rows)
    {
        //echo $response->num_rows;
        $query = "UPDATE users SET activated = '1' WHERE token = '$token'";
        $response = @mysqli_query($dbc, $query);
        if ($response)
        {
            echo "<script type=\"text/javascript\">";
//            echo "alert('Your account was activated! You can login in Soc-Spo-Rot.com and anjoy playing the logical games.');";
            echo "alert('Now you are registered. Welcome member!.');";
            //echo "window.location.assign('http://$host/My_Sites/SocSpoRot/');";
            echo "window.location.assign('../');";
            echo "</script>";
//        header("Location: ../");
        }
        else
        {
            echo mysqli_error($dbc);
        }
    }
    else
    {
        echo "The token is not exist!";
    }

    mysqli_close($dbc);
?>


