<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "u482683110_26PARIS";
$password = "I6par26?";
$dbname = "u482683110_26PARIS_BDD";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Créer la table pour les mots de passe si elle n'existe pas
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS user_passwords (
        user_id INT PRIMARY KEY,
        password_hash VARCHAR(255) NOT NULL,
        FOREIGN KEY (user_id) REFERENCES utilisateur2(user_id)
    )");
} catch(PDOException $e) {
    // La table existe peut-être déjà
}

// Initialiser les mots de passe pour les utilisateurs existants s'ils n'en ont pas
try {
    $users = $pdo->query("SELECT user_id FROM utilisateur2 WHERE user_id NOT IN (SELECT user_id FROM user_passwords)")->fetchAll();
    foreach ($users as $user) {
        $default_password = password_hash('123456', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT IGNORE INTO user_passwords (user_id, password_hash) VALUES (?, ?)");
        $stmt->execute([$user['user_id'], $default_password]);
    }
} catch(PDOException $e) {
    // Ignorer les erreurs
}

// Gestion des redirections AVANT tout affichage HTML
$redirect_url = null;

// Traitement de l'inscription
if (isset($_POST['inscription']) && !empty($_POST['login_inscription']) && !empty($_POST['password_inscription'])) {
    $login = htmlspecialchars($_POST['login_inscription']);
    $password = $_POST['password_inscription'];
    
    try {
        $stmt = $pdo->prepare("SELECT user_id FROM utilisateur2 WHERE login = ?");
        $stmt->execute([$login]);
        
        if ($stmt->fetch()) {
            $erreur = "Ce nom d'utilisateur existe déjà !";
        } else {
            $stmt = $pdo->query("SELECT MAX(user_id) as max_id FROM utilisateur2");
            $max_id = $stmt->fetch()['max_id'];
            $new_user_id = $max_id + 1;
            
            $stmt = $pdo->prepare("INSERT INTO utilisateur2 (user_id, login, date_naissance) VALUES (?, ?, CURDATE())");
            $stmt->execute([$new_user_id, $login]);
            
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO user_passwords (user_id, password_hash) VALUES (?, ?)");
            $stmt->execute([$new_user_id, $password_hash]);
            
            $_SESSION['user_id'] = $new_user_id;
            $_SESSION['login'] = $login;
            $redirect_url = $_SERVER['PHP_SELF'];
        }
    } catch(PDOException $e) {
        $erreur = "Erreur lors de l'inscription: " . $e->getMessage();
    }
}

// Traitement de la connexion
if (isset($_POST['connexion']) && !empty($_POST['login_connexion']) && !empty($_POST['password_connexion'])) {
    $login = htmlspecialchars($_POST['login_connexion']);
    $password = $_POST['password_connexion'];
    
    try {
        $stmt = $pdo->prepare("SELECT u.user_id, u.login, p.password_hash 
                              FROM utilisateur2 u 
                              LEFT JOIN user_passwords p ON u.user_id = p.user_id 
                              WHERE u.login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch();
        
        if ($user) {
            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['login'] = $user['login'];
                $redirect_url = $_SERVER['PHP_SELF'];
            } else {
                $erreur = "Mot de passe incorrect !";
            }
        } else {
            $erreur = "Nom d'utilisateur incorrect !";
        }
    } catch(PDOException $e) {
        $erreur = "Erreur lors de la connexion: " . $e->getMessage();
    }
}

// Déconnexion
if (isset($_GET['deconnexion'])) {
    session_destroy();
    $redirect_url = $_SERVER['PHP_SELF'];
}

// Redirection si nécessaire (AVANT tout affichage HTML)
if ($redirect_url) {
    header("Location: " . $redirect_url);
    exit();
}

// Gestion des redirections pour le forum
$forum_redirect = null;

// Traitement de l'ajout d'une nouvelle question (uniquement si connecté)
if (isset($_POST['ajouter_question']) && !empty($_POST['titre']) && !empty($_POST['contenu'])) {
    if (!isset($_SESSION['user_id'])) {
        $erreur_forum = "Vous devez être connecté pour poser une question.";
    } else {
        $titre = htmlspecialchars($_POST['titre']);
        $contenu = htmlspecialchars($_POST['contenu']);
        $date_ajout = date('Y-m-d H:i');
        $user_id = $_SESSION['user_id'];
        
        try {
            $stmt = $pdo->query("SELECT MAX(q_id) as max_id FROM question");
            $max_id = $stmt->fetch()['max_id'];
            $new_q_id = $max_id + 1;
            
            $stmt = $pdo->prepare("INSERT INTO question (q_id, q_titre, q_contenu, q_date_ajout, user_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$new_q_id, $titre, $contenu, $date_ajout, $user_id]);
            
            $_SESSION['success_message'] = "Votre question a été ajoutée avec succès !";
            $forum_redirect = $_SERVER['PHP_SELF'];
            
        } catch(PDOException $e) {
            $erreur_forum = "Erreur lors de l'ajout de la question: " . $e->getMessage();
        }
    }
}

// Traitement de la modification d'une question (uniquement si connecté et propriétaire)
if (isset($_POST['modifier_question']) && !empty($_POST['titre_modif']) && !empty($_POST['contenu_modif']) && !empty($_POST['question_id_modif'])) {
    if (!isset($_SESSION['user_id'])) {
        $erreur_forum = "Vous devez être connecté pour modifier une question.";
    } else {
        $question_id = intval($_POST['question_id_modif']);
        $titre = htmlspecialchars($_POST['titre_modif']);
        $contenu = htmlspecialchars($_POST['contenu_modif']);
        
        try {
            // Vérifier que l'utilisateur est bien l'auteur de la question
            $stmt = $pdo->prepare("SELECT user_id FROM question WHERE q_id = ?");
            $stmt->execute([$question_id]);
            $question = $stmt->fetch();
            
            if ($question && $question['user_id'] == $_SESSION['user_id']) {
                $stmt = $pdo->prepare("UPDATE question SET q_titre = ?, q_contenu = ? WHERE q_id = ?");
                $stmt->execute([$titre, $contenu, $question_id]);
                
                $_SESSION['success_message'] = "Votre question a été modifiée avec succès !";
                $forum_redirect = $_SERVER['PHP_SELF'] . "?question_id=" . $question_id;
            } else {
                $erreur_forum = "Vous n'êtes pas autorisé à modifier cette question.";
            }
        } catch(PDOException $e) {
            $erreur_forum = "Erreur lors de la modification de la question: " . $e->getMessage();
        }
    }
}

// Traitement de la suppression d'une question (uniquement si connecté et propriétaire)
if (isset($_GET['supprimer_question']) && !empty($_GET['supprimer_question'])) {
    if (!isset($_SESSION['user_id'])) {
        $erreur_forum = "Vous devez être connecté pour supprimer une question.";
    } else {
        $question_id = intval($_GET['supprimer_question']);
        
        try {
            // Vérifier que l'utilisateur est bien l'auteur de la question
            $stmt = $pdo->prepare("SELECT user_id FROM question WHERE q_id = ?");
            $stmt->execute([$question_id]);
            $question = $stmt->fetch();
            
            if ($question && $question['user_id'] == $_SESSION['user_id']) {
                // Supprimer d'abord les réponses associées
                $stmt = $pdo->prepare("DELETE FROM reponse WHERE r_fk_question_id = ?");
                $stmt->execute([$question_id]);
                
                // Puis supprimer la question
                $stmt = $pdo->prepare("DELETE FROM question WHERE q_id = ?");
                $stmt->execute([$question_id]);
                
                $_SESSION['success_message'] = "Votre question a été supprimée avec succès !";
                $forum_redirect = $_SERVER['PHP_SELF'];
            } else {
                $erreur_forum = "Vous n'êtes pas autorisé à supprimer cette question.";
            }
        } catch(PDOException $e) {
            $erreur_forum = "Erreur lors de la suppression de la question: " . $e->getMessage();
        }
    }
}

// Traitement de l'ajout d'une nouvelle réponse (uniquement si connecté)
$question_id = isset($_GET['question_id']) ? intval($_GET['question_id']) : 0;

if (isset($_POST['ajouter_reponse']) && !empty($_POST['contenu_reponse']) && $question_id > 0) {
    if (!isset($_SESSION['user_id'])) {
        $erreur_forum = "Vous devez être connecté pour répondre à une question.";
    } else {
        $contenu_reponse = htmlspecialchars($_POST['contenu_reponse']);
        $date_ajout = date('Y-m-d H:i');
        $user_id = $_SESSION['user_id'];
        
        try {
            $stmt = $pdo->query("SELECT MAX(r_id) as max_id FROM reponse");
            $max_id = $stmt->fetch()['max_id'];
            $new_r_id = $max_id + 1;
            
            $stmt = $pdo->prepare("INSERT INTO reponse (r_id, r_contenu, r_date_ajout, r_fk_question_id, user_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$new_r_id, $contenu_reponse, $date_ajout, $question_id, $user_id]);
            
            $_SESSION['success_message'] = "Votre réponse a été ajoutée avec succès !";
            $forum_redirect = $_SERVER['PHP_SELF'] . "?question_id=" . $question_id;
            
        } catch(PDOException $e) {
            $erreur_forum = "Erreur lors de l'ajout de la réponse: " . $e->getMessage();
        }
    }
}

// Traitement de la modification d'une réponse (uniquement si connecté et propriétaire)
if (isset($_POST['modifier_reponse']) && !empty($_POST['contenu_reponse_modif']) && !empty($_POST['reponse_id_modif'])) {
    if (!isset($_SESSION['user_id'])) {
        $erreur_forum = "Vous devez être connecté pour modifier une réponse.";
    } else {
        $reponse_id = intval($_POST['reponse_id_modif']);
        $contenu = htmlspecialchars($_POST['contenu_reponse_modif']);
        
        try {
            // Vérifier que l'utilisateur est bien l'auteur de la réponse
            $stmt = $pdo->prepare("SELECT user_id, r_fk_question_id FROM reponse WHERE r_id = ?");
            $stmt->execute([$reponse_id]);
            $reponse = $stmt->fetch();
            
            if ($reponse && $reponse['user_id'] == $_SESSION['user_id']) {
                $stmt = $pdo->prepare("UPDATE reponse SET r_contenu = ? WHERE r_id = ?");
                $stmt->execute([$contenu, $reponse_id]);
                
                $_SESSION['success_message'] = "Votre réponse a été modifiée avec succès !";
                $forum_redirect = $_SERVER['PHP_SELF'] . "?question_id=" . $reponse['r_fk_question_id'];
            } else {
                $erreur_forum = "Vous n'êtes pas autorisé à modifier cette réponse.";
            }
        } catch(PDOException $e) {
            $erreur_forum = "Erreur lors de la modification de la réponse: " . $e->getMessage();
        }
    }
}

// Traitement de la suppression d'une réponse (uniquement si connecté et propriétaire)
if (isset($_GET['supprimer_reponse']) && !empty($_GET['supprimer_reponse'])) {
    if (!isset($_SESSION['user_id'])) {
        $erreur_forum = "Vous devez être connecté pour supprimer une réponse.";
    } else {
        $reponse_id = intval($_GET['supprimer_reponse']);
        
        try {
            // Vérifier que l'utilisateur est bien l'auteur de la réponse
            $stmt = $pdo->prepare("SELECT user_id, r_fk_question_id FROM reponse WHERE r_id = ?");
            $stmt->execute([$reponse_id]);
            $reponse = $stmt->fetch();
            
            if ($reponse && $reponse['user_id'] == $_SESSION['user_id']) {
                $stmt = $pdo->prepare("DELETE FROM reponse WHERE r_id = ?");
                $stmt->execute([$reponse_id]);
                
                $_SESSION['success_message'] = "Votre réponse a été supprimée avec succès !";
                $forum_redirect = $_SERVER['PHP_SELF'] . "?question_id=" . $reponse['r_fk_question_id'];
            } else {
                $erreur_forum = "Vous n'êtes pas autorisé à supprimer cette réponse.";
            }
        } catch(PDOException $e) {
            $erreur_forum = "Erreur lors de la suppression de la réponse: " . $e->getMessage();
        }
    }
}

// Redirection pour le forum (AVANT tout affichage HTML)
if ($forum_redirect) {
    header("Location: " . $forum_redirect);
    exit();
}

// Si on arrive ici, afficher le forum (connecté ou non)
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum de Discussion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ddd;
        }
        h1, h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .question-link {
            color: #0066cc;
            text-decoration: none;
            font-weight: bold;
        }
        .question-link:hover {
            text-decoration: underline;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            height: 100px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
            margin-bottom: 5px;
        }
        button:hover {
            background-color: #45a049;
        }
        .btn-modifier {
            background-color: #FF9800;
        }
        .btn-modifier:hover {
            background-color: #F57C00;
        }
        .btn-supprimer {
            background-color: #f44336;
        }
        .btn-supprimer:hover {
            background-color: #d32f2f;
        }
        .btn-connexion {
            background-color: #2196F3;
        }
        .btn-connexion:hover {
            background-color: #1976D2;
        }
        .btn-deconnexion {
            background-color: #f44336;
        }
        .btn-deconnexion:hover {
            background-color: #d32f2f;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #0066cc;
            text-decoration: none;
            padding: 8px 15px;
            background-color: white;
            border-radius: 4px;
        }
        .back-link:hover {
            text-decoration: underline;
            background-color: #f0f0f0;
        }
        .question-details {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            position: relative;
        }
        .reponse-item {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 15px;
            border-left: 4px solid #4CAF50;
            position: relative;
        }
        .success-message {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            border: 1px solid #d6e9c6;
        }
        .error-message {
            background-color: #f2dede;
            color: #a94442;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            border: 1px solid #ebccd1;
        }
        .info-message {
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            border: 1px solid #bee5eb;
        }
        .user-info {
            background-color: #e7f3ff;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
        }
        .visitor-info {
            background-color: #fff3cd;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
        }
        .actions-buttons {
            position: absolute;
            top: 15px;
            right: 15px;
        }
        .modification-form {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
            border: 1px solid #dee2e6;
        }
        .login-prompt {
            text-align: center;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>💬 Forum de Discussion</h1>
        <div class="<?= isset($_SESSION['user_id']) ? 'user-info' : 'visitor-info' ?>">
            <?php if (isset($_SESSION['user_id'])): ?>
                👤 Connecté en tant que : <strong><?= htmlspecialchars($_SESSION['login']) ?></strong>
                <a href="?deconnexion=1" class="btn-deconnexion" style="margin-left: 15px; padding: 5px 10px; font-size: 12px;">🚪 Déconnexion</a>
            <?php else: ?>
                👤 Visiteur
                <a href="?connexion=1" class="btn-connexion" style="margin-left: 15px; padding: 5px 10px; font-size: 12px;">🔐 Se connecter</a>
            <?php endif; ?>
        </div>
    </div>
    
    <?php
    // Afficher les messages de succès
    if (isset($_SESSION['success_message'])) {
        echo "<div class='success-message'>" . $_SESSION['success_message'] . "</div>";
        unset($_SESSION['success_message']);
    }
    
    if (isset($erreur_forum)) {
        echo "<div class='error-message'>" . $erreur_forum . "</div>";
    }
    
    // Afficher un message d'information pour les visiteurs
    if (!isset($_SESSION['user_id'])) {
        echo "<div class='info-message'>";
        echo "<strong>💡 Mode visiteur :</strong> Vous pouvez consulter le forum. <a href='?connexion=1' style='color: #2196F3;'>Connectez-vous</a> pour poser des questions et répondre.";
        echo "</div>";
    }
    ?>
    
    <?php if ($question_id == 0): ?>
    <!-- Page 1 : Liste des questions -->
    
    <!-- Formulaire pour ajouter une question (uniquement si connecté) -->
    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="form-container">
        <h2>➕ Poser une nouvelle question</h2>
        <form method="post">
            <div class="form-group">
                <label for="titre">📌 Titre de la question:</label>
                <input type="text" id="titre" name="titre" placeholder="Donnez un titre clair à votre question" required>
            </div>
            <div class="form-group">
                <label for="contenu">📝 Contenu de la question:</label>
                <textarea id="contenu" name="contenu" placeholder="Décrivez votre problème ou votre question en détail..." required></textarea>
            </div>
            <button type="submit" name="ajouter_question">✅ Publier la question</button>
        </form>
    </div>
    <?php else: ?>
    <div class="login-prompt">
        <h3>💬 Vous souhaitez poser une question ?</h3>
        <p>Connectez-vous pour participer aux discussions et poser vos propres questions.</p>
        <a href="?connexion=1" class="btn-connexion">🔐 Se connecter / S'inscrire</a>
    </div>
    <?php endif; ?>
    
    <!-- Tableau des questions -->
    <h2>📋 Liste des questions</h2>
    <?php
    try {
        $sql = "
            SELECT 
                q.q_id,
                q.q_titre,
                u.login AS user_login,
                q.q_date_ajout,
                COUNT(r.r_id) AS nb_reponses,
                MAX(r.r_date_ajout) AS derniere_reponse_date,
                q.user_id
            FROM question q
            JOIN utilisateur2 u ON q.user_id = u.user_id
            LEFT JOIN reponse r ON q.q_id = r.r_fk_question_id
            GROUP BY q.q_id, q.q_titre, u.login, q.q_date_ajout, q.user_id
            ORDER BY COALESCE(MAX(r.r_date_ajout), q.q_date_ajout) DESC
        ";
        
        $stmt = $pdo->query($sql);
        $questions = $stmt->fetchAll();
        
        if (count($questions) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Titre question</th>
                    <th>Utilisateur</th>
                    <th>Réponses</th>
                    <th>Date question</th>
                    <th>Dernière réponse</th>
                    <th>Dernier répondant</th>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questions as $row): ?>
                <tr>
                    <td>
                        <a class='question-link' href='?question_id=<?= $row['q_id'] ?>'>
                            <?= htmlspecialchars($row['q_titre']) ?>
                        </a>
                    </td>
                    <td><?= htmlspecialchars($row['user_login']) ?></td>
                    <td style="text-align: center;">
                        <span style="background-color: #4CAF50; color: white; padding: 2px 8px; border-radius: 12px; font-size: 12px;">
                            <?= $row['nb_reponses'] ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars($row['q_date_ajout']) ?></td>
                    <td><?= $row['derniere_reponse_date'] ? htmlspecialchars($row['derniere_reponse_date']) : 'Aucune réponse' ?></td>
                    <td>
                        <?php
                        if ($row['nb_reponses'] > 0) {
                            $sql_dernier_repondant = "
                                SELECT u.login 
                                FROM reponse r 
                                JOIN utilisateur2 u ON r.user_id = u.user_id 
                                WHERE r.r_fk_question_id = ? 
                                ORDER BY r.r_date_ajout DESC 
                                LIMIT 1
                            ";
                            $stmt_repondant = $pdo->prepare($sql_dernier_repondant);
                            $stmt_repondant->execute([$row['q_id']]);
                            $dernier_repondant = $stmt_repondant->fetch();
                            echo $dernier_repondant ? htmlspecialchars($dernier_repondant['login']) : 'N/A';
                        } else {
                            echo 'N/A';
                        }
                        ?>
                    </td>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <td>
                            <?php if ($row['user_id'] == $_SESSION['user_id']): ?>
                                <a href="?supprimer_question=<?= $row['q_id'] ?>" class="btn-supprimer" style="padding: 5px 10px; font-size: 12px;" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette question ?')">🗑️ Supprimer</a>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>Aucune question n'a été posée pour le moment. <?php if (!isset($_SESSION['user_id'])): ?><a href="?connexion=1">Connectez-vous</a> pour être le premier !<?php else: ?>Soyez le premier à poser une question !<?php endif; ?></p>
        <?php endif;
        
    } catch(Exception $e) {
        echo "<div class='error-message'>Erreur lors du chargement des questions: " . $e->getMessage() . "</div>";
    }
    ?>
    
    <?php else: ?>
    <!-- Page 2 : Détails d'une question et ses réponses -->
    <?php
    try {
        $sql_question = "
            SELECT q.q_id, q.q_titre, q.q_contenu, u.login, q.q_date_ajout, q.user_id
            FROM question q
            JOIN utilisateur2 u ON q.user_id = u.user_id
            WHERE q.q_id = ?
        ";
        $stmt = $pdo->prepare($sql_question);
        $stmt->execute([$question_id]);
        $question = $stmt->fetch();
        
        if (!$question) {
            echo "<div class='error-message'>Question non trouvée.</div>";
            echo "<a class='back-link' href='?'>Retour à la liste des questions</a>";
            exit();
        }
    } catch(Exception $e) {
        echo "<div class='error-message'>Erreur lors du chargement de la question: " . $e->getMessage() . "</div>";
        echo "<a class='back-link' href='?'>Retour à la liste des questions</a>";
        exit();
    }
    
    // Vérifier si l'utilisateur est en train de modifier la question
    $modifier_question = isset($_GET['modifier_question']) && $_GET['modifier_question'] == $question_id;
    ?>
    
    <a class="back-link" href="?">← Retour à la liste des questions</a>
    
    <!-- Détails de la question -->
    <div class="question-details">
        <?php if (isset($_SESSION['user_id']) && $question['user_id'] == $_SESSION['user_id']): ?>
        <div class="actions-buttons">
            <?php if (!$modifier_question): ?>
                <a href="?question_id=<?= $question_id ?>&modifier_question=<?= $question_id ?>" class="btn-modifier" style="padding: 5px 10px; font-size: 12px;">✏️ Modifier</a>
                <a href="?supprimer_question=<?= $question_id ?>" class="btn-supprimer" style="padding: 5px 10px; font-size: 12px;" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette question ? Toutes les réponses seront également supprimées.')">🗑️ Supprimer</a>
            <?php else: ?>
                <a href="?question_id=<?= $question_id ?>" class="btn-supprimer" style="padding: 5px 10px; font-size: 12px;">❌ Annuler</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <?php if ($modifier_question && isset($_SESSION['user_id']) && $question['user_id'] == $_SESSION['user_id']): ?>
        <!-- Formulaire de modification de la question -->
        <h2>✏️ Modifier la question</h2>
        <form method="post">
            <input type="hidden" name="question_id_modif" value="<?= $question_id ?>">
            <div class="form-group">
                <label for="titre_modif">📌 Titre de la question:</label>
                <input type="text" id="titre_modif" name="titre_modif" value="<?= htmlspecialchars_decode($question['q_titre']) ?>" required>
            </div>
            <div class="form-group">
                <label for="contenu_modif">📝 Contenu de la question:</label>
                <textarea id="contenu_modif" name="contenu_modif" required><?= htmlspecialchars_decode($question['q_contenu']) ?></textarea>
            </div>
            <button type="submit" name="modifier_question" class="btn-modifier">💾 Enregistrer les modifications</button>
        </form>
        <?php else: ?>
        <!-- Affichage normal de la question -->
        <h2>❓ <?= htmlspecialchars($question['q_titre']) ?></h2>
        <p><strong>📝 Contenu question:</strong> <?= nl2br(htmlspecialchars_decode($question['q_contenu'])) ?></p>
        <p><strong>👤 Auteur:</strong> <?= htmlspecialchars($question['login']) ?></p>
        <p><strong>📅 Date de publication:</strong> <?= htmlspecialchars($question['q_date_ajout']) ?></p>
        <?php endif; ?>
    </div>
    
    <!-- Formulaire pour ajouter une réponse (uniquement si connecté) -->
    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="form-container">
        <h2>💬 Répondre à cette question</h2>
        <form method="post">
            <div class="form-group">
                <label for="contenu_reponse">📝 Votre réponse:</label>
                <textarea id="contenu_reponse" name="contenu_reponse" placeholder="Écrivez votre réponse ici..." required></textarea>
            </div>
            <button type="submit" name="ajouter_reponse">✅ Publier la réponse</button>
        </form>
    </div>
    <?php else: ?>
    <div class="login-prompt">
        <h3>💬 Vous souhaitez répondre à cette question ?</h3>
        <p>Connectez-vous pour participer à la discussion et donner votre avis.</p>
        <a href="?connexion=1" class="btn-connexion">🔐 Se connecter / S'inscrire</a>
    </div>
    <?php endif; ?>
    
    <!-- Liste des réponses -->
    <h2>🗨️ Réponses (<?php
        try {
            $sql_nb_reponses = "SELECT COUNT(*) as nb FROM reponse WHERE r_fk_question_id = ?";
            $stmt = $pdo->prepare($sql_nb_reponses);
            $stmt->execute([$question_id]);
            $nb_reponses = $stmt->fetch()['nb'];
            echo $nb_reponses;
        } catch(Exception $e) {
            echo "0";
        }
    ?>)</h2>
    
    <?php
    try {
        $sql_reponses = "
            SELECT r.r_id, r.r_contenu, r.r_date_ajout, u.login, r.user_id
            FROM reponse r
            JOIN utilisateur2 u ON r.user_id = u.user_id
            WHERE r.r_fk_question_id = ?
            ORDER BY r.r_date_ajout ASC
        ";
        $stmt = $pdo->prepare($sql_reponses);
        $stmt->execute([$question_id]);
        $reponses = $stmt->fetchAll();
        
        if (count($reponses) > 0) {
            foreach ($reponses as $index => $reponse) {
                $modifier_reponse = isset($_GET['modifier_reponse']) && $_GET['modifier_reponse'] == $reponse['r_id'];
                echo "<div class='reponse-item'>";
                
                // Boutons d'actions pour le propriétaire de la réponse (uniquement si connecté)
                if (isset($_SESSION['user_id']) && $reponse['user_id'] == $_SESSION['user_id']) {
                    echo "<div class='actions-buttons'>";
                    if (!$modifier_reponse) {
                        echo "<a href='?question_id=" . $question_id . "&modifier_reponse=" . $reponse['r_id'] . "' class='btn-modifier' style='padding: 5px 10px; font-size: 12px;'>✏️ Modifier</a>";
                        echo "<a href='?supprimer_reponse=" . $reponse['r_id'] . "' class='btn-supprimer' style='padding: 5px 10px; font-size: 12px;' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette réponse ?\")'>🗑️ Supprimer</a>";
                    } else {
                        echo "<a href='?question_id=" . $question_id . "' class='btn-supprimer' style='padding: 5px 10px; font-size: 12px;'>❌ Annuler</a>";
                    }
                    echo "</div>";
                }
                
                if ($modifier_reponse && isset($_SESSION['user_id']) && $reponse['user_id'] == $_SESSION['user_id']) {
                    // Formulaire de modification de la réponse
                    echo "<h3>✏️ Modifier la réponse n°" . ($index + 1) . "</h3>";
                    echo "<form method='post' class='modification-form'>";
                    echo "<input type='hidden' name='reponse_id_modif' value='" . $reponse['r_id'] . "'>";
                    echo "<div class='form-group'>";
                    echo "<label for='contenu_reponse_modif'>📝 Votre réponse:</label>";
                    echo "<textarea id='contenu_reponse_modif' name='contenu_reponse_modif' required>" . htmlspecialchars_decode($reponse['r_contenu']) . "</textarea>";
                    echo "</div>";
                    echo "<button type='submit' name='modifier_reponse' class='btn-modifier'>💾 Enregistrer</button>";
                    echo "</form>";
                } else {
                    // Affichage normal de la réponse
                    echo "<h3>💬 Réponse n°" . ($index + 1) . "</h3>";
                    echo "<p><strong>📝 Contenu:</strong> " . nl2br(htmlspecialchars_decode($reponse['r_contenu'])) . "</p>";
                    echo "<p><strong>👤 Auteur:</strong> " . htmlspecialchars($reponse['login']) . "</p>";
                    echo "<p><strong>📅 Date:</strong> " . htmlspecialchars($reponse['r_date_ajout']) . "</p>";
                }
                
                echo "</div>";
            }
        } else {
            echo "<p style='text-align: center; color: #666; padding: 20px;'>Aucune réponse pour cette question. <?php if (!isset($_SESSION['user_id'])): ?><a href='?connexion=1'>Connectez-vous</a> pour être le premier à répondre !<?php else: ?>Soyez le premier à répondre !<?php endif; ?></p>";
        }
    } catch(Exception $e) {
        echo "<div class='error-message'>Erreur lors du chargement des réponses: " . $e->getMessage() . "</div>";
    }
    ?>
    
    <?php endif; ?>
</body>
</html>