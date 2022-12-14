<?php
/* Require Session and Login Start */
// Copy and paste this section at the top of any page you want protected.
// Initialize the session

session_start();
 
// Check if the user is logged in, if not then redirect him to login page
//if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
   //header("location: login.php");
  //  exit;
//}
/* Require Session and Login End */
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to the Rollercoasters Database!.</h1>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p> 
    <p>
        <a href="manufacturer/index.php" class="btn btn-primary">Manufacturer</a>
    </p>
    <p>
        <a href="coasters/index.php" class="btn btn-primary">Roller Coasters</a>
    </p>
    <p>
        <a href="parks/index.php" class="btn btn-primary">Parks</a>
    </p>
</body>
</html>