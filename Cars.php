<!-- CITY TYPE CARS -->

<?php
    session_start();

    //including connect.php file
    require_once "Connect.php";

    //instead of warnings exceptions will be thrown
    mysqli_report(MYSQLI_REPORT_STRICT);

    //function for displaying error
    function handle_error($e) {
        echo '<span style="color:red;">Server error!</span>';
        echo '<br />Error info: '.$e;
    }

    //connection with database
    $connection = mysqli_connect($host, $db_user, $db_password, $db_name);

    //getting link type
    $link = $_GET['link'];

    //checking if conecction is valid
    if($connection->connect_errno != 0)
    {
        //throwing exception if connection failed
        echo 'mysqli_connect_errno()';
    }
    else
    {
        if($link == 'link1') 
        {
            //city type cars
            $result = $connection->query("SELECT * FROM vehicle WHERE Type='City'");
        }
        else if ($link == 'link2') 
        {
            //luxury type cars
            $result = $connection->query("SELECT * FROM vehicle WHERE Type='Luxury'");
        }
        else if ($link == 'link3') 
        {
            //sport type cars
            $result = $connection->query("SELECT * FROM vehicle WHERE Type='Sport'");
        }
        else if ($link == 'link4') 
        {
            //SUV type cars
            $result = $connection->query("SELECT * FROM vehicle WHERE Type='SUV'");
        }
    }

    //setting flag, validation correct
    $is_correct=true;

    //checking if user is logged in
    if (!(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true))
    {
        $is_correct = false;
        
        $_SESSION['e_logged_in'] = "Please log in first";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- ADDING FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    
    <!--   ADDING CSS FILE   -->
    <!-- Time solved problem with refreshing css file on site -->
    <link href="css\Cars.css?ts=<?=time()?>" rel="stylesheet" />

</head>
<body>
    <!--    HEADER    -->
    <header>

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

</header>

<!-- MAIN SECTION -->
<div class="main_section">

    <!-- Fetching data from rows -->
    <?php
        while($rows = $result->fetch_assoc())
    {
    ?>

    <div class="car_box">
        <div class="car_photo_div">
            <img src="Admin_panel/uploads/<?php echo $rows['Vehicle_ID'] ?>.jpg" alt="Car photo" class="car_photo">
        </div>

        <div class="car_title">
            <p><b><?php echo $rows['Brand'],' ', $rows['Model'];?></b></p>
        </div>

       <div class="car_description">
            <div class="car_details">
                
                <!-- ENGINE CAPACITY -->
                <p>
                    <b>Engine capacity: </b> <?php  echo $rows['Engine_capacity'];  ?> cm3
                </p>
    
                <!-- GEAR BOX -->
                <p>
                    <b>Gear box: </b> <?php echo $rows['Gear_box']; ?>
                </p>
    
                <!-- AC -->
                <p>
                    <b>A/C: </b><?php 
                    if ($rows['AC'] == 1)
                            echo 'Avaliable';
                        else
                            echo 'Not avaliable';?>
                </p>
    
                <!-- PROUCTION DATE -->
                <p>
                    <b>Production date: </b><?php echo $rows['Production_date'];?>
                </p>
    
                <!-- COST PER DAY -->
                <p>
                    <b>Cost per day: </b><?php echo $rows['Cost_per_day'];?> PLN
                </p>
            </div>
    
            <!-- BOOKING -->
            <div class="booking">
                <form action="Car_types/City_type.php">
                    <a href="Bookings.php?Vehicle_ID=<?php echo $rows['Vehicle_ID'];?>" class="book_now_button">Book now</a>
                </form>
                    
                    <div class="login_error">
                        <?php 
                        if(isset($_SESSION['e_logged_in']))
                        {
                            echo '<div class="error">'.$_SESSION['e_logged_in'].'</div>';
                            //clearing session variable
                            unset($_SESSION['e_logged_in']);
                        }
                        ?>
                    </div>
            </div>

        </div>

    </div>
    
    
    <?php
    }
    ?>
    
</div>

<!-- FOOTER -->
<footer>
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
    </footer>
</body>
</html>