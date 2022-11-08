<?php 
require_once '../controllers/dashboard-controller.php'; 
if(is_connected()) {
    header('Location: ./dashboard.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/output.css">
    <title>header</title>
</head>
<body>
    <div class="global_container">
        <div class="wrapper">
            <h1>Connexion</h1>
            <div class="wrapper_form">
                <form action="../controllers/login-controller.php" method="post">
                    <div class="wrapper_inputs">
                        <input type="text" name="credential" id="credential" maxlength="30" placeholder="Identifiant" required>
                        <input type="password" name="password" id="password" maxlength="30" placeholder="Mot de passe" required>
                    </div>
                    <button type="submit" class="btn-primary">Se connecter</button>
                </form>
            </div>
        </div>
    </div>

</body>
<?php require_once '../inc/footer.php'; ?>