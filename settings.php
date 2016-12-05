<?php require_once('resources/library/load.php');

// Handle user logging out
if (isset($_GET["logout"]) && $_GET["logout"] == 1)
    logout();

// Handle user deleting account
if (isset($_GET["deleteaccount"]) && $_GET["deleteaccount"] == 1)
	delete_account($_SESSION['user_id']);


if (isset($_GET["dashboard"]) && $_GET["dashboard"] == 1)
	header('Location: dashboard.php');
// If user is not logged in send them to the index page
if(!isset($_SESSION['user_id']))
    header('Location: index.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$new_email = $_POST['new_email'];
	$new_emailc = $_POST['new_emailc'];
	$user_id= $_SESSION['user_id'];
if ($new_email != '' && isset($_SESSION['user_id']) && $new_email == $new_emailc){
      global $db_connection;	  
	  
	  $sql = "UPDATE `users` SET `email` = '$new_email' WHERE `user_id` = $user_id";
    // Update the info in the database
    $db_connection->exec($sql);
    
    // If we made it this far we were successful
} 
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
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="resources/css/style.css">
</head>
<body id="dashboard">

    <header class="navbar">
        <div class="container">
            <div class="navbar-header">
                <div class="navbar-brand" href="">duedate.io</div>
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
                        <li><a href="?logout=1" id="logout_button">Log out</a></li>
						<li><a href="?deleteaccount=1" id = "delete_account_button">Delete Account</a></li>
						<li><a href="?dashboard=1" id="dashboard_button" >Go To Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
	
		<div class="row display"">
            <div class="class">
                <div class="header" background="blue">
                    <h1>Change Email</h1>
                    
                </div>
                <form  class = "col-md-5 change-email" method = "post" >
					<label for="new_email">New Email:</label>
					<input type = "email" name="new_email" />
					<br />
					<label for="new_emailc">Confirm New Email:</label>
					<input type = "email" name="new_emailc" />
					<br />
					<input type = "submit" name="change-email" value ="Change Email" />
					
				</form>
            </div>
			
			<div class="class">
                <div class="header" background="cyan">
                    <h1>Change Password</h1>
                </div>
                <form  class = "col-md-5 change-password" method = "post" >
					<label for="old_pass">Old Password:</label>
					<input type = "password" name="old_pass" />
					<br />
					<label for="new_pass">New Password:</label>
					<input type = "password" name="new_pass" />
					<br />
					<label for="new_passc">Confirm New Password:</label>
					<input type = "password" name="new_passc" />
					<br />
					<input type = "submit" value ="Change Password" />
					
				</form>
            </div>
		</div>
       
    </div>

    <!-- Scripts -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script> window.jQuery || document.write("<script src='resources/js/jquery.min.js'><\/script>") </script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script> window.jQuery || document.write("<script src='resources/js/bootstrap.min.js'><\/script>") </script>
    <script src="resources/js/validator.min.js"></script>
    <script src="resources/js/scripts.js"></script>
</body>
</html>
