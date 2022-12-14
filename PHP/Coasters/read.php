<<?php
// Initialize the session                                                                                                                                              
session_start();                                                                                                                                                       
                                                                                                                                                                       
// Check if the user is logged in, if not then redirect him to login page                                                                                              
//if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){                                                                                                   
 //   header("location: ../login.php");                                                                                                                                     
 //   exit;                                                                                                                                                              
//}    
// Check existence of id parameter before processing further
if(isset($_GET["coasterID"]) && !empty(trim($_GET["coasterID"]))){
    // Include config file
    require_once "../config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM coasters WHERE coasterID = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_coasterID);
        
        // Set parameters
        $param_coasterID = trim($_GET["coasterID"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                //$coaster_name = $height_ft = $speed_mph = $coasterID = $Inversion_num = $year_opened  = $location = $park_ID = $manufacturer = "";
                // Retrieve individual field value
                $coasterID = $row["coasterID"];
                $coaster_name = $row["coaster_name"];
                $height_ft = $row["height_ft"];
                $speed_mph = $row["speed_mph"];
               // $Inversion_num = $row["Inversion_num"];
                $year_opened = $row["year_opened"];
                $location = $row["location"];
                $park_ID = $row["park_ID"];
                $manufacturer = $row["manufacturer"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
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
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: ../error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Coaster ID</label>
                        <p><b><?php echo $row["coasterID"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <p><b><?php echo $row["coaster_name"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Height</label>
                        <p><b><?php echo $row["height_ft"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Speed</label>
                        <p><b><?php echo $row["speed_mph"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Year Opened</label>
                        <p><b><?php echo $row["year_opened"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <p><b><?php echo $row["location"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Park ID</label>
                        <p><b><?php echo $row["park_ID"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Manufacturer</label>
                        <p><b><?php echo $row["manufacturer"]; ?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>