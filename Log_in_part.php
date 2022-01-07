<!--SITE FOR TYPING LOGIN AND PASSWORD -->
<?php
    session_start();
?>

<!--   ADDING CSS   -->
<link href="css/Log_in_part.css?ts=<?=time()?>" rel="stylesheet" />

<!-- LOG IN SECTION
transsmision the log in data(login, password) to Log_in.php site
method="post" - sending data to a server to create/update resorce-->
<html>


    <body>
        

        <form action="Check_if_lgn_corct.php" method="post">
            <div class="login_container">
                
                    <div class = "login_text_div">
                           <p><b>LOGIN</b></p>  <br /> <br />    

                            <a href="Register_part.php">Don't have an account yet? Sign up here.</a>
                    </div>

                    <div class = "username_password_field">
                        <div class = "jojo123">
                            Username: <br /> <input type="text" name="login"> <br /> <br /> 
                            Password: <br /> <input type="password" name="password"> <br /> <br />  
                                
                            
                            <br /> <input type="submit" value="Log in" class="login_button"> 
                         </div>

                    </div>
                
                </div>
            </form>

            
            <?php
                //Displaying error only if error exists in check_if_lgn_correct.php
                if(isset($_SESSION['error']))
                {
                    echo $_SESSION['error'];
                }
            ?>
    
    </body>
    
</html>