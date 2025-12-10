<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "root";
$basededonnees = "appli_web_xavier";

$conn = new mysqli($serveur, $utilisateur, $motdepasse, $basededonnees);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$num = isset($_GET['num']) ? intval($_GET['num']) : 0;

// Mise à jour si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $description = $_POST['description'];
    $email = $_POST['email'];
    $vu = isset($_POST['vu']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE compte_rendu SET date=?, description=?, email=?, vu=? WHERE num=?");
    $stmt->bind_param("sssii", $date, $description, $email, $vu, $num);
    $stmt->execute();
    $stmt->close();

    echo "Compte rendu mis à jour avec succès ! <a href='listes_compte_rendus.php'>Retour à la liste</a>";
    exit;
}

// Récupération des données existantes
$sql = "SELECT * FROM compte_rendu WHERE num = $num";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des comptes rendus</title>
    <link rel="stylesheet" href="modifier_compte_rendu.css">
</head>
<form method="post">
    Date: <input type="date" name="date" value="<?= htmlspecialchars($row['date']) ?>"><br>
    Description: <textarea name="description"><?= htmlspecialchars($row['description']) ?></textarea><br>
    Email: <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>"><br>
    Vu: <input type="checkbox" name="vu" <?= $row['vu'] ? 'checked' : '' ?>><br>
    <button type="submit">Modifier</button>
</form>
