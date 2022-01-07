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
        //everything from vehicle's table
        $result = $connection->query("SELECT * FROM people");
    }
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
    <link href="css/Admin_panel_users.css?ts=<?=time()?>" rel="stylesheet" />
</head>
<body>
    <!-- Header -->
    <header>
        <!--Including header-->
        <?php include 'Admin_panel_header.php' ?>
    </header>    

    <p class="people_title">PEOPLE</p>

    <div class = "middle_section">

    <!-- Displaying data about people -->
    <table class="table">
        <tr>
            <th>People ID</th>
            <th>Address ID</th>
            <th>First name</th>
            <th>Second name</th>
            <th>Email</th>
            <th>Phone number</th>
            <th>Username</th>
            <th>Password</th>
            <th>isAdmin</th>
            <th>Delete</th>
        </tr>

        <!-- Fetching data from rows -->
        <?php
            while($rows = $result->fetch_assoc())
            {
        ?>
            <tr>
                <td><?php echo $rows['People_ID'];?></td>
                <td><?php echo $rows['Address_ID'];?></td>
                <td><?php echo $rows['First_name'];?></td>
                <td><?php echo $rows['Second_name'];?></td>
                <td><?php echo $rows['Email'];?></td>
                <td><?php echo $rows['Phone_number'];?></td>
                <td><?php echo $rows['Username'];?></td>
                <td><?php echo $rows['Password'];?></td>
                <td><?php echo $rows['IsAdmin'];?></td>
                <?php echo "<td><a href='Delete_user.php?id=".$rows['People_ID']."'>Delete</a></td>"; ?>
            </tr>
        <?php
            }
        ?>
    </table>

    </div>


</body>
</html>