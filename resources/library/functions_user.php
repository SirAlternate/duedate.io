<?php

// Create a new user and add it to the `users` database
function create_user($first_name, $last_name, $email, $password) {
    global $db_connection;

    // Fail-safe
    if (user_exists($email))
        return false;

    // Generate random salt
    $salt = hash('sha256', uniqid(mt_rand(), true));

    // Prepend the salt to the password and hash it
    $salted = hash('sha256', $salt . $password);

    // Inset the new user into the `users` database
    $db_connection->exec("INSERT INTO `users`
    ( `first_name`, `last_name`, `email`, `password`, `salt` )
    VALUES
    ( '$first_name', '$last_name', '$email', '$salted', '$salt' )");

    // If we made it this far we were successful
    return true;
}

// Attempt to log in with given email and password combination
function login($email, $password) {
    global $db_connection;

    // Query `users` database for this user's salt, get's set to empty string by default
    $query = $db_connection->query("SELECT `salt` FROM `users` WHERE `email`='$email';");
    $query = $query->fetch(PDO::FETCH_ASSOC);
    $salt = ($query) ? $query['salt'] : '';

    // Prepend the salt to the entered password and hash it
    $salted = hash('sha256', $salt . $password);

    // Query `users` database for entry with entered email and salted password
    $query = $db_connection->query("SELECT * FROM `users` WHERE `email`='$email' AND `password`='$salted';");
    $user = $query->fetch(PDO::FETCH_ASSOC);

    // Check if this email/password combination was successful and return accordingly
    if (count($user) > 1) {
        // Set session variables
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email'] = $user['email'];

        return true;
    } else {
        return false;
    }
}

// Log out the current user
function logout() {
    // Unset session variables
    unset($_SESSION['user_id']);
    unset($_SESSION['email']);

    // Clear browser cookie
    setcookie(session_name(), time() - 72000);

    // Destroy session
    session_destroy();
}


function delete_account($user_id){



	global $db_connection;
	$sql = "DELETE FROM `users` WHERE `users`.`user_id` = '$user_id'";
	$db_connection->exec($sql);



	 // Unset session variables
    unset($_SESSION['user_id']);
    unset($_SESSION['email']);

    // Clear browser cookie
    setcookie(session_name(), time() - 72000);

    // Destroy session
    session_destroy();
    header('Location: index.php?logged_out=2');

}



// Check if user with specifed email exists `users` database
function user_exists($email) {
    global $db_connection;

    // Query database for a user with the given email
    $query = $db_connection->query("SELECT * FROM `users` WHERE `email`='$email';");
    $user = $query->fetch(PDO::FETCH_ASSOC);

    // Check if we found any users and return accordingly
    if (count($user) > 1)
        return true;
    else
        return false;
}

// Returns information array for the specified user
function get_user_info($email) {
    global $db_connection;

    // Query database for the current user
    $query = $db_connection->query("SELECT * FROM `users` WHERE `email`='$email';");
    $query = $query->fetch(PDO::FETCH_ASSOC);

    // Create user array with relevent info
    $user = array(
        'id'  =>  $query['user_id'],
        'first_name'  =>  $query['first_name'],
        'last_name'  =>  $query['last_name'],
        'full_name'  =>  $query['first_name'] . " " . $query['last_name'],
        'email'  =>  $query['email']
    );

    // Return the user array back to caller
    return $user;
}


function change_email($old_email, $new_email, $new_emailc) {
    global $db_connection;

    // Fail-safe
    if ($new_email == '')
        return false;

	if ($new_email != $new_emailc)
		return false;



    if (!user_exists($old_email))
		return false;

	 $db_connection->exec("UPDATE `users`
		SET 'email' = '$new_email'
		WHERE 'email' = '$old_email'");

    // If we made it this far we were successful
    return true;
}
