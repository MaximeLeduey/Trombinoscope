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
    <label for="grade">Classe</label>
    <select name="grade">
        <?php $nbr1 = 1 ?>
        <?php foreach(get_grades() as $grade) : ?>
            <?php if($nbr1 === 1): ?>
                <option value="<?= $grade['grade_id'] ?>" selected><?= $grade['grade_name'] ?></option>
            <?php else: ?>
                <option value="<?= $grade['grade_id'] ?>"><?= $grade['grade_name'] ?></option>
            <?php endif; ?>
            <?php $nbr1++; ?>
        <?php endforeach; ?>
    </select>
    <label for="specialty">Specialité</label>
    <select name="specialty">
        <?php $nbr2 = 1 ?>
        <?php foreach(get_specialties() as $specialty) : ?>
            <?php if($nbr2 === 1): ?>
                <option value="<?= $specialty['specialty_id'] ?>" selected><?= $specialty['specialty_name'] ?></option>
            <?php else: ?>
                <option value="<?= $specialty['specialty_id'] ?>"><?= $specialty['specialty_name'] ?></option>
            <?php endif; ?>
            <?php $nbr2++; ?>
        <?php endforeach; ?>
    </select>
    <label for="status">Statut</label>
    <select name="status">
        <option value="0" selected>utilisateur</option>
        <option value="1">admin</option>
    </select>
    <label for="password">Mot de passe</label>
    <input type="password" name="password" required>
    <button type="submit">Valider l'inscription</button>
</form>






<?php require_once '../inc/footer.php' ?>