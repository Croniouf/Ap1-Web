<?php
session_start(); //a utiliser pour $_SESSION

include '_conf.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/phpmailer/Exception.php';
require __DIR__ . '/phpmailer/PHPMailer.php';
require __DIR__ . '/phpmailer/SMTP.php';

$mail = new PHPMailer(true);

//detecte l'envoie du formulaire ou j'appuie sur le boutton send_con


if (isset($_POST['login']))
{
    $lemail = $_POST['login'];
    echo $lemail;

    $mdp = $_POST['mot_de_passe'];
    //echo $mdp;

$bdd = mysqli_connect($serveurBDD, $userBDD, $mdpBDD, $nomBDD);
$requete = "Select * from utilisateur WHERE email= '$lemail'";
$resultat = mysqli_query($bdd, $requete);
$trouve = "0";

while($donnees = mysqli_fetch_assoc($resultat))
    {

    $trouve = 1;
    $num=$donnees['num'];
    $type=$donnees['type'];
    $login=$donnees['login'];
    $_SESSION['Sid'] = $login;

    //$type=$donnees[];

    $login=$donnees['login'];

}

if($trouve == "0") {


    echo " EMAIL NON TROUVE";


} else {


    echo " Votre email a bien été trouvé !";

    //$newmdp = genererChaineAleatoire(10);

    //echo "<hr>$newmdp</hr>";

    //$mdphash = md5($newmdp);

    //requete2 = "UPDATE `utilisateur` SET `motdepasse` = '$mdphash' WHERE `utilisateur`.`email` = '$lemail';";
    }  
}

if (isset($_SESSION['Sid']))
{
    echo("Vous êtes connecté en tant que  '  $lemail'");
    if($type == '1')
    {
        echo("PARTIE ELEVE");
    }
    else{
        echo("PARTIE PROF");
    }
}
else
{
	echo "La connexion est perdue, veuillez revenir à la <a href='index.php'>page index</a> pour vous reconnecter."; 
}


if (isset($_POST['Deconnexion'])) {
    session_start(); // Nécessaire pour accéder à la session
    session_unset(); // Supprime toutes les variables de session
    session_destroy(); // Détruit la session

    echo("Déconnexion effectuée. Merci de votre visite !");
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <br>
    <title>Page d'Accueil</title>
    <h1></h1>
    <br>
</head>

<body>
    <form method="post">
           <div class="buttons">
                <button type="button" onclick="window.location.href='index.php'">Deconnexion</button>
                <button type="button" onclick="window.location.href='perso.php'">Informations d'utilisateur</button>
            </div>
    </form>
</body>
</html>
