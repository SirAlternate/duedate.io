<?php require_once('load.php');

// Handle deleting classes
if (isset($_POST['action']) && isset($_POST['type'])) {
    switch ($_POST['type']) {
        case 'class': {
            switch ($_POST['action']) {
                case 'add': {
                    $name = isset($_POST['data']['name'] ) ? make_safe($_POST['data']['name']) : '';
                    $desc = isset($_POST['data']['desc'] ) ? make_safe($_POST['data']['desc']) : '';

                    if (create_class($name, $desc, true)) { echo true; }
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
        // TODO: Add assignment actions
    }

}
