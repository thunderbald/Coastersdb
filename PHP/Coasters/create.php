
<?php
// Initialize the session                                                                                                                                              
session_start();                                                                                                                                                       
                                                                                                                                                                       
// Check if the user is logged in, if not then redirect him to login page                                                                                              
//if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){                                                                                                   
 //   header("location: ../login.php");                                                                                                                                  

  //  exit;                                                                                                                                                              
//}     
// Include config file
require_once "../config.php";
 
// Define variables and initialize with empty values
$coaster_name = $height = $speed = $coasterID = $Inversion_num = $year_opened  = $location = $parkID = $manufacturer = "";
$coaster_name_err = $height_err = $speed_err = $coasterID_err = $Inversion_num_err = "";
$year_opened_err = $location_err = $parkID_err = $manufacturer_err =  "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    //$input_coaster_name = trim($_POST["coaster_name"]);
    $input_coaster_name = trim(isset($_POST['coaster_name'])? $_POST['coaster_name'] : '');
    if(empty($input_coaster_name)){
        $coaster_name_err = "Please enter a name.";
    } elseif(!filter_var($input_coaster_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $coaster_name_err = "Please enter a valid name.";
    } else{
        $coaster_name = $input_coaster_name;
    }
    //$reservation_id = isset($_POST['reservation_id']) ? $_POST['reservation_id'] : '';
    // Validate height
    //$input_height = trim($_POST["height"]);
    $input_height = trim(isset($_POST['height'])? $_POST['height'] : '');
    if(empty($input_height)){
        $height_err = "Please enter coaster height.";
    } else{
        $height = $input_height;
    }
    
    // Validate speed
    //$input_speed = trim($_POST["speed"]);
    $input_speed = trim(isset($_POST['speed'])? $_POST['speed'] : '');
    if(empty($input_speed)){
        $speed_err = "Please enter the speed.";
    } elseif(!ctype_digit($input_speed)){
        $speed_err = "Please enter the speed in mph.";
    } else{
        $speed = $input_speed;
    }
    // Validate coasterID
    //$input_coasterID = trim($_POST["coasterID"]);
    $input_coasterID = trim(isset($_POST['coasterID'])? $_POST['coasterID'] : '');
    if(empty($input_coasterID)){
        $coasterID_err = "Please enter unique coasterID.";
    } else{
        $coasterID = $input_coasterID;
    }

    // Validate number of inversions
    //$input_coasterID = trim($_POST["Inversion_num"]);
    $input_Inversion_num = trim(isset($_POST['Inversion_num'])? $_POST['Inversion_num'] : '');
    if(empty($input_Inversion_num)){
        $Inversion_num_err = "Please enter number of inversions.";
    } else{
        $Inversion_num = $input_Inversion_num;
    }

    // Validate year opened
    //$input_year_opened = trim($_POST["year_opened"]);
    $input_year_opened = trim(isset($_POST['year_opened'])? $_POST['year_opened'] : '');
    if(empty($input_year_opened)){
        $year_opened_err = "Please enter the year opened.";
    } else{
        $year_opened = $input_year_opened;
    }

    // Validate location
    //$input_location = trim($_POST["location"]);
    $input_location= trim(isset($_POST['location'])? $_POST['location'] : '');
    if(empty($input_location)){
        $location_err = "Please enter the location.";
    } else{
        $location = $input_location;
    }
    // Validate parkID
    //$input_parkID = trim($_POST["parkID"]);
    $input_parkID = trim(isset($_POST['parkID'])? $_POST['parkID'] : '');
    if(empty($input_parkID)){
        $parkID_err = "Please enter the parkID.";
    } else{
        $parkID = $input_parkID;
    }
    // Validate manufacturer
    //$input_manufacturer = trim($_POST["manufacturer"]);
    $input_manufacturer= trim(isset($_POST['manufacturer'])? $_POST['manufacturer'] : '');
    if(empty($input_manufacturer)){
        $manufacturer_err = "Please enter the manufacturer.";
    } else{
        $manufacturer = $input_manufacturer;
    }

    // Check input errors before inserting in database
    if(empty($coaster_name_err) && empty($height_err) && empty($speed_err) && empty($coasterID_err)
        && empty($Inversion_num_err) && empty($year_opened_err) && empty($location_err) && empty($parkID_err) && empty($manufacturer_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO coasters (coasterID,  coaster_name, height, speed, Inversion_num, year_opened, location, parkID, manufacturer) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "siiiiisis", $param_name, $param_height,
                $param_speed, $param_coasterID, $param_Inversion_num, $param_year_opened, $param_location, $param_parkID, $param_manufacturer);

            // Set parameters
            $param_name = $coaster_name;
            $param_height = $height;
            $param_speed = $speed;
            $param_coasterID = $coasterID;
            $param_Inversion_num = $Inversion_num;
            $param_year_opened = $year_opened;
            $param_location = $location;
            $param_parkID = $parkID;
            $param_manufacturer = $manufacturer;


            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add this coaster to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                        <div class="form-group">
                            <label>coasterID</label>
                            <input type="text" name="coasterID" class="form-control <?php echo (!empty($coasterID_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $coasterID; ?>">
                            <span class="invalid-feedback"><?php echo $coasterID_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="coaster_name" class="form-control <?php echo (!empty($coaster_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $coaster_name; ?>">
                            <span class="invalid-feedback"><?php echo $coaster_name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Height</label>
                            <input type = "text" name="height" class="form-control <?php echo (!empty($height_err)) ? 'is-invalid' : ''; ?>" value ="<?php echo $height; ?>">
                            <span class="invalid-feedback"><?php echo $height_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Speed</label>
                            <input type="text" name="speed" class="form-control <?php echo (!empty($speed_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $speed; ?>">
                            <span class="invalid-feedback"><?php echo $speed_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Number of Inversions</label>
                            <input type="text" name="Inversion_num" class="form-control <?php echo (!empty($Inversion_num_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Inversion_num; ?>">
                            <span class="invalid-feedback"><?php echo $Inversion_num_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Year Opened</label>
                            <input type="text" name="year_opened" class="form-control <?php echo (!empty($year_opened_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $year_opened; ?>">
                            <span class="invalid-feedback"><?php echo $year_opened_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" name="location" class="form-control <?php echo (!empty($location_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $location; ?>">
                            <span class="invalid-feedback"><?php echo $location_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Park ID</label>
                            <input type="text" name="parkID" class="form-control <?php echo (!empty($parkID_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $parkID; ?>">
                            <span class="invalid-feedback"><?php echo $parkID_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Manufacturer</label>
                            <input type="text" name="manufacturer" class="form-control <?php echo (!empty($manufacturer_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $manufacturer; ?>">
                            <span class="invalid-feedback"><?php echo $manufacturer_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>