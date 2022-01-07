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

        //current bookings for logged user
        $result = $connection->query("SELECT * FROM rental details WHERE Customer_ID=$current_user_id");
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

            <!-- Displaying user's booking data -->
            <table class="table">
                <tr>
                    <th>Model</th>
                    <th>Days hired</th>
                    <th>Initial date</th>
                    <th>Return date</th>
                    <th>Total cost</th>
                    <th>Cancel</th>
                </tr>

                <!-- Fetching data from rows -->
                <?php
                    while($rows = $result->fetch_assoc())
                    {
                ?>
                <tr>
                    <td><?php echo $rows['Model'];?></td>
                    <td><?php echo $rows['Hire_Days'];?></td>
                    <td><?php echo $rows['Hire_Date'];?></td>
                    <td><?php echo $rows['Return_date'];?></td>
                    <td><?php echo $rows['Total_cost'];?></td>
                    <?php echo "<td><a href='Delete.php?id=".$rows['Rental_ID']."'>Delete</a></td>";?>
                </tr>
                <?php
                    }
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