<?php

require_once __DIR__.'/../functions/functions.php';
require_once __DIR__.'/../controllers/commons_functions_in_controllers.php';


/** fonction qui modifier les informations selon l'id de l'utilisateur 
 * @param int $user_id
 */

function modify_user(int $user_id) {
    $db = db_connect();
    $new_city = change_names($_POST['city']);
    $new_password = create_hashed_password($_POST['password']);
    $sql = "UPDATE users_infos SET city = '$new_city', email = '$_POST[email]', tel = '$_POST[tel]', password = '$new_password' WHERE user_id = '$user_id'";
    $db->exec($sql);
}


/** fonction qui verifie les informations 
 * 
 */

function verify_modify() {
    print_r($_POST);
    if(is_not_empty_and_defined($_POST['city']) and 
    is_not_empty_and_defined($_POST['email']) and is_not_empty_and_defined($_POST['tel']) and
    is_not_empty_and_defined($_POST['password']))  {
        $name_regex = "/^[a-zA-Z-]+$/";
        $email_regex = "/^[a-z0-9\_\-\.]+@[\da-z\.-]+\.[a-z\.]{2,6}$/";
        $tel_regex = "/^(0|\+33)[1-9]([0-9]{2}){4}$/";
        $password_regex = "/^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/";
        if(check_exp($name_regex, $_POST['city']) 
        and check_exp($email_regex, $_POST['email']) and check_exp($tel_regex, $_POST['tel']) and 
        check_exp($password_regex, $_POST['password'])) {
            modify_user($_POST['user_id']);
            header('Location: ../vues/dashboard.php');
        }
        else {
            echo "Erreur, une ou plusieurs des variables ne remplissent pas les critères des regex";
        }
    }
    else {
        echo "Erreur, une ou plusieurs des variables ne sont pas définies";
    }
}

verify_modify();



?>