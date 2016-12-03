<?php

// Create a new class and add it to the `classes` database, adds current user to class if specified.
function create_class($title, $desc, $color, $add_user = false) {
    global $db_connection;

    // Fail-safe
    if ($title == '' || ($add_user && !isset($_SESSION['user_id'])))
        return false;

    // Inset the new class into the `classes` database
    $db_connection->exec("INSERT INTO `classes`
    ( `title`, `desc` )
    VALUES
    ( '$title', '$desc' )");

    // Grab the id of the class we just added
    $class_id = $db_connection->lastInsertId();

    // Add the current user to the new class if specified
    if ($add_user) {
        $user_id = $_SESSION['user_id'];
        $db_connection->exec("INSERT INTO `users-classes`
		(`user_id`, `class_id`, `role`, `color`)
		VALUES
		( $user_id, $class_id, 'owner', '$color' )");
    }

    // If we made it this far we were successful
    return true;
}

// Removes current user from the specified class, delete the class if the user is owner
function remove_class($class_id) {
    global $db_connection;

    // Get the current user's role for this class
    $role = get_user_role($_SESSION['user_id'], $class_id);

    // If user is the owner remove the class, otherwise just remove the relation
    switch($role) {
        case 'owner': {
            $db_connection->exec("DELETE FROM `classes` WHERE `class_id`='$class_id'");
            return true;
        }
        default: {
            $db_connection->exec("DELETE FROM `users-classes` WHERE `class_id`='$class_id' AND `user_id`='$user_id'");
            return true;
        }
    }

    // If we made it this far we were not successful (should end in switch statment)
    return false;
}

// Get the role for the specified user in the specified class
function get_user_role($user_id, $class_id) {
    global $db_connection;

    // Search for an entry in `users-classes` that matches the two id's
    $query = $db_connection->query("SELECT `role` FROM `users-classes` WHERE `user_id`='$user_id' AND `class_id`='$class_id';");
    $query = $query->fetch(PDO::FETCH_ASSOC);
    $role = ($query) ? $query['role'] : '';

    // Return the role to caller
    return $role;
}

// Returns a list of classes for a given user
function get_class_ids($user_id) {
    global $db_connection;

    // Query 'users-classes' for entrys with this this user_id
    $query = $db_connection->query("SELECT `class_id` FROM `users-classes` WHERE `user_id`='$user_id';");
    $query = $query->fetchAll(PDO::FETCH_COLUMN);

    // Break down to array of just class_id's
    $classes = array_values($query);

    // Return the array to caller
    return $classes;
}

// Returns information array for the specified class
function get_class_info($class_id) {
    global $db_connection;

    // Query 'classes' for class with matching class_id
    $query1 = $db_connection->query("SELECT `title`, `desc` FROM `classes` WHERE `class_id`='$class_id';");
    $query1 = $query1->fetchAll(PDO::FETCH_ASSOC)[0];

    // Get current user_id
    $user_id = $_SESSION['user_id'];

    // Query 'users-classes' for entry with matching id's
    $query2 = $db_connection->query("SELECT `color`, `role` FROM `users-classes` WHERE `class_id`='$class_id' AND `user_id`=$user_id;");
    $query2 = $query2->fetchAll(PDO::FETCH_ASSOC)[0];

    // Create array with the informatin we care about
    $class_info = array(
        'title'    =>   $query1['title'],
        'desc'    =>   $query1['desc'],
        'color'    =>   $query2['color'],
        'role'    =>   $query2['role']
    );

    // Return the array to caller
    return $class_info;
}
