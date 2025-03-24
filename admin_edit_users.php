

<?php
include 'db_connect.php';
include 'functions.php';

// Check if the user ID is provided in the query string
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Check if the action is to edit or delete
    if (isset($_GET['action'])) {
        $action = $_GET['action'];

        if ($action === 'edit') {
            // Fetch user data for editing
            $result = $conn->query("SELECT * FROM users WHERE id = $userId");
            if ($user = $result->fetch_assoc()) {
                ?>
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Modifier l'utilisateur</title>
                    <link rel="stylesheet" href="public/css/css.css">
                </head>
                <body>
                    <div class="container">
                        <h1>Modifier l'utilisateur</h1>
                        <form action="admin_update_user.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <label for="username">Nom d'utilisateur:</label>
                            <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br><br>

                            <label for="role">Rôle:</label>
                            <select name="role">
                                <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                                <option value="client" <?php echo ($user['role'] === 'client') ? 'selected' : ''; ?>>Client</option>
                            </select><br><br>

                            <label for="active">Actif:</label>
                            <select name="active">
                                <option value="1" <?php echo ($user['active'] == 1) ? 'selected' : ''; ?>>Oui</option>
                                <option value="0" <?php echo ($user['active'] == 0) ? 'selected' : ''; ?>>Non</option>
                            </select><br><br>

                            <input type="submit" value="Mettre à jour">
                        </form>
                    </div>
                </body>
                </html>
                <?php
            } else {
                echo "Utilisateur non trouvé.";
            }
        } elseif ($action === 'delete') {
            // Delete user
            $deleteResult = $conn->query("DELETE FROM users WHERE id = $userId");
            if ($deleteResult) {
                header("Location: admin.php"); // Redirect back to the user list
                exit();
            } else {
                echo "Erreur lors de la suppression de l'utilisateur.";
            }
        }
    } else {
        echo "Action non spécifiée.";
    }
} else {
    echo "ID utilisateur non spécifié.";
}
?>