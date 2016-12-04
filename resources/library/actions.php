<?php require_once('load.php');

// Handle deleting classes
if (isset($_POST['action']) && isset($_POST['type'])) {
    switch ($_POST['type']) {
        case 'class': {
            switch ($_POST['action']) {
                case 'add': {
                    $name = isset($_POST['data']['name']) ? make_safe($_POST['data']['name']) : '';
                    $desc = isset($_POST['data']['desc']) ? make_safe($_POST['data']['desc']) : '';
                    $color = isset($_POST['data']['color']) ? make_safe($_POST['data']['color']) : '';

                    if (create_class($name, $desc, $color, true)) { echo true; }
                    else { echo false; }
                    break;
                }
                case 'delete': {
                    if (remove_class($_POST['id'])) { echo true; }
                    else { echo false; }
                    break;
                }
            }
            break;
        }
        case 'assignment': {
            switch ($_POST['action']) {
                case 'get': {
                    echo get_assignment($assg_id);
                    break;
                }
                case 'add': {
                    $class_id = isset($_POST['data']['class_id']) ? make_safe($_POST['data']['class_id']) : '';
                    $title = isset($_POST['data']['title']) ? make_safe($_POST['data']['title']) : '';
                    $due_date = isset($_POST['data']['due_date']) ? make_safe($_POST['data']['due_date']) : '';
                    $desc = isset($_POST['data']['desc']) ? make_safe($_POST['data']['desc']) : '';

                    if (create_assignment($class_id, $title, null, $due_date, $desc)) { echo true; }
                    else { echo false; }
                    break;
                }
                case 'delete': {

                    break;
                }
                case 'finish': {

                    break;
                }
            }
            break;
        }
        // TODO: Add assignment actions
    }

}
