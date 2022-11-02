<?php

function is_connected() {
    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return !empty($_SESSION['connected']);
}

function go_to_login() {
    if(!is_connected()) {
        header('Location: ./login.php');
    } 
}


?>