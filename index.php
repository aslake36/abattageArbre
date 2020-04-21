<?php

require_once 'Controler/Redirection.php';

session_start();



if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case "toJson":
            toJson();
            break;
        default :
            home();
            break;
    }
} else {
    unset($_POST);
    home();
}