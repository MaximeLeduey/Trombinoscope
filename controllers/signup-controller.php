<?php
require_once '../functions/functions.php';



function check_exp($pattern, $exp) {
    if(preg_match($pattern, $exp) == 1) {
        return true;
    }
    else {
        return false;
    }
}



function change_names($name) {
    $name = strtolower($name);
    $name = ucfirst($name);
    return $name;
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
    while(is_credential_exists($credential.$nbr)) {
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

function are_not_empty_and_defined() {
   return (is_not_empty_and_defined($_POST['firstName']) and is_not_empty_and_defined($_POST['lastName'])
   and is_not_empty_and_defined($_POST['city']) and is_not_empty_and_defined($_POST['email']) and
    is_not_empty_and_defined($_POST['tel']) and is_not_empty_and_defined($_POST['birth']) and
    is_not_empty_and_defined($_POST['grade']) and is_not_empty_and_defined($_POST['specialty']) and
    is_not_empty_and_defined($_POST['status']) and is_not_empty_and_defined($_POST['password']));
}



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