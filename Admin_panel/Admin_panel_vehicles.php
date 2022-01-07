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
        $result = $connection->query("SELECT * FROM vehicle");
    }


    //ADDING CAR

    //setting flag, validation correct
    $is_correct=true;

    //getting rid of undefined variable error
    //testing for the existence of variable element without trying to access it
    if(isset($_POST['type_select']))
        $type = $_POST['type_select'];
    else
        $type = null;

    if(isset($_POST['model_input']))
        $model = $_POST['model_input'];
    else
        $model = null;

    if(isset($_POST['brand_input']))
        $brand = $_POST['brand_input'];
    else
        $brand = null;

    if(isset($_POST['gearbox_select']))
        $gear_box = $_POST['gearbox_select'];
    else
        $gear_box = null;

    if(isset($_POST['engine_capacity_input']))
        $engine_capacity = $_POST['engine_capacity_input'];
    else
        $engine_capacity = null;

    if(isset($_POST['date_input']))
        $production_date = $_POST['date_input'];
    else
        $production_date = null;

    if(isset($_POST['mileage_input']))
        $current_mileage = $_POST['mileage_input'];
    else
        $current_mileage = null;

    if(isset($_POST['cost_input']))
        $cost = $_POST['cost_input'];
    else
        $cost = null;

    if(isset($_POST['ac_select']))
        $AC = $_POST['ac_select'];
    else
        $AC = null;
    

    //FILE
    if(isset($_FILES['file']['name']))
    {
        //$target_file = basename($_FILES['file']['name']);
        $target_file = $target_dir.basename($_FILES['file']['name']);
    }
    else
        $target_file = null;
    
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // CHECKING FILE //
    //check if file is a actual image
    if(isset($_POST['submit_button'])) {
        $check = getimagesize($_FILES['file']['tmp_name']);
        if($check == false) {
            $is_correct = false;
            //setting error
            $_SESSION['e_file'] = 'File is not an image';
        }
    }

    //check if file already exists
    if(file_exists($target_file)) {
        $is_correct = false;
        //setting error
        $_SESSION['e_file'] = 'File already exists';
    }

    //check file size
    if(isset($_FILES['file']['size']) > 500000) {
        $is_correct = false;
        //setting error
        $_SESSION['e_file'] = 'File is too large';
    }

    //check file format
    /* if($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg") {
        $is_correct = false;
        //setting error
        $_SESSION['e_file'] = 'Only JPG, JPEG and PNG files allowed';
    } */

    // CHECKING BRAND //
    //checking if brand is between 3 and 20 chars
    if((strlen($brand) < 3) || (strlen($brand) > 20))
    {
        $is_correct = false;
        //setting error
        $_SESSION['e_brand'] = 'The length of the brand should be between 3 and 20 characters';
    }

    //checking if all chars are alphanumeric
    if(ctype_alnum($brand) == false)
    {
        $is_correct = false;
        //setting error
        $_SESSION['e_brand'] = 'Brand should consists of letters and numbers only';
    }

    // CHECKING MODEL //
    //checking if model is between 1 and 20 chars
    if((strlen($model) < 1) || (strlen($model) > 20))
    {
        $is_correct = false;
        //setting error
        $_SESSION['e_model'] = 'The length of the model should be between 1 and 20 characters';
    }

    //checking if all chars are alphanumeric
    if(ctype_alnum($model) == false)
    {
        $is_correct = false;
        //setting error
        $_SESSION['e_model'] = 'Model should consists of letters and numbers only';
    }

    // CHECKING ENGINE CAPACITY //
    //checking if engine capacity is between 3 and 4 chars
    if((strlen($engine_capacity) < 3 || strlen($engine_capacity) > 4))
    {
        $is_correct = false;
        //setting error
        $_SESSION['e_engine_capacity'] = 'Engine capacity should be between 100 cm3 - 9999 cm3';
    }

    // CHECING MILLEAGE //
    //checking if milleage is between 0 and 7 chars
    if((strlen($current_mileage) < 0 || strlen($current_mileage) > 7))
    {
        $is_correct = false;
        //setting error
        $_SESSION['e_current_milleage'] = 'Current milleage should be between 0 km - 9999999 km';
    }

    // CHECKING COST PER DAY //
    //checking if cost per day is between 2 and 4 chars
    if((strlen($cost) < 2 || strlen($cost) > 4))
    {
        $is_correct = false;
        //setting error
        $_SESSION['e_cost'] = 'Cost should be between 10 - 9999';
    }

    // Everything is correct
        if ($is_correct == true && isset($_SESSION['submit_button']) == isset($_POST['submit_button']))
        {
            //adding car to database
            if($connection->query("INSERT INTO vehicle (Type, Model, Brand, Gear_box, Engine_capacity, Production_date, Avaliability, Current_mileage, Cost_per_day, AC) VALUES ('$type', '$model', '$brand', '$gear_box', '$engine_capacity', '$production_date','1', '$current_mileage', '$cost', '$AC')"))
            {   
                //getting id of the last element
                $last_id = $connection->insert_id;

                //adding file to the folder
                /* if(move_uploaded_file(($_FILES['file']['tmp_name']), $target_file)) { */
                if(move_uploaded_file(($_FILES['file']['tmp_name']), "uploads/{$last_id}.jpg")) { 
                    echo "The file".htmlspecialchars(basename($_FILES['file']['tmp_name']))."has been uploaded";
                    
                //prevents from inserting data to the database while refreshing the page
                    $_SESSION['adding_successful'] = true;
                    header('Location: Admin_panel_vehicles.php');
    
                    echo 'adding successful';

                }
                else {
                    echo "Error while uploading a file";
                }
            }
            else
            {
                handle_error($connection->error);
            }
        }
    $connection->close();
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
    <link href="css/Admin_panel_vehicles.css?ts=<?=time()?>" rel="stylesheet" />
</head>
<body>
    <!-- Header -->
    <header>
        <!--Including header-->
        <?php include 'Admin_panel_header.php' ?>
    </header>    

    <p class="vehicle_title">VEHICLES</p>


    <div class = "middle_section">
        
        <!-- Main content -->
        <div class="main_content">
            
            <!-- Displaying data about vehicles -->
            <table class="table">
                <tr>
                    <th>Vehicle ID</th>
                    <th>Type</th>
                    <th>Model</th>
                    <th>Brand</th>
                    <th>Gear box</th>
                    <th>Engine capacity</th>
                    <th>A/C</th>
                    <th>Production date</th>
                    <th>Avaliability</th>
                    <th>Current mileage</th>
                    <th>Cost per day</th>
                    <th>Delete</th>
                </tr>
                
                <!-- Fetching data from rows -->
                <?php
                    while($rows = $result->fetch_assoc())
                    {
                ?>
                <tr>
                    <td><?php echo $rows['Vehicle_ID'];?></td>
                    <td><?php echo $rows['Type'];?></td>
                    <td><?php echo $rows['Model'];?></td>
                    <td><?php echo $rows['Brand'];?></td>
                    <td><?php echo $rows['Gear_box'];?></td>
                    <td><?php echo $rows['Engine_capacity'];?></td>
                    <td><?php echo $rows['AC'];?></td>
                    <td><?php echo $rows['Production_date'];?></td>
                    <td><?php echo $rows['Avaliability'];?></td>
                    <td><?php echo $rows['Current_mileage'];?></td>
                    <td><?php echo $rows['Cost_per_day'];?></td>
                    <?php echo "<td><a href='Delete.php?id=".$rows['Vehicle_ID']."'>Delete</a></td>";?>
                </tr>
                <?php
                    }
                ?>

            </table>
        </div>
    </div>
    
    <!-- Section for adding a vehicle -->
        <p class="adding_vehicle">Adding vehicle</p>
    
        <form method="POST" enctype="multipart/form-data">
            <div class="adding_vehicle_container">
                
                <!-- TYPE -->
                <div class="type_label">
                    <label for="type_select">Type:</label>
                </div>
    
                <div class="type_select_div">
                    <select name="type_select" id="type_select">
                        <option value="City">City</option>
                        <option value="Luxury">Luxury</option>
                        <option value="Sport">Sport</option>
                        <option value="SUV">SUV</option>
                    </select>
                </div>
                <!-- -->
    

                <!-- Brand -->
                <div class="brand_label">
                    <label for="brand_input">Brand:</label>
                </div>
    
                <div class="brand_div">
                    <input type="text" class="brand_input" name="brand_input">

                    <!-- Displaying error -->
                    <?php
                        if(isset($_SESSION['e_brand']))
                        {
                            echo '<div class="error">'.$_SESSION['e_brand'].'</div>';
                            //clearing session variable
                            unset($_SESSION['e_brand']);
                        }
                    ?>
                </div>
                <!-- -->


                <!-- Model -->
                <div class="model_label">
                    <label for="model_input">Model:</label>    
                </div>
    
                <div class="model_div">
                    <input type="text" class="model_input" name="model_input">
                    
                    <!-- Displaying error -->
                    <?php
                        if(isset($_SESSION['e_model']))
                        {
                            echo '<div class="error">'.$_SESSION['e_model'].'</div>';
                            //clearing session variable
                            unset($_SESSION['e_model']);
                        }
                    ?>
                </div>
                <!-- -->


                <!-- Gear box -->
                <div class="gearbox_label">
                    <label for="gearbox_select">Gear box:</label>
                </div>
                
                <div class="gearbox_div">
                    <select name="gearbox_select" id="gearbox_select">
                        <option value="Automatic">Automatic</option>
                        <option value="Manual">Manual</option>
                    </select>
                </div>
                <!-- -->


                <!-- Engine capacity -->
                <div class="engine_capacity_label">
                    <label for="engine_capacity_input">Engine capacity:</label>
                </div>
    
                <div class="engine_capacity_div">
                    <input type="number" class="engine_capacity_input" name="engine_capacity_input">

                    <!-- Displaying error -->
                    <?php
                        if(isset($_SESSION['e_engine_capacity']))
                        {
                            echo '<div class="error">'.$_SESSION['e_engine_capacity'].'</div>';
                            //clearing session variable
                            unset($_SESSION['e_engine_capacity']);
                        }
                    ?>
                </div>
                <!-- -->
    

                <!-- A/C -->
                <div class="ac_label">
                    <label for="ac_select">A/C:</label>
                </div>
    
                <div class="ac_div">
                    <select name="ac_select" id="ac_select">
                        <option value="1">Avaliable</option>
                        <option value="0">Not avaliable</option>
                    </select>
                </div>
                <!-- -->
    
                <!-- Production date -->
                <div class="production_date_label">
                    <label for="date_input">Production date:</label>
                </div>
    
                <div class="date_input_div">
                    <input type="date" class="date_input" name="date_input">
                </div>
                <!-- -->

                <!-- Current mileage -->
                <div class="current_mileage_div">
                    <label for="mileage_input">Current mileage:</label>
                </div>

                <div class="mileage_input_div">
                    <input type="number" class="mileage_input">
                </div>

                <!-- Displaying error -->
                    <?php
                        if(isset($_SESSION['e_mileage']))
                        {
                            echo '<div class="error">'.$_SESSION['e_mileage'].'</div>';
                            //clearing session variable
                            unset($_SESSION['e_mileage']);
                        }
                    ?>
                <!-- -->

                <!-- Cost per day -->
                <div class="cost_per_day_label">
                    <label for="cost_input">Cost per day:</label>
                </div>
    
                <div>
                    <input type="number" class="cost_input" name="cost_input">

                    <!-- Displaying error -->
                    <?php
                        if(isset($_SESSION['e_cost']))
                        {
                            echo '<div class="error">'.$_SESSION['e_cost'].'</div>';
                            //clearing session variable
                            unset($_SESSION['e_cost']);
                        }
                    ?>
                </div>
                <!-- -->

                <!-- Car picture -->
                <div class="file_label">
                    <label for="file_input">Choose a car picture</label>
                </div>

                <div>
                    <input type="file" name="file" id="file_input" accept="image/png, image/jpeg, image/jpg">

                    <!-- Displaying error -->
                    <?php
                        if(isset($_SESSION['e_file']))
                        {
                            echo '<div class="error">'.$_SESSION['e_file'].'</div>';
                            //clearing session variable
                            unset($_SESSION['e_file']);
                        }
                    ?>
                </div>
                <!-- -->


                <!-- Empty div -->
                <div></div>

                <!-- Submit button -->
                <div class="submit_button_div">
                    <input type="submit" class="submit_button" value="Add">
                </div>
                <!-- -->

            </div>
        </form>

</body>
</html>