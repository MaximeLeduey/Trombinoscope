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
}

function verifyAll() {
    if(is_not_empty_and_defined($_POST['credential'])) {
        if(is_credential_exists()) {
            if(is_not_empty_and_defined($_POST['password'])) {
                if(verify_password()) {
                    header('Location: ../vues/dashboard.php');
                    create_session();
                }
                else {
                    echo "Mot de passe incorrect";
                }
            }
            else {
                echo "Veuillez saisir un mot de passe";
            }
        }
        else {
            echo "Identifiant incorrect";
        }
    }
    else {
        echo "Veuillez remplir le champ identifiant";
    }
}

verifyAll();

?>