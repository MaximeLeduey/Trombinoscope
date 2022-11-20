<?php
require_once __DIR__.'/../libraries/db.php';

/** fonction qui va chercher toutes les informations de la table users infos
 * @return array
 */


function get_users_infos() : array {
    $db = db_connect();
    $sql = "SELECT * FROM `users_infos`";
    $infosStmt = $db->query($sql);
    $users_infos = $infosStmt->fetchAll(PDO::FETCH_ASSOC);
    return $users_infos;
}

/** fonction qui retourne une condition pour savoir si la valeur de l'input est definie et non nulle 
 *
 */

function is_not_empty_and_defined($input) {
    return (!empty($input) and isset($input));
}


/** fonction qui verifie si l'identifiant rentré par l'utilisateur correspond à un des identifiants de la bdd
 * @param string $var
 * @return bool
 */

function is_credential_exists($credential) {
    $credentials = [];
    foreach (get_users_infos() as $user) {
        $user_credential = $user['credential'];
        array_push($credentials, $user_credential);     
    }
    if(in_array($credential, $credentials)) {
        return true;
    }
    else {
        return false;
    }
}


/** fonction qui va chercher le nom et l'id de chaque niveau de classe dans la table grades
 * @return array
 */

function get_grades() : array {
    $db = db_connect();
    $sql = "SELECT grade_name, grade_id FROM `grades`";
    $infosStmt = $db->query($sql);
    $grades = $infosStmt->fetchAll(PDO::FETCH_ASSOC);
    return $grades;
}


/** fonction qui va chercher le nom et l'id de chaque specialité dans la table specialties
 * @return array
 */

function get_specialties() : array {
    $db = db_connect();
    $sql = "SELECT specialty_name, specialty_id FROM `specialties`";
    $infosStmt = $db->query($sql);
    $specialties = $infosStmt->fetchAll(PDO::FETCH_ASSOC);
    return $specialties;
}


/** fonction qui va chercher le nom, prénom de tous les étudiants selon leur classe, par ordre alphabétique
 * @param int $grade_id
 * @return array
 */

function get_users_by_grade(int $grade_id) : array {
    $db = db_connect();
    $sql = "SELECT last_name, first_name, user_id FROM `users` WHERE grade_id = '$grade_id' ORDER BY last_name";
    $infosStmt = $db->query($sql);
    $users_by_grade = $infosStmt->fetchAll(PDO::FETCH_ASSOC);
    return $users_by_grade;
}


/** fonction qui va chercher les informations détaillées d'un utilisateur selon son id
 * @param int $user_id
 * @return array
 */

function get_user_infos_by_id(int $user_id) : array {
    $db = db_connect();
    $sql = "SELECT age, specialty_id, city, email FROM `users_infos` WHERE user_id = '$user_id'";
    $infosStmt = $db->query($sql);
    $user_infos_by_id = $infosStmt->fetchAll(PDO::FETCH_ASSOC);
    return $user_infos_by_id;
}


/** fonction qui va chercher le nom d'une specialité selon son id
 * @param int $specialty_id
 * @return array
 */

function get_specialty_name_by_id($specialty_id) : array {
    $db = db_connect();
    $sql = "SELECT specialty_name FROM `specialties` WHERE specialty_id = '$specialty_id'";
    $infosStmt = $db->query($sql);
    $specialty_name_by_id = $infosStmt->fetchAll(PDO::FETCH_ASSOC);
    return $specialty_name_by_id;
}

/** fonction qui va chercher le nom et prénom d'une utilisateur selon son id
 * @param int $user_id
 * @return array
 */

function get_names_by_id($user_id) : array {
    $db = db_connect();
    $sql = "SELECT first_name, last_name FROM `users` WHERE user_id = '$user_id'";
    $infosStmt = $db->query($sql);
    $names_by_id = $infosStmt->fetchAll(PDO::FETCH_ASSOC);
    return $names_by_id;
}



?>