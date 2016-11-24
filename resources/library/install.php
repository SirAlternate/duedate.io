<?php require_once('load.php');

// Connect to the database (false means we are just connecting)
db_connect(false);

// Create a new database if one doesn't already exist
// $db_connection->exec("DROP DATABASE IF EXISTS `".$db_config['name']."`;");
$db_connection->exec("CREATE DATABASE IF NOT EXISTS `" . $db_config['name'] . "`");

// Select the database
try {
    $db_connection->exec("USE `".$db_config['name']."`;");
} catch(PDOException $e) {
    echo 'Could not select database: ' . $e->getMessage();
}

// Create 'users' table if doesn't already exist
$db_connection->exec("CREATE TABLE IF NOT EXISTS `users` (
    `user_id` int(7) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` varchar(32) NULL,
    `password` varchar(64) NULL,
    `salt` varchar(64) NULL,
    `first_name` varchar(32) NULL,
    `last_name` varchar(32) NULL
)");

// Create 'classes' table if doesn't already exist
$db_connection->exec("CREATE TABLE IF NOT EXISTS `classes` (
    `class_id` int(7) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title` varchar(32) NOT NULL,
    `desc` varchar(256) NULL
)");

// Create 'memberships' table if doesn't already exist
$db_connection->exec("CREATE TABLE IF NOT EXISTS `users-classes` (
    `id` int(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` int(7) NOT NULL,
    `class_id` int(7) NOT NULL,
    `role` varchar(32) NULL,
    `color` varchar(10) NOT NULL
)");

// Success message
echo "Sucessfully set up datebase";
