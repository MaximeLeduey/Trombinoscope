<?php 
require_once __DIR__.'/../inc/header.php';
require_once __DIR__.'/../functions/functions.php';
if(!is_not_empty_and_defined($_POST['user_id'])) {
    header('Location: ./dashboard.php');
}

?>

<div class="global_container second">
    <div class="user_details">
    <img src="data:image/jpeg;base64,<?=get_image_by_id($_POST['user_id'])[0]['img_bin'] ?>" class="user_details_img">
        <h2 class="user_details_names"><?= get_names_by_id($_POST['user_id'])[0]['first_name'].' '.get_names_by_id($_POST['user_id'])[0]['last_name'] ?></h2>
        <div class="user_details_infos">
            <p class="user_details_age">Age : <?= get_user_infos_by_id($_POST['user_id'])[0]['age'] ?> </p>
            <p class="user_details_specialty"> Spécialité : <?= get_specialty_name_by_id(get_user_infos_by_id($_POST['user_id'])[0]['specialty_id'])[0]['specialty_name'] ?></p>
            <p class="user_details_city">Ville : <?= get_user_infos_by_id($_POST['user_id'])[0]['city'] ?></p>
            <p class="user_details_email">Email : <?= get_user_infos_by_id($_POST['user_id'])[0]['email'] ?></p>
        </div>
        <div class="user_details_buttons">
            <form action="./dashboard.php" method="post">
                <button class="btn-secondary" type="submit">Retour</button>
            </form>
            <form action="./modify.php" method="post">
                <button name="user_id" value="<?= $_POST['user_id'] ?>" type="submit" class="btn-primary ">Modifier</button>
            </form>
           
            
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../inc/footer.php' ?>