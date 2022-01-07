<!--Taking information about Users/Vehicles.. from database -->
<?php 

    session_start();

    //including connect.php file
    require_once "../Connect.php";

    //instead of warnings exceptions will be thrown
    mysqli_report(MYSQLI_REPORT_STRICT);

    //function for displaying error
    function handle_error($e) {
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
    else
    {
        ////////////// USERS ///////////
        //checking how many users exist
        $result = $connection->query("SELECT COUNT(People_ID) FROM people");
    
        $row_users = mysqli_fetch_assoc($result);
        $number_of_users = $row_users['COUNT(People_ID)'];

        ///////////// VEHICLES ////////
        //checking how many vehicles exist
        $result = $connection->query("SELECT COUNT(Vehicle_ID) FROM vehicle");

        $row_vehicles = mysqli_fetch_assoc($result);
        $number_of_vehicles = $row_vehicles['COUNT(Vehicle_ID)'];

        //////////// REVENUE //////////


        /////////// BOOKINGS /////////
        $result = $connection->query("SELECT COUNT(Rental_ID) FROM rental_details");
        $row_rentals = mysqli_fetch_assoc($result);
        $number_of_bookings = $row_rentals['COUNT(Rental_ID)'];
    }



    //close connection
    mysqli_close($connection);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!--   ADDING CSS FILE   -->
    <!-- Time solved problem with refreshing css file on site -->
    <link href="css/Admin_panel_dashboard.css?ts=<?=time()?>" rel="stylesheet" />
</head>
<body>
    <!-- Header -->
    <header>
        <!--Including header-->
        <?php include 'Admin_panel_header.php' ?>
    </header>
    
    <div class = "middle_section">
        
        <!-- Main content -->
            <ul class = "main_content">
                <li>
                    <div class = "box_users">
                        <br /><p>Users</p><br />
                            <p class = "numbers"><?php echo $number_of_users; ?></p>
                    </div>
                </li>
            
                <li>
                    <div class = "box_total_vehicles">
                        <br /><p>Total vehicles</p><br />
                            <p class = "numbers"><?php echo $number_of_vehicles; ?></p>
                    </div>
                </li>
            
                <li>
                    <div class = "box_revenue">
                        <br /><p>Revenue</p><br />
                    </div>
                </li>

                <li>
                    <div class = "box_bookings">
                        <br /><p>Bookings</p><br />
                        <p class = "numbers"><?php echo $number_of_bookings; ?></p>
                    </div>
                </li>

            </ul>
    </div>

</body>
</html>