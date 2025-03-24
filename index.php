<?php
// Inclure les fichiers nécessaires
include 'db_connect.php';
include 'functions.php';

// Vérifier si l'utilisateur est connecté
if (is_logged_in()) {
   
}

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login_username'])) {
    $username = $_POST['login_username'];
    $password = $_POST['login_password'];

    if (login($username, $password)) {
        redirect('index.php'); // Rediriger vers la page d'accueil après la connexion
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}

// Traitement du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register_username'])) {
    $username = $_POST['register_username'];
    $password = $_POST['register_password'];

    if (register($username, $password)) {
        redirect('login.php'); // Rediriger vers la page de connexion après l'inscription
    } else {
        $error = "Erreur lors de l'inscription.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Accueil</title>
    <link rel="stylesheet" href="public/css/register.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenue Cher client !</h1>

        <?php if (isset($username)): ?>

            <a href="admin.php">Gestion des utilisateus</a>
        <?php else: ?>
            <p>Veuillez vous connecter ou vous inscrire.</p>

          
        <?php endif; ?>
    </div>
</body>
</html>