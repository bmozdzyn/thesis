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
        </div>
    </body>
</html>

