<?php

// Connect to the database. If you don't want to switch to the database after
// connecting set $select_db to false, otherwise parameter is not needed
function db_connect($select_db = true) {
    global $db_config, $db_connection;

    // Connect to database as defined in config
    try {
        $db_connection = new PDO('mysql:host='.$db_config['host'].';', $db_config['user'], $db_config['pass']);
    } catch(PDOException $e) {
        // echo 'Could not connect to database: ' . $e->getMessage();
        return false;
    }

    // Set error mode
    $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Select the correct database
    if ($select_db) {
        try {
            $db_connection->exec("USE `".$db_config['name']."`;");
        } catch(PDOException $e) {
            // echo 'Could not select database: ' . $e->getMessage();
            return false;
        }
    }

    return true;
}

// Create user
function create_user($first_name, $last_name, $email, $password) {
    global $db_connection;

    // Just a fail safe - should be checked earlier in the process for accurate
    // error response
    if (user_exists($email)) {
        return false;
    }

    // Generate random salt
    $salt = hash('sha256', uniqid(mt_rand(), true));

    // Prepend the salt to the password and hash it
    $salted = hash('sha256', $salt . $password);

    // Add the user to our database
    $db_connection->exec("INSERT INTO `users`
    ( `first_name`, `last_name`, `email`, `password`, `salt` )
    VALUES
    ( '$first_name', '$last_name', '$email', '$salted', '$salt' )");

    // Success message
    return true;
}

// Check if user exists
function user_exists($email) {
    global $db_connection;

    // Query database for user with given email
    $query = $db_connection->query("SELECT * FROM `users` WHERE `email`='$email';");
    $user = $query->fetch(PDO::FETCH_ASSOC);

    // Check if we got any results and return accordingly
    if (count($user) > 1) {
        return true;
    } else {
        return false;
    }
}

// Get the current user's information
function get_user() {
    global $db_connection, $_SSESSION;
    $user_id = $_SESSION['user_id'];

    // Query database for the current user
    $query = $db_connection->query("SELECT * FROM `users` WHERE `user_id`='$user_id';");
    $query = $query->fetch(PDO::FETCH_ASSOC);

    // Create user array with relevent info
    $user = array(
        'user_id'  =>  $query['user_id'],
        'first_name'  =>  $query['first_name'],
        'last_name'  =>  $query['last_name'],
        'name'  =>  $query['first_name'] . " " . $query['last_name'],
        'email'  =>  $query['email']
    );

    // Return the user array back to caller
    return $user;
}

// Attempt to log in with given info
function login($email, $password) {
    global $db_connection, $_SESSION;

    // Search for the salt of a user with this email, if none salt is blank string
    $query = $db_connection->query("SELECT `salt` FROM `users` WHERE `email`='$email';");
    $query = $query->fetch(PDO::FETCH_ASSOC);
    $salt = ($query) ? $query['salt'] : '';

    // Prepend the salt to the entered password and hash it
    $salted = hash('sha256', $salt . $password);

    // Search for user with given email and password_needs_rehash
    $query = $db_connection->query("SELECT * FROM `users` WHERE `email`='$email' AND `password`='$salted';");
    $user = $query->fetch(PDO::FETCH_ASSOC);

    // Login
    if (count($user) > 1) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email'] = $user['email'];
        return true;
    } else {
        return false;
    }
}

// Log out current user
function logout() {
    global $_SESSION;

    // Unset session variables
    unset($_SESSION['user_id']);
    unset($_SESSION['email']);

    // Clear cookie
    setcookie(session_name(), time() - 72000);

    // Destroy session
    session_destroy();
}

// For cleaning data and being safe from vulnerabilities
function make_safe($string) {
    $string = htmlentities($string, ENT_QUOTES);
    if (get_magic_quotes_gpc()) {
       $string = stripslashes($string);
    }
    $string = strip_tags($string);
    $string = mysql_real_escape_string(trim($string));

    return $string;
}
