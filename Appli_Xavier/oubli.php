<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/phpmailer/Exception.php';
require __DIR__ . '/phpmailer/PHPMailer.php';
require __DIR__ . '/phpmailer/SMTP.php';

$mail = new PHPMailer(true);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="oubli.css">
</head>
<body>

<?php
include '_conf.php';

function genererChaineAleatoire($longueur = 10) {
    // Lettres majuscules, minuscules, chiffres et caractères spéciaux
    $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+[]{}';
    $chaineAleatoire = '';
    $longueurCaracteres = strlen($caracteres);

    for ($i = 0; $i < $longueur; $i++) {
        $indexAleatoire = random_int(0, $longueurCaracteres - 1);
        $chaineAleatoire .= $caracteres[$indexAleatoire];
    }

    return $chaineAleatoire;
}

//************************************** */
//si j'ai envoyé un email dans le formulaire
//************************************** */

if(isset($_POST['email'])) {
    $lemail = $_POST['email'];
    echo $lemail;
    $bdd = mysqli_connect($serveurBDD, $userBDD, $mdpBDD, $nomBDD);

    //echo "le formulaire a été envoyé avec comme email : ".$lemail;

    $requete = "Select * from utilisateur WHERE email= '$lemail'";
    $resultat = mysqli_query($bdd, $requete);
    $mdp = "0";
    while($donnees = mysqli_fetch_assoc($resultat)) {
        $mdp = $donnees['motdepasse'];
    }

    if($mdp == "0") {
        //echo " Erreur d'envoie d'email";
    } else {
        //echo" Votre email a bien été envoyé !";

        //on génère un mot de passe aléatoire 
        $newmdp = genererChaineAleatoire(10);
        //echo"<hr>$newmdp</hr>";

        $mdphash = md5($newmdp);

        //on l'envoi à l'utilisateur

        // on met à jour la bdd
        // à faire après la séléction bdd
        $requete2 = "UPDATE `utilisateur` SET `motdepasse` = '$mdphash' WHERE `utilisateur`.`email` = '$lemail';";
        if(!mysqli_query($bdd, $requete2)) {
            echo "<br>Erreur : " . mysqli_error($bdd) . "</br>";  
        }

        try {
            // Config SMTP Hostinger
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'contact@sioslam.fr';  // ⚠️ remplace par ton email Hostinger
            $mail->Password   = '&5&Y@*QHb';            // ⚠️ remplace par le mot de passe de cette boîte mail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail->Port       = 587;

            // Expéditeur
            $mail->setFrom('contact@sioslam.fr', 'CONTACT SIOSLAM');
            // Destinataire
            $mail->addAddress($lemail, 'Moi');

            // Contenu
            $mail->isHTML(true);
            $mail->Subject = 'Récupération de votre Mot de Passe';
            $mail->Body = 'Bonjour Monsieur, Madame,

Suite à votre demande de réinitialisation, voici votre mot de passe temporaire :
🔐 Votre Mot de passe : ' . $newmdp . '

Nous vous recommandons de vous connecter dès que possible et de modifier ce mot de passe depuis votre espace personnel pour garantir la sécurité de votre compte.

Si vous n’êtes pas à l’origine de cette demande, veuillez nous contacter immédiatement.

Cordialement,
L’équipe de récupération';
            $mail->AltBody = '';

            $mail->send();
            echo "✅ Email envoyé avec succès !";
        } catch (Exception $e) {
            echo "❌ Erreur d'envoi : {$mail->ErrorInfo}";
        }
    }
    //echo $donnees['motdepasse'];
} else {
    ?>
    <form method="post">
        <h3>RETROUVER VOTRE MOT DE PASSE</h3>
        <label>Email</label>
        <input type="text" name="email" required>
        <input type="submit" value="Comfirmer">
    </form>
    <?php
}
?>

</body>
</html>
