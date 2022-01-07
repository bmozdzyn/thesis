<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <!--   ADDING CSS FILE   -->
    <!-- Time solved problem with refreshing css file on site -->
    <link href="css/Admin_panel.css?ts=<?=time()?>" rel="stylesheet" />

</head>

<body>
    <!-- Header -->
    <header>
        <!--Including header-->
        <?php include 'Admin_panel_header.php' ?>
    </header>

    
        <!-- Main menu -->
        <div class = "nav_menu">
            <!--Including menu-->
           <?php include 'Admin_panel_menu.php' ?>
        </div>    



</body>
</html>