<?php

// rename the magical function to avoid conflicts with extensions/dependencies
spl_autoload_register('serviceAutoloader');

// dynamically load necessary classes
function serviceAutoloader($class) {
    $class = strtolower($class);
    switch (substr($class, 0, 2)) {
        case 'm_' : {
                include_once APPLICATION_MODEL_PATH . $class . ".class.php";
            }
            break;
        case 'v_' : {
                include_once APPLICATION_VIEW_PATH . $class . ".class.php";
            }
            break;
        case 'c_' : {
                include_once APPLICATION_CONTROLLER_PATH . $class . ".class.php";
            }
            break;
        default : {
                if (file_exists(APPLICATION_EXTENSION_PATH . $class . "/" . $class . ".class.php")) {
                    include_once (APPLICATION_EXTENSION_PATH . $class . "/" . $class . ".class.php");
                }
            }
            break;
    }
}