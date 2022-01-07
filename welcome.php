<?php

    session_start();

    if(!isset($_SESSION['registration_successful']))
    {
        header('Location: Main_site.php');
        exit();
    }
    else
    {
        unset($_SESSION['registration_successful']);
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Than you for registration</p>

    <p>You can now log in into your account</p>
    <a href="Log_in_part.php">Log in</a>

</body>
</html>