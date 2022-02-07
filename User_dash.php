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


    //checking if conecction is valid
    if($connection->connect_errno != 0)
    {
        //throwing exception if connection failed
        echo 'mysqli_connect_errno()';
    }
    else
    {
        //getting user's ID
        $current_user_id = $_SESSION['Actual_user_ID'];
        
        //getting customer id
        $result_33 = $connection->query("SELECT Customer_ID FROM customer WHERE People_ID=$current_user_id");
        while($rows_4 = $result_33->fetch_assoc()) {
        $customer_ID = $rows_4['Customer_ID'];
        }
        
        //if customer does not have any bookings other queries are not invoked
        if($customer_ID != NULL)
        {
            
            //current bookings for logged user
            $result_1 = $connection->query("SELECT * FROM rental_details WHERE Customer_ID=$customer_ID");
    
            //getting vehicle id
            $result_22 = $connection->query("SELECT Vehicle_ID FROM rental_details WHERE Customer_ID = $customer_ID");
            while($rows_3 = $result_22->fetch_assoc()){
                $vehicle_ID = $rows_3['Vehicle_ID'];
            }
    
            //getting brand
            $result_2 = $connection->query("SELECT Brand FROM vehicle WHERE Vehicle_ID = $vehicle_ID");
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User dashboard</title>

    <!-- Adding css file -->
    <link href="css/User_dash.css?ts=<?=time()?>" rel="stylesheet" />
    <!-- Header css -->
    <link href="includes/css/header.css?ts=<?=time()?>" rel="stylesheet" />
    <!-- Footer css -->
    <link href="includes/css/footer.css?ts=<?=time()?>" rel="stylesheet" />
</head>
<body>
    <head>

        <!-- Including header -->
        <?php
            include('includes/header.php');
        ?>
    </head>

    <main>
        <div class="main_content">
            <p class="title">Your bookings</p>

        <?php
            echo($current_user_id);
        ?>

            <!-- Displaying user's booking data -->
            <table class="table">
                <tr>
                    <th>Brand</th>
                    <th>Days hired</th>
                    <th>Initial date</th>
                    <th>Return date</th>
                    <th>Total cost</th>
                    <th>Cancel</th>
                </tr>

                <!-- Fetching data from rows -->
                <?php
                if(!empty($result_1))
                {
                    while($rows_1 = $result_1->fetch_assoc())
                    {

                        while($rows_2 = $result_2->fetch_assoc())
                        {
                ?>
                <tr>
                    <td><?php echo $rows_2['Brand'];?></td>
                    <td><?php echo $rows_1['Hire_days'];?></td>
                    <td><?php echo $rows_1['Hire_Date'];?></td>
                    <td><?php echo $rows_1['Return_date'];?></td>
                    <td><?php echo $rows_1['Total_cost'];?></td>
                    <?php echo "<td><a href='User_return.php?id=".$rows_1['Rental_ID']."'>Return vehicle</a></td>";?>
                </tr>
                <?php
                        }
                    }
                }
                else echo "<p class='no_bookings'>You have no bookings</p>";

                ?>

            </table>
            
        </div>

    </main>

    <footer>
        <!-- Including footer -->
        <?php
            include('includes/footer.php');
        ?>
    </footer>
</body>
</html>