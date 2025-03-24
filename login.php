<?php
include 'db_connect.php';
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validation des données (ajoutez vos propres validations)
    if (empty($username) || empty($password)) {
        $error = "Veuillez remplir tous les champs.";
    } else {
        // Récupération de l'utilisateur par nom d'utilisateur
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // Vérification du mot de passe
            if (password_verify($password, $user['password'])) {
                // Démarrage de la session et définition des variables de session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['role'];

                // Enregistrement de la connexion dans la table de logs
                $conn->query("INSERT INTO logs (user_id) VALUES (" . $user['id'] . ")");

                // Redirection vers le tableau de bord
                redirect('index.php');
            } else {
                $error = "Mot de passe incorrect.";
            }
        } else {
            $error = "Nom d'utilisateur incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link rel="stylesheet" href="public/css/login.css">
</head>
<body>
    <div class="container">
        <h1>Connexion</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
            <input type="password" name="password" placeholder="Mot de passe" required><br>
       <a href="admin.php"><button type="submit">Se connecter</button>  </a>
        </form>
        <p>Pas de compte ? <a href="register.php">S'inscrire</a></p>
    </div>
</body>
</html>