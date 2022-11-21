<?php 



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


/** fonction qui verifie la taille de l'image à uploader 
 * @param float $size
 * @return bool
 */

function verify_img_size(float $size) : bool {
    if($size > 2000000) {
        return false;
    }
    else {
        return true;
    }
}


/** fonction qui verifie le type du fichier à uploader
 * @param string $type
 * @return bool
 */

function verify_file_type(string $type) : bool {
    if(($type == "image/jpeg") || ($type == "image/png")) {
        return true;
    }
    else {
        return false;
    }
}


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


/** fonction qui hash le mot de passe 
 * @param string $password
 * @return string
 */

function create_hashed_password($password) : string {
    return password_hash($password, PASSWORD_DEFAULT);
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


?>