<?php require_once '../inc/header.php'; ?>



<form action="../controllers/login-controller.php" method="post">
    <label for="credential">Identifiant</label>
    <input type="text" name="credential" id="credential">
    <label for="password">Mot de passe</label>
    <input type="password" name="password" id="password">
    <button type="submit">Se connecter</button>
</form>



<?php require_once '../inc/footer.php'; ?>