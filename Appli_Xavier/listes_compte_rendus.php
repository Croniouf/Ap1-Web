<?php
// ——— Affichage des erreurs ———
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '_conf.php';

$conn = new mysqli($serveurBDD, $userBDD , $mdpBDD, $nomBDD);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

session_start();
$user_login = $_SESSION['Sid'] ?? ''; // Récupère le login de l'utilisateur connecté

// ——— Récupération de l'email de l'utilisateur connecté ———
$user_email = "";
if (!empty($user_login)) {
    $sql_user = "SELECT email FROM utilisateur WHERE login = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("s", $user_login);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    
    if ($user_data = $result_user->fetch_assoc()) {
        $user_email = $user_data['email'];
    }
    $stmt_user->close();
}

// ——— Récupération de tous les comptes rendus ———
$sql = "SELECT num, `date`, description, email, vu, datetime FROM compte_rendu ORDER BY datetime DESC";
$result = $conn->query($sql);

// Si une erreur survient lors de la requête
if ($result === false) {
    die("Erreur dans la requête : " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des comptes rendus</title>
    <link rel="stylesheet" href="listes_compte_rendus.css">
</head>
<body>

<h2>Liste des comptes rendus</h2>

<table>
    <thead>
        <tr>
            <th>Num</th>
            <th>Date</th>
            <th>Description</th>
            <th>Email</th>
            <th>Vu</th>
            <th>Date/Heure</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['num'] ?></td>
                    <td><?= htmlspecialchars($row['date']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= $row['vu'] ? "Oui" : "Non" ?></td>
                    <td><?= htmlspecialchars($row['datetime']) ?></td>
                    <td>
                        <?php if ($row['email'] == $user_email): ?>
                            <a class="button" href="modifier_compte_rendu.php?num=<?= $row['num'] ?>">Modifier</a>
                            <a class="button" href="supprimer_compte_rendu.php?num=<?= $row['num'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce compte rendu ?')" style="background-color: #ff4444; margin-left: 5px;">Supprimer</a>
                        <?php else: ?>
                            <span>-</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" style="text-align:center;">Aucun compte rendu trouvé.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- BOUTON RETOUR -->
<div style="text-align:center; margin-top:20px;">
    <?php
    if (isset($_SESSION['type'])) {
        if ($_SESSION['type'] == 2) {
            echo '<button onclick="window.location.href=\'professeur.php\'">⬅️ Retour</button>';
        } elseif ($_SESSION['type'] == 1) {
            echo '<button onclick="window.location.href=\'eleve.php\'">⬅️ Retour</button>';
        } else {
            echo '<button onclick="window.location.href=\'accueil.php\'">⬅️ Retour</button>';
        }
    } else {
        echo '<button onclick="window.location.href=\'accueil.php\'">⬅️ Retour</button>';
    }
    ?>
</div>

</body>
</html>

<?php
$conn->close();
?>