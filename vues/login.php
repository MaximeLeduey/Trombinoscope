<?php 
require_once '../inc/header.php'; 
require_once '../controllers/dashboard-controller.php'; 
if(is_connected()) {
    header('Location: ./dashboard.php');
}

?>



<form action="../controllers/login-controller.php" method="post">
    <label for="credential">Identifiant</label>
    <input type="text" name="credential" id="credential" maxlength="30" required>
    <label for="password">Mot de passe</label>
    <input type="password" name="password" id="password" maxlength="30" required>
    <button type="submit">Se connecter</button>
</form>



<?php require_once '../inc/footer.php'; ?>