<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'ajouter') {
        $stmt = $pdo->prepare("INSERT INTO users (nom, email, sujet, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['nom'], $_POST['email'], $_POST['sujet'], $_POST['message']]);
    } elseif ($action === 'modifier') {
        $stmt = $pdo->prepare("UPDATE messages SET nom = ?, email = ?, sujet = ?, message = ? WHERE id = ?");
        $stmt->execute([$_POST['nom'], $_POST['email'], $_POST['sujet'], $_POST['message'], $_POST['id']]);
    }
}

header('Location:admin.php');
?>