<?php
require_once '../functions/functions.php';



/** function qui teste si l'expression donnée en paramètre matche avec la regex
 * @param $pattern, @param $exp
 * @return bool
 */

function check_exp($pattern, $exp) : bool {
    if(preg_match($pattern, $exp) == 1) {
        return true;
    }
    else {
        return false;
    }
}


/** function qui met en majuscule la premiere lettre d'une chaine de caractère (ici les nom, prénom)
 * @param string $name
 * @return string 
 */

function change_names($name) : string {
    $name = strtolower($name);
    $name = ucfirst($name);
    return $name;
}


/** fonction qui change le format de la date rentrée dans le champ pour 
 * correspondre au format attendu pour le calcul de l'age
 * @param date $date
 * @return string
 */

function change_date($date) : string {
    $falseDate = new DateTime($_POST[$date]);
    $goodDate = $falseDate->format('Y-m-d 00:00:00');
    return $goodDate;
}


/** fonction qui calcule l'age en fonction de la date de naissance rentrée
 * @param string $date
 * @return int 
 */

function age($date) : int {
    $birthDate = $date;
    $today = date("Y-m-d");
    $diff = date_diff(date_create($birthDate), date_create($today));
    return $diff->format('%y');
}


/** fonction qui va chercher l'id de l'utilisateur selon son nom et prenom
 * @param string $firstName, @param string $lastName
 * @return int
 */

function get_id($firstName, $lastName): int {
    $db = db_connect();
    $sql = "SELECT user_id FROM `users` WHERE first_name = '$firstName' AND last_name = '$lastName'";
    $infosStmt = $db->query($sql);
    $infos = $infosStmt->fetchAll(PDO::FETCH_ASSOC);
    $id = $infos[0]['user_id'];
    return $id;
}


/** fonction qui cree un identifiant au nouvel utilisateur selon
 *  son nom de famille (nom en majuscule + numero derriere)
 * @param string $lastName
 * @return string 
 */

function create_credential($lastName) : string {
    $credential = strtoupper($lastName);
    $nbr = 1;
    while(is_credential_exists($credential.$nbr)) {
        $nbr++;
    }
    $credential = $credential.$nbr;
    return $credential;
}


/** fonction qui hash le mot de passe 
 * @param string $password
 * @return string
 */

function create_hashed_password($password) : string {
    return password_hash($password, PASSWORD_DEFAULT);
}


/** fonction qui retourne une grande condition pour savoir si 
 * tous les champs sont definis et non nulls (la fonction is_not_empty_and_defined est
 * declaree dans le functions.php)
 * 
 */

function are_not_empty_and_defined() {
    return (is_not_empty_and_defined($_POST['firstName']) and is_not_empty_and_defined($_POST['lastName'])
    and is_not_empty_and_defined($_POST['city']) and is_not_empty_and_defined($_POST['email']) and
     is_not_empty_and_defined($_POST['tel']) and is_not_empty_and_defined($_POST['birth']) and
     is_not_empty_and_defined($_POST['grade']) and is_not_empty_and_defined($_POST['specialty']) and
     is_not_empty_and_defined($_POST['status']) and is_not_empty_and_defined($_POST['password']));
 }


/** fonction qui cree le nouvel utilisateur dans la base de donnée avec toutes les informations rentrées
 * dans les champs, qui ont été nettoyées et formatées
 */

function create_users() {
    $db = db_connect();
    $lastName = change_names($_POST['lastName']);
    $firstName = change_names($_POST['firstName']);
    $city = change_names($_POST['city']);
    $age = age(change_date('birth'));
    $credential = create_credential($_POST['lastName']);
    $password = create_hashed_password($_POST['password']);
    $sql = "INSERT INTO users (last_name, first_name, grade_id)
    VALUES ('$lastName', '$firstName', '$_POST[grade]')";
    $db->exec($sql);
    $id = get_id($firstName, $lastName);
    $sql = "INSERT INTO users_infos (specialty_id, city, email, tel, age, user_id, credential, password, admin)
    VALUES ('$_POST[specialty]', '$city', '$_POST[email]', '$_POST[tel]', '$age', '$id', '$credential', '$password', '$_POST[status]')";
    $db->exec($sql);
}


/** fonction qui verifie tous les champs et appelle la fonction
 * create_user si tout est bon
 * 
 */

function verify_fields() {
    if(are_not_empty_and_defined()) {
        $name_regex = "/^[a-zA-Z-]+$/";
        $email_regex = "/^[a-z0-9\_\-\.]+@[\da-z\.-]+\.[a-z\.]{2,6}$/";
        $tel_regex = "/^(0|\+33)[1-9]([0-9]{2}){4}$/";
        $password_regex = "/^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/";
        if(check_exp($name_regex, $_POST['firstName']) and check_exp($name_regex, $_POST['lastName']) and check_exp($name_regex, $_POST['city']) 
        and check_exp($email_regex, $_POST['email']) and check_exp($tel_regex, $_POST['tel']) and 
        check_exp($password_regex, $_POST['password'])) {
            create_users();
            echo "oui";
        }
        else {
            echo "non";
        }
    }
    else {
        echo "pas defini";
    }
    // header('Location: ../vues/signup.php');
}

verify_fields();



?>