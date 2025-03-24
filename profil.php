
<?php
// Démarrer les sessions
session_start();

// Établir une connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_profils";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Récupérer l'ID de l'utilisateur à partir de la session
$userId = $_SESSION['user_id'];

// Requête SQL pour récupérer les informations de l'utilisateur
$sql = "SELECT username FROM users WHERE id = $userId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    $error = "Utilisateur non trouvé.";
}

// ... (le reste de votre code HTML)

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil</title>
    <link rel="stylesheet" href="public/css/register.css">
</head>
<body>
    <div class="container">
        <h1>Profil</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <p>Nom d'utilisateur : <?php echo isset($user['username']) ? $user['username'] : ''; ?></p>
        <a href="modifier.php">Modifier le profil</a>
    </div>
</body>
</html>

