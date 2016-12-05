<?php include('header.php'); ?>
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
                    <i class="close-btn material-icons">close</i>
                </div>
                <ul>
					<?php
                        $assignments = get_assignments($class_id);
						foreach ($assignments as $assignment) {
                        ?>
                        <li class="item" assg-id="<?php echo $assignment['assg_id'] ?>">
                            <div class="tab">
                                <input id="checkbox-<?php echo $assignment['assg_id'] ?>" type="checkbox" <?php if (is_complete($assignment['assg_id'])) { echo 'checked'; } ?>>
                                <label for="checkbox-<?php echo $assignment['assg_id'] ?>"></label>
                            </div>
                            <div class="content">
                                <p class="title"><?php echo $assignment['title'] ?></p>
                                <p class="due">
                                    <?php
                                    $due = strtotime($assignment['due_date']);

                                    // Past due
                                    if ($due < strtotime('today'))
                                        echo "Past Due (" . date("l n/j", $due) . ")";

                                    // Today
                                    else if ($due === strtotime('today'))
                                        echo "Due <b>today</b>";

                                    // Tomorrow
                                    else if ($due === strtotime('tomorrow'))
                                        echo "Due <b>tomorrow</b>";

                                    // This week
                                    else if ($due <= strtotime('next saturday'))
                                        echo "Due <b>this</b> " . date("l", $due);

                                    // Next week
                                    else if ($due < strtotime('next saturday', strtotime('next saturday')))
                                        echo "Due <em>next</em> " . date("l", $due);

                                    // Everything else
                                    else
                                        echo "Due" . date("l n/j", $due);
                                    ?>
                                </p>
                                <!-- <p class='duration'>
                                <?php if (isset($assignment['duration'])) {
                                    echo "Est Time: " . $assignment['duration'];
                                } ?>
                                </p> -->
                            </div>
                            <div class="expand" hide="true">
                                <div class="edit">
                                    <i class="material-icons">mode_edit</i><p>Edit</p>
                                </div>
                                <div class="delete">
                                    <i class="material-icons">delete</i><p>Delete</p>
                                </div>
                            </div>
                        </li>
					<?php
						}
					?>
                    <form class="add-assignment" method="post" hide="true">
                        <div class="form-group">
                            <label for="assg_title">Title:</label></br>
                            <input type="text" name="assg_title" required="required" />
                        </div>
                        <div class="form-group">
                            <label for="assg_due">Due:</label></br>
                            <input type="date" name="assg_due" />
                        </div>
                        <div class="form-group">
                            <label for="assg_desc">Description:</label></br>
                            <input type="text" name="assg_desc" />
                        </div>
                        <div class="form-group">
                            <input type="submit" name="add_assg" value="Create Assignment" />
                        </div>
                    </form>
                    <li class="add-btn">
                        <i class="material-icons">add</i>
                    </li>
                </ul>
            </div>
        <?php
        }

        $show_form = (count($classes) == 0) ? true : false;
        ?>
        <div class="class new" hide="<?php echo var_export(!$show_form); ?>">
            <div class="header">
                <h1>New Class</h1>
                <i class="close-btn material-icons">close</i>
            </div>
            <form class="add-class" method="post">
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
<?php include('footer.php'); ?>
