<?php

require_once __DIR__.'/../inc/header.php';
require_once __DIR__.'/../functions/functions.php';
if(!is_not_empty_and_defined($_POST['user_id'])) {
    header('Location: ./dashboard.php');
}

?>

<form action="../vues/modify.php" method="post">
    <input type="submit" class="btn-primary" value="Retour"></input>
</form>

<form action="../controllers/delete-controller.php" method="post">
    <input type="submit" class="btn-primary" value="<?= $_POST['user_id'] ?>" name="user_id">
</form>







<?php
require_once __DIR__.'/../inc/footer.php';
?>