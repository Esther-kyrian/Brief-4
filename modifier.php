<?php
// Démarrer la session
session_start();



// Informations de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_profils";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Récupérer l'ID de l'utilisateur à partir de la session
$userId = $_SESSION['user_id'];

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... (votre code de validation des données)

    // Si aucune erreur, mettre à jour la base de données
    if (empty($error)) {
        $sql = "UPDATE users SET username = ?, email = ?";
        if (!empty($newPassword)) {
            $sql .= ", password = ?"; // Mettre à jour le mot de passe uniquement s'il est fourni
        }
        $sql .= " WHERE id = ?";

        $stmt = $conn->prepare($sql);

        // Vérifier si la préparation de la requête a réussi
        if ($stmt) {
            if (!empty($newPassword)) {
                $stmt->bind_param("ssi", $newUsername, $newEmail, password_hash($newPassword, PASSWORD_DEFAULT), $userId);
            } else {
                $stmt->bind_param("ssi", $newUsername, $newEmail, $userId);
            }

            if ($stmt->execute()) {
                header("Location: modifier.php"); // Rediriger vers la page de profil après la mise à jour
                exit();
            } else {
                $error = "Erreur lors de la mise à jour du profil : " . $stmt->error;
            }

            $stmt->close();
        } else {
            $error = "Erreur lors de la préparation de la requête : " . $conn->error;
        }
    }
}




$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier le profil</title>
    <link rel="stylesheet" href="public/css/register.css">
</head>
<body>
    <div class="container">
        <h1>Modifier le profil</h1>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>"><br>

            <label for="password">Mot de passe (laisser vide pour ne pas changer) :</label>
            <input type="password" name="password" id="password"><br>

            <button type="submit">Enregistrer</button>
        </form>
    </div>
</body>
</html>