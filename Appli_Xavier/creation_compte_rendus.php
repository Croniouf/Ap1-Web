<?php
// ——— Affichage des erreurs ———
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Paris');
include '_conf.php';

$conn = new mysqli($serveurBDD, $userBDD, $mdpBDD, $nomBDD);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// ——— Si le formulaire est soumis ———
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $date = $_POST['date'] ?? '';
    $description = $_POST['description'] ?? '';
    $email = $_POST['email'] ?? ''; // ✅ variable bien nommée
    $vu = 0;
    $datetime = date('Y-m-d H:i:s');

    // ✅ vérification cohérente
    if (!empty($date) && !empty($description) && !empty($email)) {
        $sql = "INSERT INTO compte_rendu (`date`, description, vu, datetime, email)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Erreur SQL : " . $conn->error);
        }

        // ✅ types : s = string, i = int
        $stmt->bind_param("ssiss", $date, $description, $vu, $datetime, $email);

        if ($stmt->execute()) {
            $message = "<p style='color:green;text-align:center;'>✅ Compte rendu enregistré avec succès !</p>";
        } else {
            $message = "<p style='color:red;text-align:center;'>❌ Erreur : " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        $message = "<p style='color:orange;text-align:center;'>⚠️ Tous les champs sont obligatoires.</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un compte rendu</title>
    <link rel="stylesheet" href="creation_compte_rendus.css">
</head>
<body>

<div class="formulaire">
    <h2>Ajouter un compte rendu</h2>

    <?= $message ?>

    <form action="" method="POST">
        <label>Date :</label>
        <input type="date" name="date" required>

        <label>Description :</label>
        <textarea name="description" rows="4" required></textarea>

        <label>Email :</label>
        <input type="email" name="email" required>

        <div class="buttons">
            <button type="submit">💾 Enregistrer</button>
            <?php
            session_start();
            if (isset($_SESSION['type'])) {
                if ($_SESSION['type'] == 2) {
                    echo '<button type="button" onclick="window.location.href=\'professeur.php\'">⬅️ Retour</button>';
                } elseif ($_SESSION['type'] == 1) {
                    echo '<button type="button" onclick="window.location.href=\'eleve.php\'">⬅️ Retour</button>';
                } else {
                    echo '<button type="button" onclick="window.location.href=\'accueil.php\'">⬅️ Retour</button>';
                }
            } else {
                echo '<button type="button" onclick="window.location.href=\'accueil.php\'">⬅️ Retour</button>';
            }
            ?>
        </div>
    </form>
</div>

</body>
</html>