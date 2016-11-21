<?php
require_once('config.php');
require_once('functions.php');

global $db_config, $db_connection;

session_start();

db_connect();
