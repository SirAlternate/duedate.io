<?php require_once('load.php');

// Connect to the database (false means we are just connecting)
db_connect(false);

// Clear session variables
logout();

// Create a new database if one doesn't already exist
$db_connection->exec("DROP DATABASE IF EXISTS `".$db_config['name']."`;");
$db_connection->exec("CREATE DATABASE IF NOT EXISTS `" . $db_config['name'] . "` COLLATE utf8_general_ci");

// Select the database
try {
    $db_connection->exec("USE `".$db_config['name']."`;");
} catch(PDOException $e) {
    echo 'Could not select database: ' . $e->getMessage();
}

// Create 'users' table if doesn't already exist
$db_connection->exec("CREATE TABLE IF NOT EXISTS `users` (
    `user_id` int(7) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `first_name` varchar(32) NULL,
    `last_name` varchar(32) NULL,
    `email` varchar(32) NULL,
    `password` varchar(64) NULL,
    `salt` varchar(64) NULL
)");

// Create 'classes' table if doesn't already exist
$db_connection->exec("CREATE TABLE IF NOT EXISTS `classes` (
    `class_id` int(7) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title` varchar(32) NOT NULL,
    `desc` varchar(256) NULL
)");

// Create 'users-classes' table if doesn't already exist
$db_connection->exec("CREATE TABLE IF NOT EXISTS `users-classes` (
    `user_id` int(7) NOT NULL,
    `class_id` int(7) NOT NULL,
    `role` varchar(32) NULL,
    `color` varchar(10) NOT NULL,
    FOREIGN KEY (`user_id`)
        REFERENCES `users`(`user_id`)
        ON DELETE CASCADE,
    FOREIGN KEY (`class_id`)
        REFERENCES `classes`(`class_id`)
        ON DELETE CASCADE
)");

// Create 'assignment' table if doesn't already exist
$db_connection->exec("CREATE TABLE IF NOT EXISTS `assignments` (
    `assg_id` int(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `class_id` int(7) NOT NULL,
    `title` varchar(32) NOT NULL,
    `desc` varchar(256) NULL,
    `post_date` date NULL,
    `due_date` date NOT NULL,
    `duration` time NULL,
    FOREIGN KEY (`class_id`)
        REFERENCES `classes`(`class_id`)
        ON DELETE CASCADE
)");

// Create 'assignents-cmpl' table if doesn't already exist
$db_connection->exec("CREATE TABLE IF NOT EXISTS `assignments-cmpl` (
    `assg_id` int(8) NOT NULL,
    `user_id` int(7) NOT NULL,
    `timestamp` date NULL,
    FOREIGN KEY (`assg_id`)
        REFERENCES `assignments`(`assg_id`)
        ON DELETE CASCADE,
    FOREIGN KEY (`user_id`)
        REFERENCES `users`(`user_id`)
        ON DELETE CASCADE
)");

// Success message
echo "Sucessfully set up datebase";
