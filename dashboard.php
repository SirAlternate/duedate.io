<?php require_once('resources/library/load.php');

// Handle user logging out
if (isset($_POST['logout']))
    logout();

// If user is not logged in send them to the index page
if(!isset($_SESSION['user_id']))
    header('Location: index.php');

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
    <link rel="stylesheet" href="resources/css/style.min.css">
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
                <a class="user">
                    <p class="name"><?php echo $user['full_name'] ?></p>
                    <img class="avatar" />
                </a>
                <a class="settings-btn"></a>
            </div>
        </div>
    </header>
    <div class="row display">
        <?php
        $classes = get_class_ids($user['id']);
        foreach ($classes as $class_id) {
            $class_info = get_class_info($class_id);
        ?>
            <div class="class" color="<?php echo $class_info['color']; ?>" class-id="<?php echo $class_id; ?>">
                <div class="header">
                    <h1><?php echo $class_info['title']; ?></h1>
                    <!-- <a class="settings-btn"></a> TODO: Add back later -->
                    <a class="close-btn"></a>
                </div>
                    <!-- <li>
                        <p class="title">Assignment 1</p>
                        <p class="due">Due Tuesday 11/22</p>
                        <p class="duration">Est Time: 1:00</p>
                        <span class="arrow"></span>
                    </li> -->
                </ul>
            </div>
        <?php
        }

        $show_form = (count($classes) == 0) ? true : false;
        ?>
        <div class="class new" hide="<?php echo var_export(!$show_form); ?>">
            <div class="header">
                <h1>New Class</h1>
                <a class="close-btn"></a>
            </div>
            <form class="col-md-5 add-class" method="post">
                <div class='form-group'>
                    <label idfor="class_name">Class Name:</label></br>
                    <input type="text" name="class_name" required="required" />
                </div>
                <div class="form-group">
                    <label for="class_desc">Description:</label></br>
                    <input type="text" name="class_desc" />
                </div>
                <div class="form-group">
                    <input type="submit" name="add_class" value="Create class" />
                </div>
            </form>
        </div>
        <div class="add-class-btn" hide="<?php echo var_export($show_form); ?>"></div>
    </div>

    <!-- Scripts -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script> window.jQuery || document.write("<script src='resources/js/jquery.min.js'><\/script>") </script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script> window.jQuery || document.write("<script src='resources/js/bootstrap.min.js'><\/script>") </script>
    <script src="resources/js/validator.min.js"></script>
    <script src="resources/js/scripts.min.js"></script>
</body>
</html>
