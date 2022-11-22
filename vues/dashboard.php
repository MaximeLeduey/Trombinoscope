<?php 
require_once __DIR__.'/../controllers/dashboard-controller.php';
go_to_login();
require_once __DIR__.'/../inc/header.php';
require_once __DIR__.'/../functions/functions.php';
if(!is_not_empty_and_defined($_POST)) {
    $_POST['grade'] = 1;
}


?>

<?php $current_grade_index = $_POST['grade'] - 1; ?>
<div id="grade">
<h1 class="grade_title"><?= get_grades()[$current_grade_index]['grade_name'] ?></h1>
<form action="" method="post" class="grades_form">
    <select name="grade" id="grade-select">
        <?php $incrementNbr = 1 ?>
        <?php foreach(get_grades() as $grade): ?>
            <?php if($incrementNbr == ($_POST['grade'])): ?>
                <option value='<?= $grade['grade_id'] ?>' selected><?= $grade['grade_name'] ?></option>
            <?php else : ?>
                <option value='<?= $grade['grade_id'] ?>'><?= $grade['grade_name'] ?></option>
            <?php endif; ?>
            <?php $incrementNbr++ ?>
        <?php endforeach; ?>
    </select>
    <button class="btn-secondary" type="submit">Valider</button>
</form>
</div>
<div class="users_list">
    <?php foreach(get_users_by_grade($_POST['grade']) as $user): ?>
        <div class="user">
            <img src="data:image/jpeg;base64,<?=get_image_by_id($user['user_id'])[0]['img_bin'] ?>" class="user_img">
            <h2 class="user_names"><?= $user['first_name'].' '.$user['last_name'] ?></h2>
            <form class="user_form" action="../vues/user_details.php" method="post">
                <button type="submit" name="user_id" value="<?= $user['user_id'] ?>" class="user_btn btn-primary">Voir plus</button>
            </form>
        </div> 
    <?php endforeach; ?>
</div>

<?php require_once __DIR__.'/../inc/footer.php' ?>

