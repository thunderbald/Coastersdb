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
if(isset($_POST["coasterID"]) && !empty($_POST["coasterID"])){
    // Get hidden input value
    $coasterID = $_POST["coasterID"];
    
    // Validate name
    $input_coaster_name = trim($_POST["coaster_name"]);
    if(empty($input_coaster_name)){
        $coaster_name_err = "Please enter a name.";
    } elseif(!filter_var($input_coaster_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $coaster_name_err = "Please enter a valid name.";
    } else{
        $coaster_name = $input_coaster_name;
    }

    // Validate height
    $input_height = trim($_POST["height_ft"]);
    if(empty($input_height)){
        $height_err = "Please enter coaster height.";
    } else{
        $height = $input_height;
    }

    // Validate speed
    $input_speed = trim($_POST["speed_mph"]);
    if(empty($input_speed)){
        $speed_err = "Please enter the speed.";
    } elseif(!ctype_digit($input_speed)){
        $speed_err = "Please enter a positive integer value.";
    } else{
        $speed = $input_speed;
    }
    


    // Validate year opened
    $input_year_opened = trim($_POST["year_opened"]);
    if(empty($input_year_opened)){
        $year_opened_err = "Please enter the year opened.";
    } else{
        $year_opened = $input_year_opened;
    }

    // Validate location
    $input_location = trim($_POST["location"]);
    if(empty($input_location)){
        $location_err = "Please enter the location.";
    } else{
        $location = $input_location;
    }
    // Validate parkID
    $input_parkID = trim($_POST["park_ID"]);
    if(empty($input_parkID)){
        $parkID_err = "Please enter the parkID.";
    } else{
        $parkID = $input_parkID;
    }
    // Validate manufacturer
    $input_manufacturer = trim($_POST["manufacturer"]);
    if(empty($input_manufacturer)){
        $manufacturer_err = "Please enter the manufacturer.";
    } else{
        $manufacturer = $input_manufacturer;
    }
    
    // Check input errors before inserting in database
    if(eempty($coaster_name_err) && empty($height_err) && empty($speed_err) && empty($coasterID_err)
        && empty($Inversion_num_err) && empty($year_opened_err) && empty($location_err) && empty($parkID_err) && empty($manufacturer_err)){
        // Prepare an update statement
        $sql = "UPDATE coasters SET coaster_name=?, height=?, speed =?, year_opened=?, location = ?, parkID = ?, manufacturer = ? WHERE coasterID=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isiiisis", $param_coasterID, $param_name, $param_height, $param_speed, 
             $param_year_opened, $param_location, $param_parkID, $param_manufacturer);
            
            // Set parameters
            $param_name = $coaster_name;
            $param_height = $height;
            $param_speed = $speed;
            $param_coasterID = $coasterID;
            
            $param_year_opened = $year_opened;
            $param_location = $location;
            $param_parkID = $parkID;
            $param_manufacturer = $manufacturer;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["coasterID"]) && !empty(trim($_GET["coasterID"]))){
        // Get URL parameter
        $coasterID =  trim($_GET["coasterID"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM coasters WHERE coasterID = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_coasterID);
            
            // Set parameters
            $param_coasterID = $coasterID;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $coasterID = $row["coasterID"];
                    $coaster_name = $row["coaster_name"];
                    $height = $row["height_ft"];
                    $speed = $row["speed_mph"];
                    
                    $year_opened = $row["year_opened"];
                    $location = $row["location"];
                    $parkID = $row["park_ID"];
                    $manufacturer = $row["manufacturer"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: ../error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: ../error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the coasters record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                     
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
                            <textarea name="height_ft" class="form-control <?php echo (!empty($height_err)) ? 'is-invalid' : ''; ?>"><?php echo $height; ?></textarea>
                            <span class="invalid-feedback"><?php echo $height_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Speed</label>
                            <input type="text" name="speed_mph" class="form-control <?php echo (!empty($speed_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $speed; ?>">
                            <span class="invalid-feedback"><?php echo $speed_err;?></span>
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
                            <input type="text" name="park_ID" class="form-control <?php echo (!empty($parkID_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $parkID; ?>">
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
