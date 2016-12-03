<?php require_once('resources/library/load.php');

// Handle user logging out
if (isset($_GET["logout"]) && $_GET["logout"] == 1) {
    logout();
    header("Location: index.php?logged_out=1");
}

// Handle user deleting account
if (isset($_GET["deleteaccount"]) && $_GET["deleteaccount"] == 1)
	delete_account($_SESSION['user_id']);

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
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="resources/css/style.css">
</head>
<body id="dashboard">
    <?php if (isset($_GET["new_user"]) && $_GET["new_user"] == 1) { ?>
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
						<li><a href="?deleteaccount=1" id = "delete_account_button">Delete account</a></li>
                    </ul>
                </div>
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
                <div class="header" background="<?php $class_info['color']; ?>">
                    <h1><?php echo $class_info['title']; ?></h1>
                    <!--<a class="settings-btn"></a> <!--TODO: Add back later -->
                    <a class="close-btn"></a>
                </div>
                <ul>
				<form method ="post">
					<?php
                        $assignments = get_assignments($class_id);
						foreach ($assignments as $assignment) {
                            $post_date = isset($assignments['post_date']) ? strtotime($assignments['post_date']) : '';
                            if ($post_date == '' || $post_date > strtotime('today')) {
                        ?>
                        <li>
                            <p class="title"><?php echo $assignment['title'] ?></p>
                            <p class="due">Due
                                <?php
                                $due = strtotime($assignment['due_date']);

                                if (date('W', $due) == date('W'))
                                    echo "<b>this</b> " . date("l", $due);
                                else if (date('W', $due) == date('W')+1)
                                    echo "<em>next</em> " . date("l", $due);
                                else
                                    echo date("l n/j", $due);
                                ?>
                            </p>
                            <p class='duration'>
                            <?php if (isset($assignment['duration'])) {
                                echo "Est Time: " . $assignment['duration'];
                            } ?>
                        </p>
                            <span class="arrow"></span>
                        </li>
					<?php
                            }
						}
					?>
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
                <div class="form-group">
                    <label for="class_name">Class Name:</label></br>
                    <input type="text" name="class_name" required="required" />
                </div>
                <div class="form-group">
                    <label>Color:</label>
                    <div class="colors">
                        <?php
                            $colors = array (
                                'red', 'violet', 'blue', 'cyan', 'green', 'yellow', 'orange'
                            );

                            foreach ($colors as $color) {
                            ?>
                               <input id="<?php echo $color; ?>" type="radio" name="color" value="<?php echo $color; ?>">
                               <label for="<?php echo $color; ?>"></label> 
                            <?php
                            }
                        ?>
                    </div>
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
