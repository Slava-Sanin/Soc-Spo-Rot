<?php

    $user_login = "a";

    $token = md5(uniqid($user_login, true));
    echo $token;
    echo '<br>';

//    mkdir('folder');

    $host = $_SERVER['HTTP_HOST'];
    $path = "../Customers/";
    $myfile = fopen("$path$token.php", "w") or die("Unable to open file!");

    $txt = "
            <?php
            
            require_once('mysqli_connect.php');
            
            $query = \"SELECT username, password FROM users\";
            
            $response = @mysqli_query($dbc, $query);
            
            if($response){
            
            //                echo '<table align=\"left\" cellspacing=\"5\" cellpadding=\"8\">
            //                            <tr>
            //                                <td align=\"left\"><b>Username</b></td>
            //                                <td align=\"left\"><b>Password</b></td>
            //                            </tr>';
            //
            //                // mysqli_fetch_array will return a row of data from the query
            //                // until no further data is available
            //                while($row = mysqli_fetch_array($response)){
            //
            //                echo '<tr><td align=\"left\">' .
            //                $row['username'] . '</td><td align=\"left\">' .
            //                $row['password'] . '</td><td align=\"left\">';
            //                echo '</tr>';
            //                }
            //
            //                echo '</table>' . '<br />';

            } else {

                      echo \"Couldn't issue database query<br />\";

                      echo mysqli_error($dbc);

                   }

            mysqli_close($dbc);

            ?>
    ";

    fwrite($myfile, $txt);
    $txt = "Jane Doe\n";
    fwrite($myfile, $txt);
    fclose($myfile);


?>