<?php
require_once '../libraries/db.php';

function get_users_infos() {
    $db = db_connect();
    $sql = "SELECT * FROM `students_infos`";
    $infosStmt = $db->query($sql);
    $users_infos = $infosStmt->fetchAll(PDO::FETCH_ASSOC);
    return $users_infos;
}



?>