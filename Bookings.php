<?php

    session_start();

    //Adding connect variables
    require_once "Connect.php";
    
    //instead of warnings exceptions will be thrown
    mysqli_report(MYSQLI_REPORT_STRICT);
    
    if(isset($_POST['submit']))
    {
        //setting flag, validation correct
        $is_correct = true;

        //getting logged user id from Check_if_lgn_corct.php
        $current_user_id = $_SESSION['Actual_user_ID'];

        //getting vehilce id which was chosen
        $current_vehicle_id = $_GET['Vehicle_ID'];

        // CHECKING DATES WHEN THE CAR IS RENTED //
        $connection = new mysqli($host, $db_user, $db_password, $db_name);
        if($connection->connect_errno!=0)
        {
            //throwing exception if connection failed
            echo 'mysqli_connect_errno()';
        }
        else
        {
            //info about Hire date
            $db_hire_date_result = $connection->query("SELECT Hire_date FROM rental_details WHERE Vehicle_ID = '$current_vehicle_id'");

            //info about return date
            $db_return_date_result = $connection->query("SELECT Return_date FROM rental_details WHERE Vehicle_ID = '$current_vehicle_id'");
        }

        //storing result into array
        while($db_hire_date = $db_hire_date_result->fetch_assoc())
        {
            $hire_date_array[] = $db_hire_date;
        }
        while($db_return_date = $db_return_date_result->fetch_assoc())
        {
            $return_date_array[] = $db_return_date;
        }
        
        // CHECKING PICK UP DATE //
        $pick_up_date = $_POST['pick_up_date'];
        // check if pick up date is between existing booking dates
        //if vehicle is already booked whenever
        if($db_hire_date != 0)
        {
            for($i = 0; $i < count($hire_date_array); $i++)
            {
                if (($pick_up_date >= $hire_date_array[$i]) && ($pick_up_date <= $return_date_array[$i]))
                {
                    echo "pick up date is between";
                    
                    $is_correct = false;
                    $_SESSION['e_pick_up_date'] = 'Vehicle is already rented on these days';
                } 
                else 
                {
                    echo "pick up date is not between";
                }
            }   
        }

        //CHECKING RETURN DATE
        $returning_date = $_POST['returning_date'];
        // check if return date is between exisiting bookinga dates
        //if vehicle is already booked whenever
        if($db_return_date != 0)
        {
            for($i = 0; $i < count($return_date_array); $i++)
            {
                if(($returning_date >= $hire_date_array[$i]) && ($returning_date <= $return_date_array[$i]))
                {
                    echo "return date is between";
        
                    $is_correct = false;
                    $_SESSION['e_return_date'] = 'Vehicles is already rented on these days';
                }
                else
                {
                    echo "return date is not between";        
                }
            }   
        }


        //how many days the car will be rented
        if(isset($_POST['pick_up_date']) && isset($_POST['returning_date']))
        {
            $connection = new mysqli($host, $db_user, $db_password, $db_name);
            if($connection->connect_errno!=0)
            {
                //throwing exception if connection failed
                echo 'mysqli_connect_errno()';
            }
            else
            {
                //getting info about vehicle cost from DB
                $db_vehicle_cost_result = $connection->query("SELECT Cost_per_day FROM vehicle WHERE Vehicle_ID = '$current_vehicle_id'");
            }

            //converting dates from string to datetime (needed to use diff() func)
            $pick_up_date = new DateTime($pick_up_date);
            $returning_date = new DateTime($returning_date);
            
            //how many days car will be booked
            $interval = $pick_up_date->diff($returning_date);
            $days_hired = $interval->days;

            //fetching data
            $db_vehicle_cost = $db_vehicle_cost_result -> fetch_assoc();
 
            if($days_hired > 3)
            {
                $total_cost = (int)$days_hired * (int)$db_vehicle_cost['Cost_per_day'] * 0.8;
            }
            else
            {
                $total_cost = (int)$days_hired * (int)$db_vehicle_cost['Cost_per_day'];
            }
            
        }

        // CHECKING DRIVING LICENSE NUMBER
        $driv_lic_num = $_POST['driv_lic_num'];
        //checking if driving license number is equal 16 chars
        if(strlen($driv_lic_num) != 16)
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_driv_lic_num'] = 'Length of the driving license number should be equal 16 chars';
        }
         
        //checking if all chars are alphanumeric
        if(ctype_alnum($driv_lic_num) == false)
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_driv_lic_num'] = 'Driving license number should consists of letters and numbers only';
        }

        
        //CHECKING INSURANCE ID
        $insurance_id = $_POST['insurance_id'];
        if(strlen($insurance_id) != 12)
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_insurance_id'] = 'Length of insurance id number should be equal 12 chars';
        }
          
        //checking if all chars are alphanumeric
        if(ctype_alnum($insurance_id) == false)
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_insurance_id'] = 'Insurance ID number should consist of letters and numbers only';
        }
          

        //CHECKING COLLISION COVERAGE
        $collision_coverage = $_POST['collision_coverage'];
        //checking if collsision coverage is between 100 and 10000000
        if(strlen($collision_coverage) < 3 || strlen($collision_coverage) > 8)
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_collision_coverage'] = 'Collision coverage should be between 100 and 10000000 $';
        }
          
        //CHECKING MEDICAL COVERAGE
        $medical_coverage = $_POST['medical_coverage'];
        //chekcing if medical coverage is between 100 an 1000000
        if(strlen($medical_coverage) < 3 || strlen($medical_coverage) > 8)
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_medical_coverage'] = 'Medical coverage should be between 100 and 1000000 $';
        }


        //function for displaying error
        function handle_error($e) 
        {
            echo '<span style="color:red;">Server error!</span>';
            echo '<br />Error info: '.$e;
        }

        if($is_correct == true)
        {
            echo "is_correct is true";
        }
        else if($is_correct == false)
        {
            echo "is_correct is false";
        }

        //EVERYTHING IS CORRECT
        if ($is_correct == true)
        {
            $connection = new mysqli($host, $db_user, $db_password, $db_name);
            if($connection->connect_errno!=0)
            {
                //throwing exception if connection failed
                echo 'mysqli_connect_errno()';
            }
            else
            {
                //getting info about current mileage from DB
                $db_initial_mileage_result = $connection->query("SELECT Current_mileage FROM vehicle WHERE Vehicle_ID = '$current_vehicle_id'");
                //fetching data
                $db_initial_mileage = $db_initial_mileage_result -> fetch_assoc();
                $initial_mileage = $db_initial_mileage['Current_mileage'];



                //converting dates to string format again (needed to put them in database)
                $pick_up_date = date_format($pick_up_date, 'Y-m-d');
                $returning_date = date_format($returning_date, 'Y-m-d');

                if($connection->query("INSERT INTO insurance (Collision_Coverage, 
                Medical_Coverage) VALUES ('$collision_coverage','$medical_coverage')"))
                {
                    //inserting into customer table
                    if($connection->query("INSERT INTO customer (People_ID, Driving_License_No, Insurance_id) VALUES ('$current_user_id', '$driv_lic_num',@@IDENTITY)"))
                    {
                        //inserting into rental_details table
                        if($connection->query("INSERT INTO rental_details (Vehicle_ID,Customer_ID, Hire_Date, Hire_Days, Total_cost, Return_date, Initial_mileage) VALUES ('$current_vehicle_id', @@IDENTITY, '$pick_up_date', '$days_hired', '$total_cost', '$returning_date','$initial_mileage')"))
                        {
                            //prevents from inserting data to the database while refreshing the page
                            $_SESSION['book_successful'] = true;
                            //header('Location: Bookings.php');
                            
                            echo "book succesful";
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
                else
                {
                    handle_error($connection->error);
                }
            }
            $connection->close();
        }
    }










/* session_start();

//if user is not logged in, then direct to log in site
if(!isset($_SESSION['logged_in']))
{
    header('Location: Log_in_part.php');
}

if (isset($_POST['insurance_id']))
//if (isset($_POST['driv_lic_num']))
{

    //including connect.php file
    require_once "Connect.php";

    //instead of warnings exceptions will be thrown
    mysqli_report(MYSQLI_REPORT_STRICT);

    //function for displaying error
    function handle_error($e) 
    {
        echo '<span style="color:red;">Server error!</span>';
        echo '<br />Error info: '.$e;
    }

    //connection with database
    $connection = mysqli_connect($host, $db_user, $db_password, $db_name);


    //checking if conecction is valid
    if($connection->connect_errno != 0)
    {
        //throwing exception if connection failed
        echo 'mysqli_connect_errno()';
    }

    //setting flag, validation correct
    $is_correct = true;

    //getting logged user id from Check_if_lgn_corct.php
    $current_user_id = $_SESSION['Actual_user_ID'];

    //getting vehilce id which was chosen
    $current_vehicle_id = $_GET['Vehicle_ID'];

    //how many days the car will be rented
    if(isset($_POST['pick_up_date']) && isset($_POST['returning_date']))
    {
        $interval = $pick_up_date->diff($returning_date);
        $days_hired = $interval->days;

        if($days_hired > 3)
        {
            //$total_cost =
        }
    }

        //CKECKING DATES
        $result = ("SELECT * FROM rental_details WHERE (
            :HireDate BETWEEN Hire_date AND Return_date
            OR :ReturnDate BETWEEN Hire_date AND Return_Date
            OR Hire_date BETWEEN :HireDate AND :ReturnDate)");
        
        //CHECKING DRIVING LICENSE NUMBER
        //checking if driving license number is equal 16 chars
        if(strlen($driv_lic_num) != 16)
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_driv_lic_num'] = 'Length of the driving license number should be equal 16 chars';
        }
        
        //checking if all chars are alphanumeric
        if(ctype_alnum($driv_lic_num) == false)
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_driv_lic_num'] = 'Driving license number should consists of letters and numbers only';
        }
        
        //CHECKING INSURANCE ID
        if(strlen($insurance_id) != 12)
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_insurance_id'] = 'Length of insurance id number should be equal 12 chars';
        }
        
        //checking if all chars are alphanumeric
        if(ctype_alnum($insurance_id))
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_insurance_id'] = 'Insurance ID number should consist of letters and numbers only';
        }
        
        //CHECKING COLLISION COVERAGE
        //checking if collsision coverage is between 100 and 10000000
        if(strlen($collision_coverage) < 100 || strlen($collision_coverage) > 10000000)
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_collision_coverage'] = 'Collision coverage should be between 100 and 10000000 $';
        }
        
        //CHECKING MEDICAL COVERAGE
        //chekcing if medical coverage is between 100 an 1000000
        if(strlen($medical_coverage) < 100 || strlen($medical_coverage) > 10000000)
        {
            $is_correct = false;
            //setting error
            $_SESSION['e_medical_coverage'] = 'Medical coverage should be between 100 and 1000000 $';
        }

        echo "qweqeqweqweq";
        echo $is_correct;
        
        //Everything is correct
        if($is_correct == true && isset($_SESSION['book_button']) == isset($_POST['book_button']))
        //if($is_correct == true)
        {
            //inserting into insurance table
            if($connection->query("INSERT INTO insurance (Collision_Coverage, 
            Medical_Coverage) VALUES ('$collision_coverage','$medical_coverage')"))
            {
                //inserting into customer table
                if($connection->query("INSERT INTO customer (People_ID, Driving_License_No, Insurance_id) VALUES ('$current_user_id', '$driv_lic_num',@@IDENTITY)"))
                {
                    //inserting into rental_details table
                    if($connection->query("INSERT INTO rental_details (Vehicle_ID,Customer_ID, Hire_Date, Hire_Days, Total_cost, Return_date) VALUES ('$current_vehicle_id', @@IDENTITY, '$pick_up_date', '$days_hired', '$total_cost', '$returning_date')"))
                    {
                        $_SESSION['book_successful'] = true;
                        echo "book succesful";
                        header('Location: User_dash.php');
                    }
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
        else
        {
            handle_error($connection->error);
        }

    $connection->close();
    
} */
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings</title>

    <!--   ADDING CSS FILE   -->
    <!-- Time solved problem with refreshing css file on site -->
    <link href="css/Bookings.css?ts=<?=time()?>" rel="stylesheet" /> 

</head>
<body>
    <header>
        <!-- INCLUDING HEADER -->
        <?php
            //does not work
            /* include 'includes/header.php'; */
        ?>

    <div class="header">
        <!--   LOGO   -->
        <!--<a href="Main_site.php" >-->
        <img src="img/logo/LOGO.png" alt="LOGO" class="logo">
        <!--</a>-->

        <!--   home, about, contacts -->
        <nav class="nav_menu">
            <ul>

                <li>
                    <a href="Main_site.php" class="home_button">HOME</a>
                </li>

                <li>
                    <a href="" class="about_button">ABOUT</a>
                </li>

                <li>
                    <a href="" class="contacts_button">CONTACTS</a>
                </li>

            </ul>
        </nav>

        <!-- Log in button directing to log in page/ Log out button -->
            <?php
                if(isset($_SESSION['logged_in']))
                {
                    echo '<form action="Logout.php" method="POST" >
                    <button type="submit" class="login_button">SIGN OUT
                </form>';
                }   
                else
                {
                    echo '<form action="Log_in_part.php" method="POST" >
                    <button type="submit" class="login_button">LOG IN/SIGN IN
                </form>';
                }
            ?>
        </div>
    </header>

    <main>
        <form method="post">
        <div class="booking_dates">
            <div class="">
                <p>If you rent for more than 3 days you get 20% discount</p>
            </div>

            <div class="pick_up_date_div">
                <label for="pick_up_date">
                    Choose date of picking up the car
                </label> 
                <input type="date" id="pick_up_date" name="pick_up_date">

                <!-- Displaying error -->
                <?php
                    if(isset($_SESSION['e_pick_up_date']))
                    {
                        echo '<div class="error">'.$_SESSION['e_pick_up_date'].'</div>';
                        //clearing session variable
                        unset($_SESSION['e_pick_up_date']);
                    }
                ?>
            </div>

            <div class="returning_date_div">
                <label for="returning_date">
                    Choose date of the return of the car
                </label>
                <input type="date" id="returning_date" name="returning_date">

                <!-- Displaying error -->
                <?php
                    if(isset($_SESSION['e_returning_date']))
                    {
                        echo '<div class="error">'.$_SESSION['e_returning_date'].'</div>';
                        //clearing session variable
                        unset($_SESSION['e_returning_date']);
                    }
                ?>
            </div>
        </div>

        <div class="additional_customer_inf">
            <p><b>We need additional informations from you</b></p>
            <div class="driv_lic_num_div">
                <label for="driv_lic_num">
                    Driving license number
                </label>
                <input type="text" id="driv_lic_num" name="driv_lic_num">

                <!-- Displaying error -->
                <?php
                    if(isset($_SESSION['e_driv_lic_num']))
                    {
                        echo '<div class="error">'.$_SESSION['e_driv_lic_num'].'</div>';
                        //clearing session variable
                        unset($_SESSION['e_driv_lic_num']);
                    }
                ?>
            </div>

            <div class="insurance_id_div">
                <label for="insurance_id">
                    Insurance ID
                </label>
                <input type="text" id="insurance_id" name="insurance_id">

                <!-- Displaying error -->
                <?php
                    if(isset($_SESSION['e_insurance_id']))
                    {
                        echo '<div class="error">'.$_SESSION['e_insurance_id'].'</div>';
                        //clearing session variable
                        unset($_SESSION['e_insurance_id']);
                    }
                ?>
            </div>

            <div class="collision_coverage_div">
                <label for="collision_coverage">
                    Insurance collision coverage
                </label>
                <input type="number" id="collision_coverage" name="collision_coverage">

                <!-- Displaying error -->
                <?php
                    if(isset($_SESSION['e_collision_coverage']))
                    {
                        echo '<div class="error">'.$_SESSION['e_collision_coverage'].'</div>';
                        //clearing session variable
                        unset($_SESSION['e_collision_coverage']);
                    }
                ?>
            </div>

            <div class="medical_coverage_id">
                <label for="medical_coverage">
                    Insurance medical coverage
                </label>
                <input type="number" id="medical_coverage" name="medical_coverage">

                <!-- Displaying error -->
                <?php
                    if(isset($_SESSION['e_medical_coverage']))
                    {
                        echo '<div class="error">'.$_SESSION['e_medical_coverage'].'</div>';
                        //clearing session variable
                        unset($_SESSION['e_medical_coverage']);
                    }
                ?>
            </div>
        </div>

        <div class="book_button_div">
            <input type="submit" class="book_button" value="Book now" name="submit">
        </div>
        </form>
    </main>

    <footer>
        <!-- INCLUDING FOOTER -->
        <?php
            //does not work
            /* include 'includes/Footer.php'; */
        ?>

        <div class="footer">
            <div class="contact_menu">
                    <ul>
                        <li><b>Contact: </b></li>
                        <li>Telephone: 6621789031</li>
                        <li>e-mail: car</li>
                    </ul>
                </div>

                <div class="social_media_menu">
                    <ul>
                        <li><b>Social Networks: </b></li>
                        <li>Facebook</li>
                        <li>Instagram</li>
                    </ul>
                </div>
        </div>
    </footer>
</body>
</html>