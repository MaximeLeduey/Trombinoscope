<?php 

require_once '../functions/functions.php';



/** fonction qui va chercher le mot de passe selon l'identifiant
 * @param string $credential
 * @return string
 */

function get_pwd($credential) : string  {
    $db = db_connect();
    $sql = "SELECT password FROM `users_infos` WHERE credential = '$credential'";
    $infosStmt = $db->query($sql);
    $infos = $infosStmt->fetchAll(PDO::FETCH_ASSOC);
    $password = $infos[0]['password'];
    return $password;
}


/** fonction qui verifie si le mot de passe rentré par l'utilisateur correspond au mot de passe hashé pris dans la base
 * de données
 * @return bool
 */

function verify_password() : bool {
    $inputPwd = $_POST['password'];
    $dbPwd = get_pwd($_POST["credential"]);
    return password_verify($inputPwd, $dbPwd);
}


/** fonction qui verifie si l'utilisateur qui veut se connecter est un admin
 * @param int $id
 * @return bool
 */

function is_admin($id) : bool {
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


/** fonction qui va chercher l'id de l'utilisateur selon son identifiant
 * @param string $credential
 * @return int 
 */

function get_id($credential) : int {
    $db = db_connect();
    $sql = "SELECT user_id FROM `users_infos` WHERE credential = '$credential'";
    $infosStmt = $db->query($sql);
    $infos = $infosStmt->fetchAll(PDO::FETCH_ASSOC);
    $id = $infos[0]['user_id'];
    return $id;
}


/** fonction qui cree une session pour l'utilisateur qui se connecte, avec les bonnes informations
 * 
 */

function create_session() {
    session_start();
    $id = get_id($_POST['credential']);
    $_SESSION['connected'] = 1;
    $_SESSION['id'] = $id;
    if(is_admin($id)) {
        $_SESSION['admin'] = 1;
    }
    else {
        $_SESSION['admin'] = 0;
    }
}


/** fonction qui verifie toutes les informations à l'aide des fonctions ci-dessus, et qui
 * connecte ou non l'utilisateur 
 * 
 */

$message;
function verifyAll() {
    if(is_not_empty_and_defined($_POST['credential']) and (is_not_empty_and_defined($_POST['password']))) {
        if(is_credential_exists($_POST['credential'])) {
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