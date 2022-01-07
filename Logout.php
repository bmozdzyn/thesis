<!--    CLEARING SESSION/EVERYTHING NEEDED FOR LOGGING OUT  -->



<?php   
    session_start();

    //clearing session
    session_unset();

    //Directing to main page after logging out
    header("Location: Main_site.php");
?>