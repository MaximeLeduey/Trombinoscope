<?php 

require_once '../functions/functions.php';


function is_not_empty_and_defined($input) {
    return (!empty($input) and isset($input));
}


function is_credential_exists() {
    $credentials = [];
    foreach (get_users_infos() as $user) {
        $user_credential = $user['credential'];
        array_push($credentials, $user_credential);     
    }
    if(in_array($_POST['credential'], $credentials)) {
        return true;
    }
    else {
        return false;
    }
}

function get_pwd($credential) {
    $db = db_connect();
    $sql = "SELECT password FROM `students_infos` WHERE credential = '$credential'";
    $infosStmt = $db->query($sql);
    $infos = $infosStmt->fetchAll(PDO::FETCH_ASSOC);
    $password = $infos[0]['password'];
    return $password;
}


function verify_password() {
    $inputPwd = $_POST['password'];
    $dbPwd = get_pwd($_POST["credential"]);
    return password_verify($inputPwd, $dbPwd);
}


function get_id($credential) {
    $db = db_connect();
    $sql = "SELECT student_id FROM `students_infos` WHERE credential = '$credential'";
    $infosStmt = $db->query($sql);
    $infos = $infosStmt->fetchAll(PDO::FETCH_ASSOC);
    $id = $infos[0]['student_id'];
    return $id;
}

?>