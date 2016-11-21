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
    if($select_db) {
        try {
            $db_connection->exec("USE `".$db_config['name']."`;");
        } catch(PDOException $e) {
            // echo 'Could not select database: ' . $e->getMessage();
            return false;
        }
    }

    return true;
}
