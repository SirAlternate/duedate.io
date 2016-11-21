<?php
include('resources/library/config.php');
include('resources/library/functions.php');
global $db_config, $db_connection;

if (db_connect()) {
    echo "Successfully connected to database";
} else {
    echo "Must install database before visiting this page";
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>duedate.io</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/style.min.css">
</head>
<body>

    <!-- Scripts -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="resources/js/scripts.min.js"></script>
</body>
</html>
