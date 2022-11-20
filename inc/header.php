<?php require_once __DIR__.'/../controllers/dashboard-controller.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/output.css">
    <script defer src="../assets/js/script.js"></script>
    <title>header</title>
</head>
<body>
    <header class="header">
        <nav class="nav">
            <img class="nav_logo" src="../assets/svg/logo.svg">
            <?php if(is_connected()): ?>
            <ul class="nav_menu">
                <li class="nav_menu_li">
                    <a href="../vues/dashboard.php" class="nav_menu_li_link">Accueil</a>
                </li>
                <?php if($_SESSION['admin']): ?>
                <li class="nav_menu_li">
                    <a href="../vues/signup.php" class="nav_menu_li_link">Créer un étudiant</a>
                </li>
                <?php endif; ?>
                <li class="nav_menu_li">
                    <a href="../controllers/logout.php" class="nav_menu_li_link">Se deconnecter</a>
                </li>
                <li class="nav_menu_li">
                <a href="#" class="nav_menu_li_link">Mon compte</a>
                </li>
            </ul>
            <div class="nav_burger">
                <div class="nav_burger_bar"></div>
                <div class="nav_burger_bar"></div>
                <div class="nav_burger_bar"></div>
            </div>
            <?php endif; ?>
        </nav> 
    </header>


