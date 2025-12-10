<?php
// ——— Affichage des erreurs ———
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ——— Connexion à la base de données ———
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "root";
$basededonnees = "appli_web_xavier";

$conn = new mysqli($serveur, $utilisateur, $motdepasse, $basededonnees);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['Sid'])) {
    header('Location: index.php');
    exit();
}

$num = $_GET['num'] ?? 0;

if ($num > 0) {
    // Récupérer l'email de l'utilisateur connecté
    $user_login = $_SESSION['Sid'];
    $sql_user = "SELECT email FROM utilisateur WHERE login = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("s", $user_login);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    $user_data = $result_user->fetch_assoc();
    $user_email = $user_data['email'];
    $stmt_user->close();

    // Vérifier que le compte rendu appartient à l'utilisateur
    $sql_check = "SELECT email FROM compte_rendu WHERE num = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $num);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $compte_rendu = $result_check->fetch_assoc();
    $stmt_check->close();

    // Si le compte rendu existe et appartient à l'utilisateur, le supprimer
    if ($compte_rendu && $compte_rendu['email'] == $user_email) {
        $sql_delete = "DELETE FROM compte_rendu WHERE num = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $num);
        $stmt_delete->execute();
        $stmt_delete->close();
    }
}

// Rediriger vers la liste des comptes rendus
header('Location: listes_compte_rendus.php');
exit();
?>