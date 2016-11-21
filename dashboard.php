<?php require_once('resources/library/load.php');

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}

// Handle logging out
if (isset($_POST['logout'])) {
    logout($_SESSION['email']);
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
    <link rel="stylesheet" href="resources/css/style.css">
</head>
<body>
    <?php echo "Welcome " . $_SESSION['email'] ?>
    <form method="post" class="logout">
        <div class="form_group">
            <input type="submit" name="logout" value="Logout" />
        </div>
    </form>

    <!-- Scripts -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="resources/js/scripts.min.js"></script>
</body>
</html>
