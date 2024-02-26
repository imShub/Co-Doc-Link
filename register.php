<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (user_fullname, user_email, user_phone , user_pin, username, password) VALUES (?, ?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssisss", $name, $email, $phone, $pin,  $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $name = $_REQUEST['name'];
            $phone = $_REQUEST['phone'];
            $email = $_REQUEST['email'];
            $pin = password_hash($_REQUEST['pin'], PASSWORD_DEFAULT);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: index.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Register </title>
    <!-- plugins:css -->
    <?php include 'partials/headtags.php'; ?>

</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <span class="fw-bold " style="font-family: Sofia,sans-serif;"> <span
                                        class="fs-1 font-effect-shadow-multiple">File</span> <span
                                        class="text-primary fs-4 font-effect-shadow-multiple">Manager</span> </span>
                            </div>
                            <h4>Hello! let's get started</h4>
                            <h6 class="fw-light">Sign up to continue.</h6>
                            <form class="pt-3" autocomplete="off"
                                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control form-control-lg"
                                        id="exampleInputEmail1" placeholder="Full Name">
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-lg"
                                        id="exampleInputEmail1" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input type="number" name="phone" class="form-control form-control-lg"
                                        id="exampleInputEmail1" placeholder="Phone">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="pin" maxlength="4" class="form-control form-control-lg"
                                        id="exampleInputEmail1" placeholder="PIN">
                                    <small class="text-secondary">PIN used to lock or unlock documents.</small>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="username"
                                        class="form-control form-control-lg <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                                        value="<?php echo $username; ?>" placeholder="Username">
                                    <span class="invalid-feedback"><?php echo $username_err; ?>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password"
                                        class="form-control form-control-lg <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                                        value="<?php echo $password; ?>" placeholder="Password">
                                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirm_password"
                                        class="form-control form-control-lg <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>"
                                        value="<?php echo $confirm_password; ?>" placeholder="Confirm Password">
                                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                                </div>
                                <div class="mt-3">
                                    <input type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                        value="SIGN UP">
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input">
                                            Keep me signed in
                                        </label>
                                    </div>
                                    <a href="#" class="auth-conn text-black">Forgot password?</a>
                                </div>
                                <div class="mb-2">
                                    <button type="button" class="btn btn-block btn-facebook auth-form-btn disabled">
                                        <i class="ti-facebook me-2"></i>Connect using facebook
                                    </button>
                                </div>
                                <div class="text-center mt-4 fw-light">
                                    Already have an account ? <a href="index.php" class="text-primary">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <?php include 'partials/javascripts.php'; ?>

</body>

</html>