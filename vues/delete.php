<?php

require_once __DIR__.'/../inc/header.php';
require_once __DIR__.'/../functions/functions.php';
if(!is_not_empty_and_defined($_POST['user_id'])) {
    header('Location: ./dashboard.php');
}

?>
<div class="delete_container">
    <div class="delete_container_pop_up">
        <p>Voulez vous vraiment supprimer ?</p>
        <div class="delete_container_buttons">
            <form action="../vues/modify.php" method="post">
                <button type="submit" class="btn-secondary" value="Retour">Non</button>
            </form>
            <form action="../controllers/delete-controller.php" method="post">
                <button type="submit" class="btn-primary" value="<?= $_POST['user_id'] ?>" name="user_id">Oui</button>
            </form>
        </div>
    </div>
</div>










<?php
require_once __DIR__.'/../inc/footer.php';
?>