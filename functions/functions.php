<?php
require_once '../libraries/db.php';

function get_users_infos() {
    $db = db_connect();
    $sql = "SELECT * FROM `users_infos`";
    $infosStmt = $db->query($sql);
    $users_infos = $infosStmt->fetchAll(PDO::FETCH_ASSOC);
    return $users_infos;
}

function is_not_empty_and_defined($input) {
    return (!empty($input) and isset($input));
}


function is_credential_exists($var) {
    $credentials = [];
    foreach (get_users_infos() as $user) {
        $user_credential = $user['credential'];
        array_push($credentials, $user_credential);     
    }
    if(in_array($var, $credentials)) {
        return true;
    }
    else {
        return false;
    }
}

?>