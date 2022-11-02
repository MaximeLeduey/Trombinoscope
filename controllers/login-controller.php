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
    $sql = "SELECT password FROM `users_infos` WHERE credential = '$credential'";
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

function is_admin($id) {
    $db = db_connect();
    $sql = "SELECT admin FROM `users_infos` WHERE user_id = '$id'";
    $infosStmt = $db->query($sql);
    $infos = $infosStmt->fetchAll(PDO::FETCH_ASSOC);
    $isAdmin = $infos[0]['admin'];
    if($isAdmin == 1) {
        return true;
    }
    else {
        return false;
    }
}



function get_id($credential) {
    $db = db_connect();
    $sql = "SELECT user_id FROM `users_infos` WHERE credential = '$credential'";
    $infosStmt = $db->query($sql);
    $infos = $infosStmt->fetchAll(PDO::FETCH_ASSOC);
    $id = $infos[0]['user_id'];
    return $id;
}


function create_session() {
    session_start();
    $id = get_id($_POST['credential']);
    $_SESSION['id'] = $id;
    if(is_admin($id)) {
        $_SESSION['admin'] = true;
    }
    else {
        $_SESSION['admin'] = false;
    }
}

$message;
function verifyAll() {
    if(is_not_empty_and_defined($_POST['credential']) and (is_not_empty_and_defined($_POST['password']))) {
        if(is_credential_exists()) {
                if(verify_password()) {
                    header('Location: ../vues/dashboard.php');
                    create_session();
                }
                else {
                    $message = "Mot de passe incorrect";
                }
        }
        else {
            $message = "Identifiant ou mot de passe incorrect";
        }
    }
    else {
        $message = "Veuillez remplir tous les champs";
    }
    echo $message;
}

verifyAll();

?>