<?php
$id = $_GET['id'];

session_start();

    //If users is not allowed to see some sites
    if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] == true))
    {
        header('Location: Main_site.php');
        exit();
    }



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

    $result = $connection->query("SELECT Customer_ID FROM rental_details WHERE Rental_ID = $id");
    while($rows = $result->fetch_assoc()){
        $customer_id = $rows['Customer_ID'];
    }
    $result_2 = $connection->query("SELECT Insurance_ID FROM customer WHERE Customer_ID = $customer_id");
    while($rows_2 = $result_2->fetch_assoc()){
        $insurance_id = $rows_2['Insurance_ID'];
    }

    //returning vehicle 
    if($connection->query("DELETE FROM rental_details WHERE Rental_ID = $id"))
    {
        if($connection->query("DELETE FROM customer WHERE Customer_ID = $customer_id"))
        {
            if($connection->query("DELETE FROM insurance WHERE Insurance_ID = $insurance_id"))
            {
                header('Location: User_dash.php');
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
?>

"DELETE FROM rental_details WHERE Rental_ID = $id"

"DELETE FROM customer WHERE Customer_ID = $customer_id"

"DELETE FROM insurance WHERE Insurance_ID = $insurance_id"