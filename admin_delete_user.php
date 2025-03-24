<?php
include 'db_connect.php'; // Inclure le fichier de connexion
include 'functions.php';

// Vérifier si l'utilisateur est un administrateur
if (!is_admin()) {
    redirect('admin_delete_user.php');
}

// Traitement de la suppression
if (isset($_GET['delete_id'])) {
    $user_id = intval($_GET['delete_id']);

    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Utilisateur supprimé avec succès.";
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression de l'utilisateur.";
    }

    // Rediriger après la suppression
    redirect('admin.php');
}

// Récupérer les données des utilisateurs pour le tableau
$sql = "SELECT * FROM users";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// En-têtes pour éviter la mise en cache
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>

<table id="userTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom d'utilisateur</th>
            <th>Rôle</th>
            <th>Actif</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['role']; ?></td>
                <td><?php echo $user['active'] ? 'Oui' : 'Non'; ?></td>
                <td>
                    <a href="admin_edit_users.php?id=<?php echo $user['id']; ?>">Modifier</a>
                    <a href="admin.php?delete_id=<?php echo $user['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                    <a href="admin_toggle_active.php?id=<?php echo $user['id']; ?>">Activer / Désactiver</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: admin.php');
} else {
    echo "ID de message manquant.";
}
?>
