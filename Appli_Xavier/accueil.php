<?php
session_start(); // à utiliser pour $_SESSION
include '_conf.php';

// Connexion à la base de données
$bdd = mysqli_connect($serveurBDD, $userBDD, $mdpBDD, $nomBDD);
if (!$bdd) {
    die("Erreur de connexion à la BDD : " . mysqli_connect_error());
}

$error_message = '';  // Variable pour stocker le message d'erreur

// Si le formulaire est soumis
if (isset($_POST['login']) && isset($_POST['mot_de_passe'])) {

    $lemail = mysqli_real_escape_string($bdd, $_POST['login']);
    $mdp = $_POST['mot_de_passe']; // Ne pas échapper pour le hachage

    // Requête pour récupérer l'utilisateur selon l'email
    $requete = "SELECT * FROM utilisateur WHERE email='$lemail'";
    $resultat = mysqli_query($bdd, $requete);

    if (mysqli_num_rows($resultat) == 1) {
        // Utilisateur trouvé
        $donnees = mysqli_fetch_assoc($resultat);
        $mdp_hash = hash('sha256', $mdp);

        // Vérification du mot de passe avec SHA256
        if ($mdp_hash === $donnees['motdepasse']) {
            // Le mot de passe est correct
            $_SESSION['Sid'] = $donnees['login'];  // Stocke le login en session
            $_SESSION['type'] = $donnees['type'];  // Stocke le type (1 pour élève, 2 pour professeur)

            // Redirection selon le type de l'utilisateur
            if ($donnees['type'] == '1') {
                // Type 1 -> Élève
                header("Location: eleve.php");
                exit();
            } elseif ($donnees['type'] == '2') {
                // Type 2 -> Professeur
                header("Location: professeur.php");
                exit();
            }
        } else {
            // Si le mot de passe est incorrect
            $error_message = "Email ou mot de passe incorrect";
        }
    } else {
        // Si l'email n'est pas trouvé
        $error_message = "Email ou mot de passe incorrect";
    }
}

// Déconnexion
if (isset($_POST['Deconnexion'])) {
    session_unset();
    session_destroy();
    echo "<p>Déconnexion effectuée.</p>";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page de Connexion</title>
    <link rel="stylesheet" href="accueil.css">
</head>
<body>

<form method="post">
    <h2>Connexion</h2>

    <!-- Affichage du message d'erreur -->
    <?php if ($error_message != ''): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <label>Email :</label><br>
    <input type="text" name="login" required><br><br>

    <label>Mot de passe :</label><br>
    <input type="password" name="mot_de_passe" required><br><br>

    <button type="submit">Se connecter</button>
</form>

</body>
</html>