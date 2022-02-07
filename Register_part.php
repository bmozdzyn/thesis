<?php
    session_start();

    //checking if submit is clicked
    //if email_register exist it means that submit is clicked
    //checking only one value because other variables should also exist
    //because the form is sent in full (the values of all fields are read)
    
    //isset is checking only if container for variable exist
    //so if email container will be empty, function will return true
    if (isset($_POST['email']))
    {
        //setting flag, validation correct
        $is_correct=true;

        //regular expressions - for polish characters
        $regularExpression = "/^[a-zA-ZąęćżźńłóśĄĆĘŁŃÓŚŹŻ\s]+$/";

        //   CHECKING USERNAME   //
        $username = $_POST['username'];
        //checking if username has between 5 and 20 chars
        if((strlen($username)<5) || (strlen($username)>20))
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_username'] = 'The length of the username should be between 5 and 20 characters';
        }

        //checking if all chars are alphanumeric
        if(ctype_alnum($username) == false)
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_username'] = "Username should consist of letters and numbers only";
        }


        //   CHECKING EMAIL ADDRESS   //
        $email = $_POST['email'];

        //emailC - email after sanitization
        $emailC = filter_var($email,FILTER_SANITIZE_EMAIL);

        //checing if email after sanitization is different then previous one
        if((filter_var($emailC, FILTER_VALIDATE_EMAIL) == false) || ($emailC!=$email))
        {
            $is_correct = false;
            $_SESSION['e_email'] = "E-mail address is incorrect";
        }



        //   CHECKING PASSWORD   //
        $password_1 = $_POST['password_1'];
        $password_2 = $_POST['password_2'];
        
        //checking if password is between 8 and 20 chars
        if ((strlen($password_1) < 8) || (strlen($password_1) > 20))
        {
            $is_correct = false;
            $_SESSION['e_password_1'] = "Password has to be from 8 to 20 characters long";
        }

        //checking if second password is the same
        if($password_1 != $password_2)
        {
            $is_correct = false;
            $_SESSION['e_password_2'] = "Given passwords are not the same";
        }

        
        //     CHECKING FIRST NAME     //
        $first_name = $_POST['first_name'];
        //checking if first name has between 2 and 20 chars
        if((strlen($first_name)<2) || (strlen($first_name)>20))
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_first_name'] = 'The length of the first name should be between 2 and 20 characters';
        }

        //checking if all chars are alphanumeric
        //if(ctype_alnum($first_name) == false)
        if(preg_match($regularExpression, $first_name) == false)
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_first_name'] = "First name should consist of letters only";
        }

        
        //     CHEKCING SECOND NAME     //
        $second_name = $_POST['second_name'];
        //checking if second name has between 5 and 20 chars
        if((strlen($second_name)<5) || (strlen($second_name)>20))
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_second_name'] = 'The length of the second name should be between 5 and 20 characters';
        }

        //checking if all chars are alphanumeric
        if(preg_match($regularExpression, $second_name) == false)
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_second_name'] = "Second name should consist of letters only";
        }


        //     CHEKCING PHONE NUMBER     //
        $phone_number = $_POST['phone_number'];
        //checking if phone number is 9 digits long
        if (strlen($phone_number) != 9)
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_phone_number'] = "Phone nunber should consist of 9 digits"; 
        }

        //checking if string consists of digits only  
        if(filter_var($phone_number, FILTER_VALIDATE_INT) == false)
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_phone_number'] = "Phone number should consist only of digits";
        }


        //Checking CITY //
        $city = $_POST['city'];
        //checking if city has between 5 and 20 chars
        if((strlen($city)<3) || (strlen($city)>20))
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_city'] = 'The length of the city should be between 3 and 20 characters';
        }

        //checking if all chars are alphanumeric
        if(preg_match($regularExpression, $city) == false)
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_city'] = "City should consist of letters only";
        }


        //CHECKING ZIPCODE//
        $zipcode = $_POST['zipcode'];
        //checking if zip code is 5 digits long
        if (strlen($zipcode) != 5)
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_zipcode'] = "Zip code should consist of 5 digits"; 
        }


        //CHECKING STREET//
        $street = $_POST['street'];
        //checking if street has between 5 and 20 chars
        if((strlen($street)<5) || (strlen($street)>20))
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_street'] = 'The length of the street should be between 5 and 20 characters';
        }

        //checking if all chars are alphanumeric
        if(preg_match($regularExpression, $street) == false)
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_street'] = "Street should consist of letters only";
        }


        //CHECING HOUSE NUMBER//
        $house_number = $_POST['house_number'];
        //checking if house number is between 1 to 4 digits long
        if((strlen($house_number)<1) || (strlen($house_number)>4))
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_house_number'] = 'House number should be of 1 to 4 digits long';
        }


        //Adding connect variables
        require_once "Connect.php";

        //instead of warnings exceptions will be thrown
        mysqli_report(MYSQLI_REPORT_STRICT);
        
        //function for displaying error
        function handle_error($e) {
            echo '<span style="color:red;">Server error!</span>';
            echo '<br />Error info: '.$e;
        }

        //EVERYTHING IS CORRECT
        if ($is_correct == true)
        {
            //trying to select data from db
            $connection = new mysqli($host, $db_user, $db_password, $db_name);
            if($connection->connect_errno!=0)
            {
                //throwing exception if connection failed
                echo 'mysqli_connect_errno()';
            }
            else
            {
                //check if email already exist
                $result = $connection->query("SELECT COUNT(People_ID) FROM people WHERE Email='$email'");

                if(!$result)
                {
                    handle_error($connection->error);
                }

                    //check how many emails are the same in the data base
                    $row_emails = mysqli_fetch_assoc($result);
                    $number_of_emails = $row_emails['COUNT(People_ID)'];
                            
                    /* $number_of_emails = $result->num_rows; */
                    if($number_of_emails > 0)
                    {
                        $is_correct = false;
                        $_SESSION['e_email'] = "Account with this email already exists";
                    }

                    //check if username already exist
                    $result = $connection->query("SELECT COUNT(People_ID) FROM people where Username='$username'");

                    if(!$result)
                    {
                        handle_error($connection->error);
                    }

                    //check how many usernames are the same in the data base
                    $row_usernames = mysqli_fetch_assoc($result);
                    $number_of_usernames = $row_usernames['COUNT(People_ID)'];

                    if($number_of_usernames > 0)
                    {
                        $is_correct = false;
                        $_SESSION['e_username'] = "Account with this username already exists";
                    }

                    if($number_of_emails == 0 && $number_of_usernames == 0)
                        {
                            //adding user to database
                            if($connection->query("INSERT INTO address (City, ZipCode, Street, House_number) VALUES('$city','$zipcode','$street', '$house_number')"))
                            {
                                if($connection->query("INSERT INTO people (First_name, Second_name, Email, Phone_number, Username, Password, isAdmin, Address_ID) VALUES('$first_name','$second_name','$email','$phone_number','$username','$password_1','0', @@IDENTITY)"))
                                {
                                    $_SESSION['registration_successful'] = true;
                                    header('Location: welcome.php');
                                }
                                else
                                {
                                    handle_error($connection->error);
                                }
                            }
                            else
                            {
                                handle_error($connection->error);
                            }
                        }

                $connection->close();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Adding css file -->
    <link href="css/register_part.css?ts=<?=time()?>" rel="stylesheet" />
</head>
<body>

    <p>Create your account</p>

    <form method="post">

        <div class = "register_container">
                
            <!-- USERNAME -->
                <div class="username_label">
                    <label for="username">Username: </label>
                </div>

                <div class="username_div">
                    
                    <input type="text" id ="username" name="username"><br /> <br />
                    
                    <!--Displaying username error-->
                    <?php
                        if(isset($_SESSION['e_username']))
                        {
                            echo '<div class="error">'.$_SESSION['e_username'].'</div>';
                            //clearing session variable
                            unset($_SESSION['e_username']);
                        }
                    ?>
                </div>
            <!-- -->

            <!-- EMAIL -->
                <div class="email_label">
                    <label for="email">E-mail: </label>
                </div>

                <div class="email_div">

                    <input type="text" id="email" name="email"><br /> <br />
                    
                    <!--Displaying email error -->
                    <?php
                        if(isset($_SESSION['e_email']))
                        {
                            echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                            //clearing session variable
                            unset($_SESSION['e_email']);
                        }
                    ?>
                </div>
            <!-- -->            

            <!-- FIRST NAME -->
                <div class="first_name_label">
                    <label for="first_name">First Name:</label>
                </div>

                <div class="first_name_div">

                    <input type = "text" id = "first_name" name = "first_name"><br /><br /> 
                        
                    <!--Displaying First name error-->
                    <?php
                        if(isset($_SESSION['e_first_name']))
                        {
                            echo '<div class="error">'.$_SESSION['e_first_name'].'</div>';
                            //clearing session variable
                            unset($_SESSION['e_first_name']);
                        }
                    ?>
                </div>
            <!-- -->
            
            <!-- SECOND NAME -->
                <div class="second_name_label">
                    <label for="second_name">Second Name:</label>
                </div>

                <div class="second_name_div">
                    
                    <input type="text" id = "second_name" name = "second_name"><br /><br />
                    
                    <!--Displaying Second name error-->
                    <?php
                        if(isset($_SESSION['e_second_name']))
                        {
                            echo '<div class="error">'.$_SESSION['e_second_name'].'</div>';
                            //clearing session variable
                            unset($_SESSION['e_second_name']);
                        }
                    ?>
                </div>
            <!-- -->
        
            <!-- PHONE -->
                <div class="phone_label">
                    <label for="phone_number">Phone Number:</label>
                </div>

                <div class="phone_div">
                    
                    <input type="number" id= "phone_number" name = "phone_number"> <br /><br />
            
                    <!--Displaying Phone number error-->
                    <?php
                        if(isset($_SESSION['e_phone_number']))
                        {
                            echo '<div class="error">'.$_SESSION['e_phone_number'].'</div>';
                            //clearing session variable
                            unset($_SESSION['e_phone_number']);
                        }
                    ?>

                </div>
            <!-- -->

            <!-- CITY -->
                <div class="city_logo">
                    <label for="city">City:</label>    
                </div>

                <div class="city_div">
                    
                    <input type="text" id = "city" name = "city"> <br /><br />
                    
                    <!--Displaying city error -->
                    <?php
                        if(isset($_SESSION['e_city']))
                        {
                            echo '<div class="error">'.$_SESSION['e_city'].'</div>';
                            //clearing session variable
                            unset($_SESSION['e_city']);
                        }
                    ?>

                </div>
            <!-- -->

            <!-- ZIPCODE-->
                <div class="zipcode_label">
                    <label for="zipcode">ZipCode:</label>
                </div>

                <div class = "zipcode_div">

                    <input type="number" id="zipcode" name = "zipcode"> <br /><br />
            
                    <!--Displaying zipcode error -->
                    <?php
                        if(isset($_SESSION['e_zipcode']))
                        {
                            echo '<div class="error">'.$_SESSION['e_zipcode'].'</div>';
                            //clearing session variable
                            unset($_SESSION['e_zipcode']);
                        }
                    ?>

                </div>
            <!-- -->
        
            <!-- STREET -->
                <div class="street_logo">
                    <label for="street">Street:</label>
                </div>

                <div class = "street_div">
                    
                    <input type="text" id="street" name = "street"> <br /><br />
            
                    <!--Displaying street error -->
                    <?php
                        if(isset($_SESSION['e_street']))
                        {
                            echo '<div class="error">'.$_SESSION['e_street'].'</div>';
                            //clearing session variable
                            unset($_SESSION['e_street']);
                        }
                    ?>

                </div>
            <!-- -->
        
            <!-- HOUSE NUMBER -->
                <div class="house_number_label">
                    <label for="house_number">House number:</label>
                </div>

                <div class="house_number_div">
                    
                    <input type="number" id="house_number" name="house_number"> <br /><br />
                    
                    <!--Displaying House_number error -->
                    <?php
                        if(isset($_SESSION['e_house_number']))
                        {
                            echo '<div class="error">'.$_SESSION['e_house_number'].'</div>';
                            //clearing session variable
                            unset($_SESSION['e_house_number']);
                        }
                    ?>

                </div>
            <!-- -->


            <!-- PASSWORD 1 -->
                <div class="password_1_label">
                    <label for="password_1">Password:</label>
                </div>

                <div class="password_1_div">
                    
                    <input type="password" id="password_1" name="password_1"><br /><br />
                        
                    <!--Displaying password error-->
                    <?php
                            if(isset($_SESSION['e_password_1']))
                            {
                                echo '<div class = "error">'.$_SESSION['e_password_1'].'</div>';
                                //clearing session value
                                unset($_SESSION['e_password_1']);
                            }
                
                    ?>

                </div>
            <!-- -->
            
            <!-- PASSWORD 2 -->
                <div class="password_2_label">
                    <label for="password_2">Confrim password:</label>
                </div>

                <div class = "password_2_div">
                    <input type="password" id="password_2" name="password_2"><br /><br />
                
                    <!--Displaying second password error-->
                    <?php
                            if(isset($_SESSION['e_password_2']))
                            {
                                echo '<div class = "error">'.$_SESSION['e_password_2'].'</div>';
                                //clearing session value
                                unset($_SESSION['e_password_2']);
                            }
                    ?>

                </div>
            <!-- -->
                
                <div><!--Empty div --></div>

            <!-- BUTTONS -->
                <div class = "buttons">

                    <div class="inside_buttons">
                        <input type="submit" class="register_button" value="Register" />
                        <a href="Main_site.php" class="cancel_button">Cancel</a>
                    </div>

                </div>
                <!-- -->
                
        </div>

    </form>

</body>
</html>