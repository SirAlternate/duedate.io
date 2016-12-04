<?php

// Create a new assignment and add it to the `assignments` database
function create_assignment($class_id, $title, $post_date, $due_date, $desc, $duration = null) {
    global $db_connection;

    // Fail-safe
    if ($class_id == '' || $title == '' || $due_date == '')
        return false;

    // Inset the new assignment into the `assignments` database
    $db_connection->exec("INSERT INTO `assignments`
    ( `class_id`, `title`, `desc`, `post_date`, `due_date`, `duration` )
    VALUES
    ( '$class_id', '$title', '$desc', '$post_date', '$due_date', '$duration' )");

    // If we made it this far we were successful
    return true;
}

// Gets all of the assignments for a given class
function get_assignments($class_id) {
    global $db_connection;

    // Query 'assignmnets' for entrys with this this class_id
    $query = $db_connection->query("SELECT * FROM `assignments` WHERE `class_id`='$class_id' ORDER BY `due_date`;");
    $assignments = $query->fetchAll(PDO::FETCH_ASSOC);

    // Return the array to caller
    return $assignments;
}

// Get the information for a given assignment
function get_assignment($assg_id) {
    global $db_connection;

    // Query 'assignmnets' for entrys with this this assg_id
    $query = $db_connection->query("SELECT * FROM `assignments` WHERE `assg_id`='$assg_id';");
    $assignments = $query->fetchAll(PDO::FETCH_ASSOC)[0];

    // Return the array to caller
    return $assignments;
}
