<?php
session_start();
include '_conf.php';

// Vérification de la session
if (!isset($_SESSION['Sid'])) {
    echo "Vous devez être connecté pour accéder à cette page. <a href='index.php'>Retour</a>";
    exit();
}

$bdd = mysqli_connect($serveurBDD, $userBDD, $mdpBDD, $nomBDD);
if (!$bdd) {
    die("Erreur de connexion à la base de données.");
}

$login = $_SESSION['Sid'];

// Récupérer les informations actuelles de l'utilisateur
$requete = "SELECT * FROM utilisateur WHERE login = '$login'";
$resultat = mysqli_query($bdd, $requete);
$donnees = mysqli_fetch_assoc($resultat);

$email_actuel = $donnees['email'];
$num_utilisateur = $donnees['num'];
$type = $donnees['type'];  // Récupère le type de l'utilisateur (1 pour élève, 2 pour professeur)
$message = "";

// ======= TRAITEMENT MISE À JOUR EMAIL =======
if (isset($_POST['modifier_email'])) {
    $nouvel_email = mysqli_real_escape_string($bdd, $_POST['nouvel_email']);

    if (filter_var($nouvel_email, FILTER_VALIDATE_EMAIL)) {
        $requete = "UPDATE utilisateur SET email = '$nouvel_email' WHERE num = $num_utilisateur";
        mysqli_query($bdd, $requete);
        $message = "✅ Email mis à jour avec succès.";
        $email_actuel = $nouvel_email;
    } else {
        $message = "❌ Email invalide.";
    }
}

// ======= TRAITEMENT CHANGEMENT MOT DE PASSE =======
if (isset($_POST['modifier_mdp'])) {
    $ancien_mdp = hash('sha256', $_POST['ancien_mdp']);
    $nouveau_mdp = hash('sha256', $_POST['nouveau_mdp']);

    // Vérifie que l'ancien mot de passe est correct
    $requete = "SELECT motdepasse FROM utilisateur WHERE num = $num_utilisateur";
    $resultat = mysqli_query($bdd, $requete);
    $donnees = mysqli_fetch_assoc($resultat);

    if ($donnees['motdepasse'] === $ancien_mdp) {
        $requete = "UPDATE utilisateur SET motdepasse = '$nouveau_mdp' WHERE num = $num_utilisateur";
        mysqli_query($bdd, $requete);
        $message = "✅ Mot de passe mis à jour avec succès.";
    } else {
        $message = "❌ Ancien mot de passe incorrect.";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page personnelle</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

<div class="formulaire">
    <h2>Informations de l'utilisateur</h2>

    <?php if ($message != ""): ?>
        <p style="color:green;"><?php echo $message; ?></p>
    <?php endif; ?>

    <p><strong>Login :</strong> <?php echo htmlspecialchars($login); ?></p>
    <p><strong>Email actuel :</strong> <?php echo htmlspecialchars($email_actuel); ?></p>

    <h3>🔄 Modifier l'email</h3>
    <form method="post">
        <label for="nouvel_email">Nouvel email :</label>
        <input type="email" name="nouvel_email" required>
        <input type="submit" name="modifier_email" value="Mettre à jour">
    </form>

    <h3>🔐 Changer le mot de passe</h3>
    <form method="post">
        <label for="ancien_mdp">Ancien mot de passe :</label>
        <input type="password" name="ancien_mdp" required><br>

        <label for="nouveau_mdp">Nouveau mot de passe :</label>
        <input type="password" name="nouveau_mdp" required><br>

        <input type="submit" name="modifier_mdp" value="Changer le mot de passe">
    </form>

    <br>
<div class="buttons">
    <?php
    // Redirection selon le type de l'utilisateur
    if ($type == 2) {  // Professeur
        echo '<button type="button" onclick="window.location.href=\'professeur.php\'">Retour à l\'accueil (Professeur)</button>';
    } elseif ($type == 1) {  // Élève
        echo '<button type="button" onclick="window.location.href=\'eleve.php\'">Retour à l\'accueil (Élève)</button>';
    } else {
        echo '<button type="button" onclick="window.location.href=\'index.php\'">Retour à l\'accueil</button>';
    }
    ?>
    <button type="button" onclick="window.location.href='index.php'">Déconnexion</button>
</div>

</body>
</html>