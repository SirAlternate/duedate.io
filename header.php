<?php require_once('resources/library/load.php');

// If user is not logged in send them to the index page
if(!isset($_SESSION['user_id']))
    header('Location: index.php');

// Handle user logging out
if (isset($_GET["logout"])) {
    logout();
    header('Location: index.php?logged_out');
}

// Get current user's information for populating page
$user = get_user_info($_SESSION['email']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>duedate.io</title>

    <!-- Stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7COpen+Sans:300,400,400i,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="resources/css/style.css">
</head>
<body id="dashboard">
    <?php if (isset($_SESSION["state"]) && $_SESSION["state"] == "new_user") {
        unset($_SESSION["state"]);
    ?>
    <div class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Welcome to duedate.io, <?php echo $user["first_name"] ?>!</strong>
    </div>
    <?php } ?>
    <header class="navbar">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="dashboard.php">duedate.io</a>
            </div>
            <div class="navbar-user">
                <a class="user">
                    <p class="name"><?php echo $user['full_name'] ?></p>
                    <img class="avatar" />
                </a>
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-gear"></i>
                      <span class="caret"></span></button>
                      <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="?logout" id="logout_button">Log out</a></li>
						<li><a href="?changesettings=1" id = "change_settings_button">Account Settings</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
