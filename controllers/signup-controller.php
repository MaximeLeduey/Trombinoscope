<?php
require_once __DIR__.'/../functions/functions.php';
require_once __DIR__.'/../controllers/commons_functions_in_controllers.php';



/** fonction qui enleve les caractères speciaux 
 * @param string 
 * @return string
 */

function sanitize(string $string) : string{
    return filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
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


/** fonction qui va chercher l'id de l'image selon l'id de l'utilisateur
 * @param int $id
 * @return int
 */

function get_image_id(int $id) : int {
    $db = db_connect();
    $sql = "SELECT img_id FROM `images` WHERE user_id = '$id'";
    $infosStmt = $db->query($sql);
    $infos = $infosStmt->fetchAll(PDO::FETCH_ASSOC);
    $id = $infos[0]['img_id'];
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
    $image_size = $_FILES['image']['size'];
    $image_type = $_FILES['image']['type'];
    $id = get_id($firstName, $lastName);
    print_r($_FILES);
    if((verify_img_size($image_size)) && (verify_file_type($image_type))) {
        $image_name = $_FILES['image']['name'];
        $source = $_FILES['image']['tmp_name'];
        move_uploaded_file($source, $image_name);
        $image_content = file_get_contents($_FILES['image']['name']);
        $image_content = base64_encode($image_content);
        $sql = "INSERT INTO images (img_name, img_size, img_type, img_bin, user_id)
        VALUES ('$image_name', '$image_size', '$image_type', '$image_content', '$id')";
        $db->exec($sql);
        $img_id = get_image_id($id);
        $sql = "INSERT INTO users_infos (specialty_id, city, email, tel, age, user_id, credential, password, admin, img_id)
        VALUES ('$_POST[specialty]', '$city', '$_POST[email]', '$_POST[tel]', '$age', '$id', '$credential', '$password', '$_POST[status]', '$img_id')";
    }
    else {
        $sql = "INSERT INTO users_infos (specialty_id, city, email, tel, age, user_id, credential, password, admin)
        VALUES ('$_POST[specialty]', '$city', '$_POST[email]', '$_POST[tel]', '$age', '$id', '$credential', '$password', '$_POST[status]')";
    }
    // print_r($_FILES);

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