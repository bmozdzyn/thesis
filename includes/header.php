<html>
    <head> 
        <!--   ADDING CSS FILE   -->
        <!-- Time solved problem with refreshing css file on site -->
        <link href="css/header.css?ts=<?=time()?>" rel="stylesheet" />
    </head>

    <body>
        <div class="header">
        <!--   LOGO   -->
        <!--<a href="Main_site.php" >-->
        <img src="../img/logo/LOGO.png" alt="LOGO" class="logo">
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

            <?php
                if(isset($_SESSION['Actual_user_ID']))
                {
                    if(isset($_SESSION['Admin_is_logged']))
                    {
                        echo '<li>
                                <a href="Admin_panel/Admin_panel_dashboard.php" class="dashboard_button">DASHBOARD</a>
                            </li>';
                    }
                    else
                    {
                        echo '<li>
                                <a href="User_dash.php" class="bookings_button">MY BOOKINGS</a>
                            </li>';
                    }
                }
            ?>

            <!-- Log in button directing to log in page/ Log out button -->
            <?php
                if(isset($_SESSION['logged_in']))
                {
                    echo '<li><form action="Logout.php" method="POST" >
                    <button type="submit" class="login_button">SIGN OUT
                </form></li>';
                }   
                else
                {
                    echo '<li><form action="Log_in_part.php" method="POST" >
                    <button type="submit" class="login_button">LOG IN/SIGN IN
                </form></li>';
                }
            ?> 

        </ul>
    </nav>

        
        <!-- Hamburger menu -->
        <div class="hamburger">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
            
            <ul class="mobile_menu">
                <li>
                    <a href="Main_site.php" class="home_button">HOME</a>
                </li>
                
                <li>
                    <a href="" class="about_button">ABOUT</a>
                </li>
                
                <li>
                    <a href="" class="contacts_button">CONTACTS</a>
                </li>
                
                <?php
                    if(isset($_SESSION['Actual_user_ID']))
                    {
                        if(isset($_SESSION['Admin_is_logged']))
                        {
                            echo '<li>
                            <a href="Admin_panel/Admin_panel_dashboard.php" class="dashboard_button">DASHBOARD</a>
                            </li>';
                        }
                        else
                        {
                            echo '<li>
                            <a href="User_dash.php" class="bookings_button">MY BOOKINGS</a>
                            </li>';
                        }
                    }
                    
                    if(isset($_SESSION['logged_in']))
                    {
                        echo '<li><form action="Logout.php" method="POST" >
                        <button type="submit" class="login_button">SIGN OUT
                        </form></li>';
                    }   
                    else
                    {
                        echo '<li><form action="Log_in_part.php" method="POST" >
                        <button type="submit" class="login_button">LOG IN/SIGN IN
                        </form></li>';
                    }
                    ?>
            </ul>
        </div>
    </div>
        
    </body>
    </html>
    
