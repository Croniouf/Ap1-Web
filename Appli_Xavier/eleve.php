<?php
session_start();

// Vérifie si l'utilisateur est connecté et que c'est bien un élève
if (!isset($_SESSION['Sid']) || !isset($_SESSION['type']) || $_SESSION['type'] != '1') {
    header("Location: index.php"); // Redirection si non autorisé
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Élève</title>
    <link rel="stylesheet" href="style_accueil.css">
</head>
<body>
    <div class="container">
        <h2>Bienvenue dans votre espace Élève 🎓</h2>

        <p>Bonjour <strong><?php echo htmlspecialchars($_SESSION['Sid']); ?></strong>,</p>
        <p>Vous êtes connecté en tant qu’élève.</p>

        <div class="buttons">
            <button type="button" onclick="window.location.href='perso.php'">Mon Profil</button>
            <button type="button" onclick="window.location.href='listes_compte_rendus.php'">Liste des Compte Rendus</button>
            <button type="button" onclick="window.location.href='creation_compte_rendus.php'">Créer un Compte Rendu</button>
            <form method="post" action="logout.php" style="display:inline;">
               <button type="button" onclick="window.location.href='index.php'">Déconnexion</button>
            </form>
        </div>
    </div>
</body>
</html>
