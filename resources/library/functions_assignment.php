<?php

// Create a new assignment and add it to the `assignments` database
function create_assignment($class_id, $title, $desc, $due_date, $post_date = null, $duration = null) {
    global $db_connection;

    // Fail-safe
    if ($class_id == '' || $title == '' || $due_date == '')
        return false;
//
//     // // Inset the new assignment into the `assignments` database
//     // $db_connection->exec("INSERT INTO `classes`
//     // ( `class_id`, `title`, `desc`, `post_date`, `due_date`, `duration` )
//     // VALUES
//     // ( '$title', '$desc' )");
//     //
//     // // Grab the id of the class we just added
//     // $class_id = $db_connection->lastInsertId();
//     //
//     // // Add the current user to the new class if specified
//     // if ($add_user) {
//     //     $user_id = $_SESSION['user_id'];
//     //     $db_connection->exec("INSERT INTO `users-classes`
//     //     ( `user_id`, `class_id`, `role`, `color` )
//     //     VALUES
//     //     ( $user_id, $class_id, 'owner', 'green' )");
//     // }

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
// // Returns a list of classes for a given user
// function get_class_ids($user_id) {
//     global $db_connection;
//
//     // Query 'users-classes' for entrys with this this user_id
//     $query = $db_connection->query("SELECT `class_id` FROM `users-classes` WHERE `user_id`='$user_id';");
//     $query = $query->fetchAll(PDO::FETCH_COLUMN);
//
//     // Break down to array of just class_id's
//     $classes = array_values($query);
//
//     // Return the array to caller
//     return $classes;
// }
//
// // Returns information array for the specified class
// function get_class_info($class_id) {
//     global $db_connection;
//
//     // Query 'classes' for class with matching class_id
//     $query1 = $db_connection->query("SELECT `title`, `desc` FROM `classes` WHERE `class_id`='$class_id';");
//     $query1 = $query1->fetchAll(PDO::FETCH_ASSOC)[0];
//
//     // Get current user_id
//     $user_id = $_SESSION['user_id'];
//
//     // Query 'users-classes' for entry with matching id's
//     $query2 = $db_connection->query("SELECT `color`, `role` FROM `users-classes` WHERE `class_id`='$class_id' AND `user_id`=$user_id;");
//     $query2 = $query2->fetchAll(PDO::FETCH_ASSOC)[0];
//
//     // Create array with the informatin we care about
//     $class_info = array(
//         'title'    =>   $query1['title'],
//         'desc'    =>   $query1['desc'],
//         'color'    =>   $query2['color'],
//         'role'    =>   $query2['role']
//     );
//
//     // Return the array to caller
//     return $class_info;
// }
