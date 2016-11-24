<?php

// Start session
session_start();

// Require functions file
include_once('functions.php');

// Fetch global variables
global $db_config, $db_connection;

// Connect to database
db_connect();
