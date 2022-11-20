<?php 
require_once __DIR__.'/../inc/header.php';
require_once __DIR__.'/../functions/functions.php';
if(!is_not_empty_and_defined($_POST['user_id'])) {
    header('Location: ./dashboard.php');
}

?>

<div class="global_container">
    <div class="user_details">
        <div class="user_details_img"></div>
        <h2 class="user_details_names"><?= get_names_by_id($_POST['user_id'])[0]['first_name'].' '.get_names_by_id($_POST['user_id'])[0]['last_name'] ?></h2>
        <div class="user_details_infos">
            <p class="user_details_age">Age : <?= get_user_infos_by_id($_POST['user_id'])[0]['age'] ?> </p>
            <p class="user_details_specialty"> Spécialité : <?= get_specialty_name_by_id(get_user_infos_by_id($_POST['user_id'])[0]['specialty_id'])[0]['specialty_name'] ?></p>
            <p class="user_details_city">Ville : <?= get_user_infos_by_id($_POST['user_id'])[0]['city'] ?></p>
            <p class="user_details_email">Email : <?= get_user_infos_by_id($_POST['user_id'])[0]['email'] ?></p>
        </div>
    </div>
</div>