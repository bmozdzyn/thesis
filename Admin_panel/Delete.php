<?php
$id = $_GET['id'];

session_start();

   /*  //If users is not allowed to see some sites
    if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] == true))
    {
        header('Location: Main_site.php');
        exit();
    } */

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

    //deleting vehicle from database
    if($connection->query("DELETE FROM vehicle WHERE Vehicle_ID = $id"))
    {
        header('Location: Admin_panel_vehicles.php');
    }
    else
    {
        handle_error($connection->error);
    }

    ///deleting file
    $file_name = 'uploads/'.$id.'.jpg';
    if(unlink($file_name))
    {
        echo 'The file' . $file_name . 'was deleted successfully';
    }
    else
    {
        echo 'Error while deleting the file ' . $file_name;
    }
?>