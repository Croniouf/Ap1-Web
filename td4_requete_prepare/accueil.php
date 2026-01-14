<?php
session_start();

$serveurBDD = "localhost";
$userBDD = "root";
$mdpBDD = "root";
$nomBDD = "td4_bloc3";

try {
    $bdd = new PDO("mysql:host=$serveurBDD;dbname=$nomBDD;charset=utf8", $userBDD, $mdpBDD);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if (isset($_POST['login']) && isset($_POST['mdp'])) {

    $login = $_POST['login'];
    $mdp = $_POST['mdp'];

    $stmt = $bdd->prepare("SELECT * FROM acheteur WHERE login = :login AND mdp = :mdp");
    $stmt->execute([':login' => $login, ':mdp' => $mdp]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['Sid'] = $user['login'];

        

        echo "✅ Votre email a bien été trouvé !<br><br>";
        echo "<strong>Informations de l'utilisateur :</strong><br>";
    
        

        foreach ($user as $champ => $valeur) {
            if ($champ != 'id') {
                echo ucfirst($champ) . " : " . htmlspecialchars($valeur) . "<br>";
            }
        
        
        }
?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk
</body>
</html>

<?php
    
    } else {
        echo "❌ EMAIL OU MOT DE PASSE INCORRECT";
    }
}
?>

