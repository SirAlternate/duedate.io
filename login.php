<?php require_once('resources/library/load.php');

// Handle login
if (isset($_POST['login'])) {
    $email = isset( $_POST['email'] ) ? make_safe($_POST['email']) : '';
    $password = isset( $_POST['password'] ) ? make_safe($_POST['password']) : '';

    // Check if fields are filled
    if (!$email || !$password) {
        $login_error = "Both an email and password are required";
    } else {
        if (login($email, $password)) {
            $login_success = "Successfully logged in!";
            header('Location: dashboard.php');
        } else {
            $login_error = "Incorrect email or password";
        }
    }
}

// Handle registering
if (isset($_POST['register'])) {
    $first_name = isset( $_POST['first_name'] ) ? make_safe($_POST['first_name']) : '';
    $last_name = isset( $_POST['last_name'] ) ? make_safe($_POST['last_name']) : '';
    $email = isset( $_POST['email'] ) ? make_safe($_POST['email']) : '';
    $password = isset( $_POST['password'] ) ? make_safe($_POST['password']) : '';
    $password_c = isset( $_POST['password_c'] ) ? make_safe($_POST['password_c']) : '';

    if (!$first_name || !$last_name || !$email || !$password || !$password_c) {
        $register_error = "All fields are required";
    } else if ($password != $password_c) {
        $register_error = "Both passwords must match";
    } else if (user_exists($email)) {
        $register_error = "A user with that email already exists";
    } else {
        if (create_user($first_name, $last_name, $email, $password)) {
            $register_success = "User successfully created!";
        } else {
            $register_error = "Woops! Something seems to have went wrong";
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
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/style.css">
</head>
<body>
    <div class="container fullpage centered-y">
        <form method="post" class="login">
            <h2>Login</h2>
            <div class="form_group">
                <label for="email">Email</label>
                <input type="email" name="email" />
            </div>
            <div class="form_group">
                <label for="password">Password</label>
                <input type="password" name="password" />
            </div>
            <div class="form_group">
                <?php if (isset($login_error)) {
                    echo "<p class='form_error'>$login_error</p>";
                } ?>
                <?php if (isset($login_success)) {
                    echo "<p class='form_success'>$login_success</p>";
                } ?>
                <input type="submit" name="login" value="Login" />
                <a class="forgot_pwd" href="">Forgot password?</a>
            </div>
        </form>
        <form method="post" class="register">
            <h2>Register</h2>
            <div class="form_group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" />
            </div>
            <div class="form_group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" />
            </div>
            <div class="form_group">
                <label for="email">Email</label>
                <input type="email" name="email" />
            </div>
            <div class="form_group">
                <label for="password">Password</label>
                <input type="password" name="password" />
            </div>
            <div class="form_group">
                <label for="password_c">Confirm</label>
                <input type="password" name="password_c" />
            </div>
            <div class="form_group">
                <?php if (isset($register_error)) {
                    echo "<p class='form_error'>$register_error</p>";
                } ?>
                <?php if (isset($register_success)) {
                    echo "<p class='form_success'>$register_success</p>";
                } ?>
                <input type="submit" name="register" value="Sign Up" />
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="resources/js/scripts.min.js"></script>
</body>
</html>
