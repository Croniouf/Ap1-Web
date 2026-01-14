<?php
$serveurBDD="localhost";
$userBDD="root";
$mdpBDD="root";
$nomBDD="td4_bloc3";
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
    <title>Formulaire</title>
</head>
<body>
    <form action="accueil.php" method="post">
    <label for="login">Login</label>
    <input type="text" id="login" name="login" required>
    
    <label for="mdp">Mot de Passe</label>
    <input type="password" id="mdp" name="mdp" required>
    
    <div class button>
    <button type= "submit">Comfirmer</button>
</div>
</body>