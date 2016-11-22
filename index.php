<?php require_once('resources/library/load.php');

// If user is already logged in go straight to the dashboard
if(isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
}

// Handle users logging in
if (isset($_POST['login'])) {
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
if (isset($_POST['sign_up'])) {
    $first_name = isset( $_POST['first_name'] ) ? make_safe($_POST['first_name']) : '';
    $last_name = isset( $_POST['last_name'] ) ? make_safe($_POST['last_name']) : '';
    $email = isset( $_POST['email'] ) ? make_safe($_POST['email']) : '';
    $password = isset( $_POST['password'] ) ? make_safe($_POST['password']) : '';
    $password_c = isset( $_POST['password_c'] ) ? make_safe($_POST['password_c']) : '';

    if (!$first_name || !$last_name || !$email || !$password || !$password_c) {
        echo "<script>console.log( 'All fields must be filled in' );</script>";
    } else if (user_exists($email)) {
        echo "<script>console.log( 'A user with that email already exists' );</script>";
    } else if ($password != $password_c) {
        echo "<script>console.log( 'Passwords must match' );</script>";
    } else {
        if (create_user($first_name, $last_name, $email, $password)) {
            echo "<script>console.log( 'User successfully created!' );</script>";
        } else {
            echo "<script>console.log( 'Woops! Something seems to have went wrong' );</script>";
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

    <title>duedate.io</title> <!-- TODO: Should probably style this more -->

    <!-- Stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7COpen+Sans:300,400,400i,600" rel="stylesheet">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/style.css">
</head>
<body id="index">
    <header class="navbar">
        <div class="container">
            <div class="navbar-header">
                <div class="navbar-brand" href="">duedate.io</div>
            </div>
            <div class="navbar-login navbar-right">
                <form class="login" method="post"> <!-- TODO: Should probably be done as a popup instead -->
                    <div class="form-group">
                        <input type="email" name="email" required="required" placeholder="Email" />
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" required="required" placeholder="Password" />
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" value="Login" /></br>
                        <!-- TODO: Add forgot password functionality -->
                        <!-- <a class="forgot_pwd" href="">Forgot password?</a> -->
                    </div>
                </form>
            </div>
        </div>
    </header>
    <div class="container page">
        <div class="row">
            <div class="col-md-7">
                <!-- TODO: Add blurb about what duedate.io is and how it can help students/teachers -->
            </div>
            <form class="col-md-5 sign-up" method="post"> <!-- TODO: Proper form validation (probably use validator.js) -->
                <h1>Sign up now</h1>
                <div class="form-group">
                    <label for="first_name">First Name:</label></br>
                    <input type="text" name="first_name" required="required" />
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name:</label></br>
                    <input type="text" name="last_name" required="required" />
                </div>
                <div class="form-group">
                    <label for="email">Email:</label></br>
                    <input type="email" name="email" required="required" />
                </div>
                <div class="form-group">
                    <label for="password">Password:</label></br>
                    <input type="password" name="password" required="required" />
                </div>
                <div class="form-group">
                    <label for="password_c">Confirm:</label></br>
                    <input type="password" name="password_c" required="required" />
                </div>
                <div class="form-group">
                    <input type="submit" name="sign_up" value="Sign me up!" />
                    <p class="terms">By signing up, you agree to the <a href="">Terms of Service</a> and <a href="">Privacy Policy</a>.</p>
                </div>
            </form>
        </div>
    </div>
    <!-- Scripts -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="resources/js/validator.min.js"></script>
    <script src="resources/js/scripts.min.js"></script>
</body>
</html>
