<?php
// Initialize the session                                                                                                                                              
session_start();                                                                                                                                                       
                                                                                                                                                                       
// Check if the user is logged in, if not then redirect him to login page                                                                                              
//if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  //  header("location: ../login.php");
    //exit;
//}
// Include config file
require_once "../config.php";
 
// Define variables and initialize with empty values
$park_name = $location = $year_opened = $parkID = $num_coasters= "";
$name_err = $location_err = $year_opened_err = $parkID_err = $num_coasters_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["parkID"]) && !empty($_POST["parkID"])){
    // Get hidden input value
    $parkID = $_POST["parkID"];

    // Validate park name
    $input_park_name = trim($_POST["name"]);
    if(empty($input_park_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_park_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $park_name = $input_park_name;
    }

    // Validate location
    $input_location = trim($_POST["location"]);
    if(empty($input_location)){
        $location_err = "Please enter the location.";
    } else{
        $location = $input_location;
    }

    // Validate year opened
    $input_year_opened = trim($_POST["year_opened"]);
    if(empty($input_year_opened)){
        $year_opened_err = "Please enter the year opened.";
    } elseif(!ctype_digit($input_year_opened)){
        $year_opened_err = "Please enter the year opened.";
    } else{
        $year_opened = $input_year_opened;
    }

    // Validate the number of coasters
    $input_num_coasters = trim($_POST["num_coasters"]);
    if(empty($input_num_coasters)){
        $num_coasters_err = "Please enter the number of coasters.";
    } else{
        $num_coasters = $input_num_coasters;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($location_err) && empty($year_opened_err) && empty($parkID_err) && empty($num_coasters_err)){
        // Prepare an update statement
        $sql = "UPDATE parks SET park_name=?, location=?, year_opened=?, num_coasters = =? WHERE parkID=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "issii",$param_parkID, $param_park_name, $param_location, $param_year_opened, $param_num_coasters);
            
            // Set parameters
            $param_parkID = $parkID;
            $param_park_name = $park_name;
            $param_location = $location;
            $param_year_opened = $year_opened;            
            $param_num_coasters = $num_coasters;
            
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
    if(isset($_GET["parkID"]) && !empty(trim($_GET["parkID"]))){
        // Get URL parameter
        $parkID =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM parks WHERE parkID = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_parkID);
            
            // Set parameters
            $param_parkID = $parkID;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $parkID = $row["parkID"];
                    $park_name = $row["park_name"];
                    $location = $row["location"];
                    $year_opened = $row["year_opened"];
                    $num_coasters = $row["num_coasters"];
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
                    <p>Please edit the input values and submit to update the Park record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                         <div class="form-group">
                            <label>Park ID</label>
                            <input type="text" name="parkID" class="form-control <?php echo (!empty($parkID_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $parkID; ?>">
                            <span class="invalid-feedback"><?php echo $parkID_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Park Name</label>
                            <input type="text" name="park_name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $park_name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>location</label>
                            <textarea name="location" class="form-control <?php echo (!empty($location_err)) ? 'is-invalid' : ''; ?>"><?php echo $location; ?></textarea>
                            <span class="invalid-feedback"><?php echo $location_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Year Opened</label>
                            <input type="text" name="year_opened" class="form-control <?php echo (!empty($year_opened_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $year_opened; ?>">
                            <span class="invalid-feedback"><?php echo $year_opened_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Number of coasters</label>
                            <input type="text" name="num_coasters" class="form-control <?php echo (!empty($num_coasters_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $num_coasters; ?>">
                            <span class="invalid-feedback"><?php echo $num_coasters_err;?></span>
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
