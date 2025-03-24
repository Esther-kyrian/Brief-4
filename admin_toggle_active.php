
<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Get current active state
    $result = $conn->query("SELECT active FROM users WHERE id = $userId");
    if ($user = $result->fetch_assoc()) {
        $currentActive = $user['active'];
        $newActive = ($currentActive == 1) ? 0 : 1; // Toggle active state

        $updateResult = $conn->query("UPDATE users SET active = $newActive WHERE id = $userId");

        if ($updateResult) {
            header("Location: admin_users.php"); // Redirect back to the user list
            exit();
        } else {
            echo "Erreur lors de la mise à jour de l'état actif.";
        }
    } else {
        echo "Utilisateur non trouvé.";
    }
} else {
    echo "ID utilisateur non spécifié.";
}
?>