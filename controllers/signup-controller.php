<?php
require_once '../functions/functions.php';

$name_regex = "/[a-zA-Z]{3,}[-]*[a-zA-Z]{3,}/i";
$email_regex = "/[a-z\.\-\_]+@[a-z]+\.[a-z]{2,3}/i";
$tel_regex = "/0[0-9]{9}/i";

function check_exp($pattern, $exp) {
    if(preg_match($pattern, $exp) == 1) {
        return "oui";
    }
    else {
        return "non";
    }
}

function change_date($date) {
    $falseDate = new DateTime($_POST[$date]);
    $goodDate = $falseDate->format('Y-m-d 00:00:00');
    return $goodDate;
}

function age($date) {
    $birthDate = $date;
    $today = date("Y-m-d");
    $diff = date_diff(date_create($birthDate), date_create($today));
    return $diff->format('%y');
}


function get_id($firstName, $lastName) {
    $db = db_connect();
    $sql = "SELECT user_id FROM `users` WHERE first_name = '$firstName' AND last_name = '$lastName'";
    $infosStmt = $db->query($sql);
    $infos = $infosStmt->fetchAll(PDO::FETCH_ASSOC);
    $id = $infos[0]['user_id'];
    return $id;
}

function create_credential($lastName) {
    $credential = strtoupper($lastName);
    $nbr = 1;
    if(is_credential_exists($lastName)) {
        $nbr++;
    }
    $credential = $credential.$nbr;
    return $credential;
}

function create_hashed_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function create_users() {
    $db = db_connect();
    $age = age(change_date('birth'));
    $credential = create_credential($_POST['lastName']);
    $password = create_hashed_password($_POST['password']);
    $sql = "INSERT INTO users (last_name, first_name, grade_id)
    VALUES ('$_POST[lastName]', '$_POST[firstName]', '$_POST[grade]')";
    $db->exec($sql);
    $id = get_id($_POST['firstName'], $_POST['lastName']);
    $sql = "INSERT INTO users_infos (specialty_id, city, email, tel, age, user_id, credential, password, admin)
    VALUES ('$_POST[specialty]', '$_POST[city]', '$_POST[email]', '$_POST[tel]', '$age', '$id', '$credential', '$password', '$_POST[status]')";
    $db->exec($sql);
    header('Location: ../vues/signup.php');
    echo $sql;
}

create_users();



?>