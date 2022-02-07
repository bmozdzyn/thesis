<!-- CHECKING IF GIVEN LOGIN AND PASSWORD ARE CORRECT -->


<?php

    session_start();

    //If the account is not log in, then direct to log in site
    if((!isset($_POST['login'])) || (!isset($_POST['password'])))
    {
        header('Location: Log_in_part.php');
        exit();
    }

     //Directing to the main page if logged in
     //If users is not allowed to see some sites
     if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] == true))
     {
         header('Location: Main_site.php');
         exit();
     }

    //DIFFERENCE BETWEEN REQUIRE AND INCLUDE
    //require is used instead of include because if file cannot be openned the require will stop the program
    //include will show an error and go through the code


    //DIFFERENCE BETWEEN REQUIRE AND REQUIRE_ONCE
    //require_once means that the file will be add only once
    //php will check if the file was not included before
    //if so then the lines will not be included again


    //including connect.php file
    require_once "Connect.php";

    //connection with database
    //mysqli is a contructor

    //@ - error control operator - in case of an error, php will not show any errors on the screen
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);


    //checking if conecction is valid
    //connect_erno=0 - means that last attempt to connect with database was successful
    if ($connection->connect_errno != 0)
    {
        echo "Error: ".$connection->connect_errno."Description: ".$connection->connect_error;
    }
    else
    {
        //initializing login and password
        //getting them from Log_in_part.php POST method
        $login  = $_POST['login'];
        $password = $_POST['password'];
        //
        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        $password = htmlentities($password, ENT_QUOTES, "UTF-8");

        //sending query to databse
        //checking if query was correctly done
        if ($result = @$connection->query(sprintf("SELECT * FROM people WHERE BINARY
            Username = '%s' AND Password = '%s'",
            mysqli_real_escape_string($connection, $login),
            mysqli_real_escape_string($connection, $password))))
        {
            //checking how many users have given username and password
            $how_many_users = $result->num_rows;

            if($how_many_users > 0)
            {
                //setting a flag for logged user
                $_SESSION['logged_in'] = true;
                header('Location: Main_site.php');


                //table for storing columns taken from database
                //fetch_assoc() - returns an associative array of strings that corresponds
                //to the fetched row, or false if there are no more rows.
                $row = $result->fetch_assoc();
                
                //taking id from associated table to know which user is currently logged
                $username = $row['People_ID'];
                //passing to another page (booking)
                $_SESSION['Actual_user_ID'] = $username;

                //checking if its an admin
                $admin = $row['IsAdmin'];
                //passing to main page
                if($admin == '1')
                    $_SESSION['Admin_is_logged'] = $admin;

                //freeing memory
                $result->free_result();

                //freeing memory
                //unset($_SESSION['error']);
            }
            else
            {
                //Invalid Username or password
                $_SESSION['error'] = '<span style = "color:red"> Invalid login or Password!</span>';
                //Moving back to Log in part
                header('Location: Log_in_part.php');
            }
        }

        //closing the connection between database
        $connection->close();
    }


?>