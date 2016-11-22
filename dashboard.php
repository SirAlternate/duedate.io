<?php require_once('resources/library/load.php');

// If user is not logged in send back to index page
if(!isset($_SESSION['user_id'])) {
    header('Location: index.php');
}

// Handle logging out
if (isset($_POST['logout'])) {
    logout();
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
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7COpen+Sans:300,400,400i,600" rel="stylesheet">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/style.css">
</head>
<body id="dashboard">
    <header class="navbar">
        <div class="container">
            <div class="navbar-header">
                <div class="navbar-brand" href="">duedate.io</div>
            </div>
            <div class="navbar-user">
                <form method="post" class="logout">
                    <div class="form_group">
                        <input type="submit" name="logout" value="Logout" />
                    </div>
                </form>
                <?php $user = get_user(); ?>
                <a class="user">
                    <p class="name"><?php echo $user["name"] ?></p>
                    <img class="avatar" />
                </a>
                <a class="settings-btn"></a>
            </div>
        </div>
    </header>
    <div class="row display">
        <div class="class" color="green">
            <div class="header">
                Class A <a class="settings-btn"></a>
            </div>
            <ul class="assignments">
                <li>
                    <p class="title">Assignment 1</p>
                    <p class="due">Due <b>this</b> Tuesday</p>
                    <p class="duration">Est Time: 1:00</p>
                    <span class="arrow"></span>
                </li>
                <li>
                    <p class="title">Assignment 1</p>
                    <p class="due">Due <em>next</em> Tuesday</p>
                    <p class="duration">Est Time: 1:00</p>
                    <span class="arrow"></span>
                </li>
                <li>
                    <p class="title">Assignment 1</p>
                    <p class="due">Due Tuesday 11/22</p>
                    <p class="duration">Est Time: 1:00</p>
                    <span class="arrow"></span>
                </li>
                <li>
                    <p class="title">Assignment 1</p>
                    <p class="due">Due Tuesday 11/22</p>
                    <p class="duration">Est Time: 1:00</p>
                    <span class="arrow"></span>
                </li>
                <li>
                    <p class="title">Assignment 1</p>
                    <p class="due">Due Tuesday 11/22</p>
                    <p class="duration">Est Time: 1:00</p>
                    <span class="arrow"></span>
                </li>
                <li>
                    <p class="title">Assignment 1</p>
                    <p class="due">Due Tuesday 11/22</p>
                    <p class="duration">Est Time: 1:00</p>
                    <span class="arrow"></span>
                </li>
                <li>
                    <p class="title">Assignment 1</p>
                    <p class="due">Due Tuesday 11/22</p>
                    <p class="duration">Est Time: 1:00</p>
                    <span class="arrow"></span>
                </li>
                <li>
                    <p class="title">Assignment 1</p>
                    <p class="due">Due Tuesday 11/22</p>
                    <p class="duration">Est Time: 1:00</p>
                    <span class="arrow"></span>
                </li>
                <li>
                    <p class="title">Assignment 1</p>
                    <p class="due">Due Tuesday 11/22</p>
                    <p class="duration">Est Time: 1:00</p>
                    <span class="arrow"></span>
                </li>
                <li>
                    <p class="title">Assignment 1</p>
                    <p class="due">Due Tuesday 11/22</p>
                    <p class="duration">Est Time: 1:00</p>
                    <span class="arrow"></span>
                </li>
                <li>
                    <p class="title">Assignment 1</p>
                    <p class="due">Due Tuesday 11/22</p>
                    <p class="duration">Est Time: 1:00</p>
                    <span class="arrow"></span>
                </li>
            </ul>
        </div>
        <div class="class" color="green">
            <div class="header">
                Class A <a class="settings-btn"></a>
            </div>
            <ul class="assignments">
                <li>
                    <p class="title">Assignment 1</p>
                    <p class="due">Due Tuesday 11/22</p>
                    <p class="duration">Est Time: 1:00</p>
                    <span class="arrow"></span>
                </li>
            </ul>
        </div>
        <div class="class" color="green">
            <div class="header">
                Class A <a class="settings-btn"></a>
            </div>
            <ul class="assignments">
                <li>
                    <p class="title">Assignment 1</p>
                    <p class="due">Due Tuesday 11/22</p>
                    <p class="duration">Est Time: 1:00</p>
                    <span class="arrow"></span>
                </li>
            </ul>
        </div>
        <div class="class" color="green">
            <div class="header">
                Class A <a class="settings-btn"></a>
            </div>
            <ul class="assignments">
                <li>
                    <p class="title">Assignment 1</p>
                    <p class="due">Due Tuesday 11/22</p>
                    <p class="duration">Est Time: 1:00</p>
                    <span class="arrow"></span>
                </li>
            </ul>
        </div>
        <div class="class" color="green">
            <div class="header">
                Class A <a class="settings-btn"></a>
            </div>
            <ul class="assignments">
                <li>
                    <p class="title">Assignment 1</p>
                    <p class="due">Due Tuesday 11/22</p>
                    <p class="duration">Est Time: 1:00</p>
                    <span class="arrow"></span>
                </li>
            </ul>
        </div>
        <div class="class" color="green">
            <div class="header">
                Class A <a class="settings-btn"></a>
            </div>
            <ul class="assignments">
                <li>
                    <p class="title">Assignment 1</p>
                    <p class="due">Due Tuesday 11/22</p>
                    <p class="duration">Est Time: 1:00</p>
                    <span class="arrow"></span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Scripts -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="resources/js/validator.min.js"></script>
    <script src="resources/js/scripts.min.js"></script>
</body>
</html>
