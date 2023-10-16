


<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: homepage.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: customerinterface.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<html>
    <head>
        <title>Log In | FLASH LIGHTING</title>
        <link rel="stylesheet" href="style1.css">
    </head>
    <body>
        <div class="header">
            <table align="center">
           <td><img src="images/radi.jpg" alt="img not found" height="100" width="200"> </td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td> <div class="topnav" >
               
               
               
               
               
             </div> </td>
            </table><br> 
       </div>
        <div class="container">

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
              <div class="row">
                
                <h2 style="text-align:center">Log In with Social Media or Manually</h2>
                <div class="vl">
                  <span class="vl-innertext">or</span>
                </div>
          
                <div class="col">
                  <a href="#" class="fb btn">
                    <i class="fa fa-facebook fa-fw"></i> Login with Facebook
                  </a>
                  <a href="#" class="twitter btn">
                    <i class="fa fa-twitter fa-fw"></i> Login with Twitter
                  </a>
                  <a href="#" class="google btn">
                    <i class="fa fa-google fa-fw"></i> Login with Google+
                  </a>
                </div>
          
                <div class="col">
                  <div class="hide-md-lg">
                    <p>Or sign in manually:</p>
                  </div>
          
                  <input type="text" name="username" placeholder="Username" 
                  <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>"
                  required>
                  <span class="invalid-feedback" style="color:red;"><?php echo $username_err; ?></span>
                  <input type="password" name="password" placeholder="Password" 
                  
                  <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                  required>
                <input type="submit" value="Login" >
                </div>
          
              </div>
            </form>
          </div>
          
          <div class="bottom-container">
            <div class="row">
              <div class="col">
                <a href="signup1.php" style="color:white" class="btn">Sign up</a>
              </div>
              <div class="col">
                <a href="passreset.html" style="color:white" class="btn">Forgot password?</a>
              </div>
            </div>
            </div>

            <footer>
              <div align="center" style="padding: 2px;">
                <p><a href="mailto:5@gmail.com"> Contact Us</a> | <a href="about us.html">About Us</a> | <a href="#privacy policy">Privacy Policy</a> | </p>
               <p> <a href="#faqs">FAQs</a> | <a href="#Four Seasons Blog">Flash Lighting Blog</a> | <a href="staff.html">Staff</a></p>
               
                <img src="footer.png" alt="" width="">
                <p><small><i>copyright © 2023 Developed by <a href="tel:+254705036698">FlashCoders</a></i></small><i></p>
              </div>
             
     
          </footer>   
           

















    </body>
</html>






