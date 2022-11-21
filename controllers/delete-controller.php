<?php

require_once __DIR__.'/../functions/functions.php';



/** fonction qui supprime un utilisateur selon son id
 * @param int $user_id
 */

function remove_by_id(int $user_id) {
    $db = db_connect();
    $sql = "DELETE FROM `users_infos` WHERE user_id = '$user_id'";
    $db->exec($sql);
    $sql = "DELETE FROM `users` WHERE user_id = '$user_id'";
    $db->exec($sql);
    $sql = "DELETE FROM `images` WHERE user_id = '$user_id'";
    $db->exec($sql);
    header('Location: ../vues/dashboard.php');
}

remove_by_id($_POST['user_id']);





?>