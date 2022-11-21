<?php
 require_once __DIR__.'/../inc/header.php';
 require_once __DIR__.'/../functions/functions.php';

 if(!is_not_empty_and_defined($_POST['user_id'])) {
    header('Location: ./dashboard.php');
}
 ?>


<form action="../controllers/modify-controller.php" method="post" enctype="multipart/form-data">
    <label for="city">Ville</label>
    <input type="text" name="city" maxlength="30" required>
    <label for="email">Email</label>
    <input type="email" name="email" required>
    <label for="tel">Téléphone</label>
    <input type="tel" name="tel" required>
    <label for="password">Mot de passe</label>
    <input type="password" name="password" required>
    <!-- <input type="file" name="image" placeholder="image" required> -->
    <input class="btn-primary" value="<?= $_POST['user_id'] ?>" type="submit" name="user_id"></input>
</form>



<?php require_once __DIR__.'/../inc/footer.php' ?>