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
                case 'add': {
                    $class_id = isset($_POST['data']['class_id']) ? make_safe($_POST['data']['class_id']) : '';
                    $title = isset($_POST['data']['title']) ? make_safe($_POST['data']['title']) : '';
                    $due_date = isset($_POST['data']['due_date']) ? make_safe($_POST['data']['due_date']) : '';
                    $desc = isset($_POST['data']['desc']) ? make_safe($_POST['data']['desc']) : '';

                    if (create_assignment($class_id, $title, $due_date, $desc)) { echo true; }
                    else { echo false; }
                    break;
                }
                case 'delete': {
                    if (remove_assignment($_POST['id'])) { echo true; }
                    else { echo false; }
                    break;
                }
                case 'finish': {
                    if (finish_assignment($_POST['id'])) { echo true; }
                    else { echo false; }
                    break;
                }
                case 'unfinish': {
                    if (unfinish_assignment($_POST['id'])) { echo true; }
                    else { echo false; }
                    break;
                }
            }
            break;
        }
    }
}

// Handle getting info
if (isset($_GET['type'])) {
    switch ($_GET['type']) {
        case 'assignment': {
            echo json_encode(get_assignment($_GET['id']));
            break;
        }
    }
}
