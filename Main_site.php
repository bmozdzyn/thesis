<!-- MAIN SITE OF THE APPLICATION -->

<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- ADDING FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    
    <!--   ADDING CSS FILE   -->
    <!-- Time solved problem with refreshing css file on site -->
    <link href="css/main_site.css?ts=<?=time()?>" rel="stylesheet" />

</head>

<body>
    <!--    HEADER    -->
    <header>

    <!--   LOGO   -->
    <!--<a href="Main_site.php" >-->
        <img src="img/logo/LOGO.png" alt="LOGO" class="logo">
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

</header>


    <main>
        <!--   MID SECTION (CAR PHOTO) -->
        <div class="mid_section">
            <img src="img/background/background2.jpg" alt="background_image" class="mid_section_photo">
    
            <p class="mid_section_text">
                RENT YOUR DREAM CAR
            </p>
        </div>
    </main>

    
    <!-- TYPE CHOICE -->
    <div class="type_choice">
        
        <p class = "type_choice_text">CHOOSE YOUR TYPE</p><br />
        
        <ul class="type_grid">
                <li>
                    <!-- link directing to city type cars -->
                    <div class="box box_city">
                        <br /><p>CITY</p><br />
                        <a href="Cars.php?link=link1">
                            <img src="img/types/city.png" alt="city_type">
                        </a>
                    </div>
                </li>

                <li>
                    <!-- link directing to luxury type cars -->
                    <div class="box box_luxury">
                        <br /><p>LUXURY</p><br />
                        <a href="Cars.php?link=link2">
                            <img src="img/types/luxury.png" alt="luxury_type">
                        </a>
                    </div>
                </li>

                <li>
                    <!-- link directing to sport type cars -->
                    <div class="box box_sport">
                        <br /><p>SPORT</p><br />
                        <a href="Cars.php?link=link3">
                            <img src="img/types/sport.png" alt="sport_type">
                        </a>
                    </div>
                </li>

                <li>
                    <!-- link directing to suv type cars -->
                    <div class="box box_suv">
                        <br /><p>SUV</p><br />
                        <a href="Cars.php?link=link4">
                            <img src="img/types/suv.png" alt="suv_type">
                        </a>
                    </div>
                </li>
            </ul>
    </div> 


    <!-- FOOTER -->
    <footer>
            <div class="contact_menu">
                <ul>
                    <li><b>Contact: </b></li>
                    <li>Telephone: 6621789031</li>
                    <li>e-mail: car</li>
                </ul>
            </div>

            <div class="social_media_menu">
                <ul>
                    <li><b>Social Networks: </b></li>
                    <li>Facebook</li>
                    <li>Instagram</li>
                </ul>
            </div>
    </footer>

</body>
</html>