<?php
include '_conf.php';

?>

<?php
if ($bdd = mysqli_connect($serveurBDD, $userBDD, $mdpBDD,$nomBDD))
{
    //echo "Connexion reussi !";
}
else
{
    echo "ERREUR !!";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Connexion</title>
    <link rel="stylesheet" href="index.css">


</head>
<body>
<div class="formulaire">
        <h2>SUIVI DES STAGES</h2>
        <form action="accueil.php" method="post">
            <label for="login">Login</label>
            <input type="text" id="login" name="login" required>

            <label for="mdp">Mot de passe</label>
            <input type="password" id="mdp" name="mot_de_passe" required>

            <div class="buttons">
                <button type="submit">Confirmer</button>
                <button type="button" onclick="window.location.href='oubli.php'">Mot de passe oublié ?</button>
            </div>
        </form>
    </div>
</body>
