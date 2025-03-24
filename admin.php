<?php
include 'db_connect.php';
include 'functions.php';


$result = $conn->query("SELECT * FROM users");
//?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestion des utilisateurs</title>
    <link rel="stylesheet" href="public/css/css.css">
</head>
<body>
    <div class="container">
        <h1>Gestion des comptes clients :</h1>
        <button class="bouton-dynamique"><a href="register.php">Creer un client</a></button>
        <button class="bouton-dynamique"><a href="login.php">Se connecter</a></button>
       
        <table>
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
                <?php while ($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td><?php echo $user['active'] ? 'Oui' : 'Non'; ?></td>
                        <td>
                        <br> <a href="admin_edit_users.php?id=<?php echo $user['id']; ?>">Modifier</a>
                           
                        <br> <a href="admin_delete_user.php?id=<?php echo $user['id']; ?>">Supprimer</a>
                        
                        <br><a href="admin_toggle_active.php?id=<?php echo $user['id']; ?>">Activer / Désactiver</a>
                          
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <style>
        .bouton-dynamique {
    background-color:rgb(18, 37, 18); /* Couleur de fond */
    border: none;
    color: white;
    padding: 10px 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 8px; /* Bords arrondis */
    transition: all 0.3s ease; /* Animation de transition */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Ombre légère */
  }
  
  .bouton-dynamique:hover {
    background-color: #3e8e41; /* Couleur de fond au survol */
    transform: translateY(-2px); /* Légère élévation au survol */
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.3); /* Ombre plus prononcée au survol */
  }
  
  .bouton-dynamique:active {
    background-color:rgb(49, 17, 17); /* Couleur de fond au clic */
    transform: translateY(0); /* Pas d'élévation au clic */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Ombre réduite au clic */
  }
    </style>
    <script src="public/javascript.js"></script>
</body>
</html>