<?php 
require_once '../inc/header.php';
require_once '../functions/functions.php' ;
?>

<form action="../controllers/signup-controller.php" method="post">
    <label for="firstName">Prénom</label>
    <input type="text" name="firstName" maxlength="30" required>
    <label for="lastName">Nom</label>
    <input type="text" name="lastName" maxlength="30" required>
    <label for="city">Ville</label>
    <input type="text" name="city" maxlength="30" required>
    <label for="email">Email</label>
    <input type="email" name="email" required>
    <label for="tel">Téléphone</label>
    <input type="tel" name="tel" required>
    <label for="birth">Date de naissance</label>
    <input type="date" name="birth" required>
    <label for="status">Classe</label>
    <select name="grade">
        <?php foreach(get_grades() as $grade) : ?>
            <option value="<?= $grade['grade_id'] ?>"><?= $grade['grade_name'] ?></option>
        <?php endforeach; ?>
    </select>
    <label for="status">Specialité</label>
    <select name="specialty">
        <?php foreach(get_specialties() as $specialty) : ?>
            <option value="<?= $specialty['specialty_id'] ?>"><?= $specialty['specialty_name'] ?></option>
        <?php endforeach; ?>
    </select>
    <label for="status">Statut</label>
    <select name="status">
        <option value="0">utilisateur</option>
        <option value="1">admin</option>
    </select>
    <label for="password">Mot de passe</label>
    <input type="password" name="password" required>
    <button type="submit">Valider l'inscription</button>
</form>






<?php require_once '../inc/footer.php' ?>