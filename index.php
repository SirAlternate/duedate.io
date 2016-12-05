<?php require_once('resources/library/load.php');

// If user is already logged in go straight to dashboard
if(isset($_SESSION['user_id']))
    header('Location: dashboard.php');

// Handle users logging in
if (isset($_POST['login_submit'])) {
    // Get input values from form
    $email = isset( $_POST['email'] ) ? make_safe($_POST['email']) : '';
    $password = isset( $_POST['password'] ) ? make_safe($_POST['password']) : '';

    // Check if fields are filled
    if (!$email || !$password) {
        echo "<script>console.log( 'Both an email and password are required' );</script>";
    } else {
        if (login($email, $password)) {
            echo "<script>console.log( 'Successfully logged in!' );</script>";
            header('Location: dashboard.php');
        } else {
            echo "<script>console.log( 'Incorrect email or password' );</script>";
        }
    }
}

// Handle new users signing up
if (isset($_POST['register_submit'])) {
    // Get input values form form
    $first_name = isset( $_POST['register_firstname'] ) ? make_safe($_POST['register_firstname']) : '';
    $last_name = isset( $_POST['register_lastname'] ) ? make_safe($_POST['register_lastname']) : '';
    $email = isset( $_POST['register_email'] ) ? make_safe($_POST['register_email']) : '';
    $password = isset( $_POST['register_password'] ) ? make_safe($_POST['register_password']) : '';
    $password_c = isset( $_POST['register_passwordc'] ) ? make_safe($_POST['register_passwordc']) : '';

    if (!$first_name || !$last_name || !$email || !$password || !$password_c) {
        echo "<script>alert( 'All fields must be filled in' );</script>";
    } else if (user_exists($email)) {
        echo "<script>alert( 'A user with that email already exists' );</script>";
    } else if ($password != $password_c) {
        echo "<script>alert( 'Passwords must match' );</script>";
    } else {
        if (create_user($first_name, $last_name, $email, $password)) {
            if (login($email, $password)) {
                $_SESSION["state"] = "new_user";
                header('Location: dashboard.php');
            }
        } else {
            echo "<script>alert( 'Woops! Something seems to have went wrong' );</script>";
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>duedate.io</title>

    <!-- Stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7COpen+Sans:300,400,400i,600" rel="stylesheet">
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/style.css">
</head>
<body id="index">
    <?php if (isset($_GET["logged_out"])) {
    ?>
    <div class="alert alert-info alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>You've been logged out</strong>
    </div>
    <?php } ?>
    <header class="navbar">
        <div class="container">
            <div class="navbar-header">
                <div class="navbar-brand" href="">duedate.io</div>
            </div>
            <div class="navbar-login">
                <form class="login" method="post"> <!-- TODO: Should probably be done as a popup instead -->
                    <div class="form-group">
                        <input type="email" name="email" required="required" placeholder="Email" />
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" required="required" placeholder="Password" />
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login_submit" value="Login" /></br>
                        <!-- TODO: Add forgot password functionality -->
                        <!-- <a class="forgot_pwd" href="">Forgot password?</a> -->
                    </div>
                </form>
            </div>
        </div>
    </header>
    <div class="container page">
        <div class="row">
            <div class="col-md-6 blurb">
                <h1>About duedate.io</h1>
                <p><b>duedate.io</b> is a web-based assignment manager that aids students in keeping track of their classes and assignments. Don't let the hectic nature of college life wear you down, let duedate.io help you sort out the chaos.</p>
                </br>
                <p><i>Site created by Dan Bruce, Viv Kunnath, Erik Saulnier, and Nathan Strelser for Web Systems Development at RPI&mdash;Fall 2016.</i></p>
            </div>
            <form class="col-md-5 col-md-offset-1 register" method="post"> <!-- TODO: Proper form validation (probably use validator.js) -->
                <h1>Sign up now</h1>
                <div class="form-group">
                    <label for="register_firstname">First Name:</label></br>
                    <input type="text" name="register_firstname" required="required" />
                </div>
                <div class="form-group">
                    <label for="register_lastname">Last Name:</label></br>
                    <input type="text" name="register_lastname" required="required" />
                </div>
                <div class="form-group">
                    <label for="register_email">Email:</label></br>
                    <input type="email" name="register_email" required="required" />
                </div>
                <div class="form-group">
                    <label for="register_password">Password:</label></br>
                    <input type="password" name="register_password" required="required" />
                </div>
                <div class="form-group">
                    <label for="register_passwordc">Confirm:</label></br>
                    <input type="password" name="register_passwordc" required="required" />
                </div>
                <div class="form-group">
                    <input type="submit" name="register_submit" value="Sign me up!" />
                    <p class="terms">By signing up, you agree to the <a href="">Terms of Service</a> and <a href="">Privacy Policy</a>.</p>
                </div>
            </form>
            <div style="clear: both;"></div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="resources/js/validator.min.js"></script>
    <script src="resources/js/scripts.js"></script>

    <!-- Fallbacks for jQuery and Bootstrap CDNs -->
    <script>
    if (!window.jQuery) {
        document.write("<script src='resources/js/jquery.min.js'><\/script>");
        document.write("<script src='resources/js/bootstrap.min.js'><\/script>");
    }
    </script>
</body>
</html>
