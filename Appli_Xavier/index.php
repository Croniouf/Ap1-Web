<?php
include '_conf.php';

?>

<?php
if ($bdd = mysqli_connect($serveurBDD, $userBDD, $mdpBDD,$nomBDD))
{
    echo "Connexion reussi !";
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
    <div class= "formulaire">
        <h2>Formulaire<h2>
        <labbel>Login</labbel>
        <input type = "text" name = "login" required>
        <br>
        <labbel>Mot de passe</labbel>
        <input type = "text" name = "mot de passe" required>
    </div>
    <button type="Comfirmer" class="form-button">Comfirmer</button>
    <button><a href = "oubli.php"> Mot de passe Oublié ? </a><button>
</body>
