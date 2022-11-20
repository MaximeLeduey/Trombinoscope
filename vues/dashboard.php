<?php 
require_once '../controllers/dashboard-controller.php';
go_to_login();
require_once '../inc/header.php';
require_once '../functions/functions.php';
if(!is_not_empty_and_defined($_POST)) {
    $_POST['grade'] = 1;
}


?>

<?php $current_grade_index = $_POST['grade'] - 1; ?>
<h1><?= get_grades()[$current_grade_index]['grade_name'] ?></h1>
<form action="" method="post">
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
    <button type="submit">Valider</button>
</form>
<div class="users_list">
    <?php foreach(get_users_by_grade($_POST['grade']) as $user): ?>
        <div class="user">
            <div class="user_img"></div>
            <h2 class="user_names"><?= $user['first_name'].' '.$user['last_name'] ?></h2>
            <button type="button" class="user_btn btn-primary">Consulter le profil</button>
        </div> 
    <?php endforeach; ?>
</div>

